  <!-- Main Footer -->
<footer class="main-footer no-print">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Load in <strong><a href="?prf=yes" title="View full profiler details">{elapsed_time}</a></strong> seconds  and  <strong>{memory_usage}</strong> Memory used			
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015-2016 <a href="#">LAW DEPARTMENT</a></strong> All rights reserved.
      </footer>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>dist/js/app.min.js" type="text/javascript"></script>
	<!--Text Slider-->
	<script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/text_slider.js" type="text/javascript"></script>	
	<!--End Text Slider-->
	
	<!--validation Js-->
	<script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/formValidation.min.js" type="text/javascript"></script>
	<script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/validationForm.bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>themes/validationScript.js" type="text/javascript"></script>
	
	
<?php if ($this->uri->segment(1) == 'leave' || $this->uri->segment(2) == 'addleave' || $this->uri->segment(2) == 'add_leave') { ?>
<!--- Leave Javascript -->
<script src="<?php echo base_url(); ?>themes/leave.js" type="text/javascript"></script>	
<!-- END Leave Javascript-->
<?php } ?>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
	
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo ADMIN_THEME_PATH; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/multiselect_checkbox.js" type="text/javascript"></script>
	<script src="<?php echo ADMIN_THEME_PATH; ?>plugins/datatables/dataTables.tableTools.js" type="text/javascript"></script>
    <script type="text/javascript">        
        $(document).ready(function () {  

         var myVar = setInterval(function(){ myTimer() }, 1000);

                function myTimer() {
                    var d = new Date();
                    var t = d.toLocaleTimeString();
                    document.getElementById("counter").innerHTML = t;
                }
        }); 

        $(document).ready(function () {
        		$('#leave_tbl, #dataTable').dataTable({
        			 "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
        			  "pageLength": 25,	
						"ordering": false					  
        		});
            $('.dataTable').dataTable();
        });
      $(function () {
        //$("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });

       $(function () {
        $("#admin_users_list").dataTable();
        $(document).ready(function () {
            $('#leave_employee').dataTable({
                "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
				"pageLength": 25,
                "tableTools": {
                    "sSwfPath": "<?php echo ADMIN_THEME_PATH; ?>plugins/datatables/swf/copy_csv_xls_pdf.swf",
                }
            });
            
        });

        $('#admin_users_list').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });

      $(function () {
         //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
      });


        $(document).ready(function() {
            var HTTP_PATH='<?php echo base_url(); ?>';
            //add the country dialing code in input field at registration
            $("#emp_role").change(function() {
                var conf = confirm('<?php echo $this->lang->line("emp_role_confirm_message"); ?>');
                if(conf==false){
                  if($("#selected_emp_role").val()!=''){
                    var old_role= $("#selected_emp_role").val();
                    window.location.reload(true)
                  }
                  return false;
                }

                var role_id = $(this).val();
                if(role_id=='3'){
                    $(".supervisor").hide();
                }else{
                    $(".supervisor").show();
                }
                if(role_id!=''){
                  $("#selected_emp_role").val(role_id);
                }
                $.ajax({
                    type: "POST",
                    url: HTTP_PATH + "admin_users/get_supervisore_emp",
                    datatype: "json",
                    async: false,
                    data: {rold_id: role_id},
                    success: function(data) {
                        var r_data = JSON.parse(data);
                        //alert(r_data);
                        var otpt = '<option value="">Select Supervisore</option>';
                         $.each(r_data, function( index, value ) {
                          // console.log(value);
                            otpt+= '<option value="'+value.emp_id+'">'+value.emp_full_name+' ('+value.emprole_name_en+'-'+value.emprole_name_hi+' )</option>';
                        });
                        $("#supervisor_emp_id").html(otpt);
                    }
                });
            });

            /*Table*/
            $("#section_id").change(function() {
                var conf = confirm('<?php echo $this->lang->line("emp_role_confirm_message"); ?>');
                if(conf==false){
                  if($("#selected_emp_role").val()!=''){
                    var old_role= $("#selected_emp_role").val();
                    window.location.reload(true)
                  }
                  return false;
                }
                var section_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: HTTP_PATH + "admin_notesheet_master/get_notification_master_menu",
                    datatype: "json",
                    async: false,
                    data: {section_id: section_id},
                    success: function(data) {
                        var r_data = JSON.parse(data);
                        //alert(r_data);
                        var otpt = '<option value="">Select notesheet menu</option>';
                         $.each(r_data, function( index, value ) {
                          // console.log(value);
                            otpt+= '<option value="'+value.notesheet_menu_id+'">'+value.notesheet_menu_title_hi+' ('+value.notesheet_menu_title_en+' )</option>';
                        });
                        $("#notesheet_type").html(otpt);
                    }
                });
            });

            $("#supervisor_emp_id").change(function() {
                var conf = confirm('<?php echo $this->lang->line("emp_supervisor_confirm_message"); ?>');
                if(conf==false){
                  if($("#selected_supervisor_id").val()!=''){
                    var old_role= $("#selected_supervisor_id").val();
                    window.location.reload(true)
                  }
                  return false;
                }
            });
        });
    function confir_post_data(){
        var confval=confirm('<?php echo $this->lang->line("emp_submit_confirm"); ?>');
        if(confval==false){
            //window.location.reload(true)
            return false;
            }
    }
  </script>
  <?php //if($this->uri->segment(1)=='leave'|| $this->uri->segment(2)=='add_employee' || $this->uri->segment(2)=='edit_employee' || $this->uri->segment(2)=='manage_user' || $this->uri->segment(2)=='notesheets'){ ?>
      <link href="<?php echo ADMIN_THEME_PATH; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script type="text/javascript">
       $(function() {
            $("#emp_detail_dob").datepicker({ dateFormat: "dd-mm-yy" }).val()
			$(".datepicker").datepicker({ dateFormat: "dd-mm-yy" }).val();
        
       });

   </script>  
	 <script type="text/javascript">
      $(function () {
        //Date DOB
        $('#emp_detail_dob').datepicker();
      });
    </script>  
  <?php //} ?>
    
  <script type="text/javascript">
      $(document).ready(function() {
        $('#example1').dataTable({
          
        });
    });
    
    //for print
     function print_content() {
          window.print();
    }
    
	function goBack() {
          window.history.back();
      }
    
    //tree
    $(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
});
  </script>
  <script>
    function printContents(data){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(data).innerHTML;
		printcontent += '' +
        '<style type="text/css">' +
        '#bio_report_block {' +
        'font-size:12px !important;' +        
        '}' +
		'table#bio_table td {' +
        'font-size:12px !important; padding:2px !important;' +        
        '}' +
		'#bio_report_block p {' +
        ' padding:0px !important; margin:2px !important; ' +        
        '}' +
		'#bio_report_block h2 {' +
        'font-size:18px !important; font-weight: bold !important;  ' +        
        '}' +
		'table#bio_table tr.bg-warning, table#bio_table td.bg-warning{' +
        ' background:#eee !important;' +        
        '}' +
		'table#bio_table tr.bg-danger, table#bio_table td.bg-danger{' +
        ' background:#bbb !important;' +        
        '}' +
        '</style>';
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
	function closeWin() {
		close();  // Closes the new window
	}
	
	//leave aaprove model show emplyee leave details	
	$(function () {
		$(".btnapprove, .btndeny, .btnforapprove").click(function() {
			$("#name_of_emp").text($(this).closest("tr").find('td:eq(3)').text());
			$("#typeleave_of_leave").text($(this).closest("tr").find('td:eq(6)').text());
			$("#from_date_leave").text($(this).closest("tr").find('td:eq(7)').text());
			$("#to_date_leave").text($(this).closest("tr").find('td:eq(8)').text());
			$("#days_leave").text($(this).closest("tr").find('td:eq(10)').text());
			
			$(".user_leave_details").val('');
			$(".user_leave_taken").val('');			
			var emp_id = $(this).data('empid');
			$('.appve_emp_id').val(emp_id);
			var leave_id = $(this).data('leaveid');
			var leave_type = ''; //$(this).data('leavetype');
			//alert(leave_type);
			$('.leaveID').val(leave_id);
			
			var create_date = new Date();
			var crnt_year = create_date.getFullYear();
			get_user_leave_record(emp_id,leave_type, crnt_year);
		});
	
		$(document).on('change', ".ajax_leave_type", function(){
			var leave_type = $(this).val();
			var year = $('.ajax_leave_year').val();
			var emp_id = $('.appve_emp_id').val();
			get_user_leave_record(emp_id,leave_type, year);
			$('.ajax_leave_type').val($(this).val());
			$('.ajax_leave_year').val(year);
		});
		
		$(document).on('change', ".ajax_leave_year", function(){
			var year = $(this).val();
			var leave_type = $('.ajax_leave_type').val();
			var emp_id = $('.appve_emp_id').val();
			get_user_leave_record(emp_id,leave_type, year);
			$('.ajax_leave_year').val($(this).val());
			$('.ajax_leave_type').val(leave_type);
		});
	});

	
	function  get_user_leave_record(emp_id,leave_type,crnt_year){
		var create_date = new Date();
		var end_year = create_date.getFullYear();
		var HTTP_PATH = '<?php echo base_url(); ?>';
		$.ajax({
			type: "POST",
			url: HTTP_PATH + "leave/leave_approve/get_userdetails",
			datatype: "json",
			async: false,
			data: {emp_id: emp_id,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},					
			success: function(data) {						 
				var r_data = JSON.parse(data);
				//console.log(r_data);						
				var otpt = '<h3>बचे हुए अवकाश ('+create_date.getFullYear()+')</h3>';
				 otpt += '<table width="100%"><tr><th>CL</th><th>OL</th><th>EL</th><th>HPL</th></tr>';
				 $.each(r_data, function( index, value ) {
					//console.log(value);
					otpt+= '<tr><td>'+value.cl_leave+'</td>';
					otpt+= '<td>'+value.ol_leave+'</td>';
					otpt+= '<td>'+value.el_leave+'</td>';
					otpt+= '<td>'+value.hpl_leave+'</td></tr>';
				});
				otpt+= '</table>';
				$(".user_leave_details").html(otpt);
			}
		}); 
		
		otpt = '<br/><div class="row"><div class="col-md-4"><h3 class="no-margin">लिए हुए अवकाश</h3></div>';						
		otpt += '<div class="col-md-4"><select name="ajax_leave_type" id="ajax_leave_type" class="form-control ajax_leave_type">';
		otpt += '<option value="">EL+CL</option>';
		otpt += '<option value="el">EL</option>';
		otpt += '<option value="hpl">HPL</option>';
		otpt += '<option value="cl">CL</option>';
		otpt += '<option value="ol">OL</option>';
		otpt += '</select></div>';
		otpt += '<div class="col-md-4"><select name="ajax_leave_year" id="ajax_leave_year" class="form-control ajax_leave_year">';
		var start_year = 2015;
		var selected = '';
		var leave_data = '';
		while (start_year <= end_year){
			if(start_year == crnt_year){ selected = 'selected'; }
			otpt += '<option value="'+start_year+'" '+selected+'>'+start_year+'</option>';
			start_year++;
		}
		otpt += '</select></div></div>';
		var total = 0; var i = 0; 
		otpt += '<table class="table  table-striped dataTable" width="100%"><tr><th>अवकाश की प्रकृति</th><th>दिन</th><th>कब से</th><th>कब तक</th><th>अवकाश का कारण</th></tr>';
		$.ajax({
			type: "POST",
			url: HTTP_PATH + "leave/leave_approve/ajax_get_leaves_taken",
			datatype: "json",
			async: false,
			data: {emp_id: emp_id, leave_type: leave_type, year:crnt_year,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},					
			beforeSend: function() {
				// setting a timeout
				$('.user_leave_taken').text('Loading leaves......');
				i++;
			},
			success: function(l_data) {
				leave_data = JSON.parse(l_data);
				//console.log(leave_data);
				if(leave_data  == false){
					otpt+= '<tr class="bg-danger"><td colspan="5" align="center">कोई रिकॉर्ड नहीं पाया गया</td></tr>';
				} else{
					$.each(leave_data, function( index, value ) {
						//console.log(value);
						var style =  '';
						var symbol =  '';
						var types =  value.emp_leave_type.toUpperCase();
						if(value.emp_leave_approval_type == 0){
							style = 	'class="text-danger"';	
							symbol = '*';	
						}
						otpt+= '<tr '+style+'><td class="text-center">'+symbol+' '+types+'</td>';						
						otpt+= '<td>'+value.emp_leave_no_of_days+'</td>';
						otpt+= '<td>'+formattedDate(value.emp_leave_date)+'</td>';
						otpt+= '<td>'+formattedDate(value.emp_leave_end_date)+'</td>';
						otpt+= '<td>'+value.emp_leave_reason+'</td></tr>';
						total = total + parseFloat(value.emp_leave_no_of_days);
					});
				}
			},
			error: function(xhr) { // if error occured
				alert("Error occured.please try again");
				$('.user_leave_taken').append(xhr.statusText + xhr.responseText);
				$('.user_leave_taken').text('');
			},
			complete: function() {
				i--;
				if (i <= 0) {
					$('.user_leave_taken').text('');
				}
			}
		});
		if(leave_data != false){
			otpt+= '<tr class="bg-info"><td colspan="3" align="center">कुल लिए हुए अवकाश</td><td colspan="2" align="center"><b>'+total+'</b></td></tr>';
		}
		otpt+= '</table>';			
		$(".user_leave_taken").html(otpt);
	}
		
	function formattedDate(date) {
		var d = new Date(date || Date.now()),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		return [day, month, year].join('/');
	}
</script>
  </body>
</html>
<script>
    $(".slct_file").click(function() {
		var emp_level= 6;
		var total_select_count=$("#total_slct_count").val();
		if(emp_level==6){
			if(total_select_count >= 10){
				alert('एक बार में १० अधिक फाइलो को डिजिटल हस्ताक्षर नहीं कर सकते |');
				$(".radiobtn"+chkboxid).prop("checked", false);
				return false;
			}
		}else{
			if(total_select_count>=10){
				alert('एक बार में 10 अधिक फाइलो को डिजिटल हस्ताक्षर नहीं कर सकते !');
				$(".radiobtn"+chkboxid).prop("checked", false);
				return false;
			}
		}
		
        var checked = $(this).is(':checked');
        var chkboxid = $(this).attr('id');
		var total_select_radio_count=$("#total_select_radio_buton_count"+chkboxid).val();
        if (checked) {
            $(".radiobtn"+chkboxid).prop("disabled", false);            
			total_select_count=parseInt(total_select_count)+parseInt(1);			
			$('.chkbox'+chkboxid).prop("disabled", false);  
        } else {
			total_select_count=parseInt(total_select_count)-parseInt(1);			
            $(".radiobtn"+chkboxid).prop("disabled", true);
            $("#employeelist_"+chkboxid).html('');
			$("#total_nu_radio_selected").val(total_select_count);
			$(".radiobtn"+chkboxid).prop("checked", false);
			$('.chkbox'+chkboxid).prop("disabled", true); 
        }		
		if(total_select_count==0){			
			$(".sign_button").prop("disabled", true);
			$(".test_sign").prop("disabled", true);
		}else{
			$(".sign_button").prop("disabled", false);
			$(".test_sign").prop("disabled", false);
		}
		
		$("#total_slct_count").val(total_select_count);
		
    });


    $(document).ready(function(){
		$(".sign_button").click(function () {
			
			var total_ckbox_count = $("#total_nu_radio_selected").val();
			var total_radio_count =$("#total_slct_count").val();		
		
			var HTTP_PATH='<?php echo base_url(); ?>';
			var url_ref='leave_livemode';
			var emp_login_lvl=6;            
			var url = HTTP_PATH+'oder_sing/post_multi_signature'; 
			var site_status = "<?php echo SITE_STATUS; ?>"; 
			/*$.post(url, $("#multi_sign_frm").serialize(), function(data){					
				var site_status = "<?php #echo SITE_STATUS; ?>";
				  var location_url = "http://10.115.254.213:8080/data_signing/multiSignData?other="+site_status+"&url="+site_status+"&draft_id="+url_ref+"&file_id="+emp_login_lvl+"&emp_name=bijendra&data="+data; 
				  location.href= location_url;
			});*/	
			
			$.ajax({ 
						type: "POST",
						url:url,
						datatype: "json",
						processData: 'false',
						async: true,
						data: $("#multi_sign_frm").serialize(),                            
						success: function(data) {						
								var location_url = "http://10.115.254.213:8080/data_signing/multiSignData?other="+site_status+"&url="+site_status+"&draft_id="+url_ref+"&file_id="+emp_login_lvl+"&emp_id="+url_ref+"&data="+data; 
								$('#ds_data_fld').val(data);
								$('#ds_file_id_fld').val(emp_login_lvl);
								$('#ds_emp_id_fld').val(url_ref);
								$('#ds_draft_id_fld').val(url_ref);
								$('#ds_url_fld').val(site_status);
								$('#ds_other_fld').val(site_status);
								location.href= location_url;
								
						}
				});
        });		
		/* var myVar = setInterval(function(){ if(!$(".sign_button").attr('disabled')){ check_digitally_sign_or_not()} }, 3000);*/
		 if($('.multi_send_updown_txt').val()==0){	
			var myVar = setInterval(function(){ 
			if(!$(".sign_button").attr('disabled')){				
					check_digitally_sign_or_not();
				}			 
			}, 10000);			
		} 
			function check_digitally_sign_or_not(){	
				var HTTP_PATH='<?php echo base_url(); ?>';
				$.ajax({
						type: "POST",
						url: HTTP_PATH + "oder_sing/check_digitally_sign_or_not",
						datatype: "json",
						async: true,
						data: $("#multi_sign_frm").serialize(),                            
						success: function(data) {								
								
								if(data>0){
									 $('.multi_send_updown_txt').val(1);
									 $(".slct_file").prop( "checked",false );
									 window.location.href = HTTP_PATH+"oder_sing/sign_order?msg=success";
									  $('#multi_sign_frm').reset();
									
									
								}
						}
				});				
			}
	});

	$("#session_pagination_entries").change(function () {
		var  per_page_entry = $(this).val();
		var HTTP_PATH= '<?php echo base_url(); ?>';
		$.ajax({
			type: "POST",
			url: HTTP_PATH + "leave/session_per_page_entry",
			datatype: "json",
			async: true,
			data: {per_page_entry:per_page_entry,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
			success: function(data) {
				window.location.reload();
			}
		});
    });
	function check_dropdown(){
		alert($(this).attr('id'));
	}
</script>
<?php
    $CI = & get_instance();
    $this->benchmark->mark('end');
    $timetot = $this->benchmark->elapsed_time('start', 'end');   
    get_log_data($timetot);
    
?>