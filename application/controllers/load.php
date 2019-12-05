<?php
class load extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function delete_image()
	{
		$id = $this->input->post('del_id_img');
		$table = $this->input->post('del_table');
		$field = $this->input->post('del_field');
		
		$GetFile = GetValue($field,$table, array("id"=> "where/".$id));
		$GetThumb = GetThumb($GetFile);
		if($table != "admin")
		{
			if(file_exists("./".$this->config->item('path_upload')."/".$GetFile)) unlink("./".$this->config->item('path_upload')."/".$GetFile);
			if(file_exists("./".$this->config->item('path_upload')."/".$GetThumb)) unlink("./".$this->config->item('path_upload')."/".$GetThumb);
		}
		else
		{
			if(file_exists("./".$this->config->item('path_upload')."/foto/".$GetFile)) unlink("./".$this->config->item('path_upload')."/foto/".$GetFile);
			if(file_exists("./".$this->config->item('path_upload')."/foto/".$GetThumb)) unlink("./".$this->config->item('path_upload')."/foto/".$GetThumb);
		}
		
		$data[$field] = "";
		$this->db->where("id", $id);
		$this->db->update($table, $data);
	}
	
	function employee()
	{
		$q = GetAll("employee");
		foreach($q->result_array() as $r)
		{
			$id_dep = $r['id_department']."000";
			$data = array("id_department"=> $id_dep);
			$this->db->where("id", $r['id']);
			$this->db->update("employee", $data);
		}
	}
	
	function baca_absen($tglz, $blnz, $thnz, $shift)
	{
		
		for($k=$shift;$k<=3;$k++)
		{
			$filez = './uploads/tgl '.$tglz.' shift '.$k.'.dbf';
			$dbf = dbase_open($filez, 0);
			$column_info = dbase_get_header_info($dbf);
			$loop = dbase_numrecords($dbf);
			for($i=1;$i<=$loop;$i++)
			{
				$row = dbase_get_record_with_names($dbf,$i);
				$nik = $row['FCCARDNO'];
				$nik = substr($nik,0,1)."-".substr($nik,1,4)."-".substr($nik,5,3);
				$date = $row['FDDATE'];
				$tgl = substr($date,6,2);
				$bln = substr($date,4,2);
				$thn = substr($date,0,4);
				$masuk = $row['FCFIRSTIN'];
				$keluar = $row['FCLASTOUT'];
				if($thn."-".$bln."-".$tgl == $thnz."-".$blnz."-".$tglz)
				{
					$id_employee = GetValue("id", "employee", array("nik"=> "where/".$nik));
					if($id_employee)
					{
						$cek_hadir = GetValue("id", "kehadirandetil", array("id_employee"=> "where/".$id_employee, "tanggal"=> "where/".$tgl, "bulan"=> "where/".$bln, "tahun"=> "where/".$thn));
						if(!$cek_hadir && ($masuk || $keluar))
						{
							$data = array("id_employee"=> $id_employee, "jhk"=> 1, "jh"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
							"scan_masuk"=> $masuk, "scan_pulang"=> $keluar);
							$this->db->insert("kehadirandetil", $data);
						}
					}
				}
			}
			
			if($k == 3)
			{
				$masuk=$keluar="";
				$sql = "select * from kg_employee where id not in (select id_employee from kg_kehadirandetil where tanggal='$tglz' and bulan='$blnz' and tahun='$thnz')";
				$q = $this->db->query($sql);
				foreach($q->result_array() as $r)
				{
					$data = array("id_employee"=> $r['id'], "jhk"=> 1, "alpa"=> 1, "tanggal"=> $tglz, "bulan"=> $blnz, "tahun"=> $thnz,
						"scan_masuk"=> $masuk, "scan_pulang"=> $keluar);
					$this->db->insert("kehadirandetil", $data);
				}
			}
		}
		
		die();	
	}
	
	function baca_absen_cron($jam=10, $tglz=NULL, $blnz=NULL, $thnz=NULL)
	{
		if(!$tglz) $tglz = date("d");
		if(!$blnz) $blnz = date("m");
		if(!$thnz) $thnz = date("Y");
		
		if($jam==10)
		{
			$cek_log = GetValue("id", "log_cron", array("date"=> "where/".$thnz."-".$blnz."-".$tglz, "jam"=> "where/2"));
			$cek_log_skrg = GetValue("id", "log_cron", array("date"=> "where/".$thnz."-".$blnz."-".$tglz, "jam"=> "where/10"));
		}
		else
		{
			$log_kemarin = explode("-", date("Y-m-d", mktime(0, 0, 0, $blnz, $tglz-1, $thnz)));
			$cek_log = GetValue("id", "log_cron", array("date"=> "where/".$log_kemarin[0]."-".$log_kemarin[1]."-".$log_kemarin[2], "jam"=> "where/10"));
			$cek_log_skrg = GetValue("id", "log_cron", array("date"=> "where/".$thnz."-".$blnz."-".$tglz, "jam"=> "where/2"));
		}
		
		if(!$cek_log_skrg && $cek_log)
		{
			$create_date=date("Y-m-d H:i:s");
			$filez = file_get_contents('http://127.0.0.1/dus/device/db.php?tahun='.$thnz.'&bulan='.$blnz.'&tanggal='.$tglz.'&jam='.$jam);
			$absen = explode("<br>", $filez);
			$absen = array_filter($absen);
			//print_mz($absen);
			foreach($absen as $r)
			{
				$exp = explode(";", $r);
				$nik = $exp[0];
				$nik = substr($nik,0,1)."-".substr($nik,1,4)."-".substr($nik,5,3);
				$date = $exp[1];
				$tgl = substr($date,6,2);
				$bln = substr($date,4,2);
				$thn = substr($date,0,4);
				$date_kemarin = explode("-", date("Y-m-d", mktime(0, 0, 0, $bln, $tgl-1, $thn)));
				$masuk = $exp[2];
				$keluar = $exp[3];
				//die(strtotime($masuk)."/".strtotime($keluar));
				$id_employee = GetValue("id", "employee", array("nik"=> "where/".$nik));
				if($id_employee)
				{
					$cek_hadir = GetValue("id", "kehadirandetil", array("id_employee"=> "where/".$id_employee, "tanggal"=> "where/".$tgl, "bulan"=> "where/".$bln, "tahun"=> "where/".$thn));
					if(!$cek_hadir && ($masuk || $keluar))
					{
						if((strtotime($keluar) - strtotime($masuk)) <= 300)
						{
							$keluar="";
							$cek_shift3 = GetAll("kehadirandetil", array("id_employee"=> "where/".$id_employee, "tanggal"=> "where/".$date_kemarin[2], "bulan"=> "where/".$date_kemarin[1], "tahun"=> "where/".$date_kemarin[0], "scan_pulang"=> "where/", "scan_masuk !="=> "where/"));
							
							if($cek_shift3->num_rows() > 0)
							{
								$shift3 = $cek_shift3->result_array();
								//Apabila shift3 dan tidak absen saat pulang jam 7, absen lg jam 23
								if(substr($masuk,0,2) > 12 || substr($masuk,0,2) < 2 || substr($shift3[0]['scan_masuk'],0,2) < 12)
								{
									$data = array("id_employee"=> $id_employee, "jhk"=> 1, "jh"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
									"scan_masuk"=> $keluar, "scan_pulang"=> "", "create_date"=> $create_date);
									$this->db->insert("kehadirandetil", $data);
								}
								else
								{
									$data = array("scan_pulang"=> $masuk, "modify_date"=> $create_date);
									$this->db->where("id", $shift3[0]['id']);
									$this->db->update("kehadirandetil", $data);
								}
							}
							else
							{
								$cek_jam=substr($masuk,0,2);
								$telat=0;
								$id_dept = GetValue("id_department", "employee", array("id"=> "where/".$id_employee));
								//if($id_dept == 2)
								//{
									if($cek_jam >= 8 && $cek_jam <= 10) $telat=1;
									else if($cek_jam >= 15 && $cek_jam <= 17) $telat=1;
									else if($cek_jam >= 23 || ($cek_jam >= 0 && $cek_jam <= 2)) $telat=1;
								//}
								$data = array("id_employee"=> $id_employee, "jhk"=> 1, "jh"=> 1, "terlambat"=> $telat, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
								"scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "create_date"=> $create_date);
								$this->db->insert("kehadirandetil", $data);
							}
						}
						else
						{
							if(substr($masuk,0,2) < 10)
							{
								$data = array("id_employee"=> $id_employee, "jhk"=> 1, "jh"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
								"scan_masuk"=> $keluar, "scan_pulang"=> "", "create_date"=> $create_date);
								$this->db->insert("kehadirandetil", $data);
							}
							else
							{
								$data = array("id_employee"=> $id_employee, "jhk"=> 1, "jh"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
								"scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "create_date"=> $create_date);
								$this->db->insert("kehadirandetil", $data);
							}
						}				
					}
					else
					{
						if((strtotime($keluar) - strtotime($masuk)) <= 300)
						{
							$cek_shift2 = GetValue("id", "kehadirandetil", array("id_employee"=> "where/".$id_employee, "tanggal"=> "where/".$tgl, "bulan"=> "where/".$bln, "tahun"=> "where/".$thn, "scan_pulang"=> "where/", "scan_masuk !="=> "where/"));
							//lastq();
							if($cek_shift2)
							{
								$data = array("scan_pulang"=> $masuk, "modify_date"=> $create_date);
								$this->db->where("id", $cek_shift2);
								$this->db->update("kehadirandetil", $data);
							}
							else
							{
								$data = array("scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "modify_date"=> $create_date);
								$this->db->where("id", $cek_hadir);
								$this->db->update("kehadirandetil", $data);
							}
						}
						else
						{
							$data = array("scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "modify_date"=> $create_date);
							$this->db->where("id", $cek_hadir);
							$this->db->update("kehadirandetil", $data);
						}
					}
				}
			}
			
			//Jam 
			if($jam==2)
			{
				$masuk=$keluar="";
				$sql = "select * from kg_employee where id not in (select id_employee from kg_kehadirandetil where tanggal='$tgl' and bulan='$bln' and tahun='$thn')";
				$q = $this->db->query($sql);
				foreach($q->result_array() as $r)
				{
					//cek hari sabtu & minggu
					$weekend = date("w", strtotime($thn."-".$bln."-".$tgl));
					//cek holiday
					$holiday = GetValue("id", "holiday", array("tgl_penuh"=> "where/".$thn."-".$bln."-".$tgl));
					//cek jadwal off
					$cek_jadwal = GetValue("tgl_".intval($tgl), "jadwal_shift", array("id_employee"=> "where/".$r['id'], "bulan"=> "where/".$bln, "tahun"=> "where/".$thn));
					if((!$cek_jadwal || $cek_jadwal != "off") && $weekend != 0 && !$holiday)
					{
						$data = array("id_employee"=> $r['id'], "jhk"=> 1, "alpa"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
							"scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "create_date"=> $create_date);
						$this->db->insert("kehadirandetil", $data);
					}
					else
					{
						$data = array("id_employee"=> $r['id'], "jhk"=> 1, "off"=> 1, "tanggal"=> $tgl, "bulan"=> $bln, "tahun"=> $thn,
							"scan_masuk"=> $masuk, "scan_pulang"=> $keluar, "create_date"=> $create_date);
						$this->db->insert("kehadirandetil", $data);
					}
				}
			}
			
			//Insert Log
			$data = array("date"=> $thnz."-".$blnz."-".$tglz, "jam"=> $jam, "create_date"=> $create_date);
			$this->db->insert("log_cron", $data);
		}
		else die("cron gagal, cron ini sudah pernah dijalankan atau cron sebelumnya belum dijalankan");
	}
	
	function gaji()
	{
		$q = GetJoin("gaji_bu", "employee", "gaji_bu.nik=employee.nik", "inner", "employee.id, employee.nik");
		foreach($q->result_array() as $r)
		{
			$data=array("id_employee"=> $r['id']);
			$this->db->where("nik", $r['nik']);
			$this->db->update("gaji_bu", $data);
		}
	}
	
	function absen_bulan()
	{
		$dt = strtotime("2014-01-03");
		$jam = array("", "2", "10");
		for($i=$dt;$i<=strtotime("2014-02-08");$i+=86400)
		{
			for($j=1;$j<=2;$j++)
			{
				$tgl = date("d", $i);
				$bln = date("m", $i);
				$thn = date("Y", $i);
				
				$this->baca_absen_cron($jam[$j], $tgl, $bln, $thn);
			}
		}
	}
	function tipes($data){
		$tipe[0]=GetValue("tipe","tb_tipe_simpan_pinjam",array('id'=>'where/'.$data));
		$tipe[1]=GetValue("nama","tb_tipe_simpan_pinjam",array('id'=>'where/'.$data));
		echo json_encode($tipe);
	}
	function cekkaryawan(){
	
	/* RECEIVE VALUE */
	if(isset($_REQUEST['fieldValue']) && isset($_REQUEST['fieldId'])){
	$validateValue=$_REQUEST['fieldValue'];
	$validateId=$_REQUEST['fieldId'];}
	else{
	$validateValue=$_GET['fieldValue'];
	$validateId=$_GET['fieldId'];	
	}

	$validateError= "ID Karyawan Tidak Ditemukan";
	$validateSuccess= "ID Karyawan Ditemukan";

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$query="SELECT * FROM tb_simpan_pinjam WHERE id_karyawan='$validateValue' AND status='b'";
	$statuslunas=$this->db->query($query)->num_rows();
	if($statuslunas>0){
		$n="SELECT pinjamlagi FROM tb_karyawan WHERE (kode_karyawan='$validateValue' OR nik='$validateValue')";
		$sq=$this->db->query($n)->row_array();
		$pinjamlagi=$sq['pinjamlagi'];
		if($pinjamlagi=='n')
		$arrayToJs[3]='disabled';
		else
		$arrayToJs[3]='exception';
		}
	else if($statuslunas==0){$arrayToJs[3]='enabled';}
	
	$cekq="SELECT id FROM tb_karyawan WHERE (kode_karyawan='$validateValue' OR nik='$validateValue')";
	$cek=$this->db->query($cekq)->num_rows();
	if($cek>0){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
	}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
	}	
	}
	
	function cekpinjaman(){
	
	/* RECEIVE VALUE */
	if(isset($_REQUEST['fieldValue']) && isset($_REQUEST['fieldId'])){
	$validateValue=$_REQUEST['fieldValue'];
	$validateId=$_REQUEST['fieldId'];}
	else{
	$validateValue=$_GET['fieldValue'];
	$validateId=$_GET['fieldId'];	
	}


	$validateError= "ID Pembayaran Tidak Ditemukan";
	$validateSuccess= "ID Pembayaran Ditemukan";



	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$cek=$this->db->select('id')->from('tb_simpan_pinjam')->where('id_simpan_pinjam',$validateValue)->get()->num_rows();
	if($cek>0){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
	}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
	}	
	}
	
	function cekbarang(){
	
	/* RECEIVE VALUE */
	if(isset($_REQUEST['fieldValue']) && isset($_REQUEST['fieldId'])){
	$validateValue=$_REQUEST['fieldValue'];
	$validateId=$_REQUEST['fieldId'];}
	else{
	$validateValue=$_GET['fieldValue'];
	$validateId=$_GET['fieldId'];	
	}


	$validateError= "ID Pembayaran Tidak Ditemukan";
	$validateSuccess= "ID Pembayaran Ditemukan";



	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$q=$this->db->select('id,jumlah,min_qty')->from('tb_inventory')->where(array('kode_barang'=>$validateValue,'status'=>'y'))->get();
	$cek=$q->num_rows();
	$barangnya=$q->row_array();
	//lastq();
	
	
	
	if($cek>0){		// validate??
	
	if($barangnya['jumlah']==0){$arrayToJs[2]='habis';
	$arrayToJs[1] = false;}
	
	elseif($barangnya['jumlah']<=$barangnya['min_qty']){$arrayToJs[2]='minimum';
	$arrayToJs[1] = true;}
	
	else{$arrayToJs[2]='banyak';
	$arrayToJs[1] = true;}
				// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
	}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
	}	
	}
	
	function muatkaryawan($id){
		$qbio="SELECT * FROM tb_karyawan WHERE (kode_karyawan='$id' OR nik='$id')";
		$data['bio']=$this->db->query($qbio)->row_array();
		$this->load->view('inner/bio',$data);	
	}
	
	function muatrincian($id){
		$q="SELECT * FROM tb_simpan_pinjam_detail WHERE id_simpan_pinjam='$id' AND (kredit !=NULL OR kredit!=0)";
		$data['pay']=$this->db->query($q)->num_rows();
		$data['rincian']=$this->db->select('*')->from('tb_simpan_pinjam')->where('id_simpan_pinjam',$id)->get()->row_array();
		$this->load->view('inner/rincian_bayar',$data);	
	}
	
	function muatrincian_pinjaman($id){
		
		$q="SELECT * FROM tb_simpan_pinjam_detail WHERE id_simpan_pinjam='$id' AND (kredit !=NULL OR kredit!=0)";
		$data['pay']=$this->db->query($q)->num_rows();
		$data['rincian']=$this->db->select('*')->from('tb_simpan_pinjam')->where('id_simpan_pinjam',$id)->get()->row_array();
		if($this->session->userdata('webmaster_grup')==2){
			$nik=GetValue('nik','tb_karyawan',array('id'=>'where/'.$this->session->userdata('webmaster_id')));
			$idkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$this->session->userdata('webmaster_id')));
			if($data['rincian']['id_karyawan']!=$nik && $data['rincian']['id_karyawan']!=$idkar){
			echo "Anda Tidak Berhak Melihat Rincian Ini";	
			}
			else{
			$this->load->view('inner/rincian_pinjaman',$data);		
			}
		}
		else{
		$this->load->view('inner/rincian_pinjaman',$data);	
		}
	}
	function muatriwayatbayar($id){
		$q="SELECT * FROM tb_simpan_pinjam_detail WHERE id_simpan_pinjam='$id' AND (kredit !=NULL OR kredit!=0)";
		$data['pay']=$this->db->query($q)->result_array();
		$data['rincian']=$this->db->select('*')->from('tb_simpan_pinjam')->where('id_simpan_pinjam',$id)->get()->row_array();
		if($this->session->userdata('webmaster_grup')==2){
			$nik=GetValue('nik','tb_karyawan',array('id'=>'where/'.$this->session->userdata('webmaster_id')));
			$idkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$this->session->userdata('webmaster_id')));
			if($data['rincian']['id_karyawan']!=$nik && $data['rincian']['id_karyawan']!=$idkar){
			echo "";	
			}
			else{
			$this->load->view('inner/history_bayar',$data);		
			}
		}
		else{
		$this->load->view('inner/history_bayar',$data);	
		}
	}
	function muatbarang($id,$a){
		$q="SELECT * FROM tb_inventory WHERE kode_barang='$id' AND status='y'";
		$data=$this->db->query($q)->row_array();
		$h="SELECT * FROM tb_inventory_harga WHERE kode_barang='$id' ORDER BY id DESC limit 1";
		if($this->db->query($h)->num_rows()>0){
		$price=$this->db->query($h)->row_array();}
		else{
		$price['harga_jual']=0;
		$price['harga_beli']=0;}
		//lastq();
		//$this->load->view('inner/history_bayar',$data);	
		echo "
		<tr data-id=$a>
		<td><input type='text' value='".$data['kode_barang']."' name='kode_barang[]' readonly></td>
		<td><input type='text' value='1' name='qty[]' id='qty-$a' class='qty' qty-s='$a'></td>
		<td><input type='text' value='".$data['nama']."' name='nama[]' readonly></td>
		<td><input type='text' value='".$price['harga_jual']."' name='harga_dasar[]' readonly id='harga_dasar-$a' harga_dasar-s='$a'></td><input type='hidden' value='".$price['harga_beli']."' name='harga_beli[]' id='harga_beli-$a' harga_beli-s='$a'></td>
		<td><input type='text' value='".$price['harga_jual']."' name='total_price[]' readonly id='total_price_$a' total_price-s='$a'></td>
		</tr>
		";
	}
	function muatbarang_beli($id,$a){
		$q="SELECT * FROM tb_inventory WHERE kode_barang='$id' AND status='y'";
		$data=$this->db->query($q)->row_array();
		$h="SELECT * FROM tb_inventory_harga WHERE kode_barang='$id' ORDER BY tanggal DESC limit 1";
		if($this->db->query($h)->num_rows()>0){
		$price=$this->db->query($h)->row_array();}
		else{
		$price['harga_jual']=0;
		$price['harga_beli']=0;}
		//lastq();
		//$this->load->view('inner/history_bayar',$data);	
		echo "
		<tr data-id=$a>
		<td><input type='text' value='".$data['kode_barang']."' name='kode_barang[]' readonly></td>
		<td><input type='text' value='1' name='qty[]' id='qty-$a' class='qty' qty-s='$a'></td>
		<td><input type='text' value='".$data['nama']."' name='nama[]' readonly></td>
		<td><input type='text' value='".$price['harga_jual']."' name='harga_dasar[]' id='harga_dasar-$a' harga_dasar-s='$a'><input type='hidden' value='".$price['harga_beli']."' name='harga_beli[]' id='harga_beli-$a' harga_beli-s='$a'></td>
		<td><input type='text' value='".$price['harga_jual']."' name='total_price[]' readonly id='total_price_$a' total_price-s='$a'></td>
		</tr>
		";
	}
	function suggestbarang(){

/*
note:
this is just a static test version using a hard-coded countries array.
normally you would be populating the array out of a database

the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/
	$load=$this->db->select('*')->from('tb_inventory')->get()->result_array();
	$aUsers = array();
	$aInfo = array();
	foreach($load as $brg){
		$aUsers[]=$brg['kode_barang'];
		$aInfo[]=$brg['nama'].','.$brg['keterangan'];
	}
	
	
	
	
	$input = strtolower( $_GET['input'] );
	$len = strlen($input);
	
	
	$aResults = array();
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($aUsers[$i]),0,$len)) == $input)
				$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aUsers[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
			
			//if (stripos(utf8_decode($aUsers[$i]), $input) !== false)
			//	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aUsers[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
		}
	}
	
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($aResults);$i++)
		{
			echo "<rs id=\"".$aResults[$i]['id']."\" info=\"".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
		}
		echo "</results>";
	}
		
	}
}
?>