<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class simpan_pinjam extends CI_Controller 
{	
	var $filename = "simpan_pinjam";
	var $tabel = "tb_simpan_pinjam";
	var $id_primary = "id";
	var $title = "List Simpan Pinjam";
	
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
		$data['path_file'] = $this->filename.'_detail';
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		$data['nota']=GetValue('id_simpan_pinjam','tb_simpan_pinjam',array('id'=>'where/'.$id));
		
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
		//$data['edit_tgl'] = date("Y-m-d H:i:s");
		//print_mz($data);
		if($id > 0)
		{
			//$data['edit_oleh'] = $webmaster_id;
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			
			//$data['masuk_oleh'] = $webmaster_id;
			//$data['masuk_tgl'] = $data['modify_date'];
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		redirect($this->filename."/main");
	}
	
	function main(){
		
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		if($this->session->userdata('webmaster_grup')==2){$ids=$this->session->userdata('webmaster_id');}
		else{$ids=0;}
		$data['js_grid']=$this->get_column($ids);
		$data['filename']=$this->filename;
		
		$this->load->view('template',$data);
	}
	
	function get_column($ids){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id_simpan_pinjam'] = array('Kode Simpan Pinjam',120,TRUE,'left',2);
            $colModel['tipe'] = array('Tipe',120,TRUE,'center',2);
            $colModel['id_karyawan'] = array('ID Karyawan',100,TRUE,'left',2);
            $colModel['id_penjualan'] = array('ID Penjualan',100,TRUE,'left',2);
            $colModel['jml_angsuran'] = array('Jumlah Angsuran',100,TRUE,'left',2);
            $colModel['bunga'] = array('Bunga',50,TRUE,'left',2);
            $colModel['tgl_jatuh_tempo'] = array('Tanggal Jatuh Tempo',100,TRUE,'left',2);
            $colModel['total_debit'] = array('Total Debit',100,TRUE,'left',2);
            $colModel['total_kredit'] = array('Total Kredit',100,TRUE,'left',2);
            $colModel['email'] = array('E-mail',100,TRUE,'left',2);
            $colModel['tlp'] = array('Telepon',100,TRUE,'left',2);
            $colModel['deskripsi'] = array('Deskripsi',100,TRUE,'left',2);
            $colModel['status'] = array('Status',100,TRUE,'left',2);
        
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
            $buttons[] = array('separator');
            $buttons[] = array('detail','detail','btn');
            $buttons[] = array('delete','delete','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->filename."/get_record/$ids"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($ids)
        {
			
			if($ids!=0){
			/*$rowkar=GetValue('username','tb_user',array('id'=>'where/'.$ids));
			lastq();*/
			$nik=GetValue('nik','tb_karyawan',array('id'=>'where/'.$ids));
			$idkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$ids));
			}
				
            //Build contents query
            $this->db->select('*')->from($this->tabel);
			if($ids!=0){
			//$where = "id_karyawan='$idkar' OR id_karyawan='$idkar'";
			$this->db->where('id_karyawan',$idkar);
			$this->db->or_where('id_karyawan',$nik);		
			}
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->tabel);if($ids!=0){
			//$where = "id_karyawan='$idkar' OR id_karyawan='$idkar'";
			$this->db->where('id_karyawan',$idkar);
			$this->db->or_where('id_karyawan',$nik);		
			}
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($ids){
		
            $valid_fields = array('id','id_simpan_pinjam','tipe','id_karyawan','id_penjualan','jml_angsuran','bunga','tgl_jatuh_tempo','total_debit','total_kredit','email','tlp','deskripsi','status','waktu');

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
            $records = $this->get_flexigrid($ids);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id_simpan_pinjam,
                GetValue('nama','tipe_simpan_pinjam',array('id'=>'where/'.$row->tipe)),
                $row->id_karyawan,
                $row->id_penjualan,
                $row->jml_angsuran,
				$row->bunga,
                $row->tgl_jatuh_tempo,
				$row->total_debit,
				$row->total_kredit,
				$row->email,
				$row->tlp,
				$row->deskripsi,
				$row->status,
				$row->waktu
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
			$this->db->delete($this->tabel,array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
}

?>