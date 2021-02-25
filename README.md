# mitopaths
Pathways for human mitochondria

This repository contains the source files of the MitopatHs web service, located at: https://web.math.unipd.it/mitopaths/. In order to run a local copy of the web service, copy content of this repository into your web server virtualhost, the make a copy of config-dummy.ini:
  cp config-dummy.ini config.ini
and edit `config.ini` as needed by following section and property names.

You will need running instances of a web server, an SQL server and Apache Solr. SQL database schemas can be found in `website/scripts` and must be created before installing the web service.
