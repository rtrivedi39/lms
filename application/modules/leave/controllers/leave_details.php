<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_details extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_details', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
        authorize();
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index($id) {
		if($this->input->get('year') != ''){
			$year = $this->input->get('year');
		} else {
			$year = date('Y');
		}
        $data['title'] = $this->lang->line('leave_detail_title');
        $data['title_tab'] = $this->lang->line('leave_detail_title_tab');
        $data['module_name'] = "leave";
        $data['id'] = $id;
        $data['leave_detail_lists'] = $this->leave_model->get_leaves('','',$id,$year );
        $data['leaves'] = $this->leave_model->getLeaves($id);
        $data['view_file'] = "leave/leave_details";
        $this->template->index($data);
    } 
    
	public function leave_details_search($id) {
		
		$year = $this->input->post('year_select');
		$leave_type = $this->input->post('leave_type');
        $data['title'] = $this->lang->line('leave_detail_title');
        $data['title_tab'] = $this->lang->line('leave_detail_title_tab');
        $data['module_name'] = "leave";
        $data['id'] = $id;
        $data['leave_detail_lists'] = $this->leave_model->get_leaves('','',$id,$year,$leave_type);
        $data['leaves'] = $this->leave_model->getLeaves($id);
        $data['view_file'] = "leave/leave_details";
        $this->template->index($data);
    }
	
	public function leave_order($show_all = '0') {		
        $data['title'] = $this->lang->line('order_title');
        $data['title_tab'] =  $this->lang->line('order_title');
        $data['module_name'] = "leave";
		$employees_class = $emp_unique_id =  '';
		if($show_all == '0'){
			$date = date('Y-m-d');
		} else if($show_all == '1'){
			$date = null;
		}else if ($show_all == 'date') {
			$date = date('Y-m-d',strtotime($this->input->post('order_date')));
			if ($this->input->post('order_date') == '') {		
				$date = null;		
			}			
		}
		if ($this->input->post('employees_class') != '') {
			$employees_class = $this->input->post('employees_class');			
		}
		if ($this->input->post('emp_unique_id') != '') {
			$emp_unique_id = $this->input->post('emp_unique_id');			
		}		
		
        $data['leave_order_lists'] = $this->leave_model->generate_order($date, $employees_class, $emp_unique_id);
        $data['view_file'] = "leave/leave_order";
        $this->template->index($data);
    }
	
	public function leave_applications($all_pedning = '0') {		
		$employees_class = '';	
        $data['title'] = $this->lang->line('application_title');
        $data['title_tab'] =  $this->lang->line('application_title');
        $data['module_name'] = "leave";		
		if($all_pedning == '0'){
			$date = date('Y-m-d');
		} else if($all_pedning == '1') {
			$date = null;
		}else if ($all_pedning == 'date') {
			$date = date('Y-m-d',strtotime($this->input->post('app_date')));
			if ($this->input->post('order_date') == '') {		
				$date = null;		
			}			
		}		
		if ($this->input->post('employees_class') != '') {
			$employees_class = $this->input->post('employees_class');			
		}	
	
        $data['leave_order_lists'] = $this->leave_model->leave_applications($date, $employees_class);
        $data['view_file'] = "leave/leave_applications";
        $this->template->index($data);
    }
	
	public function genrate_order($id) {
		$order_number = $this->input->post('order_number');
		set_leave_log($id,$this->session->userdata('emp_id'), 'आवेदन पर आर्डर नंबर दर्ज किया गया', 'जिसका आर्डर नंबर '.$order_number.' है');
		$res = updateData(LEAVE_MOVEMENT, array('leave_order_number' => $order_number), array('emp_leave_movement_id' => $id));		
        redirect('leave/leave/print_order/'.$id);
    }	
	
	public function leave_attachments($leave_id) {		
        $data['title'] = 'अवकाश दस्तावेज';
        $data['title_tab'] =  'अवकाश दस्तावेज';
        $data['module_name'] = "leave";		
        $data['leave_attachments_lists'] = $this->leave_model->leave_attachments($leave_id);
        $data['view_file'] = "leave/leave_attachments";
        $this->template->index($data);
    }
	
	public function update_leave_attachments() {		
       	$this->db->select('emp_leave_movement_id,medical_files,on_behalf_leave,emp_leave_create_date');      
        $this->db->from(LEAVE_MOVEMENT);
		$this->db->where('medical_files !=', '');
        $query = $this->db->get();
       // echo $this->db->last_query(); exit();
        $return = $query->result();     
		foreach($return as $files){
			 $attachment = array(
				'att_movement_id' => $files->emp_leave_movement_id,
				'att_name' => $files->medical_files,
				'att_by_emp_id' => $files->on_behalf_leave,
				'att_date' => $files->emp_leave_create_date,
				'att_type' => 'चिकित्सा दस्तावेज',
			 );
			 insertData($attachment,ATTACHMENTS);
		}
		pr(count($return).' inserted succersfully!');
    }
	
     
    public function show_404() {
        $this->load->view('404');
    }

}
