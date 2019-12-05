<link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/js/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.8.4.custom.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validate_new/validate.js"></script>
				
<link rel="stylesheet" href="<?php echo base_url();?>assets/style/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?php echo  base_url();?>assets/js/autosuggest.js"></script>
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
			$('#kodeBar').focus();
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

	<!--<form id="form_edit" action="#" method="post" enctype="multipart/form-data">-->

		<fieldset>
			<table id="tb_form_edit" style="width:100%;">

				<tr>

					<td>

<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-setting-pos" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Transaction</h2>
				</header>
				<!-- widget div-->
				<div>
					<!-- end widget edit box -->
                    
					<!-- widget content -->
					<div class="widget-body no-padding" id="wrapFormPOS">
                    <form id="form_edit" action="<?php echo site_url('pos_app')?>/update" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="a" value="input"/>
                            <input type="hidden" name="c" value="true"/>
                            <input type="hidden" name="ajax" value="true"/>
							
                            <fieldset>
                                <section class="col-sm-5">
									<label class="input">
                                        <i class="icon-append fa fa-plus-square"></i>
										<input type="text" id="kodeBar" placeholder="< Type/SCAN item info here"/>
									</label>
                                </section>
                            </fieldset>
                            <fieldset>
                                <div class="clearfix" style="padding: 5px;min-height: 150px!important">
                                    <table id="tablePOS" class="table table-striped table-hover" width="100%">
            							<thead>
            								<tr>
            									<th width="13%">Code</th>
                                                <th width="10%">QTY</th>
                                                <th width="40%">Item Name</th>
                                                <th width="13%">Price</th>
                                                <th width="13%">Total</th>
            								</tr>
            							</thead>
            							<tbody>
                                            
            							</tbody>
            						</table>
                                </div>
                            </fieldset>
                            
							<fieldset>
                                <div class="clearfix">
                                <table>
                                <tr>
                                <td>
										<label class="label"><strong>Discount</strong> %</label>
								</td><td>
											<input type="text" id="diskon" name="diskon" value="0">
								</td><td>
										<label class="label"><strong>PPN</strong>%</label>
								</td><td>
											<input type="text" id="ppn" name="ppn" value="<?php echo $ppn?>" style="background-color: rgba(230, 230, 230, 0.21);">
								</td><td>
								</div>
                                <div class="clearfix">
                                    <section class="col col-xs-12">
										<label class="label"><strong>TOTAL</strong></label>
											<input type="text" name="totalprice" id="totalprice" style="background-color: rgba(230, 230, 230, 0.21);height:100px;font-size: 50pt; width:80%;" readonly>
									</section>
                                </div>
							</fieldset>

					</div>
                </div>
            </div>
					<!-- end widget content -->
		</article>
		<!-- WIDGET END -->
    </div>
	<!-- end row -->

</section>
<!-- end widget grid -->
</td>

				</tr>
                <tr>
                <td>
                Tipe Pembayaran
                </td>
                <td>
                <select id="tipe_pembayaran" name="tipe_pembayaran">
                <option value="cash">
                Cash
                </option>
                <option value="kredit">
                Kredit
                </option>
                </select>
                </td>
                </tr>
                <tr>
                
                <table width="47%" style="float:left; display:none;" id="detailkredit">
                 <tr>
							<td>Jumlah Angsuran</td>
							<td><?php 
								$nm_f = "jml_angsuran";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> kali</td>
                  <tr>
							<td>Tanggal Jatuh Tempo</td>
							<td><?php 
								$nm_f = "tgl_jatuh_tempo";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> setiap bulannya
						</td>
                        
                     </tr>
                 <tr>
							<td>Bunga</td>
							<td><?php 
								$nm_f = "bunga";
								echo form_input($nm_f, isset($val[$nm_f]) ? GetValue('value','tb_ppn',array('nama'=>'where/bunga')) : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> %</td>
                  <tr>
                 <tr>
							<td>Telepon</td>
							<td><?php 
								$nm_f = "tlp";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> </td>
                  <tr>
                 <tr>
							<td>Email</td>
							<td><?php 
								$nm_f = "email";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]'");
							?> </td>
                  <tr><div class="clearfix" style="display:
                  none">
							<label class="title">Tipe</label>
							<?php 
								$nm_f = "tipe";
								echo form_dropdown($nm_f, $tipe_sp, 6, "id='".$nm_f."' class='validate[required]'");
							?>
						</div>
                     </table>
                    <table>
                <tr>
							<td>ID Karyawan</td>
							<td><?php 
								$nm_f = "id_karyawan";
								echo form_input($nm_f, isset($val[$nm_f]) ? $val[$nm_f] : "", "id='".$nm_f."' ");
							?></td>
                 </tr>
                 </table>
<fieldset id="biodata" style="width:47%;">
				
</fieldset>
                </tr>

			</table>

			
                <div id="rincian">
                </div>

			<div class="clearfix_button">
	    	<!--<input type="submit" name="back" value="<?php echo $val_button." & ".lang("back");?>" class="btn">-->

	    </div>
</form>
		</fieldset>

	<!--</form>-->

  
<fieldset id="riwayat">
</fieldset>
</div>

<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>

<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />

