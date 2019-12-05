<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class debit_kredit_kas extends CI_Controller 
{	
	var $filename = "debit_kredit_kas";
	var $tabel = "tb_transaksi_kas";
	var $id_primary = "id";
	var $title = "Debit/Kredit Kas";
	
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
		$data['kas']=GetOptAll('tb_kas');
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
		
		$q="UPDATE tb_kas SET ";
		if($this->input->post('tipebayar')=='kredit'){
		$q.="`value`=`value`+'".$data['kredit']."'";	
		}
		else{
			$q.="`value`=`value`-'".$data['debit']."'";
		}
		$q.=" WHERE id='".$data['kas']."'";
		$this->db->query($q);
		//lastq();
		//$data['edit_tgl'] = date("Y-m-d H:i:s");
		//print_mz($data);
		$data['tgl']=date('Y-m-d H:i:s');
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
		
		//lastq();
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
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['tipe_transaksi'] = array('Keterangan',100,TRUE,'left',2);
            $colModel['id_transakis'] = array('ID Transaksi',100,TRUE,'left',2);
            $colModel['nama_kas'] = array('Kas',100,TRUE,'left',2);
            $colModel['debit'] = array('Debit',100,TRUE,'left',2);
            $colModel['kredit'] = array('Kredit',100,TRUE,'left',2);
            $colModel['tgl'] = array('Tanggal',100,TRUE,'left',2);
        
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
		
            return $grid_js = build_grid_js('flex1',site_url($this->filename."/get_record"),$colModel,'tb_transaksi_kas.id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select('tb_transaksi_kas.tipe_transaksi as id,tb_transaksi_kas.tipe_transaksi as tipe_transaksi
			,tb_transaksi_kas.id_transaksi as id_transaksi
			,tb_transaksi_kas.debit as debit
			,tb_transaksi_kas.kredit as kredit
			,tb_transaksi_kas.tgl as tgl
			,tb_kas.nama as nama_kas')->from($this->tabel);
			$this->db->join('tb_kas', 'tb_kas.id = tb_transaksi_kas.kas', 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();
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
		
            $valid_fields = array('id','tipe_transaksi','id_transaksi','debit','kredit','tgl','nama_kas');

            $this->flexigrid->validate_post('tb_transaksi_kas.id','ASC',$valid_fields);
            $records = $this->get_flexigrid();

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
                $row->tipe_transaksi,
                $row->id_transaksi,
                $row->nama_kas,
                $row->debit,
                $row->kredit,
				$row->tgl
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