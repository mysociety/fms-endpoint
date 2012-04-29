<?php

class Reports extends Controller {

	function Reports()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('Ion_auth');
		$this->load->helper('xml');
		$this->load->helper('fms_endpoint');
		open311_enabled_or_error();
    
		// Be sure to comment out or disable this for production
		$this->load->scaffolding('reports');
	}
	
	function index()
	{
		$data['query'] = $this->db->get('reports');
		
		$this->load->view('reports_xml', $data);
	}
	
	
	
	

	function post_report($format)
	{
		
		
		$service_code = (!empty($_POST['service_code'])) ? $_POST['service_code'] : '';
		$description = (!empty($_POST['description'])) ? $_POST['description'] : '';
		$lat = (!empty($_POST['lat'])) ? $_POST['lat'] : '';
		$long = (!empty($_POST['long'])) ? $_POST['long'] : '';
		$requested_datetime = (!empty($_POST['requested_datetime'])) ? $_POST['requested_datetime'] : date("Y-m-d H:i:s",time());
		$address_string = (!empty($_POST['address_string'])) ? $_POST['address_string'] : '';
		$address_id = (!empty($_POST['address_id'])) ? $_POST['address_id'] : '';
		$email = (!empty($_POST['email'])) ? $_POST['email'] : '';
		$device_id = (!empty($_POST['device_id'])) ? $_POST['device_id'] : '';
		$account_id = (!empty($_POST['account_id'])) ? $_POST['account_id'] : '';
		$first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : '';
		$last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : '';
		$phone = (!empty($_POST['phone'])) ? $_POST['phone'] : '';
		$media_url = (!empty($_POST['media_url'])) ? $_POST['media_url'] : '';		


		
		
		$data = array(
					'category_id' 			=> $service_code      ,
			        'description' 			=> $description       ,
			        'lat'			 		=> $lat               ,
			        'long' 					=> $long              ,
			        'requested_datetime' 	=> $requested_datetime,
			        'address' 				=> $address_string    ,
			        'address_id' 			=> $address_id        ,
			        'email' 				=> $email             ,
			        'device_id' 			=> $device_id         ,
			        'account_id' 			=> $account_id        ,
			        'first_name' 			=> $first_name        ,
			        'last_name' 			=> $last_name         ,
			        'phone' 				=> $phone             ,
			        'media_url' 			=> $media_url         
		            );
		
		$this->db->insert('reports', $data); 
		
		$report_id = $this->db->insert_id();
		
		// process response depending on format
		if ($format == 'xml') {
			return $this->get_xml_post_response($report_id);
		}
		else {
			// just use xml as the default
			return $this->get_xml_post_response($report_id);
		}
	}



	function get_feed($format)
	{
		// if we're receiving a POST report call. 
		if(!empty($_POST['service_code'])) {
			return $this->post_report($format);
		}
		
		
		if (!empty($_GET['status'])) {
			$this->db->where('status', $_GET['status']);									
		}
		
		if (!empty($_GET['service_code'])) {
			$this->db->where('category_id', $_GET['service_code']);									
		}		
		
		if (!empty($_GET['start_date'])) {
			$start_date = date("Y-m-d H:i:s", strtotime($_GET['start_date']));
			$this->db->where('requested_datetime >=', $start_date);									
		}		
		
		if (!empty($_GET['end_date'])) {
			$end_date = date("Y-m-d H:i:s", strtotime($_GET['end_date']));			
			$this->db->where('requested_datetime <=', $end_date);									
		}		
		
		$data['query'] = $this->db->get('reports', 1000);
		
 		switch ($format) {
			case "xml":
				$this->load->view('reports_xml', $data);	
				break;
			case "json":
				$this->load->view('reports_json', $data);	
				break;				
		}
		
	}


	
	function get_xml_report($report_id)
	{
	
		$this->db->where('report_id', $report_id);						
		$data['query'] = $this->db->get('reports');

		
		$this->load->view('reports_xml', $data);
	}	
	
	
	
	function get_xml_post_response($report_id)
	{
	
		$this->db->where('report_id', $report_id);						
		$data['query'] = $this->db->get('reports');

		
		$this->load->view('reports_post_response_xml', $data);
	}	
	
}


?>
