<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/ui.dropdownchecklist.themeroller.css">
<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>
<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />
<script>
$(document).ready(function() {
	$('#tanggal').datepicker({
		dateFormat: 'yy-mm-dd', 
		changeMonth: true,
		changeYear: true
	});
	$('#tgl_selesai').datepicker({
		dateFormat: 'yy-mm-dd', 
		changeMonth: true,
		changeYear: true
	});
});
</script>

<!-- Include the basic JQuery support (core and ui) -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.8.13.custom.min.js"></script>

<!-- Include the DropDownCheckList supoprt -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ui.dropdownchecklist-1.4-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	$("#id_atasan").dropdownchecklist({emptyText: " - Nama Atasan -", maxDropHeight: 240, width: 275});
    	$("#id_bawahan").dropdownchecklist({emptyText: " - Nama Bawahan -", maxDropHeight: 240, width: 275});
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
	<form action="<?php echo base_url().$path_file;?>/update" method="post" enctype="multipart/form-data">
		<fieldset>
			<table id="tb_form_edit">
				<tr>
					<td>
						<?php $idz = isset($val['id']) ? $val['id'] : 0;?>
						<input type="hidden" name="id" value="<?php echo $idz;?>" id="id">
						<div class="clearfix">
							<label class="title">Tanggal</label>
							<?php 
								$nm_f = "tanggal";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 required'")." YYYY-MM-DD";
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						
						<div class="clearfix">
							<label class="title">Nama</label>
							<?php 
								$nm_f = "nama";
								echo form_dropdown($nm_f, $opt_nama, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."'");
							?>
						</div>
						
						<div class="clearfix">
							<label class="title">Jenis Klaim</label>
							<?php 
								$nm_f = "jenis_klaim";
								$opt_remark = array(
													  ''=>' - Jenis Klaim -',
													  'JKK'=>'JKK',
													  'JHT'=>'JHT',
													  'JM'=>'JM',
													  'JPK'=>'JPK');
								echo form_dropdown($nm_f, $opt_remark, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='required'");
							?>
						</div>
						
						<div class="clearfix">
							<label class="title">Value</label>
							<?php 
								$nm_f = "value";
								echo "Rp. ".form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span4 numeric'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
											
						<div class="clearfix">
							<label class="title">Remark</label>
							<?php 
								$nm_f = "remark";
								echo form_textarea($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='required'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						
					</td>
				</tr>
			</table>
			
			<div class="clearfix_button">
	    	<input type="submit" name="Ubah" value="<?php echo $val_button;?>" class="btn">&nbsp;&nbsp;&nbsp;
	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->
	    </div>
		</fieldset>
	</form>
</div>
