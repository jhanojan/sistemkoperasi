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
			<table id="tb_form_edit" style="float:left">

				<tr>

					<td>

						<?php echo form_hidden("id", isset($val["id"]) ? $val["id"] : '');?>
						<div class="clearfix">
							<label class="title">Kode Barang</label>
							<?php 
								$nm_f = "kode_barang";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Kode Grup</label>
							<?php 
								$nm_f = "kode_group";
								echo form_dropdown($nm_f,$grup_parent, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."'");
							?>
						</div>

						<div class="clearfix">
							<label class="title">Nama</label>
							<?php 
								$nm_f = "nama";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Keterangan</label>
							<?php 
								$nm_f = "keterangan";
								echo form_textarea($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Jumlah</label>
							<?php 
								$nm_f = "jumlah";
								echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required,custom[integer]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Satuan</label>
							<?php 
								$nm_f = "satuan";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Jumlah Min.</label>
							<?php 
								$nm_f = "min_qty";
								echo form_input($nm_f,isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required,custom[integer]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Status</label>
							<?php 
								$nm_f = "status";
								echo form_dropdown($nm_f, array('y'=>'Active','n'=>'InActive'),isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        	<div class="clearfix_button">
&nbsp;&nbsp;&nbsp;

	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>
					</td>

				</tr>
			</table>
<fieldset>
						<div class="clearfix">
							<label class="title">Tanggal Berlaku</label>
							<?php 
								$nm_f = "tanggal";
								echo form_input($nm_f,"", "id='tgl_berlaku'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Harga Beli</label>
							<?php 
								$nm_f = "harga_beli";
								echo form_input($nm_f,"", "id='".$nm_f."'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Harga Jual</label>
							<?php 
								$nm_f = "harga_jual";
								echo form_input($nm_f,"", "id='".$nm_f."'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
    
	    	<input type="submit" name="back" value="Apply" class="btn" style="float:right">
    </form><br>
			<table style="margin-left:15%; float:left; border:1px double black; border-radius:15%;" class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
    <tr>
    <td colspan="2">
    Perubahan Harga
    </td>
    </tr>
    <tr>
    <td>Tanggal Berlaku
    </td>                                   
     <td>Harga Beli               
    </td>                                       
     <td>Harga Jual               
    </td>                                 
     <td>Act               
    </td>
    </tr>
    </thead>
    <tbody>
    <?php if($harga->num_rows()==0){?>
    <tr>
    <td colspan="4">
    Tidak Ada Data
    </td>
    </tr>
    <?php } else{
		foreach($harga->result() as $hargakini){
		?>
        <form action="<?php echo site_url('inventory').'/deletehargajual/'.$val['id']?>" method="post">
    <input type="hidden" name="id_harga" value="<?php echo $hargakini->id?>">
    <tr>
    <td>
    <?php echo tgl_indo($hargakini->tanggal) ?>
    </td>
    <td>
    <?php echo $hargakini->harga_beli?>
    </td>
    <td>
    <?php echo $hargakini->harga_jual?>
    </td>
    <td><input type="submit" value="Delete">
</td>
    </tr>
    </form>
    <?php 
		}
	}?>
    </tbody>
    </table>

		</fieldset>
			

		

		</fieldset>

	

  
<fieldset>
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>

$(function() {

	$('#tgl_berlaku').datepicker({

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