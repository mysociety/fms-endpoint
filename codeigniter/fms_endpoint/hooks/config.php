<?php 

/*
This hook function is responsible for reading all of the settings from
the database into the config array so they can be accessed in controllers
and views with $this->config->item('whatever'); or config_item('whatever');
*/

function load_db_config_settings() {
	$CI =& get_instance(); 
	$results = $CI->db->get('config_settings')->result();
	foreach ($results as $setting) {
		$CI->config->set_item($setting->name, $setting->value);
	}
}

?>