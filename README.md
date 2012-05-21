FixMyStreet-endpoint
====================

FMS-Endpoint is a simple open source web application for storing problem
reports created by mySociety's [FixMyStreet](http://code.fixmystreet.com/)
platform. In fact, as it's an [Open311](http://code.fixmystreet.com/) server,
it should be happy accepting *any* reports submitted over the Open311 API.


Who needs an FMS-endpoint?
--------------------------

* if you're running a FixMyStreet deployment already, you don't necessarily
  need a FixMyStreet endpoint!

FixMyStreet sends reports to the relevant authority/department/council. This
is often accomplished by sending an email, but it's usually best if the report
can be injected directly into the back-end system. These systems can be large
and complex and FixMyStreet can integrate with a growing number of them. The
Open311 standard is used by some third parties to simplify this integration
process.

However, if you're using FixMyStreet in an environment where the recipient of
reports has no established back-end database for collecting reports,
FMS-endpoint is a quick solution if you need to get something simple up and
running.


Installation
------------

FixMyStreet-endpoint is written in PHP using the CodeIgniter framework. You
should find it easy to install provided you have access to a webserver and a
database.

Although the code generally expects to be running under an Apache webserver
with a mySQL database, it's easy to change these things if your system is
different -- see the installation documentation:

__Installation instructions:__ See documentation/INSTALL.md


Quickstart
----------

If you're familiar with PHP CodePoint (or possibly just PHP!) you might be
able to get things going just by dropping the repository somewhere under your
server root.

The FMS-endpoint home page will provide diagnostics even if you've not got the
database running, so try hitting that as soon as you get going.

Remember to see documentation/INSTALL.md for details. If the home page seems
OK, try clicking on __Main site__ and logging in as the default out-of-the-box
administrator:

* username: admin@example.com
* password: password

Remember you need to change these values as soon as you're logged in. The home
page will tell you how (until you've done it).


Licensing
---------

The Open311 implementation is nearly all from Philip Ashlock's raw
implementation of Open311 GeoReport v2.

See LICENSE.txt but also check in the documentation/ for component-specific
licenses.

About mySociety
---------------

FMS-endpoint is a [mySociety](http://www.mysociety.org/) project.

This particular project has been made possible with funding from the World
Bank. 

__May-2012__ FMS-endpoint is currently a work-in-progress! 
Check https://github.com/mysociety/fms-endpoint for changes.



