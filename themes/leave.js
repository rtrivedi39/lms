
function get_today(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var today = dd+'-'+mm+'-'+yyyy;
		return today;
}
function daysInMonth(month,year) {
	return new Date(year, month, 0).getDate();
}

$(document).ready(function() {
	var today = new Date();
	var month = $('#month_leave').val();
	var yyyy = today.getFullYear();
	var dayin = daysInMonth(month,yyyy);
	$(".leave_deduction #end_date").val(dayin + '-' + month + '-' + yyyy);
});

$(function () {

    $("#no_days_other").blur(function () {
        var days = $("#no_days_other").val();
        $("#days").val(days);
    });
    $("#no_days_ol").change(function () {
        var days = $("#no_days_ol").val();
        $("#days").val(days);
    });



    $("#no_days_cl").change(function () {
        var days = $("#no_days_cl").val();
        $("#days").val(days);
        var leaveid = $(this).attr("data-leaveid");
        //alert(uid);
        $('#leaveID').val(leaveid);

        if (days % 1 === 0) {
            $(".cl_leave_days").addClass("hide_class");
        } else {
            $(".cl_leave_days").removeClass("hide_class");
        }

        //$(".headquoter_leave").removeClass("hide_class");
    });

    $('#headquoter').on('change', function () {
        //alert( this.value);
        if (this.value == 1) {
            $(".headquoters_leave").removeClass("hide_class");
			$('#hd_start_date_hour,#hd_start_date_minitues,#hd_start_date_pali,#hd_end_date_hour,#hd_end_date_minitues,#hd_end_date_pali').attr('required',true);
        } else {
            $(".headquoters_leave").addClass("hide_class");
			$('#hd_start_date_hour,#hd_start_date_minitues,#hd_start_date_pali,#hd_end_date_hour,#hd_end_date_minitues,#hd_end_date_pali').attr('required',false);
}
    });
 

    $("#start_date").datepicker({
        changeMonth: true,
        format: 'dd-mm-yyyy',
    });

    $("#end_date").datepicker({
        // defaultDate: "+1w",
        changeMonth: true,
        format: 'dd-mm-yyyy'
    });

    $('#hd_start_date').datepicker({
        format: 'dd-mm-yyyy'
    });

    $('#hd_end_date').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('#sickness_date').datepicker({
        format: 'dd-mm-yyyy'
    });


    //day diff
    function daysdiff(a, b) {
        var c = 24 * 60 * 60 * 1000,
        diffDays = Math.round(Math.abs((a - b) / (c)));
        return diffDays;
        //console.log(diffDays); //show difference
    }

    $('#end_date').on('change', function () {
        diffDays =  daysdiff($("#start_date").datepicker('getDate').getTime(), $("#end_date").datepicker('getDate').getTime());
        $('#no_days_other,#no_days_ol,#no_days_cl, #days').val(diffDays + 1);
    });
    $('#start_date').on('change', function () {
        diffDays =  daysdiff($("#start_date").datepicker('getDate').getTime(), $("#end_date").datepicker('getDate').getTime());
        $('#no_days_other,#no_days_ol,#no_days_cl, #days').val(diffDays + 1);
		$('#sickness_date').val(("#start_date").val());
    });

    //end day diff

    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("datepicker").minViewMode(e.date);
    });
    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("datepicker").maxViewMode(e.date);
    });

	function get_latedays_ofemp(unique_id,month,yyyy){
		var getUrl = window.location;
		var HTTP_PATH  = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
		$.ajax({
			type: "POST",
			url: HTTP_PATH + "/unis_bio_report/ajax_get_late_days",
			datatype: "json",
			async: false,
			data: {unique_id: unique_id, month:month, year:yyyy, lms_csrf_law_Dept: csrf_hash }, /* Tokjen name define in admin header*/
			success: function(data) {
				var r_data = JSON.parse(data);
				$('#days_late').val(r_data.days);
				late_days();
			}
		});
	}

	// leave montnh for deduction
    $('.leave_deduction #month_leave').on('change', function () {
		var month = this.value;
		var yyyy = $('#year_leave').val();
		var unique_id = $('#leaveemp_unique_id').val();
		var dayin = daysInMonth(month,yyyy);
        $(".leave_deduction #start_date").val('1-'+month+'-'+yyyy);
        $(".leave_deduction #end_date").val(dayin+'-'+month+'-'+yyyy);
		get_latedays_ofemp(unique_id,month,yyyy);
	});

	// leave montnh for deduction
    $('.leave_deduction #year_leave').on('change', function () {
		var month = $('#month_leave').val();
		var yyyy = this.value;
		var unique_id = $('#leaveemp_unique_id').val();
		var dayin = daysInMonth(month,yyyy);
		$(".leave_deduction #start_date").val('1-'+month+'-'+yyyy);
		$(".leave_deduction #end_date").val(dayin + '-' + month + '-' + yyyy);
		get_latedays_ofemp(unique_id,month,yyyy);
	});

	$('#days_late').on('change', function () {
		late_days();
	});
	

	function late_days(){
		var days_days = $('#days_late').val();
		var days_late = parseInt(days_days);
		var days = 0;
		if(!isNaN(days_late)){
			if(days_late > 2){
				days =  parseInt(days_late/3);
				$('.leave_deduction #leaveFormSubmit').show();
			} else {
				days = 0;
				alert('दिनों की संख्या नम्बर 3 से कम होने पर अवकाश कटोत्रा नहीं किया जा सकता ');
				$('.leave_deduction #leaveFormSubmit').hide();
			}
			$("#leave_reason_ddl").val('कार्यालय में ' + days_late + ' दिवस  विलम्ब से आने के कारण  ' + days + ' दिन का अवकाश कटोत्रा | ');
			$("#days").val(days);
		}else{
			alert('कृपया दिनों की संख्या नम्बर में ही दर्ज करें');
			$("#leave_reason_ddl").val(' ');
			$("#days").val(days);
		}
	}
    //leave on change
    $('#leave_type').on('change', function () {
        if (this.value === 'el') {
            $(".hq_leave_type").removeClass("hide_class");
            $(".el_leave, .certificate").removeClass("hide_class");
            $(".ol_leave, #daysDeduct").addClass("hide_class");
            $(".cl_leave,.cl_leave_days,.cl_reason_other").addClass("hide_class");
            $("#no_days_other, #pay_rent_box, #leave_reason_control").show();
            $(".hq_type").addClass("hide_class");
            $("#special_leave_types").hide(); 
        } else if (this.value === 'cl') {
            $(".hq_leave_type, #daysDeduct").removeClass("hide_class");
            $(".hq_type, #special_leave_types, .certificate").addClass("hide_class");
            $(".cl_leave").removeClass("hide_class");
            $(".el_leave").addClass("hide_class");
            $(".ol_leave,.cl_reason_other").addClass("hide_class");
            $("#leave_reason_control").show();
            $("#no_days_other, #pay_rent_box, #special_leave_types").hide();
        } else if (this.value === 'hpl') {
            $(".hq_leave_type, .certificate").removeClass("hide_class");
            $(".hq_type").removeClass("hide_class");
            $(".cl_leave, #daysDeduct, #special_leave_types").addClass("hide_class");
            $(".el_leave").addClass("hide_class");
            $(".ol_leave,.cl_reason_other").addClass("hide_class");
            $("#pay_rent_box, #special_leave_types").hide();
            $("#leave_reason_control").show();
        } else if (this.value === 'ol') {
            $(".hq_leave_type").removeClass("hide_class");
            $(".hq_type, #daysDeduct, .certificate").addClass("hide_class");
            $(".ol_leave").removeClass("hide_class");
            $(".cl_leave").addClass("hide_class");
            $("#leave_reason_control").show();
            $(".el_leave,.cl_leave_days, #special_leave_types,.cl_reason_other").addClass("hide_class");
            $("#no_days_other, #pay_rent_box, #special_leave_types").hide();
        } else if (this.value === 'hq') {
            $(".hq_leave_type, .hq_type, .ol_leave, .el_leave, .cl_leave, #daysDeduct, #special_leave_types, .certificate").addClass("hide_class");
            $(".headquoters_leave,#leave_reason_control,.cl_reason_other").removeClass("hide_class");
            $("#no_days_other, #leave_reason_control").show();
            $("#special_leave_types").hide();
            $("#headquoter").val("1");
        } else if (this.value === 'sl') {
            $(".el_leave, .ol_leave,.hq_type,.cl_leave, #daysDeduct, .certificate").addClass("hide_class");
            $("#no_days_other, #pay_rent_box, #leave_reason_control").hide();
            $("#special_leave_types,#no_days_other").show(); 
            $("#special_leave_types,.cl_reason_other").removeClass("hide_class");
            $("#leave_reason_ddl").val('अन्य');
        } else {
            $(".hq_leave_type").removeClass("hide_class");
            $(".hq_type, .certificate").addClass("hide_class");
            $(".ol_leave").addClass("hide_class");
            $(".el_leave").addClass("hide_class");
            $(".cl_leave, #daysDeduct").addClass("hide_class");
            $("#no_days_other,#leave_reason_control,#leave_reason_control").show();
            $("#special_leave_types").hide(); 
        }
        $('#leave_type').val(this.value);
    });

   //deny 
    $(".btndeny").click(function () {
        var leaveid = $(this).attr("data-leaveid");
        var todeny = $(this).attr("data-todeny");
        //alert(leaveid);
        $('#leaveIDdeny').val(leaveid);
        $('#leaveID').val(leaveid);
		$('.leaveID').val(leaveid);
        $('#todeny').text(todeny);
    }); 
	
	$(".btnapprove").click(function () {
        var leaveid = $(this).attr("data-leaveid");
        //alert(uid);
        $('#leaveIDapprove').val(leaveid);
    });
	
	$(".btnreturn").click(function () {
        var leaveid = $(this).attr("data-leaveid");
        var typesof = $(this).attr("data-typesof");
        var toaction = $(this).attr("data-toaction");
        //alert(leaveid);
        $('#leavereturnID').val(leaveid);
        $('#types').val(typesof);
        $('#toaction').text(toaction);
    });
	
	$(".btnresend").click(function () {
        var leaveid = $(this).attr("data-leaveid");
        //alert(uid);
        $('#resendleaveid').val(leaveid);
    });
	
