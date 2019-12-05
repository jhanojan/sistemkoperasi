
<body>
<form id="form_edit" method="post" action="<?php echo site_url($document['aksi_print']);?>" name="detailreport" target="_blank">
<table style="width:100%; border:0px solid black;">
<tr id="head"><td colspan="3"><?php echo $document['title_document']?></td></tr>
<input type="hidden" name="category" value="<?php echo $document['aksi_print']?>">
<input type="hidden" name="idcategory" value="<?php echo $document['id']?>">
<?php 
if($document['attrib']!=NULL){
$input=explode(',',$document['attrib']);
for($a=0;$a<count($input);$a++){
	$this->load->view('report/category/'.$input[$a]);
	}};?>
<tr><td colspan="3"><input class="btn" type="submit" name="print" value="Print Preview" style="margin-left:0px;"></td></tr>
</table>
</form>
</body>