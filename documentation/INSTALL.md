FMS-endpoint installation instructions
======================================

Overview
--------

You'll need a webserver that's happy to run PHP, and a database. For example,
Apache and mySQL works fine, but if your system is different you should be OK
to change it -- see the configuration details further down in this file.

Install the files
-----------------

FMS-endpoint is a PHP CodeIgniter project.

Place the contents of this git repository somewhere where your webserver will
have access to it. Ideally, only the contents of the web/ directory (that is,
index.php and assets/) should be placed under your webserver's server root:

* if you intend to run FMS-endpoint as the *only* service for that webserver,
  you can deploy directly into the server root

* alternatively, you can put it in a subdirectory so it won't collide with
  other things you might already be running on the webserver

The web/ directory also contains an fcgi/ directory -- if you're not using
FastCGI on your webserver you can ignore this, otherwise copy that to be
alongside assets/ too).


Edit the CodeIgniter $system_folder setting
-------------------------------------------

You can skip this step if your web/ directory is in the same directory as the
codeigniter/ directory (that is, if the relative path to codeigniter/ from
index.php hasn't changed).

Otherwise, edit web/index.php and change the $system_folder setting:

   * $system_folder = "../codeigniter";

This must point to the codeigniter directory in this repository. For example,
in the default setup, this is ../codeigniter because the codeigniter/
directory is a sibling of web/. If you have moved them apart (which is OK, of
course), make sure this setting has the correct path _from this index.php_ You
can use an absolute or relative path here.


Edit the fms-endpoint base_url setting
--------------------------------------

You can skip this step if you have placed index.php in the server-root of your
webserver, not in a subdirectory (that is, if http://YOUR_DOMAIN/ should hit
the index.php already).

Otherwise, make sure that fms-endpoint's core CodeIgniter config knows the URL
to the root page:

Edit codeigniter/fms-endpoint/config/config.php and set

   * $config['base_url']= 'http://example.com/your-path/';


Check the root page
-------------------

You should already be able to see the FMS-endpoint root page in your browser
(reporting that you haven't set up the database yet). If you don't see such a
page, double-check the setting for $system_folder -- if you're not sure, use
an absolute path.

Depending on where you have installed index.php, the URL will be:

   * http:YOUR_DOMAIN/ if you've set web/ to be your server root, or put
     index.php and assets/ directly in the server root 

   * http:YOUR_DOMAIN/path_to_web_dir/ otherwise


Set up the database
-------------------

Create a database using your favourite database software -- CodeIgniter
supports mySQL, MySQLi, Postgre SQL, ODBC, and MS SQL.

Populate that database with the initial values in db/fms-endpoint-initial.sql

This SQL is in mySQL dialect. You may need to translate it slightly if you're
running with different flavour of SQL.


Edit the database configuration
-------------------------------

Edit codeigniter/fms_endpoint/config/database.php and set the values necessary
to access your database.

You probably only need to set values for the following:

   * $db['default']['hostname'] = "localhost:8889";
   * $db['default']['username'] = "root";
   * $db['default']['password'] = "root";
   * $db['default']['database'] = "fms-endpoint";
   * $db['default']['dbdriver'] = "mysql";

The values shown here are for a mySQL database running on port 8889 on the
same machine as the webserver. Change this values to match your own situation.


Check the root page again
-------------------------

The root page will indicate if FMS-endpoint is connecting to the database
properly.

If you don't see the root page reporting that you need to change some
configuration settings, double-check the database settings above.

   * if you're getting a completely blank (empty) page, check that you didn't
     break the PHP when you edited the configuration files (try php -l
     filename to check the syntax, for example)

   * look in codeigniter/logs to see if there is a report in the most recently
     updated log file


Configure URL rewriting
-----------------------

CodeIgniter works most cleanly if you rewrite the URLs. The recommended
rewrite URLs for the Apache webserver can be found in /conf/httpd.conf

If you're running FMS-endpoint under Apache, copy the contents of
/conf/httpd.conf into your main httpd.conf file.


Final Things
------------

When everything is running, you can click on the __Main site__ link on the
FMS-endpoint root page that's now running in your webserver.

You'll see from the homepage that there are a couple of things that you *must*
change away from the defaults before your configuration is truly finished.

### Change the administrator username

Go directly into your database and change the email address to a working email
address, for example with: 

UPDATE `users` SET email='your_email@your_domain.com' WHERE
email='admin@example.com';


### Change the administrator password

Log into FMS-endpoint by clicking on __Main site__. You can't access the
FMS-endpoint (except the root page) unless you're logged in, so you'll be
redirected to the login page. Login as admin:

   * username: admin@example.com (unless you've just changed it as above!)
   * password: password

You'll be logged in to the root page: click on __Main site__ again, and this
time you'll see an example record in the reports.

Change the administrator's password by clicking on the admin email on the
top-right of the screen.

   * you *must* change the password to a secret one because the default is
     public knowledge!

### Change the organisation name

Now you're logged in as an administrator, you can change any of the
configuration settings that are stored inside the database. Click on
__Settings__ or go to /index.php/admin/settings

To edit a setting, find it in the list and click on "Edit".

   * _organisation_name_ -- change this to the name of your department. You
     have to navigate to another page, or refresh, to see the heading change
     after you've made the change.

### Optionally redirect the root page when everything is working

As you've seen, the root page shows diagnostics (which, at this stage, should
all be positive). If you prefer not to display this, you can change the
behaviour by clicking on Settings and changing the config setting to whichever
URL you prefer.

   * redirect_root_page

### Add some non-admin users

If you want to add users, click on __Users__ then click on __Create new user__.
Users created this way will *not* have admin access.


### Configure Open311

Note that you can control whether or not your server accepts requests through
the Open311 API by clicking on __Settings__ and toggling the config setting:

  * enable_open311_server

There are other settings that affect the behaviour of the Open311 server --
see the entries in __Settings__ for details.

### Delete example data

Your FMS-endpoint contains some example records. When you're ready to go live,
you can delete these either from within your database directly, or by
navigating to the pages in FMS-endpoint and clicking on the delete icon to the
right of each item's listing.


Working with FixMyStreet
------------------------

In order to work with clients running FixMyStreet variants, log in as the admin user
and click on __Settings__, and use these values:

   * open311_use_api_keys set to 
       yes
   * open311_use_external_id set to 
       always
   * open311_use_external_name set to 
     external_id

This forces your FMS-endpoint to only accept FMS reports which provide the ID
or ref from the client system that is reporting them. FixMyStreet clients can
be configured to behave in this way.


