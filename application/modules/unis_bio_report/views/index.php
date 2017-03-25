<style>
#bio_report_block h2, #bio_report_block p {
    padding:0px; margin:2px;        
}
#bio_report_block h2{
	font-size:18px; font-weight: bold;        
}
@print{
	#bio_report_block h2, #bio_report_block p {
		padding:0px; margin:2px;        
	}
	#bio_report_block h2{
		font-size:18px; font-weight: bold;        
	}
	table#bio_table tr.bg-danger, #bio_table tr.bg-warning{
       background:#bbbbbb !important;     
    }
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $title; ?>
	<small>अंतिम अपलोड दिनांक:- <?php echo get_date_formate($last_upload['bio_date'],'d.m.Y').' '. get_date_formate($last_upload['bio_time'],'h:i:s A'); ?></small> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active"><?php echo $title_tab; ?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Your Page Content Here -->
  <!-- Small boxes (Stat box) -->
 	 <div class="row">
		<div class="col-xs-12">
	  		<div class="box">
			<?php $this->load->view('header'); ?>
			 <div class="box-body" id="report_ptrint">
				 <?php if($this->session->flashdata('update') || $this->session->flashdata('insert') || $this->session->flashdata('delete') ){ ?>  <div class="alert alert-success alert-dismissable hideauto">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <strong>
						  <?php  echo $this->session->flashdata('update');
						  echo $this->session->flashdata('delete');
						  echo $this->session->flashdata('insert'); ?>
					  </strong><br>
				  </div>
				  <?php }?>
				  <?php 
				  	if($search_report){  
						$this->load->view('user_wise'); 
					}  else if($day_wise_report){
						$this->load->view('day_wise');
					} else if($month_wise_report){
						$this->load->view('month_wise');
					}  else if($all_emp_absent_report){
						$this->load->view('user_wise_emp'); 
					}?>
		  		</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
  	</div><!-- /.row -->
  <!-- Main row -->
  <?php //echo $this->security->get_csrf_token_name(); ?>
  <?php //echo $this->security->get_csrf_hash(); ?>
</section><!-- /.content -->
<script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    $("#emp_sections").change(function () {
        var section_id = $(this).val();
        var HTTP_PATH = '<?php echo base_url(); ?>';

        $.ajax({
            type: "POST",
            url: HTTP_PATH + "unis_bio_report/ajax_get_list",
            datatype: "json",
            async: false,
            data: {section_id: section_id,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function(data) {
                var r_data = JSON.parse(data);                
                var otpt = '<option value="">कर्मचारी/ अनुभाग</option>';
                $.each(r_data, function( index, value ) {
                    /* console.log(value);  */
                    if(section_id == 'other'){
						otpt += '<option value="'+value.emp_unique_id+'"> '+value.emp_unique_id+' - '+value.emp_full_name_hi+'</option>';
					} else {
                        otpt += '<option value="'+value.emp_unique_id+'"> '+value.emp_unique_id+' - '+value.emp_title_hi+' '+value.emp_full_name_hi+'('+value.emprole_name_hi+')</option>';
                    }
                });
                $("#employee_list_section").html(otpt);
            }, 
            complete: function(){
                $('#loading-image').hide();
            }
        });
    });
</script>
<script type="text/javascript">
  function is_delete(){
	var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
	if(res===false){
	  return false;
	}
  }
</script>
