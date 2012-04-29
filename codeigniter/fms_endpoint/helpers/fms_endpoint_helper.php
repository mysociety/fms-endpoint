<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * fms_endpoint_helper
 */

// ------------------------------------------------------------------------

/**
 * is_config_true
 *
 * returns true if the config value (from the database's config_settings) is true
 *
 * @access	public
 * @param	string $raw_value the config setting's value (typically read from the database)
 * @return	boolean TRUE if the value represents a true/confirmed setting
 */	
if ( ! function_exists('is_config_true')) {
	function is_config_true($raw_value) {
		$config_value = strtolower(trim($raw_value));
		return ($config_value != '' && $config_value != '0' && $config_value != 'f' && $config_value != 'false' && $config_value != 'no');
	}
}

/**
 * open311_enabled_or_error
 *
 * returns true if the Open311 server is enabled (checks the config setting directly)
 * 
 * @access	public
 * @return	none, but throws error
 */	
if ( ! function_exists('open311_enabled_or_error')) {
	function open311_enabled_or_error() {
		$CI =& get_instance();
		$config_result = $CI->db->get_where('config_settings', array('name' => 'enable_open311_server'), 1);
		if (! is_config_true($config_result->row()->value)) {
			show_error('This Open311 server is currently disabled', 404 );
    	}
	}
}

?>