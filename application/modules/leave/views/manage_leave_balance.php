
<section class="content-header">
    <h1>
        <?php echo $title ?>(<?php echo date('Y');?>)

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave Balance</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
  <?php //pre($leave_balance); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">
						<i class="fa fa-inbox"></i> <?php echo $title_tab; ?> 
					</h3>
					<div class="pull-right tools">
						<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('Back_button_label'); ?></button>
						<a class="btn btn-primary" href="<?php echo base_url(); ?>leave/employee_list">List</a>
					</div>
			   </div><!-- /.box-header -->
			   <div class="box-header">
					<h4 class="bg-info"> (<?php echo $emoployee_det = getemployeeName($id, true) ." / ". get_employee_role($id); ?>)</h4>
			   </div><!-- /.box-header -->
			   <?php
				 $attributes_update_leave_balance = array('class' => 'form-unis', 'id' => 'formupdate_leave_balance', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
				echo form_open('leave/leave/update_leave_balance', $attributes_update_leave_balance);
				?>  
				
                <div class="box-body">
				<input type="hidden" value="<?php echo $id; ?>" name="emp_id">
                    <div class="form-group col-md-12">
						<label for="cl"> Casual leave <?php echo $this->lang->line('casual_leave'); ?><span class="text-danger">*</span></label>
						<input type="number"   name="cl_leave" id="" min="0" max="13" step=".5" value="<?php echo $leave_balance[0]['cl_leave'] ; ?>" class="form-control">
						<?php echo form_error('cl_leave'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="cl"> Optional leave <?php echo $this->lang->line('optional_leave'); ?><span class="text-danger">*</span></label>
						<input type="number"   name="ol_leave" id="" min="0" max="3" value="<?php echo $leave_balance[0]['ol_leave'] ; ?>" class="form-control">
						<?php echo form_error('ol_leave'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="cl"> Earned leave <?php echo $this->lang->line('earned_leave'); ?><span class="text-danger">*</span></label>
						<input type="number"   name="el_leave" id=""  value="<?php echo $leave_balance[0]['el_leave'] ; ?>" class="form-control">
						<?php echo form_error('el_leave'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="cl"> Half pay leave <?php echo $this->lang->line('half_pay_leave'); ?><span class="text-danger">*</span></label>
						<input type="number"   name="hpl_leave" id=""  value="<?php echo $leave_balance[0]['hpl_leave'] ; ?>" class="form-control">
						<?php echo form_error('hpl_leave'); ?>
					</div>
					<div class="form-group col-md-12">
						<label for="jd"> Joining date<span class="text-danger">*</span></label>
						<input type="text"   name="joining_date" id=""  value="<?php echo !empty($emp_details[0]['emp_joining_date']) ? get_date_formate($emp_details[0]['emp_joining_date'],'d-m-Y') : '' ; ?>" class="form-control" placeholder="dd-mm-yyyy">
						<?php echo form_error('joining_date'); ?>
					</div>
					
					<div class="form-group col-md-12">
						<label for="jd"> Class <span class="text-danger">*</span></label>
							<select name="emp_class" class="form-control">
							<?php foreach(employees_class() as $key => $value){?>
								<option value="<?php echo $key;?>" <?php echo $key == $emp_details[0]['emp_class'] ? 'selected' : '' ?>><?php echo $value;?></option>
						<?php 	}?> 
						</select>
						<?php echo form_error('emp_class'); ?>
					</div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                 <button class="btn btn-primary" type="submit" onclick="return confirm('क्या आप <?php echo $emoployee_det ; ?> के अवकाश में बदलाव करना चाहते है|');" id=""><?php echo $this->lang->line('submit_botton'); ?></button>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->


