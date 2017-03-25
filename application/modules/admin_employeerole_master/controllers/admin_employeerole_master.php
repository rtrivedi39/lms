<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin_employeerole_master extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('admin_employeerole_master_model', 'employeerole_model');
        $this->load->language('employeerole', 'hindi');
    }
    public function index() {
        $data = array();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('emprole_all_unit_list');
        $data['get_employee'] = $this->employeerole_model->get_employee_list(); //get_list(EMPLOYEEE_ROLE,'role_id',null);
        //pre($data['get_section']);
        $data['module_name'] = "admin_employeerole_master";
        $data['view_file'] = "admin_employeerole_master/index";
        $this->template->index($data);
    }
    public function manage_employeerole($id = null) {
        $this->load->helper(array('form', 'url'));
        $data = array();
        $data['unilevels'] = $this->employeerole_model->getunitlevel();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('title');
        if ($id == null) {
            $data['page_title'] = $this->lang->line('add_employee_role');
            $data['is_page_edit'] = 1;
        } else {
            $data['page_title'] = $this->lang->line('edit_employee_role');
            ;
            $data['is_page_edit'] = 0;
            $emprole_master_detail = get_list(EMPLOYEEE_ROLE, null, array('role_id' => $id));
            $data['emprole_master_detail'] = $emprole_master_detail[0];
        }
        $data['id'] = $id;
        $this->form_validation->set_rules('unit_id', $this->lang->line('add_employeerole_with_unit'), 'required');
        $this->form_validation->set_rules('emprole_name_hi', $this->lang->line('add_employeerole_with_hi'), 'required|xss_clean');
        $this->form_validation->set_rules('emprole_name_en', $this->lang->line('add_employeerole_with_en'), 'required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE) {
            $emprole_tbl_data = array($this->input->post());
            if ($id) {
                $res = updateData(EMPLOYEEE_ROLE, $emprole_tbl_data[0], array('role_id' => $id));
                if ($res) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
                }
            } else {
                $res = insertData($emprole_tbl_data[0], EMPLOYEEE_ROLE);
                if ($res) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('success_message') . '</div>');
                }
            }

            redirect('admin/employeerole');
        }

        //$data['get_section']=get_list(SECTIONS,'section_id',null);
        //pre($data['get_section']);
        $data['view_file'] = "admin_manage_employeerole";
        $data['module_name'] = "admin_employeerole_master";
        $this->template->index($data);
    }
    function alpha_dash_space($str) {
        if (!preg_match("/^([-a-z_ ])+$/i", $str)) {
            $this->form_validation->set_message('alpha_dash_space', $this->lang->line('text_allow_with_space_error'));
            return false;
        }
    }
    public function show_404() {
        $this->load->view('404');
    }
}
