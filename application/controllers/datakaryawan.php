<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/	

class datakaryawan extends CI_Controller {
	
	var $filename = "datakaryawan";
	var $tabel = "employee";
	var $id_primary = "id";
	var $title = "Data Karyawan";
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main($dep=0,$user=0)
	{
		//Set Global
		permission();
    $data = GetHeaderFooter();
		$data['path_file'] = $this->filename;
		//permissionkaryawan($this->session->userdata('webmaster_id'), $data['path_file']);
		$data['main_content'] = $data['path_file'];
		$data['filename'] = $this->filename;
		$data['title'] = $this->title;
		
		$path_paging = base_url().$this->filename."/main/".$dep."/".$user;
		$uri_segment = 5;
		$pg = $this->uri->segment($uri_segment);
		$per_page=15;
		//End Global
		
		/*$data['opt_pic'] = GetOptPIC();
		$data['opt_pic'][''] = "";*/
		$data['opt_dep'] = GetOptDepartment();
		//$data['opt_dep'][''] = "";
		
		$filter = array("is_active"=> "where/Active");
		$filter_where_in = array();
		if($user)
		{
			$exp = explode("-",$user);
			$user=array();
			foreach($exp as $r)
			{
				$user[] = $r;
			}
			$filter_where_in['id'] = $user;
		}
		else $user=array();
		
		if($dep)
		{
			/*$exp = explode("-",$dep);
			$dep=array();
			foreach($exp as $r)
			{
				$dep[] = $r;
			}
			$filter_where_in['id_department'] = $dep;*/
			$filter['id_department'] = "where/".$dep;
		}
		//else $dep=array();
		/*if($dep)
		{
			$filter['id_kedeputian'] = "where/".$dep;
			if($user) $filter['id'] = "where/".$user;
		}*/
		$data['dep'] = $dep;
		$data['pic'] = $user;
		
		//Grup Admin
		$id_grup = $this->session->userdata("webmaster_grup");
		$where = "";
		if($id_grup == 4) $filter['nik'] = "where/-";
		//End Grup Admin
		
		$data['grid'] = array("Nama","Tempat, Tanggal Lahir","Usia","Position","Department","Jenis Kelamin","Agama","Pendidikan","Pernikahan");
		$data['query_all'] = GetAll($this->tabel, $filter, $filter_where_in);
		$filter['limit'] = $pg."/".$per_page;
		$data['query_list'] = GetAll($this->tabel, $filter, $filter_where_in);
		$data['list'] = array("name","ttl","usia","id_position","id_department","sex","religion","education","id_marrital_status");
		
		//Page
		$pagination = Page($data['query_all']->num_rows(),$per_page,$pg,$path_paging,$uri_segment);
		if(!$pagination) $pagination = "<strong>1</strong>";
		$data['pagination'] = $pagination;
		//End Page
		if($this->input->post('export'))
		{
			$data['grid_export'] = array("Nama","No Employee", "Jabatan", "Departement", "Date Of Joint", "Status", "Jenis Kelamin","Tanggal Lahir", "Riwayat Pendidikan");
			$data['query_list_export'] = GetAll($this->tabel, array("id !="=> "where/1"));
			$data['list_export'] = array("name","nik","id_position","id_department","date_hire_since","id_marrital_status","sex","ttl","education");
			
			$data['main_content'] = "datakaryawan_export";
			$html = $this->load->view("template_export",$data);
			to_excel($html,str_replace(" ","_",$this->title));
		}else{
			$this->load->view('template_personal',$data);
		}
		
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
		$data['table'] = $this->tabel;
		if($id > 0) $data['val_button'] = lang("edit");
		else $data['val_button'] = lang("add");
		//End Global
		
		$q = GetAll($this->tabel, array("id"=> "where/".$id));
		$r = $q->result_array();
		if($q->num_rows() > 0) $data['val'] = $r[0];
		else $data['val'] = array();
		$data['opt_agama'] = GetOptAgama();
		$data['opt_blood'] = GetOptBlood();
		$data['opt_pernikahan'] = GetOptAll("marrital_status");
		$data['opt_position'] = GetOptPosition();
		$data['opt_department'] = GetOptDepartment();
		$data['opt_grup'] = GetOptAll("admin_grup");
		/*$data['opt_atasan'] = GetOptPIC();
		$data['opt_atasan'][''] = "";
		$data['opt_bawahan'] = GetOptPIC();
		$data['opt_bawahan'][''] = "";*/
		
		$this->load->view('template',$data);
	}
	
