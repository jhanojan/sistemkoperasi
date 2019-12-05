<script language="JavaScript" src="<?php echo base_url();?>assets/js/FusionCharts.js"></script>
<?php
if(cekIpad()) 
{
	?>
	<script>
	FusionCharts.setCurrentRenderer('javascript');
	</script>
	<?php
}
?>
<form id="search" action="<?php echo site_url('dashboard');?>" method="post" style="margin-bottom:5px;">
<table style="width:60%;border:0px;margin:auto;">
  <tr id="head">
    <td style="text-align:center;">
    	Tanggal <input id="set_date" name="set_date" class="span3" value="<?php echo isset($tgl) ? $tgl : ""?>">&nbsp;&nbsp;&nbsp;
	 	  Grup <?php echo form_dropdown("id_department",$opt_department, isset($val['id_department']) ? $val['id_department']:"","class='span5' style='height:22px;'");?>&nbsp;&nbsp;&nbsp;
	 		&nbsp;&nbsp;&nbsp;
	 	  Shift <?php echo form_dropdown("shift",array(''=>'-Shift-','06:00-09:00'=>'Pagi','13:00-16:00'=>'Siang','21:00-23:59'=>'Malam'), isset($val['shift']) ? $val['shift']:"","class='span5' style='height:22px;'");?>&nbsp;&nbsp;&nbsp;
	 		<input type="submit" value="Cari" name="cari">
	 	</td>
  </tr>
</table>
</form>
<table id="dashboard">
	<tr>
		<td colspan="2" style="padding-left:0px;">
			<table class="box">
				<tr class="head_title">
					<td>
						<div class="left" style="margin-top:3px;font-size:16px;margin-right:8px;"><b>KEHADIRAN HARIAN</b></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:4px 0px;">
						<div id="chart_attend5" align="center"></div>
						<script type="text/javascript">
						   var chart = new FusionCharts("<?php echo base_url();?>assets/grafik/Column3D.swf", "ChartId", "100%", "462", "0", "0");
						   chart.setDataURL("<?php echo site_url('dashboard/grafik_attendance/'.$param.'/'.$tgl_param.'/'.$shift);?>");
						   chart.render("chart_attend5");
						</script>
					</td>
				</tr>
			</table>
		</td>
		<tr>
		<td width="50%" style="padding-left:0px;">
			<table class="box">
			<tr class="head_title">
				<td colspan="2">
					<div class="left" style="margin-top:3px;font-size:16px;margin-right:8px;"><b>OVERTIME</b></div>
				</td>
			</tr>
			<tr>
				<td width="25%">
					<div id="chart_attend2" align="center"></div>
					<script type="text/javascript">
					   var chart = new FusionCharts("<?php echo base_url();?>assets/grafik/Column3D.swf", "ChartId", "200", "395", "0", "0");
					   chart.setDataURL("<?php echo site_url('dashboard/grafik_overtime/'.$param.'/'.$tgl_param.'/'.$shift);?>");
					   chart.render("chart_attend2");
					</script>
				</td>
				<td width="75%">
					<div style="overflow:auto;height:350px;width:100%;margin-top:30px;">
					<table class="bordered-table zebra-striped gridz">
						<tr>
							<th>NIK</th>
							<th>Nama</th>
							<th>Department</th>
						</tr>
						<?php
						$exp = explode("/", $tgl_param);
						$filter=array();
						if($param) $filter["id_department"] = "where/".$param;
						if($shift){
						$shift=explode('-',$shift);
						$filter['scan_masuk']='wherebetween/'.$shift[0].','.$shift[1];
						}
						$filter['lembur'] = "where/1";
						$filter["tanggal"] = "where/".$exp[0];
						$filter["bulan"] = "where/".$exp[1];
						$filter["tahun"] = "where/".$exp[2];
						$q = GetAll("view_kehadiran", $filter);
						//lastq();
						foreach($q->result_array() as $r)
						{
							echo "<tr>";
							echo "<td>".$r['nik']."</td>";
							echo "<td>".$r['name']."</td>";
							echo "<td>".$r['department']."</td>";
							echo "</tr>";
						}
						?>
					</table>
					</div>
				</td>
			</tr>	
		</table>
		</td>
		<td width="50%" style="padding-left:0px;">
			<table class="box">
			<tr class="head_title">
				<td colspan="2">
					<div class="left" style="margin-top:3px;font-size:16px;margin-right:8px;"><b>BASIC WORKING HOUR</b></div>
				</td>
			</tr>
			<tr>
				<td width="75%">
					<div style="overflow:auto;height:400px;width:100%;">
					<table class="bordered-table zebra-striped gridz">
						<tr>
							<th>NIK</th>
							<th>Nama</th>
							<th>Department</th>
							<th>Hour</th>
						</tr>
						<?php
						$exp = explode("/", $tgl_param);
						$filter=array();
						if($param) $filter["id_department"] = "where/".$param;
						if($shift){
						$filter['scan_masuk']='wherebetween/'.$shift[0].','.$shift[1];
						}
						$filter["tanggal"] = "where/".$exp[0];
						$filter["bulan"] = "where/".$exp[1];
						$filter["tahun"] = "where/".$exp[2];
						$filter["name"] = "order/asc";
						$q = GetAll("view_kehadiran", $filter);
						foreach($q->result_array() as $r)
						{
							if($r['nik'] != "-")
							{
								echo "<tr>";
								echo "<td>".$r['nik']."</td>";
								echo "<td>".$r['name']."</td>";
								echo "<td>".$r['department']."</td>";
								$in = str_replace(" ","",$r['scan_masuk']);
								$out = str_replace(" ","",$r['scan_pulang']);
								if($out && $in)
								{
									$hour = floor((strtotime($r['scan_pulang']) - strtotime($r['scan_masuk'])) / 3600);
									if($hour < 0)
									{
										$hour = 24 + $hour;
										$minute = ceil((((strtotime($r['scan_pulang']) + 86400) - strtotime($r['scan_masuk'])) - (3600 * $hour) ) / 60);
									}
									else $minute = ceil(((strtotime($r['scan_pulang']) - strtotime($r['scan_masuk'])) - (3600 * $hour) ) / 60);
									$hour = strlen($hour) == 1 ? "0".$hour : $hour;
									$minute = strlen($minute) == 1 ? "0".$minute : $minute;
									echo "<td>".$hour." jam ".$minute." menit</td>";
								}
								else echo "<td>08 jam 00 menit</td>";
								echo "</tr>";
							}
						}
						?>
					</table>
					</div>
				</td>
			</tr>	
		</table>
		</td>
	</tr>
	</tr>
</table>
<script src="<?php echo base_url();?>assets/js/ui.datepicker.js" type="text/javascript"></script>
<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/smoothness/jquery-ui-1.7.1.custom.css"  />
<script>
$(function() {
	$('#set_date').datepicker({
		dateFormat: 'yy-mm-dd', 
		changeMonth: true,
		changeYear: true,
		//minDate: -30, 
		//maxDate: "+0D"
	});
});
</script>
<style>
.gridz th, .gridz td{font-size:14px;padding:8px;}
</style>