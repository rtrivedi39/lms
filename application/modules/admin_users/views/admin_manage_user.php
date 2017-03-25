<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
      <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('admin'); ?>/sections">Employees</a></li>
        <li class="active"><?php echo $page_title; ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div style="float:left"><h3 class="box-title"><?php echo $page_title; ?></h3></div>
                    <?php if ($is_page_edit == 0) { ?>
                        <div style="float:right">
                            <a href="<?php echo base_url('admin'); ?>/add_employee">
                                <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?></button>
                            </a>
                        </div>
                    <?php } ?>
                    <div style="float:right;margin-right: 10px;">
                        <a href="javascript:history.go(-1)">
                            <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <?php echo $this->session->flashdata('message'); //pre($this->input->post()); pre($emp_detail); pre($emp_more_detail); ?>
                <form role="form"  enctype="multipart/form-data" method="post" action="<?php echo base_url() ?>admin_users/manage_user<?php if (isset($id)) {
                    echo '/' . $id;
                } ?>">
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <div class="box-body">							 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">क्या कर्मचारी भोपाल में कार्यरत हैं ?  <span class="text-danger">*</span></label>
                                    <select class="form-control" name="emp_posting_location" required>
                                        <option value="">Select</option>                                            
												<option value="1" <?php if($emp_detail['emp_posting_location']==1){ echo 'selected';} ?>> हाँ </option>
												<option value="0" <?php if($emp_detail['emp_is_retired']!="" && $emp_detail['emp_posting_location']==0){ echo 'selected';} ?>> नहीं </option>
                                    </select>
                                    <?php echo form_error('emp_is_retired'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_designation_id_label'); ?> <span class="text-danger">*</span></label>
                                    <?php if ($id) {
                                        $emp_roles = get_list(EMPLOYEEE_ROLE, null, null);
                                    } else { ?>
                                            <?php $emp_roles = get_employe_role_designatio();
                                        } //pre($emp_roles);?>
                                    <select class="form-control" name="designation_id" id="designation_id">
                                        <option value=""><?php echo $this->lang->line('emp_designation_select_label'); ?></option>
                                            <?php foreach ($emp_roles as $empk => $emprolse) { ?>
                                                <?php 
                                                    if (is_array($emprolse)) { ?>
                                                        <option value="<?php echo $emprolse['role_id']; ?>" <?php if (@$emp_detail['designation_id'] == $emprolse['role_id']) 
                                                        {
                                                            echo 'selected';
                                                        } 
                                                        else if ($this->input->post('designation_id') == $emprolse['role_id']) 
                                                        {
                                                            echo 'selected';
                                                        } ?> ><?php echo $emprolse['emprole_name_hi']; ?> (<?php echo $emprolse['emprole_name_en']; ?>) 
                                                    <?php } ?>
                                            <?php } ?>
                                    </select>
                                        <?php echo form_error('designation_id'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_role_id_label'); ?> <span class="text-danger">*</span></label>
                                    <?php if ($id) {
                                        $emp_roles = get_list(EMPLOYEEE_ROLE, null, null);
                                    } else { ?>
                                            <?php $emp_roles = get_employe_role_designatio();
                                        } //pre($emp_roles);?>
                                    <select class="form-control" name="emp_role" id="emp_role">
                                        <option value=""><?php echo $this->lang->line('emp_role_select_label'); ?></option>
                                            <?php foreach ($emp_roles as $empk => $emprolse) { ?>
                                        <?php if (is_array($emprolse)) { ?>
                                                <option value="<?php echo $emprolse['role_id']; ?>" <?php if (@$emp_detail['role_id'] == $emprolse['role_id']) {
                                        echo 'selected';
                                    } else if ($this->input->post('emp_role') == $emprolse['role_id']) {
                                        echo 'selected';
                                    } ?> ><?php echo $emprolse['emprole_name_hi']; ?> (<?php echo $emprolse['emprole_name_en']; ?>) 
                                        <?php } ?>
                                    <?php } ?>
                                    </select>
                                        <?php echo form_error('emp_role'); ?>
                                </div>
                                        <?php ?>
                                <?php if (@$emp_detail['role_id'] != 3) { ?>
                                <div class="form-group supervisor">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_supervisor_label'); ?> <span class="text-danger">*</span></label>
                                            <?php if (isset($id) && $id != '') {
                                                $supervisor_list = get_supervisor_list(@$emp_detail['role_id'], 'get_supervisor_detail');
                                            } //pre($supervisor_list); ?>
                                        <select multiple="multiple" class="form-control" name="supervisor_emp_id[]" id="supervisor_emp_id">
                                            <option value="">Select Supervisor</option>
                                            <?php if (isset($id) && $id != '' && count($supervisor_list) > 0) { ?>
                                                <?php foreach ($supervisor_list as $spkey => $spval) { ?>
                                                    <?php if (@$spval['role_id'] != @$emp_detail['role_id']) { ?>
                                                        <?php
                                                        /* Edit Case */
                                                        if (isset($id) && $id != '') {
                                                            $supervisor_id = null;
                                                            $supervisor_array = get_supervisor_list($id, 'get_supervisor_detail_byId');
                                                            //if ($supervisor_id == $spval['emp_id']) {
                                                            if(in_array($spval['emp_id'], $supervisor_array)) {
                                                                $slcted = "selected";
                                                            } else {
                                                                $slcted = "";
                                                            }
                                                        }
                                                        
                                                        /* end */
                                                        ?>
                                                        <option <?php echo $slcted; ?>  value="<?php echo $spval['emp_id'] ?>"><?php echo $spval['emp_full_name'] ?> (<?php echo $spval['emprole_name_en'] . ' - ' . $spval['emprole_name_hi']; ?>)</option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                            <?php echo form_error('supervisor_emp_id'); ?>
                                </div>
                                <?php } ?>
                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_section_id_label'); ?> <span class="text-danger">*</span></label>
                                            <?php $section_list = get_list(SECTIONS, null, null); //pre($section_list);  ?>
                                    <div class="form-group">
                                        <?php
                                        /* Employee alloted section */
                                        $employee_sections_array = '';
                                        $employee_sections_array = get_alloted_sections_list($id, 'EMPLOYEEE_TBL');
                                        if (isset($employee_sections_array) && $employee_sections_array != '') {
                                            $alloted_section_convert_array = explode(',', @$employee_sections_array['emp_section_id']);
                                        }
                                        ?>
                                        <?php $ln = 1;
                                        foreach ($section_list as $seck => $sections) { ?>
                                                <div style="float:left;width:250px;padding-bottom:10px" title="<?php echo $sections['section_name_en']; ?>">
                                                    <input type="checkbox"  class="minimal" name="emp_section_id[]" value="<?php echo $sections['section_id']; ?>" <?php if (in_array($sections['section_id'], $alloted_section_convert_array, true)) { echo 'checked ';} else if ($id && $alloted_section_convert_array[0] == 26) {echo 'disabled';} ?> />
                                                    <?php if ($id && $alloted_section_convert_array[0] == 26) {
                                                        if ($sections['section_id'] != 26) {
                                                            echo '<i class="fa fa-check"></i>';
                                                        }
                                                    } ?>
                                                    <?php echo $sections['section_name_hi']; ?>(<?php echo $sections['section_short_name']; ?>)
                                                </div> <?php if ($ln == 3) { echo '<br/>';} ?>
                                            <?php $ln++;
                                        } ?>  
                                    </div>
                                    <div style="clear:both"></div>
                                        <?php echo form_error('emp_section_id'); ?>
                                </div>
                                <!--Other Work-->
                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_other_work_label'); ?></label>
                                            <?php $other_work_list_master = get_list(OTHER_WORK_UPPERLEVEL_MASTER, null, null); //pre($section_list);  ?>
                                    <div class="form-group">
                                        <?php
                                        /* Employee alloted section */
                                        $employee_other_array = '';
                                        $alloted_otherwork_convert_array=array();
                                        $employee_other_array = get_alloted_sections_list($id, 'EMPLOYEEE_TBL');
                                            if (isset($id) && $id != '') {
                                                $alloted_otherwork_convert_array = get_emp_other_work_alloted($id);
                                            }
                                        ?>
                                        <?php $ln = 1;
                                        foreach ($other_work_list_master as $otherwrkey => $otherwork) { ?>
                                                <div style="float:left;width:250px;padding-bottom:10px" title="<?php echo $otherwork['other_work_title_en']; ?>">
                                                    <input type="checkbox"  class="minimal" name="other_work_id[]" value="<?php echo $otherwork['other_work_id']; ?>" <?php if(is_array($alloted_otherwork_convert_array)){ if(in_array($otherwork['other_work_id'],$alloted_otherwork_convert_array, true)) { echo 'checked ';} else if ($id && $alloted_otherwork_convert_array[0] == 26) {echo 'disabled';}} ?> />
                                                    <?php echo $otherwork['other_work_title_hi']; ?>
                                                </div> <?php if ($ln == 3) { echo '<br/>';} ?>
                                            <?php $ln++;
                                        } ?>  
                                    </div>
                                    <div style="clear:both"></div>
                                        <?php echo form_error('other_work_id'); ?>
                                </div>
                                <!--End Other Work-->
                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo $this->lang->line('emp_unique_id_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_unique_id" <?php if (@isset($id) && @$id != '') {echo 'readonly';} ?> value="<?php echo (@$emp_detail['emp_unique_id'] ? @$emp_detail['emp_unique_id'] : $this->input->post('emp_unique_id')); ?>" class="form-control"/>
                                        <?php echo form_error('emp_unique_id'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_login_id_label_1'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_login_id" <?php if (@isset($id) && @$id != '') {echo 'readonly';} ?> value="<?php echo (@$emp_detail['emp_login_id'] ? @$emp_detail['emp_login_id'] : $this->input->post('emp_login_id')); ?>" class="form-control"/>
                                    <?php echo form_error('emp_login_id'); ?>
                                </div>                  
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_password_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_password" value="<?php echo (@$emp_detail['emp_password'] ? @$emp_detail['emp_password'] : $this->input->post('emp_password')); ?>" class="form-control">
                                        <?php echo form_error('emp_password'); ?>
                                </div>   
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_full_name_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_full_name" value="<?php echo (@$emp_detail['emp_full_name'] ? @$emp_detail['emp_full_name'] : $this->input->post('emp_full_name')); ?>"  class="form-control">
                                    <?php echo form_error('emp_full_name'); ?>
                                </div>                 
								<div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_full_name_label'); ?>(हिंदी) <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_full_name_hi" value="<?php echo (@$emp_detail['emp_full_name_hi'] ? @$emp_detail['emp_full_name_hi'] : $this->input->post('emp_full_name_hi')); ?>"  class="form-control">
                                    <?php echo form_error('emp_full_name_hi'); ?>
                                </div>  
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_email_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_email" value="<?php echo (@$emp_detail['emp_email'] ? @$emp_detail['emp_email'] : $this->input->post('emp_email')); ?>" class="form-control">
                                        <?php echo form_error('emp_email'); ?>
                                </div>  
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_mobile_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_mobile_number" maxlength="15" value="<?php echo (@$emp_detail['emp_mobile_number'] ? @$emp_detail['emp_mobile_number'] : $this->input->post('emp_mobile_number')); ?>"  class="form-control"/>
                                        <?php echo form_error('emp_mobile_number'); ?>
                                </div> 
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_dob_label'); ?> <span class="text-danger">*</span></label>
                                       <input type="text" id="emp_detail_dob" name="emp_detail_dob" value="<?php echo (@$emp_more_detail['emp_detail_dob']) ? date('d-m-Y' , strtotime($emp_more_detail['emp_detail_dob'])) : $this->input->post('emp_detail_dob'); ?>"  class="form-control">
                                    <?php echo form_error('emp_detail_dob'); ?>
                                </div> 
                            </div><!-- /.box-body -->
                            <!--  <div class="box-footer">
                               <button class="btn btn-primary" type="submit"><?php //echo $this->lang->line('submit_botton');  ?></button>
                             </div> -->
                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "क्या कर्मचारी सेवानिवृत है (Employee is retired)?" ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="emp_is_retired" required>
                                        <option value="">Select</option>                                            
												<option value="1" <?php if($emp_detail['emp_is_retired']==1){ echo 'selected';} ?> >सेवानिवृत है </option>
												<option value="0" <?php if($emp_detail['emp_is_retired']!="" && $emp_detail['emp_is_retired']==0){ echo 'selected';} ?>> सेवानिवृत  नहीं  है</option>
                                    </select>
                                    <?php echo form_error('emp_is_retired'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> कर्मचारी सक्रिय / निष्क्रिय / स्थानांतरण /निलंबित ( Active/In-Active/Transfer/Suspended)?<span class="text-danger">*</span></label>
                                    <select class="form-control" name="emp_status" required>
                                        <option value="">Select</option>                                            
												<option value="1" <?php if($emp_detail['emp_status']==1){ echo 'selected';} ?>> कर्मचारी सक्रिय  हैं</option>
												<option value="2" <?php if($emp_detail['emp_status']==2){ echo 'selected';} ?>> कर्मचारी निलंबित हैं </option>
												<option value="3" <?php if($emp_detail['emp_status']==3){ echo 'selected';} ?>> कर्मचारी  का स्थानांतरण  हो गया हैं</option>
												<option value="0" <?php if($emp_detail['emp_is_retired']!="" && $emp_detail['emp_status']==0){ echo 'selected';} ?>>कर्मचारी निष्क्रिय हैं</option>
                                    </select>
                                    <?php echo form_error('emp_is_retired'); ?>
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('emp_gender_label'); ?> <span class="text-danger">*</span></label>
                                        <?php $gender_array = gender_array(); //pre($gender_array); ?>
                                    <select class="form-control" name="emp_gender">
                                        <option value="">Select Employee Gender</option>
                                        <?php foreach ($gender_array as $gky => $gval) { ?>
                                        <option value="<?php echo $gky; ?>" <?php if (@$emp_more_detail['emp_detail_gender'] == $gky) {echo 'selected';} else if ($this->input->post('emp_gender') == $gky) {echo 'selected';} ?>><?php echo $gval; ?></option>                                        
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('emp_gender'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo $this->lang->line('emp_detail_martial_status_label'); ?> <span class="text-danger">*</span></label>
                                    <?php $marital_array = marital_status_array(); //pre($gender_array);  ?>
                                    <select class="form-control" name="emp_marital_status">
                                        <option value="">Select Marital Status</option>
                                        <?php foreach ($marital_array as $mtky => $mtval) { ?>
                                        <option value="<?php echo $mtky; ?>" <?php if (@$emp_more_detail['emp_detail_martial_status'] == $mtky) {echo 'selected';} else if ($this->input->post('emp_marital_status') == $mtky) {echo 'selected';} ?>><?php echo $mtval; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('emp_marital_status'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_detail_address_label'); ?> <span class="text-danger">*</span></label>
                                    <textarea name="emp_detail_address"  rows="3" class="form-control"><?php echo (@$emp_more_detail['emp_detail_address'] ? @$emp_more_detail['emp_detail_address'] : $this->input->post('emp_detail_address')); ?></textarea>
                                    <?php echo form_error('emp_detail_address'); ?>
                                </div>                  
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_state_label'); ?> <span class="text-danger">*</span></label>
                                    <?php $state_list = get_list(STATES, 'state_name_hi', array('country_id' => '1')); //pre($state_list);  ?>
                                    <select class="form-control" name="emp_detail_state">
                                        <option value="">Select</option>
                                        <?php foreach ($state_list as $stateky => $stateval) { ?>
                                        <option value="<?php echo $stateval['state_id']; ?>" <?php if (@$emp_more_detail['emp_detail_state'] == $stateval['state_id']) {echo 'selected';} else if ($this->input->post('emp_detail_state') == $stateval['state_id']) {echo 'selected';} ?>><?php echo $stateval['state_name_hi']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('emp_detail_state'); ?>
                                </div>   
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_city_label'); ?> <span class="text-danger">*</span></label>
                                    <?php $city_list = get_list(CITY, 'city_name', NULL); //pre($yesno_array);  ?>
                                    <select class="form-control" name="emp_detail_city">
                                        <option value="">Select</option>
                                        <?php foreach ($city_list as $cityky => $cityval) { ?>
                                        <option value="<?php echo $cityval['city_id']; ?>" <?php if (@$emp_more_detail['emp_detail_city'] == $cityval['city_id']) {echo 'selected';} elseif ($this->input->post('emp_detail_city') == $cityval['city_id']) {echo 'selected';} ?>><?php echo $cityval['city_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('emp_detail_city'); ?>
                                </div>                 
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_security_question_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_detail_security_question" value="<?php echo (@$emp_more_detail['emp_detail_security_question'] ? @$emp_more_detail['emp_detail_security_question'] : 'what is your employee Id?'); ?>" class="form-control">
                                    <?php echo form_error('emp_detail_security_question'); ?>
                                </div>  
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('emp_security_answer_label'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="emp_detail_answer" value="<?php echo (@$emp_more_detail['emp_detail_answer'] ? @$emp_more_detail['emp_detail_answer'] : $this->input->post('emp_detail_answer')); ?>" class="form-control">
                                    <input type="hidden" name="emp_detail_id" value="<?php echo (@$emp_more_detail['emp_detail_id'] ? @$emp_more_detail['emp_detail_id'] : ''); ?>" class="form-control">
                                    <?php echo form_error('emp_detail_answer'); ?>
                                </div> 
                                <input type="hidden" name="selected_emp_role" id="selected_emp_role" <?php if (isset($id) && $id != '') {echo 'value="' . $emp_detail['role_id'] . '"';} ?> />
                                <input type="hidden" name="selected_supervisor_id" id="selected_supervisor_id" <?php if (isset($id) && $id != '' && $emp_detail['role_id'] != 3) {echo 'value="' . $supervisor_id . '"';} ?> />
                            </div><!-- /.box-body -->
                            <!--Leave Fields-->
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title"><b>Leave Information</b></h3>
                                    <?php $emp_leave_details = array();
                                    $emp_leave_details = manage_employee_leave(null, array('emp_id' => $id), 'emp_leave_detail'); //pre($emp_leave_details); ?>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_casual_leave'); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="cl_leave" id="cl_leave" value="<?php echo (@$emp_leave_details['cl_leave'] ? @$emp_leave_details['cl_leave'] : $this->input->post('cl_leave')); ?>"/>
                                         <?php echo form_error('cl_leave'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_optional_leave'); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="ol_leave" id="ol_leave" value="<?php echo (@$emp_leave_details['ol_leave'] ? @$emp_leave_details['ol_leave'] : $this->input->post('ol_leave')); ?>" />
                                        <?php echo form_error('ol_leave'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_earned_leave'); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="el_leave" id="el_leave" value="<?php echo (@$emp_leave_details['el_leave'] ? @$emp_leave_details['el_leave'] : $this->input->post('el_leave')); ?>"/>
                                        <?php echo form_error('el_leave'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_half_pay_leave'); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="hpl_leave" id="hpl_leave" value="<?php echo (@$emp_leave_details['hpl_leave'] ? @$emp_leave_details['hpl_leave'] : $this->input->post('hpl_leave')); ?>"/>
                                        <?php echo form_error('hpl_leave'); ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_grade_pay_label'); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="emp_gradpay" id="emp_gradpay" value="<?php echo (@$emp_more_detail['emp_gradpay'] ? @$emp_more_detail['emp_gradpay'] : $this->input->post('emp_gradpay')); ?>"/>
                                        <?php echo form_error('emp_gradpay'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('emp_house_rent_label'); ?> <span class="text-danger">*</span></label>
                                        <?php $employee_grad_pay_array = employee_grad_pay(); //pre($employee_grad_pay_array); ?>
                                        <select class="form-control" name="emp_houserent">
                                        <option value="">Select Houserent</option>
                                        <?php foreach ($employee_grad_pay_array as $gdpky => $gdpval) { ?>
                                        <option value="<?php echo $gdpky; ?>" <?php if (@$emp_more_detail['emp_houserent'] == $gdpky) {echo 'selected';} else if ($this->input->post('emp_houserent') == $gdpky) {echo 'selected';} ?>><?php echo $gdpval; ?></option>                                        
                                        <?php } ?>
                                        </select>
                                        <?php echo form_error('emp_houserent'); ?>
                                    </div>
									<div class="form-group">
									
                                        <label><?php echo $this->lang->line('emp_service_book_label'); ?></label>
										<input type="file" class="form-control" name="service_record_book" id="service_record_book" />
										 <?php if( isset($emp_more_detail['emp_service_book_file']) ){ ?><a target="_blank" href='<?php echo base_url(); ?>uploads/service_book_pdf/<?php echo $emp_more_detail['emp_service_book_file']; ?>' >Service Book Copy</a> <?php } ?>
									</div>
									<input type="hidden" value="0" name="pat_leave" id="pat_leave" />
                                    <input type="hidden" value="0" name="mat_leave" id="mat_leave" />
                                    <input type="hidden" value="0" name="ot_leave" id="ot_leave" />
                                </div>
                            </div>

                            <div class="box-footer">
                                <button class="btn btn-primary" onclick="return confir_post_data();" type="submit"><?php echo $this->lang->line('submit_botton'); ?></button>
                            </div>
                            <span class="text-danger"><b>Note :</b> All Fields required *</span>
                        </div><!-- /.box -->
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div><!-- /.row -->
<!-- Main row -->
</section><!-- /.content -->

