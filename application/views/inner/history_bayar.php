<table style="width:100%;">
<tr>
<td>No</td>
<td>Angsuran Ke</td>
<td>Rekening</td>
<td>Jumlah Pembayaran</td>
<td>Waktu Pembayaran</td>
</tr>
<?php
$a=1;
 foreach($pay as $paid){
	?>
<tr>
<td><?php echo $a;?></td>
<td><?php echo $paid['angsuran_ke'];?></td>
<td><?php echo $paid['rekening'];?></td>
<td><?php echo $paid['kredit'];?></td>
<td><?php echo $paid['tanggal'];?></td>
</tr>
<?php
$a++;
 } ?>
</table>