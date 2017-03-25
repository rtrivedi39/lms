
<section class="content-header">
  <h1><?php echo $title?></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url(); ?>leave/"><i class="fa fa-index"></i> Leave</a></li>
    <li class="active">Print</li>
  </ol>
</section>
    <?php 
      $depart = 'म.प्र. शासन विधि और विधायी कार्य विभाग, भोपाल';
      $now = date('d/m/Y');
      $user_details = get_user_details($leave_details->emp_id);  
    ?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="no-print">  
          <p class="alert alert-info">
          प्रिंट निकालने के लिए 'प्रिंट' का बटन दबायें, और प्रिंट की कॉपी यदि आवश्यक हो तो स्थापना शाखा में जमा करें|</p>      
        </div> 
      <div style="border:1px dashed #333; padding:20px;">  
     
    <div class="row">          
      <div class="col-md-12 text-center">
        <h2>आवेदन पत्र</h2>
        <h3><?php echo leaveType($leave_details->emp_leave_type, true); ?></h3>      
        <label> --------- </label>
      </div>
    </div>      
    <div class="row">          
      <div class="col-md-12 text-left">
      <table class="table borderless">
        <tr><td width="10%">1. </td><td width="40%">इम्पलाई कोड</td><td width="50%"><?php echo $user_details[0]->emp_unique_id; ?></td></tr>
        <tr><td>2. </td><td>शासकीय सेवक का नाम</td><td><?php echo  $user_details[0]->emp_full_name_hi; ?></td></tr>
        <tr><td>3. </td><td>दूरभाष/ मोबाइल</td><td><?php echo  $user_details[0]->emp_mobile_number; ?></td></tr>
        <tr><td>4. </td><td>पदनाम</td><td><?php echo $user_details[0]->emprole_name_hi; ?></td></tr>
        <tr><td>5. </td><td>विभाग और कार्यालय</td><td><?php echo $depart; ?></td></tr>
        <tr><td>6. </td><td>अवकाश दिनांक</td><td><b><?php echo leaveType($leave_details->emp_leave_type, true)."</b>, <b>".get_date_formate($leave_details->emp_leave_date)."</b> से <b>".get_date_formate($leave_details->emp_leave_end_date)."</b> ( <b>".$leave_details->emp_leave_no_of_days."</b> दिन ) "; ?></td></tr>
        <tr><td>7. </td><td>मुख्यालय छोड़ने की अनुमति</td><td><?php echo ($leave_details->emp_leave_is_HQ) == 1 ? "हाँ" .' ( '.get_date_formate($leave_details->emp_leave_HQ_start_date).'-'.get_date_formate($leave_details->emp_leave_HQ_end_date).' ) ' : "नहीं" ;?>  </td></tr>
        <tr><td>8. </td><td>कारण</td><td><?php echo $leave_details->emp_leave_reason; ?></td></tr>
		<tr><td>9. </td><td>अवकाश पर होने पर कार्य का आवंटन</td><td><?php echo $leave_details->emp_onleave_work_allot; ?></td></tr>
	 </table>
      </div>
    </div>   
    <br/><br/><br/>
    <div class="row"> 
      <div class="col-md-12">  
      <table class="table borderless">  
        <tr><td width="50%"><p>दिनांक <?php echo $now; ?></p></td>
        <td width="50%"> <p>हस्ताक्षर </p> </td></tr>
      <br/>
        <tr><td width="50%"><p>9.  अग्रेषित अधिकारी </p></td><td></td></tr>
        <tr><td width="50%"> <p>दिनांक <?php echo ($leave_details->emp_leave_forword_type == '1' || $leave_details->emp_leave_forword_type == '2' ) ? ':- '.get_date_formate($leave_details->emp_leave_forword_date)  :'......................'; ?></p></td>
        <td width="50%"><p><?php echo ($leave_details->emp_leave_forword_type == '1' || $leave_details->emp_leave_forword_type == '2' ) ? getemployeeName($leave_details->emp_leave_forword_emp_id, true).'('.get_employee_role($leave_details->emp_leave_forword_emp_id).')'  :''; ?><br/>
		हस्ताक्षर और पदनाम </p></td></tr> 
		<tr><td width="50%"><p>10. अनुमोदन अधिकारी </p></td><td></td></tr>
        <tr><td width="50%"> <p>दिनांक <?php echo ($leave_details->emp_leave_approval_type == '1' || $leave_details->emp_leave_approval_type == '2' ) ? ':- '.get_date_formate($leave_details->emp_leave_approvel_date)  :'......................'; ?></p></td>
        <td width="50%"><p><?php echo ($leave_details->emp_leave_approval_type == '1' || $leave_details->emp_leave_approval_type == '2' ) ? getemployeeName($leave_details->emp_leave_approval_emp_id, true).'('.get_employee_role($leave_details->emp_leave_approval_emp_id).')'  :''; ?><br/>
		हस्ताक्षर और पदनाम </p></td></tr>

            
        </table>
        </div>
      </div>
    </div>
    <div class="row no-print">   
    <hr/>       
      <div class="col-md-3 text-center">
         <button type="button" onclick="print_content()" class="btn btn-primary" name="">प्रिंट करे</button>
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


    