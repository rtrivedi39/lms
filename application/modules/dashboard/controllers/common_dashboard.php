<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_dashboard extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('common_dashboard','hindi');
		$this->load->helper('leave');
    }
	 public function isLoggedIn()
    {
        if (($this->session->userdata('admin_logged_in') === false) && ($this->session->userdata('is_logged_in') === false))
        {
            redirect("home");
        }
    }
 	public function index()
    {
		no_cache();
		//print_r($this->session->all_userdata());
        $this->isLoggedIn();
        $data = array();

        $data['title']          = $this->lang->line('title');
        $data['title_tab']      = $this->lang->line('emprole_all_unit_list');


		// $data['total_file'] = $this->dashboard_model->getTotalFile();
		// $data['dispetch_file'] = $this->dashboard_model->getDispatchFile();
		// $data['pending_file'] = $this->dashboard_model->getpendingFile();
		// $data['leaves'] = $this->leave_model->getLeaves();
		//$data['pending_files'] = $this->dashboard_model->getPendingfilesDetails();
		$setion_id = $this->session->userdata("emp_section_id");
		$data['notice_boards']  = getNoticeBoardInformation($setion_id);
		$data['module_name']    = "dashboard";
        $data['view_file']      = "dashboard/index";
        $this->template->index($data);
    }

	public function site_map(){
		$data['title']          = $this->lang->line('site_map_menu');
        $data['title_tab']      = $this->lang->line('site_map_menu');
		$data['module_name']    = "dashboard";
        $data['view_file']      = "dashboard/site_map";
        $this->template->index($data);
	}

    public function show_404() {
         $this->load->view('404');
 	}
}