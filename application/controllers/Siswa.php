<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller {

    function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect("welcome");
		}
	}

    public function index(){
        $data['title'] = "Halaman Nilai Siswa";
        $data['siswa'] = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id_siswa')])->row_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $ta = $data['thn_ajaran']['thn_ajaran'];
        $siswa = $data['siswa']['id_siswa'];
        $data['nila'] = $this->db->query("SELECT n.*, s.* FROM nilai n, siswa s WHERE n.id_siswa = s.id_siswa AND n.id_siswa='$siswa'
                        AND n.thn_ajaran='$ta'")->row_array();
        $data['nilai'] = $this->db->query("SELECT n.*, s.*, m.* FROM nilai n, siswa s, mapel m WHERE n.id_siswa = s.id_siswa AND n.id_mapel = m.id_mapel AND n.id_siswa='$siswa'
                        AND n.thn_ajaran='$ta'")->result_array();
        $this->load->view('v_siswa/templates_siswa/header',$data);
        $this->load->view('v_siswa/templates_siswa/topbar');
        $this->load->view('v_siswa/index');
        $this->load->view('templates/footer');
    }
}