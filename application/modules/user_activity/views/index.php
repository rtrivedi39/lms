<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 title="<?php echo $this->lang->line('user_activity_title_en'); ?>"><?php echo $this->lang->line('user_activity_title_hi'); ?></h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $this->lang->line('user_activity_title_hi'); ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-7 col-xs-12">
              <!-- small box -->
               <div class="box box-info">
                  <div class="box-header">
                      <h3><?php echo $this->lang->line('activity_list'); ?></h3>
                  </div>
                  <div class="box-body">
                     <table id="" class="table table-bordered table-striped dataTable">  
                         <thead>
                          <tr>
                              <th><?php echo $this->lang->line('sno'); ?>#</th>
                              <th><?php echo $this->lang->line('uid'); ?></th>
                              <th><?php echo $this->lang->line('name'); ?></th>
                              <th><?php echo $this->lang->line('login_count'); ?></th>
                              <th><?php echo $this->lang->line('details'); ?></th>
                          </tr>
                         </thead>
                         <tbody>
                          <?php if($activity_list){
                              $i = 1;
                              foreach($activity_list as $row){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                  echo "<td>".$row->emp_unique_id."</td>";
                                  echo "<td>".$row->emp_full_name_hi." / ".$row->emprole_name_hi."</td>";
                                  echo "<td>".$row->total."</td>"; ?>
                                  <td> <a href="<?php echo base_url(); ?>activity_details/<?php echo $row->emp_id; ?>" class="btn  btn-twitter"><?php echo $this->lang->line('details_view'); ?></a></td>
                                 <?php  echo "</tr>";
                             $i++; }
                          } else {
                              echo "<tr>";
                              echo "<td colspan='5'>". $this->lang->line('no_list_found')."</td>";
                              echo "</tr>";
                          } ?>
                     </tbody>
                      </table>
                   </div><!-- /.box-body --> 
                    <div class="box-footer">
                       <div class="no-print">
                          <button onclick="print_content()" class="btn btn-primary">Print this page</button>
                      </div>
                  </div>
                 </div> <!--box end -->
                  <div class="box box-info">
                  <div class="box-header">
                      <h3><?php echo $this->lang->line('activity_list_not_login'); ?></h3>
                  </div>
                  <div class="box-body">
                     <table id="" class="table table-bordered table-striped dataTable">  
                         <thead>
                          <tr>
                              <th><?php echo $this->lang->line('sno'); ?>#</th>
                              <th><?php echo $this->lang->line('uid'); ?></th>
                              <th><?php echo $this->lang->line('name'); ?></th>
                          </tr>
                         </thead>
                         <tbody>
                          <?php if($activity_list_not_login){
                              $i = 1;
                              foreach($activity_list_not_login as $row){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                  echo "<td>".$row->emp_unique_id."</td>";
                                  echo "<td>".$row->emp_full_name_hi." / ".$row->emprole_name_hi."</td>";
                                  echo "</tr>";
                             $i++; }
                          } else {
                              echo "<tr>";
                              echo "<td colspan='5'>". $this->lang->line('no_list_found')."</td>";
                              echo "</tr>";
                          } ?>
                     </tbody>
                      </table>
                   </div><!-- /.box-body --> 
                    <div class="box-footer">
                       <div class="no-print">
                          <button onclick="print_content()" class="btn btn-primary">Print this page</button>
                      </div>
                  </div>
                 </div>
               </div>
               <div class="col-lg-5 col-xs-12">
              <!-- small box -->
               <div class="box box-info">
                  <div class="box-header">
                      <h3><?php echo $this->lang->line('activity_list_today'); ?></h3>
                  </div>
                  <div class="box-body">
                     <table id="" class="table table-bordered table-striped dataTable">  
                         <thead>
                          <tr>
                              <th><?php echo $this->lang->line('sno'); ?>#</th>
                              <th><?php echo $this->lang->line('uid'); ?></th>
                              <th><?php echo $this->lang->line('name'); ?></th>
                              <th><?php echo $this->lang->line('time'); ?></th>
                          </tr>
                         </thead>
                         <tbody>
                          <?php if(isset($activity_lists_today)){
                              $i = 1;
                              foreach($activity_lists_today as $row){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                  echo "<td>".$row->emp_unique_id."</td>";
                                  echo "<td>".$row->emp_full_name_hi." / ".$row->emprole_name_hi."</td>";
                                  echo "<td>".get_datetime_formate($row->log_create_date)."</td>"; ?>
                                 <?php  echo "</tr>";
                             $i++; }
                          } else {
                              echo "<tr>";
                              echo "<td colspan='5'>". $this->lang->line('no_list_found')."</td>";
                              echo "</tr>";
                          } ?>
                     </tbody>
                      </table>
                   </div><!-- /.box-body --> 
                    <div class="box-footer">
                       <div class="no-print">
                          <button onclick="print_content()" class="btn btn-primary">Print this page</button>
                      </div>
                  </div>
                 </div>
               </div>
              </div>
            </div><!-- ./col -->
          <!-- Main row -->
        </section><!-- /.content -->