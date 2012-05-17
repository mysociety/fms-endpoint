<?php

class Reports extends Controller {

	function Reports() {
		parent::Controller();
		$this->load->database();
		$this->load->library('Ion_auth');
		$this->load->helper('xml');
		$this->load->helper('fms_endpoint');
		open311_enabled_or_error();
	}

	function index() {
		$data['query'] = $this->db->get('reports');
		$this->load->view('reports_xml', $data);
	}

	function post_report($format) {
		$api_key = (!empty($_POST['api_key'])) ? $_POST['api_key'] : '';
		$source_client = null;
		if (is_config_true(config_item('open311_use_api_keys'))) {
			if ($api_key == '') {
				show_error_xml("You must provide an API key to submit reports to this server.", OPEN311_SERVICE_BAD_API_KEY);
			} else {
				$api_key_lookup = $this->db->get_where('api_keys', array('api_key' => $api_key));
				if ($api_key_lookup->num_rows()==0) {
					show_error_xml("The API key you provided (\"$api_key\") is not valid for this server.", OPEN311_SERVICE_BAD_API_KEY);
				} else {
					$source_client = $api_key_lookup->row()->client_id;
				}
			}
		}

		$service_code = (!empty($_POST['service_code'])) ? $_POST['service_code'] : '';
		
		if ($service_code != '') {
			$lookup = $this->db->get_where('categories', array('category_id' => $service_code)); 
			if ($lookup->num_rows() == 0) {
				show_error_xml("You sent a service code of \"$service_code\", which is not recognised by this server.",
				 	OPEN311_GENERAL_SERVICE_ERROR);
			}
		} else {
			show_error_xml("Open311 problem reports must have a service code, but you didn't provide one.", OPEN311_SERVICE_ID_MISSING);		    
		}

		if (config_item('open311_use_external_id')) {
			$external_id_name = "".OPEN311_ATTRIBUTE_EXTERNAL_ID;
			if (config_item('open311_attribute_external_id')) {
				$external_id_name = config_item('open311_attribute_external_id');
			}
			// external_id masquerading as an Open311 attribute, sadly not in Open311 spec yet
			$external_id = (!empty($_POST['attribute'][$external_id_name])) ? trim($_POST['attribute'][$external_id_name]) : '';
			// be generous with the attribute query variable name (accept attribute or attrib)
			if ($external_id == '') {
				$external_id = (!empty($_POST['attrib'][$external_id_name])) ? trim($_POST['attrib'][$external_id_name]) : '';
			}
			if ($external_id == '' && strtolower(config_item('open311_use_external_id')) == 'always') {
				show_error_xml("This server requires that your ID (e.g., your report number) appears in the request as attribute[" 
					. $external_id_name . "] but you didn't provide one.", OPEN311_EXTERNAL_ID_MISSING);
			}
			if ($external_id != '') {
				$lookup = $this->db->get_where('reports', array('external_id' => $external_id)); 
				if ($lookup->num_rows() > 0) {
					show_error_xml("External ID \"$external_id\" already exists here, so we're rejecting it as a duplicate submission.",
				 		OPEN311_EXTERNAL_ID_DUPLICATE);
				}
			}
		}
		
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

		$status = (!empty($_POST['status'])) ? $_POST['status'] : REPORT_DEFAULT_STATUS;
		$status_lookup = $this->db->get_where('statuses', array('status_name' => trim(strtolower($status))), 1);
		if ($status_lookup->num_rows()==1) {
			$status = $status_lookup->row()->status_id;
		} else {
			$status_notes = "Received with unrecognised status: $status";
			$status = REPORT_UNKNOWN_STATUS_ID;
		}
		
		$data = array(
			'status'				=> $status,
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
			'media_url' 			=> $media_url         ,
#			'source_client'         => $source_client
		);
		
		if (isset($source_client)) {
			$data['source_client'] = $source_client;
		}
		
		if (isset($external_id)) {
			$data['external_id'] = $external_id;
		}
		if (isset($status_notes)) {
			$data['status_notes'] = $status_notes;
		}

		$this->db->insert('reports', $data);

		$report_id = $this->db->insert_id();

		// TODO: json
		if ($format == 'xml') {
			return $this->get_xml_post_response($report_id);
		} else {
			// just use xml as the default
			return $this->get_xml_post_response($report_id);
		}
	}

	function get_feed($format) {
		if(array_key_exists('service_code', $_POST)) { // if we're receiving a POST report call.
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

	function get_xml_report($report_id) {
		$this->db->where('report_id', $report_id);
		$data['query'] = $this->db->get('reports');
		$this->load->view('reports_xml', $data);
	}

	function get_xml_post_response($report_id) {
		$this->db->where('report_id', $report_id);
		$data['query'] = $this->db->get('reports');
		$this->load->view('reports_post_response_xml', $data);
	}
}

?>
