<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $this->lang->line('notice_heading'); ?></li>
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
                      <a href="<?php echo base_url('admin');?>/add_notice">
                        <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
                      </a>
                    </div>
                    <div style="float:right;margin-right: 10px;">
                        <a href="javascript:history.go(-1)">
                            <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
				 <div class="box-body">
                 <?php if($this->session->flashdata('update') || $this->session->flashdata('insert') || $this->session->flashdata('delete') ){ ?>  <div class="alert alert-success alert-dismissable hideauto">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <strong>
                          <?php  echo $this->session->flashdata('update');
                          echo $this->session->flashdata('delete');
                          echo $this->session->flashdata('insert'); ?>
                      </strong><br>
                  </div>
                  <?php }?>

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th width="20%">Subject</th>
                        <th width="30%">Description</th>
                        <th>Type/Sections</th>
                        <!--<th>Range of Date</th>-->
                        <th>Status</th>
                        <th width="100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php  error_reporting(1);
						if(isset($get_notice) && count($get_notice)>0){?>
                      <?php $i=1; 
							foreach ($get_notice as $key =>$notice) { ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $notice['notice_subject']; ?></td>
                          <td><?php echo $notice['notice_description'];?></td>
                          <td><?php echo $notice['notice_title'] ."/".$notice['section_name_en'];?></td>
                          <!--<td><?php //echo date("d-m-Y", strtotime($notice['notice_from_date'])) ." - ".date("d-m-Y", strtotime($notice['notice_to_date'])) ; ?></td>-->
                          <td><?php if ($notice['notice_is_active'] == 1) echo "Active"; else echo "In Active"; ?></td>
                          <td>
                              <div class="btn-group">
                                <a href="<?php echo base_url('admin');?>/edit_notice/<?php echo $notice['notice_id'];?>" class="btn  btn-twitter">Edit</a>
                                <a href="<?php echo base_url('admin');?>/delete_notice/<?php echo $notice['notice_id'];?>" onclick="return is_delete();" class="btn  btn-danger">Delete</a>
                              </div>
                            </td>
                        </tr>
                      <?php $i++; } }else {?>
						<tr>
							<td>
								No record found
                            </td>
                        </tr>
					  <?php }?>
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
    