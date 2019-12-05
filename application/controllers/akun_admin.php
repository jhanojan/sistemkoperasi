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
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
	}
	
	function index()
	{
		$this->main();
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
	
	function main(){
		
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		$data['js_grid']=$this->get_column();
		$data['filename']=$this->filename;
		
		$this->load->view('template',$data);
	}
	
	function get_column(){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['username'] = array('Username',100,TRUE,'left',2);
            $colModel['password'] = array('Password',200,TRUE,'left',2);
            $colModel['salt'] = array('SALT',200,TRUE,'left',2);
            $colModel['email'] = array('E-Mail',200,TRUE,'left',2);
            $colModel['jabatan'] = array('Jabatan',50,TRUE,'left',2);
            $colModel['jml_login'] = array('Jumlah Login',70,TRUE,'left',2);
            $colModel['terakhir_masuk'] = array('Terakhir Masuk',120,TRUE,'left',2);
            $colModel['terkahir_keluar'] = array('Terakhir Keluar',120,TRUE,'left',2);
            $colModel['status'] = array('Status',50,TRUE,'left',2);
            $colModel['action'] = array('Aksi',70,FALSE,'right',0);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
            $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->filename."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select('*')->from($this->tabel);
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->tabel);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
            $valid_fields = array('id','username','password','salt','email','jabatan','jml_login','terakhir_masuk','terakhir_keluar','status');

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->username,
				$row->password,
                $row->salt,
                $row->email,
                $row->jabatan,
                $row->jml_login,
                $row->terakhir_masuk,
                $row->terakhir_keluar,
				$status,
                '<a href=\'#\' onclick="edit(\''.$row->id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'assets/flexigrid/images/b_edit.png\'></a>&nbsp'
//                '<a href=\'#\' onclick="del(\''.$row->roles_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'assets/flexigrid/images/close.png\'></a>'
                        );
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  

	function deletec()
	{		
		//return true;
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			/*if (is_numeric($country_id) && $country_id > 0) {
				$this->delete($country_id);}*/
			$this->db->delete('tb_user',array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
}

?>