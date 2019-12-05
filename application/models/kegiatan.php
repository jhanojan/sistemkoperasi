<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan extends CI_Model {

	var $table = 'kg_newkegiatan';
	
	public function getdata()
	{
		$result = $this->db->get($this->table);
		
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		return FALSE;
	}
	
	
	public function add($data)
	{
		$this->db->insert($this->table, $data);
	}

	function get_all()
	{
		$this->db->order_by('no');
		return $this->db->get($this->table);
	}

	function get_workplan_by_id($no)
	{
		return $this->db->get_where($this->table, array('no' => $no), 1)->row();
	}

	function delete($no)
	{
		$this->db->delete($this->table, array('no' => $no));
	}
	
	/**
	 * Tambah data kelas
	 */
	
	/**
	 * Update data kelas
	 */
	function update($no, $workplan)
	{
		$this->db->where('no', $no);
		$this->db->update($this->table, $workplan);
	}
	
	/**
	 * Validasi agar tidak ada kelasd dengan id ganda
	 */
	function valid_id($no)
	{
		$query = $this->db->get_where($this->table, array('no' => $no));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file klinik.php */
/* Location: ./application/controllers/klinik.php */