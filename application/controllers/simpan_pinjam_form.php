<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class simpan_pinjam_form extends CI_Controller 
{	
	var $filename = "simpan_pinjam_form";
	var $tabel = "tb_simpan_pinjam";
	var $id_primary = "id";
	var $title = "Simpan Pinjam";
	
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

	
	function detail($id=null){
		permission();
		$data = GetHeaderFooter();
		$data['segment'] = $this->uri->segment(1);
		//$data['path_file'] = $this->filename.'_form';
		$data['path_file'] = $this->filename;
		//$data['main_content'] = $data['path_file'];
                $data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		$data['tipe_sp'] = GetOptAllYes('tb_tipe_simpan_pinjam','-Tipe-');
		$data['bunga']=GetValue('value','tb_ppn',array('nama'=>'where/bunga'));
		
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
                //$this->load->view("simpan_pinjam_form",$data);

                
                
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
			//$data['tipe']
			$tipe=GetValue("tipe","tb_tipe_simpan_pinjam",array('id'=>'where/'.$data['tipe']));
			$kodekop=GetValue('kode','tb_kode_koperasi',array('id'=>'where/1'));
			date_default_timezone_set('Asia/Jakarta');
			$now=date("Y-m-d H:i:s");
			$bln=date('m');
			$thn=date('Y');
			$seri=GetValue('pinjaman','tb_seri_pinjaman',array('tahun'=>'where/'.$thn));
			$urut=substr(100000+$seri+1,1);
			$data['id_simpan_pinjam']=$kodekop.$bln.'-'.substr($thn,-2).'-'.$urut;
			$data['waktu']=$now;
			
			if($tipe=='simpan'){
			$data['status']='l';
				$detail['id_simpan_pinjam']=$data['id_simpan_pinjam'];
				$detail['tanggal']=$data['waktu'];
				$detail['rekening']=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$data['id_karyawan']));
				$detail['kredit']=$data['total_kredit'];
				$kas=cari_kas('Simpan Pinjam');
				$catat=kredit_kas('Simpan Pinjam',$detail['id_simpan_pinjam'],$detail['kredit'],$kas);
				$this->db->insert('tb_simpan_pinjam_detail',$detail);	
				
			}
			else{
			$data['status']='b';		
				$detail['id_simpan_pinjam']=$data['id_simpan_pinjam'];
				$detail['tanggal']=$data['waktu'];
				$detail['rekening']=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$data['id_karyawan']));
				$detail['debit']=$data['total_debit'];
				$kas=cari_kas('Simpan Pinjam');
				$catat=debit_kas('Simpan Pinjam',$detail['id_simpan_pinjam'],$detail['debit'],$kas);
				if($catat==FALSE){
				$this->session->set_flashdata("message", 'Pinjaman Gagal! Saldo Kas Tidak Mencukupi');
					redirect($this->filename."/detail");
					}
				$this->db->insert('tb_simpan_pinjam_detail',$detail);
				
				$data['total_debit']=$data['total_debit']*(100+$data['bunga'])/100;
			}
			$this->db->where('tahun',$thn);
			$this->db->update('tb_seri_pinjaman',array('pinjaman'=>$seri+1));
			//$data['masuk_oleh'] = $webmaster_id;
			//$data['masuk_tgl'] = $data['modify_date'];
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		cetakSimpanPinjam($data['id_simpan_pinjam']);
		redirect($this->filename."/detail");
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
            $colModel['nama'] = array('Nama',100,TRUE,'left',2);
            $colModel['tipe'] = array('Tipe',100,TRUE,'left',2);
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
		
            $valid_fields = array('id','nama','value');

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
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
                $row->nama,
                $row->tipe,
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