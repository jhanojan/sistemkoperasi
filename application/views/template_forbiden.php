<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo lang('app_name');?></title>
    <meta name="description" content="webmazhters">
    <meta name="author" content="mazhters irwan">

    <!-- Menu -->
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/menu.js" ></script>
		
		<!-- styles -->
    <link href="<?php echo base_url();?>assets/style//bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/style//custom.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo base_url();?>faviconz.ico">
  </head>

  <body>
  	<header>
			<?php $this->load->view($header); ?>
		</header>

    <div class="container-fluid">
      <div class="content" style="text-align:center;margin-top:200px;margin-left:0px;font-size:30px;">
        <strong>Anda tidak boleh mengakses halaman ini.</strong>
      </div>
    </div>
  </body>
</html>
