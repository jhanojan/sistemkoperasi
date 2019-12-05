<link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script>


<link rel="stylesheet" href="<?php echo base_url();?>assets/style/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?php echo  base_url();?>assets/js/autosuggest.js"></script>
<script>

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
							<label class="title">Kode Barang</label>
							<?php 
								$nm_f = "kode_barang";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='validate[required]'");
							?> 
						</div>
                        
                        
						<div class="clearfix">
							<label class="title">Jumlah</label>
							<?php 
								$nm_f = "jumlah";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class=' validate[required,custom[number]]'");
								echo form_hidden($nm_f."_temp", isset($val[$nm_f]) ? $val[$nm_f] : "");
							?>
						</div>
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

	$('#tanggal').datepicker({

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


	var options = {
		script:"test.php?json=true&",
		varname:"input",
		json:true,
		callback: function (obj) { document.getElementById('testid').value = obj.id; }
	};
	var as_json = new AutoSuggest('testinput', options);
	
	
	var options_xml = {
		script:"<?php echo site_url()?>load/suggestbarang/?",
		varname:"input",
		noresults:"Barang Tidak Ditemukan",
		timeout:1000000
	};
	var as_xml = new AutoSuggest('kode_barang', options_xml);
</script>
