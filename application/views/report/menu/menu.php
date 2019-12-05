  <!--including-->
  <?php if(!isset($katakuncirahasia)){error_reporting(E_ALL^E_NOTICE);}?>
<!--
<script type="text/javascript" src="<?php echo base_url()?>assets/js/print_f.js"></script>-->
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript">
function carimenu(id)
{
	$("#documents").load('<?php echo base_url()?>report/response_cat/'+id);
}
function carikar(id)
{
	if(!id) id = "0";
	$("#karyawannya").load('<?php echo base_url()?>report/karyawannya/'+id);
}
</script>
<!--<fieldset style="border:1px solid black; border-radius:5px; width:40%; margin:0 auto;"> <legend> Document Report </legend>-->
<div id="search">
	<table style='width:500px;'>
		<tr id="head">
	    <td>Type Document</td>
	  </tr>
		<tr>
			<td>
				<select name="tipedocument" onChange="carimenu(this.value)"><option value="" selected>--Pilih Tipe Dokumen--</option><?php
				 foreach($tipedokumen as $pilihan){
					?> 
					<option value="<?php echo $pilihan->id;?>" title="<?php echo $pilihan->detail;?>"><?php echo $pilihan->title_document;?></option>
					<?php	
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td style="padding-left:0px;">
				<div id='documents' style="margin-top:25px;"></div>
			</td>
		</tr>
	</table>
</div>
