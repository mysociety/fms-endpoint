<?php

class Categories extends Controller {

	function Categories()
	{
		parent::Controller();
		$this->load->helper('xml');
		
		// Be sure to comment out or disable this for production
		$this->load->scaffolding('categories');
        
			
	}
	
	function index()
	{
		$data['categories'] = $this->db->get('categories');
		
		$this->load->view('categories_xml', $data);
	}
	

	function get_feed($format)
	{
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


	
	function get_xml_category($category_id)
	{
	
		$this->db->where('category_id', $category_id);
		$this->db->order_by("order", "asc"); 						
		$data['attributes'] = $this->db->get('category_attributes');
		$data['category_id'] = $category_id;
	
		$this->load->view('category_attributes_xml', $data);
	}	
	


	
}


?>
