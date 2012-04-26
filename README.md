FixMyStreet-endpoint
====================

FixMyStreet Endpoint is a simple database for problem reports created by mySociety's
[FixMyStreet](http://code.fixmystreet.com/) platform. In fact, it's an Open311 server,
so should be happy accepting *any* reports submitted over the Open311 API.


Who Needs a FMS-endpoint?
-------------------------

* if you're running a FixMyStreet deployment already, you don't necessarily need a FixMyStreet endpoint!

FixMyStreet sends reports to the relevant authority/department/council. This is often accomplished by
sending an email, but it's usually best if the report can be injected directly into the back-end
system. These systems can be large and complex and FixMyStreet can integrate with a growing number of
them. The Open311 standard is used by some third parties to simplify this integration process.

However, if you're using FixMyStreet in an environment where the recipient of reports has no established
back-end database for collecting reports, FMS-endpoint is a quick solution if you need to get something
simple up and running. 

INSTALLATION
------------

FixMyStreet-endpoint is written in PHP using the CodeIgniter framework.


Database configuration: see values in codeigniter/fms_endpoint/config/database.php

General configuration: set the BASE_URL values in codeigniter/fms_endpoint/config/config.php

Populate the database with tables and data from
sql/fms-endpoint-initial.sql


Apache configuration: to ensure CodeIgniter routes work nicely, put the settings that are in...
conf/httpd.conf
...into your Apache configuration.

Once you've got the database running, log into the site using:

* username: admin@example.com
* password: password

You can then edit the settings by clicking the _Settings_ link. In particular, change the name of
the organisation that this is endpoint.

*Important* - Click on the admin@example.com link when you're logged in and reset the password to a secret one
that only the administrator of this site will know.  

Whilst logged in as the administrator, you can add new users by clicking on the _Users_ link.

Note there are a couple of sample problem reports included in the data. Delete them before you go live!

FIXME:TODO


Licenses
--------
FIXME:TODO

See



FixMyStreet-endpoint is a [mySociety](http://www.mysociety.org/) project.

