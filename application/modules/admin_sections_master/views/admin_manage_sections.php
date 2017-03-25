<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!-- <small>Optional description</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url('admin');?>/sections">Sections</a></li>
            <li class="active">Manage Section</li>
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
                      if($is_page_edit==0){ ?>
                          <div style="float:right">
                             <a href="<?php echo base_url('admin');?>/add_section">
                              <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?></button>
                            </a>
                          </div>
                    <?php } ?>
                  
                </div><!-- /.box-header -->
                <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $page_title; ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->session->flashdata('message'); ?>
                <form role="form" method="post" action="<?php echo base_url()?>admin_sections_master/manage_section<?php if(isset($id)){ echo '/'.$id;} ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo $this->lang->line('add_section_with_hi'); ?></label>
                      <input type="text" name="section_name_hi" value="<?php echo (@$section_master_detail['section_name_hi'] ? @$section_master_detail['section_name_hi']:'');?>" placeholder="<?php echo $this->lang->line('add_section_with_hi'); ?>" class="form-control">
                      <?php echo form_error('section_name_hi');?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1"><?php echo $this->lang->line('add_section_with_en'); ?></label>
                      <input type="text" name="section_name_en" value="<?php echo (@$section_master_detail['section_name_en'] ? @$section_master_detail['section_name_en']:'');?>" placeholder="<?php echo $this->lang->line('add_section_with_en'); ?>" class="form-control">
                      <?php echo form_error('section_name_en');?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile"><?php echo $this->lang->line('section_short_label'); ?></label>
                      <input type="text" name="section_short_name" value="<?php echo (@$section_master_detail['section_short_name'] ? @$section_master_detail['section_short_name']:'');?>" placeholder="<?php echo $this->lang->line('section_short_label'); ?>" class="form-control">
                      <?php echo form_error('section_short_name');?>
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
    