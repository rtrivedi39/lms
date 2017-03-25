<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_structure extends MX_Controller {
    /**
     * created by Raginee patle
     */

     function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('admin_department_model', 'depart_struct');
        $this->load->module('template');
        $this->load->language('department_structure','hindi');
    }
    
    public function index()
    {
        $data = array();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('title_tab');
        $data['department_struct'] = $this->depart_struct->get_departmental_structure(2);
        $data['view_file'] = "admin_department_structure";
        $this->template->index($data);
    }

    public function show_404() {
         $this->load->view('404');
     }
}