<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 title="<?php echo $this->lang->line('reset_password_title_en'); ?>"><?php echo $this->lang->line('new_reset_password_title_hi'); ?></h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $this->lang->line('reset_tab'); ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-10 col-xs-10">
              <!-- small box -->
               <div class="box box-warning">
                <div class="box-body col-lg-6">
                 <?php 
                     $attributes_change_password = array('class' => 'form-signin', 'id' => 'formchange_password', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('reset_password/change_password', $attributes_change_password);
                    ?>  
                     <div class="form-group" title="<?php echo $this->lang->line('reset_new_pwd_label_en'); ?>">
                      <label><?php echo $this->lang->line('reset_new_pwd_label_hi'); ?> <span class="text-danger">*</span></label>
                      <input type="password" value="<?php echo isset($userdata[0]->emp_full_name) ? $userdata[0]->emp_full_name : ''; ?>" class="form-control" name="new_password" id="new_password"/>
                      <?php echo form_error('new_password'); ?>
                    </div>
                    <!-- text input -->
                    <div class="form-group" title="<?php echo $this->lang->line('reset_confirm_pwd_label_en'); ?>">
                      <label><?php echo $this->lang->line('reset_confirm_pwd_label_hi'); ?> <span class="text-danger">*</span></label>
                      <input type="password" value="<?php echo isset($userdata[0]->emp_email)?$userdata[0]->emp_email:''; ?>" class="form-control" name="confirm_pwd" id="confirm_pwd" />
                      <?php echo form_error('confirm_pwd'); ?>
                    </div>
                    <div class="form-group" title="<?php echo $this->lang->line('reset_confirm_question_label_en'); ?>">
                      <label><?php echo $this->lang->line('reset_confirm_question_label_hi'); ?>  <span class="text-danger">*</span></label>
                      <?php $security=get_secuirty_question(); ?>
                      <select name="sec_question" name="sec_question" class="form-control">
                        <option value=""><?php echo $this->lang->line('reset_select_label_hi'); ?></option>
                        <?php foreach ($security as $qtky=>$qt) { ?>
                          <option value="<?php echo $qt; ?>"><?php echo $qt; ?></option>
                        <?php }  ?>
                      </select> 
                      <?php echo form_error('sec_question'); ?>
                    </div>
                    <div class="form-group" title="<?php echo $this->lang->line('reset_confirm_answer_label_en'); ?>">
                      <label><?php echo $this->lang->line('reset_confirm_answer_label_hi'); ?> <span class="text-danger">*</span></label>
                       <input type="text" value="<?php echo isset($userdata[0]->emp_email)?$userdata[0]->emp_email:''; ?>" class="form-control" name="sec_answer" id="sec_answer" />
                       <?php echo form_error('sec_answer'); ?>
                     </div>

                    <div class="form-group" title="<?php echo $this->lang->line('reset_pwd_email_en'); ?>">
                      <label><?php echo $this->lang->line('reset_pwd_email_hi'); ?> <span class="text-danger">*</span></label>
                       <input maxlength="80" placeholder="<?php echo $this->lang->line('reset_pwd_email_placholder_hi'); ?>" type="text" value="<?php echo isset($userdata[0]->emp_email)?$userdata[0]->emp_email:''; ?>" class="form-control" name="emp_email" id="emp_email" />
                       <?php echo form_error('emp_email'); ?>
                    </div>

                    <div class="form-group" title="<?php echo $this->lang->line('reset_pwd_mobile_en'); ?>">
                      <label><?php echo $this->lang->line('reset_pwd_mobile_hi'); ?> <span class="text-danger">*</span></label>
                       <input maxlength="15" placeholder="<?php echo $this->lang->line('reset_pwd_mobile_placholder_hi'); ?>" type="text" value="<?php echo isset($userdata[0]->emp_mobile_number)?$userdata[0]->emp_mobile_number:''; ?>" class="form-control" name="emp_mobile_number" id="emp_mobile_number" />
                       <?php echo form_error('emp_mobile_number'); ?>
                    </div>
                   <div style="clear:both">
                      <span class="text-danger">
                          <?php echo $this->lang->line('note_label'); ?>
                          <br/><b style="margin-left:40px;"><?php echo $this->lang->line('password_note_label_noti'); ?></b>

                      </span>
                    </div>
                    <div class="form-group col-lg-4 pull-right">
                      <button type="submit" class="btn btn-block btn-primary"><?php echo $this->lang->line('submit_botton'); ?></button>                 
                    </div>     
                 </div>
               </div>
              </div>
            </div><!-- ./col -->
            </div>
          </div> 
           
          
          <!-- Main row -->



        </section><!-- /.content -->