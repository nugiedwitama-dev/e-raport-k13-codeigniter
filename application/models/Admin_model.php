<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function update_user_akses_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 

    public function hapus_user_akses_data($where,$table){

        $this->db->where($where);
        $this->db->delete($table);   
    }
    public function get_guru(){
        return $this->db->get('guru');
    }
    public function get_where($table, $where)
	{
		return $this->db->get_where($table, $where);
	}
    public function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}
    public function insert_nilai($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function update($table, $data)
	{
		$this->db->update($table, $data);
	}
    public function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    public function getGuruId($idGuru)
	{
		return $this->db->get_where('guru', $idGuru)->row_array();
	}
    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }
    public function get_join_guru($table1, $table2)
	{
		$this->db->join("$table1", "$table1.id_guru = $table2.id_guru");
		return $this->db->get("$table2");
	}
    public function get_join_mapel($table1, $table2)
	{
		$this->db->join("$table1", "$table1.id_guru = $table2.id_guru");
		return $this->db->get("$table2");
	}
    public function sum_tuntas($where){
        $query = $this->db->query("select * from nilai where ket='Tuntas' and id_mapel ='$where'");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_tdk_tuntas($where){
        $query = $this->db->query("select * from nilai where ket='Tidak Tuntas' and id_mapel ='$where'");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_jml_siswa($where){
        $query = $this->db->query("select * from nilai where id_mapel ='$where'");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_siswa(){
        $query = $this->db->query("select * from siswa");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_guru(){
        $query = $this->db->query("select * from guru");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_db_tuntas(){
        $query = $this->db->query("select * from nilai where ket='Tuntas'");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
    public function sum_db_tdk_tuntas(){
        $query = $this->db->query("select * from nilai where ket='Tidak Tuntas'");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }
}