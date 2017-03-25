<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $this->lang->line('profile_title'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="box box-warning">
                <div class="box-header">
                    <h3>व्यक्तिगत जानकारी</h3>
                </div>
                 <?php 
                 $attributes_updateProfile = array('class' => 'form-signin', 'id' => 'formupdateProfile', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('admin/admin_dashboard/updateProfile', $attributes_updateProfile);
                ?> 
             
                    <div class="box-body">
                        <?php if ($this->session->flashdata('update')) {
                            ?>  <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong><?php echo $this->session->flashdata('update'); ?></strong><br>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php }
                        ?>
                        <input type="hidden" name="edit_id" value="<?php echo isset($userdata[0]->emp_id) ? $userdata[0]->emp_id : ''; ?>" > 
                        <div class="form-group">
                            <label><?php echo $this->lang->line('full_name'); ?></label>
                            <input type="text" value="<?php echo isset($userdata[0]->emp_full_name) ? $userdata[0]->emp_full_name : ''; ?>" class="form-control" name="emp_name" id="emp_name"  placeholder="Enter ..."/>
                        </div>
						<div class="form-group">
                            <label><?php echo $this->lang->line('full_name'); ?> हिंदी</label>
                            <input type="text" value="<?php echo isset($userdata[0]->emp_full_name_hi) ? $userdata[0]->emp_full_name_hi : ''; ?>" class="form-control" name="emp_name_hi" id="emp_name"  placeholder="Enter ..."/>
                        </div>
                        <!-- text input -->
                        <div class="form-group">
                            <label><?php echo $this->lang->line('email'); ?></label>
                            <input type="text" value="<?php echo isset($userdata[0]->emp_email) ? $userdata[0]->emp_email : ''; ?>" class="form-control" name="email" id="email"  placeholder="Enter ..."/>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('mobile'); ?></label>
                            <input type="text" value="<?php echo isset($userdata[0]->emp_mobile_number) ? $userdata[0]->emp_mobile_number : ''; ?>" class="form-control" placeholder="Enter ..." name="mobile" id="mobile" />
                        </div>
                        <div class="form-group col-lg-4">
                            <label><?php echo $this->lang->line('upload_image'); ?></label>
                            <input type="file" name="userfile"  />
                        </div>
                        <div class="form-group pull-right" >
                            <?php if (!empty($userdata[0]->emp_image)) { ?>
                                <img src="<?php echo USR_IMG_PATH; ?><?php echo $userdata[0]->emp_image ?>"   height="" width="" style="max-width:200px;">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group col-lg-4 pull-right">
                            <button type="submit" class="btn btn-block btn-primary">Update</button>                 
                        </div>     
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="box box-warning">
                <div class="box-header">
                    <h3>सिक्यूरिटी जानकारी</h3>
                </div>
                <form role="form" method="post"  enctype="multipart/form-data" action="<?php echo site_url() ?>admin/admin_dashboard/update_passdetails">
                    <div class="box-body">
                        <?php 
                        $uset_data = get_user_details($userdata[0]->emp_id,'emp_detail_security_question, emp_detail_answer');
                       
                        if ($this->session->flashdata('update_pass')) {
                            ?>  <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong><?php echo $this->session->flashdata('update_pass'); ?></strong><br>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php }
                        ?>
                        <input type="hidden" name="edit_id" value="<?php echo isset($userdata[0]->emp_id) ? $userdata[0]->emp_id : ''; ?>" > 
                        <div class="form-group" title="<?php echo $this->lang->line('new_pwd_label_en'); ?>">
                            <label><?php echo $this->lang->line('new_pwd_label_hi'); ?> <span class="text-danger">*</span></label>
                            <input type="password" value="" class="form-control" name="new_password" id="new_password"/>
                            <?php echo form_error('new_password'); ?>
                        </div>
                        <!-- text input -->
                        <div class="form-group" title="<?php echo $this->lang->line('confirm_pwd_label_en'); ?>">
                            <label><?php echo $this->lang->line('confirm_pwd_label_hi'); ?> <span class="text-danger">*</span></label>
                            <input type="password" value="" class="form-control" name="confirm_pwd" id="confirm_pwd" />
                            <?php echo form_error('confirm_pwd'); ?>
                        </div>
                        <div class="form-group" title="<?php echo $this->lang->line('confirm_question_label_en'); ?>">
                            <label><?php echo $this->lang->line('confirm_question_label_hi'); ?>  <span class="text-danger">*</span></label>
                            <?php $security = get_secuirty_question(); ?>
                            <select name="sec_question" name="sec_question" class="form-control">
                                <option value=""><?php echo $this->lang->line('select_label_hi'); ?></option>
                                <?php foreach ($security as $qtky => $qt) { ?>
                                    <option value="<?php echo $qt; ?>" <?php echo $uset_data[0]->emp_detail_security_question == $qt ? 'selected' : ''; ?> ><?php echo $qt; ?></option>
                                <?php } ?>
                            </select> 
                            <?php echo form_error('sec_question'); ?>
                        </div>
                        <div class="form-group" title="<?php echo $this->lang->line('confirm_answer_label_en'); ?>">
                            <label><?php echo $this->lang->line('confirm_answer_label_hi'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="sec_answer" value="<?php echo isset($uset_data[0]->emp_detail_answer) ? $uset_data[0]->emp_detail_answer : ''; ?>" class="form-control" id="sec_answer" >
                            <?php echo form_error('sec_answer'); ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group col-lg-4 pull-right">
                            <button type="submit" class="btn btn-block btn-primary">Update</button>                 
                        </div>     
                    </div>
                </form>
            </div>
        </div><!-- ./col -->
    </div>
    <!-- Main row -->

    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!-- small box -->
            <div class="box box-warning">
                <div class="box-header">
                    <h3>यह आपकी पर्सनल जानकारी है अगर इसमे किसी प्रकार की त्रुटी दिखाई दे तो हमें अवश्य सूचित करे|</h3>
                </div>
                <form role="form" method="post"  enctype="multipart/form-data" action="<?php echo site_url() ?>admin/admin_dashboard/update_user_details">
                    <div class="box-body">
                        <?php //pre($user_service_profile);
                        foreach($user_service_profile as $row) { ?>
                        <div class="col-lg-6 col-xs-6">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                       <label> Unique ID </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->emp_uid; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Sex </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Sex; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Parent name/ Hasband </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Parent_name; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Address </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Emp_address; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Native district </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Native_dist; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Current address </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Cu_emp_address; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Current district </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Current_dist; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Language </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Language; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Pan card number </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Pan; ?></b>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                       <label> religion_code </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->religion_code; ?></b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                       <label> Date_of_birth </label> 
                                    </td>
                                    <td>
                                        <b><?php echo get_date_formate($row->Date_of_birth); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Height </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Height; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Identification_mark </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Identification_mark; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Blood group </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Bgroup; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Date education </label> 
                                    </td>
                                    <td>
                                        <b><?php echo get_date_formate($row->Date_ejudicial); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Date govt join </label> 
                                    </td>
                                    <td>
                                        <b><?php echo get_date_formate($row->Date_egovt); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Nationality </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->Nationality; ?></b>
                                    </td>
                                </tr>
                              
                                <tr>
                                    <td>
                                       <label> Emergency contact no </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->emg_contact_no; ?></b>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                       <label> Emergency contact address </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->emg_contact_add; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label> Bank account number </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->bank_ac; ?></b>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                       <label> Bank branch </label> 
                                    </td>
                                    <td>
                                        <b><?php echo $row->bnk_branch; ?></b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="box-footer">
                        <div class="form-group col-lg-4 pull-right">
                           <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                        </div>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->