from __future__ import absolute_import, print_function

import os
import json
import uuid

import sqlalchemy as sa

try:
    from lxml import etree
except ImportError:
    import xml.etree.cElementTree as etree

from bs4 import BeautifulSoup as BS
from jsonschema import Draft4Validator
from pyramid.view import view_config
from pyramid.httpexceptions import HTTPBadRequest, HTTPNotFound
from .util.convert import parse


TERMBASE_CREATE = sa.text("INSERT INTO base (name, working_language) VALUES (:name, :working_language) RETURNING key, id")
TERMBASE_UPDATE = sa.text("UPDATE base SET name = :name, working_language = :working_language WHERE id = :id AND is_active")
TERMBASE_DELETE_BY_ID = sa.text("UPDATE base SET is_active = FALSE WHERE id = :id")
TERMBASE_RETRIEVE_BY_ID = sa.text("SELECT id::VARCHAR, name, working_language FROM base WHERE id = :id AND is_active")
TERMBASE_RETRIEVE_KEY_BY_ID = sa.text("SELECT key FROM base WHERE id = :id AND is_active")
TERMBASE_RETRIEVE = sa.text("SELECT id::VARCHAR, name, working_language FROM base WHERE is_active")

ENTRY_CREATE = sa.text("INSERT INTO entry (key, id, data) VALUES (:base, :id, :data) RETURNING id")
ENTRY_UPDATE = sa.text("UPDATE entry SET id = :id, data = :data WHERE id = :old AND is_active")
ENTRY_DELETE_BY_ID = sa.text("UPDATE entry SET is_active = FALSE WHERE id = :id")
ENTRY_RETRIEVE_BY_TERMBASE = sa.text("SELECT e.id, e.data FROM entry e JOIN base b ON b.key = e.key WHERE b.id = :id AND b.is_active AND e.is_active")
ENTRY_RETRIEVE_BY_ID = sa.text("SELECT e.data FROM entry e JOIN base b ON b.key = e.key WHERE e.id = :id AND b.is_active AND e.is_active")

# This is an example complex query that has been tested
ENTRY_RETRIEVE_BY_SUBJECT_FIELD = sa.text("""
    SELECT
        e.id,
        e.data
    FROM entry e
    JOIN base b
    ON b.key = e.key
    WHERE (data #>> '{subject_field}') = :subject_field
    AND b.id = :id
    AND b.is_active
    AND e.is_active
""")

# These next three queries should also work, but they have not been tested in Python
ENTRY_RETRIEVE_BY_SUBJECT_FIELD_MATCH = sa.text("""
    SELECT
        e.id,
        e.data
    FROM entry e
    JOIN base b
    ON b.key = e.key
    WHERE (data #>> '{subject_field}') ILIKE :subject_field
    AND b.id = :id
    AND b.is_active
    AND e.is_active
""")

TERMS_RETRIEVE_BY_LANGUAGE = sa.text("""
    SELECT
        e.id,
        langs->>'code' as language,
        jsonb_array_elements(langs->'terms') as terms
    FROM entry e, jsonb_array_elements(e.data->'languages') as langs
    JOIN base b
    ON b.key = e.key
    WHERE (langs #>> '{code}') = :code
    AND b.id = :id
    AND b.is_active
    AND e.is_active
""")

SUBJECT_FIELD_RETRIEVE = sa.text("""
    SELECT e.id, e.data->>'subject_field'
    FROM entry e
    JOIN base b ON b.key = e.key
    WHERE (data->'subject_field') IS NOT NULL
    AND b.id = :id
    AND b.is_active
    AND e.is_active
""")

PERSON_CREATE = sa.text("INSERT INTO person (key, id, data) VALUES (:base, :id, :data) RETURNING id")
PERSON_UPDATE = sa.text("UPDATE person SET id = :id, data = :data WHERE id = :old AND is_active")
PERSON_DELETE_BY_ID = sa.text("UPDATE person SET is_active = FALSE WHERE id = :id")
PERSON_RETRIEVE_BY_TERMBASE = sa.text("SELECT p.id, p.data FROM person p JOIN base b ON b.key = p.key WHERE b.id = :id AND b.is_active AND p.is_active")
PERSON_RETRIEVE_BY_ID = sa.text("SELECT p.data FROM person p JOIN base b ON b.key = p.key WHERE p.id = :id AND b.is_active AND p.is_active")

