<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller 
{	
	var $filename = "penjualan";
	var $tabel = "tb_penjualan";
	var $id_primary = "id";
	var $title = "List Penjualan";
	
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
			$data['edit_oleh'] = $webmaster_id;
			/*$bln=substr($this->input->post('tgl_lahir'),5,2);
			$bln_cur=substr(GetValue('tgl_lahir','tb_karyawan',array('id'=>'where/'.$id)),5,2);
			if($bln!=$bln_cur){
				$kodkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$id));
				$rek_cur=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$kodkar));
			$this->db->where('kode_karyawan', $kodkar);
			$this->db->update('tb_karyawan_rekening', array('rekening'=>substr($rek_cur,0,2).$bln.substr($rek_cur,4)));
			}*/
			
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			/*$kodkop=$this->input->post('kodkop');
			$jml_kar=GetValue('jml_kar','tb_kode_koperasi',array('kode'=>'where/'.$kodkop));
			$data['kode_karyawan']=$kodkop.substr(100000+1+$jml_kar,1);	
			$data['masuk_oleh'] = $webmaster_id;
			$data['masuk_tgl'] = $data['edit_tgl'];*/
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			
			/*$rek=array('kode_karyawan'=>$data['kode_karyawan'],
						'rekening'=>$kodkop.substr($data['tgl_lahir'],5,2).substr(100000+1+$jml_kar,1),
						'tanggal'=>date("Y-m-d"));
			$this->db->insert('tb_karyawan_rekening',$rek);
			
			$this->db->where('kode',$kodkop);
			$this->db->update('tb_kode_koperasi',array('jml_kar'=>$jml_kar+1));*/
			
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
		$data['js_grid']=$this->get_column();
		$data['filename']=$this->filename;
		
		$this->load->view('template',$data);
	}
	
	function get_column(){
	
            $colModel['idnya'] = array('ID',70,TRUE,'left',2,TRUE);
            $colModel['tanggal'] = array('Tanggal',120,TRUE,'left',2);
            $colModel['kasir'] = array('Kasir',100,TRUE,'left',2);
            $colModel['tipe_pembayaran'] = array('Tipe Pembayaran',70,TRUE,'left',2);
            $colModel['id_karyawan'] = array('ID Karyawan',200,TRUE,'left',2);
            $colModel['jangka_waktu'] = array('Jangka Waktu',60,TRUE,'left',2);
            $colModel['bunga'] = array('Bunga',60,TRUE,'left',2);
            $colModel['ppn'] = array('PPN',70,TRUE,'left',2);
            $colModel['diskon'] = array('Diskon',70,TRUE,'left',2);
            $colModel['sub_total'] = array('Sub Total',100,TRUE,'left',2);
            $colModel['total'] = array('Total',100,TRUE,'left',2);
            $colModel['status'] = array('Status',70,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
            //$buttons[] = array('select','check','btn');
            //$buttons[] = array('deselect','uncheck','btn');
            //$buttons[] = array('separator');
            //$buttons[] = array('add','add','btn');
            //$buttons[] = array('separator');
            $buttons[] = array('Detail','detail','btn');
            //$buttons[] = array('delete','delete','btn');
		
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
		
            $valid_fields = array('id','tanggal','kasir','tipe_pembayaran','id_karyawan','jangka_waktu','bunga','ppn','diskon','sub_total','total','status');

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
			if($row->status=='l'){$status='Lunas';}
			elseif($row->status=='b'){$status='Belum Lunas';}
			/*elseif($row->status=='s'){$status='Suspended';}
			if($row->kelamin=='L'){$kelamin='Laki-Laki';}
			else $kelamin='Perempuan';
			if($row->agama=='I'){$agama='Islam';}
			elseif($row->agama=='P'){$agama='Protestan';}
			elseif($row->agama=='K'){$agama='Katolik';}
			elseif($row->agama=='H'){$agama='Hindu';}
			elseif($row->agama=='B'){$agama='Budha';}*/
			
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->tanggal,
				$row->kasir,
                $row->tipe_pembayaran,
				$row->id_karyawan,
                $row->jangka_waktu,
                $row->bunga,
                $row->ppn,
                $row->diskon,
                $row->sub_total,
                $row->total,
				$status
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
			$kodkar=GetValue('kode_karyawan','tb_karyawan',array('id'=>'where/'.$country_id));
			$kodkop=substr($kodkar,0,2);
			$jml_kar=GetValue('jml_kar','tb_kode_koperasi',array('kode'=>'where/'.$kodkop));
			
			$this->db->where('kode',$kodkop);
			$this->db->update('tb_kode_koperasi',array('jml_kar'=>$jml_kar-1));
			
			$this->db->delete('tb_karyawan_rekening',array('kode_karyawan'=>$kodkar));
			$this->db->delete($this->tabel,array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	function deletec2()
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