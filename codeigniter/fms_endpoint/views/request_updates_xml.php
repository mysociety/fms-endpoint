<?php 

// <service_request_updates>
//     <request_update>
//         <update_id>20474</update_id>
//         <service_request_id>2934</service_request_id>
//         <status>OPEN</status>
//         <updated_datetime>2010-04-14T10:37:38-01:00</updated_datetime>
//         <description>This problem has been scheduled for inspection</description>
//     </request_update>
// </service_request_updates>

$this->load->helper('xml');
$dom = xml_dom();
$request_updates = xml_add_child($dom, 'service_request_updates');

function dateformat($datetime) {
	$datetime = ($datetime == '0000-00-00 00:00:00') ? '' : date("Y-m-d\TH:i:s\Z",strtotime($datetime));
	return $datetime;
}

foreach($query->result() as $row) {
	
	$update = xml_add_child($request_updates, 'request_update');
	
	xml_add_child($update, 'update_id', $row->id);
	xml_add_child($update, 'service_request_id', $row->report_id);
	xml_add_child($update, 'status', $row->status_id); // FIXME status name (?)
	xml_add_child($update, 'updated_datetime', dateformat($row->updated_at));
	xml_add_child($update, 'description', $row->update_desc);
}

xml_print($dom);

?>



