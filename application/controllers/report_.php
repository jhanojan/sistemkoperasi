<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  - Programmed : Nov 2013
  - Programmer : Fauzan Rabbani
  - Email      : jhanojan@komunigrafik.com
  - Webpage    : http://www.jhanojan.com
  - CMS ver    : CI ver.2.0
*/

class report extends CI_Controller {
	
	var $title = "Report";
	var $filename = "report";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_getdata');
		$this->load->model('model_query_report');
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		permission();
		$data = GetHeaderFooter();
		$q=$this->model_getdata->get_judul();
		$data['main_content'] = 'report/menu/menu';
		
		$data['title'] = $this->title;
		$data['filename'] = $this->filename;
		$data['tipedokumen']= $q->result();
		$this->load->view('template',$data);
		
		
	}
	
	function response_cat($id=null){
		error_reporting(0);
		$id=htmlentities(mysql_real_escape_string($id));
		if($id!=''){
		
		$qdep=$this->model_getdata->get_department();
		$data['listdep']=$qdep->result();
		$data['bulan']=$this->model_getdata->namabulan();
		$data['document']=$this->model_getdata->getdoc($id);
		
		if(mysql_num_rows(mysql_query("SELECT * FROM kg_dokumen WHERE id='$id'"))>0){
		$this->load->view('report/category/main',$data);
		}
		else{
			echo "Dokumen Tidak Ditemukan";
		}
		}
	}
	function print_prev($cat,$dep,$period){
		$query=$this->model_getdata->get;
		$data['cat']=$cat;
		$data['dep']=$dep;
		$data['period']=$period;
		$data['result']=$query->result();
		$this->load->view('report/layout/template.php',$data);
		
		}
		
	function masterlist(){
	
	$dep=$this->input->post('seldep');
	$periode=tanggalpenuh($this->input->post('tahun').'-'.$this->input->post('bulan'));
	
	$query=$this->model_query_report->masterlist($dep,$periode);
	
	if($dep!='_all'){
	$depname=$this->model_getdata->get_department_name($dep);
	}
	else{
	$depname=array('title'=>'All Department');
	}
	$data['content']='masterlist';
		$data['dep']=$depname['title'];
		$data['period']=strtoupper(getBulan($this->input->post('bulan'))).'-'.$this->input->post('tahun');
		$data['result']=$query;
	$this->load->view('report/layout/template.php',$data);
		
	}
	
	function listemployee($param){
	$periode=tanggalpenuh($this->input->post('tahun').'-'.$this->input->post('bulan'));
	
	$query=$this->model_query_report->sortnik($periode);
	
	$data['content']='listemployee';
		$data['period']=strtoupper(getBulan($this->input->post('bulan'))).'-'.$this->input->post('tahun');
		$data['parameter']=$param;
		$data['result']=$query;
	$this->load->view('report/layout/template.php',$data);
		
	}
	
	function summary($param)
	{
		$periode=tanggalpenuh($this->input->post('tahun').'-'.$this->input->post('bulan'));
	$params='summary_'.$param;
	$query=$this->model_query_report->$params($periode);
	
	$data['content']='summary';
		$data['period']=strtoupper(getBulan($this->input->post('bulan'))).'-'.$this->input->post('tahun');
		$data['parameter']=$param;
		$data['department']=$this->model_getdata->get_department()->result();
		$data['result']=$query;
	$this->load->view('report/layout/template.php',$data);
		}
	
	function daftar_absensi()
	{
		$id_dep = $this->input->post("seldep");
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$data['judul'] = "DAFTAR ABSENSI KARYAWAN";
		$data['content'] = 'daftar_absensi';
		$data['dep'] = GetValue("title", "department", array("id"=> "where/".$id_dep));
		$data['period'] = GetTanggalIndo($start_date)." - ".GetTanggalIndo($end_date);
		//$data['list'] = GetAll("view_kehadiran", array("id_department"=> "where/".$id_dep, "date_full >="=> "where/".$start_date, "date_full <="=> "where/".$end_date));
		$sql = "select *, sum(jh) as hadir, sum(off) as off, sum(sakit) as sakit, sum(ijin) as ijin, sum(cuti) as cuti, sum(alpa) as alpa,
		sum(potong_gaji) as potong_gaji from kg_view_kehadiran where id_department='".$id_dep."' AND date_full >= '".$start_date."' AND date_full <= '".$end_date."' 
		group by id_employee order by id_employee";
		$data['list'] = $this->db->query($sql);
		$this->load->view('report/layout/template.php',$data);
	}
}
?>