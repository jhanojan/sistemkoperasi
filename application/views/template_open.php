<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo lang('app_name');?></title>
    <meta name="description" content="webmazhters http://www.mazhters.com/">
    <meta name="author" content="Mazhters Irwan">

    <!-- styles -->
    <link href="<?php echo base_url();?>assets/style/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/style/BreadCrumb.css" rel="stylesheet">
    
    <?php
    if(cekIpad())
    {
    	?>
    	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    	<?php
    }
    else
    {
    	?>
    	<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    	<?php
    }
    ?>
    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo base_url();?>faviconz.ico">    
  </head>

  <body>
  	<div class="container-fluid">
    	<div class="content" style="margin-left:0px;">
    		<div class="clear"></div>
        <?php $this->load->view($main_content); ?>
      </div>
    </div>
  </body>
</html>