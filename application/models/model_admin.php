<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_admin extends CI_Model {

	var $table = 'kg_admin';
	
	function get_admin()
	{
		$this->db->order_by('id');
		return $this->db->get('admin');
	}

	function get_karyawan()
	{
		$this->db->order_by('id');
		return $this->db->get('admin');
	}
	
}

/* End of file klinik.php */
/* Location: ./application/controllers/klinik.php */