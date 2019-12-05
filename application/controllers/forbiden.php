<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/	

class forbiden extends CI_Controller {
	
	var $title = "Dilarang Masuk";
	var $filename = "forbiden";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("model_admin_all");
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Set Global
		$data = GetHeaderFooter();
		$data['main_content'] = 'forbiden';
		//End Global
		
		$this->load->view('template_forbiden',$data);
	}
}
?>