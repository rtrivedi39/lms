<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Sections</li>
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
                    <a href="<?php echo base_url('admin');?>/add_section">
                      <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
                    </a>
                    </div>
                </div><!-- /.box-header -->
                <?php echo $this->session->flashdata('message'); ?>
                  <table id="leave_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th><?php echo $this->lang->line('section_label'); ?>(Hindi)</th>
                        <th><?php echo $this->lang->line('section_label'); ?>(English)</th>
                        <th><?php echo $this->lang->line('section_label'); ?>Short Name</th>
                        <th><?php echo $this->lang->line('date_label'); ?></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach ($get_section as $key => $sections) { ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $sections['section_name_hi'];?></td>
                          <td><?php echo $sections['section_name_en'];?></td>
                          <td><?php echo $sections['section_short_name'];?></td>
                          <td><?php echo $sections['section_created_date'];?></td>
                          <td>
                              <div class="btn-group">
                                <a href="<?php echo base_url('admin');?>/edit_section/<?php echo $sections['section_id'];?>" class="btn  btn-twitter">Edit</a>
                                <!-- <a href="<?php //echo base_url('admin');?>/delete_section/<?php //echo $sections['section_id'];?>" onclick="return is_delete();" class="btn  btn-twitter">Delete</a> -->
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
        <script type="text/javascript">
          function is_delete(){
            var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
            if(res===false){
              return false;
            }
          }
        </script>
    