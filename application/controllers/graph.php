<?php
class Graph extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function produk_terlaku(){
		$q="SELECT SUM(jumlah) as jumlah,kode_barang FROM tb_penjualan_detail GROUP BY kode_barang ORDER BY jumlah DESC LIMIT 10";
		$data['isi']=$this->db->query($q)->result_array();
		$this->load->view('graph/produk_terlaku',$data);
	}
	
	function belanja_terbanyak(){
		$q="SELECT SUM(total) as jumlah,id_karyawan FROM tb_penjualan WHERE id_karyawan!='' GROUP BY id_karyawan ORDER BY jumlah DESC LIMIT 10";
		$data['isi']=$this->db->query($q)->result_array();
		$this->load->view('graph/belanja_terbanyak',$data);
	}
	
	function stok_tersedikit(){
		$q="SELECT * FROM tb_inventory ORDER BY jumlah ASC limit 100";
		$data['isi']=$this->db->query($q)->result_array();
		$this->load->view('graph/stok_tersedikit',$data);
	}
	
	function laba(){
		$data['p'][0]=date('Y-m');
		$data['p'][1]=date('Y-m',strtotime('-1 months'));
		$data['p'][2]=date('Y-m',strtotime('-2 months'));
		$q="SELECT SUM(laba) as laba,kode_barang,tanggal FROM tb_penjualan_detail LEFT JOIN tb_penjualan ON tb_penjualan.id_penjualan=tb_penjualan_detail.id_penjualan GROUP BY YEAR(tanggal),MONTH(tanggal) ";
		$data['isi']=$this->db->query($q)->result_array();
		$this->load->view('graph/laba',$data);	
	}
}
?>