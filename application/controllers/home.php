<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2011
  * Creator : Mazhters Irwan
  * Email   : irwansyah@komunigrafik.com
  * CMS ver : CI ver.2.0
*************************************/	

class home extends CI_Controller {
	
	var $title = "Home";
	var $filename = "home";
	
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
		redirect('dashboard');
		permission();
		$data = GetHeaderFooter();
		$data['main_content'] = 'home';
		//End Global
		
		$this->load->view('template_home',$data);
	}
}
?>