<link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script>

<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#form_edit").validationEngine('attach');
		});
</script>
<div id="block_add_edit">

	<h2><?php echo $title;?></h2>

	<?php

	$flashmessage = $this->session->flashdata('message');

	if($flashmessage)

	{

		?>

		<div class="alert-message success fade in">

      <a href="#" class="close">&times;</a>

      <p><?php echo $flashmessage;?></p>

    </div>

    <?php

	}

	?>

	<form id="form_edit" action="<?php echo base_url().$filename;?>/update" method="post" enctype="multipart/form-data">

		<fieldset>
			<table id="tb_form_edit">

				<tr>

					<td>

						<?php echo form_hidden("id", isset($val["id"]) ? $val["id"] : '');?>
						
                        <div class="clearfix">
							<label class="title">Nama</label>
							<?php 
								$nm_f = "nama";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div><div class="clearfix">
							<label class="title">Alamat</label>
							<?php 
								$nm_f = "alamat";
								echo form_textarea($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>

						<!--<div class="clearfix">
							<label class="title">Tanggal Permohonan</label>
							<?php 
/*
								$nm_f = "tgl_permohonan";

								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span5 required'");

								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
*/
							?>

						</div>-->
					</td>

				</tr>

			</table>

			

			<div class="clearfix_button">

	    	<input type="submit" name="back" value="Apply" class="btn">&nbsp;&nbsp;&nbsp;

	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>

		</fieldset>

	</form>

  
<fieldset>
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>

$(function() {

	$('#tgl_permohonan').datepicker({

		dateFormat: 'yy-mm-dd', 

		changeMonth: true,

		changeYear: true

	});
	
	$('#tgl_izin').datepicker({

		dateFormat: 'yy-mm-dd', 

		changeMonth: true,

		changeYear: true

	});

});

</script>