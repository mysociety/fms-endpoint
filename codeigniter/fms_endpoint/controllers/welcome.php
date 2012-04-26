<?php

class Welcome extends Controller {

    
	function Welcome() {
		parent::Controller();
		$this->load->helper('url');	
		$this->load->library('Ion_auth');	
	}

	function index() {
		//$this->load->helper('url');
		if ($this->ion_auth->logged_in()) {
			redirect('admin/');
		} else {
			$this->load->view('welcome_message');			
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */