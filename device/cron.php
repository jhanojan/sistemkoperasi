<?php
$jam=$_GET['jam'];
$tgl=$_GET['tanggal'] ? $_GET['tanggal'] : date("d");
$bln=$_GET['bulan'] ? $_GET['bulan'] : date("m");
$thn=$_GET['tahun'] ? $_GET['tahun'] : date("Y");
//$yy="http://localhost/dus/load/baca_absen_cron/".$tgl."/".$bln."/".$thn."/".$jam;
header("location:http://localhost/dus/load/baca_absen_cron/".$tgl."/".$bln."/".$thn."/".$jam);
?>