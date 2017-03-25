<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Template extends MX_Controller {
	function __construct(){
		$this->load->module('leave');
		$this->benchmark->mark('start');
	}
	
	public function index($data) {
		//common veriable used in full site
		$data['forword_count'] = $this->leave_model->get_allforword_lists(null, true);
		$data['recomend_count'] = $this->leave_model->get_recomender_lists(null, true);
		if((in_array(7, explode(',', $this->session->userdata("emp_section_id") ))) &&  (in_array( $this->session->userdata('user_role'), array(4)))) {
			$data['forword_count_all'] = $this->leave_model->get_allforword_lists(null, true, 'all');
		 }
	    $data['aproval_count'] = $this->leave_model->get_allaproval_lists(null, true);
		$data['userrole'] = checkUserrole();
		$get_emp_est_sec = get_section_employee(7,4);
		$data['emp_est_sec'] = $get_emp_est_sec[0]->emp_id;
		
		//all session data
		$data['current_emp_id'] = $this->session->userdata("emp_id");
		$data['current_emp_full_name_hi'] = $this->session->userdata('emp_full_name_hi');
		$data['current_emp_full_name'] = $this->session->userdata('emp_full_name');
		$data['current_emp_emp_image'] = $this->session->userdata('emp_image');
		$data['current_emp_section_id'] = $this->session->userdata("emp_section_id");
		$data['current_emp_designation_id'] = $this->session->userdata('user_designation');
		$data['current_emp_role_id'] = $this->session->userdata('user_role');
		$data['is_emp_first_login'] = $this->session->userdata('emp_first_login');
		
		if ($this->session->userdata('admin_logged_in') === true) {
			$this->load->view('template/admin_template',$data);
		}else{
			$this->load->view('template/user_template',$data);
		}
	}
	/*public function admin_index($data) {
		 if ($this->session->userdata('admin_logged_in') === false) {
		 	redirect('home');
		}else{
		 	$this->load->view('template/admin_template',$data);
		}
			
	}
	public function user_index($data) {
		 if ($this->session->userdata('is_logged_in') === false) {
		 	redirect('home');
		}else{
		 	$this->load->view('template/user_template',$data);
		}
			
	} */

}
