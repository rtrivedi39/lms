<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $title; ?>
	<!-- <small>Optional description</small> -->
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('home');?></a></li>
	<li><a href="<?php echo base_url('admin');?>/sections"><?php echo $this->lang->line('emprole_dashboard');?></a></li>
	<li class="active"><?php echo $this->lang->line('title');?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Your Page Content Here -->
	<!-- Small boxes (Stat box) -->
	<div class="box">
		<?php echo $this->session->flashdata('message'); ?>
		<div class="box-header">
		  <div style="float:left"><h3 class="box-title"><?php echo $page_title;?></h3></div>
		  <div style="float:right">
			 <?php  if($is_page_edit==0){ ?>
					 <a href="<?php echo base_url('admin');?>/add_employeerole">
					  <button class="btn  btn-info"><?php echo $this->lang->line('emprole_add');?></button>
					</a>
				<?php } ?>
					 <a href="javascript:history.go(-1)">
                      <button class="btn  btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
                    </a>
			</div>
		</div><!-- /.box-header -->
		<form role="form" method="post" action="<?php echo base_url()?>admin_employeerole_master/manage_employeerole/<?php echo $id;?>">
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
				<!-- form start -->
					<div class="form-group">
						<label for="exampleInputFile"><?php echo $this->lang->line('emprole_unit_name'); ?></label>
						<select name = "unit_id" class="form-control"> 
						  <option value=""> -- Select --  </option>
						  <?php if(isset($unilevels)){
							foreach($unilevels as $unitlelel){
								if($unitlelel->unit_id == $emprole_master_detail['unit_id'])
								{
								?>
							<option value="<?php echo $unitlelel->unit_id ?>" selected> <?php echo $unitlelel->unit_name;  ?></option>
								<?php	
									
								}else{
							?>
							<option value="<?php echo $unitlelel->unit_id ?>"> <?php echo $unitlelel->unit_name;  ?></option>
								<?php }
						  }
						  } ?>
					  </select>
					  <?php echo form_error('unit_id');?>
					</div>

					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('emprole_lavel_name_hi'); ?></label>
					  <input type="text" name="emprole_name_hi" value="<?php echo (@$emprole_master_detail['emprole_name_hi'] ? @$emprole_master_detail['emprole_name_hi']:'');?>" placeholder="<?php echo $this->lang->line('add_employeerole_with_hi'); ?>" class="form-control">
					  <?php echo form_error('emprole_name_hi');?>
					</div>
					<div class="form-group">
					  <label for="exampleInputPassword1"><?php echo $this->lang->line('emprole_lavel_name_en'); ?></label>
					  <input type="text" name="emprole_name_en" value="<?php echo (@$emprole_master_detail['emprole_name_en'] ? @$emprole_master_detail['emprole_name_en']:'');?>" placeholder="<?php echo $this->lang->line('add_employeerole_with_en'); ?>" class="form-control">
					  <?php echo form_error('emprole_name_en');?>
					</div>
					<div class="form-group">
					  <label for="emprole_short_name"><?php echo $this->lang->line('emprole_short_name'); ?></label>
					  <input type="text" name="emprole_short_name" value="<?php echo (@$emprole_master_detail['emprole_short_name'] ? @$emprole_master_detail['emprole_short_name']:'');?>" placeholder="<?php echo $this->lang->line('emprole_short_name'); ?>" class="form-control">
					  <?php echo form_error('emprole_short_name');?>
					</div>
					<div class="form-group">
					  <label for="emprole_payscale_gradepay"><?php echo $this->lang->line('emprole_payscale_gradepay'); ?></label>
					  <input type="text" name="emprole_payscale_gradepay" value="<?php echo (@$emprole_master_detail['emprole_payscale_gradepay'] ? @$emprole_master_detail['emprole_payscale_gradepay']:'');?>" placeholder="<?php echo $this->lang->line('emprole_payscale_gradepay'); ?>" class="form-control">
					  <?php echo form_error('emprole_payscale_gradepay');?>
					</div>
					<div class="form-group">
					  <label for="emprole_level"><?php echo $this->lang->line('emprole_level'); ?></label>
					  <input type="text" name="emprole_level" <?php echo $is_page_edit == 0 ? 'readonly' : '' ; ?> value="<?php echo (@$emprole_master_detail['emprole_level'] ? @$emprole_master_detail['emprole_level']:'');?>" placeholder="<?php echo $this->lang->line('emprole_level'); ?>" class="form-control">
					  <?php echo form_error('emprole_level');?>
					</div>	
					<div class="form-group">
					  <label for="level_class"><?php echo $this->lang->line('level_class'); ?></label>
					  <input type="text" name="level_class" <?php echo $is_page_edit == 0 ? 'readonly' : '' ; ?> value="<?php echo (@$emprole_master_detail['level_class'] ? @$emprole_master_detail['level_class']:'');?>" placeholder="<?php echo $this->lang->line('level_class'); ?>" class="form-control">
					  <?php echo form_error('level_class');?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					  <label for="emprole_total_posts"><?php echo $this->lang->line('emprole_total_posts'); ?></label>
					  <input type="number" name="emprole_total_posts" value="<?php echo (@$emprole_master_detail['emprole_total_posts'] ? @$emprole_master_detail['emprole_total_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_total_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_total_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_parmanent_posts"><?php echo $this->lang->line('emprole_parmanent_posts'); ?></label>
					  <input type="number" name="emprole_parmanent_posts" value="<?php echo (@$emprole_master_detail['emprole_parmanent_posts'] ? @$emprole_master_detail['emprole_parmanent_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_parmanent_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_parmanent_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_temporary_posts"><?php echo $this->lang->line('emprole_temporary_posts'); ?></label>
					  <input type="number" name="emprole_temporary_posts" value="<?php echo (@$emprole_master_detail['emprole_temporary_posts'] ? @$emprole_master_detail['emprole_temporary_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_temporary_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_temporary_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_bhopal_posts"><?php echo $this->lang->line('emprole_bhopal_posts'); ?></label>
					  <input type="number" name="emprole_bhopal_posts" value="<?php echo (@$emprole_master_detail['emprole_bhopal_posts'] ? @$emprole_master_detail['emprole_bhopal_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_bhopal_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_bhopal_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_delhi_posts"><?php echo $this->lang->line('emprole_delhi_posts'); ?></label>
					  <input type="number" name="emprole_delhi_posts" value="<?php echo (@$emprole_master_detail['emprole_delhi_posts'] ? @$emprole_master_detail['emprole_delhi_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_delhi_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_delhi_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_jabalpur_posts"><?php echo $this->lang->line('emprole_jabalpur_posts'); ?></label>
					  <input type="number" name="emprole_jabalpur_posts" value="<?php echo (@$emprole_master_detail['emprole_jabalpur_posts'] ? @$emprole_master_detail['emprole_jabalpur_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_jabalpur_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_jabalpur_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_indore_posts"><?php echo $this->lang->line('emprole_indore_posts'); ?></label>
					  <input type="number" name="emprole_indore_posts" value="<?php echo (@$emprole_master_detail['emprole_indore_posts'] ? @$emprole_master_detail['emprole_indore_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_indore_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_indore_posts');?>
					</div>
					<div class="form-group">
					  <label for="emprole_gwalior_posts"><?php echo $this->lang->line('emprole_gwalior_posts'); ?></label>
					  <input type="number" name="emprole_gwalior_posts" value="<?php echo (@$emprole_master_detail['emprole_gwalior_posts'] ? @$emprole_master_detail['emprole_gwalior_posts']:0);?>" placeholder="<?php echo $this->lang->line('emprole_gwalior_posts'); ?>" class="form-control">
					  <?php echo form_error('emprole_gwalior_posts');?>
					</div>
				</div>				
			</div><!-- /.row -->
		</div><!-- /.box-body -->
		<div class="box-footer">
			<button class="btn btn-primary" onclick="return confir_post_data();" type="submit"><?php echo $this->lang->line('submit_botton'); ?></button>
		</div>
		</form>
	</div><!-- /.box -->
</section><!-- /.content -->
