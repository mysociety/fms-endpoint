<?php 

// set these values for your own installation

// ATTENTION!
// if you've got a conf/general.yml file in place, any settings in
// that will be OVERRIDING the settings you see here!
// see ../../../documentation/ALTERNATIVE_CONFIG.md for details
//==================================================================


$active_group = 'default'; 
$active_record = TRUE;

$db['default']['hostname'] = "localhost:8889";
$db['default']['username'] = "root";
$db['default']['password'] = "root";
$db['default']['database'] = "fms-endpoint";
$db['default']['dbdriver'] = "mysql";

$db['default']['dbprefix'] = "";

$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
$db['default']['swap_pre'] = "";
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//$db['default']['port'] = 8889;

?>