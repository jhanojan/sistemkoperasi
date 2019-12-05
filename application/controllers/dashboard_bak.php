<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/	

class dashboard extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Migrasi 1 Feb 14
		/*$q=GetAll("kehadirandetil", array("scan_pulang >"=> "where/21:00:00", "scan_masuk <"=> "where/09:00:00"));
		foreach($q->result_array() as $r)
		{
			$data = array("scan_masuk"=> $r['scan_pulang'], "scan_pulang"=> "");
			$this->db->where("id",$r['id']);
			$this->db->update("kehadirandetil", $data);
		}
		die();*/
		
		//Hilangkan spasi
		/*$q = GetAll("employee");
		foreach($q->result_array() as $r)
		{
			$name = $r['name'];
			if(substr($name,0,1) == " ")
			{
				$name = substr($name,1);
				$data = array("name"=> $name);
				$this->db->where("id",$r['id']);
				$this->db->update("employee", $data);
			}
		}*/
		
		/*$q = GetAll("kehadirandetil");
		foreach($q->result_array() as $r)
		{
			$masuk = substr($r['scan_masuk'],0,2);
			if($masuk >= 7 && $masuk <= 9) $telat=1;
			else if($masuk >= 15 && $masuk <= 17) $telat=1;
			else if($masuk >= 23) $telat=1;
			else $telat=0;
			
			if($telat)
			{
				$data = array("terlambat"=> 1);
				$this->db->where("id",$r['id']);
				$this->db->update("kehadirandetil", $data);
			}
		}
		die();
		*/
		/*$q = GetAll("admin_auth", array("id_admin_grup"=> "where/1"));
		foreach($q->result_array() as $r)
		{
			unset($r['id']);
			$r['id_admin_grup'] = 6;
			$data = $r;
			$this->db->insert("admin_auth", $data);
		}*/
		/*
		foreach($q->result_array() as $r)
		{
			unset($r['id']);
			$r['id_admin_grup'] = 3;
			$data = $r;
			$this->db->insert("admin_auth", $data);
		}
		die();*/
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['main_content'] = 'dashboard';
		//End Global
		
		//Attendance
		$grup = $this->input->post('id_department');
		if($grup){
			$data['val']['id_department'] = $data['param'] = $grup;
		}else{
			$data['val']['id_department'] = "";
			$data['param'] = 0;
		}
		
		$shift = $this->input->post('shift');
		if($shift){
			$data['val']['shift'] = $data['shift'] = $shift;
		}else{
			$data['val']['shift'] = "";
			$data['shift'] = 0;
		}
		
		$tgl = $this->input->post("set_date");
		$exp = explode("-", $tgl);
		$q = GetAll("kehadirandetil", array("tahun"=> "order/desc", "bulan"=> "order/desc", "tanggal"=> "order/desc", "limit"=> "0/1"));
		$r = $q->result_array();
		if(isset($exp[2])) $data['tgl'] = $tgl;
		else if($tgl)
		{
			$exp = explode(" ", $tgl);
			$data['tgl'] = $exp[2]."-".GetMonthIndex($exp[1])."-".$exp[0];
		}
		else $data['tgl'] = $r[0]['tahun']."-".$r[0]['bulan']."-".$r[0]['tanggal']; //date("Y-m-d");
		
		$data['tgl_param'] = date("d/m/Y", strtotime($data['tgl']));
		$data['opt_department'] = GetOptDepartment();
		$this->load->view('template',$data);
	}
	
	function grafik_attendance($param=0,$tanggal=1,$bulan=11,$tahun=2013,$shift=0)
	{
		$fontsize=14;
		if($param)
		$sql = "select count(*) as jumlah from kg_employee where is_active='Active' AND id_department='".$param."' AND id not in (select id_employee from kg_kehadirandetil where tanggal='".$tanggal."' AND bulan='".$bulan."' AND tahun='".$tahun."' AND id_department='".$param."')";
		else
		$sql = "select count(*) as jumlah from kg_employee where is_active='Active' AND id not in (select id_employee from kg_kehadirandetil where tanggal='".$tanggal."' AND bulan='".$bulan."' AND tahun='".$tahun."')";
		$q = $this->db->query($sql);
		$r = $q->result_array();
		$ga_terdaftar = 0;//$r[0]['jumlah'];
		
		$warna = array("","109D00","2390FB","D400AF","FF9900","FF0000","FFFF00","000000");
		//Hadir
		$select = "SUM(jh) as jh, SUM(terlambat) as terlambat, SUM(sakit) as sakit, SUM(cuti) as cuti, SUM(ijin) as ijin, SUM(alpa) as alpa, SUM(off) as off";
		$this->db->select($select);
		$this->db->where("tanggal", $tanggal);
		$this->db->where("bulan", $bulan);
		$this->db->where("tahun", $tahun);
		if($param) $this->db->where("id_department", $param);
		else $param=0;
		if($shift){
			$shift=explode('-',$shift);
			$this->db->where("scan_masuk >=",$shift[0]);
			$this->db->where("scan_masuk <=",$shift[1]);}
		else{$shift=0;}
		$q = $this->db->get("view_kehadiran");
		//lastq();
		foreach($q->result_array() as $r)
		{
			$terlambat = $r['terlambat'] ? $r['terlambat'] : 0;
			$hadir = $r['jh'] ? $r['jh'] : 0;
			$hadir -= $terlambat;
			$ijin = $r['ijin'] ? $r['ijin'] : 0;
			$sakit = $r['sakit'] ? $r['sakit'] : 0;
			$cuti = $r['cuti'] ? $r['cuti'] : 0;
			$alpa = $r['alpa'] ? $r['alpa'] : 0;
			$off = $r['off'] ? $r['off'] : 0;
		}
		$alpa += $ga_terdaftar;
		$total = $hadir + $terlambat + $sakit + $ijin + $cuti + $alpa;
		
		
		$chart = "<Chart 
baseFontSize='".$fontsize."' 
xAxisName='' 
yAxisName='JUMLAH' 
//yAxisMaxValue='".$total."'
decimals='2' 
formatNumberScale='0'
numberSuffix='' 
numDivLines='6' 
bgColor='FFFFFF,FFFFFF' 
bgAlpha='100,100' 
bgRatio='0,100' 
bgAngle='90' 
showBorder='0'
canvasBgColor='FFFFFF,FFFFFF' 
canvasBorderColor='999999' 
canvasBorderThickness='1' 
canvasBorderAlpha='80' 
showCanvasBg='1' 
>
		<set label='Hadir' color='".$warna[1]."' value='".$hadir."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/jh')."'/>
		<set label='Terlambat' color='".$warna[6]."' value='".$terlambat."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/terlambat')."'/>
		<set label='Cuti' color='".$warna[2]."' value='".$cuti."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/cuti')."'/>
		<set label='Sakit' color='".$warna[3]."' value='".$sakit."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/sakit')."'/>
		<set label='Ijin' color='".$warna[4]."' value='".$ijin."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/ijin')."'/>
		<set label='Alpa' color='".$warna[5]."' value='".($alpa)."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/alpa')."'/>
		<set label='Off' color='".$warna[7]."' value='".($off)."' link='".site_url('kehadirandetil/main/0/'.$tahun.'-'.$bulan.'-'.$tanggal.'/'.$param.'/off')."'/>
		";
		$chart .= "</Chart>";
		echo $chart;
	}
	
	function grafik_overtime($param=1,$tanggal=2,$bulan=11,$tahun=2012,$shift=0)
	{
		$tabel = "kg_view_kehadiran";
		$select = "SUM(lembur) as overtime";
		$this->db->select($select);
		$this->db->where("tanggal", $tanggal);
		$this->db->where("bulan", $bulan);
		$this->db->where("tahun", $tahun);
		if($param)
		{
			$this->db->where("id_department", $param);
		}
		if($shift){
			$shift=explode('-',$shift);
			$this->db->where("scan_masuk >=",$shift[0]);
			$this->db->where("scan_masuk <=",$shift[1]);}
		else{$shift=0;}
		$q = $this->db->get($tabel);
		$overtime=0;
		foreach($q->result_array() as $r)
		{
			$overtime = $r['overtime'];
		}
		
		$fontsize="15";
		
		$chart = "<Chart 
baseFontSize='".$fontsize."' 
xAxisName='' 
yAxisName='JUMLAH' 
yAxisValue='0'
decimals='2' 
formatNumberScale='0'
numberSuffix='' 
numDivLines='6' 
bgColor='FFFFFF,FFFFFF' 
bgAlpha='100,100' 
bgRatio='0,100' 
bgAngle='90' 
showBorder='0'
showYAxisValues='0'
canvasBgColor='EEF4FA,EEF4FA' 
canvasBorderColor='999999' 
canvasBorderThickness='1' 
canvasBorderAlpha='80' 
showCanvasBg='0' 
labelDisplay='Stagger'
>
		<set label='Overtime' color='30A299' value='".$overtime."'/>
		";
		$chart .= "</Chart>";
		echo $chart;
	}
}
?>