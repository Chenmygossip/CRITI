#  from logging import config as logging_config

import logbook
import sqlalchemy as sa
from pyramid.config import Configurator
from pyramid.renderers import JSON

from .logging import setup


def setup_logging(app):
    """
    Setup logbook logging for specify since it is more flexible and easier
    to understand than the builtin logging module.
    """

    logbook.compat.redirect_logging()

    def logged_application(environ, start_response):
        with setup.applicationbound():
            return app(environ, start_response)

    return logged_application


def setup_routing(config):
    config.add_route(name='import', pattern='/import')
    config.add_route(name='export', pattern='/termbases/{base_id}/export')

    config.add_route(name='termbase_collection', pattern='/termbases')
    config.add_route(name='termbase', pattern='/termbases/{base_id}')

    config.add_route(name='entry_collection', pattern='/termbases/{base_id}/entries')
    config.add_route(name='entry', pattern='/termbases/{base_id}/entries/{entry_id}')

    config.add_route(name='person_collection', pattern='/termbases/{base_id}/people')
    config.add_route(name='person', pattern='/termbases/{base_id}/people/{person_id}')
    config.scan()


def main(global_config, **settings):

    # This loads the configuration for asyncio, gunicorn
    # and other builtin loggers.
    #  logging_config.fileConfig(
        #  settings['logging.config'],
        #  disable_existing_loggers=False
    #  )

    config = Configurator(settings=settings)

    # Database
    engine = sa.create_engine(settings['sqlalchemy.url'])

    def add_db(request):
        connection = engine.connect()
        transaction = connection.begin()

        @request.add_finished_callback
        def commit(request):
            if request.exception is not None:
                transaction.rollback()
            else:
                transaction.commit()

        return connection

    config.add_request_method(add_db, 'db', reify=True)

    # Request Log
    def add_log(request):
        log = logbook.Logger('criti.request')
        return log

    config.add_request_method(add_log, 'log', reify=True)

    # Default output is JSON
    config.add_renderer(None, JSON())

    # Routes
    setup_routing(config)

    app = config.make_wsgi_app()
    return setup_logging(app)