	function update()
	{
		$webmaster_id = permission();
		$id = $this->input->post('id');
		$GetColumns = GetColumns($this->tabel);
		foreach($GetColumns as $r)
		{
			if($this->input->post($r['Field']."_file") || isset($_FILES[$r['Field']]['name']))
			{
				if($_FILES[$r['Field']]['name'])
				{
					$data[$r['Field']] = InputFile($r['Field'], 1000);
					if($data[$r['Field']] == "2")
					{
						$this->session->set_flashdata("message", lang('msg_err_size'));
						redirect($this->filename.'/detail/'.$id);
					}
					else if($data[$r['Field']] == "3")
					{
						$this->session->set_flashdata("message", lang('msg_err_ext'));
						redirect($this->filename.'/detail/'.$id);
					}
					
					$file_old = $this->input->post($r['Field']."_file");
					if(file_exists("./".$this->config->item('path_upload')."/".$file_old) && $file_old) unlink("./".$this->config->item('path_upload')."/".$file_old);
					
					$thumb = GetThumb($file_old);
					if(file_exists("./".$this->config->item('path_upload')."/".$thumb) && $thumb) unlink("./".$this->config->item('path_upload')."/".$thumb);
				}
			}
			else
			{
				$data[$r['Field']] = $this->input->post($r['Field']);
				$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
				
				if($r['Field'] == "userpass")
				{
					if($data[$r['Field']] != $data[$r['Field']."_temp"]) $data[$r['Field']] = md5($this->config->item('encryption_key').$data[$r['Field']]);
				}
				
				if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
				unset($data[$r['Field']."_temp"]);
			}
		}
		$data['modify_date'] = date("Y-m-d H:i:s");
		//print_mz($data);
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
		
		$k=0;
		//$filter = array("name"=> "order/asc");
		$filter = array();
		$q = GetAll("employee", $filter);
		foreach($q->result_array() as $r)
		{
			$k++;
			if($r['id'] == $id)
			{
				if($k%15) $pg = floor($k/15) * 15;
				else $pg = (floor($k/15)-1) * 15;
				break;
			}
		}
		
		if($this->input->post("stay")) redirect($this->filename.'/detail/'.$id);
		else redirect($this->filename."/main/0/0/".$pg);
	}
	
	function delete()
	{
		$webmaster_id = permission();
		$data=array();
		
		$exp = explode("-",$this->input->post('del_id'));
		foreach($exp as $r)
		{
			if($r)
			{
				$data[]=$r;
				//Admin Log
				//$logs = "DELETE from ".$this->tabel." where id='".$r."'";
				//$this->model_admin_all->LogActivities($webmaster_id,$this->tabel,$r,$logs,lang($this->filename),'',$this->filename,"Delete");
				$q = GetAll($this->tabel, array("id"=> "where/".$r));
				$r = $q->result_array();
				$data_ins = array("id_employee"=> $r[0]['id'], "create_date"=> date("Y-m-d H:i:s"),
				 "modify_date"=> date("Y-m-d H:i:s"), "create_user_id"=> GetUserID(), "modify_user_id"=> GetUserID());
				$this->db->insert("exitmng", $data_ins);
			}
		}
		
		//$this->db->where_in($this->id_primary, $data);
		//$this->db->delete($this->tabel);
		$this->db->where_in($this->id_primary, $data);
		$this->db->update($this->tabel, array("is_active"=> "InActive", "modify_date"=> date("Y-m-d H:i:s"), "modify_user_id"=> GetUserID()));
		$this->session->set_flashdata("message", lang('delete')." ".count($data)." ".lang($this->filename)." ".lang('msg_sukses'));
	}
	
