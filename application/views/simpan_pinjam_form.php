<!--link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<!--script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script-->

<script>
    
		// This method is called right before the ajax form validation request
		// it is typically used to setup some visuals ("Please wait...");
		// you may return a false to stop the request 
		function beforeCall(form, options){
			//alert('oke');
			if (window.console) 
			console.log("Right before the AJAX form validation call");
			return true;
		}
            
		// Called once the server replies to the ajax form validation request
		function ajaxValidationCallback(status, form, json, options){
			if (window.console) 
			console.log(status);
                
			if (status === true) {
				alert('the form is valid!');
				// uncomment these lines to submit the form to form.action
				 form.validationEngine('detach');
				 form.submit();
				// or you may use AJAX again to submit the data
			}
		}
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#form_edit").validationEngine({
				
				/*ajaxFormValidation: true,
				ajaxFormValidationMethod: 'post',
				onAjaxFormComplete: ajaxValidationCallback*/
				
				});
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
							<label class="title">ID Karyawan</label>
							<?php 
								$nm_f = "id_karyawan";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required,ajax[ajaxcekkaryawan]]'");
							?>
						</div>
						<div class="clearfix">
							<label class="title">Tipe</label>
							<?php 
								$nm_f = "tipe";
								echo form_dropdown($nm_f, $tipe_sp, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
                        <div class="clearfix" style="display:none;" id="jml_angsuran_div">
							<label class="title">Jumlah Angsuran</label>
							<?php 
								$nm_f = "jml_angsuran";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> kali
						</div>
                        <div class="clearfix" style="display:none;" id="bunga_div">
							<label class="title">Bunga</label>
							<?php 
								$nm_f = "bunga";
								echo form_input($nm_f, isset($bunga) ? $bunga : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> %
						</div>
                        <div class="clearfix" style="display:none;" id="tgl_jatuh_tempo_div">
							<label class="title">Tanggal Jatuh Tempo</label>
							<?php 
								$nm_f = "tgl_jatuh_tempo";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> setiap bulannya
						</div>
                        <div class="clearfix" style="display:none;" id="tlp_div">
							<label class="title">Telepon</label>
							<?php 
								$nm_f = "tlp";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?>
						</div>
                        <div class="clearfix" style="display:none;" id="email_div">
							<label class="title">Email</label>
							<?php 
								$nm_f = "email";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?>
						</div>
                        <div class="clearfix" style="display:none;" id="deskripsi_div">
							<label class="title">Deskripsi Barang</label>
							<?php 
								$nm_f = "deskripsi";
								echo form_textarea($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?>
						</div>
                        <div class="clearfix" style="display:none;" id="debit_div">
							<label class="title">Debet</label>
							<?php 
								$nm_f = "total_debit";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
                        <div class="clearfix" style="display:none;" id="kredit_div">
							<label class="title">Total Kredit</label>
							<?php 
								$nm_f = "total_kredit";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
					</td>

				</tr>

			</table>

			

			<div class="clearfix_button">

	    	<input type="submit" name="back" value="Apply" class="btn" id="sambit" disabled>&nbsp;&nbsp;&nbsp;

	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>

		</fieldset>

	</form>

  
<fieldset id="biodata">
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>

function cekpinjamankaryawan(){
$.ajax({
	type: "POST",
	url: "<?php echo site_url('load')?>/cekkaryawan/",
	data: { fieldId : 'id_karyawan', fieldValue : $("#id_karyawan").val() }
    ,
    success: function(msg) {
	var n = msg.search("true");
	var d = msg.search("disabled");
	var e = msg.search("enabled");
	var ee = msg.search("exception");
        //alert(n>);
		if(n>0){
			$("#biodata").attr('style','display:');	
	$("#biodata").load('<?php echo site_url('load')?>/muatkaryawan/'+ $("#id_karyawan").val() );
		}
		else{
			$("#biodata").attr('style','display:none');	
		}
		
		
		if(d>0){
			alert('Anda mempunyai Hutang Belum Lunas.');
			$('#sambit').prop('disabled',true);
			
			$("#kredit_div").attr("style","display:none");
			$("#tlp_div").attr("style","display:none");
			$("#email_div").attr("style","display:none");
			$("#debit_div").attr("style","display:none");
			$("#tgl_jatuh_tempo_div").attr("style","display:none");
			$("#jml_angsuran_div").attr("style","display:none");
			$("#bunga_div").attr("style","display:none");	
			$("#deskripsi_div").attr("style","display:none");
		}
		else if(e>0){
			$('#sambit').removeProp('disabled');
		}
		else if(ee>0){
			alert('Anda mempunyai Hutang Belum Lunas \n Tapi Anda Diizinkan Meminjam Lagi');
			$('#sambit').removeProp('disabled');
		}
    }
	});	
}

function bukapinjaman(){
	$.ajax({
	type: "POST",
	url: "<?php echo site_url('load')?>/tipes/"+$("#tipe").val(),
	data: { use : null }
    ,
    success: function(msg) {
        //alert(msg);
		
	var s = msg.search("simpan");
	var p = msg.search("pinjam");
	var des = msg.search("Pembiayaan");
		if(s>0){
			$("#kredit_div").attr("style","display:");
			$("#debit_div").attr("style","display:none");
			$("#tgl_jatuh_tempo_div").attr("style","display:none");
			$("#jml_angsuran_div").attr("style","display:none");
			$("#bunga_div").attr("style","display:none");
			$("#tlp_div").attr("style","display:none");
			$("#email_div").attr("style","display:none");
			$("#deskripsi_div").attr("style","display:none");
			
			
			$("#total_kredit").removeClass("validate[required]");
			$("#total_debit").removeClass("validate[required]");
			$("#tgl_jatuh_tempo").removeClass("validate[required]");
			$("#jml_angsuran").removeClass("validate[required]");
			$("#bunga").removeClass("validate[required]");
			$("#deskripsi").removeClass("validate[required]");
			
			$("#total_kredit").addClass("validate[required]");
		}
		else if(p>0){
			if($("#tipe").val()!='' && $("#id_karyawan").val() !=''){
				cekpinjamankaryawan();
			$("#kredit_div").attr("style","display:none");
			$("#tlp_div").attr("style","display:");
			$("#email_div").attr("style","display:");
			$("#debit_div").attr("style","display:");
			$("#tgl_jatuh_tempo_div").attr("style","display:");
			$("#jml_angsuran_div").attr("style","display:");
			$("#bunga_div").attr("style","display:");
			if(des>0){
			$("#deskripsi_div").attr("style","display:");}
			
			$("#total_kredit").removeClass("validate[required]");
			$("#total_debit").removeClass("validate[required]");
			$("#tgl_jatuh_tempo").removeClass("validate[required]");
			$("#tlp").removeClass("validate[required]");
			$("#email").removeClass("validate[required]");
			$("#deskripsi").removeClass("validate[required]");
			$("#jml_angsuran").removeClass("validate[required]");
			$("#bunga").removeClass("validate[required]");
			
			if(des>0){
			$("#deskripsi").addClass("validate[required]");}
			$("#tlp").addClass("validate[required]");
			$("#email").addClass("validate[required]");
			$("#total_debit").addClass("validate[required]");
			$("#tgl_jatuh_tempo").addClass("validate[required]");
			$("#jml_angsuran").addClass("validate[required]");
			$("#bunga").addClass("validate[required]");
			}
		}
    }
	});
	
	
	}

$("#tipe").change(function(){
	bukapinjaman();
});

$("#id_karyawan").focusout(function(){
	bukapinjaman();
});


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