# TODO see if we need to use an absolute path here
TBX_SCHEMA = etree.RelaxNG(etree.parse(os.path.join('schemas', 'TBXBasicRNGV02.rng')))

TERMBASE_SCHEMA = json.load(open(os.path.join('schemas', 'termbase.json')))
ENTRY_SCHEMA = json.load(open(os.path.join('schemas', 'entry.json')))
PERSON_SCHEMA = json.load(open(os.path.join('schemas', 'person.json')))


class View(object):

    def __init__(self, context, request):
        self.context = context
        self.request = request
        self.match = request.matchdict
        self.db = request.db
        try:
            self.data = request.json
        except ValueError:
            pass

    def validate(self, schema):
        validator = Draft4Validator(schema)
        errors = list(validator.iter_errors(self.request.json))
        if errors:
            raise HTTPBadRequest([err.message for err in errors])


class ExternalView(View):

    @view_config(route_name='import', request_method='GET', renderer='tbx-upload.jinja2')
    def import_tbx_form(self):
        return {}

    @view_config(route_name='import', request_method='POST')
    def import_tbx(self):
        tbx_file = self.request.POST.get('file')
        if tbx_file is None:
            raise HTTPBadRequest("No TBX file uploaded.")
        name = self.request.POST.get('name')
        if name is None:
            raise HTTPBadRequest("No termbase name provided.")

        self.request.log.info("Validating TBX for {} in {}.".format(name, tbx_file.filename))

        # Validate against the TBX RNG Schema
        tbx = tbx_file.file.read()
        raw_xml = etree.fromstring(tbx)

        TBX_SCHEMA.assertValid(raw_xml)

        self.request.log.info("Parsing TBX into JSON for {}".format(name))
        tbx = BS(tbx, 'xml')
        parsed = parse(tbx)

        self.request.log.info("Updating database with new termbase {}".format(name))
        key, base_id = self.db.execute(TERMBASE_CREATE, name=name, working_language=parsed['working_language']).fetchone()

        for person in parsed['people']:
            self.request.log.debug("Creating person: {}".format(person))
            self.db.execute(PERSON_CREATE, base=key, id=person['id'], data=json.dumps(person))

        for entry in parsed['entries']:
            self.request.log.debug("Creating entry: {}".format(entry))
            self.db.execute(ENTRY_CREATE, base=key, id=entry['id'], data=json.dumps(entry))

        return {"created": str(base_id)}

    @view_config(route_name='export', request_method='GET', renderer='tbx-basic.jinja2')
    def export_tbx(self):
        base_id = self.match['base_id']
        base = self.db.execute(TERMBASE_RETRIEVE_BY_ID, id=base_id).fetchone()
        if base is None:
            raise HTTPNotFound("The termbase {} does not exist.".format(base_id))

        context = {
            "people": [],
            "entries": [],
        }
        context['working_language'] = base.working_language

        self.request.log.debug("Retrieving entries for {}.".format(base_id))
        for entry in self.db.execute(ENTRY_RETRIEVE_BY_TERMBASE, id=base_id).fetchall():
            assert entry.id == entry.data['id'], "Corrupted entry id. Please contact an administrator."
            context['entries'].append(entry.data)

        self.request.log.debug("Retrieving people for {}.".format(base_id))
        for person in self.db.execute(PERSON_RETRIEVE_BY_TERMBASE, id=base_id).fetchall():
            assert person.id == person.data['id'], "Corrupted person id. Please contact an administrator."
            context['people'].append(person.data)

        self.request.response.content_type = 'application/xml'
        self.request.log.info("Rendering {} to TBX-Basic.".format(base_id))
        return context


class TermbaseView(View):

    @view_config(route_name='termbase_collection', request_method='GET')
    def filter(self):
        # for now we just return them all
        return list(dict(base) for base in self.db.execute(TERMBASE_RETRIEVE))

    @view_config(route_name='termbase_collection', request_method='POST')
    def create(self):
        self.validate(TERMBASE_SCHEMA)
        key, base_id = self.db.execute(TERMBASE_CREATE, self.data).fetchone()
        return {"created": str(base_id)}

    @view_config(route_name='termbase', request_method='GET')
    def retrieve(self):
        base = self.db.execute(TERMBASE_RETRIEVE_BY_ID, id=self.match['base_id']).fetchone()
        if base is None:
            raise HTTPNotFound("The termbase {} does not exist.".format(self.match['base_id']))
        return dict(base)

    @view_config(route_name='termbase', request_method='PUT')
    def update(self):
        self.validate(TERMBASE_SCHEMA)

        self.retrieve()

        self.db.execute(
            TERMBASE_UPDATE,
            name=self.data['name'],
            working_language=self.data['working_language'],
            id=self.match['base_id'])

        return {"updated": self.match['base_id']}

    @view_config(route_name='termbase', request_method='DELETE')
    def delete(self):
        self.db.execute(TERMBASE_DELETE_BY_ID, id=self.match['base_id'])
        return {"deleted": self.match['base_id']}


