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
                        <?php 
						$kodkop=$this->db->select('kode')->from('tb_kode_koperasi')->get()->row_array();
								echo form_hidden('kodkop',$kodkop['kode'],"class='validate[required]'");
							?>
                        <div class="clearfix">
							<label class="title">NIK</label>
							<?php 
								$nm_f = "nik";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>    
						<div class="clearfix">
							<label class="title">Nama</label>
							<?php 
								$nm_f = "nama";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
						

						<div class="clearfix">
							<label class="title">Jabatan</label>
							<?php 
								$nm_f = "kode_jabatan";
								echo form_dropdown($nm_f, GetOptAllYes('tb_jabatan','- Jabatan -') ,isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Kelamin</label>
							<?php 
								$nm_f = "kelamin";
								echo form_dropdown($nm_f,array('L'=>'Laki-Laki','P'=>'Perempuan'), isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Tempat Lahir</label>
							<?php 
								$nm_f = "tmpt_lahir";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Tanggal Lahir</label>
							<?php 
								$nm_f = "tgl_lahir";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required,custom[date]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Agama</label>
							<?php 
								$nm_f = "agama";
								echo form_dropdown($nm_f,array(''=>'-Agama-','I'=>'Islam','P'=>'Protestan','K'=>'Katolik','H'=>'Hindu','B'=>'Budha'), isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Alamat</label>
							<?php 
								$nm_f = "alamat";
								echo form_textarea($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div><div class="clearfix">
							<label class="title">Telepon</label>
							<?php 
								$nm_f = "notel";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required,custom[phone]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div><div class="clearfix">
							<label class="title">Email</label>
							<?php 
								$nm_f = "email";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required,custom[email]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Izinkan Pinjam Lagi?</label>
							<?php 
								$nm_f = "pinjamlagi";
								echo form_dropdown($nm_f,array('y'=>'Ya','n'=>'Tidak'), isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
                        <div class="clearfix">
							<label class="title">Status</label>
							<?php 
								$nm_f = "status";
								echo form_dropdown($nm_f,array('y'=>'Aktif','n'=>'Tidak Aktif'), isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>

			<div class="clearfix_button">

	    	<input type="submit" name="back" value="Apply" class="btn">&nbsp;&nbsp;&nbsp;

	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>
					</td>

				</tr>

			</table>
            

	<fieldset>
			<table style="margin-left:15%; margin-top:5%; float:left; border:1px double black; border-radius:15%;">
    <tr>
    <td>
    Profile Picture
    </td>
    </tr>
    <tr>
    <td>
                        <div class="clearfix"><?php 
							if(isset($val["id"])){$ids=$val["id"];}
							else{$ids='';}
							$img=GetPP($ids);
							//echo $ids;
							?>
							<img src="<?php echo $img?>" width="100%" height="100%">
						</div><div class="clearfix">
							<?php 
								$nm_f = "image";
								echo '<input type="file" name="photo" id="photos" />';
							?>
                            <button id="resetphoto" style="display:block; margin-right:4%; float:right;">Reset</button>
							<br>
                            *)Jika gambar tidak diganti, Kosongkan saja
                        </div>
                     <div class="clearfix">
						</div>
                     
                     </form>
    </td>
    </tr>
    </table>

		</fieldset>

  
<fieldset>
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>

$(function() {

	$('#tgl_lahir').datepicker({

		dateFormat: 'yy-mm-dd', 

		changeMonth: true,

		changeYear: true,
		
		yearRange: '-70:+10'

	});
	
	$('#tgl_izin').datepicker({

		dateFormat: 'yy-mm-dd', 

		changeMonth: true,

		changeYear: true

	});
	$('#resetphoto').click(function(){
	$('#photos').val('');
	});

});

</script>