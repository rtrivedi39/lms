<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Law department, Govt of M.P.">
         <meta http-equiv="X-Frame-Options" content="deny">
        <title><?php echo $title; ?></title>
        <link href="<?php echo base_url(); ?>themes/admin/bootstrap/css/bootstrap.css" rel="stylesheet">


        <link href="<?php echo base_url(); ?>themes/style.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>themes/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>themes/admin/bootstrap/js/bootstrap.min.js"></script>
        <style id="antiClickjack">body{display:none !important;}</style>
      </head>
		<script type="text/javascript">
		   if (self === top) {
		       var antiClickjack = document.getElementById("antiClickjack");
		       antiClickjack.parentNode.removeChild(antiClickjack);
		   } else {
		       top.location = self.location;
		   }
		</script>
<body>
 <div class="container-fluid home">
  <div class="container border">
    <div class="row">
  	<div class="col-md-12 text-center">
            <?php 
            $header_image_properties = array(
            'src' => 'themes/site/images/header_logo.jpg',
            'alt' => $this->lang->line('home_header_image_title'),
            'class' => '',
            'width' => '',
            'height' => '',
            'title' => $this->lang->line('home_header_image_title'),
            'rel' => '',
            );		
            echo anchor('home', img($header_image_properties));
            ?>
  	</div>
    </div>
  <br/>
<div class="row">
    <div class="col-md-12 text-center">
        <ul class="footer-menu">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <!--<li>|</li>
            <li><a href="<?php echo base_url(); ?>privacy_policy">Privacy policy</a></li>-->
            <li>|</li>
            <li><a href="<?php echo base_url(); ?>faq">FAQ</a></li>
            <li>|</li>
            <li><a href="<?php echo base_url(); ?>uploads/notice/Law Department detailed Structure_3Nov2016.pdf" target="_blank">Departmental structure</a></li>
            <li>|</li>
            <li><a href="<?php echo base_url(); ?>uploads/notice/lawsetup.pdf" target="_blank">Departmental setup</a></li>
            <li>|</li>
            <li><a href="<?php echo base_url(); ?>uploads/notice/PS List-3Nov 2016PDF.pdf" target="_blank">PS List</a></li>
        </ul>
    </div>
</div>