<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activity extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->module('template');
        $this->load->model('User_activity_model', 'user_activity');
        $this->load->language('user_activity', 'hindi');
    }

    public function index() {
        $data = array();
        $data['title'] ='User activity' ;
        $data['title_tab'] = $this->lang->line('title');
        $data['activity_list'] = $this->user_activity->get_activity_list();
        $data['activity_list_not_login'] = $this->user_activity->get_activity_list_not_login();
        $data['activity_lists_today'] = $this->user_activity->get_activity_list_today();
        $data['module_name'] = "user_activity";
        $data['view_file'] = "user_activity/index";
        $this->template->index($data);
    }

    public function activity_details($id) {
        $data = array();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('title');
        $data['activity_log_list'] = $this->user_activity->get_activity_list($id);
        $data['module_name'] = "user_activity";
        $data['view_file'] = "user_activity/log_details";
        $this->template->index($data);
    }

    

}
