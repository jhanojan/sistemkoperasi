 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil_karyawan extends CI_Controller 
{	
	var $filename = "profil_karyawan";
	var $tabel = "tb_karyawan";
	var $id_primary = "id";
	var $title = "List Karyawan";
	
	function __construct()
	{
		parent::__construct();
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
	}
	
	function index()
	{
		$this->detail();
	}

	
	function detail(){
		permission();
		$data = GetHeaderFooter();
		$id=$this->session->userdata('webmaster_id');
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
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
		//print_mz($_FILES);
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
		
		if($_FILES['photo']['tmp_name']!=NULL){
			$pp=$this->changePP($id,$this->input->post());
			if($pp['status']==TRUE){
			$data['images']=$pp['fn'];
			}
		//die("ada foto");
		}
		
		$data['edit_tgl'] = date("Y-m-d H:i:s");
		//print_mz($data);
		if($id > 0)
		{
			if(isset($data['images'])){
			unlink('./'.GetValue('images','tb_karyawan',array('id'=>'where/'.$id)));}
			$data['edit_oleh'] = $webmaster_id;
			$bln=substr($this->input->post('tgl_lahir'),5,2);
			$bln_cur=substr(GetValue('tgl_lahir','tb_karyawan',array('id'=>'where/'.$id)),5,2);
			if($bln!=$bln_cur){
				$kodkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$id));
				$rek_cur=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$kodkar));
			$this->db->where('kode_karyawan', $kodkar);
			$this->db->update('tb_karyawan_rekening', array('rekening'=>substr($rek_cur,0,2).$bln.substr($rek_cur,4)));
			}
			
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			$kodkop=$this->input->post('kodkop');
			$jml_kar=GetValue('jml_kar','tb_kode_koperasi',array('kode'=>'where/'.$kodkop));
			$data['kode_karyawan']=$kodkop.substr(100000+1+$jml_kar,1);	
			$data['masuk_oleh'] = $webmaster_id;
			$data['masuk_tgl'] = $data['edit_tgl'];
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			
			$rek=array('kode_karyawan'=>$data['kode_karyawan'],
						'rekening'=>$kodkop.substr($data['tgl_lahir'],5,2).substr(100000+1+$jml_kar,1),
						'tanggal'=>date("Y-m-d"));
			$this->db->insert('tb_karyawan_rekening',$rek);
			
			$this->db->where('kode',$kodkop);
			$this->db->update('tb_kode_koperasi',array('jml_kar'=>$jml_kar+1));
			
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		redirect($this->filename."/main");
	}
	}

?>