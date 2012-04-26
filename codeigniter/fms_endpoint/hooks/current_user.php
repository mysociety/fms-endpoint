<?php 

function add_current_user_to_view_vars() {
	$CI =& get_instance(); 
	$data = array(
     'auth'  => $CI->ion_auth,
     'current_user_data'  => $CI->ion_auth->user()->row() // what if there is none?
	);
	$CI->load->vars($data);	
}

?>