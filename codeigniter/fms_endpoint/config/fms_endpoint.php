<?php 

// set these values for your own installation

$config['fmse_cobrand_name'] = '';

// load from conf/general.yml if it exists -- this arose from the
// mySociety deployment mechanism, but it's useful for anyone using
// FMSE-endpoint who doesn't want to put their config settings into
// the core code or the git repo.

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
                $k = '';
                break;
            case 'cobrand_name': // note this isn't a database setting either
                $config['fmse_cobrand_name'] = trim($value);
                log_message('debug',"\$config['fmse_cobrand_name'] is " . $config['fmse_cobrand_name']);
                $k = '';
                break;
            default:
                if (strrpos($k, 'db_') == 0) {
                    $k = strtolower(str_replace("db_", "", $k));
                } else {
	                $k = '';	
                }
        }
        if ($k) {
          $db['default'][$k] = trim($value);
          log_message('debug', "\$db['default'][$k] is " .  $db['default'][$k]);
        }
    }
}
?>