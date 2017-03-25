<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_levels extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
		$this->load->helper('leave');
        $this->load->model('leave_levels_model');
        $this->load->module('template');
        $this->load->language('leave_levels', 'hindi');
    }

    /**
     * created by sulbha shrivastava
     * @ Function Name      : index
     * @ Function Purpose   : display unit list 
     * @ Function Returns   : 
     */
    public function index() {
        $data = array();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('leave_levels_lists_title');
        $data['leave_level_lists'] = $this->leave_levels_model->get_level_lists();
        $data['view_file'] = "leave_levels_lists";
        $this->template->index($data);
    }

    /**
     * created by sulbha shrivastava
     * @ Function Name      : manage_unit
     * @ Function Params    : $data {mixed}, $kill {boolean}
     * @ Function Purpose   : display add and edit unit form 
     * @ Function Returns   : edit data 
     */
    public function manage_leave_levels($id = '') {
        $data = array();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('leave_levels_lists_title');
        if ($id != '') {
            $data['leave_level_lists'] = $this->leave_levels_model->get_single_level($id);
            $data['id'] = $id;
        }
        $data['view_file'] = "manage_leave_levels";
        $this->template->index($data);
    }

    /**
     * created by sulbha shrivastava
     * @ Function Name      : addUpdateUnit
     * @ Function Params    : $data {mixed}, $kill {boolean}
     * @ Function Purpose   : add and update unit value
     * @ Function Returns   : insert id
     */
    public function add_update_leave_levels() {
        $edit_id = $this->input->post('hirarchi_id');
        $this->form_validation->set_rules('emp_id', $this->lang->line('required'), 'required');
        $this->form_validation->set_rules('forwarder_id', $this->lang->line('required'), 'required');
        $this->form_validation->set_rules('recommender_id', $this->lang->line('required'), 'required');
        $this->form_validation->set_rules('approver_id', $this->lang->line('required'), 'required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        
        if ($this->form_validation->run($this) === TRUE) {
            $data = array(
                'emp_id' => $this->input->post('emp_id'),
                'forwarder_id' => $this->input->post('forwarder_id'),
                'recommender_id' => $this->input->post('recommender_id'),
                'approver_id' => $this->input->post('approver_id'),
            );
            // pr($data);
            if ($edit_id == '') {
                $response = $this->leave_levels_model->add_leave_level($data);
                if ($response) {
                    $this->session->set_flashdata('insert', $this->lang->line('insert_message'));
                    redirect('admin/leave_levels');
                }
            } else {
                $response = $this->leave_levels_model->update_leave_level($data, $edit_id);
                if ($response) {
					$remark_log = getemployeeName($this->session->userdata('emp_id'))." के द्वारा ".getemployeeName($this->input->post('emp_id'))." का  अग्रेषित  कर्ता ".getemployeeName($this->input->post('forwarder_id'))." अनुशंषित कर्ता ".getemployeeName($this->input->post('recommender_id'))." और अनुमोदन कर्ता ".getemployeeName($this->input->post('approver_id'))." संशोधित किया गया|";
					set_leave_log('',$this->session->userdata('emp_id'), $remark_log);
                    $this->session->set_flashdata('update', $this->lang->line('update_message'));
                    redirect('admin/leave_levels');
                }
            }
        }
        if ($edit_id != '') {
            $data['id'] = $edit_id;
        }
        $data['leave_level_lists'] = $this->input->post();
        $data['title'] = $this->lang->line('title');
        $data['title_tab'] = $this->lang->line('leave_levels_lists_title');
        $data['view_file'] = "manage_leave_levels";
        $this->template->index($data);
    }

    /**
     * created by sulbha shrivastava
     * @ Function Name      : delete_unit
     * @ Function Params    : $data {mixed}, $kill {boolean}
     * @ Function Purpose   : add and update unit value
     * @ Function Returns   : insert id
     */
    public function delete_level_lists($delete_id = '') {
        $response = $this->leave_levels_model->delete_level_level($delete_id);
        if ($response) {
            $this->session->set_flashdata('delete', $this->lang->line('delete_message'));
            redirect('admin/leave_levels');
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

}
