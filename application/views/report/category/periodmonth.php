<tr id="periodmonth"><td>Period</td><td>:</td><td><select name="bulan" style="width:100px;"><option value="">-Bulan-</option><?php
foreach(array_keys($bulan) as $id){
?>
<option value="<?php echo $id;?>" <?php if($id==date("m")){ echo "Selected";}?>><?php echo $bulan[$id]?></option>
<?php	
}
?></select> - 
<select name="tahun" style="width:100px;"><option value="">-Tahun-</option><?php for($a=2013;$a<=date("Y")+1;$a++){?><option value="<?php echo $a;?>" <?php if($a==date("Y")) echo "Selected";?>><?php echo $a;?></option><?php }?></select></td></tr>