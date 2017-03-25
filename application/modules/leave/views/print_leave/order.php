<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>leave/"><i class="fa fa-index"></i> Leave</a></li>
        <li class="active">Print</li>
    </ol>
</section>
<?php
$emp_details = get_list(EMPLOYEES,null,array('emp_id'=>$this->session->userdata("emp_id"))); 
$userrole = checkUserrole();

$depart = 'म.प्र. शासन विधि और विधायी कार्य विभाग, भोपाल';
$now = date('d/m/Y');
$user_details = get_user_details($leave_details->emp_id);
$emp_detail_gender = $user_details[0]->emp_detail_gender;
if($emp_detail_gender == 'm'){
	$emp_detail_gender = 'श्री';
}else{
	$emp_detail_gender = 'सुश्री';
}
$emp_full_name = $emp_detail_gender.' '.$user_details[0]->emp_full_name_hi;

$final_order_number =  '..............' ;
if($leave_details->leave_order_number != null){
	$final_order_number = $leave_details->leave_order_number.'-'.strtoupper($leave_details->emp_leave_type).'/'.get_date_formate($leave_details->emp_leave_approvel_date,'Y').'/'.$user_details[0]->	emp_unique_id;
} 
$details = get_section_employee(7,8); 
foreach($details as $row){
	$emp_name =  $row->emp_full_name_hi;
}
//pr($user_details);
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="no-print">  
                <p class="alert alert-info"> प्रिंट निकालने के लिए 'प्रिंट' का बटन दबायें, और प्रिंट की कॉपी यदि आवश्यक हो तो स्थापना शाखा में जमा करें| जब तक आदेश पर प्रशासकीय अधिकारी के हस्ताक्षर नहीं होते यह आदेश मान्य नहीं होगा|</p>      
            </div> 
<?php 
$content = '<style>
	table td{
		padding:2px;
	}
	p{
		text-indent: 50px;
		text-align:justify;
	}
	
</style>';
$content .= '<div style="border:1px dashed #333; padding:20px;" id="ordrer">';
$content .= '<table class="table borderless" style="width:100%;  font-size:16px; line-height:22px;">';
$content .= '<tr><td align="center"> <h3>'.$depart.'</h3></td></tr>';
$content .= '<tr><td align="center"> <h4>// आदेश //</h4> </td></tr>';
$content .= '<tr><td align="center"> <label> --------- </label> </td></tr>';
$content .= '<tr><td class="text-right">भोपाल दिनांक '.get_date_formate($leave_details->emp_leave_approvel_date,'d.m.Y').'</td></tr>';
$is_hq = $leave_details->emp_leave_is_HQ == 1 ? ' मुख्यालय छोड़ने की अनुमति सहित ' : '';
$content .= '<tr><td align="left"><p> क्रमांक '.$final_order_number.'/21-अ(स्था.)  <b>'. $emp_full_name.', '.$user_details[0]->emprole_name_hi.'</b> को दिनांक '. get_date_formate($leave_details->emp_leave_date,'d.m.Y').'
                                        से '.get_date_formate($leave_details->emp_leave_end_date,'d.m.Y').' दिनांक तक कुल <b>';
                                        if($leave_details->emp_leave_type == 'el'){
                                        	  $content .= $leave_details->emp_leave_no_of_days;                                       
                                        } else if($leave_details->emp_leave_type == 'hpl'){
                                        	  if($leave_details->sickness_date != $leave_details->emp_leave_date ){ 
                                        	  	  $diff =  day_difference_dates($leave_details->emp_leave_date,$leave_details->sickness_date) + 1; 
                                        	  	$content .= $diff.' + '. $diff.' = '.($diff+ $diff);
                                        	}else {
                                        	  $content .= $leave_details->emp_leave_no_of_days.' + '. $leave_details->emp_leave_no_of_days.' = '.($leave_details->emp_leave_no_of_days+ $leave_details->emp_leave_no_of_days); 
                                        	}
                                        }
                                        $content .='</b> दिवस का  <b>'. leaveType($leave_details->emp_leave_type, true).'</b>'
               . $is_hq .' स्वीकृत किया जाता है| </p></td></tr>';
$content .= '<tr><td align="left"><p>उक्त अवकाश स्वीकृति उपरांत उन्हें  ';			   
$leave_session_m =  get_date_formate($leave_details->emp_leave_date,'m');
$leave_session_y =  get_date_formate($leave_details->emp_leave_date,'Y');

