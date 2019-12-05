<?php
$jam=2;
$tgl=$_GET['tanggal'] ? $_GET['tanggal'] : date("d");
$bln=$_GET['bulan'] ? $_GET['bulan'] : date("m");
$thn=$_GET['tahun'] ? $_GET['tahun'] : date("Y");
//$yy="http://localhost/dus/load/baca_absen_cron/".$tgl."/".$bln."/".$thn."/".$jam;
header("location:http://localhost/dus/load/baca_absen_cron/".$tgl."/".$bln."/".$thn."/".$jam);

 //awal dumping
$username = "root"; 
$password = ""; 
$hostname = "localhost"; 
$dbname   = "dus";
 
$dumpfname = $dbname . "_" . date("Y-m-d_H-i-s").".sql";
$command = "C:\\xampp\\mysql\\bin\\mysqldump -u root ";
if ($password) 
        $command.= "--password=". $password ." "; 
$command.= $dbname;
$command.= " > " . $dumpfname;
system($command);
 //akhir dumping
 
 /*hapus ini klo mau outputnya jadi zip
// masukin file dumping ke zip
$zipfname = $dbname . "_" . date("Y-m-d_H-i-s").".zip";
$zip = new ZipArchive();
if($zip->open($zipfname,ZIPARCHIVE::CREATE)) 
{
   $zip->addFile($dumpfname,$dumpfname);
   $zip->close();
}
 
// baca file zip jadi standard output browser
if (file_exists($zipfname)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zipfname));
    flush();
    readfile($zipfname);
    exit;
}*/
?>