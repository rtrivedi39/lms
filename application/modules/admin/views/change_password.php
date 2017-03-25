<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>FTMS | Change Password</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script type="text/javascript">
            setTimeout(function() {
                $('.hideauto').fadeOut('fast');
            }, 8000);
            var HTTP_PATH = "<?php echo HTTP_PATH; ?>";
            var SITE_NAME = "<?php echo SITE_NAME; ?>";
        </script>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo base_url();?>admin">Change Password</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php echo $this->session->flashdata('update'); ?>
          <?php 
                 $attributes_change_pwd = array('class' => 'form-signin', 'id' => 'formchange_pwd', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('admin/admin_dashboard/change_pwd', $attributes_change_pwd);
                ?> 
       
          <?php if (validation_errors() != "") {?>
              <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>Input Warnings :</strong><br>
                  <?php echo validation_errors(); ?>
              </div>
          <?php }?>
          <div class="form-group has-feedback">
            <!-- <input type="email" class="form-control" placeholder="Email"/> -->
            <input type="password" name="new_pwd" id="new_pwd" class="form-control" placeholder="New Password" >
            
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="confirm_pwd" id="confirm_pwd" required class="form-control" placeholder="Confirm Password">
            
          </div>
          <div class="row">
            <div class="col-xs-6">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
            </div><!-- /.col -->
          </div>
        </form>
        <form  id="forgot-form" style="display:none;" action="<?php echo base_url();?>admin/forgote_password" method="post">
                <div class="form-group has-feedback">
                  <input type="text" name="email" id="email" class="form-control" placeholder="Email address" >
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <!-- <input type="email" name="email" required id="email"  class="form-control" placeholder="Email address" ><br> -->
                <div id="forgot-msg"></div>
                <div class="row">
                  <div class="col-xs-7">    
                       <a href="javascript:void(0);" onclick="login();">Login existing user</a><br>               
                  </div><!-- /.col -->
                  <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="return valForgot();" name="forgotpassword" type="submit">Send password</button>
                  </div><!-- /.col -->
                </div>
               <!--  <label >
                    <a href="javascript:void(0);" onclick="login();" >Login existing user ?</a>
                </label><br>
                <button class="btn btn-primary btn-block btn-flat" onclick="return valForgot();" name="forgotpassword" type="submit">Send password</button> -->
            </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!--<script src="<?php echo ADMIN_THEME_PATH; ?>common_js/common.js"></script>-->
    <script src="<?php echo ADMIN_THEME_PATH; ?>common_js/login.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>