class EntryView(View):

    @view_config(route_name='entry_collection', request_method='GET')
    def filter(self):
        # for now we just return them all
        return list(
            dict(entry.data)
            for entry in self.db.execute(
                ENTRY_RETRIEVE_BY_TERMBASE,
                id=self.match['base_id']))

    @view_config(route_name='entry_collection', request_method='POST')
    def create(self):
        self.validate(ENTRY_SCHEMA)
        base_key = self.db.execute(TERMBASE_RETRIEVE_KEY_BY_ID, id=self.match['base_id']).scalar()
        if base_key is None:
            raise HTTPNotFound("The termbase {} does not exist.".format(self.match['base_id']))

        entry_id = 'c' + str(uuid.uuid4())
        # override any id passed so that we get a uuid
        # prefix with c so the id meets the DTD requirements for ID
        self.data['id'] = entry_id

        self.db.execute(ENTRY_CREATE, base=base_key, id=entry_id, data=json.dumps(self.data))
        return {"created": entry_id}

    @view_config(route_name='entry', request_method='GET')
    def retrieve(self):
        entry = self.db.execute(ENTRY_RETRIEVE_BY_ID, id=self.match['entry_id']).scalar()
        if entry is None:
            raise HTTPNotFound("The entry {} does not exist.".format(self.match['entry_id']))
        return dict(entry)

    @view_config(route_name='entry', request_method='PUT')
    def update(self):
        self.validate(ENTRY_SCHEMA)

        self.retrieve()

        self.db.execute(
            ENTRY_UPDATE,
            id=self.data['id'],
            data=json.dumps(self.data),
            old=self.match['entry_id'])

        return {"updated": self.data['id']}

    @view_config(route_name='entry', request_method='DELETE')
    def delete(self):
        self.db.execute(ENTRY_DELETE_BY_ID, id=self.match['entry_id'])
        return {"deleted": self.match['entry_id']}


class PersonView(View):

    @view_config(route_name='person_collection', request_method='GET')
    def filter(self):
        # for now we just return them all
        return list(
            dict(person.data)
            for person in self.db.execute(
                PERSON_RETRIEVE_BY_TERMBASE,
                id=self.match['base_id']))

    @view_config(route_name='person_collection', request_method='POST')
    def create(self):
        self.validate(PERSON_SCHEMA)
        base_key = self.db.execute(TERMBASE_RETRIEVE_KEY_BY_ID, id=self.match['base_id']).scalar()
        if base_key is None:
            raise HTTPNotFound("The termbase {} does not exist.".format(self.match['base_id']))

        person_id = 'p' + str(uuid.uuid4())
        # override any id passed so that we get a uuid
        # prefix with p so the id meets the DTD requirements for ID
        self.data['id'] = person_id

        self.db.execute(PERSON_CREATE, base=base_key, id=person_id, data=json.dumps(self.data))
        return {"created": person_id}

    @view_config(route_name='person', request_method='GET')
    def retrieve(self):
        person = self.db.execute(PERSON_RETRIEVE_BY_ID, id=self.match['person_id']).scalar()
        if person is None:
            raise HTTPNotFound("The person {} does not exist.".format(self.match['person_id']))
        return dict(person)

    @view_config(route_name='person', request_method='PUT')
    def update(self):
        self.validate(PERSON_SCHEMA)

        self.retrieve()

        self.db.execute(
            PERSON_UPDATE,
            id=self.data['id'],
            data=json.dumps(self.data),
            old=self.match['person_id'])

        return {"updated": self.data['id']}

    @view_config(route_name='person', request_method='DELETE')
    def delete(self):
        self.db.execute(PERSON_DELETE_BY_ID, id=self.match['person_id'])
        return {"deleted": self.match['person_id']}


@view_config(context=etree.LxmlError)
def handle_invalid_xml(exc, request):
    return HTTPBadRequest("Invalid TBX-Basic document: {}".format(str(exc)))
