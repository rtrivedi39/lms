<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('admin_notice_master/Admin_notice_master_model', 'admin_notice');
        $this->load->helper('leave_helper');
    }

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    public function index() {

        if ($this->session->userdata('is_logged_in')) {
             redirect('dashboard');
        } else if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
        } else {
            //redirect('http://10.115.254.213/');
            $data['title'] = $this->lang->line('home_title');
            $data['notice'] = $this->admin_notice->fetchnoticebyid();
            $this->load->view('home', $data);
        }
    }

    /**
     * encript the datakey 
     * @return mixed
     */
    function __encrip_password($datakey) {
        return md5($datakey);
    }

    /**
     * check the username and the password with the database
     * @return void
     */
    function login_user() {
		$this->load->library('user_agent');        
        $data['title'] = $this->lang->line('home_title');
        $this->form_validation->set_rules('emp_login_id', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('emp_password', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        if($this->session->userdata('counting') > 3){
			$cpachavalue = $this->input->post('cpachavalue');
			$capchainput = $this->input->post('capchainput');
			if($cpachavalue != $capchainput){
				$this->form_validation->set_rules('capchainput', ' कैपचा को सही दर्ज करें', 'required|matches[cpachavalue]');
			}
		}
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        //get post value
		$user_id = ltrim($this->input->post('emp_login_id'),'0');
        $user_id = trim($user_id);
        
		$ses_data['login_id'] =  $user_id;	
		if($this->session->userdata('login_id') == $user_id){
			if(!$this->session->userdata('counting')){
				$ses_data['counting'] = 1;
			}else{
				$ses_data['counting'] = $this->session->userdata('counting') + 1;
			}
		}else{
			$ses_data['counting'] = 1;
		}
		$this->session->set_userdata($ses_data);
		
        if ($this->form_validation->run($this) == FALSE) {
			$data['notice'] = $this->admin_notice->fetchnoticebyid();
            $data['emp_login_id_val'] = $user_id;
            $this->load->view('site/home', $data);
        } else {
			
			$password = $this->__encrip_password($this->input->post('emp_password'));
            $emp_id = is_numeric($user_id) ? $this->Users_model->get_emp_id_unique_id($user_id) : $this->Users_model->get_emp_id_user_id($user_id);
            $user_data = $this->Users_model->get_user_data($emp_id);
            $is_valid = $this->Users_model->validate_user($user_id, $password);
            if ($is_valid > 0) {
                if ($user_data[0]->emp_status == 1) {
                    if ($user_data[0]->emp_is_retired) {
                        $data['retire_error'] = TRUE;
                        $data['emp_login_id_val'] = $user_id;
						$data['notice'] = $this->admin_notice->fetchnoticebyid();
                        $this->load->view('site/home', $data);
                    } else {
                        $data = array( 
                            'emp_id' => $emp_id,
                            'user_id' => $user_id,  // unique id
                            'user_role' => $user_data[0]->role_id,
                            'user_role_name_hi' => getemployeeRole($user_data[0]->role_id),
                            'user_role_name_en' => getemployeeRole($user_data[0]->role_id, true),
                            'user_designation' => $user_data[0]->designation_id,
							'user_designation_name_hi' => getemployeeRole($user_data[0]->designation_id),
                            'user_designation_name_en' => getemployeeRole($user_data[0]->designation_id, true),
                            'emp_unique_id' => $user_data[0]->emp_unique_id,
                            'emp_full_name' => $user_data[0]->emp_full_name,
                            'emp_full_name_hi' => $user_data[0]->emp_full_name_hi,
                            'emp_image' => $user_data[0]->emp_image,
							'emp_first_login' => $user_data[0]->emp_first_login,
                            'emp_section_id' => $user_data[0]->emp_section_id
                        );
                        if ($user_data[0]->role_id == 1) {
                            $data['admin_logged_in'] = TRUE;
                            $this->session->set_userdata('admin_image', $user_data[0]->emp_image);
                            $this->session->set_userdata($data);
                            $this->Users_model->user_login_log();
                            redirect('dashboard');
                        } else {
                            // $data['is_logged_in'] = TRUE;
                            // $this->session->set_userdata($data);
                            //redirect('dashboard');
                            $data['is_logged_in'] = TRUE;
                            $this->session->set_userdata($data);  
                            $this->Users_model->user_login_log();                          
                            if ($user_data[0]->emp_first_login == 0) {
                                redirect('first_reset_password');
                            } else {
                                redirect('dashboard');
                                //redirect('leave');
                            }                            
                        }
                    }
                } else {
                    $data['status_error'] = TRUE;
                    $data['status_error_message'] = $user_data[0]->emp_status_message;
                    $data['emp_login_id_val'] = $user_id;
                    $data['notice'] = $this->admin_notice->fetchnoticebyid();
					$this->load->view('site/home', $data);
                }
            } else { // incorrect username or password
				
                $data['message_error'] = TRUE;
                $data['emp_login_id_val'] = $user_id;
				$data['notice'] = $this->admin_notice->fetchnoticebyid();
                $this->load->view('site/home', $data);
            }
        }
    }

    /**
     * user forgot password to ask security question
     * @return void
     */
    public function forgote_password() {
        $data['title'] = $this->lang->line('forgot_password_title');
        $this->form_validation->set_rules('emp_forgote_login_id', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $user_id = ltrim($this->input->post('emp_forgote_login_id'),'0');
        if ($this->form_validation->run($this) === TRUE) {
            $is_exists = $this->Users_model->check_valid_user($user_id);
            if ($is_exists) {
                $data['security_question'] = TRUE;
                // $emp_id = $this->Users_model->get_emp_id_user_id($user_id);
                $emp_id = is_numeric($user_id) ? $this->Users_model->get_emp_id_unique_id($user_id) : $this->Users_model->get_emp_id_user_id($user_id);
                $user_data = $this->Users_model->get_user_data($emp_id);
                $data['emp_security_ques'] = $user_data[0]->emp_detail_security_question;
                $data['emp_id'] = $this->encrypt->encode($emp_id);
                $this->load->view('forgote_password', $data);
            } else {
                $data['message_error'] = TRUE;
                $data['emp_forgote_login_id_val'] = $user_id;
                $this->load->view('forgote_password', $data);
            }
        } else {
            $this->load->view('forgote_password', $data);
        }
    }

    /**
     * check the security answer and user_id with the database
     * @return void
     */
    public function reset_password() {
        $data['title'] = $this->lang->line('forgot_password_title');
        $emp_id = $this->encrypt->decode($this->input->post('emp_id'));
        $user_data = $this->Users_model->get_user_data($emp_id);
        $this->form_validation->set_rules('emp_security_answer', 'answer', 'required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run($this) === TRUE) {
            $emp_security_answer = $this->input->post('emp_security_answer');
            
            $ses_data['emp_id'] = $emp_id;	
			if($this->session->userdata('emp_id') == $emp_id){
				if(!$this->session->userdata('countings')){
					$ses_data['countings'] = 1;
				}else{
					$ses_data['countings'] = $this->session->userdata('countings') + 1;
				}
			}else{
				$ses_data['countings'] = 1;
			}
			$this->session->set_userdata($ses_data);
			
            $emp_detail_answer = $user_data[0]->emp_detail_answer;
            if ($emp_security_answer === $emp_detail_answer) {
                $data['title'] = $this->lang->line('reset_password_title');
                $data['emp_id'] = $this->encrypt->encode($emp_id);
                $this->load->view('reset_password', $data);
            } else {
                $data['security_question'] = TRUE;
                $data['security_message_error'] = TRUE;
                $data['emp_security_ques'] = $user_data[0]->emp_detail_security_question;
                $data['emp_id'] = $this->encrypt->encode($emp_id);
                $data['emp_security_answer_val'] = $emp_security_answer;
                $this->load->view('forgote_password', $data);
            }
        } else {
            $data['security_question'] = TRUE;
            $data['emp_security_ques'] = $user_data[0]->emp_detail_security_question;
            $data['emp_id'] = $this->encrypt->encode($emp_id);
            $this->load->view('forgote_password', $data);
        }
    }

    /**
     * reset user password and redirect to home page with message
     * @return void
     */
    public function reset_forgote_password() {
        $data['title'] = $this->lang->line('reset_password_title');
        $this->form_validation->set_rules('emp_password', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('emp_new_password', '5', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        if($this->session->userdata('countings') > 3){
			$cpachavalue = $this->input->post('cpachavalue');
			$capchainput = $this->input->post('capchainput');
			if($cpachavalue != $capchainput){
				$this->form_validation->set_rules('capchainput', ' कैपचा को सही दर्ज करें', 'required|matches[cpachavalue]');
			}
		}
        $emp_id = $this->encrypt->decode($this->input->post('emp_id'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run($this) === TRUE) {
            $emp_password = $this->input->post('emp_password');
            $emp_new_password = $this->input->post('emp_new_password');

            if ($emp_password === $emp_new_password) {
                $_password = $this->__encrip_password($emp_password);
                $is = $this->Users_model->update_password($emp_id, $_password);
                if ($is) {
                    $this->session->set_flashdata('pass_msg', $this->lang->line('success_reset_password_message'));
                    redirect('home');
                }
            } else {
                $data['message_error'] = TRUE;
                $data['emp_id'] = $this->encrypt->encode($emp_id);
                $this->load->view('reset_password', $data);
            }
        } else {
            $data['emp_id'] = $emp_id;
            $this->load->view('reset_password', $data);
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

    public function faq() {
        $data['title'] = 'FAQ'; //$this->lang->line('title_faq');
        $this->load->view('faq', $data);
    }

    public function privacy_policy() {
        $data['title'] = 'Privacy policy'; //$this->lang->line('title_faq');
        $this->load->view('privacy_policy', $data);
    }

    public function departmental_setup() {
        $data['title'] = 'Departmental setup'; //$this->lang->line('title_faq');
        $this->load->view('departmental_setup', $data);
    }

    /**
     * logout all session and redirect to home page
     * @return void
     */
    public function logout() {
        $this->Users_model->destroy_user_login_log();
        $this->session->sess_destroy();
        no_cache();
        redirect("home");
    }

    public function auto_login_user() {
        
        $this->load->library('user_agent');        
        if(isset($_GET['uid']) && $_GET['uid']!='' && $_GET['islogin']=='y' ){
            $user_id=$_GET['uid'];
            $user_data = $this->Users_model->get_user_data($user_id);
            $password =$user_data[0]->emp_password;
            $emp_unique_id=$user_data[0]->emp_unique_id;
            $is_valid = $this->Users_model->validate_user($emp_unique_id, $password);
            if ($is_valid) {
                if ($user_data[0]->emp_status) {
                    if ($user_data[0]->emp_is_retired) {
                        $data['retire_error'] = TRUE;
                        $data['emp_login_id_val'] = $user_id;
                        $data['notice'] = $this->admin_notice->fetchnoticebyid();
                        $this->load->view('site/home', $data);
                    } else {
                        $data = array(
                            'user_id' => $user_id,
                            'user_role' => $user_data[0]->role_id,
                            'user_designation' => $user_data[0]->designation_id,
                            'emp_id' => $user_id,
                            'emp_unique_id' => $user_data[0]->emp_unique_id,
                            'emp_full_name' => $user_data[0]->emp_full_name,
                            //'emp_designation' => $user_data[0]->emprole_name_hi,
                            'emp_image' => $user_data[0]->emp_image
                        );
                        $data['is_logged_in'] = TRUE;
                        $this->session->set_userdata($data);  
                        $this->Users_model->user_login_log(); 
                        //pr($this->session->all_userdata());
                        redirect(base_url().'leave/leave_approve');
                    }
                } else {
                    $data['status_error'] = TRUE;
                    $data['status_error_message'] = $user_data[0]->emp_status_message;
                    $data['emp_login_id_val'] = $user_id;
                    $data['notice'] = $this->admin_notice->fetchnoticebyid();
                    $this->load->view('site/home', $data);
                }
            } else { // incorrect username or password
                
                $data['message_error'] = TRUE;
                $data['emp_login_id_val'] = $user_id;
                $data['notice'] = $this->admin_notice->fetchnoticebyid();
                $this->load->view('site/home', $data);
            }
        }
    }

}
