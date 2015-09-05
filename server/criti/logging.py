
import logbook
from logbook.more import ColorizedStderrHandler
from logbook.compat import LoggingHandler
from logbook.base import ERROR, NOTICE, DEBUG

from pyramid_debugtoolbar.panels.logger import handler as pdtb_log_handler


class ColoredLogHandler(ColorizedStderrHandler):

    def emit(self, record):
        super().emit(record)
        converter = LoggingHandler()
        pdtb_log_handler.emit(converter.convert_record(record))

    def get_color(self, record):
        """Returns the color for this record."""
        if record.level >= ERROR:
            return 'red'
        elif record.level >= NOTICE:
            return 'yellow'
        elif record.level == DEBUG:
            return 'lightgray'
        else:
            return 'blue'

setup = logbook.NestedSetup([
    ColoredLogHandler(),
])
