<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
        <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('admin');?>/sections"></a></li>
        <li class="active"><?php echo $page_title; ?></li>
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
                    <div style="float:left"><h3 class="box-title"><?php echo $page_title;?></h3></div>
                    
                    <?php
                    if($is_page_edit==0){ ?>
                        <div style="float:right;padding-left: 10px;">
                            <a href="<?php echo base_url('admin');?>/add_notice">
                                <button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?></button>
                            </a>
                        </div>
                    <?php } ?>
                    <div style="float:right;">
                        <a href="javascript:history.go(-1)">
                            <button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>admin_notice_master/manage_notice<?php if(isset($id)){ echo '/'.$id;} ?>">
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('notice_subject'); ?></label>
                                    <input type="text" name="notice_subject" id="notice_subject" value="<?php echo (@$notice1_detail['notice_subject'] ? @$notice1_detail['notice_subject']:''); echo isset($input_data['notice_subject'])? $input_data['notice_subject'] : '' ;  ?>" placeholder="<?php echo $this->lang->line('notice_subject'); ?>" class="form-control">
                                    <?php echo form_error('notice_subject');?>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('notice_description'); ?></label>
                                    <div class='box-body pad'>
                                        <textarea  placeholder="Place some text here" id="edit_textarea1"  name="edit_textarea1" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (@$notice1_detail['notice_description'] ? @$notice1_detail['notice_description']:'') ; echo isset($input_data['edit_textarea1'])? $input_data['edit_textarea1'] : '' ; ?></textarea>
                                        <?php echo form_error('edit_textarea1');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo $this->lang->line('notice_attachment'); ?></label>
                                    <input type="file" name="notice_attachment">
                                </div>
                                <?php if(isset($notice1_detail['notice_attachment'])){ ?>
                                    <div class="form-group">
                                        <a href="<?php echo base_url(); ?>uploads/notice/<?php echo $notice1_detail['notice_attachment'] ?>" target="_blank">Attectment</a>
                                    </div>
                                <?php } ?>
                             </div><!-- /.box-body -->
                             </div><!-- /.box -->
                        </div>


                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('notice_type_id'); ?></label>
                                    <select class="form-control" name="notice_type_id" id="notice_type_id">
                                        <option value="<?php echo (@$notice1_detail['notice_type_id'] ? @$notice1_detail['notice_type_id']:'');?>"><?php echo (@$notice1_detail['notice_title'] ? @$notice1_detail['notice_title']:'Select Type');?></option>
                                        <?php foreach ($get_notice_type as $noticetype=>$nid) { ?>
                                            <option value="<?php echo $nid['notice_id']; ?>"><?php echo $nid['notice_title'];?></option>
                                        <?php }  ?>
                                    </select>
                                    <?php echo form_error('notice_type_id');?>
                                </div>
                                <div class="form-group" id="section_div" style="display: none">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('notice_section'); ?></label>
                                    <select class="form-control" name="notice_section" id="notice_section">
                                        <option value="<?php echo (@$notice1_detail['notice_section_id'] ? @$notice1_detail['notice_section_id']:'');?>"><?php echo (@$notice1_detail['section_name_en'] ? @$notice1_detail['section_name_en']:'Select Type');?></option>
                                        <?php foreach ($get_notice_section as $getsection) { ?>
                                            <option value="<?php echo $getsection['section_id']; ?>"><?php echo $getsection['section_name_hi'];?></option>
                                        <?php }  ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('notice_remark'); ?></label>
                                    <input type="text" name="notice_remark" id="notice_remark" placeholder="<?php echo $this->lang->line('notice_remark'); ?>" value="<?php echo (@$notice1_detail['notice_remark'] ? @$notice1_detail['notice_remark']:'');  echo isset($input_data['notice_remark'])? $input_data['notice_remark'] : '' ;?>" placeholder="" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">From Date</label>
                                    <input type="text" name="notice_from_date" id="notice_from_date" placeholder="dd-mm-yyyy" value="<?php echo (@$notice1_detail['notice_from_date'] ? @$notice1_detail['notice_from_date']:''); echo isset($input_data['notice_from_date'])? $input_data['notice_from_date'] : '' ;?>" placeholder="" class="form-control">
                                    <?php echo form_error('notice_from_date');?>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">To Date</label>
                                    <input type="text" name="notice_to_date" id="notice_to_date" placeholder="dd-mm-yyyy" value="<?php echo (@$notice1_detail['notice_to_date'] ? @$notice1_detail['notice_to_date']:''); echo isset($input_data['notice_to_date'])? $input_data['notice_to_date'] : '' ;?>" placeholder="" class="form-control">
                                    <?php echo form_error('notice_to_date');?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Notice Status</label>
                                    <select class="form-control" name="notice_status" id="notice_status">
                                        <?php if ($notice1_detail['notice_is_active'])
                                        { ?>
                                        <option value="<?php echo (@$notice1_detail['notice_is_active'] ? @$notice1_detail['notice_is_active']:'');?>"><?php if($notice1_detail['notice_is_active'] == 1) echo 'Active'; else echo 'In Active' ;?></option>
                                        <?php } ?>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                         </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit" name="savenotice" id="savenotice" value="1"><?php echo $this->lang->line('submit_botton'); ?></button>
                            </div>
                        </div><!-- /.box -->
                    </div>
                 </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    </div><!-- /.row -->
    <!-- Main row -->
</section><!-- /.content -->
<!-- jQuery 2.1.4 -->
<script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#section_div').hide();
        $('#notice_type_id').change(function(){
          //  alert('hello');
            if($('#notice_type_id').val() == '2'){
                $('#section_div').show();
            } else {
                $('#section_div').hide();
            }

        })
    })
</script>


    