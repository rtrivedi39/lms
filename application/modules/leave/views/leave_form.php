<?php $emp_id = $this->session->userdata('emp_id');
	$user_details = $this->leave_model->getSingleEmployee($emp_id);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
      <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $page_title; ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $page_title; ?></h3>
					<div class="pull-right box-tools no-print">
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
					</div>
                </div><!-- /.box-header -->
                <?php echo $this->session->flashdata('message'); //pre($this->input->post()); //pre($emp_detail); pre($emp_more_detail);?>
                  <?php
                     $attributes_modifyleave = array('class' => 'form-leave', 'id' => 'leaveForm', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/addleave', $attributes_modifyleave);
                    ?>  

             
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-12">                           
                                <?php if (isset($user_det->emp_full_name_hi)) { ?>
                                    <div class='alert alert-info'>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <label for="exampleInputEmail1" ><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation'); ?> </label>
                                            </div>
                                            <div class="col-md-6 ">
                                                <b> <?php
                                                    echo isset($user_det->emp_full_name_hi) ?
                                                            get_employee_gender($user_det->emp_id).' '.$user_det->emp_full_name_hi . ' / ' . getemployeeRole($user_det->designation_id) :
                                                            '';
                                                    ?></b>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div> 
                        <hr class="clearfix"/>
                        <div class="form-group col-md-6" >
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('leave_type'); ?> <span class="text-danger">*</span></label>
                            <select class="form-control" name="leave_type" id="leave_type" <?PHP echo set_value('leave_type') ?> >
                                <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                <?php if (isset($user_det->emp_full_name)) { 
                                    if($current_emp_id == '251'){ ?>
                                      <option value="ihpl" ><?php echo $this->lang->line('inform_to_hpl'); ?></option>
                                      <?php } else { ?>
                                    <option  value="cl" <?php
                                    if ($this->input->get('type') == 'cl') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('casual_leave'); ?></option>
                                    <option value="ol" <?php
                                    if ($this->input->get('type') == 'ol') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('optional_leave'); ?></option>
                                    <option value="ihpl" ><?php echo $this->lang->line('inform_to_hpl'); ?></option>
                                    <option value="ot"><?php echo $this->lang->line('official_tour'); ?></option>
                                <?php }
                                } else {
                                    ?>
                                    <option  value="cl" <?php
                                    if ($this->input->get('type') == 'cl') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('casual_leave'); ?></option>
                                    <option value="ol" <?php
                                    if ($this->input->get('type') == 'ol') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('optional_leave'); ?></option>
                                    <option value="el" <?php
                                    if ($this->input->get('type') == 'el') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('earned_leave'); ?></option>
                                    <option value="hpl" <?php
                                    if ($this->input->get('type') == 'hpl') {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $this->lang->line('half_pay_leave'); ?></option>
                                    <option value="ot"><?php echo $this->lang->line('official_tour'); ?></option>
                                    <option value="sl"><?php echo $this->lang->line('special_leave'); ?></option>
                                    <option value="hq"><?php echo $this->lang->line('leave_head_quoter'); ?></option>
                                    <option value="lwp"><?php echo $this->lang->line('leave_without_pay'); ?></option>
                                <?php }
								
                                ?>

                            </select>
                            <?php echo form_error('leave_type'); ?>
                        </div>
                        <div class="form-group col-md-6 "  id="leave_reason_control">

                            <label for="exampleInputEmail1"><?php echo $this->lang->line('leave_reason'); ?> <span class="text-danger">*</span></label>
                            <select class="form-control" name="leave_reason_ddl" id="leave_reason_ddl" <?PHP echo set_value('leave_type') ?> >
                                <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                <?php
                                $leave_resons = leaveReason();
                                foreach ($leave_resons as $leave_reason) {
                                    ?>
                                    <option value="<?php echo $leave_reason; ?>" ><?php echo $leave_reason; ?></option>
                                <?php }
                                ?>

                            </select>
                        </div>

                        <div class="form-group col-md-6 hide_class" id="special_leave_types">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('leave_reason'); ?> <span class="text-danger">*</span></label>
                            <select class="form-control" name="leave_type_sl" id="leave_type_sl" <?PHP echo set_value('leave_type') ?> >
                                <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                <option value="sl"><?php echo $this->lang->line('special_leave'); ?></option>
                                <option value="mat"><?php echo $this->lang->line('maternity_leave'); ?></option>
                                <option value="pat"><?php echo $this->lang->line('paternity_leave'); ?></option>
                                <option value="child"><?php echo $this->lang->line('child_care_leave'); ?></option>
                            </select>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-group col-md-12 cl_reason_other hide_class">
                            <label for="exampleInputFile"><?php echo $this->lang->line('leave_reason'); ?></label>
                            <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Enter ..."><?php echo $this->input->post('reason') != '' ? $this->input->post('reason') : '' ; ?></textarea>
                        </div> 
                        <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $this->uri->segment(3); ?>">
                        <input type="hidden" name="on_behalf_id" id="on_behalf_id" value="<?php echo $this->session->userdata('emp_id'); ?>">


                        <div class="clearfix"></div>
                        <div class="hq_leave_type">
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1"><?php echo $this->lang->line('start_date'); ?> <span class="text-danger">*</span></label>
                                <input type="text"  data-date-format="dd-mm-yyyy"  data-provide="datepicker" name="start_date" id="start_date"  class="form-control datepicker">
                                <?php echo form_error('start_date'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('end_date'); ?> <span class="text-danger">*</span></label>
                                <input type="text" data-date-format="dd-mm-yyyy" name="end_date" id="end_date" class="form-control datepicker">
                                <?php echo form_error('end_date'); ?>
                            </div>  
                        </div> 
                        <div class="clearfix"></div>
                        <div class="<?php
                        if (isset($leave_type)) {
                            if ($leave_type == 'cl') {
                                echo "";
                            } else {
                                echo "hide_class ";
                            }
                        }
                        if ($this->input->get('type') == 'cl') {
                            echo "";
                        } else {
                            echo "hide_class ";
                        }
                        ?> days_deduct " id="daysDeduct">
                            <div class="form-group col-md-9">  
                                <label><?php echo $this->lang->line('deduct_days'); ?></label><br/>
                                <?php foreach (get_weeks(true) as $key => $value) { ?>
                                    <label>
                                        <input type="checkbox" name="days_deduct[]"   value="<?php echo $key; ?> "  class="form">
                                        <?php echo $value; ?> 
                                    </label>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-3">
                                <br/>
                                <button type="button" id="Confirm_deduct" class="btn btn-primary"><?php echo $this->lang->line('confirm_deduct_days'); ?></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1" class="no_of_days_label"><?php echo $this->lang->line('leave_days'); ?> <span class="text-danger">*</span></label>
                            <input type="number"  min="1" name="no_days_other" id="no_days_other" class="form-control <?php
                            if (isset($leave_type)) {
                                if (($leave_type == 'cl') || ($leave_type == 'ol')) {
                                    echo "hide_class";
                                } else {
                                    echo "";
                                }
                            } else if (($this->input->get('type') == 'ol') || ($this->input->get('type') == 'cl')) {
                                echo "hide_class";
                            }
                            ?>">
                            <select name="no_days_ol" id="no_days_ol" class="form-control ol_leave <?php
                            if (isset($leave_type) || ($this->input->get('type') == 'ol')) {
                                if ($leave_type == 'ol') {
                                    echo "";
                                } else {
                                    echo "hide_class";
                                }
                            } else {
                                ?>hide_class <?php } ?>">
                                <option value="">-- <?php echo $this->lang->line('leave_select'); ?>--</option>
                                <option >1</option>
                                <option >2</option>
                                <option >3</option>
                            </select>
                            <select name="no_days_cl" id="no_days_cl" class="form-control cl_leave <?php
                            if (isset($leave_type) || ($this->input->get('type') == 'cl')) {
                                if ($leave_type == 'cl') {
                                    echo "";
                                } else {
                                    echo "hide_class";
                                }
                            } else {
                                ?>hide_class <?php } ?>">
                                <option value="">-- <?php echo $this->lang->line('leave_select'); ?>--</option>
                                <?php
                                $i = .5;
                                while ($i < 8.5) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                    $i = $i + .5;
                                }
                                ?>
                            </select>
                            <input type="hidden" name="days" id="days" value="">								
                            <?php echo form_error('days'); ?> 
                        </div>
                        <div class="form-group col-md-6 cl_leave_days <?php
                        if (isset($leave_type)) {
                            if ($leave_type == 'cl') {
                                echo "";
                            } else {
                                echo "hide_class";
                            }
                        } else {
                            ?>hide_class <?php } ?>">
                            <label for="leave_type" class="radio"><?php echo $this->lang->line('leave_half_type'); ?></label>
                            <label class="radio col-md-6"> <input type="radio" name="half_type" id="first_half" value="FH" ><?php echo $this->lang->line('first_half'); ?></label>
                            <label class="radio col-md-6"> <input type="radio" name="half_type" id="secon_half" value="SH"><?php echo $this->lang->line('second_half'); ?></label>
                            <?php echo form_error('half_type'); ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="<?php
                        if (isset($leave_type)) {
                            if ($leave_type == 'hpl') {
                                echo "";
                            } else {
                                echo "hide_class";
                            }
                        } else {
                            ?> <?php } ?> hpl_leave">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1 " class="headquoter_label"> <?php echo $this->lang->line('for_EL_with_headquarter_permission'); ?></label>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control" name="headquoter" id="headquoter" >
                                    <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                    <option value="1"><?php echo $this->lang->line('yes'); ?> </option>
                                    <option value="2"><?php echo $this->lang->line('no'); ?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="hide_class headquoters_leave ">
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('start_date'); ?> (दिनांक) <span class="text-danger">*</span></label>
                                <input type="text" data-date-format="dd-mm-yyyy" name="hd_start_date" id="hd_start_date"  class="form-control">
                                <label for="exampleInputFile">समय (बजे से ) <span class="text-danger">*</span></label>
								<br/>
								<div class="col-md-4 no-padding">
									<select name="hd_start_date_hour" id="hd_start_date_hour" class="form-control">
										<option value="">घंटे(Min)</option>
										<?php  for($i=1; $i <= 12; $i++){ 													
										//$selected = ($input_data['report_when_go_hour'] != '' && $input_data['report_when_go_hour'] == $i ? 'selected' : '' );?>
											<option value="<?php echo $i; ?>" <?php //echo $selected; ?>><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 no-padding">
									<select name="hd_start_date_minitues" id="hd_start_date_minitues" class="form-control">
										<option value="">मिनट(Min)</option>
										<?php  $i = 00; while( $i <= 55){
											//$selected = ($input_data['report_when_go_minitues'] != '' && $input_data['report_when_go_minitues'] == $i ? 'selected' : '' ); ?>													
											<option value="<?php echo $i; ?>" <?php //echo $selected; ?>><?php echo $i; ?></option>
										<?php $i = $i+5; } ?>
									</select>
								</div>
								<div class="col-md-4 no-padding">
									<select name="hd_start_date_pali" id="hd_start_date_pali" class="form-control">
										<option value="">-समय-</option>
										<option value="AM" >AM</option>
										<option value="PM" >PM</option>
									</select>
								</div>
                                <?php echo form_error('hd_start_date'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('end_date'); ?> (दिनांक) <span class="text-danger">*</span></label>
                                <input type="text" data-date-format="dd-mm-yyyy" name="hd_end_date" id="hd_end_date"  class="form-control">
							<div class="clearfix"></div>
                            <label for="exampleInputFile">समय (बजे तक ) <span class="text-danger">*</span></label>
								<br/>
								<div class="col-md-4 no-padding">
									<select name="hd_end_date_hour" id="hd_end_date_hour" class="form-control">
										<option value="">घंटे(Hrs)</option>
										<?php  for($i=1; $i <= 12; $i++){ 													
										//$selected = ($input_data['report_when_go_hour'] != '' && $input_data['report_when_go_hour'] == $i ? 'selected' : '' );?>
											<option value="<?php echo $i; ?>" <?php //echo $selected; ?>><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 no-padding">
									<select name="hd_end_date_minitues" id="hd_end_date_minitues" class="form-control">
										<option value="">मिनट(Min)</option>
										<?php  $i = 00; while( $i <= 55){
											//$selected = ($input_data['report_when_go_minitues'] != '' && $input_data['report_when_go_minitues'] == $i ? 'selected' : '' ); ?>													
											<option value="<?php echo $i; ?>" <?php //echo $selected; ?>><?php echo $i; ?></option>
										<?php $i = $i+5; } ?>
									</select>
								</div>
								<div class="col-md-4 no-padding">
									<select name="hd_end_date_pali" id="hd_end_date_pali" class="form-control">
										<option value="">-समय-</option>
										<option value="AM" >AM</option>
										<option value="PM" >PM</option>
									</select>
								</div>
                                <?php echo form_error('hd_end_date'); ?>
                            </div>  
                            <div class="form-group col-md-12">
                                <label for="exampleInputFile">कोई रिमार्क  </label>
                                <input type="text"  name="hq_time" id="hq_time"  class="form-control" placeholder="">
                            </div> 
                        </div>	

                        <div class="<?php
                        if ($this->input->get('type') == 'hpl') {
                            
                        } else {
                            echo 'hide_class';
                        }
                        ?> hq_type ">
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile" class="radio"><?php echo $this->lang->line('sickness_date'); ?> (Sickness certificate date) </label>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" data-date-format="dd-mm-yyyy" name="sickness_date" id="sickness_date"  class="form-control">
                                <p class="help-block">जिस दिनांक से आपका मेडिकल है, और जो दिनांक आपके सर्टिफिकेट में है|</p>
                            </div>

                            <hr class="clearfix"/>
                            <div class="form-group col-md-12">
                                <label for="exampleInputFile" class="radio"><?php echo $this->lang->line('leave_header_quoter_leave'); ?> </label>
                            </div>
                            <hr class="clearfix"/>
                            <div class="form-group col-md-12 ">
                                <div class="row">
                                    <div class="radio col-md-6">
                                        <label>
                                            <input type="radio"	name="head_quoter_type" id="general_ground"  value="GG" checked="checked" >
                                            <?php echo $this->lang->line('leave_general_grounds'); ?> 
                                        </label>
                                    </div>
                                    <div class="radio col-md-6">
                                        <label>
                                            <input type="radio" name="head_quoter_type" id="medical_ground" value="MG">
                                            <?php echo $this->lang->line('leave_medical_ground'); ?> 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                       	</div>
                        
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12 el_leave <?php
                        if (isset($leave_type)) {
                            if ($leave_type != 'el') {
                                echo "hide_class";
                            } else {
                                
                            }
                        }if ($this->input->get('type') == 'el') {
                            
                        } else {
                            ?>hide_class <?php } ?>">
                            <label for="exampleInputFile"><?php echo $this->lang->line('leave_address'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter ..."><?php echo $this->input->post('address') != '' ? $this->input->post('address') : '' ; ?></textarea>

                        </div> 

                        <?php if ($this->uri->segment(3)) { ?>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('leave_of_way'); ?></label>
                            </div> 
                            <div class="form-group col-md-6">
                                <div class="row">
                                    <label class="radio col-md-4 email_radio"> <input type="radio" name="leave_way" id="leave_way_email" value="ईमेल" ><?php echo $this->lang->line('leave_of_email'); ?></label>
                                    <label class="radio col-md-4"> <input type="radio" name="leave_way" id="leave_way_msg" value="संदेश" ><?php echo $this->lang->line('leave_of_msg'); ?></label>
                                    <label class="radio col-md-4"> <input type="radio" name="leave_way" id="leave_way_other" value="अन्य"><?php echo $this->lang->line('leave_of_other'); ?></label>
                                </div>
                            </div> 
                            <div class="clearfix"></div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputFile"><?php echo $this->lang->line('leave_of_message'); ?></label>
                                <textarea class="form-control" name="leave_message" id="leave_message" rows="3" placeholder="Enter ..."></textarea>

                            </div>

                        <?php } ?>
                        <hr class="clearfix"/>
                        <div id="pay_rent_box" class="" <?php
                        if ($this->input->get('type') == 'el') {
                            echo "style='display:block'";
                        }
                        ?>>
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('leave_of_pay'); ?><span class="text-danger">*</span></label>
                                <input type="text"  name="pay_grade_pay" id="pay_grade_pay"  class="form-control" value="<?php echo isset($user_details->emp_gradpay) ?  $user_details->emp_gradpay  : '1200+5000' ; ?>">
                                <?php echo form_error('pay_grade_pay'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile"><?php echo $this->lang->line('house_rant'); ?><span class="text-danger">*</span></label>
                                <select name="emp_houserent" id="emp_houserent" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('house_rant'); ?></option>
                                    <?php foreach(employee_grad_pay() as $key=>$value ) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo (isset($user_details->emp_houserent) && $user_details->emp_houserent == $key)  ? 'selected' : ''; ?> ><?php echo $value; ?></option>   
                                    <?php } ?>
                                </select>
                                <?php echo form_error('emp_houserent'); ?>
                            </div>
                        </div>
                         <div class="clearfix"></div>
                        <div class="col-md-12 certificate <?php
							if ($this->input->get('type') == 'hpl' || $this->input->get('type') == 'el') {
								echo "";
							} else {
								echo 'hide_class';
							}
							?>">
							<div class="form-group">
								<label for="exampleInputFile"><?php echo $this->lang->line('leave_upload_medical_file'); ?> (Form - 3) </label>
								<input type="text" name="medical_file_name[]" id="medical_file_name"  class="form-control" value="Form - 3" required>
								<input type="file" name="medical_file[]" id="medical_file" accept=".pdf"   value="Form - 3">
							</div>  
							<div class="form-group">
								<label for="exampleInputFile"><?php echo $this->lang->line('leave_upload_medical_file'); ?> (Form - 4) </label>
								<input type="text" name="medical_file_name[]" id="medical_file_name"  class="form-control" value="Form - 4" required>
								<input type="file" name="medical_file[]" id="medical_file" accept=".pdf"   value="Form - 4">
							</div>  
							<div class="form-group">
								<label for="exampleInputFile"> अन्य दस्तावेज </label>
								<input type="text" name="medical_file_name[]" id="medical_file_name"  class="form-control" value="अन्य" required>
								<input type="file" name="medical_file[]" id="medical_file" accept=".pdf"  value="Other">
							</div>
							<p class="help-block"><?php echo $this->lang->line('mecal_ground_cerfificate_message'); ?></p>
						</div>
						<div class="form-group col-md-12">
							<label for="exampleInputFile"> दस्तावेज </label>
							<input type="text" name="medical_file_name[]" id="medical_file_name" placeholder="दस्तावेज का नाम" class="form-control" value="दस्तावेज" required>
                            <input type="file" name="medical_file[]" id="medical_file" accept=".pdf" >
                            <p class="help-block">यदि कोई दस्तावेज संलग्न  करना हो तो संलग्न  करें</p>
                        </div> 
                    	
						<div class="form-group col-md-12">
							<label>
								<input type="checkbox" name="confirm" id="confirm_chk" /><?php echo $this->lang->line('confimation_fields_message'); ?>
							</label> 
						</div>
					</div> <!-- body-->	
                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit" id="leaveFormSubmit"><?php echo $this->lang->line('submit_botton'); ?></button>
                        <br/><p class="text-danger"><b>* <?php echo $this->lang->line('conpulsary_fileds_meesage'); ?></b></p>
                    </div>
                </form>
            </div><!-- /.box -->
            <div class="alert alert-warning">
                <?php echo $this->lang->line('rule_not_changes_message'); ?>
            </div>
        </div><!-- /.col6 -->
        <?php
                if (($this->uri->segment(2) == 'add_leave' ) && $this->uri->segment(3)) {

                } else {
                    $this->load->view('leave_dashboard');
                }
            ?>
        <div class="col-xs-6">
            
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?php   echo $this->lang->line('calender_time'); ?></h3>					
                </div>
                <div class="box-body">
                    
                    <!--calender start-->
                    <?php
                    /* Set the default timezone */
                    date_default_timezone_set("America/Montreal");
                    /* Set the date */
                    $date = strtotime(date("Y-m-d"));
                    $day = date('d', $date);
                    $month = date('m', $date);
                    $year = date('Y', $date);
                    $firstDay = mktime(0, 0, 0, $month, 1, $year);
                    $title = strftime('%B', $firstDay);
                    $dayOfWeek = date('D', $firstDay);
                    $daysInMonth = cal_days_in_month(0, $month, $year);
                    /* Get the name of the week days */
                    $timestamp = strtotime('next Sunday');
                    $weekDays = array();
                    for ($i = 0; $i < 7; $i++) {
                        $weekDays[] = strftime('%a', $timestamp);
                        $timestamp = strtotime('+1 day', $timestamp);
                    }
                    $blank = date('w', strtotime("{$year}-{$month}-01"));
                    ?>
                    <div align="center"><?php echo $title ?> <?php echo $year ?></div>
                    <table class='table table-bordered' style="table-layout: fixed;"> <tr class="text-center">
                            <?php foreach ($weekDays as $key => $weekDay) : ?>
                                <td style="padding: 2px;background-color: #dcdeed"><?php echo $weekDay ?></td>
                            <?php endforeach ?>
                        </tr>
                        <tr class="text-center">
                            <?php for ($i = 0; $i < $blank; $i++): ?>
                                <td style="padding: 6px"></td>
                            <?php endfor; ?>
                            <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                                <?php $i = strlen($i) == 1 ? '0'.$i : $i ;
                                       $on_date = $year.'-'.$month.'-'.$i;
                                if ($day == $i): ?>
                                    <td style="padding:6px; background: #337ab7; color: #ffffff">
                                        <strong><?php echo $i ?></strong>
                                    </td>
                                <?php elseif(in_array($on_date, holidays(date('Y')))): ?>
                                    <td style="padding:6px; background: red; color: #ffffff" title="<?php echo holidays_name($on_date); ?>">
                                        <strong><?php echo $i ?></strong>
                                    </td>
                                <?php  else: ?>
                                    <td style="padding: 6px"><?php echo $i ?></td>
                                <?php endif; ?>
                                <?php if (($i + $blank) % 7 == 0): ?>
                                </tr><tr class="text-center">
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php for ($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
                                <td style="padding: 6px"></td>
                            <?php endfor; ?>
                        </tr>
                    </table>
                    <!--calender start-->
                </div>
            </div>
        </div>   
    </div><!-- /.row -->
</section><!-- /.content -->
<?php //pr($user_details->emp_houserent); ?>