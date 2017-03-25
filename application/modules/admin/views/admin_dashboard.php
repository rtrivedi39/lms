<?php //pre($this->session->all_userdata()); ?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small><?php echo $this->session->userdata('emp_designation'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $this->session->userdata('emp_designation'); ?></a></li>
            <li class="active"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <?php //pre($this->session->all_userdata());?>
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>
                    <?php 
                      echo $totalemployees= get_total_numbers_of('employee',null,'counter');
                    ?>
                  </h3>
                  <p><?php echo $this->lang->line('dashboard_total_employee');?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url('admin');?>/employees" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $totalfiles= get_total_numbers_of('files',null,'counter'); ?>
                      <sup style="font-size: 20px"></sup></h3>
                  <p><?php echo $this->lang->line('dashboard_total_files');?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $totalfiles= get_total_numbers_of('files',null,'counter'); ?></h3>
                  <p><?php echo $this->lang->line('dashboard_total_dispatch_department'); ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $totalfiles= get_total_numbers_of('files',null,'counter'); ?></h3>
                  <p><?php echo $this->lang->line('dashboard_total_dispatch_out'); ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			
          </div><!-- /.row -->
          <!-- Main row -->
	        <?php $this->load->view('admin/notice_boards'); ?>
        </section><!-- /.content -->
		
		