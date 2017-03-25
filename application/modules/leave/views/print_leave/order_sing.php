<style>
#ordrer table{
	width:100% !important;  
	font-size:14px !important; 
	line-height:20px !important; 
}
#ordrer table h3,#ordrer table h4{
	margin: 5px;
}
#ordrer table td{
	padding: 3px;
}
</style>
<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>leave/"><i class="fa fa-index"></i> Leave</a></li>
        <li class="active">Print</li>
    </ol>
</section>
<?php

?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="no-print">  
                <p class="alert alert-info"> प्रिंट निकालने के लिए 'प्रिंट' का बटन दबायें, और प्रिंट की कॉपी यदि आवश्यक हो तो स्थापना शाखा में जमा करें|</p>      
            </div>
            	<div id="print_div">
				<?php //pr($leave_details);
					$conbefore = $leave_details->ds_content_final;
					$conaffter= urldecode(base64_decode($leave_details->ds_signing_content));
					$ddd = str_replace(" ","+", $conaffter);
					echo base64_decode($ddd);
					echo "<br/>";
					echo '<div style="float:right;"><div style="width:100%; text-align:center;">';
					echo verify_digital_sinature($leave_details->ds_leave_mov_id,$conaffter);
					echo '</div>';
					?>
					</div> 
				<br/>
			<div class="row no-print"> 
			 <?php 
                     $attributes_signature_data = array('class' => 'form-signin', 'id' => 'formsignature_data', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/signature_data', $attributes_signature_data);
                    ?> 	  
				
					<div class="col-md-3 text-center">
						<button type="button" onclick="printContents('print_div')" class="btn btn-primary" name="">प्रिंट करे</button>
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
<script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
$( document ).ready(function() {
    $("#ordrer").removeAttr("style");
});


</script>