if($leave_details->emp_leave_type == 'el'){
	$rem_laves = !empty($leave_details->leave_remaining ) ? ($leave_details->leave_remaining - $leave_details->emp_leave_no_of_days) : null ;
	$leave_order_bal = !empty($rem_laves) ?  calculate_el($rem_laves) : calculate_el(get_leave_balance($user_details[0]->emp_id, 'el'));
	if($leave_session_m > 6){
		$content .= ' दिनांक 31.12.'.$leave_session_y;
		$content .= ' तक  '; 
		$content .=$leave_order_bal;
	} else{
		$content .=  ' दिनांक 30.06.'.$leave_session_y;
		$content .= ' तक  '; 
		$content .= $leave_order_bal; 
		
	}
} else if($leave_details->emp_leave_type == 'hpl'){
	$rem_laves = !empty($leave_details->leave_remaining) ? ($leave_details->leave_remaining - ($leave_details->emp_leave_no_of_days + $leave_details->emp_leave_no_of_days)) : null ;
	 // $content .=  '31.12.'.$leave_session_y;
	  //$content .= ' तक  '; 
	  $content .= !empty($rem_laves) ?  $rem_laves : get_leave_balance($user_details[0]->emp_id, 'hpl');
}

$content .= ' दिवस के '.leaveType($leave_details->emp_leave_type, true).'</b> की पात्रता रहेगी |</p></p></td></tr>';
$content .= '<tr><td align="left"><p>प्रमाणित किया जाता है कि यदि  <b>'.$emp_full_name.', '.$user_details[0]->emprole_name_hi.'</b>, अवकाश पर नहीं जाते तो अपने पद पर कार्य करते रहते | </p>';
$content .= '<tr><td>';
if($leave_details->emp_leave_approval_emp_id == 2 || $leave_details->emp_leave_approval_emp_id == 264 ) {
	$content .= ' (प्रमुख सचिव विधि द्वारा अनुमोदित)';
  }else {
	$content .=  '(सचिव विधि द्वारा अनुमोदित)';
}
$content .= '</td></tr>';

$content .= '<tr><td>&nbsp;</td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">('. $emp_name.')</div></td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">प्रशासकीय अधिकारी</div></td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">'. $depart.'</div></td></tr>';
$content .= '<tr><td>प्र. क्रमांक '. $final_order_number.'/21-अ(स्था.)</td></tr>';
$content .= '<tr><td class="text-right">भोपाल दिनांक '. get_date_formate($leave_details->emp_leave_approvel_date,'d.m.Y').'</td> </tr>';
$deny_reason = $leave_details->emp_leave_deny_reason != null ? $leave_details->emp_leave_deny_reason : '';
$content .= '<tr><td>1.  <b>'. $user_details[0]->emp_full_name_hi.', '. getemployeeRole($user_details[0]->role_id).'</b>, '. $deny_reason.' </td></tr>';
$content .= '<tr><td>2. पे-लिपिक,</td></tr> ';                        		
$content .= '<tr><td>3. वरिष्ठ कोषालय अधिकारी, विंध्यांचल भवन, भोपाल,</td></tr> ';                        		
$content .= '<tr><td>की ओर सूचनार्थ एवं आवश्यक कार्यवाही हेतु |</td></tr>';  
$content .= '<tr><td>&nbsp;</td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">('. $emp_name.')</div></td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">प्रशासकीय अधिकारी</div></td></tr>';
$content .= '<tr><td align="right"><div style="width:50%; text-align:center;">'. $depart.'</div></td></tr>';                      		
$content .= '</table>';
$content .= '</div>';
echo $content;
$content_final = base64_encode($content);
?>
<br/>
			<div class="row no-print">  
			<?php 
                     $attributes_signature_data = array('class' => 'form-signin', 'id' => 'formsignature_data', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/signature_data', $attributes_signature_data);
                    ?> 	  
			
					<div class="col-md-3 text-center">
						<button type="button" onclick="printContents('ordrer')" class="btn btn-primary" name="">प्रिंट करे</button>
					</div>
					<div class="col-md-3 text-center">
						<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
					</div>
					<?php if(enable_order_gen($current_emp_id) == true || ((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(8))) && $is_saved == false )) {  ?>
					<div class="col-md-3 text-center">
						<input type="hidden" name="movement_id" value="<?php echo $leave_details->emp_leave_movement_id; ?>">
						<input type="hidden" name="content_final" value="<?php echo $content_final; ?>">
						<input type="hidden" name="signature_emp_id" value="<?php echo $details[0]->emp_id; ?>">
						<input type="hidden" name="is_signature" value="0">
						<button type="submit" class="btn btn-success" onclick="return confirm('सुनिश्चित कर ले कि आप दर्ज करना चाहते है|')">आदेश सुरक्षित करें|</button>
					</div>
					<?php } ?>
				</form>
			</div>
		</div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->



