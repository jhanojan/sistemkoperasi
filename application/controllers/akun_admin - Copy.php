<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class akun_admin extends CI_Controller 
{	
	var $filename = "akun_admin";
	var $tabel = "tb_user";
	var $id_primary = "id";
	var $title = "List Akun Pengguna";
	
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
		
		$data['grid'] = array("No","Username", "Password", "Salt","Email","Jabatan","Jumlah Login"," Terakhir Masuk","Terakhir Keluar","Status");
		$data['query_all'] = GetAll($this->tabel,$filter);
		$filter['limit'] = $pg."/".$per_page;
		$data['query_list'] = GetAll($this->tabel,$filter);
		$data['list'] = array("no","username","password","salt","email","jabatan","jml_login","terakhir_masuk","terakhir_keluar","status");
			
		//Page
		$pagination = Page($data['query_all']->num_rows(),$per_page,$pg,$path_paging,$uri_segment);
		if(!$pagination) $pagination = "<strong>1</strong>";
		$data['pagination'] = $pagination;
		
		$this->load->view('template',$data);
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
		
		$data['opt_grup'] = GetOptAll('admin_grup','-Jabatan-');
		
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
		$data['edit_tgl'] = date("Y-m-d H:i:s");
		//print_mz($data);
		if($id > 0)
		{
			$data['edit_oleh'] = $webmaster_id;
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			
			$data['password'] = md5($data['salt'].$data['password']);
			$data['masuk_oleh'] = $webmaster_id;
			$data['masuk_tgl'] = $data['modify_date'];
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
		//$this->general_lib->_flash_message("Anda Telah Menghapus ".$jml." Record",$this->filename);
		redirect($this->main());
		else
		echo 'salah';
		
	}
	function change_password($id,$msg='')
	{
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		//$data['path_file'] = $this->filename.'_form';
		//$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		$data['iduser']=$id;
		$data['main_content'] = 'ganti_password';
		$msg="";
		if($this->uri->segment(4) == "err")
		{
			$data['dis_error'] = "display:''";
			if($this->uri->segment(5) == 1) $msg = "Password Lama Tidak Valid";
			else $msg = "Ganti Password Berhasil";
		}
		else $data['dis_error'] = "display:none;";
		$data['msg'] = $msg;
		$this->load->view('template',$data);
	}
	
	function cek_password()
	{
		$webmaster_id = $this->input->post('id_user');
		$salt_pass=GetValue('salt','user',array('id'=>'where/'.$webmaster_id));
		$old_pass = md5($salt_pass.$this->input->post("old_password"));
		$cek_old_pass = GetValue("password","user", array("id"=> "where/".$webmaster_id));
		//$cek_old_pass2 = GetValue("userpass","employee", array("id"=> "where/".substr($webmaster_id,1)));
		if($old_pass == $cek_old_pass)
		{
			$new_pass = md5($salt_pass.$this->input->post("new_password"));
			$data = array("password"=> $new_pass);
			$this->db->where("id", $webmaster_id);
			$this->db->update("user", $data);
			redirect('akun_admin/change_password/'.$webmaster_id.'/err/2');
		}
		/*else if($old_pass == $cek_old_pass2)
		{
			$new_pass = md5($this->config->item('encryption_key').$this->input->post("new_password"));
			$data = array("userpass"=> $new_pass);
			$this->db->where("id", substr($webmaster_id,1));
			$this->db->update("employee", $data);
			redirect('akun_admin/change_password/err/2');
		}*/
		else redirect('akun_admin/change_password/'.$webmaster_id.'/err/1');
	}
}

?>