<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <small>Optional description</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('unit_dashboard'); ?></a></li>
            <li class="active"><?php echo $title; ?></li>
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
                  <div style="float:right">
                    <a href="<?php echo base_url('admin');?>/add_unit">
                      <button class="btn btn-block btn-info"><?php echo $this->lang->line('unit_add'); ?></button>
                    </a>
                    </div>
                </div><!-- /.box-header -->
                 <?php if($this->session->flashdata('update') || $this->session->flashdata('insert') || $this->session->flashdata('delete') ){

                    ?>  <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>
                    <?php  echo $this->session->flashdata('update'); 
                     echo $this->session->flashdata('insert');
                   ?></strong><br>
                 </div>
                    <?php
                     
                  }?>
                   
                  <table id="leave_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('unit_no'); ?></th>
                        <th><?php echo $this->lang->line('unit_name'); ?></th>
                        <th><?php echo $this->lang->line('unit_level_name'); ?></th>
                        <th><?php echo $this->lang->line('unit_code'); ?></th>
                        <th><?php echo $this->lang->line('unit_create_date'); ?></th>
                        <th><?php echo $this->lang->line('unit_action'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach ($get_unit as $key => $unit) { ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $unit['unit_name'];?></td>
                          <td><?php echo $unit['unit_level_name'];?></td>
                          <td><?php echo $unit['unit_code'];?></td>
                          <td><?php echo $unit['unit_create_date'];?></td>
                          <td>
                              <div class="btn-group">
                                <a href="<?php echo base_url('admin');?>/manage_unit/<?php echo $unit['unit_id'];?>" class="btn  btn-twitter">Edit</a>
                                 <!-- <a onclick="return confirm('Are you sure you want to delete..!!')" href="<?php echo base_url('admin');?>/delete_unit/<?php echo $unit['unit_id'];?>" class="btn  btn-info ">Delete</a> -->
                               
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
    