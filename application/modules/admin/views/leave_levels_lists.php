<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!--<small>Optional description</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"></li><?php echo $this->lang->line('title'); ?></li>
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
				  <?php if(checkUserrole() == 1){ ?>
                    <a href="<?php echo base_url('admin');?>/add_leave_levels">
                      <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_new_level') ?></button>
                    </a>
				  <?php } ?>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php if($this->session->flashdata('update') || $this->session->flashdata('insert') || $this->session->flashdata('delete') ){ ?>  <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>
                            <?php  echo $this->session->flashdata('update');
                            echo $this->session->flashdata('delete');
                            echo $this->session->flashdata('insert'); ?>
                        </strong><br>
                      </div>
                  <?php }?>
                  <table id="leave_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('sno') ?>No.</th>
                        <th>ID</th>
                        <th><?php echo $this->lang->line('employee_name').'/'.$this->lang->line('employee_post') ?></th>
                        <th><?php echo $this->lang->line('employee_forwoder_name') ?></th>
                        <th><?php echo $this->lang->line('employee_recommender_name') ?></th>
                        <th><?php echo $this->lang->line('employee_approver_name') ?></th>
                        <th><?php echo $this->lang->line('action') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; 
                      if($leave_level_lists != ''){
                        foreach ($leave_level_lists as $row) { ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row->emp_unique_id;?></td>
                            <td><?php echo getemployeeName($row->emp_id, true).'/'.get_employee_role($row->emp_id, true);?></td>
                            <td><?php echo getemployeeName($row->forwarder_id, true);?>/<?php echo get_employee_role($row->forwarder_id, true);?></td>
                            <td><?php echo getemployeeName($row->recommender_id, true);?>/<?php echo get_employee_role($row->recommender_id, true);?></td>
                            <td><?php echo getemployeeName($row->approver_id, true);?>/<?php echo get_employee_role($row->approver_id, true);?></td>
                            <td>
                              <div class="btn-group">
                               <?php if(checkUserrole() == 1){ ?> <a href="<?php echo base_url('admin');?>/delete_level_lists/<?php echo $row->hirarchi_id;?>"  class="btn  btn-danger"  onclick="return confirm('Are you sure?');"><?php echo $this->lang->line('delete') ?></a><?php } ?>
                                <a href="<?php echo base_url('admin');?>/manage_leave_levels/<?php echo $row->hirarchi_id;?>"  class="btn  btn-twitter"><?php echo $this->lang->line('edit') ?></a>
                              </div>
                              </td>
                        </tr>
                      <?php $i++; }
                      } else{
                          echo 'No lists found';
                      } ?>
                    </tbody>
                </table>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    