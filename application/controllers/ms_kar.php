 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ms_kar extends CI_Controller 
{	
	var $filename = "ms_kar";
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
			$idusers = $this->db->insert_id();
			
			$rek=array('kode_karyawan'=>$data['kode_karyawan'],
						'rekening'=>$kodkop.substr($data['tgl_lahir'],5,2).substr(100000+1+$jml_kar,1),
						'tanggal'=>date("Y-m-d"));
			$this->db->insert('tb_karyawan_rekening',$rek);
			
			$akun=array('username'=>$idusers,
						'salt'=>'12345',
						'password'=>md5('1234512345'),
						'jabatan'=>2,
						'status'=>'Y');
			$this->db->insert('tb_user',$akun);
			
			$this->db->where('kode',$kodkop);
			$this->db->update('tb_kode_koperasi',array('jml_kar'=>$jml_kar+1));
			
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
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['nik'] = array('NIk',100,TRUE,'left',2);
            $colModel['kode_karyawan'] = array('Kode Karyawan',100,TRUE,'left',2);
            $colModel['nama'] = array('Nama',200,TRUE,'left',2);
            $colModel['kode_jabatan'] = array('Jabatan',70,TRUE,'left',2);
            $colModel['kelamin'] = array('Kelamin',70,TRUE,'left',2);
            $colModel['tmpt_lahir'] = array('Tempat Lahir',200,TRUE,'left',2);
            $colModel['tgl_lahir'] = array('Tgl Lahir',200,TRUE,'left',2);
            $colModel['agama'] = array('Agama',70,TRUE,'left',2);
            $colModel['alamat'] = array('Alamat',200,TRUE,'left',2);
            $colModel['email'] = array('E-Mail',200,TRUE,'left',2);
            $colModel['notel'] = array('Telepon',70,TRUE,'left',2);
            $colModel['rekening'] = array('Rekening',70,TRUE,'left',2);
            $colModel['status'] = array('Status',70,TRUE,'left',2);
            $colModel['masuk_tgl'] = array('Masuk Tgl',150,TRUE,'left',2);
            $colModel['masuk_oleh'] = array('Masuk Oleh',70,TRUE,'left',2);
            $colModel['edit_tgl'] = array('Edit Tgl',150,TRUE,'left',2);
            $colModel['edit_oleh'] = array('Edit Oleh',50,TRUE,'left',2);
        
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
			//lastq();
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
		
            $valid_fields = array('id','kode_karyawan','nama','kode_jabatan','kelamin','tmpt_lahir','tgl_lahir','agama','alamat','notel','status','rekening');

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}
			if($row->kelamin=='L'){$kelamin='Laki-Laki';}
			else $kelamin='Perempuan';
			if($row->agama=='I'){$agama='Islam';}
			elseif($row->agama=='P'){$agama='Protestan';}
			elseif($row->agama=='K'){$agama='Katolik';}
			elseif($row->agama=='H'){$agama='Hindu';}
			elseif($row->agama=='B'){$agama='Budha';}
			
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->nik,
                $row->kode_karyawan,
				$row->nama,
                GetValue('nama','jabatan',array('id'=>'where/'.$row->kode_jabatan)),
				$kelamin,
                ucfirst($row->tmpt_lahir),
				tgl_indo($row->tgl_lahir),
                $agama,
				ucfirst($row->alamat),
                $row->email,
                $row->notel,
				GetValue('rekening','tb_karyawan_rekening',array('kode_karyawan'=>$row->kode_karyawan)),
                $status,
                $row->masuk_tgl,
                $row->masuk_oleh,
                $row->edit_tgl,
                $row->edit_oleh
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
	function changePP($id=NULL,$post){
        $config['upload_path']	= "./uploads/foto/real/";
        $config['allowed_types']= 'gif|jpg|png|jpeg';
        $config['max_size']     = '2000';
        $config['max_width']  	= '2000';
        $config['max_height']  	= '2000';
 		$config['file_name'] = str_replace(' ','_',$post['nama']).date("YmdHis");
        $this->load->library('upload', $config);
 
        if ($this->upload->do_upload("photo")) {
            $data	 	= $this->upload->data();
 
            /* PATH */
            $source             = "./uploads/foto/real/".$data['file_name'] ;
            $destination_thumb	= "./uploads/foto/thumbnail/" ;
            $destination_medium	= "./uploads/foto/medium/" ;
 
            // Permission Configuration
            chmod($source, 0777) ;
 
            /* Resizing Processing */
	    // Configuration Of Image Manipulation :: Static
	    $this->load->library('image_lib') ;
	    $img['image_library'] = 'GD2';
	    $img['create_thumb']  = TRUE;
	    $img['maintain_ratio']= TRUE;
 
            /// Limit Width Resize
            $limit_medium   = 250 ;
            $limit_thumb    = 150 ;
 
            // Size Image Limit was using (LIMIT TOP)
            $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;
 
            // Percentase Resize
            if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                $percent_medium = $limit_medium/$limit_use ;
                $percent_thumb  = $limit_thumb/$limit_use ;
            }
 
   /*         //// Making THUMBNAIL ///////
	    	$img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
            $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;
 
            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
            $img['quality']      = '100%' ;
            $img['source_image'] = $source ;
            $img['new_image']    = $destination_thumb ;
 
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear() ;*/
 
            ////// Making MEDIUM /////////////
            $img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
            $img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;
 
            // Configuration Of Image Manipulation :: Dynamic
            $img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']) ;
            $img['quality']      = '100%' ;
            $img['source_image'] = $source ;
            $img['new_image']    = $destination_medium ;
 
            // Do Resizing
            $this->image_lib->initialize($img);
            $this->image_lib->resize();
            $this->image_lib->clear() ;
			$datas['status']=TRUE;
			$datas['fn']='uploads/foto/medium/'.$config['file_name'].$img['thumb_marker'].substr($data['full_path'],-4);
			
			unlink('./uploads/foto/real/'.$config['file_name'].'.jpg');
			return $datas;
        }
        else {
			$datas['status']=FALSE;
            return $datas;
        }
    
		
		
		}
}

?>