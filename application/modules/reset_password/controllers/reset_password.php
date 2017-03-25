<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reset_password extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->module('template');
        $this->load->model('reset_password_model', 'reset_password_model');
        $this->load->language('resetpassword', 'hindi');
        authorize();
    }

    public function index() {
        $data = array();
        $data['title'] ='Reset and Change secuirity question and password' ;
        $data['title_tab'] ='Change Password' ;
        //$data['get_users'] = get_list(EMPLOYEES, 'emp_id', null);
        $data['module_name'] = "reset_password";
        $data['view_file'] = "reset_password/index";
        $this->template->index($data);
    }

    public function change_password(){
        $this->form_validation->set_rules('new_password', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('confirm_pwd', $this->lang->line('reset_confirm_pwd_label'), 'trim|required|xss_clean|min_length[5]|max_length[50]|callback_check_confirm_pwd');
        $this->form_validation->set_rules('sec_question', $this->lang->line('reset_confirm_question_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('sec_answer', $this->lang->line('reset_confirm_answer_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_email', $this->lang->line('reset_pwd_email_hi'), 'valid_email|trim|required|xss_clean|callback_check_emp_email');
        $this->form_validation->set_rules('emp_mobile_number', $this->lang->line('reset_pwd_mobile_hi'), 'integer|min_length[10]|max_length[15]|trim|required|xss_clean|callback_check_emp_mobile');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run($this) === TRUE) {
                $id = $this->session->userdata('emp_id');
                if (is_array($this->input->post())) {
                    $res1 = updateData(EMPLOYEES, array('emp_email'=>$this->input->post('emp_email'),'emp_mobile_number'=>$this->input->post('emp_mobile_number'),'emp_first_login'=>1,'emp_password'=>md5($this->input->post('confirm_pwd'))), array('emp_id' => $id));
                    $emp_detail=array(
                            'emp_detail_security_question'=>$this->input->post('sec_question'),
                            'emp_detail_answer'=>$this->input->post('sec_answer'),
                        );

                    $res2= updateData(EMPLOYEE_DETAILS,$emp_detail, array('emp_id' => $id));
                    if($res2 && $res1){
                        redirect('dashboard');
                    }
                }
        }else{
            $data['module_name'] = "reset_password";
            $data['view_file'] = "reset_password/index";
            $this->template->index($data);
        }
    }


    function check_confirm_pwd($str) {
        $new_pwd = $this->input->post('new_password');
        $confirm_pwd = $this->input->post('confirm_pwd');
        if ($new_pwd!=$confirm_pwd) {
            $this->form_validation->set_message('check_confirm_pwd', '<b>' . $confirm_pwd . '</b> ' . $this->lang->line('reset_pwd_notmatch_hi'));
            return false;
        }
    }

    function check_emp_email($str){
        $emp_unique_loginid3 = $this->input->post('emp_email');
        $id = $this->session->userdata("emp_id");
        if ($emp_unique_loginid3 != ''){
            $cnt = 1;
            $is_users = get_list(EMPLOYEES,NULL,array('emp_email'=>$emp_unique_loginid3,'emp_id !='=>$id));
        } 
        if ($cnt<count($is_users)){
            $this->form_validation->set_message('check_emp_email','<b>'.$emp_unique_loginid3.'</b>'.$this->lang->line('emp_email_allready_exit_message'));
            return false;
        }
    }

    function check_emp_mobile($str){
        $emp_mobil_loginid3 = $this->input->post('emp_mobile_number');
        $id = $this->session->userdata("emp_id");
        if ($emp_mobil_loginid3!=''){
            $cnt = 1;
            $is_users = get_list(EMPLOYEES,NULL,array('emp_mobile_number'=>$emp_mobil_loginid3,'emp_id !='=>$id));
        } 
        if ($cnt<count($is_users)){
            $this->form_validation->set_message('check_emp_mobile','<b>'.$emp_mobil_loginid3.'</b>'.$this->lang->line('emp_email_allready_exit_message'));
            return false;
        }
    }

}
