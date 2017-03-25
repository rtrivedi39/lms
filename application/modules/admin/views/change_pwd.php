<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Change password
           
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Change password</li>
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
                  <?php if($this->session->flashdata('error')){

                    ?>  <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong><?php  echo $this->session->flashdata('error'); ?></strong><br>
                  <?php echo validation_errors(); ?>
                  </div>
                    <?php
                     
                  }?>
                   <?php if($this->session->flashdata('update')){

                    ?>  <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong><?php  echo $this->session->flashdata('update'); ?></strong><br>
                  <?php echo validation_errors(); ?>
                  </div>
                    <?php
                     
                  }?>
                  <form role="form" method="post" action="<?php echo site_url() ?>admin/admin_dashboard/change_pwd">
                    <input type="hidden" name="edit_id" value="<?php echo  isset($userdata[0]->emp_id) ? $userdata[0]->emp_id : ''; ?>" > 
                   <div class="form-group">
                      <label>Old Password</label>
                      <input type="password" required  class="form-control" placeholder="Enter ..." name="old_password" id="old_password" />
                    </div>
                     <div class="form-group">
                      <label>Password</label>
                      <input type="password" required class="form-control" placeholder="******" name="new_password" id="new_password" />
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" required class="form-control" placeholder="******" name="con_password" id="con_password" />
                    </div>
                    <div class="form-group col-lg-4 pull-right">
                      <button type="submit" class="btn btn-block btn-primary">Update</button>                 
                    </div>     
                 </div>
               </div>
              </div>
            </div><!-- ./col -->
            </div>
          </div> 
           
          
          <!-- Main row -->



        </section><!-- /.content -->