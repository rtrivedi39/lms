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
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
               <div class="box box-info">
                  <div class="box-header">
                      <h3><?php echo $this->lang->line('activity_list'); ?></h3>
                  </div>
                  <div class="box-body">
                     <table id="example1" class="table table-bordered table-striped">   
                        <thead>                   
                          <tr>
                              <th><?php echo $this->lang->line('sno'); ?>#</th>
                              <th><?php echo $this->lang->line('name'); ?></th>
                              <th><?php echo $this->lang->line('ip_address'); ?></th>
                              <th><?php echo $this->lang->line('browser'); ?></th>
                              <th><?php echo $this->lang->line('time'); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if($activity_log_list){
                              $i = 1;
                              foreach($activity_log_list as $row){
                                  echo "<tr>";
                                  echo "<td>".$i."</td>";
                                  echo "<td>".$row->emp_full_name_hi."</td>";
                                  echo "<td>".$row->log_ip_address."</td>";
                                  echo "<td>".$row->log_browser."</td>";
                                  echo "<td>".get_datetime_formate($row->log_create_date)."</td>";
                                 echo "</tr>";
                             $i++; }
                          } else {
                              echo "<tr>";
                              echo "<td colspan='5'><?php echo $this->lang->line('no_list_found'); ?></td>";
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