<script>
$(document).keyup(function(e){
     hitungtotal();
});
$(document).ready(function() {
	
	 hitungtotal();
   $(document).keydown(function(e) {
    if(e.which==16){
		$("#kodeBar").focus();
     }
	 else if(e.which==17){
		 
		$('.qty').focus();
     }
	 else if(e.which==35){
		 
		$('#diskon').focus();
     }
	 else if(e.which==36){
		 
		$('#ppn').focus();
     }
	 else if(e.which==192){
		 if($('#totalprice').val()!=0){
		$('#form_edit').submit();
		window.open('<?php echo site_url()?>');
		 }
     }
	 
	 else if(e.which==220){
		 
		$('#tipe_pembayaran').focus();
     }
	 else if(e.which==191){
		 
		$('#id_karyawan').focus();
     }
	 else if(e.which==20){
		 
		hitungtotal();
     }
   });
});
<?php for($a=0;$a<=100;$a++){?>
$(document).off('keyup','#qty-<?php echo $a?>').on('keyup','#qty-<?php echo $a?>',function(e){
	var harga=parseInt($(this).val())*parseFloat($('#harga_dasar-<?php echo $a?>').val());
	//alert(harga);
	$('#total_price_<?php echo $a?>').val(harga);
});
<?php }?>

$("#kodeBar").delay(10000).keyup(function(){
	$.ajax({
	type: "POST",
	url: "<?php echo site_url('load')?>/cekbarang/",
	data: { fieldId : 'kodeBar', fieldValue : $("#kodeBar").val() }
    ,
    success: function(msg) {
	var n = msg.search("true");
	var m = msg.search("minimum");
	var h = msg.search("habis");
        //alert(n>);
		
		if(h>0){
		alert('Barang Sudah Habis');
	$("#kodeBar").val('');
		}
		else if(n>0){
		
		if(m>0){
		alert('Barang Sudah Memasuki Minimum Stok');	
		}
	var i = 0;
            if($('#tablePOS tbody tr').length > 0){
                i = $('#tablePOS tbody tr:last').attr('data-id');
                i = parseInt(i) + 1;
            }
	
	$.get('<?php echo site_url('load')?>/muatbarang/'+ $("#kodeBar").val()+'/'+i, function(result) {
    $('#tablePOS tbody').append(result);
	hitungtotal();
	});
	$("#kodeBar").val('');
	}
    }
	});
});


function hitungtotal(){
	var ppn = parseInt($('#ppn').val());
	var diskon = parseInt($('#diskon').val());
	var a = 0;
            if($('#tablePOS tbody tr').length > 0){
                a = $('#tablePOS tbody tr:last').attr('data-id');
                a = parseInt(a) + 1;
            }
var total = 0;
for (var i = 0; i <= a; i++) {
	total += parseInt($('#total_price_'+i).val()<<0);
}	

	total = total * (100+ppn)/100;
	
	total = total * (100-diskon)/100;
	
	total= parseInt(total);
	
	$('#totalprice').val(total);
	//alert(total);
}

		$('#tipe_pembayaran').keyup(function(){
		var msg=$(this).val();
		if(msg=='cash'){
			
			$("#detailkredit").attr("style","display:none");
			$("#id_karyawan").removeClass("validate[required]");
			
			/*$("#total_kredit").removeClass("validate[required]");
			$("#total_debit").removeClass("validate[required]");
			$("#tgl_jatuh_tempo").removeClass("validate[required]");
			$("#jml_angsuran").removeClass("validate[required]");
			$("#bunga").removeClass("validate[required]");
			
			$("#total_kredit").addClass("validate[required]");*/
		}
		else{
			
			$("#detailkredit").attr("style","display:");
			$("#id_karyawan").addClass("validate[required]");
			/*$("#kredit_div").attr("style","display:none");
			$("#debit_div").attr("style","display:");
			$("#tgl_jatuh_tempo_div").attr("style","display:");
			$("#jml_angsuran_div").attr("style","display:");
			$("#bunga_div").attr("style","display:");
			
			$("#total_kredit").removeClass("validate[required]");
			$("#debit").removeClass("validate[required]");
			$("#tgl_jatuh_tempo").removeClass("validate[required]");
			$("#jml_angsuran").removeClass("validate[required]");
			$("#bunga").removeClass("validate[required]");
			
			$("#total_debit").addClass("validate[required]");
			$("#tgl_jatuh_tempo").addClass("validate[required]");
			$("#jml_angsuran").addClass("validate[required]");
			$("#bunga").addClass("validate[required]");*/
		}
    
});
$("#id_karyawan").keyup(function(){
	$.ajax({
	type: "POST",
	url: "<?php echo site_url('load')?>/cekkaryawan/",
	data: { fieldId : 'id_karyawan', fieldValue : $("#id_karyawan").val() }
    ,
    success: function(msg) {
	var n = msg.search("true");;
        //alert(n>);
		if(n>0){
	$("#biodata").load('<?php echo site_url('load')?>/muatkaryawan/'+ $("#id_karyawan").val() );
		}
    }
	});
});

</script>
<!--<script>
  $(function() {
    var availableTags = [
      <?php foreach($autocomplete as $tagss){?>
	  "<?php echo strtolower($tagss['kode_barang'])?>",
	  <?php }?>
    ];
    $( "#kodeBar" ).autocomplete({
      source: availableTags
    });
  });
  </script>
-->
<script type="text/javascript">
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
	var as_xml = new AutoSuggest('kodeBar', options_xml);
</script>
