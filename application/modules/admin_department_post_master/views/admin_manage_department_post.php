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
                <?php echo $this->session->flashdata('message'); //pre($department_post_master); ?>
                <form role="form" method="post" action="<?php echo base_url()?>admin_department_post_master/manage_post<?php if(isset($id)){ echo '/'.$id;} ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo $this->lang->line('list_label_post_name'); ?></label>
                      <input type="text" name="endm_designation" value="<?php echo (@$department_post_master['endm_designation'] ? @$department_post_master['endm_designation']:'');?>" class="form-control">
                      <?php echo form_error('endm_designation');?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1"><?php echo $this->lang->line('list_label_no_of_post'); ?></label>
                      <input type="text" name="endm_designation_numbers" value="<?php echo (@$department_post_master['endm_designation_numbers'] ? @$department_post_master['endm_designation_numbers']:'');?>" class="form-control">
                      <?php echo form_error('endm_designation_numbers');?>
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
    