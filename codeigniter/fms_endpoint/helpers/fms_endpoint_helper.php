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

/**
 * show_error_xml
 *
 * mimics show_error but with http status and simple error delivered in XML
 * This should be friendlier to FixMyStreet
 * Note: terminates execution
 * 
 * @access	public
 * @return	none, but terminates execution
 */	
if ( ! function_exists('show_error_xml')) {
	function show_error_xml($msg, $code) {
		$CI =& get_instance();
		$error['code'] = $code;
		$error['description'] = $msg;
		//$CI->output->set_content_type('xml');
		$CI->output->set_status_header($code);
		$CI->load->view('error_xml', $error);
		$CI->output->_display(); // explicit flush so we can exit
		exit();
	}
}


?>