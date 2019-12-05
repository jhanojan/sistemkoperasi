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
	<form id="form_edit" action="<?php echo base_url().$path_file;?>/update" method="post" enctype="multipart/form-data">
		<fieldset>
			<table id="tb_form_edit">
				<tr>
					<td>
						<?php echo form_hidden("id", isset($val["id"]) ? $val["id"] : '');?>
						<div class="clearfix">
							<label class="title">Grup Admin</label>
							<?php 
								$nm_f = "id_admin_grup";
								echo form_dropdown($nm_f, $opt_grup, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Menu Admin</label>
							<?php 
								$nm_f = "id_menu_admin";
								echo form_dropdown($nm_f, $opt_menu, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						
					</td>
				</tr>
			</table>
			
			<div class="clearfix_button">
	    	<input type="submit" name="back" value="<?php echo $val_button;?>" class="btn">&nbsp;&nbsp;&nbsp;
	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->
	    </div>
		</fieldset>
	</form>
</div>
<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>
<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />
<script>
$(function() {
	$('#tanggal_permohonan').datepicker({
		dateFormat: 'yy-mm-dd', 
		changeMonth: true,
		changeYear: true
	});
});
</script>