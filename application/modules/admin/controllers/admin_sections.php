<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_sections extends MX_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        //$this->load->model('admin_login/admin_login_model','Model_admin');
        $this->load->module('template');
        //$this->load->controller('template/template','admin_template');
    }
    public function isLoggedIn()
    {
        if ($this->session->userdata('admin_logged_in') === TRUE)
        {
            redirect("admin_dashboard");
        }
    }
    public function index()
    {
        $data = array();
        $data['title'] = "Sections";
        $data['title_tab'] = "All Sections list";
        $data['view_file'] = "admin_sections";
        $data['module_name'] = "admin_sections";
        $this->template->index($data);
    }
    public function show_404() {
         $this->load->view('404');
     }
}