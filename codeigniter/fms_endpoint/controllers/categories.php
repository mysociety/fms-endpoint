<?php

class Categories extends Controller {

	function Categories() {
		parent::Controller();
		$this->load->database();
		$this->load->library('Ion_auth');
		$this->load->helper('xml');
		$this->load->helper('fms_endpoint');
		open311_enabled_or_error();
	}

	function index() {
		$data['categories'] = $this->db->get('categories');
		$this->load->view('categories_xml', $data);
	}


	function get_feed($format) {
		// check here for jurisdiction_id?
		$url = parse_url($_SERVER['REQUEST_URI']);
		if (array_key_exists('query', $url)) { 
			parse_str($url['query'], $params);
			if (array_key_exists('jurisdiction_id', $params)) {
				log_message('debug', 'note: jurisdiction_id=' . $params['jurisdiction_id'] . " is currently ignored");
			} else {
				log_message('debug', "note: no jurisdiction_id was provided");
			}
		}
		$data['categories'] = $this->db->get('categories');

 		switch ($format) {
			case "xml":
				$this->load->view('categories_xml', $data);
				break;
			case "json":
				$this->load->view('categories_json', $data);
				break;
		}
	}

	function get_xml_category($category_id) {
		$this->db->where('category_id', $category_id);
		$this->db->order_by("order", "asc");
		$data['attributes'] = $this->db->get('category_attributes');
		$data['category_id'] = $category_id;
		$this->load->view('category_attributes_xml', $data);
	}
}

?>
