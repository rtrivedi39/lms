<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_department extends MX_Controller {
    /**
     * created by Raginee patle
     */

     function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('admin_department_model');
        $this->load->module('template');
         $this->load->language('hindi_department','hindi');
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
        $data['title'] = $this->lang->line('department');
        $data['title_tab'] = $this->lang->line('department_title_tab');
        $data['get_department']=get_list(DEPARTMENTS,'dept_id',null);
       // pre($data['get_section']);
        $data['view_file'] = "admin_department";
        $data['module_name'] = "admin_department";
        $this->template->index($data);
    }

    public function manage_department($id='')
    {
        $data = array();
        $data['dpid'] = $id;
        $data['title'] = $this->lang->line('department');
        $data['title_tab'] = $this->lang->line('department_title_tab');
        $data['get_district']=get_list(DEPARTMENTS,'dept_id',null);
        $data['view_file'] = "admin_manage_department";
        $data['module_name'] = "admin_department";
        $data['departmentdata'] = $this->admin_department_model->getdepartmentData($id);
        $this->template->index($data);

    }
    public function addUpdatedepartment($deptid=NULL )
    {
        $this->form_validation->set_rules('dept_name_hi', 'dept_name_hi', 'required');
        $this->form_validation->set_rules('dept_name_en', 'dept_name_en', 'required|callback_alpha_dash_space');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE) {


            if ($deptid) {

                $data = array(
                    'dept_name_hi' => trim($this->input->post('dept_name_hi')),
                    'dept_name_en' => trim($this->input->post('dept_name_en')),
                );
                $response = $this->admin_department_model->updatedepartment($data, $deptid);

                if ($response) {
                    $this->session->set_flashdata('update', $this->lang->line('update_success_message'));
                    redirect('admin/department');
                }
            } else {
                $data = array(
                    'dept_name_hi' => trim($this->input->post('dept_name_hi')),
                    'dept_name_en' => trim($this->input->post('dept_name_en')),
                );
                $response = $this->admin_department_model->adddepartment($data);
                if ($response) {
                    $this->session->set_flashdata('insert',$this->lang->line('success_message'));
                    redirect('admin/department');
                }
            }
        }
        else
        {

          //  $did = $this->input->post('dept_id');
            $data = array();
            $data['dpid'] = $deptid;
            $data['title'] = "Department";
            $data['title_tab'] = "All Department list";
            $data['get_district']=get_list(DEPARTMENTS,'dept_id',null);
            $data['view_file'] = "admin_manage_department";
            $data['module_name'] = "admin_department";
            $data['departmentdata'] = $this->admin_department_model->getdepartmentData($deptid);
            $this->template->index($data);

        }
    }

    function alpha_dash_space($str)
    {
        if(!preg_match("/^([-a-z_ ])+$/i", $str)){
            $this->form_validation->set_message('alpha_dash_space','Please fill valid value');
            return false;
        }
    }

    public function show_404() {
         $this->load->view('404');
     }
}