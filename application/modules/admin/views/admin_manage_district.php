<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!--<small>Optional description</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><?php echo $this->lang->line('district') ?></li>
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
                  <h3 class="box-title"><?php echo $this->lang->line('add_district') ?></h3>
                </div><!-- /.box-header -->
                 <!-- form start -->
                <form role="form" method="post" action="<?php echo site_url(); ?>admin/admin_district/addUpdatedistrict">
                   <input type="hidden" value="<?php echo isset($districtdata['district_id'])? $districtdata['district_id'] :''; ?>"  name="district_id" id="district_id" class="form-control">
                    <div class="box-body">
                    <div class="form-group">
                      <label for="distname_Name"><?php echo $this->lang->line('add_district_hi') ?></label>
                      <input type="text" value="<?php echo isset($districtdata['district_name_hi'])? $districtdata['district_name_hi'] :''; ?>" placeholder="<?php echo $this->lang->line('add_district_hi') ?>" name="district_name_hi" id="district_name_hi" class="form-control" required="">
                        <?php echo form_error('district_name_hi');?>
                     </div>
                    <div class="form-group">
                      <label for="District_Name_eng"><?php echo $this->lang->line('add_district_en') ?></label>
                      <input type="text" value="<?php echo isset($districtdata['district_name_en'])? $districtdata['district_name_en'] :''; ?>" placeholder="<?php echo $this->lang->line('add_district_en') ?>" name="district_name_en" id="district_name_en" class="form-control" required="">
                        <?php echo form_error('district_name_en');?>
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
    