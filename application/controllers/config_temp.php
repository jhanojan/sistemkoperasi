<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class config_temp extends CI_Controller 
{	
	var $filename = "config_temp";
	var $tabel = "kg_config_temp";
	var $id_primary = "id";
	var $title = "List Konfigurasi Parameter";
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main(){
		//Set Global
		//permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
		$path_paging = base_url().$this->filename."/main";
		$uri_segment = 3;
		$pg = $this->uri->segment($uri_segment);
		$per_page=15;
		
		$filter = array();
		$cari = $this->input->post('cari_s');
		if($cari){
			$filter['name'] = "like/".$cari;
			$data['cari'] = $cari;
		}else{
			$data['cari'] = '';
		}
		
		$data['grid'] = array("No","Tj Transport", "Tj Kehadiran", "Pt Kehadiran","Tanggal");
		$data['query_all'] = GetAll($this->tabel,$filter);
		$filter['limit'] = $pg."/".$per_page;
		$data['query_list'] = GetAll($this->tabel,$filter);
		$data['list'] = array("no","tj_transport","tj_kehadiran","pt_kehadiran","date");
			
		//Page
		$pagination = Page($data['query_all']->num_rows(),$per_page,$pg,$path_paging,$uri_segment);
		if(!$pagination) $pagination = "<strong>1</strong>";
		$data['pagination'] = $pagination;
		
		$this->load->view('template',$data);
	}
	
	function upload(){
		//permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = 'upload_izin';
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
		$this->load->view("template",$data);
	}
	
	function do_upload(){
		$nama_upload = "userfile";
		$config['upload_path'] = 'uploads/file/izin/';
		$config['allowed_types'] = 'xls|xlsx';
		
		$upload = do_upload($config,$nama_upload,'izin');
		if($upload){
			foreach($upload as $r){
				$file =  $r['file_name'];
			}
			$this->load->library('PHPExcel');
			$exl = PHPExcel_IOFactory::load("uploads/file/izin/".$file);
			$highRow = $exl->getActiveSheet()->getHighestRow();
			$this->db->truncate('kg_cuti_platfon');
			
			for($i=5;$i<$highRow;$i++){
				//$id = $exl->getActiveSheet()->getCell('A'.$i)->getCalculatedValue().'</td>';
				$nama_karyawan = $exl->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$id_karyawan = GetValue('id','admin',array('fullname'=>'like/'.$nama_karyawan));
				$hak_cuti = $exl->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$sisa_cuti_sebelumnya = $exl->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$sisa_cuti_saat_ini = $exl->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				
				$query = "insert into kg_cuti_platfon(karyawan,nama,hak_cuti,sisa_cuti_sebelumnya,sisa_cuti_saat_ini)
				values('$id_karyawan','$nama_karyawan','$hak_cuti','$sisa_cuti_sebelumnya','$sisa_cuti_saat_ini')
				";
				$this->db->query($query);
				//$this->general_lib->_flash_message("File Upload Anda Tidak Sesuai","hris/".$this->filename);
				//echo $nama_karyawan.'-'.$id_karyawan.'<br>';
			}
			$this->general_lib->_flash_message("Anda Telah Mengupload File Cuti",$this->filename);
		}else{
			$this->general_lib->_flash_message("Anda Gagal Mengupload File Cuti",$this->filename);
		}
	}
	
	function edit($karyawan){
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename.'_edit';
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
		$path_paging = base_url().$this->filename."/main";
		$uri_segment = 4;
		$pg = $this->uri->segment($uri_segment);
		$per_page=15;
		
		$filter = array();
		$filter['karyawan'] = "where/".$karyawan;
		$data['karyawan'] = $karyawan;
		
		$data['grid'] = array("No","Nama Karyawan","Hak Cuti","Sisa Cuti Sebelumnya","Sisa Cuti Saat Ini");
		//$data['query_all'] = GetJoin("cuti_platfon","admin","cuti_platfon.karyawan = admin.id","inner","cuti_platfon.*",$filter);
		$data['query_all'] = GetAll("cuti_platfon",$filter);
		$filter['limit'] = $pg."/".$per_page;
		//$data['query_list'] = GetJoin("cuti_platfon","admin","cuti_platfon.karyawan = admin.id","inner","cuti_platfon.*",$filter);
		$data['query_list'] = GetAll("cuti_platfon",$filter);
		$data['list'] = array("no","karyawan","hak_cuti","sisa_cuti_sebelumnya","sisa_cuti_saat_ini");
			
		//Page
		$pagination = Page($data['query_all']->num_rows(),$per_page,$pg,$path_paging,$uri_segment);
		if(!$pagination) $pagination = "<strong>1</strong>";
		$data['pagination'] = $pagination;
		
		$this->load->view('template',$data);
	}
	
	function detail($id=null){
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename.'_form';
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
		$data['opt_pic'] = GetOptPIC();
		
		if($id>0){
			$filter['id'] = "where/".$id;
			$res = GetAll($this->tabel,$filter);
			$r = $res->result_array();
			
			$data['val'] = $r[0];
			$data['id'] = $id;
		}else{
			$data['id'] = 0;
		}
		
		$this->load->view("template",$data);
	}
	
	function update()
	{
		$webmaster_id = permission();
		$id = $this->input->post('id');
		$GetColumns = GetColumns($this->tabel);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}
		//$data['modify_date'] = date("Y-m-d H:i:s");
		
		//print_mz($data);
		if($id > 0 && $this->input->post('date')==date("Y-m-d"))
		{
			//$data['modify_user_id'] = $webmaster_id;
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$insert1=array('title'=>'tj_transport','value'=>$data['tj_transport']);
			$this->db->insert('kg_config', $insert1);
			$insert2=array('title'=>'tj_kehadiran','value'=>$data['tj_kehadiran']);
			$this->db->insert('kg_config', $insert2);
			$insert3=array('title'=>'pt_kehadiran','value'=>$data['pt_kehadiran']);
			$this->db->insert('kg_config', $insert3);
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			/*$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");*/
			
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$insert1=array('title'=>'tj_transport','value'=>$data['tj_transport']);
			$this->db->insert('kg_config', $insert1);
			$insert2=array('title'=>'tj_kehadiran','value'=>$data['tj_kehadiran']);
			$this->db->insert('kg_config', $insert2);
			$insert3=array('title'=>'pt_kehadiran','value'=>$data['pt_kehadiran']);
			$this->db->insert('kg_config', $insert3);
			if(isset($data['id'])) unset($data['id']);
			$data['date']=date("Y-m-d");
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		redirect($this->filename."/main");
	}
	
	function delete(){
		$del_id = $this->input->post("del_id");
		$jml = count($del_id);
		$this->db->where_in("id",$del_id);
		$del = $this->db->delete($this->tabel);
		if($del) 
		$this->general_lib->_flash_message("Anda Telah Menghapus ".$jml." Record",$this->filename);
		else
		echo 'sala';
		
	}
	
	function apply()
	{
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['main_content'] = 'cuti_apply_form';
		$data['path_file'] = $this->filename;
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		//End Global
		$data['val'] = array();
		$data['opt_pengganti'] = GetOptPIC();
		$data['opt_pengganti'][''] = "- Karyawan Pengganti -";
		$data['opt_jenis_cuti'] = GetOptJenisCuti();
		$data['opt_atasan'] = GetOptAtasan();
		$this->load->view('template',$data);
	}
	
	function apply_submit()
	{
		$webmaster_id = permission();
		//$id = $this->input->post($this->id_primary);
		$GetColumns = GetColumns($this->tabel);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}
		$data['modify_date'] = date("Y-m-d H:i:s");
		
		$data['create_user_id'] = $webmaster_id;
		$data['create_date'] = $data['modify_date'];
		
		$this->db->insert($this->tabel, $data);
		$id = $this->db->insert_id();
		$link="<a href='".site_url('hris/cuti/approval/'.$webmaster_id.'/'.$id)."'>Approval</a>";

		$msg = "Nama : ".$this->session->userdata("admin")."<br>";
		$msg .= "Jenis Cuti : ".GetValue("title","jenis_cuti", array("id"=> "where/".$data['id_jenis_cuti']))."<br>";
		$msg .= "Tanggal Permohonan : ".$data['tgl_permohonan']."<br>";
		$msg .= "Tanggal Cuti : ".$data['tgl_cuti']."<br>";
		$msg .= "Hari : ".$data['hari']."<br>";
		$msg .= "Karyawan Pengganti : ".GetValue("fullname","admin", array("id"=> "where/".$data['pengganti']))."<br>";
		$msg .= "No. Telepon Selama Cuti : ".$data['telp_cuti']."<br><br>";
		$msg .= "Klik link berikut untuk memberikan persetujuan ".$link;
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		$email = GetValue("email_address","admin",array("id"=> "where/".$webmaster_id));
		//$email_atasan = GetValue("email","admin",array("id"=> "where/".$data['id_atasan']));
		$email = "cuti@dwirekasolusi.com";
		$this->email->from($email, $this->session->userdata("admin"));
		$this->email->to('mazh@datamazhters.com');
		
		$this->email->subject('Pengajuan Cuti');
		$this->email->message($msg);	

		$this->email->send();
			
		$this->session->set_flashdata("message", "Apply ".$this->title." ".lang('msg_sukses'));
		
		redirect($this->filename.'/apply');
	}
}

?>