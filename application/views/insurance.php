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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/ui.dropdownchecklist.themeroller.css">

<!-- Include the basic JQuery support (core and ui) -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.8.13.custom.min.js"></script>

<!-- Include the DropDownCheckList supoprt -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ui.dropdownchecklist-1.4-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	//$("#spic").dropdownchecklist({emptyText: " - Karyawan -", maxDropHeight: 240, width: 180});
    	//$("#sdep").dropdownchecklist({emptyText: " - Department -", maxDropHeight: 240, width: 180});
    });
</script>
<form id="search" action="<?php echo site_url($path_file.'/search');?>" method="post">
<!--<table style="width:400px;">
  <h3>Pencarian</h3>
  <tr id="head">
    <td>Department</td>
    <td></td>
  </tr>
  <tr>
  	<td>
		<?php 
      //echo form_dropdown("dep[]", $opt_dep, $dep, "id='sdep' multiple='multiple' class='span5'");
		?>
		</td>
		<td><input type="submit" value="Cari" class="btn"/></td>
  </tr>
</table>-->
</form>

<form method="post" action="<?php echo site_url($path_file.'/main/');?>" id="<?php echo $filename;?>">
  <div style="float:left;">
  	<h3><?php echo $title;?></h3>
	</div>
	<div class="clear"></div>
	<table class="bordered-table zebra-striped gridz">
    <tr>
    	<input type="hidden" id="temp_id" value="">
    	<th class="box_delete">
    		<input type="checkbox" onclick="checkedAll('<?php echo $filename;?>', true)" id="primary_check" value="" name="">
    	</th>
    	<?php
    	foreach($grid as $r)
    	{
    		echo "<th>".$r."</th>";
    	}
    	?>
    	<th class='action'>Action</th>
    </tr>
    <?php
    foreach($query_list->result_array() as $r)
    {
    	echo "<tr id='listz-".$r['id']."'>";
    	echo "<td class='box_delete'><input type='checkbox' class='delete' id='del".$r['id']."' value='".$r['id']."'></td>";
    	foreach($list as $s)
    	{
			if($s=="nama") { 
				$r[$s]= GetValue("name","employee", array("id"=> "where/".$r[$s]));
			}
			else if($s=="tanggal") {
				$tgl = Explode("-", $r['tanggal']);
				$r[$s] = $tgl[2]."-".GetMonth(2)."-".$tgl[0];
			}
    		else if($s=="position") {
				$r[$s] = GetValue("title", "position", array("id"=> "where/".GetValue("id_position", "employee", array("name"=> "where/".$r['nama']))));
			}
			else if($s=="departemen") {
				$r[$s] = GetValue("title", "department", array("id"=> "where/".GetValue("id_department", "employee", array("name"=> "where/".$r['nama']))));}
			else if($s=="value") {
				$r[$s] = Rupiah($r['value']);
			}
    		echo "<td>".$r[$s]."</td>";
    	}
    	echo "<td class='action'>";
    	hak_edit1($this->session->userdata('webmaster_grup'),$filename,1,$r['id']);
    	echo "</tr>";
    }
    ?>
	</table>
	<br><br>
  <div class="clear"></div>
  <div class="pagination">
  	<ul>
    	<li class="prev disabled"><a><?php echo lang('page');?></a></li>
      <?php echo $pagination;?>
    </ul>
  </div>
	<div class="tombol">
		<input type="button" value="<?php echo lang("delete");?>" alt="<?php echo lang("delete");?>" title="<?php echo lang("delete");?>" class="delete_button btn" disabled/>
		<input type="button" value="<?php echo lang("add");?>" alt="<?php echo lang("add");?>" title="<?php echo lang("add");?>" class="btn" onClick="javascript:window.location='<?php echo base_url().$path_file;?>/detail/0';"/>
	</div>
	<div id="id_temp" value=""></div>
</form>

<script src="<?php echo base_url();?>assets/js/bootstrap/bootstrap-modal.js"></script>
<script>
$(document).ready(function(){
	$(".export_all").click(function(){
		var idz = $(this).attr("rel");
		$("#framez").attr("src", "<?php echo site_url('personal/export_param/"+idz+"');?>");
	});
});
</script>
<div id="modal-export" class="modal hide fade" style="width:670px;left:45%;">
  <div class="modal-header">
    <a href="#" class="close">&times;</a>
    <h3 class="popup">Export Data Karyawan</h3>
  </div>
  <div class="modal-body">
    <iframe id="framez" frameborder="0" scrolling="auto" width="650" height="350" 
    	src="<?php echo site_url('personal');?>"></iframe>
  </div>
</div>
<div id="modal-password" class="modal hide fade" style="width:670px;left:45%;">
  <div class="modal-header">
    <a href="#" class="close">&times;</a>
    <h3 class="popup">Ganti Password</h3>
  </div>
  <div class="modal-body">
    <iframe id="framez-password" frameborder="0" scrolling="no" width="650" height="350" 
    	src="<?php echo site_url('login/change_password');?>"></iframe>
  </div>
</div>