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
  	<header>
			<?php $this->load->view($header); ?>
  	</header>

    <div class="container-fluid">
    	<div class="content" style="margin-left:0px;">
    		<div class="clear"></div>
    		<div id="breadCrumb0" class="breadCrumb module">
    			<ul>
					<?php echo $breadcrumb;?>
					</ul>
				</div>
        <?php $this->load->view($main_content); ?>
        <footer>
          <?php $this->load->view($footer); ?>
        </footer>
      </div>
    </div>
    
    <!-- Placed at the end of the document so the pages load faster -->
		<!--<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>-->
		<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-alerts.js"></script>
		<script src="<?php echo base_url();?>assets/js/custom.js"></script>
		<script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script>
				
		<!-- Superfish Menu -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/superfish.css" />
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/superfish.js"></script>
		<!-- End Superfish Menu -->
		
		<!-- Breadcrumb -->
		<script src="<?php echo base_url();?>assets/js/jquery.jBreadCrumb.1.1.js"></script>
		<!-- End Breadcrumb -->
		
		<!-- Custom Script JS -->
    <script>
    $(document).ready(function() {
    	var temp_id = document.getElementById('temp_id');
			$('input.delete').click(function(e) 
			{
				var parent = $(this).parent('td').parent('tr');
				var val = $(this).attr('value');
				var frm = $("#"+parent.attr('id')).children('td');
				if($(this).attr('checked'))
				{
					frm .css({backgroundColor:'#F90'});					
					temp_id.value += val+"-";
				}
				else
				{
					frm .css({backgroundColor:''});
					temp_id.value = temp_id.value.replace(val+'-','');
				}
				
				if(temp_id.value) $('input.delete_button').attr('disabled', false);
				else $('input.delete_button').attr('disabled', true);
			});
			
    	$('input.delete_button').click(function(e) 
			{
				var answer = confirm("<?php echo lang('delete_confirm');?> ??");
				if(answer)
				{
					var uri 	= '<?php echo base_url();?><?php echo $path_file;?>/delete';
					var data  = { del_id : temp_id.value };
					$.ajax({ type: "POST", url: uri,data: data,  dataType: "html", success : function(data) {
						window.location='<?php echo current_url(); ?>';
					}});
				}
			});
			
			$('a.del_img').click(function(e) 
			{
				var id_del_img = document.getElementById('id');
				var answer = confirm("Anda yakin menghapus file ini ??");
				if(answer)
				{
					var tabel = '<?php echo $table;?>';
					var field = $(this).attr('alt');
					var uri 	= '<?php echo base_url();?>load/delete_image';
					var data  = { del_id_img : id_del_img.value, del_field : field, del_table: tabel};
					//$("#imgz").fadeOut(1000);
					$.ajax({ type: "POST", url: uri,data: data,  dataType: "html", success : function(data) {
						//$("#imgz").fadeOut(1000);
						//$(this).parent().fadeOut(1000);
						//$("#"+field+"_file").attr("value","-");
					}});
					$(this).parent().fadeOut(1000);
				}
			});
			
			//$('ul.main-nav').superfish();
			jQuery("#breadCrumb0").jBreadCrumb();
			$("#menu").attr("style","display:''");
		});
		</script>
  </body>
</html>