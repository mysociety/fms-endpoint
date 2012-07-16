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

// note: one of these settings isn't a datbase setting. Bad style.
//       FMSE_BASE_URL (currently not used)

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
            case 'base_url': // note this isn't a database setting
                $base_url = trim($value);
                $len = strlen($base_url);
                if ($len > 0) {
                    if (strrpos($base_url, '/') != $len-1) {
                        $base_url = $base_url . '/';
                    }
                    $config['base_url'] = $base_url;
                    log_message('debug',"config['base_url'] is " . $base_url);
                    // sadly, not carried through to config... kept in in case it's useful
                }
            default:
                $k = '';
        }
        if ($k) {
          $db['default'][$k] = trim($value);
        }
    }
} 
?>