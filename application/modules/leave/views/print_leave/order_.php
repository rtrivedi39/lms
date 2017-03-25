
<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>leave/"><i class="fa fa-index"></i> Leave</a></li>
        <li class="active">Print</li>
    </ol>
</section>
<?php
$emp_details = get_list(EMPLOYEES,null,array('emp_id'=>$this->session->userdata("emp_id"))); 
$userrole = checkUserrole();

$depart = 'म.प्र. शासन विधि और विधायी कार्य विभाग, भोपाल';
$now = date('d/m/Y');
$user_details = get_user_details($leave_details->emp_id);
$emp_detail_gender = $user_details[0]->emp_detail_gender;
if($emp_detail_gender == 'm'){
	$emp_detail_gender = 'श्री';
}else{
	$emp_detail_gender = 'सुश्री';
}
$emp_full_name = $emp_detail_gender.' '.$user_details[0]->emp_full_name_hi;

$final_order_number =  '..............' ;
if($leave_details->leave_order_number != null){
	$final_order_number = $leave_details->leave_order_number.'-'.strtoupper($leave_details->emp_leave_type).'/'.get_date_formate($leave_details->emp_leave_approvel_date,'Y').'/'.$user_details[0]->	emp_unique_id;
}

 
//pr($user_details);
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="no-print">  
                <p class="alert alert-info">
                    प्रिंट निकालने के लिए 'प्रिंट' का बटन दबायें, और प्रिंट की कॉपी यदि आवश्यक हो तो स्थापना शाखा में जमा करें|</p>      
            </div> 
            <div style="border:1px dashed #333; padding:20px; font-size:16px; line-height:24px;" id="ordrer">  
                <?php $details = get_section_employee(7,8); 
                foreach($details as $row){
                    $emp_name =  $row->emp_full_name_hi;
                } 
                ?>
                <div class="row" >          
                    <div class="col-md-12 text-center">
                        <h3><?php echo $depart; ?></h3>
                        <h4>// आदेश //</h4>      
                        <label> --------- </label>
                    </div>
                </div>      
                <div class="row">          
                    <div class="col-md-12 text-left">
                        <table class="table borderless">
                            <tr><td class="text-right">भोपाल दिनांक <?php echo get_date_formate($leave_details->emp_leave_approvel_date,'d.m.Y'); ?></td></tr>
                            <tr>
                                <td>
                                    <p>
                                        क्रमांक <?php echo $final_order_number; ?>/21-अ(स्था.)  <b><?php echo $emp_full_name.', '.$user_details[0]->emprole_name_hi; ?></b> को दिनांक <?php echo get_date_formate($leave_details->emp_leave_date,'d.m.Y'); ?>
                                        से <?php echo get_date_formate($leave_details->emp_leave_end_date,'d.m.Y'); ?> दिनांक तक कुल <b><?php echo $leave_details->emp_leave_no_of_days; ?></b> दिवस का  <b><?php echo leaveType($leave_details->emp_leave_type, true); ?></b>
                                        <?php echo ($leave_details->emp_leave_is_HQ) == 1 ? 'मुख्यालय छोड़ने की अनुमति सहित' : ''; ?> स्वीकृत किया जाता है|
                                    </p>
                                    <p class="indent">
                                        उक्त अवकाश स्वीकृति उपरांत उन्हें दिनांक <?php 
										$leave_session_m =  get_date_formate($leave_details->emp_leave_date,'m');
										$leave_session_y =  get_date_formate($leave_details->emp_leave_date,'Y');
										$rem_laves = $leave_details->leave_remaining != 0 ? ($leave_details->leave_remaining - $leave_details->emp_leave_no_of_days) : null ;
										if($leave_details->emp_leave_type == 'el'){
											$leave_order_bal = $rem_laves != null ?  calculate_el($rem_laves) : calculate_el(get_leave_balance($user_details[0]->emp_id, 'el'));
											if($leave_session_m > 6){
												echo  '31.12.'.$leave_session_y;
												echo ' तक  '; 
												echo $leave_order_bal;
											} else{
												echo  '30.06.'.$leave_session_y;
												echo ' तक  '; 
												echo $leave_order_bal;
												
											}
										} else if($leave_details->emp_leave_type == 'hpl'){
											  echo  '31.12.'.$leave_session_y;
											  echo ' तक  '; 
											  echo $rem_laves != null ?  $rem_laves : get_leave_balance($user_details[0]->emp_id, 'hpl');
										}						
																						
                                        ?> दिवस के 
                                        <b><?php echo leaveType($leave_details->emp_leave_type, true); ?></b> की पात्रता रहेगी |
                                    </p>
                                    <p class="indent">
                                        प्रमाणित किया जाता है की यदि  <b><?php echo $emp_full_name.', '.$user_details[0]->emprole_name_hi; ?></b>, अवकाश पर नहीं जाते तो अपने पद पर कार्य करते रहते |
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td>
								<?php if($leave_details->emp_leave_approval_emp_id == 2) {?>
										(प्रमुख सचिव विधि द्वारा अनुमोदित)
								<?php } else {
									echo '(सचिव विधि द्वारा अनुमोदित)';
								} ?>
                                </td>
                            </tr>
                            
							<tr><td>&nbsp;</td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;">(<?php echo $emp_name ; ?>)</div></td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;">प्रशासकीय अधिकारी</div></td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;"><?php echo $depart; ?></div></td></tr>
                            <br/>
                            <tr>
                                <td>प्र. क्रमांक <?php echo $final_order_number ; ?>/21-अ(स्था.)</td>
                            </tr>
                            <tr>
                                <td class="text-right">भोपाल दिनांक <?php echo get_date_formate($leave_details->emp_leave_approvel_date,'d.m.Y'); ?></td>
                            </tr>
                            <tr>
                                <td>1.  <b><?php echo $user_details[0]->emp_full_name_hi; ?>, <?php echo getemployeeRole($user_details[0]->role_id); ?></b>, 
								<?php  echo $leave_details->emp_leave_deny_reason != null ? $leave_details->emp_leave_deny_reason : ''; ?> </td>
                            </tr>
                            <tr>
                                <td>2. पे-लिपिक,</td>
                            </tr>
                            <tr>
                                <td>की ओर सूचनार्थ एवं आवश्यक कार्यवाही हेतु |</td>
                            </tr>
							
                            <tr><td>&nbsp;</td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;">(<?php echo $emp_name ; ?>)</div></td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;">प्रशासकीय अधिकारी</div></td></tr>
                            <tr><td align="right"><div style="width:50%; text-align:center;"><?php echo $depart; ?></div></td></tr>
                        </table>
                    </div>
                </div>   
            </div>
            <div class="row no-print">   
                <hr/>       
                <div class="col-md-3 text-center">
                    <button type="button" onclick="printContents('ordrer')" class="btn btn-primary" name="">प्रिंट करे</button>
                </div>
                <div class="col-md-3 text-center">
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
                </div>
				<?php  /*if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 || $userrole == 11 || (enable_order_gen($current_emp_id) == true) ){?>
				<form action="<?php echo base_url().'leave/genrate_order/'.$leave_details->emp_leave_movement_id ; ?>" method="post">
					<div class="col-md-3 text-center">
						<input type="text"  id="order_number" class="form-control" name="order_number" placeholder="Enter order number here" value="<?php echo $leave_details->leave_order_number != null ? $leave_details->leave_order_number : '' ; ?>" required>
					</div>
					<div class="col-md-3 text-center">
						<button type="submit" name=""  class="btn btn-primary" value= "">Genrate order</button>
					</div>
				</form>
				<?php } */?>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->


