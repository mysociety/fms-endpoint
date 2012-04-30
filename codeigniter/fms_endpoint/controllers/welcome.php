<?php

class Welcome extends Controller {

  /* 
   *  The Welcome class runs an inert home page (at the root of the application) to help
   *  diagnose basic configuration problems (which is also why it doesn't use the header and
   *  footer views).
   *  Once your installation is up and running, you may prefer to replace it with something
   *  more useful to your own situation.
   */
    
  function Welcome() {
    parent::Controller();
  }

	function index() {
    $problems  = array();
    $details = array();
    $title = 'FMS-endpoint';
    $is_open311_enabled =  false;
    $this->load->helper('fms_endpoint');

    $this->load->database();
    $err_no = $this->db->_error_number();
    if ($err_no != 0) {
      $msg =<<<END_OF_HTML
      Check that: 
        <ol>
          <li> you've created the database</li>
          <li> your database server is running</li>
          <li> you've updated <span class='code'>codeigniter/fms_endpoint/config/database.php</span> with the correct values</li>
        </ol>
END_OF_HTML;
      array_push($problems, "Can't connect to database: make sure your database configuration is correct");
      array_push($details, $msg);      
    } else {
      $config_query = $this->db->get('config_settings');
      $err_no = $this->db->_error_number();
      log_message('debug', 'problem::: $this->db->get("config_settings") yields error number: ' . $err_no);
      
      if ( $err_no != 0 || $config_query->num_rows() == 0) { // table should not be empty        
        array_push($problems, "Database is not populated yet.");
        array_push($details, "Run the SQL in <span class='code'>db/fms-endpoint-initial.sql</span> to create and populate the tables.");
        if ($err_no == 0) {
          $query = $this->db->get('reports');
          if ($query->num_rows() > 1) { // ...but there is data (beyond the expected example) in the reports table, which is unexpected
            array_push($problems, "<b>Note</b> It looks like you've got data (possibly live reports) in your database, which seems odd when other tables are empty.");
            array_push($details, "Running the <span class='code'>db/fms-endpoint-initial.sql</span> won't delete any reports data.");
          }
        }
      } else { // database seems OK
        foreach ($config_query->result() as $setting) {
          $this->config->set_item($setting->name, trim($setting->value));
        }
        
        $query = $this->db->get_where('users',  array('email' => 'admin@example.com'));
        if ($query->num_rows() == 1) {
          array_push($problems, 'You need to configure your administrator user.');
          $msg =<<<END_OF_HTML
          Change the administrator user's details.
          <ol>
            <li>Connect directly to your database and edit the <span class='code'>USERS</span> table</li>
            <li>Update the data (e.g., name, email address). Don't edit the password field, because it needs to be encrypted.</li>
            <li>Then <a href='auth/login'>login with that email</a>.</li>
            <li>Go to <a href="auth/change_password">the change password page</a>.</li>
            <li>Enter the default password (it's in the README), and then your new one. Submit the form to change the password.</li>
          </ol>
END_OF_HTML;
          array_push($details, $msg);
        }
        $name = $this->config->item('organisation_name');
        if ($name=='Example Department' || $name=='') {
          array_push($problems, 'The configuration setting <b>organisation_name</b> needs to be set.');
          array_push($details, "Login as the administrator, and change the <b>organisation_name</b> setting in <a href='admin/settings/edit/organisation_name'>config settings</a>.");
        } else {
          $title = $name; 
        }
        $is_open311_enabled =  is_config_true($this->config->item('enable_open311_server'));
      } 
    }
    if ($this->config->item('redirect_root_page')) {
      $this->load->helper('url');
      redirect($this->config->item('redirect_root_page'));
    } else {
      $data = array(
                'problems' => $problems,
                'details'  => $details,
                'title'    => $title,
                'is_open311_enabled' => $is_open311_enabled
                );    
      $this->load->view('welcome_message', $data);
    }
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */