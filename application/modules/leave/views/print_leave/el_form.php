
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
  <div class="row" id="el_form">
    <div class="col-md-12">
        <div class="no-print">  
          <p class="alert alert-info">
          प्रिंट निकालने के लिए 'प्रिंट' बटन दबाये, और प्रिंट की कॉपी स्थापना में जमा करे|</p>      
        </div> 
      <div style="border:1px dashed #333; padding:20px;">    
      <div class="row">      
        <table class="table borderless">
        <tr><td width="50%"><p><b>XV-OR-38</b></p></td>      
        <td class="text-right" width="50%"><p><b>F. R. Form</b> <br/>(See S.R. below F.R. 74)</p></td></tr>
      </table>     
    </div>
    <div class="row">          
      <div class="col-md-12 text-center">
        <h2>APPLICATION FOR LEAVE</h2>
        <span>(For both Gazetted and Non--Gazetted Govt. Servants)</span>
        <br/>
        <label> --------- </label>
      </div>
    </div>
    <div class="row">          
      <div class="col-md-12 text-justify">
        <p><b>NOTE :- </b>Items 1 to 11 must be filled in by the applicants. Items 12 and 13 applies only in  Case of Gazetted Officer. Items 14 and 15 
        apply only in the case of the Non-Gazetted Officers.</p>
      </div>
    </div>  
    <div class="row">          
      <div class="col-md-12 text-left">
      <table class="table borderless">
        <tr><td width="10%">1. </td><td width="40%">Employee Code</td><td width="50%"><?php echo $user_details[0]->emp_unique_id; ?></td></tr>
        <tr><td>2. </td><td>Name of applicant</td><td><?php echo  $user_details[0]->emp_full_name; ?></td></tr>
        <tr><td>3. </td><td>Mobile/telephone</td><td><?php echo  $user_details[0]->emp_mobile_number; ?></td></tr>
        <tr><td>4. </td><td>Leave rules applicable</td><td><?php echo $rule; ?></td></tr>
        <tr><td>5. </td><td>Post held</td><td><?php echo $user_details[0]->emprole_name_en; ?></td></tr>
        <tr><td>6. </td><td>Department & Office</td><td><?php echo $depart; ?></td></tr>
        <tr><td>7. </td><td>Pay + Grade pay</td><td><?php echo $user_details[0]->emp_gradpay; ?></td></tr>
        <tr><td>8. </td><td> House rent allowances, Conveyance allowances on other compensatory allowances(*drawn in the present post)</td>
        <td><?php echo $user_details[0]->emp_houserent; ?></td></tr>
        <tr><td>9. </td><td>Nature & Period of leave applied for and date from which required</td>
            <td><b><?php echo leaveType($leave_details->emp_leave_type)." From ".get_date_formate($leave_details->emp_leave_date)." to ".get_date_formate($leave_details->emp_leave_end_date)."(".$leave_details->emp_leave_no_of_days." Days) "; ?></b><br/>
        <?php echo $leave_details->emp_leave_is_HQ == 1 ? "With"  : "Without" ;?> HQ leave permission (<?php echo $leave_details->emp_leave_is_HQ == 1 ? get_date_formate($leave_details->emp_leave_HQ_start_date)." to ".get_date_formate($leave_details->emp_leave_HQ_end_date)  : "" ;?>)</td></tr>
        <tr><td>10. </td><td>Ground on which leave is applied for</td><td><?php echo $leave_details->emp_leave_reason; ?></td></tr>
        <tr><td>11. </td><td>Date of return from last leave, the nature and period of that leave</td><td></td></tr>
        <tr><td>12. </td><td>Leave address, if granted</td><td><?php echo $leave_details->emp_leave_address; ?></td></tr>
        <tr><td>13. </td><td>Leave Remaining(Before approval)</td><td><?php //echo $leave_details->leave_remaining != 0 ? $leave_details->leave_remaining : calculate_el(get_leave_balance($user_details[0]->emp_id,'el')); ?></td></tr>
        <tr><td>14. </td><td>Leave application date </td><td><?php echo get_date_formate($leave_details->emp_leave_create_date) ?></td></tr>
		<tr><td> </td><td>On leave work Employee</td><td><?php echo $leave_details->emp_onleave_work_allot; ?></td></tr>
	 </table>
          
      </div>
    </div>
    <div class="row">          
      <div class="col-md-12 text-justify">
        <p>I undertake to refund the difference between the leave salary drawn during leave on average pay/commuted leave and that admissible during 
        leave on half average pay/half pay leave, which would not have been admissible had the proviso to F. R. 81(b) (ii)/M.B.F.R. 79(c) Madhya Pradesh 
        Civil services Leave Rules, 1977, not been applied in the event of my retirement from service at the end or during the currency of the leave.</p>
      </div>
    </div>
    <br/>
    <div class="row"> 
      <div class="col-md-12">  
      <table class="table borderless">  
        <tr><td width="50%"><p>Date:-  <?php echo $now; ?></p></td>
        <td width="50%"> <p>Signature & Designation </p> </td></tr>
      
        <tr><td width="50%"><p>15. Remark and/ or recommendation of the Controlling Officer.</p></td><td></td></tr>
        <tr><td width="50%"> <p>Date <?php echo ($leave_details->emp_leave_forword_type == '1' || $leave_details->emp_leave_forword_type == '2' ) ? ':- '.get_date_formate($leave_details->emp_leave_forword_date)  :'......................'; ?></p></td>
        <td width="50%"><p><?php echo ($leave_details->emp_leave_forword_type == '1' || $leave_details->emp_leave_forword_type == '2' ) ? getemployeeName($leave_details->emp_leave_forword_emp_id, true).'('.get_employee_role($leave_details->emp_leave_forword_emp_id).')'  :''; ?>
		<p>Signature & Designation </p></td></tr>

        <tr><td width="50%"><p>16. Report of the Audit Officer.</p></td><td></td></tr>
        <tr><td width="50%"> <p>Date ......................</p></td>
        <td width="50%"><p>Signature & Designation </p></td></tr>

        <tr><td width="50%"><p>17. Statement of leave granted to applicant previous to this application.</p></td> <td></td> </tr>   
        <tr><td width="50%"> <p>(1) Nature of leave <b><?php //echo ucwords($leave_details->emp_leave_type); ?>EL</b></p></td>
        <td width="50%"> <p>(2) In current year <b><?php ?></b></p></td></tr>
        <tr><td width="50%"> <p>(3) During last year <b><?php ?></b></p></td>
        <td width="50%"><p>(4) Total <b><?php ?></b></p></td></tr>

        <tr><td colspan="2"><p>18. Certified that leave on average pay/earned leave for 
                    <b><?php echo get_date_formate($leave_details->emp_leave_date,'F'); ?></b> month and <b><?php echo $leave_details->emp_leave_no_of_days; ?></b> day(s) from <b> <?php echo get_date_formate($leave_details->emp_leave_date); ?></b> to <b><?php echo get_date_formate($leave_details->emp_leave_end_date); ?></b> 
          is admissible under <b>........................... </b> of the <b>.......................... </b>.</p> </td></tr>      
        <tr><td width="50%"><p>Date ......................</p></td>
        <td width="50%"><p>Signature & Designation </p></td></tr>

        <tr><td colspan="2"><p>19. Order of the Sanctioning Authority <b></b></p> </td> </tr>     
          <tr><td width="50%"> <p>Date <?php echo ($leave_details->emp_leave_approval_type == '1' || $leave_details->emp_leave_approval_type == '2' ) ? ':- '.get_date_formate($leave_details->emp_leave_approvel_date)  :'......................'; ?></p></td>
        <td width="50%"><p><?php echo ($leave_details->emp_leave_approval_type == '1' || $leave_details->emp_leave_approval_type == '2' ) ? getemployeeName($leave_details->emp_leave_approval_emp_id, true).'('.get_employee_role($leave_details->emp_leave_approval_emp_id).')'  :''; ?>
		<p>Signature & Designation </p></td></tr>
        </table>
        </div>
      </div>
    </div>
    <div class="row no-print">   
    <hr/>       
      <div class="col-md-3 text-center">
         <button type="button" onclick="printContents('el_form')" class="btn btn-primary" name="">प्रिंट करे</button>
      </div>
      <div class="col-md-3 text-center">
       <button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
       </div>
       <div class="col-md-3 text-center">
        
       </div>
       <div class="col-md-3 text-center">
     
       </div>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->


    