Using general.yml to store your database config
================================================

The instructions in `documentation/INSTALL.md` tell you to edit the database
configuration values (which will, of course, be specific to your own
installation) in `codeigniter/fms_endpoint/config/database.php` (and other
files in that directory). This is the easiest way to get up and running,
since this is the normal place for CodeIgniter configuration.

However, those files are within the git repository, which means they *may*
get changed in future versions of FMS-endpoint. If you prefer to keep your
config separate form the code, like we do, then we provide an alternative
mechanism for specifying configuration values:

---

Put your configuration settings in `conf/general.yml`. 

FMS-endpoint will
read those and use them to override anything that is set in 
`codeigniter/fms_endpoint/config/database.php`

---

For an example of what this file should look like, see
`conf/general-example.yml`

Note that this currently only works for your *database* configuration
settings, but as it's the mechanism we at mySociety use for our own
deployments, we might expand it to other config values as needed.


