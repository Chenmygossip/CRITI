import re

WHITE = re.compile(r'\s+')


def _update_if_not_none(tag, data, key):
    if tag is not None:
        data[key] = WHITE.sub(' ', tag.string).strip()


def parse_context(soup, data):

    for context in soup(type="context", recursive=False):
        data.setdefault('contexts', []).append({"content": WHITE.sub(' ', context.string).strip()})

    for context_group in soup('descripGrp', recursive=False):
        data.setdefault('contexts', []).append({
            "content": WHITE.sub(' ', context_group.descrip.string).strip(),
            "source": WHITE.sub(' ', context_group.admin.string).strip(),
        })


def parse_definition(soup, data):

    for definition in soup(type="definition", recursive=False):
        data.setdefault('definitions', []).append({"content": WHITE.sub(' ', definition.string).strip()})

    for def_group in soup('descripGrp', recursive=False):
        data.setdefault('definitions', []).append({
            "content": WHITE.sub(' ', def_group.descrip.string).strip(),
            "source": WHITE.sub(' ', def_group.admin.string).strip(),
        })


def parse_transaction(soup, data):

    for transaction in soup('transacGrp', recursive=False):
        trans = {"type": WHITE.sub(' ', transaction.transac.string).strip()}
        if transaction.find('transacNote'):
            trans["person"] = WHITE.sub(' ', transaction.transacNote.string).strip()
            trans["target"] = transaction.transacNote['target']

        if transaction.find('date'):
            trans["date"] = WHITE.sub(' ', transaction.date.string).strip()

        data.setdefault('transactions', []).append(trans)


def parse_reference(soup, data):

    for ref in soup(type='crossReference', recursive=False):
        data.setdefault('references', []).append({
            "content": WHITE.sub(' ', ref.string).strip(),
            "target": ref['target'],
        })

    for xref in soup(type='externalCrossReference', recursive=False):
        data.setdefault('external_references', []).append({
            "content": WHITE.sub(' ', xref.string).strip(),
            "target": xref['target'],
        })


def parse_concept_level(term_entry):
    entry = {"id": term_entry['id']}

    _update_if_not_none(term_entry.find(type="subjectField"), entry, 'subject_field')

    for image in term_entry(type="xGraphic", recursive=False):
        entry.setdefault('images', []).append({
            "content": WHITE.sub(' ', image.string).strip(),
            "target": image['target'],
        })

    for note in term_entry('note', recursive=False):
        entry.setdefault('notes', []).append(WHITE.sub(' ', note.string).strip())

    parse_reference(term_entry, entry)
    parse_definition(term_entry, entry)
    parse_transaction(term_entry, entry)

    return entry


def parse_term_level(tig):
    term = {
        "term": WHITE.sub(' ', tig.find('term').string).strip(),
    }
    _update_if_not_none(tig.find(type='source'), term, 'source')
    _update_if_not_none(tig.find(type='termType'), term, 'type')
    _update_if_not_none(tig.find(type='partOfSpeech'), term, 'pos')
    _update_if_not_none(tig.find(type='grammaticalGender'), term, 'gender')
    _update_if_not_none(tig.find(type='administrativeStatus'), term, 'status')
    _update_if_not_none(tig.find(type='geographicalUsage'), term, 'geo')
    _update_if_not_none(tig.find(type='termLocation'), term, 'location')

    for customer in tig(type='customerSubset'):
        term.setdefault('customers', []).append(WHITE.sub(' ', customer.string).strip())

    for project in tig(type='projectSubset'):
        term.setdefault('projects', []).append(WHITE.sub(' ', project.string).strip())

    parse_context(tig, term)
    parse_reference(tig, term)
    parse_transaction(tig, term)

    return term


def parse(tbx):
    """ tbx is the route of a BeautifulSoup tree. """

    data = {
        "people": [],
        "entries": [],
    }

    data['working_language'] = tbx.attrs.get('xml:lang', 'en-US')

    for term_entry in tbx('termEntry'):
        entry = parse_concept_level(term_entry)

        for lang_set in term_entry('langSet'):
            language = {"code": lang_set['xml:lang']}
            parse_definition(lang_set, language)
            parse_transaction(lang_set, language)

            for tig in lang_set('tig'):
                term = parse_term_level(tig)
                language.setdefault('terms', []).append(term)

            entry.setdefault('languages', []).append(language)
        data['entries'].append(entry)

    for ref in tbx('refObject'):
        party = {}
        party['id'] = ref['id']
        for item in ref('item'):
            party[item['type']] = WHITE.sub(' ', item.string).strip()

        data['people'].append(party)

    return data
