<?php

class Category_attributes extends Controller {

	function Category_attributes() {
		parent::Controller();
		$this->load->database();
		$this->load->library('Ion_auth');
		$this->load->helper('xml');
		$this->load->helper('fms_endpoint');
	    open311_enabled_or_error();	
	}

	function index() {
		$data['categories'] = $this->db->get('category_attributes');
		$this->load->view('category_attributes_xml', $data);
	}
}

?>
