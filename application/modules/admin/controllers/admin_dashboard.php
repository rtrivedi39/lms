<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_dashboard extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('admin_login_model');
        $this->load->module('template');
        $this->lang->load("common_dashboard", "hindi");
        //$this->load->controller('template/template','admin_template');
        authorize();
    }

    public function isLoggedIn() {
        if ($this->session->userdata('admin_logged_in') === TRUE) {
            redirect("admin_dashboard");
        }
    }

    public function index() {
        no_cache();
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        } else if ($this->session->userdata('admin_logged_in')) {
            $data = array();
            //$data['totalnumberofemployee']=
            $data['view_file'] = "admin_dashboard";
            $data['module_name'] = "admin_dashboard";
            $this->template->index($data);
        } else {
            redirect('home');
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

    /** This function will chnage login user password
      $param
      return boolean data if success or failer
     */
    public function change_pwd() {
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'required');
        if ($this->form_validation->run($this) === TRUE) {
            $oldpssword = md5($this->input->post('old_password'));
            $match = $this->admin_login_model->match_oldpwd($oldpssword);
            if ($match > 0) {
                $responce = $this->admin_login_model->change_pwd($newpssword);
                if ($responce) {
                    $this->session->set_flashdata('update', 'Your password updated successfully..!!');
                    redirect('admin/changepassword');
                }
            } else {

                $this->session->set_flashdata('error', 'Old password not match..!!');
                redirect('admin/changepassword');
            }
        }
    }

    public function profile() {
        $data = array();
        $data['userdata'] = $this->admin_login_model->getUserdata();
        $data['user_service_profile'] = $this->admin_login_model->get_user_service_profile();
        $data['view_file'] = "profile";
        $data['module_name'] = "profile";
        $this->template->index($data);
    }

    public function editpassword() {
        $data = array();
        $data['userdata'] = $this->admin_login_model->getUserdata();
        $data['view_file'] = "change_pwd";
        $data['module_name'] = "change_pwd";
        $this->template->index($data);
    }

    public function updateProfile() {

        if ($this->input->post('edit_id')) {


            if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile'])) {
                $path = './uploads/employee/';
                $config['upload_path'] = $path;
                $config['allowed_types'] = '*';

                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['overwrite'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;
                if (!is_dir($path))
                    die("THE UPLOAD DIRECTORY DOES NOT EXIST");
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                }
            }

            $data = array(
                'emp_full_name' => $this->input->post('emp_name'),
                'emp_full_name_hi' => $this->input->post('emp_name_hi'),
                'emp_email' => $this->input->post('email'),
                'emp_mobile_number' => $this->input->post('mobile'),
                'emp_image' => isset($upload_data['file_name']) ?  $upload_data['file_name'] : '',
            );

            $edit_id = $this->input->post('edit_id');
            $response = $this->admin_login_model->updateProfile($data, $edit_id);
            if ($response) {
				$message_text = $this->session->userdata('emp_full_name_hi'). ' के द्वारा  व्यक्तिगत जानकारी को बदला गया -- (' .serialize($data).')';
				$emp_log_activity_array = array('emp_id' => $this->input->post('edit_id'),
					'log_prefix_status' => 'Change personal details',
					'log_description' => $message_text);
				insertData($emp_log_activity_array, EMPLOYEE_ACTIVITY_LOG);
                $this->session->set_flashdata('update', "Account details updated successfully..!!");
                redirect('admin/profile');
            }
        }
    }

    function upload() {
        $this->load->view('upload_file', array('error' => ' '));
    }

    function do_upload() {
        print_r($_FILES);
        die;
        $config = array(
            'upload_path' => './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => '100',
            'max_width' => '1024',
            'max_height' => '768',
            'encrypt_name' => true,
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_file', $error);
        } else {
            $upload_data = $this->upload->data();
            print_r($upload_data);
            die;
            $data_ary = array(
                'title' => $upload_data['client_name'],
                'file' => $upload_data['file_name'],
                'width' => $upload_data['image_width'],
                'height' => $upload_data['image_height'],
                'type' => $upload_data['image_type'],
                'size' => $upload_data['file_size'],
                'date' => time(),
            );

            //$this->load->database();
            // $this->db->insert('upload', $data_ary);
            //$data = array('upload_data' => $upload_data);
            // $this->load->view('upload_success', $data);
        }
    }
    
    function  update_passdetails(){
        $this->form_validation->set_rules('new_password', '5', 'trim|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('confirm_pwd', $this->lang->line('reset_confirm_pwd_label'), 'trim|xss_clean|min_length[5]|max_length[50]|callback_check_confirm_pwd');
        $this->form_validation->set_rules('sec_question', $this->lang->line('reset_confirm_question_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('sec_answer', $this->lang->line('reset_confirm_answer_label'), 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run($this) === TRUE) {
                $id = $this->session->userdata('emp_id');
                if($this->input->post('confirm_pwd') != '') {
                    $data = array(
                        'emp_password'=>md5($this->input->post('confirm_pwd')),
                      );
                    $response = updateData(EMPLOYEES, $data, array('emp_id' => $id));
                }
                $emp_detail=array(
                        'emp_detail_security_question'=>$this->input->post('sec_question'),
                        'emp_detail_answer'=>$this->input->post('sec_answer'),
                );
                $response = updateData(EMPLOYEE_DETAILS, $emp_detail, array('emp_id' => $id));
                if ($response) {
					$message_text = $this->session->userdata('emp_full_name_hi'). ' के द्वारा  सिक्यूरिटी जानकारी को बदला गया -- (' .serialize($emp_detail).')';
					$emp_log_activity_array = array('emp_id' => $this->input->post('edit_id'),
						'log_prefix_status' => 'Change security details',
						'log_description' => $message_text
					);
					insertData($emp_log_activity_array, EMPLOYEE_ACTIVITY_LOG);
					$this->session->set_flashdata('update_pass', "Account details updated successfully..!!");
					redirect('admin/profile');
				}
        }else{
            $data['userdata'] = $this->admin_login_model->getUserdata();
            $data['view_file'] = "profile";
            $data['module_name'] = "profile";
            $this->template->index($data);
        }
    }
    
    function check_confirm_pwd($str) {
        $new_pwd = $this->input->post('new_password');
        $confirm_pwd = $this->input->post('confirm_pwd');
        if ($new_pwd!=$confirm_pwd) {
            $this->form_validation->set_message('check_confirm_pwd', '<b>' . $confirm_pwd . '</b> ' . $this->lang->line('pwd_notmatch_hi'));
            return false;
        }
    }
}
