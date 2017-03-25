<section class="content-header">
    <h1>
        <?php echo $title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave attachments</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
  
    <div class="row" id="divname">
        <div class="col-md-12"> 
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i>
					<h3 class="box-title"><?php echo $title_tab; ?> 
                    </h3>
					
                <div class="pull-right box-tools"> 
					<button onclick="printContents('divname')" class="btn btn-primary ">Print</button>
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
				</div>				
			</div><!-- /.box-header -->
				

                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>दस्तावेज</th>                           
                            <th>संलग्न  दस्तावेज की दिनांक </th>
                            <th>दस्तावेज संलग्न कर्ता का नाम </th>					
                         
                        </tr>
                        <?php
                        $r = 1;                                  
                        //pr($leaves_pending);
                        if (isset($leave_attachments_lists)) {
                            foreach ($leave_attachments_lists as $row => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $r; ?>.</td>
                                    <td><a href="<?php echo base_url(); ?>uploads/medical_files/<?php echo $value->att_name; ?>" target="_blank"><?php echo $value->att_type; ?></a></td>
                                    <td><?php echo get_date_formate($value->att_date); ?></td>
                                    <td><?php echo getemployeeName($value->att_by_emp_id, true); ?></td>
                                 </tr>
						<?php $r++;}
						} ?>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->
