<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_district extends MX_Controller {
    /**
     * created by Raginee patle
     */

     function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('admin_district_model');
        $this->load->module('template');
         $this->load->language('hindi_district','hindi');
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
        $data['title'] = $this->lang->line('district');
        $data['title_tab'] = $this->lang->line('district_title_tab');
        $data['get_district']=get_list(DISTRICT,'district_id',null);
       // pre($data['get_section']);
        $data['view_file'] = "admin_district";
        $data['module_name'] = "admin_district";
        $this->template->index($data);
    }

    public function manage_district($id='')
    {
        $data = array();
        $data['title'] = $this->lang->line('district');
        $data['title_tab'] = $this->lang->line('district_title_tab');
        $data['get_district']=get_list(DISTRICT,'district_id',null);
        $data['view_file'] = "admin_manage_district";
        $data['module_name'] = "admin_district";
        $data['districtdata'] = $this->admin_district_model->getdistrictData($id);
        $this->template->index($data);
    }
     public function addUpdatedistrict()
    {
        $this->form_validation->set_rules('district_name_hi', 'district_name_hi', 'required');
        $this->form_validation->set_rules('district_name_en', 'district_name_en', 'required|callback_alpha_dash_space');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE) {


            if ($this->input->post('district_id')) {
                $district_id = $this->input->post('district_id');
                $data = array(
                    'district_name_hi' => trim($this->input->post('district_name_hi')),
                    'district_name_en' => trim($this->input->post('district_name_en')),
                );
                $response = $this->admin_district_model->updatedistrict($data, $district_id);

                if ($response) {
                    $this->session->set_flashdata('update', $this->lang->line('update_success_message'));
                    redirect('admin/district');
                }
            } else {
                $data = array(
                    'district_name_hi' => trim($this->input->post('district_name_hi')),
                    'district_name_en' => trim($this->input->post('district_name_en')),
                );
                $response = $this->admin_district_model->adddistrict($data);
                if ($response) {
                    $this->session->set_flashdata('insert', $this->lang->line('success_message'));
                    redirect('admin/district');
                }
            }
        }
        else
        {
            $dist_id = $this->input->post('district_id');
            $data = array();
            $data['title'] = "District";
            $data['title_tab'] = "All District list";
            $data['get_district']=get_list(DISTRICT,'district_id',null);
            $data['view_file'] = "admin_manage_district";
            $data['module_name'] = "admin_district";
            $data['districtdata'] = $this->admin_district_model->getdistrictData($dist_id);
            $data['msg'] = "Please enter valid value";
            $this->template->index($data);

        }
    }
    public function district_delete($delete_id = '')
    {

       echo  $response = $this->admin_district_model->deletedistrict( $delete_id );
        if ($response)
        {
            $this->session->set_flashdata('delete','District deleted sucessfully..!!');
            redirect('admin/district');
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