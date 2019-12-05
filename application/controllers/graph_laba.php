<?php
class Graph_laba extends CI_Controller {

	var $filename = "graph_laba";
	var $tabel = "tb_penjualan_detail";
	var $id_primary = "id_penjualan";
	var $title = "Grafik Laba Penjualan";
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
	$this->view();	
	}
	function view(){
		
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename.'_form';
		$data['main_content'] = 'report/graph/laba';
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
	if(!$this->input->post('period')){$period=date('Y-m');}
	else{$period=$this->input->post('period');}
	$data['period']=$period;
	$data['fulldate']=tanggalpenuh($period);
	$this->load->view('template',$data);	
	}
}
?>