<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/	

class manage_auth extends CI_Controller {
	
	var $filename = "manage_auth";
	var $tabel = "admin_auth";
	var $id_primary = "id";
	var $title = "Manage Auth";
	
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
	
	function detail($id=0)
	{
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'].'_form';
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		if($id > 0) $data['val_button'] = lang("edit");
		else $data['val_button'] = lang("add");
		//End Global
		
		$q = GetAll($this->tabel, array("id"=> "where/".$id));
		$r = $q->result_array();
		if($q->num_rows() > 0) $data['val'] = $r[0];
		else $data['val'] = array();
		$data['opt_menu'] = GetOptMenu();
		$data['opt_grup'] = GetOptGrup();
		
		$this->load->view('template',$data);
	}
	
	function update()
	{
		$webmaster_id = permission();
		$id = $this->input->post('id');
		$GetColumns = GetColumns($this->tabel);
		foreach($GetColumns as $r)
		{
			/*if($this->input->post($r['Field']."_file"))
			{
				if($_FILES[$r['Field']]['name'])
				{
					$data[$r['Field']] = $mz_function->input_file($r['Field']);
					if($data[$r['Field']] == "err_img_size")
					{
						$this->session->set_flashdata("message", lang('msg_err_img_size'));
						redirect('webmaster/'.$this->filename.'/detail/'.$id);
					}
					else if($data[$r['Field']] == "err_file_size")
					{
						$this->session->set_flashdata("message", lang('msg_err_file_size'));
						redirect('webmaster/'.$this->filename.'/detail/'.$id);
					}
					$file_old = $this->input->post($r['Field']."_file");
					if(file_exists("./".$this->config->item('path_upload')."/".$file_old)) unlink("./".$this->config->item('path_upload')."/".$file_old);
					
					$thumb = $mz_function->getThumb($file_old);
					if(file_exists("./".$this->config->item('path_upload')."/".$thumb)) unlink("./".$this->config->item('path_upload')."/".$thumb);
				}
			}
			else
			{*/
				$data[$r['Field']] = $this->input->post($r['Field']);
				$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
				if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
				unset($data[$r['Field']."_temp"]);
			//}
		}
		$data['modify_date'] = date("Y-m-d H:i:s");
		
		if($id > 0)
		{
			$data['modify_user_id'] = $webmaster_id;
			$this->db->where($this->id_primary, $id);
			$this->db->update($this->tabel, $data);
			
			//Admin Log
			//$logs = $this->db->last_query();
			//$this->model_admin_all->LogActivities($webmaster_id,$this->tabel,$this->db->insert_id(),$logs,lang($this->filename),$data[$this->title_table],$this->filename,"Add");
			
			$this->session->set_flashdata("message", lang('edit')." ".$this->title." ".lang('msg_sukses'));
		}
		else
		{
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = $data['modify_date'];
			$this->db->insert($this->tabel, $data);
			$id = $this->db->insert_id();
			//Admin Log
			//$logs = $this->db->last_query();
			//$this->model_admin_all->LogActivities($webmaster_id,$this->tabel,$this->db->insert_id(),$logs,lang($this->filename),$data[$this->title_table],$this->filename,"Add");
			
			$this->session->set_flashdata("message", lang('add')." ".$this->title." ".lang('msg_sukses'));
		}
		
		if($this->input->post("stay")) redirect($this->filename.'/detail/'.$id);
		else redirect($this->filename);
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
            $colModel['id_admin_grup'] = array('Grup User',100,TRUE,'left',2);
            $colModel['id_menu_admin'] = array('Nama Menu',100,TRUE,'left',2);
        
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
                GetValue('title','tb_admin_grup',array('id'=>'where/'.$row->id_admin_grup)),
                GetValue('title','tb_menu_admin',array('id'=>'where/'.$row->id_menu_admin))
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