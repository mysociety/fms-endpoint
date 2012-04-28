<?php 

// set these values for your own installation

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

// mySociety-specific deploy mechanism:
// If our conf/general.yaml file exists, use its settings.

$conf_general_filename = BASEPATH . "../conf/general.yml";
if (file_exists($conf_general_filename)) {  
    require_once APPPATH . "libraries/spyc.php";
    $readme = Spyc::YAMLLoad($conf_general_filename);
    foreach ($readme as $key => $value) {      
        $k = strtolower(str_replace("FMSE_", "", trim($key)));
        switch ($k) {
            case 'db_host':
                $k = 'hostname';
                break;
            case 'db_name':
                $k = 'database';
                break;
            case 'db_user':
                $k = 'username';
                break;
            case 'db_pass':
                $k = 'password';
                break;
            default:
                $k = '';
        }
        if ($k) {
          $db['default'][$k] = trim($value);
        }
    }
} 
?>