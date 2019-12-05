<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo lang('app_name');?></title>
    <meta name="description" content="webmazhters">
    <meta name="author" content="mazhters irwan">

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
			<?php $this->load->view($main_content); ?>
      <footer>
	      <?php $this->load->view($footer); ?>
	    </footer>
    </div>
    
    <!-- script -->
		<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$('.a_lang').click(function(e) 
			{
				var id_del_img = document.getElementById('id');
				var id_lang = $(this).attr('alt');
				var uri 	= '<?php echo base_url();?>load/change_lang';
				var data  = { id_lang : id_lang};
				$.ajax({ type: "POST", url: uri,data: data,  dataType: "html", success : function(data) {
					window.location.reload();
				}});
			});
		});
		
		</script>
		<!-- Menu -->
		<script src="<?php echo base_url();?>assets/js/menu.js" ></script>
		
  </body>
</html>



<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-modal.js"></script>
<div id="modal-password" class="modal hide fade" style="width:670px;left:45%;">
  <div class="modal-header">
    <a href="#" class="close">&times;</a>
    <h3 class="popup">Ganti Password</h3>
  </div>
  <div class="modal-body">
    <iframe id="framez-password" frameborder="0" scrolling="no" width="650" height="350" 
    	src="<?php echo site_url('login/change_password');?>"></iframe>
  </div>
</div>