$(".btnforapprove").click(function () {
		$('#onleave_work_allot').val('');
        var leaveid = $(this).attr("data-leaveid");
        var toaprove = $(this).attr("data-toaprove");
        var work_allote = $(this).attr("data-work_allote");
        //alert(uid);
        $('#leaveID').val(leaveid);
        $('#toaprove').text(toaprove);
		if(work_allote !== ''){
			$('#onleave_work_allot').val(work_allote);
		}
    });
	
	$("#onholyday").click(function () {
        var msg = $(this).attr("data-msg");
        //alert(uid);
        $('#onleave_work_allot').val(msg);
    });
	$(".bultselect").change(function () {
        var bultselect = $(this).val();
        $('.bultselect').val(bultselect);
    });
	
	//bulk selction approve - forward
	$(".btnbulk_action").click(function () {
		var sel_value = $('.bultselect').val();
		var count = $('.leave_ids:checkbox:checked').length;
		var retutn = true; 
		if(count <= 0){
			alert('कृपया आवेदक को जरुर चुने');
			retutn =  false;
		} else if(sel_value === ''){
			alert('कृपया कार्यवाही प्रकार का चयन करे');
			$('.bultselect').focus();
			retutn =  false;
		}  
       return retutn;
    });
    // leave reason 
    $('#leave_reason_ddl').on('change', function () {

        if (this.value == 'अन्य')
        {
            $(".cl_reason_other").removeClass("hide_class");
        }
        else
        {
            $(".cl_reason_other").addClass("hide_class");
        }
    });
    $("#Confirm_deduct").click(function () {
            var days = $("#days").val();
            if(days == ''){
                alert('पहले दिनांक चुने');
            }else{
                var total_days =  daysdiff($("#start_date").datepicker('getDate').getTime(), $("#end_date").datepicker('getDate').getTime()) + 1 ;
                var count = $('input[name="days_deduct[]"]:checked').length;
                if(count >= total_days){
                    alert('कृपया कुल दिन से कम ही घटायें');
                } else {
                    var final_days = total_days - count;
                    $('#no_days_cl, #days').val(final_days);
                }
            }
       });
       
        function dateconvert(a) {
        var c = 24 * 60 * 60 * 1000,
        newdate = Math.round(Math.abs(a)/c);
        return newdate;
        //console.log(diffDays); //show difference
    }
	
	
	$(function () {
	 $('#year_select').on('change', function () {
		 window.location = "?year="+$('#year_select').val();
	 });
	});
	
	
    //on click leave submit button  
    $(function(){
        $('#leaveForm').on('submit',function(event){
            var leave_type = $('#leave_type').val();
            var leave_type_sl = $('#leave_type_sl').val();
            var leave_reason = $('#leave_reason_ddl').val();
            var start_date = dateconvert($("#start_date").datepicker('getDate').getTime());
            var end_date = dateconvert($("#end_date").datepicker('getDate').getTime());
            var no_days_other = $('#no_days_other').val();
            var no_days_cl = $('#no_days_cl').val();
            var no_days_ol = $('#no_days_ol').val();
            var headquoter = $('#headquoter').val();
            var hd_start_date = dateconvert($("#hd_start_date").datepicker('getDate').getTime()); 
            var hd_end_date = dateconvert($("#hd_end_date").datepicker('getDate').getTime()); 
            var leave_reason_ddl = $('#leave_reason_ddl').val();
            var reason = $('#reason').val();
            var address = $('#address').val();            
            var sickness_date = dateconvert($("#sickness_date").datepicker('getDate').getTime()); 
            var days = $('#days').val();
            var diff = daysdiff($("#start_date").datepicker('getDate').getTime(), $("#end_date").datepicker('getDate').getTime()) + 1 ;
            var half_type = $('input[name=half_type]:checked').val();  
            var medical_file = $('#medical_file').val();   
            var head_quoter_type = $('input[name=head_quoter_type]:checked').val();  
            var confirm_chk = $('#confirm_chk').prop('checked');
			var emp_houserent = $('#emp_houserent').val();
			var pay_grade_pay = $('#pay_grade_pay').val();
			var onleave_work_allot = $('#onleave_work_allot').val();
            
            if(leave_type === ''){
                event.preventDefault() ;
                alert('कृपया अवकाश की प्रकृति का चयन करें|');
                $('#leave_type').focus();
            } else if(leave_type === 'sl' && leave_type_sl === ''){
                event.preventDefault() ;
                alert('कृपया अवकाश कारण का चयन करें|');
                $('#leave_type_sl').focus();
            } else if(leave_reason === ''){
                event.preventDefault() ;
                alert('कृपया अवकाश कारण का चयन करें|');
                $('#leave_reason_ddl').focus();
            } else if(leave_reason_ddl === 'अन्य' && reason === '' && leave_type !== 'sl'){
                event.preventDefault() ;
                alert('कृपया अवकाश कारण के अन्य में कारण दर्ज करें|');
                $(".cl_reason_other").removeClass("hide_class");
                $('#reason').focus();
            } else if($("#start_date").val() === '' && leave_type !== 'hq' ){
                event.preventDefault() ;
                alert('कृपया अवकाश का दिनांक चयन करें|');
                $('#start_date').focus();
            } else if($("#end_date").val() === '' && leave_type !== 'hq'){
                event.preventDefault() ;
                alert('कृपया अवकाश का अंतिम दिनांक चयन करें|');
                $('#end_date').focus();
            } else if(start_date > end_date){
                event.preventDefault() ;
                alert('कृपया अवकाश का अंतिम दिनांक शुरुवात दिनांक से कम न रखे |');
                $('#end_date').focus(); 
            } else if(start_date !== end_date && leave_type === 'ol'){
                event.preventDefault() ;
                alert('यह अवकाश केवल एक ही दिवस के लिए मान्य है|');
                $('#end_date').val($("#start_date").val());
                $('#no_days_ol').val(1);
            } else if(no_days_other === '' && (leave_type !== 'cl' || leave_type !== 'ol')){
                event.preventDefault() ;
                alert('कृपया अवकाश के दिन चयन करें|');
                $('#no_days_other').focus();
            } else if(no_days_cl === '' && leave_type === 'cl'){
                event.preventDefault() ;
                alert('कृपया अवकाश के दिन चयन करें|');
                $('#no_days_cl').focus();
            } else if(no_days_ol === '' && leave_type === 'ol'){
                event.preventDefault() ;
                alert('कृपया अवकाश के दिन चयन करें|');
                $('#no_days_ol').focus();
            } else if(diff > 8 && leave_type === 'cl'){
                event.preventDefault() ;
                alert('यह अवकाश 8 से ज्यादा दिन नहीं ले सकते |');
                $('#end_date').focus();
            } else if(days > 180 && leave_type === 'hpl'){
                event.preventDefault() ;
                alert('यह अवकाश 180 से ज्यादा दिन नहीं ले सकते |');
                $('#end_date').focus();
           } else if(days > 120 && leave_type === 'el'){
                event.preventDefault() ;
                alert('यह अवकाश 120 से ज्यादा दिन नहीं ले सकते |');
                $('#end_date').focus();
            } else if(no_days_cl > 6 && leave_type === 'cl'){
                event.preventDefault() ;
                alert('यह अवकाश दिन घटाके 6 से ज्यादा दिन एक साथ नहीं ले सकते |');
                $('#no_days_cl').focus();
            } else if(days > 180 && leave_type === 'sl' && leave_type_sl === 'mat'){
                event.preventDefault() ;
                alert('यह अवकाश 180 से ज्यादा दिन नहीं ले सकते|');
                $('#end_date').focus();
            } else if(days > 15 && leave_type === 'sl' && leave_type_sl === 'pat'){
                event.preventDefault() ;
                alert('यह अवकाश 15 से ज्यादा दिन नहीं ले सकते|');
                $('#end_date').focus();
            } else if(days > 730 && leave_type === 'sl' && leave_type_sl === 'child'){
                event.preventDefault() ;
                alert('यह अवकाश 730 से ज्यादा दिन नहीं ले सकते|');
                $('#end_date').focus();
            } else if(days > diff){
                event.preventDefault() ;
                alert('कृपया अवकाश के दिन दिनांक से ज्यदा नहीं चयन करे|');
                $('#days').focus();
          /*  } else if((typeof $("input[name='radio-button-group']:checked").val() === 'undefined' || half_type === '' )  && leave_type === 'cl' && (days % 1 !== 0)){
                event.preventDefault() ;
                alert('कृपया आकस्मिक छुट्टी में आधा दिन के प्रकार चयन करे|');
                $('#half_type').focus(); */ 
            } else if(headquoter === ''){
                event.preventDefault() ;
                alert('कृपया मुख्यालय का प्रकार चयन करें|');
                $('#headquoter').focus();
            } else if(headquoter === '1' && $("#hd_start_date").val() === ''){
                event.preventDefault() ;
                alert('कृपया मुख्यालय अवकाश का दिनांक चयन करें|');
                $('#hd_start_date').focus();
            } else if(headquoter === '1' && $("#hd_end_date").val() === ''){
                event.preventDefault() ;
                alert('कृपया मुख्यालय अवकाश का अंतिम दिनांक चयन करें|');
                $('#hd_end_date').focus();
            } else if(headquoter === '' && leave_type === 'hq'){
                event.preventDefault() ;
                alert('कृपया मुख्यालय छोड़ने के दिनांक चुनना आवश्यक है|');
                $('#headquoter').focus();
            } else if(hd_start_date > hd_end_date){
                event.preventDefault() ;
                alert('कृपया मुख्यालय अवकाश का अंतिम दिनांक शुरुवात दिनांक से कम न रखे |');
                $('#hd_end_date').focus(); 
            /*} else if(hd_start_date < start_date){
                event.preventDefault() ;
                alert('कृपया मुख्यालय अवकाश का अंतिम दिनांक अवकाश दिनांक से कम न रखे |');
                $('#hd_end_date').focus(); */
            } else if(address === '' && leave_type === 'el'){
                event.preventDefault() ;
                alert('कृपया इस अवकाश में अवकाश का पता दर्ज करें|');
                $('#address').focus();
            } else if(emp_houserent === '' && leave_type === 'el'){
                event.preventDefault() ;
                alert('कृपया इस अवकाश में कर्मचारी हाउस रेंट दर्ज करें|');
                $('#emp_houserent').focus();
            }else if(pay_grade_pay === '' && leave_type === 'el'){
                event.preventDefault() ;
                alert('कृपया इस अवकाश में कर्मचारी पे + ग्रेड पे दर्ज करें|');
                $('#pay_grade_pay').focus();
            } else if($("#sickness_date").val() === ''  && leave_type === 'hpl'){
                event.preventDefault() ;
                alert('कृपया सर्टिफिकेट की दिनांक चयन करें|');
                $('#sickness_date').focus();
            } else if((sickness_date < start_date || sickness_date > end_date) && (leave_type === 'hpl')){
                event.preventDefault() ;
                alert('कृपया सर्टिफिकेट की दिनांक अवकाश की दिनांक और अवकाश की अंतिम दिनांक के मध्य ही चयन करें|');
                $('#sickness_date').focus();
            } else if(medical_file === '' && leave_type === 'hpl' && head_quoter_type === 'MG'){
                event.preventDefault() ;
                alert('कृपया सर्टिफिकेट अपलोड करे|');
                $('#medical_file').focus();
			} else if(onleave_work_allot === ''){
                event.preventDefault() ;
                alert('आपका कार्य किसके द्वारा किया जायेगा');
                $('#onleave_work_allot').focus();
            } else if(!confirm_chk){
                event.preventDefault() ;
                alert('कृपया दी गयी जानकारी सही है सुनुश्चित पर टिक करे|');
                $('#confirm_chk').focus();
            }
          
        });
    });
       
});