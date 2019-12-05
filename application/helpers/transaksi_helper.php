<?php
function cari_kas($tipe){
return $kas=GetValue('kas','tb_config_kas',array('item'=>'where/'.$tipe));
}

function kredit_kas($tipe,$idtrans,$value,$kas){
	$CI =& get_instance();
	
	$adding="UPDATE tb_kas SET value=value+'$value' WHERE id='$kas'";
	$CI->db->query($adding);
	
	$trans=array(
	'tipe_transaksi'=>$tipe,
	'id_transaksi'=>$idtrans,
	'kas'=>$kas,
	'kredit'=>$value,
	'tgl'=>date("Y-m-d H:i:s")
	);
	$CI->db->insert('tb_transaksi_kas',$trans);
	
	return TRUE;
	
}

function debit_kas($tipe,$idtrans,$value,$kas){
	$CI =& get_instance();
	
	$duit=GetValue('value','tb_kas',array('id'=>'where/'.$kas));
	if($duit<$value){
		return FALSE;
		}
	else{
	$adding="UPDATE tb_kas SET value=value-'$value' WHERE id='$kas'";
	$CI->db->query($adding);
	
	$trans=array(
	'tipe_transaksi'=>$tipe,
	'id_transaksi'=>$idtrans,
	'kas'=>$kas,
	'debit'=>$value,
	'tgl'=>date("Y-m-d H:i:s")
	);
	$CI->db->insert('tb_transaksi_kas',$trans);
	
	return TRUE;
	}
}
function GetHarga($brg,$period){
	$CI =& get_instance();
	$q="SELECT * FROM tb_inventory_harga WHERE kode_barang='$brg' AND tanggal <='$period' ORDER BY tanggal DESC LIMIT 1";
	$hsil=$CI->db->query($q)->row_array();
	if($CI->db->query($q)->num_rows()==0){$hsil['harga_jual']=0;}
	return $hsil['harga_jual'];
}
function GetFisik($brg,$period){
	$CI =& get_instance();
	$q="SELECT * FROM tb_inventory_jumlah WHERE kode_barang='$brg' AND tgl <='$period' ORDER BY tgl DESC LIMIT 1";
	$hsil=$CI->db->query($q)->row_array();
	if($CI->db->query($q)->num_rows()==0){$hsil['jumlah']='';$hsil['nol']=TRUE;}
	return $hsil;
}
function GetHargaBeli($brg,$period){
	$CI =& get_instance();
	$q="SELECT * FROM tb_inventory_harga WHERE kode_barang='$brg' AND tanggal <='$period' ORDER BY tanggal DESC LIMIT 1";
	$hsil=$CI->db->query($q)->row_array();
	if($CI->db->query($q)->num_rows()==0){$hsil['harga_beli']=0;}
	return $hsil['harga_beli'];
}
function GetTerjual($brg,$start,$end){
	$CI =& get_instance();
	$q="SELECT SUM(tb_penjualan_detail.jumlah) as jumlah FROM tb_penjualan_detail LEFT JOIN tb_penjualan ON tb_penjualan.id_penjualan=tb_penjualan_detail.id_penjualan WHERE tb_penjualan_detail.kode_barang='$brg' AND (tb_penjualan.tanggal >='$start 00:00:00' AND tb_penjualan.tanggal <='$end 23:59:59') ";
	
		$karyawan=$CI->input->post('karyawan');
		$kasir=$CI->input->post('kasir');
		$jenis=$CI->input->post('jenisbayar');
	if(!empty($kasir)){
			$kasir=implode("','",$kasir);
			$q.="AND kasir IN ('$kasir') ";
			} 
		if(!empty($karyawan)){
			$i=0;
			foreach($karyawan as $isikas){
			$karyawan[$i]=GetValue('nik','tb_karyawan',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$karyawan=implode("','",$karyawan);
			$q.="AND id_karyawan IN ('$karyawan') ";
			}
		if(!empty($jenis)){
			$jenis=implode("','",$jenis);
			$q.="AND tipe_pembayaran IN ('$jenis') ";
			}	
	$hsil=$CI->db->query($q)->row_array();
	
	//lastq();
	if($CI->db->query($q)->num_rows()==0){$hsil['jumlah']=0;}
	return $hsil['jumlah'];
}
function GetSummaryPenjualan($idpenjualan){
	$CI =& get_instance();
	$q="SELECT SUM(jumlah*beli) as beli,SUM(total) AS total,SUM(laba) AS laba FROM tb_penjualan_detail WHERE id_penjualan='$idpenjualan'";
	$hsil=$CI->db->query($q)->row_array();
	if($CI->db->query($q)->num_rows()==0){$hsil=array('beli'=>0,'total'=>0,'laba'=>0);}
	return $hsil;
}
function GetLabaBulan($period){
	$CI =& get_instance();
	$q="SELECT SUM(laba) as laba FROM tb_penjualan_detail LEFT JOIN tb_penjualan ON tb_penjualan.id_penjualan=tb_penjualan_detail.id_penjualan WHERE SUBSTR(tanggal,1,7) ='$period' GROUP BY YEAR(tanggal),MONTH(tanggal) ";
	$exec=$CI->db->query($q);
	if($exec->num_rows==0){
	$hsil['laba']=0;
	}
	else{
	$hsil=$exec->row_array();}
	return $hsil['laba'];
}
function GetLabaHarian($period){
	$CI =& get_instance();
	$q="SELECT SUM(laba) as laba FROM tb_penjualan_detail LEFT JOIN tb_penjualan ON tb_penjualan.id_penjualan=tb_penjualan_detail.id_penjualan WHERE SUBSTR(tanggal,1,10)='$period' GROUP BY YEAR(tanggal),MONTH(tanggal),DATE(tanggal) ";
	$exec=$CI->db->query($q);
	//lastq();
	if($exec->num_rows==0){
	$hsil['laba']=0;
	}
	else{
	$hsil=$exec->row_array();}
	return $hsil['laba'];
}
function GetPinjamanHarian($period){
	$CI =& get_instance();
	$q="SELECT SUM(total_debit) as laba FROM tb_simpan_pinjam WHERE SUBSTR(waktu,1,10)='$period' GROUP BY YEAR(waktu),MONTH(waktu),DATE(waktu) ";
	$exec=$CI->db->query($q);
	//lastq();
	if($exec->num_rows==0){
	$hsil['laba']=0;
	}
	else{
	$hsil=$exec->row_array();}
	return $hsil['laba'];
}
function GetPenjualanHarian($period){
	$CI =& get_instance();
	$q="SELECT SUM(total) as laba FROM tb_penjualan WHERE SUBSTR(tanggal,1,10)='$period' GROUP BY YEAR(tanggal),MONTH(tanggal),DATE(tanggal) ";
	$exec=$CI->db->query($q);
	//lastq();
	if($exec->num_rows==0){
	$hsil['laba']=0;
	}
	else{
	$hsil=$exec->row_array();}
	return $hsil['laba'];
}