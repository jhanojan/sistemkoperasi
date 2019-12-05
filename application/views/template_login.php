<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SISTEM KOPERASI</title>
    <meta name="description" content="webmazhters">
    <meta name="author" content="mazhters irwan">

    <!-- script -->
		<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-alerts.js"></script>
		<script>
		$(document).ready(function(){
			$('.close').click(function(){
				$(".alert-message").alert('close');
			});
		});
		</script>
		
    <!-- styles -->
    <link href="<?php echo base_url();?>assets/style/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo base_url();?>faviconz.ico">
  </head>

  <body>
  	<header>
			<?php $this->load->view($header); ?>
  	</header>

    <div class="container-fluid">
      <div class="content" style="margin-left:0px;">
        <?php $this->load->view($main_content); ?>
        <footer>
          <?php $this->load->view($footer); ?>
        </footer>
      </div>
    </div>

  </body>
</html>