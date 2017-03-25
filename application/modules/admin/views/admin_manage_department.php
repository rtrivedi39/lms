<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!--<small>Optional description</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><?php echo $this->lang->line('department'); ?></li>
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
                  <h3 class="box-title"><?php echo $this->lang->line('add_department'); ?></h3>
                </div><!-- /.box-header -->
                 <!-- form start -->
                <form role="form" method="post" action="<?php echo site_url(); ?>admin/admin_department/addUpdatedepartment<?php if(isset($dpid)){ echo '/'.$dpid;} ?>">
                   <input type="hidden" value="<?php echo isset($departmentdata['dept_id'])? $departmentdata['dept_id'] :''; ?>"  name="dept_id" id="dept_id" class="form-control">
                    <div class="box-body">
                    <div class="form-group">
                      <label for="department_Name"><?php echo $this->lang->line('add_department_hi'); ?></label>
                      <input type="text" value="<?php echo isset($departmentdata['dept_name_hi'])? $departmentdata['dept_name_hi'] :''; ?>" placeholder="<?php echo $this->lang->line('add_department_hi'); ?>" name="dept_name_hi" id="dept_name_hi" class="form-control" required="">
                        <?php echo form_error('dept_name_hi');?>
                     </div>
                    <div class="form-group">
                      <label for="Department_Name_eng"><?php echo $this->lang->line('add_department_en'); ?></label>
                      <input type="text" value="<?php echo isset($departmentdata['dept_name_en'])? $departmentdata['dept_name_en'] :''; ?>" placeholder="<?php echo $this->lang->line('add_department_en'); ?>" name="dept_name_en" id="dept_name_en" class="form-control" required="">
                        <?php echo form_error('dept_name_en');?>
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button class="btn btn-primary" onclick="return confir_post_data();" type="submit"><?php echo $this->lang->line('submit') ?></button>
                  </div>
                </form>
              </div><!-- /.box -->
             </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    