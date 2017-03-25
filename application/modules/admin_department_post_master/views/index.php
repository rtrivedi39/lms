<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $this->lang->line('department_posts_label'); ?></li>
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
                        <th>S.No.</th>
                        <th><?php echo $this->lang->line('list_label_post_name'); ?></th>
                        <th><?php echo $this->lang->line('list_label_no_of_post'); ?></th>
                        <th><?php echo $this->lang->line('list_label_datetime'); ?></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach ($get_posts as $key => $get_posts) { ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $get_posts['endm_designation'];?></td>
                          <td><?php echo $get_posts['endm_designation_numbers'];?></td>
                          <td><?php echo $get_posts['created_datetime'];?></td>
                          <td>
                              <div class="btn-group">
                                <a href="<?php echo base_url('admin');?>/edit_post/<?php echo $get_posts['endm_id'];?>" class="btn  btn-twitter">Edit</a>
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
    