	function dashboard($id=0)
	{
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'].'_dashboard';
		$data['filename'] = $this->filename;
		$data['id']=$id;
		//End Global
		
		$data['info_mem'] = GetAll("employee", array("id"=> "where/".$id));
		
		$filter = array("karyawan"=> "where/".$id);
		$data['pi_pendidikan'] = GetAll("pi_pendidikan", array("karyawan"=> "where/".$id, "thn_mulai"=> "order/asc"));
		$data['pi_keluarga'] = GetAll("pi_keluarga", $filter);
		$data['pi_riwayatkerja'] = GetAll("pi_riwayatkerja", $filter);
		$data['pi_medis'] = GetAll("pi_medis", $filter);
		$data['pi_riwayatsanksi'] = GetAll("pi_riwayatsanksi", $filter);
		$data['pi_training'] = GetAll("pi_training", array("karyawan"=> "where/".$id, "tahun_mulai"=> "order/asc"));
		$data['cuti'] = GetAll("cuti", array("id_employee"=> "where/".$id));
		//$data['trj'] = GetAll("tunjangan", $filter);
		//$data['kompetensi'] = GetAll("kompetensi", $filter);
		
		$this->load->view('template',$data);
	}
	
	
	function export($id=0,$target=NULL)
	{
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'].'_export_'.$target;
		$data['filename'] = $this->filename;
		$data['id']=$id;
		//End Global
		
		$filter = array("karyawan"=> "where/".$id);
		switch($target){
		
			case "dashboard" :
			$data['info_mem'] = GetAll("admin", array("id"=> "where/".$id));
			break;
			
			case "tambahan" :
			$data['info_mem'] = GetAll("admin", array("id"=> "where/".$id));
			break;
			
			case "pendidikan" :
			$data['pi_pendidikan'] = GetAll("pi_pendidikan", array("karyawan"=> "where/".$id, "thn_mulai"=> "order/asc"));
			break;
			
			case "keluarga" :
			$data['pi_keluarga'] = GetAll("pi_keluarga", $filter);
			break;
			
			case "riwayatkerja" :
			$data['pi_riwayatkerja'] = GetAll("pi_riwayatkerja", $filter);
			break;
			
			case "training" :
			$data['pi_training'] = GetAll("pi_training", array("karyawan"=> "where/".$id, "tahun_mulai"=> "order/asc"));
			break;
			
			case "medis" :
			$data['pi_medis'] = GetAll("pi_medis", $filter);
			break;
			
			case "riwayatkpan" :
			$data['pi_riwayatkpan'] = GetAll("pi_riwayatkpan", $filter);
			break;
			
			case "riwayatsanksi" :
			$data['pi_riwayatsanksi'] = GetAll("pi_riwayatsanksi", $filter);
			break;
			
			case "cuti" :
			$data['cuti'] = GetAll("cuti", $filter);
			break;
			
			case "plafontunjangan" :
			$data['info_mem'] = GetAll("admin", array("id"=> "where/".$id));
			$data['trj'] = GetAll("tunjangan", $filter);
			break;
			
			case "kompetensi" :
			$data['kompetensi'] = GetAll("kompetensi", $filter);
			break;
			
			case "targetkerja" :
			$data['target'] = GetAll("view_kegiatan", array("id_pic"=> "where/-".$id."-"));
			break;
			
		}
		
		$date = date("Y-m-d H:i:s");
		$html = $this->load->view('template_export',$data);
		to_excel($html, $this->filename."_".$target.$date);
	}
	
