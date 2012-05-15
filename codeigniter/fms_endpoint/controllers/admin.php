<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Controller { // not CI_Controller (XXX: old-CI)

	function __construct() {

		parent::__construct();

		/* Standard Libraries */
		$this->load->database();
		$this->load->helper('url');

		$this->load->helper('fms_endpoint');
		$this->load->library('Ion_auth');
		$this->load->library('grocery_CRUD');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	function index() {
		try{
			$crud = $this->_set_common_report_crud(array('report_id','status', 'requested_datetime','priority','category_id','external_id','media_url','description','address'));
			$output = $crud->render();
			$this->_admin_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function reports() {
		// explicitly list all fields (was missing out report-id)
		$crud = $this->_set_common_report_crud(array());
		$output = $crud->render();
		$this->_admin_output($output);
	}

	function report($id) {
		$this->db->select('*');
		$this->db->from('reports');
		$this->db->join('priorities', 'reports.priority = priorities.prio_value');
		$this->db->join('categories', 'reports.category_id = categories.category_id');
		$this->db->join('statuses', 'reports.status = statuses.status_id');
		$this->db->where('report_id', $id);

		$query = $this->db->get();
		if ($query->num_rows()==1) {
			$image_url = $query->row()->media_url;
			if (! preg_match('/\.(gif|jpe?g|png)$/', $image_url)) {
				$image_url = false;
			}
			$this->load->vars(array('report' => $query->row(), 'image_url' => $image_url));
			$output = array('output' => $this->load->view('report', '', true));
			$this->_admin_output($output);
		} else {
			show_error("Record $id not found", 404);
		}
	}

	function reports_csv() {
		$this->load->helper('csv');
		$query = $this->db->get('reports');
		$filename = date('Y-m-d_Hi') . '_reports.csv';
		query_to_csv($query, TRUE, $filename);
	}

	function categories() {
		$crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('categories');
		$crud->unset_texteditor('description'); # maybe don't unset this one
		$crud->unset_texteditor('status_notes','keywords');

		if (!($this->ion_auth->is_admin() || is_config_true($this->config->item('can_edit_categories')))) {
			$crud->unset_delete();
			$crud->unset_add();
			$crud->unset_edit();
		} else {
			$crud->callback_edit_field('keywords', array($this,'_text_keywords_field'));
		}

		$crud->set_subject('Open311 category');
		$output = $crud->render();

		$this->_admin_output($output);
	}

	function settings() {
		if (!$this->ion_auth->is_admin()) {
			redirect('admin/');
		} else {
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables'); /* text wraps for the long descriptions in databables, not flexigrid */
			$crud->set_table('config_settings');
			$crud->display_as('desc', 'Explanation');
			$crud->callback_column('desc', array($this, '_full_description'));
			$crud->unset_texteditor('name','value');
			$crud->edit_fields('name', 'desc', 'value');
			$crud->callback_edit_field('value', array($this,'_text_value_field'));  // the default (textarea) is too big for any current setttings 
			$crud->callback_edit_field('name', array($this,'_read_only_name_field'));  // read-only during edit
			$crud->callback_edit_field('desc', array($this,'_read_only_desc_field'));  // read-only during edit
			$crud->set_subject("configuration setting");
			$output = $crud->render();
			$this->_admin_output($output);
		}
	}

	function statuses() {
		if (!$this->ion_auth->is_admin()) {
			redirect('admin/');
		} else {
			$crud = new grocery_CRUD();
			$crud->set_theme('flexigrid'); 
			$crud->set_table('statuses');
			$crud->set_subject("problem status");
			$output = $crud->render();
			$this->_admin_output($output);
			
		}
	}
	
	function api_keys() {
		if (!$this->ion_auth->is_admin()) {
			redirect('admin/');
		} else {
			$crud = new grocery_CRUD();
			$crud->set_theme('flexigrid'); 
			$crud->set_table('api_keys');
			$crud->set_subject("API keys");
			$output = $crud->render();
			$this->_admin_output($output);
		}
	}

	function about() {
		$output = array('output' => $this->load->view('about', '', true));
		$this->load->view('admin_view.php', $output);
	}
	
	function help() {
		$output = array('output' => $this->load->view('help', '', true));
		$this->load->view('admin_view.php', $output);
	}

	function open311() {
		$output = array('output' => $this->load->view('open311', '', true));
		$this->load->view('admin_view.php', $output);
	}

	// There is some magic here: using xxx_report_id because we running callback_column directly
	// on report_id breaks other field renders (such as actions) that contain report_id.
	function _set_common_report_crud($columns) {
		$crud = new grocery_CRUD();
		// default columns excludes: token address_id simply because FMS/FMS-endpoint doesn't use them
		$default_columns = array('report_id', 'status', 'requested_datetime', 'priority',  'category_id',
			'external_id', 'media_url', 'status_notes', 'description', 'agency_responsible', 'service_notice',
			'updated_datetime', 'expected_datetime', 'address', 'postal_code', 'lat', 'long',
			'email', 'device_id', 'account_id', 'first_name', 'last_name', 'phone');
		$columns = $columns? $columns : $default_columns;
		foreach ($columns as &$colname) {
			if ($colname == 'report_id') {
				$colname = 'xxx_report_id';
			}
		}
		$crud->columns($columns);
		$crud->edit_fields($default_columns);
		$crud->set_theme('flexigrid');
		$crud->set_table('reports');
		$crud->set_subject('Problem report');
		$crud->set_relation('category_id','categories','category_name',null,'category_name ASC');
		$crud->set_relation('priority','priorities',
			'<span class="fmse-prio fmse-prio{prio_value}">{prio_name}</span>',null,'prio_value ASC');
		$crud->set_relation('status','statuses',
			'<span class="fmse-status-{is_closed}">{status_name}</span>',null,'status_name ASC');
		$crud->callback_column('media_url',array($this,'_linkify'));
		$crud->callback_edit_field('media_url', array($this,'_text_media_url_field'));  
		$crud->display_as('requested_datetime', 'Received')
			->display_as('updated_datetime', 'Updated')
			->display_as('expected_datetime', 'Expected')		
			->display_as('category_id', 'Category')
			->display_as('media_url', 'URL')
			->display_as('external_id', 'FMS ID');
		$crud->unset_texteditor('address', 'status_notes', 'service_notice');
		$crud->add_action('View', '/assets/fms-endpoint/images/report.png', 'admin/report');
		
		$crud->callback_column('xxx_report_id', array($this, '_report_id_link_field'));
		$crud->display_as('xxx_report_id', 'ID');
		$crud->callback_edit_field('xxx_report_id', array($this, '_read_only_report_id_field'));
		return $crud;
	}
	 
	function _admin_output($output = null) {
		$this->load->view('admin_view.php', $output);
	}

	// make the ID a link to the 
	function _report_id_link_field($value, $row) {
		$rid = $row->report_id;
		return "<a href='" . config_item('base_url') . "/admin/report/$rid' class='report-id-link'>$rid</a>";
	}
	
	function _read_only_report_id_field($value, $primary_key) { 
		return "<input type='hidden' value='$value' name='$primary_key'/>$value";
	}
	function _read_only_name_field($value, $primary_key) { return $this->_read_only_field('name', $value); }
	function _read_only_desc_field($value, $primary_key) { return $this->_read_only_field('desc', $value); }
	function _read_only_field($name, $value) {
		return '<input type="hidden" value="' . $value . '" name="' . $name . '"/>' . $value;
	}

	function _text_value_field($value, $primary_key) { return $this->_text_field('value', $value); }
	function _text_media_url_field($value, $primary_key) { return $this->_text_field('media_url', $value); }
	function _text_keywords_field($value, $primary_key) { return $this->_text_field('keywords', $value); }
	function _text_field($name, $value) {
		return '<input type="text" value="' . $value . '" name="' . $name . '"/>';
	}

	function _linkify($value, $row) {
		$retval = '';
		if ($value) {
			if (preg_match('/https?:\/\/(\\w*\\.)fixmy/', $value)) {
				$retval = 'fmse-web-link-fms';
			} else {
				$retval = 'fmse-web-link';
			}
			$retval = '<a href="' . $value . '" class="' . $retval . '" target="_blank">link</a>';
		}
		return $retval;
	}

	function _full_description($value, $row) {
		return $value = wordwrap($row->desc, strlen($row->desc), "<br>", true);
	}

}

?>