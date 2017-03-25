
<section class="content-header">
  <h1><?php echo $title?></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url(); ?>leave/"><i class="fa fa-index"></i> Leave</a></li>
    <li class="active">Print</li>
  </ol>
</section>
<?php 
    $rule = 'M.P. Civil services leave rule 1977';
    $depart = 'Law & Legistative Affairs Department, Bhopal';
    $now = date('d/m/Y');
    $user_details = get_user_details($leave_details->emp_id); 
?>
<!-- Main content -->
<section class="content">
  <div class="row" id="form">
    <div class="col-md-12">
        <div class="no-print">  
          <p class="alert alert-info">प्रिंट निकालने के लिए 'प्रिंट' बटन दबाये, और प्रिंट की कॉपी स्थापना में जमा करे|</p>      
        </div> 
        <div style="border:1px dashed #333; padding:10px;">    
		<div class="row">          
			<div class="col-md-12 text-center">
				<h3><u>APPLICATION FOR CHILD CARE LEAVE</u></h3>       
			</div>
		</div>   
		<div class="row">          
			<div class="col-md-12 text-left">
				<table class="table borderless">
					<tr><td width="10%">1. </td><td width="40%">Employee Code</td><td width="50%"><?php echo $user_details[0]->emp_unique_id; ?></td></tr>
					<tr><td>2. </td><td>Name of applicant</td><td><?php echo  $user_details[0]->emp_full_name; ?></td></tr>
					<tr><td>3. </td><td>Designation</td><td><?php echo $user_details[0]->emprole_name_en; ?></td></tr>
					<tr><td>4. </td><td>Department/Office/Section</td><td><?php echo $depart; ?></td></tr>
					<tr><td>5. </td><td>Name of child for whom Child Care leave is applied for</td><td>.......................</td></tr>
					<tr><td>6. </td><td>Date of Birth of Child</td> <td>.......................</td></tr>
					<tr><td>7. </td><td>Date on which child will be attaining 18 years.</td><td>.......................</td></tr>
					<tr><td>8. </td><td>Is the Child among the two eldest Children</td><td>.......................</td></tr>
					<tr><td>9. </td><td>EL in credit(as on date)</td><td>.......................</td></tr>
					<tr><td>10. </td><td>Period of leave Days</td><td><b><?php echo leaveType($leave_details->emp_leave_type)." From ".get_date_formate($leave_details->emp_leave_date)." to ".get_date_formate($leave_details->emp_leave_end_date)."(".$leave_details->emp_leave_no_of_days." Days) "; ?></b></td></tr>
					<tr><td>11. </td><td>Reason(s) for leave applied for</td><td><?php echo $leave_details->emp_leave_reason != '' ? $leave_details->emp_leave_reason : '.......................'; ?></td></tr>
					<tr><td>12. </td><td>Total Child Care Leave availed till date</td><td><?php //echo get_leave_balance($user_details[0]->emp_id,'child'); ?> Days</td></tr>
					<tr><td>13. </td><td>(a) Whether permission to leave station is required </td><td><?php echo $leave_details->emp_leave_is_HQ == 1 ? "Yes"  : "No" ;?></td></tr>
					<tr><td></td><td>(b) If Yes, Address during leave period </td><td><?php echo $leave_details->emp_leave_is_HQ == 1 ? get_date_formate($leave_details->emp_leave_HQ_start_date)." to ".get_date_formate($leave_details->emp_leave_HQ_end_date)  : "" ;?></td></tr>
					<tr><td>14. </td><td>Date of return from last leave, the nature and period of that leave</td><td>.......................</td></tr>    
					<tr><td>15. </td><td>Leave application date </td><td><?php echo get_date_formate($leave_details->emp_leave_create_date) ?></td></tr>
				</table>			  
			</div>
		</div>  
		<div class="row"> 
			<div class="col-md-12">  
				<table class="table borderless">  
					<tr><td width="50%"><p>Date:-  <?php echo $now; ?></p></td>
					<td width="50%"> <p>Signature of applicant <br/>Pay Card No. ............ </p> </td></tr>			  
					<tr><td colspan="2"><h5 class="text-center"><b><u>Remark of the Controlling Officer.</b></u></h5></td></tr>
					<tr><td colspan="2"><p class="text-center">Leave Recommended/Leave Not Recommended.</p></td></tr>
					<tr><td> <p>Date .......................</p></td>
					<td><p>Signature ............................</p>
					<p>Designation ..........................</p>
					<p>Office <b><?php echo $depart; ?></b></p></td></tr>			 
				</table>
			</div>
		</div>
		<div class="row no-print">   
		<hr/>       
			<div class="col-md-3 text-center">
				<button type="button" onclick="printContents('form')" class="btn btn-primary" name="">प्रिंट करे</button>
			</div>
			<div class="col-md-3 text-center">
		   <button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
			</div>
			<div class="col-md-3 text-center">
			
			</div>
			<div class="col-md-3 text-center">
		 
			</div>
		</div><!-- /.row -->
    </div><!-- /.border -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->


    