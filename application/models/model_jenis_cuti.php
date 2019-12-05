<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jenis_cuti extends CI_Model {

	var $table = 'kg_jenis_cuti';
	
	function get_cuti()
	{
		$this->db->order_by('id_jenis_cuti');
		return $this->db->get('jenis_cuti');
	}


}

/* End of file klinik.php */
/* Location: ./application/controllers/klinik.php */