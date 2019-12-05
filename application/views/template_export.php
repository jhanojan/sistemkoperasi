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
    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo base_url();?>faviconz.ico">    
  </head>
  <body>
  <?php $this->load->view($main_content); ?>
  </body>
</html>