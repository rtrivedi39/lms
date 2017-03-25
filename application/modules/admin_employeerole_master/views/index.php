<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('emprole_dashboard')?></a></li>
            <li class="active"><?php echo $this->lang->line('title')?></li>
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
                    <a href="<?php echo base_url('admin');?>/add_employeerole">
                      <button class="btn btn-block btn-info"><?php echo $this->lang->line('emprole_add')?></button>
                    </a>
                  </div>
                  <div style="float:right;margin-right: 10px;">
                    <a href="javascript:history.go(-1)">
                      <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                    </a>
                  </div>
                </div><!-- /.box-header -->
			
                <?php echo $this->session->flashdata('message'); ?>
                  <table id="leave_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('emprole_no')?></th>
						<th><?php echo $this->lang->line('emprole_unit_name')?></th>
                        <th><?php echo $this->lang->line('emprole_name_hi')?></th>
                        <th><?php echo $this->lang->line('emprole_name_en')?></th>
                        <th><?php echo $this->lang->line('emprole_date')?></th>
                        <th><?php echo $this->lang->line('emprole_action')?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach ($get_employee as $key => $employees) { //pre($get_employee); ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $employees->unit_name;?></td>
                          <td><?php echo $employees->emprole_name_hi;?></td>
                          <td><?php echo $employees->emprole_name_en;?></td>
                          <td><?php echo $employees->emprole_create_date;?></td>
                          <td>
                              <div class="btn-group">
								<?php if($employees->role_id != ''){?>
                                <a href="<?php echo base_url('admin');?>/edit_employeerole/<?php echo $employees->role_id;?>" class="btn  btn-twitter">Edit</a>
                                <!-- <button class="btn btn-info" type="button" onclick="return delete_row();">Delete</button> -->
								<?php } ?>
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
    