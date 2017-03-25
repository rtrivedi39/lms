<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rest_api extends MX_Controller {

    function __construct() {
        parent::__construct();
       // $this->load->model('rest_api_model');
		$this->load->model('site/users_model');        
    }
	public function get_allemployee() {
        $employees = $this->rest_api_model->get_allemployee();
      	echo json_encode($employees);
        exit();
    }
   public function check_login( ) 
   {
	 	$this->load->library('user_agent');   
	   if($this->input->get('username')  && $this->input->get('password')  ){		   
	   		$user_id = $this->input->get('username');
		    $password = md5($this->input->get('password'));
			$emp_id 	=   is_numeric($user_id) ? $this->users_model->get_emp_id_unique_id($user_id) : $this->users_model->get_emp_id_user_id($user_id);
	  		$user_data = $this->users_model->get_user_data($emp_id);
		    $is_valid = $this->users_model->validate_user($user_id, $password);
		    if ($is_valid) {
                if ($user_data[0]->emp_status) {
                    if ($user_data[0]->emp_is_retired) {
						$user_data[0]->emp_is_retired;
                        $data = array(
										'success' => "False",
										'message' => "आप रिटायर्ड हो गए है| आप लॉग इन नहीं कर सकते"
									 );
						echo json_encode($data);
        				exit();
                        
                    } else {
                        $data = array(
                            'user_id' => $user_id,
                            'user_role' => $user_data[0]->role_id,
                            'user_designation' => $user_data[0]->designation_id,
                            'emp_id' => $user_data[0]->emp_id,
                            'emp_unique_id' => $user_data[0]->emp_unique_id,
                            'emp_full_name' => $user_data[0]->emp_full_name,
                           	'emp_image' => $user_data[0]->emp_image,
							'success' => 'True'
                        );
                       
                        $this->session->set_userdata($data);  
                        $this->users_model->user_login_log(); 
                     	echo json_encode($data);
        				exit();
                    }
                } else {
						$data = array(
										'success' => "False",
										'message' => "not a active user"
									 );
                    	echo json_encode($data);
        				exit();
                }
            } else { // incorrect username or password
               $data = array(
										'success' => "False",
										'message' => "प्रशासन लॉगिन आईडी और पासवर्ड हमारे रिकॉर्ड में मौजूद नहीं है"
									 );
                	echo json_encode($data);
        			exit();
               
            }
	   }
	}
  
   public function leave_status()
   {
	   if($this->input->get('emp_id') && $this->input->get('year')  ){
		   $this->load->model("leave/leave_model");	
		   $leave_balance = $this->leave_model->getLeaves($this->input->get('emp_id'));
		   $total_leave_balance = array('total_leave_balance' => count($leave_balance)>0 ?$leave_balance :"NULL" ) ;
		   $leaves_pending = $this->leave_model->get_leaves('pending','',$this->input->get('emp_id'));
          
		   $leaves_approve_deny_cancel = $this->leave_model->get_leaves('leaves_approve_deny_cancel','',$this->input->get('emp_id'),$this->input->get('year') );
		   $panding_leave = array('leaves_pending'=> count($leaves_pending)>0 ?$leaves_pending:'NULL' );
		   $leaves_approve_deny_cancel = array('leaves_approve_deny_cancel' =>count($leaves_approve_deny_cancel)>0 ?$leaves_approve_deny_cancel:'NULL' );
		   $leave_status = array_merge($total_leave_balance,$panding_leave,$leaves_approve_deny_cancel );
		  // pr( $leave_status);
		   echo json_encode( $leave_status);
		   exit();
	   }
   }
	public function leave_apply()
	{
		//echo "sulbha enter in a funtion ";
		$id = $this->input->get('emp_id'); //  && $this->input->get('start_date') && 	 $this->input->get('end_date') && $this->input->get('no_days_other') 
		 if($this->input->get('leave_type') && $this->input->get('leave_reason_ddl') && $this->input->get('start_date')&& $this->input->get('end_date')
			&& $this->input->get('day') && $this->input->get('headquoter')&& $this->input->get('emp_id')
		)
		 {
			
			$this->load->model("leave/leave_model");	
			$this->load->helper('leave_helper');
		
		 	if(date('m',strtotime($this->input->get('start_date'))) == '12' && $this->input->get('days') > 2  && $this->input->get('leave_type') == 'cl')
			{
           		$data = array(
							'success'=>'False',
							'message'=> 'आप इस माह में दो से अधिक आकस्मिक अवकाश आवेदन नहीं कर सकते|'
						);
				echo json_encode($data);
				exit();
			
        	}        
       		else{
				
			$emp_id_exits = $this->input->get('emp_id') ;
			$leave = $this->leave_model->is_leave_exits($emp_id_exits ,$this->input->get('start_date'), $this->input->get('end_date'), $this->input->get('leave_type') );
			
			 if($this->input->get('leave_type') == 'cl' || $this->input->get('leave_type') == 'ol'){
				// check leave type exists or not
				if( $this->leave_model->is_leave_exits($emp_id_exits ,$this->input->get('start_date'), $this->input->get('end_date'), $this->input->get('leave_type') )){
					$data = array(
							'success'=>'False',
							'message'=> 'इस आवेदन की प्रविष्टि उपलब्ध है| कृपया दोबारा न करें|'
						);
					echo json_encode($data);
					exit();
				}
				
				// check leave after date  (Can't apply cl-ol continues to el-hpl)
				else if( $this->leave_model->check_leave_date_after($emp_id_exits ,$this->input->get('start_date'), true )){
					
					$data = array(
							'success'=>'False',
							'message'=> 'अर्जित या मेडिकल के बाद सी.एल. या ओ. एल. अवकाश आवेदन नहीं कर सकते|'
						);
					echo json_encode($data);
					exit();
				} 
				//check leave exists before holiday 
				else if( $this->leave_model->is_leave_exits_before_holiday($emp_id_exits ,$this->input->get('start_date'),true )){
					
					$data = array(
							'success'=>'False',
							'message'=> 'अर्जित या मेडिकल के बाद सी.एल. या ओ. एल. अवकाश आवेदन नहीं कर सकते|'
						);
					echo json_encode($data);
					exit();
				}
				 else{
				$whos_emp = !empty($this->input->get('emp_id')) ? $this->input->get('emp_id') : $this->session->userdata('emp_id');
				$_leave_type = $this->input->get('leave_type') == 'sl' ? $this->input->get('leave_type_sl') : $this->input->get('leave_type') ; 
				
				$leave_type = in_array($_leave_type, array('hq','ihpl','sl','jr','lwp')) ? 'other' : $_leave_type ; 
				
				$column_name = $leave_type . '_leave';
				if (!empty($this->input->get('emp_id'))) {
					
				// get remaning leave which are applied and approve or not approve both
                $leave_rem = $this->leave_model->get_remaining_leaves($this->input->get('emp_id'),$this->input->get('leave_type'),$this->input->get('head_quoter_type'));
            
				// if remaining leave less than leaves set message
					if ($leave_rem < $this->input->get('day')) {
					   $data = array(
								'success'=>'False',
								'message'=> 'आपके खाते में इस अवकाश का पर्याप्त बैलेंस नहीं है|'
							);
						echo json_encode($data);
						exit();
						
					} else {
							
                    	$data_date = array();
						if($this->input->get('leave_type') == 'cl' || $this->input->get('leave_type') == 'ol' || $this->input->get('leave_type') == 'el' || $this->input->get('leave_type') == 'hpl'){
							$leave_remaining = get_leave_balance($whos_emp, $this->input->get('leave_type'));
						} else {
							$leave_remaining = 0;
						}
						
					//print_r($leave_remaining);
							
					$data_all = array(
                        'emp_id' => !empty($this->input->get('emp_id')) ? $this->input->get('emp_id') : $this->session->userdata('emp_id'),
                        'emp_leave_type' => $_leave_type,
                        'emp_leave_no_of_days' => $this->input->get('day'),
                        'emp_leave_date' => date('Y-m-d', strtotime($this->input->get('start_date'))),
                        'emp_leave_end_date' => date('Y-m-d', strtotime($this->input->get('end_date'))),
                        'emp_leave_is_HQ' => $this->input->get('headquoter'),
                        'emp_leave_half_type' => $this->input->get('half_type') != '' ?$this->input->get('half_type') : null,
                        'emp_leave_address' => $this->input->get('address') != '' ? $this->input->get('address') : null,
                        'on_behalf_leave' => $this->input->get('emp_id'),
                        'leave_apply' => $this->input->get('leave_way') != '' ?  $this->input->get('leave_way') : null,
                        'leave_message' => !empty($this->input->get('hq_time')) ? $this->input->get('hq_time') : $this->input->get('leave_message'),
                        'type_of_headquoter' => $this->input->get('head_quoter_type'),
                        //'medical_files' => $upload_data != ''  ? $upload_name : '' ,
                        'emp_leave_HQ_start_date' => $this->input->get('hd_start_date') != null ? date('Y-m-d', strtotime($this->input->get('hd_start_date'))) : null,
                        'emp_leave_HQ_end_date' => $this->input->get('hd_end_date') != null ? date('Y-m-d', strtotime($this->input->get('hd_end_date'))) : null ,
                        'sickness_date' => !empty($this->input->get('sickness_date')) ? date('Y-m-d', strtotime($this->input->get('sickness_date'))) : null,
						'leave_remaining' => $leave_remaining,
						'emp_leave_sub_type' => $this->input->get('leave_sub_type') != null ? $this->input->get('leave_sub_type') : null,
                    );
					
                    
                    $data = array_merge($data_date, $data_all);

                   //pr(  $data);

                    if ($this->input->get('leave_reason_ddl') != $this->lang->line('leave_reason_other')) {
                        $msg_ld = '';
						if($this->input->get('leave_sub_type') == 'ld'){
							$data_ld = array(
								 'report_type'    => 'l',
								 'report_month'   => get_date_formate($this->input->get('start_date'),'m'),
								 'report_year'    => get_date_formate($this->input->get('start_date'),'Y'),
								 'report_status'  => 1,
							 );
							
							$data_list = get_list(BIOMETRIC_REPORT, null , $data_ld);								
							if(!empty($data_list)){
								$document = $data_list[0]['report_doccument'];
								$msg_ld = '<a href="'.base_url().'uploads/report/'.$document.'">विलम्ब रिपोर्ट देखें|</a>';
							}else{
								$msg_ld = '';
							}
						}
						$emp_leave_reason = $this->input->get('leave_reason_ddl').''.$msg_ld;
                    } else {
                        $emp_leave_reason = $this->input->get('reason');
						
                    }
					  $data['emp_leave_reason'] = $emp_leave_reason ;
					  $response = $this->leave_model->insert_leave($data);
						if($response){
							$leave_movement_id = $response;
							$dervice_array = $this->save_device_values();
							$leave_prakar = leaveType($this->input->get('leave_type'), true);
							$leave_remark = $this->input->get('day') .' दिन का '.$leave_prakar.' अवकाश का आवेदन किया गया';
							set_leave_log($leave_movement_id,$this->input->get('emp_id'), $leave_remark,'',$dervice_array);
							$json_data = array('success' => "True");
							echo json_encode($json_data);
							exit();
					 		
						}
					}
                }
			}
			// if own leave apply
            }
				// if other employee leave apply
			}
		 }else{
		       $data = array(
								'success'=>'False',
								'message'=> 'Please send proper perameter for devloper'
							);   
		        echo json_encode($data);
							exit();
		 
		 }
	}
	public function save_device_values()
	{ 
		
		 if($this->input->get('model') && $this->input->get('platform') && $this->input->get('uuid') && $this->input->get('version')
			&& $this->input->get('serial'))
		{
			
			
		 	$data = array(
							//'cordova'=>$this->input->get('cordova'),
							'model'=>$this->input->get('model'),
							'platform'=>$this->input->get('platform'),
							'uuid'=>$this->input->get('uuid'),
							'version'=>$this->input->get('version'),
							//'manufacturer'=>$this->input->get('manufacturer'),
							//'isVirtual'=>$this->input->get('isVirtual'),
							'serial'=>$this->input->get('serial'),
					);
			
			return serialize($data); 
		 }
	}
	public function leave_forword(){
		if($this->input->get('leaveID') && $this->input->get('emp_id')){
			$this->load->model("leave/leave_model");	
			$this->load->helper('leave_helper');
			$leave_id = $this->input->get('leaveID') != '' ? $this->input->get('leaveID') : $leave_id;
			$person_name = $this->input->get('onleave_work_allot') != '' ? $this->input->get('onleave_work_allot') : '';

			$leave = $this->leave_model->getLeave($leave_id);
			$emp_id = $leave->emp_id;
			$type = $leave->emp_leave_type;
			$days = $leave->emp_leave_no_of_days;
			//deductLeave($emp_id , $type ,$days );

			$data = array(
				'emp_leave_forword_emp_id' => $this->input->get('emp_id'),
				'emp_leave_forword_type' => '1',
				'emp_leave_forword_date' => date('Y-m-d H:i:s'),
				'emp_onleave_work_allot' => $person_name,
			);
			$response = $this->leave_model->updateLeave($leave_id, $data);
			if ($response) {
				$teep = $person_name != null ? 'अवकाश काल मे आपका  कार्य '. $person_name. ' के द्वारा किया जायेगा|' : null ;
				$dervice_array = $this->save_device_values();
				set_leave_log($leave_id,$this->input->get('emp_id'),' अवकाश अग्रेषित  किया गया ', $teep,$dervice_array);
				$json_data = array('success' => "True");
				echo json_encode($json_data);
				exit();
				
			}
		}
	}
	public function leave_forword_list(){
		if($this->input->get('emp_id')){
				$this->load->model("leave/leave_model");	
				$this->load->helper('leave_helper');
				$details_leave = $this->leave_model->get_allforword_lists('','',$this->input->get('emp_id'));
				print_r($details_leave);
				echo json_encode($details_leave);
				exit();
				
			}
		
	}
	public function leave_approve($leave_id = '', $isreturn = false) {	
		if($this->input->get('leaveID') && $this->input->get('emp_id') ){
			$this->load->model("leave/leave_model");	
			$this->load->helper('leave_helper');
			$leave_id = $this->input->get('leaveID') != '' ? $this->input->get('leaveID') : $leave_id;
			$approve_reson = $this->input->get('approve_reson') != '' ? $this->input->get('approve_reson') : '';
			$leave = $this->leave_model->getLeave($leave_id);
			$emp_id = $leave->emp_id;
			$type = $leave->emp_leave_type;
			$days = $leave->emp_leave_no_of_days;
			$headquoter_type = $leave->type_of_headquoter;
			$sickness_date = $leave->sickness_date;
			$date = $leave->emp_leave_date;
			if(( $type == 'hpl' || $type == 'el') && $this->leave_model->is_leave_exits_ondate($emp_id, $date)){
				$leave_data =  $this->leave_model->is_leave_exits_ondate($emp_id, $date, true);
				// pr($leave_data);
				$response =  $this->leave_model->update_leave_exists($leave_data);
				if(($date == $sickness_date && $type == 'hpl') || $type == 'el'){
					deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
					$type_name = leaveType($type, true);
					$update_data = array(
						'emp_leave_deny_reason' => $approve_reson."(यह अवकाश $type_name में परिवर्तन किया गया)",
					);
					$this->leave_model->updateLeave($leave_id, $update_data); 
					$this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
				}else if(($date != $sickness_date && $type == 'hpl')){
					$this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
					$this->calculation_sickness($date,$sickness_date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
					deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
				}
			}else if(($type == 'hpl' || $type == 'el') && !$this->leave_model->is_leave_exits_ondate($emp_id, $date)){
				if(($date == $sickness_date && $type == 'hpl') || $type == 'el'){
					$this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
					deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
				}else if(($date != $sickness_date && $type == 'hpl')){
				   $this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
				   $this->calculation_sickness($date,$sickness_date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
				   deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
				}
			} else{			
			   deductLeave($emp_id, $type, $days, $headquoter_type, $leave); 
			} 

			$last_order_number = last_order_number();
			$data = array(
				'emp_leave_approval_emp_id' => $this->input->get('emp_id'),
				'emp_leave_approval_type' => '1',
				'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
				'leave_status' =>  9,
				'emp_leave_deny_reason' => $approve_reson,
				'leave_order_number' => $last_order_number + 1,
			);

		   $response = $this->leave_model->updateLeave($leave_id, $data);
		   if ($response) {
				$empdetails = empdetails($emp_id);
				//$type = $type == 'ihpl' ? 'leave information' : $type;
				$leave_sub_type = $leave->emp_leave_sub_type;
				if($leave_sub_type == 'ld'){
					$month = ltrim(get_date_formate($leave->emp_leave_date,'m'),0);
					$month_name = months($month,true);
					$msg = leave_deduction_sms($type,$days);
					//$msg = 'कार्यालय में विलम्ब से आने के कारण '.$month_name.' माह में अवकाश कटोत्रा किया गया| विलम्ब रिपोर्ट देखें|';
				} else {
					 //$msg = "आपका ".leaveType($type,true)." दि. ". get_date_formate($date,'d/m/y')." से ".get_date_formate($leave->emp_leave_end_date,'d/m/y')." तक स्वीकृत किया गया";
					$msg = "Your ".strtoupper($type)." from ".get_date_formate($date,'d/m/Y')." to ".get_date_formate($leave->emp_leave_end_date,'d/m/Y').", $days day(s) has been approved.";
				}

				//$result = send_sms('9425424554' ,$msg, true);
				if($empdetails[0]['emp_mobile_number'] != '' && $empdetails[0]['emp_mobile_number'] != 0 && $type != 'ihpl' && $type != 'jr' ){
					//send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true); // for unicode
					send_sms($empdetails[0]['emp_mobile_number'] ,$msg); // for normal
				}
				set_leave_log($leave_id,$this->session->userdata('emp_id'),' अवकाश स्वीकृत किया गया', $approve_reson);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
		   }
		   if($isreturn){
			   return true;
		   }else {
			   redirect($_SERVER['HTTP_REFERER']);
			   //redirect('leave/leave_approve');
		   }
		}
    }
    public function get_employees_birthdays()
	{
		
		$today_birthday = get_employees_brthdays('yes');
		$birth_today = array('today_birthday' => $today_birthday );
		if(count($today_birthday) > 0 ){
			$data = array(
							'success'=>'True',
							//'message'=> 'Please send proper perameter for devloper'
						);   
			$birhtday_array = array_merge($todat_birthday , $data);
			echo json_encode($birhtday_array);
			exit();
		}else
		{
			$birth_today = array('today_birthday' => null );
			echo json_encode($birth_today);
			exit();
		}
			
	}
	public function get_employees_leaves()
	{
		$this->load->helper('leave_helper');
		$leave_today = user_leave_today('','');
		$today_leave = array('leave_today' => $leave_today );
		if(count($leave_today) > 0 ){
			$data = array(
							'success'=>'True',
							
						);   
			$leave_array =	array_merge($today_leave , $data);
			echo json_encode($leave_array);
			exit();
		}else
		{
			$today_leave = array('leave_today' => NULL );
			echo json_encode($today_leave);
			exit();
		}
		
	}

	public function get_unis_bio_report($date ,$type)
	{
		$this->load->model('unis_bio_report/unis_bio_report_model', 'bio_report');		
		$get_report= $this->bio_report->get_report_date($date,$type);
		if(count($get_report) > 0 ){
			$data = array(
					'success'=>'True',
				); 
			echo json_encode($get_report);
			exit();
		}else{
			$get_report = array('get_report' => NULL ); 
			echo json_encode($get_report);
			exit();
		}
	}
	
	
}
