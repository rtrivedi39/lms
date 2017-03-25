<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Oder_sing extends MX_Controller {
    function __construct() {
        parent::__construct();
         $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_details', 'hindi');
        $this->load->model("oder_model");
			  $this->load->model('efile_list_model');  //,'efile_model'
        $this->load->helper('leave_helper');
		  $this->load->helper('text_helper');$this->load->helper('common_helper');
        authorize();
    }
	public function index()
	{
	echo "adas";
	}
	
	public function sign_order($show_all = '0'){
		
		
	$emp_role_lvl= get_emp_role_levele();
		$data['login_emp_level']=$emp_role_lvl;
	  $data['title'] = $this->lang->line('order_title');
        $data['title_tab'] =  $this->lang->line('order_title');
        $data['module_name'] = "leave";
		$employees_class = $emp_unique_id =  '';
		if($show_all == '0'){
			$date = date('Y-m-d');
		} else if($show_all == '1'){
			$date = null;
		}else if ($show_all == 'date') {
			$date = date('Y-m-d',strtotime($this->input->post('order_date')));
			if ($this->input->post('order_date') == '') {		
				$date = null;		
			}			
		}
		if ($this->input->post('employees_class') != '') {
			$employees_class = $this->input->post('employees_class');			
		}
		if ($this->input->post('emp_unique_id') != '') {
			$emp_unique_id = $this->input->post('emp_unique_id');			
		}		
		
        $data['leave_order_lists'] = $this->oder_model->ordering();
		if($this->uri->segment(3) == "singorder"){
        $data['view_file'] = "oder_sing/leave_order1";
		}else{
			    $data['view_file'] = "oder_sing/leave_order";
			
		}
        $this->template->index($data);
	}
	function check_digitally_sign_or_not(){
		$i=0;
        $j=0;
        $k=0;
        $post_data_array=array();
		$post_data_array_b=array();
		//pre($this->input->post());
        foreach($this->input->post() as $ky=>$val){
            if($ky=='ck_file_id'){
			   $total_post = count($val);
               foreach($val as $fky=>$value1){
					$post_data_array[$j][$ky]=$value1;
					$file_ley[]=$fky;
                    $j++;
               }
            }			              
            $i++;
        }
		$draft12 = array_keys($this->input->post('draft_log_id'));
		$checkdraft12 = array_keys($this->input->post('ck_file_id'));
		$checkval = array_intersect($draft12,$checkdraft12);
		foreach($checkval as $keyr => $checkval1){
		    $draft_log_id1 = $this->input->post('draft_log_id');		   
			$post_data_array_b[] = $draft_log_id1[$checkval1];			
			/*Draft signing content*/			
			$draft_content_md5_row = $this->input->post('file_param1');		   
			$draft_content_md5_aray[] = "'".$draft_content_md5_row[$checkval1]."'";
		}
		/*pre($post_data_array_b);		
		$draft_log_id= implode(',',$post_data_array_b);
		$draft_sign_list = get_list_with_in('ft_digital_signature',null,'ds_draft_log_id',$draft_log_id);
		echo count($draft_sign_list);
		*/
		
		$draft_log_id= implode(',',$post_data_array_b);		
		$draft_content_md5_str= implode(',',$draft_content_md5_aray);
		//$draft_sign_list = get_list_with_in('ft_digital_signature_b',null,'ds_local_data',$draft_content_md5_str);
		$ds_sql="SELECT COUNT(ds_id) as total_sign_data FROM (`ft_leave_digital_signature`) WHERE `ds_local_data` IN ($draft_content_md5_str) AND ds_draft_log_id IN ($draft_log_id)";
		$draft_sign_list = get_row($ds_sql);
		echo $draft_sign_list['total_sign_data'];		
	}
	public function post_multi_signature(){
        //pre($this->input->post());
        $i=0;  $j=0; $k=0;
        $post_data_array=array();
		$checked_row_id  = array_keys($this->input->post('ck_file_id'));

		$content_row_id  = array_keys($this->input->post('file_param1'));


		$ck_file_id = $this->input->post('ck_file_id');

		$section_id = 7;

		$up_down = 0;

		$empid = $this->input->post('file_param4');

		$signing_content = $this->input->post('file_param1');

		$file_status = $this->input->post('file_status');

		$draft_log_id = $this->input->post('file_param2');

		$file_param1 = $this->input->post('file_param1');
		$file_param2 = $this->input->post('file_param2');
		$file_param3 = $this->input->post('file_param3');
		$file_param4 = $this->input->post('file_param4');
		/*Common*/
		$checkval = array_intersect($checked_row_id,$content_row_id);
		
		/*File ID*/
		foreach($checkval as $keyr => $checkval1){
			//FileId
			$post_data_array_b[$keyr]['ck_file_id'] = $ck_file_id[$checkval1];
			/*Section Id*/
			$post_data_array_b[$keyr]['section_id'] = 7;
			/*File up_down*/
			$post_data_array_b[$keyr]['up_down'] = "leave";
			/*empid*/
			$post_data_array_b[$keyr]['empid'] = $empid[$checkval1];
			/*file_status*/
			$post_data_array_b[$keyr]['file_status'] = $file_status[$checkval1];
			/*draft_log_id*/
			$post_data_array_b[$keyr]['draft_log_id'] = $draft_log_id[$checkval1];
			/*Signing Contant*/
			$post_data_array_b[$keyr]['signing_content'] = $signing_content[$checkval1];
			/*file_param1*/
			$post_data_array_b[$keyr]['file_param1'] = $file_param1[$checkval1];
			/*file_param2*/
			$post_data_array_b[$keyr]['file_param2'] = $file_param2[$checkval1];
			/*file_param3*/
			$post_data_array_b[$keyr]['file_param3'] = $file_param3[$checkval1];
			/*file_param4*/
			$post_data_array_b[$keyr]['file_param4'] = $file_param4[$checkval1];
		}		
		
		
		//pr($post_data_array_b);
		echo json_encode($post_data_array_b);		
	}
	
	 public function ajax_count_inbox_second($is_retur=false){
      $inbox1 = 23;//$this->oder_model->count_inbox();
      $wip1 = 34;//$this->oder_model->count_wip();
      $sent1 = 45;//$this->oder_model->count_sent();
        $ibox=array($wip1['wipefile'],$inbox1['inbox'],$sent1['sent_efile']);/*working,inbox,sent*/
        if($is_retur==false){
            echo json_encode($ibox);
        }else{
            return json_encode($ibox);
        }
    }//print el hpl order after approve
    function print_order($id, $saved = false) {
        if ($id != '') {
            $leave_details = $this->oder_model->getLeaves($id);
            if (!empty($leave_details)) {
              $file_name = 'order';
            }
            $data['module_name'] = "leave";
            $data['view_file'] = "leave/print_leave/order_sing" ;
            $data['leave_details'] = $leave_details;
			$data['is_saved'] = $saved;
            $data['title'] = $this->lang->line('print');
            $this->template->index($data);
        } else {
            $this->index();
        }
    }public function ajax_count_inbox($is_retur=false){
		//$emp_role_lvl= get_emp_role_levele(); 
		
		$file_working_array=$this->oder_model->count_geteFiles($section_explode=null, $moveup_down=null,$section_id_search=null,'working');/*working*/		
		$total_working= $file_working_array;/*working*/		
	//	pr($file_working_array);
		
		$sent_file_array = $file_working_array;/*Sent*/
		$total_sent= $file_working_array;/*Sent*/
		
		$ibox=array($total_working,$inbox,$total_sent,);/*working,inbox,sent*/		
		if($is_retur==false){
			echo json_encode($ibox);
		}else{
			return json_encode($ibox);
		}
		//$this->output->set_content_type('application/json')->set_output(json_encode($ibox));
	}
	
}