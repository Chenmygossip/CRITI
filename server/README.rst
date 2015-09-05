Introduction
============

This is a Python RESTful API server that can convert TBX-Basic into JSON and store that information in a Postgresql
database. Likewise, this server can export stored data into TBX-Basic.

The server only accepts whole entries. In order to help clients create a valid JSON representation of their terminology
data, this server uses JSONSchema (and in the future, partial updates may be possible via JSONPatch). If you attempt to
create or store an invalid JSON representation, the server should respond with helpful validation clues.

Please use the JSON schemas in `schemas`, in particular the `schemas/entry.json` schema when constructing a client
because using JSON schema will help provide cross-language validation and consistency. See use the schema with the
[json editor](http://jeremydorn.com/json-editor/) for an example of this power.

Installation
------------

These instructions assume that you are workin in a Linux environment. Other environments may be supported later.

Make sure you have a recent version of Python (>=2.7.*). And setup a [virtualenv](https://virtualenv.pypa.io/en/latest/).
[virtualenvwrapper](https://virtualenvwrapper.readthedocs.org/en/latest/) is very nice for this. This project uses some
Python C extensions, so you may need to install some C libraries (e.g. apt-get libxml2-dev libxslt-dev python-dev).

You will also need to configure a Postgresql >=9.4 database server. The default parameters (see development.ini:sqlalchemy.url)
expect a database named `criti` on the localhost, but changing the sqlalchemy.url will allow you to point to another instance.
To initialize the database schema, source `migrations/initial.sql` (e.g. `\i migrations/initial.sql` in the `psql` console.)

Once you have your `virtualenv` and have installed the C libraries necessary for [lxml](http://lxml.de/installation.html),
you need to install the remaining dependencies with `pip install -r requirements.txt` and finally `python setup.py install`. You can
then use `uwsgi --ini-paste development.ini --py-autoreload 1` to run the server on port `:6543`. Try uploading one of the TBX
files located in `resources` by going to `/import` to give you some initial data to play with.

As always, have fun!

Routes
------

    import                       /import                                      GET,POST
    export                       /termbases/{base_id}/export                  GET
    termbase_collection          /termbases                                   GET,POST
    termbase                     /termbases/{base_id}                         DELETE,GET,PUT
    entry_collection             /termbases/{base_id}/entries                 GET,POST
    entry                        /termbases/{base_id}/entries/{entry_id}      DELETE,GET,PUT
    person_collection            /termbases/{base_id}/people                  GET,POST
    person                       /termbases/{base_id}/people/{person_id}      DELETE,GET,PUT



