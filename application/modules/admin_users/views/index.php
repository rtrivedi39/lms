<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <?php //pr($this->session->flashdata); 
               echo $this->session->flashdata('message');
          ?>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <div style="float:left"><h3 class="box-title"><?php echo $title_tab;?></h3></div>
                  <div style="float:right">
                    <a href="<?php echo base_url('admin');?>/add_employee">
                      <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
                    </a>
                  </div>
                  <div style="float:right;margin-right: 10px;">
                        <a href="javascript:history.go(-1)">
                            <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                
                  <table id="leave_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th><?php echo $this->lang->line('emp_image_label'); ?></th>
                        <th><?php echo $this->lang->line('emp_label_ids'); ?></th>
                        <th style="width: 150px;"><?php echo $this->lang->line('emp_section_id_label'); ?></th>
                        <th><?php echo $this->lang->line('emp_full_name_label'); ?> (<?php echo $this->lang->line('emp_name_role_label'); ?>)</th>
                        <th><?php echo $this->lang->line('emp_email_label'); ?></th>
                        <th><?php echo $this->lang->line('emp_mobile_label'); ?></th>
                        <th style="width:90px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; //pre($get_users);
                        foreach ($get_users as $key => $users) { ?>
                        <tr>
                            <td>
                                <?php echo $i;?>
                                <?php $emp_designation_array= get_list(EMPLOYEEE_ROLE, NULL, array('role_id'=>$users['designation_id'])); //pre($emp_designation_array); ?>
                                <?php $emp_role_array= get_list(EMPLOYEEE_ROLE, NULL, array('role_id'=>$users['role_id'])); //pre($emp_role_array); ?>
                               <?php if($users['emp_section_id']!=''){ $emp_sections_array= get_list(SECTIONS, NULL, array('section_id'=>$users['emp_section_id']));}else { $emp_sections_array=0;} //pre($emp_sections_array); ?>
                            </td>
                            <td>
                              <?php if($users['emp_image']==''){ ?>
                              <img src="<?php echo USR_IMG_PATH?>avatarold.png" alt="user Image" title="User profile image" />
                              <?php }else{ ?>
                              <img src="<?php echo USR_IMG_PATH.$users['emp_image']?>" width="64px" alt="user Image" title="User profile image" />
                              <?php } ?>
                            </td>
                            <td>
                                <span class="badge bg-light-blue">
                                <?php echo $this->lang->line('emp_label_unique_id_short');?>: &nbsp;<b><?php echo $users['emp_unique_id'];?></b>
                                </span>
                                <br/>
                                <span class="badge bg-red">
                                <?php echo $this->lang->line('emp_login_id_label_short');?>: &nbsp;<b><?php echo $users['emp_login_id'];?></b>
                                </span>
                                <br/>
                                <span class="badge bg-green">
                                  <?php echo $this->lang->line('emp_role_label');?>: &nbsp;<b><?php if(count($emp_role_array)>0){ echo $emp_role_array[0]['emprole_name_hi'].'</span><br/>('.$emp_role_array[0]['emprole_name_en'].')';}else { echo 'Null';}?></b>
                                
                              </td>
                            <td>
                                <?php //echo $users['emp_section_id'];?>
                                 <?php if($users['emp_section_id']!=''){  $emp_section_array= get_emp_sections($users['emp_section_id']);}else{ $emp_section_array=0;} //pre($emp_section_array);?>
                                <span class="badge bg-yellow" style="padding:8px" title="" data-toggle="tooltip" class="btn btn-box-tool" data-original-title="<?php echo $emp_section_array['section_en'] ?>">
                                    <?php echo $emp_section_array['section_hi'] ?>
                                </span>
                                <?php //if(count($emp_sections_array)>0){ echo $emp_sections_array[0]['section_name_hi'].'</span><br/>('.$emp_sections_array[0]['section_name_en'].')';}else { echo 'Null';}?>
                            </td>
                            <td>
                              <?php echo $users['emp_full_name'];?><br>
								 ( <b><?php echo $users['emp_full_name_hi'];?> </b>)
                                <br/><span class="badge bg-green"><?php if(count($emp_designation_array)>0){ echo $emp_designation_array[0]['emprole_name_hi'];}else { echo 'Null';}?></span>
                            </td>
                            <td><?php echo $users['emp_email'];?></td>
                            <td><?php echo $users['emp_mobile_number'];?></td>
                            <td>
                              <div class="btn-group">
                                <a href="<?php echo base_url('admin');?>/edit_employee/<?php echo $users['emp_id'];?>" class="btn  btn-twitter">Edit</a>
                                <a href="<?php echo base_url();?>dealing_assistant/viewProfile/<?php echo $users['emp_id'];?>" class="btn  btn-twitter">View</a>
                              </div>
                            </td>
                        </tr>
                      <?php $i++; } ?>
                    </tbody>
                </table>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
        <script type="text/javascript">
          function is_delete(){
            var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
            if(res===false){
              return false;
            }
          }
        </script>
        <style type="text/css">
        #leave_employee_filter{
          clear: both;
        }
        </style>
    