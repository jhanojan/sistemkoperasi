<link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script>

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

	<form id="form_edit" action="<?php echo base_url().$filename;?>/update" method="post" enctype="multipart/form-data" style="display:none;">

		<fieldset>
			<table id="tb_form_edit">

				<tr>

					<td>

						<?php echo form_hidden("id", isset($val["id"]) ? $val["id"] : '');?>
						<div class="clearfix">
							<label class="title">Nota Simpan Pinjam</label>
							<?php 
								$nm_f = "id_simpan_pinjam";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required,ajax[ajaxpinjaman]]'");
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

	    	<input type="submit" name="back" value="Apply" class="btn" style="float:left;">&nbsp;&nbsp;&nbsp;

	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>

		</fieldset>

	</form>
	<form>
                <div id="rincian">
                </div>
	</form>
<br>
<br>
  
<fieldset id="riwayat">
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>

$(document).ready(function(){
	$.ajax({
	type: "POST",
	url: "<?php echo site_url('load')?>/cekpinjaman/",
	data: { fieldId : 'id_simpan_pinjam', fieldValue : $("#id_simpan_pinjam").val() }
    ,
    success: function(msg) {
	var n = msg.search("true");
        //alert(n>);
		if(n>0){
	//$("#id_karyawan").val()
	$("#rincian").load('<?php echo site_url('load')?>/muatrincian_pinjaman/'+ $("#id_simpan_pinjam").val() );
	$("#riwayat").load('<?php echo site_url('load')?>/muatriwayatbayar/'+ $("#id_simpan_pinjam").val() );
		}
    }
	});
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