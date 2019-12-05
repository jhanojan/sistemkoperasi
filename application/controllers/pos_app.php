<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_app extends CI_Controller 
{	
	var $filename = "pos_app";
	var $tabel = "tb_penjualan";
	var $id_primary = "id";
	var $title = "POS";
	
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
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		$data['tipe_sp'] = GetOptAllYes('tb_tipe_simpan_pinjam','-Tipe-');
		$data['ppn']=GetValue('value','tb_ppn',array('nama'=>'where/ppn'));
		$res = GetAll('tb_inventory',array());
		$data['tipe_sp'] = GetOptAll('tb_tipe_simpan_pinjam','-Tipe-');
		$data['autocomplete'] = $res->result_array();
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
		//print_mz($this->input->post());
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
			$kodekop=GetValue('kode','tb_kode_koperasi',array('id'=>'where/1'));
			date_default_timezone_set('Asia/Jakarta'); 
			$now=date("Y-m-d H:i:s");
			$bln=date('m');
			$thn=date('Y');
			$qs=$this->db->select('*')->from('tb_seri_penjualan')->where('tgl',date("Y-m-d"))->get();
			$cekpenjualan=$qs->num_rows();
			if($cekpenjualan==0){
			$seri=0;}
			else{
			$series=$qs->row_array();
			$seri=$series['penjualan'];	
			}
			$urut=substr(100000+$seri+1,1);
			$data['pj']['tipe_pembayaran']=$data['tipe_pembayaran'];
			$data['pj']['ppn']=$data['ppn'];
			$data['pj']['id_karyawan']=$data['id_karyawan'];
			$data['pj']['id_penjualan']=$kodekop.date("dm").'-'.substr($thn,-2).'-'.$urut;
			$data['pj']['tanggal']=$now;
			$data['pj']['kasir']=$this->session->userdata('admin');
			$harga_dasar=0; 
			$data['pj']['total']=$this->input->post('totalprice');
			$kdbrg=$this->input->post('kode_barang');
			$hrga_dasar=$this->input->post('harga_dasar');
			$hrga_beli=$this->input->post('harga_beli');
			$qty=$this->input->post('qty');
			$s=0;
			foreach($this->input->post('total_price') as $hargadasar){
			$harga_dasar+=$hargadasar;	
			
			$data['pj_detail'][$s]['id_penjualan']=$data['pj']['id_penjualan'];
			$data['pj_detail'][$s]['kode_group']=GetValue('kode_group','tb_inventory',array('kode_barang'=>'where/'.$kdbrg[$s]));
			$data['pj_detail'][$s]['kode_barang']=$kdbrg[$s];
			$data['pj_detail'][$s]['jumlah']=$qty[$s];
			$data['pj_detail'][$s]['satuan']=$hrga_dasar[$s];
			$data['pj_detail'][$s]['beli']=$hrga_beli[$s];
			$data['pj_detail'][$s]['laba']=($hrga_dasar[$s]*$qty[$s])-($hrga_beli[$s]*$qty[$s]);
			$data['pj_detail'][$s]['total']=$data['pj_detail'][$s]['jumlah']*$data['pj_detail'][$s]['satuan'];
			
			$sisastok=GetValue('jumlah','tb_inventory',array('kode_barang'=>'where/'.$kdbrg[$s]))-$qty[$s];
			$this->db->insert('tb_penjualan_detail',$data['pj_detail'][$s]);
			$this->db->where('kode_barang',$kdbrg[$s]);
			$this->db->update('tb_inventory',array('jumlah'=>$sisastok));
			$s++;
			}
			$data['pj']['sub_total']=$harga_dasar;
			
			if($data['tipe_pembayaran']=='cash'){$data['pj']['status']='l';
			$data['pj']['kas']=cari_kas('Penjualan');
			$kredit=kredit_kas('Penjualan',$data['pj']['id_penjualan'],$data['pj']['total'],$data['pj']['kas']);}
			else{$data['pj']['status']='b';
			//$this->input->post('total_debit')=$data['pj']['totalprice'];
			$this->kredit_barang($ids='pinjaman');
			
			}
			
		//print_mz($data);
		if($id > 0)
		{
		
		}
		else
		{
			
			$this->db->insert('tb_penjualan',$data['pj']);
			if($cekpenjualan==0){
			$this->db->insert('tb_seri_penjualan',array('tgl'=>date('Y-m-d'),'penjualan'=>1));
			
			}
			else{
			$this->db->where('tgl',date('Y-m-d'));
			$this->db->update('tb_seri_penjualan',array('penjualan'=>$seri+1));
			}
		}
		
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
	function kredit_barang($pinjaman=NULL)
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
			
			$tipe='pinjam';
			$kodekop=GetValue('kode','tb_kode_koperasi',array('id'=>'where/1'));
			date_default_timezone_set('Asia/Jakarta');
			$now=date("Y-m-d H:i:s");
			$bln=date('m');
			$thn=date('Y');
			$seri=GetValue('pinjaman','tb_seri_pinjaman',array('tahun'=>'where/'.$thn));
			$urut=substr(100000+$seri+1,1);
			$data['id_simpan_pinjam']=$kodekop.$bln.'-'.substr($thn,-2).'-'.$urut;
			$data['waktu']=$now;
			$data['total_debit']=$this->input->post('totalprice');
			if($tipe=='simpan'){
			$data['status']='l';
				$detail['id_simpan_pinjam']=$data['id_simpan_pinjam'];
				$detail['tanggal']=$data['waktu'];
				$detail['rekening']=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$data['id_karyawan']));
				$detail['kredit']=$data['total_kredit'];
				$this->db->insert('tb_simpan_pinjam_detail',$detail);	
				
			}
			else{
			$data['status']='b';		
				$detail['id_simpan_pinjam']=$data['id_simpan_pinjam'];
				$detail['tanggal']=$data['waktu'];
				$detail['rekening']=GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>'where/'.$data['id_karyawan']));
				$detail['debit']=$data['total_debit'];
				$this->db->insert('tb_simpan_pinjam_detail',$detail);
				
				$data['total_debit']=$data['total_debit']*(100+$data['bunga'])/100;
			}
			$this->db->where('tahun',$thn);
			$this->db->update('tb_seri_pinjaman',array('pinjaman'=>$seri+1));
			//$data['masuk_oleh'] = $webmaster_id;
			//$data['masuk_tgl'] = $data['modify_date'];
			$this->db->insert('tb_simpan_pinjam', $data);
			$id = $this->db->insert_id();
			
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		//cetakSimpanPinjam($data['id_simpan_pinjam']);
		return TRUE;
	}
	
	
	
}

?>