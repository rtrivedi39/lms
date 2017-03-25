<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!--<small>Optional description</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>admin/leave_levels"><?php echo $this->lang->line('title') ?></a></li>
            <li class="active"><?php echo $title_tab; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-xs-6">
            
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line('add_new_level') ?></h3>
                </div><!-- /.box-header -->
				 <div class="box-body">
                 <!-- form start -->
                 <?php
                 if(isset($leave_level_lists) && $leave_level_lists != ''){
                    $edit_emp_id = $leave_level_lists['emp_id'];
                    $forwoder_id = $leave_level_lists['forwarder_id'];
                    $recommender_id = $leave_level_lists['recommender_id'];
                    $approver_id = $leave_level_lists['approver_id'];
                 }
                 //pre($this->leave_levels_model->get_recommender());
                 ?>
                
                <?php 
                   $attributes_update_leave_levels = array('class' => 'form-signin', 'name' => 'hirarchi_id', 'id' => 'formupdate_leave_levels', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                  echo form_open('admin/leave_levels/add_update_leave_levels', $attributes_update_leave_levels);
                  ?> 
              
                    <input type="hidden" value="<?php echo (isset($id) && $id != '') ? $id : '';?>"  name="hirarchi_id" id="hirarchi_id" class="form-control">
                    <div class="box-body">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('name'); ?></label>
                            <select name="emp_id" class="form-control">
                                <option value="">---- Select ----</option> 
                                <?php 
                                $all = (isset($id) && $id != '') ? true :  false; 
                                foreach($this->leave_levels_model->get_all_employee($all) as $row) { ?>
                                    <option value="<?php echo $row->emp_id; ?>"  <?php echo (isset($edit_emp_id) && $edit_emp_id == $row->emp_id) ? 'Selected' : '' ;?>><?php echo $row->emp_full_name_hi; ?>/<?php echo getemployeeRole($row->role_id); ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('emp_id'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('employee_forwoder_name'); ?></label>
                            <select name="forwarder_id" class="form-control">
                                <option value="">---- Select ----</option>
                                <?php foreach($this->leave_levels_model->get_forwarder() as $row) { ?>
                                    <option value="<?php echo $row->emp_id; ?>"  <?php echo (isset($forwoder_id) && $forwoder_id == $row->emp_id) ? 'Selected' : '' ;?>><?php echo $row->emp_full_name_hi; ?>/<?php echo getemployeeRole($row->role_id); ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('forwarder_id'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('employee_recommender_name'); ?></label>
                            <select name="recommender_id" class="form-control">
                                <option value="">---- Select ----</option>
                                <?php foreach($this->leave_levels_model->get_recommender() as $row) { ?>
                                    <option value="<?php echo $row->emp_id; ?>" <?php echo (isset($recommender_id) && $recommender_id == $row->emp_id) ? 'Selected' : '' ;?>><?php echo $row->emp_full_name_hi; ?>/<?php echo getemployeeRole($row->role_id); ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('recommender_id'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('employee_approver_name'); ?></label>
                            <select name="approver_id" class="form-control">
                                <option value="">---- Select ----</option>
                                <?php foreach($this->leave_levels_model->get_approver() as $row) { ?>
                                    <option value="<?php echo $row->emp_id; ?>"  <?php echo (isset($approver_id) && $approver_id == $row->emp_id) ? 'Selected' : '' ;?>><?php echo $row->emp_full_name_hi; ?>/<?php echo getemployeeRole($row->role_id); ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('approver_id'); ?>
                        </div>
                   
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                      <button class="btn btn-primary" onclick="return confirm('क्या आप जोड़ना चाहते है |');" type="submit"><?php echo $this->lang->line('submit') ?></button>
                    </div>
                </form>
              </div><!-- /.box -->
             </div><!-- /.box-body -->
            </div><!-- /.box -->
           </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    