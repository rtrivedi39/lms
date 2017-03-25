<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!-- <small>Optional description</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('admin');?>/department_posts"><?php echo $this->lang->line('department_posts_label');?></a></li>
            <li class="active"><?php echo $this->lang->line('Manage_post_label'); ?></li>
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
                  <div style="float:left"><h3 class="box-title"><?php echo $title_tab;?></h3></div>
                    <div style="float:right;margin-right: 10px;">
                      <a href="javascript:history.go(-1)">
                        <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                      </a>
                    </div>
                    <?php 
                      //if($is_page_edit==0){ ?>
                          <!-- <div style="float:right">
                             <a href="<?php //echo base_url('admin');?>/add_section">
                              <button class="btn btn-block btn-info"><?php //echo $this->lang->line('add_button'); ?></button>
                            </a>
                          </div> -->
                    <?php //} ?>
                  
                </div><!-- /.box-header -->
                <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $page_title; ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->session->flashdata('message'); //pre($otherwork_master_detail); ?>
                 <?php if(isset($id)){ $id=  '/'.$id;} else { $id = null;} ?>
                  <?php 
                 $attributes_manage_user = array('class' => 'form-signin', 'id' => 'formmanage_user', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('admin_upper_level_work_master/manage_otherwork'.$id, $attributes_manage_user);
                ?> 

                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo $this->lang->line('label_otherwork_hi'); ?></label>
                      <input type="text" name="other_work_title_hi" value="<?php echo (@$otherwork_master_detail['other_work_title_hi'] ? @$otherwork_master_detail['other_work_title_hi']:'');?>" class="form-control">
                      <?php echo form_error('other_work_title_hi');?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1"><?php echo $this->lang->line('label_otherwork_en'); ?></label>
                      <input type="text" name="other_work_title_en" value="<?php echo (@$otherwork_master_detail['other_work_title_en'] ? @$otherwork_master_detail['other_work_title_en']:'');?>" class="form-control">
                      <?php echo form_error('other_work_title_en');?>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button class="btn btn-primary" onclick="return confir_post_data();" type="submit"><?php echo $this->lang->line('submit_botton'); ?></button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    