	function export_param($id)
	{
		permission();
		$data['id'] = $id;
		$this->load->view('personal_export_param',$data);
	}
	
	function export_all()
	{
		//Set Global
		permission();
		$data = GetHeaderFooter();
		$data['path_file'] = $this->filename;
		$data['main_content'] = $data['path_file'].'_export_all';
		$data['filename'] = $this->filename;
		$id = $this->input->post("id");
		$data['id']=$id;
		$name = GetValue("name","admin", array("id"=> "where/".$id));
		//End Global
		
		$data['info_mem'] = GetAll("admin", array("id"=> "where/".$id));
		$filter = array("karyawan"=> "where/".$id);
		$data['absen'] = GetAll("kehadirandetil", array("karyawan"=> "where/".$id, "tahun"=> "where/".date("Y"), "bulan"=> "order/asc", "tanggal"=> "order/asc"));
		$data['pi_pendidikan'] = GetAll("pi_pendidikan", array("karyawan"=> "where/".$id, "thn_mulai"=> "order/asc"));
		$data['pi_keluarga'] = GetAll("pi_keluarga", $filter);
		$data['pi_riwayatkerja'] = GetAll("pi_riwayatkerja", $filter);
		$data['pi_training'] = GetAll("pi_training", array("karyawan"=> "where/".$id, "tahun_mulai"=> "order/asc"));
		$data['pi_medis'] = GetAll("pi_medis", $filter);
		$data['pi_riwayatkpan'] = GetAll("pi_riwayatkpan", $filter);
		$data['pi_riwayatsanksi'] = GetAll("pi_riwayatsanksi", $filter);
		$data['cuti'] = GetAll("cuti", $filter);
		$data['trj'] = GetAll("tunjangan", $filter);
		$data['kompetensi'] = GetAll("kompetensi", $filter);
		$data['target'] = GetAll("view_kegiatan", array("id_pic"=> "where/-".$id."-"));
		
		if($this->input->post("personal")) $data['dis_personal'] = "";
		else $data['dis_personal'] = "display:'none';";
		
		if($this->input->post("personal_tambahan")) $data['dis_personal_tambahan'] = "";
		else $data['dis_personal_tambahan'] = "display:none;";
		
		if($this->input->post("kehadiran")) $data['dis_kehadiran'] = "";
		else $data['dis_kehadiran'] = "display:none;";
		
		if($this->input->post("target")) $data['dis_target'] = "";
		else $data['dis_target'] = "display:none;";
		
		if($this->input->post("pendidikan")) $data['dis_pendidikan'] = "";
		else $data['dis_pendidikan'] = "display:none;";
		
		if($this->input->post("training")) $data['dis_training'] = "";
		else $data['dis_training'] = "display:none;";
		
		if($this->input->post("kerja")) $data['dis_kerja'] = "";
		else $data['dis_kerja'] = "display:none;";
		
		if($this->input->post("kompetensi")) $data['dis_kompetensi'] = "";
		else $data['dis_kompetensi'] = "display:none;";
		
		if($this->input->post("keluarga")) $data['dis_keluarga'] = "";
		else $data['dis_keluarga'] = "display:none;";
		
		if($this->input->post("cuti")) $data['dis_cuti'] = "";
		else $data['dis_cuti'] = "display:none;";
		
		if($this->input->post("plafon")) $data['dis_plafon'] = "";
		else $data['dis_plafon'] = "display:none;";
		
		if($this->input->post("medis")) $data['dis_medis'] = "";
		else $data['dis_medis'] = "display:none;";
		
		if($this->input->post("sanksi")) $data['dis_sanksi'] = "";
		else $data['dis_sanksi'] = "display:none;";
		
		$date = date("d-F-Y");
		$html = $this->load->view('template_export_all',$data);
		to_doc($html, str_replace(" ","_",$name)."_".$date);
	}
	
	
	function grafik_attendance()
	{
		//Setting
		//$q = GetQuery("MONTH(tanggal) as label,count(*) as total", "kg_kehadiran", "karyawan='".$this->uri->segment(4)."' and absen=1","","MONTH(tanggal)");
		//$q = GetQuery("bulan as label,count(*) as total", "kg_kehadirandetil", "karyawan='".$this->uri->segment(4)."' and jh=1","","bulan");
		//$q = GetQuery("bulan as label,SUM(jhk) as total,SUM(jh) as hadir", "kg_kehadirandetil", "karyawan='".$this->uri->segment(4)."' and jh=1","","bulan");
		//Setting
		
		/*$chart = "<chart caption='' smartLineColor='#FF0000' enableSmartLabels='1'
		xAxisName='Month' yAxisName='Absen' yAxisMinValue='0' yAxisMaxValue='30' showValues='1' showBorder='0'
		alternateHGridColor='EEF4FA' alternateHGridAlpha='100' divLineColor='333333' divLineAlpha='10' 
		canvasBorderColor='a6a6a6' baseFontColor='333333' lineColor='FF0000' bgColor='FFFFFF,FFFFFF' 
		>";*/
		$id_employee = $this->uri->segment(3);
		$chart = "<chart caption='' smartLineColor='#FF0000' enableSmartLabels='1' numberSuffix=' %' 
		xAxisName='Bulan' yAxisName='Prosentase' yAxisMinValue='0' yAxisMaxValue='100' showValues='1' showBorder='0'
		alternateHGridColor='EEF4FA' alternateHGridAlpha='100' divLineColor='333333' divLineAlpha='10' 
		canvasBorderColor='a6a6a6' baseFontColor='333333' lineColor='FF0000' bgColor='FFFFFF,FFFFFF' 
		>";
		$chart .= "<set label='' value=''/>";
		$year=date("Y");
		for($i=1;$i<=12;$i++)
		{
			$bln = strlen($i) == 1 ? "0".$i : $i;
			$q = GetQuery("SUM(jhk) as total", "kg_kehadirandetil", "bulan='".$bln."' AND tahun='".$year."' AND id_employee='".$id_employee."'","","bulan");
			if($q->num_rows() > 0)
			{
				$r = $q->result_array();
				$qq = GetQuery("SUM(jh) as hadir", "kg_kehadirandetil", "bulan='".$bln."' AND tahun='".$year."' AND id_employee='".$id_employee."' and jh=1","","bulan");
				$rr = $qq->result_array();
				$val = ($rr[0]['hadir'] / $r[0]['total']) * 100;
			}
			else $val=0;
			$chart .= "<set label='".GetMonth($i)."' value='".Decimal($val)."' />";
		}
		$chart .= "<set label='' value=''/>";
		$chart .= "<styles>
	      <definition>
	         <style type='font' name='captionFont' size='13' />
	      </definition>
	      <application>
	         <apply toObject='CAPTION' styles='captionFont' />
	      </application>
	   </styles>";
		$chart .= "</chart>";
		echo $chart;
	}
	
	function search()
	{
		$spic = $this->input->post('pic');
		$sdep = $this->input->post('dep');
		/*if($dep)
		{
			$sdep = "";
			foreach($dep as $r)
			{
				if($sdep) $sdep .= "-".$r;
				else $sdep .= $r;
			}
		}
		else $sdep = "0";
		
		if($pic)
		{
			$spic = "";
			foreach($pic as $r)
			{
				if($spic) $spic .= "-".$r;
				else $spic .= $r;
			}
		}
		else $spic = "0";*/
		
		redirect(site_url($this->filename.'/main/'.$sdep.'/'.$spic));
		/*if(($pic && $dep) || $dep)
		redirect(site_url($this->filename.'/main/'.$sdep.'/'.$pic));
		else
		redirect(site_url($this->filename.'/dashboard/'.$pic));*/
	}	
}
?>