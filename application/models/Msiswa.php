<?php

class Msiswa extends CI_Model{

    public function get_guru(){
        return $this->db->get('guru');
    }
    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }
    public function get_where($table, $where)
	{
		return $this->db->get_where($table, $where);
	}
    public function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function update($table, $data)
	{
		$this->db->update($table, $data);
	}
}