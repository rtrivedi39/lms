<?php $setion_id = getEmployeeSection();
	$notice_boards = getNoticeBoardInformation($setion_id); 
 ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_noticeboard'); ?></h3>
      </div><!-- /.box-header -->
      <?php if(count($notice_boards)>0){ ?>
      <div id="carousel">
          <div class="btn-bar">
            <?php if($notice_boards){ ?>
            <div id="buttons"><a id="prev" href="#"><</a><a id="next" href="#">></a> </div>
            <?php }?>
          </div>
          <div id="slides">
            <ul>
              	<?php 
                //pr($notice_boards);
              	if(count($notice_boards)>0){
              		foreach($notice_boards as $notice_board){?>
                    <li class="slide">
                      <div class="quoteContainer">
                        <p class="quote-phrase"><span class="quote-marks">"</span><?php echo isset($notice_board->notice_description)?$notice_board->notice_description:'' ?><span class="quote-marks">"</span> </p>
                      </div>
                      <div class="authorContainer">
                        <p class="quote-author"><?php echo isset($notice_board->notice_subject)?$notice_board->notice_subject:'' ?></p>
                      </div>
                    </li>
                  <?php } ?>
                <?php }else{
              		echo "<li>No Records Found</li>";
              	} ?>
            </ul>
          </div>
      </div>
      <?php }else{
            echo 'No Notice board found';
        } 
      ?>
    </div><!-- /.box -->
