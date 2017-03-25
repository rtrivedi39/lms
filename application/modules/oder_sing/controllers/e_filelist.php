<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class E_filelist extends MX_Controller {
    function __construct() {
        parent::__construct();
         $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_details', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
        authorize();
    }
	
	public function efile_sign($show_all = '0'){
		
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
        $data['view_file'] = "e_filelist/leave_order";
        $this->template->index($data);
	}
	
	
	
	
}