<?php
//$dbName = "C:\Program Files (x86)\Smart2K-Bio Utility 1.11\smartweb.mdb";
$dbName = "D:\\xampp\htdocs\dus\device\smartweb.mdb";
if (!file_exists($dbName)) {
    die("Could not find database file.");
}

$jam=$_GET['jam'];
$tanggal=intval($_GET['tanggal']);
$bulan=intval($_GET['bulan']);
$tahun=intval($_GET['tahun']);
$kemarin = explode("-", date("Y-m-d", mktime(0, 0, 0, $bulan, $tanggal-1, $tahun)));
$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=PRIMINTI;");
if($jam==10)
{
	/*$query = "select * from tActivities a where (YEAR(ftTime)='".$tahun."' AND 
	MONTH(ftTime)='".intval($_GET['bulan'])."' AND DAY(ftTime)='".intval($_GET['tanggal'])."' AND HOUR(ftTime) >= 2 AND HOUR(ftTime) <= 10 order by a.fsCardNo,ftTime";*/
	$query = "select * from tActivities a where ftTime between #".$tahun."-".$bulan."-".$tanggal." 02:00:01# AND #".$tahun."-".$bulan."-".$tanggal." 10:00:00# order by a.fsCardNo,ftTime";
	$date=$_GET['tahun'].$_GET['bulan'].$_GET['tanggal'];
}
else if($jam==2)
{
	/*$query = "select * from tActivities a where YEAR(ftTime)='".$_GET['tahun']."' AND 
	MONTH(ftTime)='".intval($_GET['bulan'])."' AND DAY(ftTime)='".intval($_GET['tanggal'])."' AND HOUR(ftTime) >= 2 AND HOUR(ftTime) <= 10 order by a.fsCardNo,ftTime";*/
	$query = "select * from tActivities a where ftTime between #".$kemarin[0]."-".$kemarin[1]."-".$kemarin[2]." 10:00:01# AND #".$tahun."-".$bulan."-".$tanggal." 02:00:00# order by a.fsCardNo,ftTime";
	$date = date("Ymd", mktime(0, 0, 0, $bulan, $tanggal-1, $tahun));
}
//MONTH(ftTime)='".intval($_GET['bulan'])."' AND DAY(ftTime)='".intval($_GET['tanggal'])."' order by a.fsCardNo,ftTime";
//die($query."S");
$sth = $db->prepare($query);
$sth->execute();
$results = $sth->fetchALL(PDO::FETCH_ASSOC);
/*echo "<pre>";
print_r($results);
echo "</pre>";*/
$temp=$temp_key="";$absen=array();

foreach($results as $key=> $r)
{
	$cardno=$r['fsCardNo'];
	$time = substr($r['ftTime'],11);
	if($temp != $cardno)
	{
		if($temp) $absen[$temp_key]['FCFIRSTOUT'] = substr($results[$key-1]['ftTime'],11);
		$absen[$key]['FCCARDNO'] = $cardno;
		$absen[$key]['FDDATE'] = $date;
		$absen[$key]['FCFIRSTIN'] = $time;
		$temp = $cardno;
		$temp_key=$key;
	}
}
if($key) $absen[$temp_key]['FCFIRSTOUT'] = $time;
/*echo "<pre>";
print_r($absen);
echo "</pre>";*/

$data="";
foreach($absen as $r)
{
	$data .= $r['FCCARDNO'].";".$r['FDDATE'].";".$r['FCFIRSTIN'].";".$r['FCFIRSTOUT']."<br>";
}
die($data);

?>