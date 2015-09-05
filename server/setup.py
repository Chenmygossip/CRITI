import os

from setuptools import setup, find_packages

here = os.path.abspath(os.path.dirname(__file__))
README = open(os.path.join(here, 'README.rst')).read()

requires = [
    'pyramid>=1.5.2',
    'pyramid_jinja2',
    'pyramid_debugtoolbar',
]

setup(name='criti',
      version='0.0',
      description='criti',
      long_description=README,
      classifiers=[
          "Programming Language :: Python",
          "Framework :: Pylons",
          "Topic :: Internet :: WWW/HTTP",
          "Topic :: Internet :: WWW/HTTP :: WSGI :: Application",
      ],
      author='',
      author_email='',
      url='',
      keywords='web pyramid pylons',
      packages=find_packages(),
      include_package_data=True,
      zip_safe=False,
      install_requires=requires,
      tests_require=requires,
      test_suite="criti",
      entry_points="""\
      [paste.app_factory]
      main = criti:main
      """,
      paster_plugins=['pyramid'],
      )
