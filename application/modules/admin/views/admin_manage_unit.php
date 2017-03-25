<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <small>Optional description</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Unit</li>
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
                  <h3 class="box-title"><?php echo $this->lang->line('unit_add');?></h3>
                </div><!-- /.box-header -->
                 <!-- form start -->
                <?php $uid=$this->uri->segment(4); ?>
                <form role="form" method="post" action="<?php echo site_url(); ?>admin/admin_unit/addUpdateUnit<?php if($this->uri->segment(4)!=''){ echo '/'.$this->uri->segment(4);} ?>">
                   <input type="hidden" value="<?php if($this->uri->segment(3)!=''){ echo $this->uri->segment(3);}?>"  name="edit_id" id="edit_id" class="form-control">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="Unit_Name"><?php echo $this->lang->line('unit_name'); ?></label>
                      <input type="text" value="<?php echo isset($unitdata['unit_name'])? $unitdata['unit_name'] :''; ?>" placeholder="Enter unit Name" name="unit_name" id="unit_name" class="form-control">
                      <?php echo form_error('unit_name'); ?>
                    </div>
                    <div class="form-group">
                      <label for="Unit_Level_Name"><?php echo $this->lang->line('unit_level_name'); ?></label>
                      <input type="text" value="<?php echo isset($unitdata['unit_level_name'])? $unitdata['unit_level_name'] :''; ?>" placeholder="Unit Level Name" name="unit_level_name" id="unit_level_name" class="form-control">
                      <?php echo form_error('unit_level_name'); ?>
                    </div>
                      <div class="form-group">
                      <label for="Unit_Code"><?php echo $this->lang->line('unit_code'); ?></label>
                      <input type="text" value="<?php echo isset($unitdata['unit_code'])? $unitdata['unit_code'] :''; ?>" placeholder="Unit Code" name="unit_code" id="unit_code" class="form-control">
                      <?php echo form_error('unit_code'); ?>
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button class="btn btn-primary" onclick="return confir_post_data();" type="submit"><?php echo $this->lang->line('unit_submit'); ?></button>
                  </div>
                </form>
              </div><!-- /.box -->
             </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    