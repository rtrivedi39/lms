<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<section class="content-header">
    <h1> <?php echo $title ?></h1>
    <ol class="breadcrumb">
         <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Under employee</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-info" id="printdiv">
		<div class="box-header">
			<h3><?php echo $this->lang->line('under_employee_title'); ?></h3>
			<div class="box-tools pull-right">
				<button onclick="printContents('printdiv')" class="btn btn-primary no-print">Print</button>
				<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<?php function get_class_role($role){
					if($role == 28){
						return 'class="bg-info"';
					} 
				}
				
				//$lists = get_list(EMPLOYEES, 'designation_id', array('designation_id >' => '2', 'designation_id <' => '9', 'emp_status' => '1', 'emp_is_retired' => '0'), 'ASC');					
				$lists = get_list(EMPLOYEES, 'designation_id', "`role_id` in(2,3,4,5,6,7,8,14,37,15) and `emp_status` = '1' and `emp_is_retired` = '0' and 	`emp_is_parmanent` = '1'", 'ASC');					
				$emp_lists = array();
				foreach($lists as $key => $value){
					$emp_lists[] = $value['emp_id'];
				}				
				
				if(count($emp_lists > 0)){
					$i = 1;
					foreach($emp_lists as $emp){ ?>			
						<div class="col-md-4 col-sm-6 col-xs-12">
							<ul>
							<h4><?php echo $i.'. '.getemployeeName($emp, true); ?>/ <?php echo  get_employee_role($emp); ?></h4>
								<?php if(!empty($this->leave_model->getUnderEmployeeUser($emp))){
									$j = 1;
									foreach($this->leave_model->getUnderEmployeeUser($emp) as $row){											
										echo '<li '. get_class_role($row->designation_id).'>'.$j.'. '.get_employee_gender($row->emp_id).' '.$row->emp_full_name_hi.'/ <b>'.getemployeeRole($row->designation_id).'</b></li>'; 
									$j++; }
								 } else {
									echo "No under employee found";
								 } ?>  
							</ul>
						</div>
					<?php if($i%3 == 0) { echo '</div><hr/><div class="row">'; } ?>		
					
					<?php $i++; }
				} else {
					echo 'No lists found';
				}					?>					
			</div><!-- /.row -->
		</div><!-- /.body- box -->
	</div><!-- /.box -->
</section><!-- /.content -->


