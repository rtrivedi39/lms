<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
        <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('biometric_report');?>"></a></li>
        <li class="active"><?php echo $title_tab; ?></li>
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
                    <?php if($is_page_edit == 0){ ?>
                        <div style="float:right;padding-left: 10px;">
                           <a href="<?php echo base_url('biometric_report');?>/add_report">
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
                <?php if(isset($id)){ $id =  '/'.$id;} else { $id = null;} ?>
                   <?php 
                 $attributes_manage_report = array('class' => 'form-signin', 'id' => 'formmanage_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('biometric_report/manage_report'.$id, $attributes_manage_report);
                ?> 
       
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('report_name'); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="report_name" id="report_name" value="<?php echo (@$report_detail['report_name'] ? @$report_detail['report_name']:''); echo isset($input_data['report_name'])? $input_data['report_name'] : '' ;  ?>" placeholder="<?php echo $this->lang->line('report_name'); ?>" class="form-control">
                                    <?php echo form_error('report_name');?>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('report_description'); ?> <span class="text-danger">*</span></label>
                                    <div class='box-body pad'>
                                        <textarea  placeholder="Place some text here" id="report_description"  name="report_description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo (@$report_detail['report_description'] ? @$report_detail['report_description']:'') ; echo isset($input_data['report_description'])? $input_data['report_description'] : '' ; ?></textarea>
                                        <?php echo form_error('report_description');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo $this->lang->line('report_doccument'); ?> <span class="text-danger">*</span></label>
                                    <input type="file" name="report_doccument" accept=".pdf" >
                                </div>
                                <?php if(isset($report_detail['report_doccument'])){ ?>
                                    <div class="form-group">
                                        <a href="<?php echo base_url(); ?>uploads/notice/<?php echo $report_detail['report_doccument'] ?>" target="_blank">Attachment</a>
                                    </div>
									<input type="hidden" name="report_doccument_select" value="<?php echo $report_detail['report_doccument'] ?>">
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
                                    <label for="exampleInputFile"><?php echo $this->lang->line('report_type'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="report_type" id="report_type">
                                        <?php $get_report_type = get_report_type();
										foreach ($get_report_type as $id => $value) {
											$selected = ((@$report_detail['report_type'] != '' && $report_detail['report_type'] == $id )  || (@$input_data['report_type'] != '' && $input_data['report_type'] == $id ) ) ? 'selected' : '';
											?>
                                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
                                        <?php }  ?>
                                    </select>
                                    <?php echo form_error('report_type');?>
                                </div>
								
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('report_month'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="report_month" id="report_month">
                                        <?php $month = months(null, true);
										foreach ($month as $id => $value) { 
											$selected = ((@$report_detail['report_month'] != '' && $report_detail['report_month'] == $id )  || (@$input_data['report_month'] != '' && $input_data['report_month'] == $id ) ) ? 'selected' : '';
										?>
                                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
                                        <?php }  ?>
                                    </select>
                                </div>

								<div class="form-group" id="">
									<label for="exampleInputFile">  <?php echo $this->lang->line('report_year'); ?><span class="text-danger">*</span></label>
									<select name="report_year" class="form-control"  id="report_year">
										<?php $i = '2015';
										while($i <= date('Y')) { 
											$selcted =  $i == date('Y') ? 'selected' : '';
										?>
											<option value="<?php echo $i ; ?>" <?php echo $selcted; ?>><?php echo $i ;?></option>
										<?php $i++; } ?>
									</select>
								</div>
                                                            
                                <div class="form-group">
                                    <label for="exampleInputFile"> <?php echo $this->lang->line('report_status'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="report_status" id="report_status">
                                        <?php if ($report_detail['report_status'])
                                        { ?>
                                        <option value="<?php echo (@$report_detail['report_status'] ? @$report_detail['report_status']:'');?>"><?php if($report_detail['report_status'] == 1) echo 'Active'; else echo 'In Active' ;?></option>
                                        <?php } ?>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                         </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary" type="submit" name="save_report" id="save_report" value="1"><?php echo $this->lang->line('submit_botton'); ?></button>
                           
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


    