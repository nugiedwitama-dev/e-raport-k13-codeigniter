<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['siswa'] = $this->Admin_model->sum_siswa();
        $data['guru'] = $this->Admin_model->sum_guru();
        $data['tuntas'] = $this->Admin_model->sum_db_tuntas();
        $data['tdk_tuntas'] = $this->Admin_model->sum_db_tdk_tuntas();
        $data['nilai'] = $this->db->query("SELECT n.*, s.*, m.* FROM nilai n, siswa s, mapel m WHERE n.id_siswa = s.id_siswa AND n.id_mapel = m.id_mapel ORDER BY id DESC LIMIT 5")->result();
        $data['tdk'] = $this->db->query("SELECT n.*, s.*, m.* FROM nilai n, siswa s, mapel m WHERE n.id_siswa = s.id_siswa AND n.ket='Tidak Tuntas' AND n.id_mapel = m.id_mapel ORDER BY id DESC LIMIT 5")->result();
        $data['tuntas_tb'] = $this->db->query("SELECT n.*, s.*, m.* FROM nilai n, siswa s, mapel m WHERE n.id_siswa = s.id_siswa AND n.ket='Tuntas' AND n.id_mapel = m.id_mapel ORDER BY id DESC LIMIT 5")->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
        Akses berubah!</div>');
    }

    public function user_akses() {
        $data['title'] = 'User Akses';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user_akses', $data);
        $this->load->view('templates/footer');
    }

    public function user_akses_update($id){
        $data['title'] = 'Update User Akses';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user_akses'] = $this->db->query("select * from user where id='$id'")->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user_akses_update', $data);
        $this->load->view('templates/footer');
    }

    public function update_user_akses_aksi(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $password = $this->input->post('password');
        $data = array(
            'name' => $name,
            'email' => $email,
            'alamat' => $alamat,
            'no_telp' => $no_telp,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );
        $where = array(
            'id' => $id
        );
        $this->Admin_model->update_user_akses_data($where,$data,'user');
        $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data user akses berhasil di update
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('admin/user_akses'); 
    }   

    public function user_akses_delete($id){
        $where = array('id' => $id);
        $this->Admin_model->hapus_user_akses_data($where,'user');
        $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Data user akses berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('admin/user_akses');
    }
    public function siswa(){
        $data['title'] = 'Siswa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['siswa'] = $this->db->get('siswa')->result_array();
		$data['kelas'] = $this->db->get('wali_kelas')->result_array();
        // Mengenerate ID Siswa
        $kode_terakhir = $this->Admin_model->getMax('siswa', 'id_siswa');
        $kode_tambah = substr($kode_terakhir, -6, 6);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 2, '0', STR_PAD_LEFT);
        $data['id_siswa'] = $number;
		$this->form_validation->set_rules('nama', 'Nama Siswa', 'required|trim', ['required' => 'Nama Siswa wajib di isi!.']);
		$this->form_validation->set_rules('password', 'Password Siswa', 'required|trim', ['required' => 'Password Siswa wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('alamat', 'Kelas', 'required|trim', ['required' => 'Alamat wajib di isi!.']);
		$this->form_validation->set_rules('telp', 'Kelas', 'required|trim', ['required' => 'Telp wajib di isi!.']);
		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/siswa/index', $data);
            $this->load->view('templates/footer');
		} else {
            $id_siswa = $this->input->post('id_siswa');
            $password = $this->input->post('password');
            $nis = $this->input->post('nis');
            $nama = $this->input->post('nama');
            $kelas = $this->input->post('kelas');
            $alamat = $this->input->post('alamat');
            $telp = $this->input->post('telp');
			$data = [
				'id_siswa' => $id_siswa,
				'password' => $password,
				'nis' => $nis,
				'nama' => $nama,
				'kelas' => $kelas,
				'alamat' => $alamat,
				'telp' => $telp,
			];


			// tambah data siswa
			$tbSiswa = $this->db->insert('siswa', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Siswa Berhasil Ditambahkan.</div>');
			redirect('admin/siswa');
        }
    }
    public function ubahSiswa($id)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$where = ['id_siswa' => $id];
		$data['siswa'] = $this->Admin_model->get_where('siswa', $where)->row_array();
		$data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['title'] = 'Ubah Data Siswa ';

		// Rules Form
		$this->form_validation->set_rules('nama', 'Nama Siswa', 'required|trim', ['required' => 'Nama Siswa wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => 'Alamat wajib di isi!.']);
		$this->form_validation->set_rules('telp', 'Telp', 'required|trim', ['required' => 'Telp wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/siswa/update', $data);
            $this->load->view('templates/footer');
		} else {
			$this->ubahDataSiswa();
		}

	}

	public function ubahDataSiswa()
	{
		$idSiswa = $this->input->post('id_siswa');
        $password = $this->input->post('password');
        $nis = $this->input->post('nis');
        $nama = $this->input->post('nama');
        $kelas = $this->input->post('kelas');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
		$data = [
			'password' => $password,
			'nis' => $nis,
			'nama' => $nama,
			'kelas' => $kelas,
			'alamat' => $alamat,
			'telp' => $telp
		];
		$this->db->where('id_siswa', $idSiswa);
		$this->Admin_model->update('siswa', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Siswa Berhasil Diubah.</div>');
		redirect('admin/siswa');
	}

	public function hapus_siswa($id)
	{
		$this->db->delete('siswa', ['id_siswa' => $id]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Siswa Berhasil Dihapus.</div>');
		redirect('admin/siswa');
	}
    public function guru(){
        $data['title'] = 'Guru';
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['guru'] = $this->Admin_model->get_guru('guru')->result_array();
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/guru/index', $data);
            $this->load->view('templates/footer');
		} else {
			$data = [
				'nama_guru' => html_escape($this->input->post('nama', true)),
				'whatsapp' => html_escape($this->input->post('whatsapp', true)),
			];
			$this->Admin_model->insert('guru', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Guru Berhasil Ditambahkan.</div>');
			redirect('admin/guru');
		}
    }
    public function sendwa($id_guru){
        $query = $this->db->query("SELECT * from guru WHERE id_guru='$id_guru'");
		
        if($query->num_rows() > 0) {
            $result = $query->result(); 
            foreach( $result as $row)
            {
        $tanggal = tanggal();
        $target = "$row->whatsapp|$row->nama_guru|$tanggal";
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => 'Informasi! Per Tanggal {var1}, Guru dengan nama {name} Belum Input Nilai Raport, Mohon segera input nilai di sistem, Terimakasih', 
            'delay' => '2', 
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: vR6GidYJFKSIfq37+IXq' //change TOKEN to your actual token
        ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            Notifikasi berhasil terkirim!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('admin/guru');
        }
      }
    }
    public function getguruid()
	{
		echo json_encode($this->Admin_model->getGuruId($_POST['id']));
	}
    public function ubahGuru($id)
	{
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$where = ['id_guru' => $id];
		$data['guru'] = $this->Admin_model->get_where('guru', $where)->row_array();
		$data['title'] = 'Ubah Data Guru ' . $data['guru']['nama_guru'];
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/guru/update', $data);
            $this->load->view('templates/footer');
		} else {
			$this->ubahDataGuru();
			
		}
	}
    public function ubahDataGuru()
	{
		$idGuru = $this->input->post('id_guru');
		$data = [
			'nama_guru' => html_escape($this->input->post('nama', true)),
			'whatsapp' => html_escape($this->input->post('whatsapp', true))
		];
		$this->db->where('id_guru', $idGuru);
		$this->Admin_model->update('guru', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Guru Berhasil Diubah.</div>');
		redirect('admin/guru');
	}
    public function guru_delete($id){
        
        $this->db->delete('guru', ['id_guru' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Guru Berhasil Dihapus.</div>');
        redirect('admin/guru');
        
    }
    public function kelas()
    {
        $data['title'] = 'Kelas';
        $data['current_page'] = 'kelas';
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['guruWali'] = $this->Admin_model->get_join_guru('guru', 'wali_kelas')->result_array();
		$data['guru'] = $this->Admin_model->get_guru('guru')->result_array();
		$this->form_validation->set_rules('nama', 'Nama Wali Kelas', 'required|trim', ['required' => 'Nama Wali Kelas wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelas/index', $data);
            $this->load->view('templates/footer');
		} else {
			$data = [
				'kelas' => html_escape($this->input->post('kelas', true)),
				'id_guru' => html_escape($this->input->post('nama', true))
			];
			$this->Admin_model->insert('wali_kelas', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Ditambahkan.</div>');
			redirect('admin/kelas');
		}
    }
    public function ubahKelas($id_kelas)
    {
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['current_page'] = 'kelas';
		$data['guruWali'] = $this->db->query("select * from wali_kelas where id_kelas='$id_kelas'")->row_array();
		$data['guru'] = $this->db->get('guru')->result_array();
		$data['title'] = 'Ubah Data Kelas ';
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kelas/update', $data);
            $this->load->view('templates/footer');
		} else {
			$this->ubahDataKelas();
		}
    }
    public function ubahDataKelas()
	{
		$kelas = $this->input->post('kelas');
		$data = [
			'id_guru' => html_escape($this->input->post('nama', true))
		];
		$this->db->where('kelas', $kelas);
		$this->Admin_model->update('wali_kelas', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Diubah.</div>');
		redirect('admin/kelas');
	}

	public function hapusKelas($id_kelas)
	{
		$this->db->delete('wali_kelas', ['id_kelas' => $id_kelas]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Wali Kelas Berhasil Dihapus.</div>');
		redirect('admin/kelas');
	}
    public function mapel(){
        $data['title'] = 'Mata Pelajaran';
        $data['current_page'] = 'mapel';
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['mapel'] = $this->Admin_model->get_join_mapel('mapel', 'guru')->result_array();
		$data['guru'] = $this->Admin_model->get_guru('guru')->result_array();
		$this->form_validation->set_rules('mapel', 'Mata Pelajaran', 'required|trim', ['required' => 'Mata Pelajaran wajib di isi!.']);
		$this->form_validation->set_rules('skk', 'SKK', 'required|trim', ['required' => 'SKK wajib di isi!.']);
		$this->form_validation->set_rules('kkm', 'KKM', 'required|trim', ['required' => 'KKM wajib di isi!.']);
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/mapel/index', $data);
            $this->load->view('templates/footer');
		} else {
			$data = [
				'mata_pelajaran' => html_escape($this->input->post('mapel', true)),
				'skk' => html_escape($this->input->post('skk', true)),
				'kkm' => html_escape($this->input->post('kkm', true)),
				'id_guru' => html_escape($this->input->post('nama', true))
			];
			$this->Admin_model->insert('mapel', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Ditambahkan.</div>');
			redirect('admin/mapel');
		}
    }
    public function ubahMapel($id_mapel)
    {
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['current_page'] = 'mapel';
		$data['mapel'] = $this->db->query("select * from mapel where id_mapel='$id_mapel'")->row_array();
		$data['guru'] = $this->db->get('guru')->result_array();
		$data['title'] = 'Ubah Data Mata Pelajaran';
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/mapel/update', $data);
            $this->load->view('templates/footer');
		} else {
			$this->ubahDataMapel();
		}
    }
    public function ubahDataMapel(){
        {
            $mapel = $this->input->post('id_mapel');
            $data = [
                'mata_pelajaran' => html_escape($this->input->post('mapel', true)),
                'skk' => html_escape($this->input->post('skk', true)),
                'kkm' => html_escape($this->input->post('kkm', true)),
                'id_guru' => html_escape($this->input->post('nama', true))
            ];
            $this->db->where('id_mapel', $mapel);
            $this->Admin_model->update('mapel', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Mata Pelajaran Berhasil Diubah.</div>');
            redirect('admin/mapel');
        }
    }
    public function hapusMapel($id_mapel)
	{
		$this->db->delete('mapel', ['id_mapel' => $id_mapel]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Wali Kelas Berhasil Dihapus.</div>');
		redirect('admin/mapel');
    }
    public function thn_ajaran(){
        $data['title'] = 'Tahun Ajaran Saat Ini';
        $data['current_page'] = 'thn_ajaran';
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['thn_ajaran'] = $this->db->get('tahun_ajaran')->result_array();
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('semester', 'Semester', 'required|trim', ['required' => 'Semester wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/thn_ajaran/index', $data);
            $this->load->view('templates/footer');
		} else {
			$data = [
				'thn_ajaran' => html_escape($this->input->post('thn_ajaran', true)),
				'semester' => html_escape($this->input->post('semester', true))
			];
			$this->db->update('tahun_ajaran',$data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Tahun Ajaran Berhasil Ditambahkan.</div>');
			redirect('admin/thn_ajaran');
        }
    }
    public function nilai(){
        $data['title'] = 'Data Nilai';
        $data['current_page'] = 'nilai';
        $data['siswa'] = $this->db->get('siswa')->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from filter_nilai')->row_array();
        $data['tahun_ajaran'] = $this->db->query('select tahun_ajaran from filter_nilai')->row_array();
        $data['id_kelas'] = $this->db->query('select kelas from filter_nilai')->row_array();
        $mp = $data['id_mapel']['id_mapel'];
        $ta = $data['tahun_ajaran']['tahun_ajaran'];
        $k = $data['id_kelas']['kelas'];
        $data['get_guru'] = $this->db->query("select m.*, g.nama_guru from mapel m , guru g where m.id_mapel='$mp' and m.id_guru = g.id_guru")->row_array();
        $data['thn_ajar'] = $this->db->get('tahun_ajaran')->result_array();
        $data['guru'] = $this->db->get('guru')->result_array();
        $data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['nila'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_mapel = '$mp'
            and n.thn_ajaran = '$ta' and n.kelas = '$k'")->row_array();
		$data['nilai'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_mapel = '$mp'
            and n.thn_ajaran = '$ta' and n.kelas = '$k'")->result_array();
        $data['tuntas'] = $this->db->query("select count(ket) from nilai where ket='Tuntas'")->result();
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required|trim', ['required' => 'Siswa wajib di isi!.']);
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|trim', ['required' => 'Mapel wajib di isi!.']);
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('id_guru', 'Guru', 'required|trim', ['required' => 'Guru wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/nilai/index', $data);
            $this->load->view('templates/footer');
		} else {
			$data = [
				'id_siswa' => html_escape($this->input->post('id_siswa', true)),
				'id_mapel' => html_escape($this->input->post('id_mapel', true)),
				'thn_ajaran' => html_escape($this->input->post('thn_ajaran', true)),
				'id_guru' => html_escape($this->input->post('id_guru', true)),
				'kelas' => html_escape($this->input->post('kelas', true))
			];
			$this->db->insert('nilai',$data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Nilai Berhasil Ditambahkan.</div>');
			redirect('admin/nilai');
        }
    }
    public function inputNilai($id)
    {
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['current_page'] = 'nilai';
		$data['nilai'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and id='$id'")->row_array();
		$data['title'] = "Input Data Nilai Siswa ".$data['nilai']['nama']." Mata Pelajaran ".$data['nilai']['mata_pelajaran'];
        $this->form_validation->set_rules('1', 'Nilai T&TM ', 'required|trim', ['required' => 'Nilai T&TM  wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/nilai/input', $data);
            $this->load->view('templates/footer');
		} else {
			$this->inputDataNilai();
		}
    }
    public function inputDataNilai(){
    {        
        $id = $this->input->post('id');
        $satu = $this->input->post('1');
        $dua = $this->input->post('2');
        $tiga = $this->input->post('3');
        $empat = $this->input->post('4');
        $lima = $this->input->post('5');
        $jumlah_tm = $satu+$dua+$tiga+$empat+$lima;
        $rata_tm = $jumlah_tm/5;
        $nilai_mandiri = $this->input->post('mandiri');
        $uts = $this->input->post('uts');
        $jumlah_rata = $satu+$dua+$tiga+$empat+$lima+$nilai_mandiri+$uts;
        $rata_rata = $jumlah_rata/7;
        $nilai_smt = $this->input->post('nilai_smt');
        $sikap = $this->input->post('sikap');
        $nilai_raport = $this->input->post('nilai_raport');
        $jumlah = $satu+$dua+$tiga+$empat+$lima+$nilai_mandiri+$uts+$nilai_smt+$nilai_raport;
        $ket = $this->input->post('ket');
        $data = [
            'nilai_tm_1' => $satu,
            'nilai_tm_2' => $dua,
            'nilai_tm_3' => $tiga,
            'nilai_tm_4' => $empat,
            'nilai_tm_5' => $lima,
            'rata_rata_tm' => $rata_tm,
            'nilai_mandiri' => $nilai_mandiri,
            'uts' => $uts,
            'rata_rata_tm_uts' => $rata_rata,
            'nilai_smt' => $nilai_smt,
            'sikap' => $sikap,
            'nilai_raport' => $nilai_raport,
            'jumlah' => $jumlah,
            'ket' => $ket,
        ];
        $where = [
             'id' => $id,
         ];
         $this->Admin_model->update_data($where,$data,'nilai');
         $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Nilai Berhasil Diubah.</div>');
         redirect('admin/nilai');
        }
    }
    public function hapus_nilai($id)
	{
		$this->db->delete('nilai', ['id' => $id]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Nilai Berhasil Dihapus.</div>');
		redirect('admin/nilai');
    }
    public function filter_nilai(){
        $data['title'] ='Filter Nilai';
        $data['mapel'] = $this->db->query('select * from mapel')->result();
        $data['semester'] = $this->db->query('select * from tahun_ajaran')->result_array();
        $data['kelas'] = $this->db->query('select * from wali_kelas')->result_array();
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/nilai/filter', $data);
        $this->load->view('templates/footer');
    }
    public function filter_nilai_set(){
        $data = [
            'id_mapel' => html_escape($this->input->post('id_mapel', true)),
            'tahun_ajaran' => html_escape($this->input->post('smt', true)),
            'kelas' => html_escape($this->input->post('kelas', true))
        ];
        $this->db->update('filter_nilai',$data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Filter data nilai berhasil.</div>');
        redirect('admin/nilai');
    }
    public function cetak_nilai(){
        $data['title'] = 'Data Nilai';
        $data['current_page'] = 'nilai';
        $data['siswa'] = $this->db->get('siswa')->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from filter_nilai')->row_array();
        $data['tahun_ajaran'] = $this->db->query('select tahun_ajaran from filter_nilai')->row_array();
        $data['id_kelas'] = $this->db->query('select kelas from filter_nilai')->row_array();
        $mp = $data['id_mapel']['id_mapel'];
        $ta = $data['tahun_ajaran']['tahun_ajaran'];
        $k = $data['id_kelas']['kelas'];
        $data['get_guru'] = $this->db->query("select m.*, g.nama_guru from mapel m , guru g where m.id_mapel='$mp' and m.id_guru = g.id_guru")->row_array();
        $data['thn_ajar'] = $this->db->get('tahun_ajaran')->result_array();
        $data['guru'] = $this->db->get('guru')->result_array();
        $data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['nila'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_mapel = '$mp'
            and n.thn_ajaran = '$ta' and n.kelas = '$k'")->row_array();
		$data['nilai'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_mapel = '$mp'
            and n.thn_ajaran = '$ta' and n.kelas = '$k'")->result_array();
        $data['get'] = $this->db->query("select * from nilai where ket='Tuntas'")->row();
        $where = $mp;
        $data['tuntas'] = $this->Admin_model->sum_tuntas($where);
        $data['tdk_tuntas'] = $this->Admin_model->sum_tdk_tuntas($where);
        $data['jml'] = $this->Admin_model->sum_jml_siswa($where);
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required|trim', ['required' => 'Siswa wajib di isi!.']);
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|trim', ['required' => 'Mapel wajib di isi!.']);
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('id_guru', 'Guru', 'required|trim', ['required' => 'Guru wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/nilai/cetak', $data);
		} else {
			$data = [
				'id_siswa' => html_escape($this->input->post('id_siswa', true)),
				'id_mapel' => html_escape($this->input->post('id_mapel', true)),
				'thn_ajaran' => html_escape($this->input->post('thn_ajaran', true)),
				'id_guru' => html_escape($this->input->post('id_guru', true)),
				'kelas' => html_escape($this->input->post('kelas', true))
			];
			$this->db->insert('nilai',$data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Nilai Berhasil Ditambahkan.</div>');
			redirect('admin/nilai');
        }
    }
    public function raport(){
        $data['title'] ='Raport';
        $data['siswa'] = $this->db->query('select * from siswa')->result();
        $data['semester'] = $this->db->query('select * from tahun_ajaran')->result_array();
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/raport/index', $data);
        $this->load->view('templates/footer');
    }
    public function raport_set(){
        $data = [
            'id_siswa' => html_escape($this->input->post('id_siswa', true)),
            'thn_ajaran' => html_escape($this->input->post('smt', true))
        ];
        $this->db->update('idraport',$data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Raport Berhasil Diubah.</div>');
        redirect('admin/raport_show');
    }
    public function raport_show(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['siswa'] = $this->db->get('siswa')->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $data['thn_ajar'] = $this->db->get('tahun_ajaran')->result_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $data['guru'] = $this->db->get('guru')->result_array();
        $data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];

		$data['nila'] = $this->db->query("select s.id_siswa,s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran' and n.id_mapel='$mapel'")->row_array();
		$data['raport'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->result_array();
            
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required|trim', ['required' => 'Siswa wajib di isi!.']);
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|trim', ['required' => 'Mapel wajib di isi!.']);
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/raport/show', $data);
        $this->load->view('templates/footer');
    }
    public function cetak_raport(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['siswa'] = $this->db->get('siswa')->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $data['thn_ajar'] = $this->db->get('tahun_ajaran')->result_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $data['guru'] = $this->db->get('guru')->result_array();
        $data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
		$data['nila'] = $this->db->query("select s.id_siswa,s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran' and n.id_mapel='$mapel'")->row_array();
		$data['raport'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->result_array();
		$data['footer'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->row_array();    
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required|trim', ['required' => 'Siswa wajib di isi!.']);
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|trim', ['required' => 'Mapel wajib di isi!.']);
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_raport', $data);
    }
    public function cetak_cover(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
        $data['cover'] = $this->db->query("select s.nama,s.nis,s.id_siswa,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
        n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
        where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
        and n.thn_ajaran='$thn_ajaran'")->row_array(); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_cover', $data);
    }
    public function cetak_biodata(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
        $data['bio'] = $this->db->query("select s.nama,s.nis,s.id_siswa,s.alamat, s.telp,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
        n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
        where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
        and n.thn_ajaran='$thn_ajaran'")->row_array(); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_biodata', $data);
    }
    public function cetak_kompetensi(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
        $data['kompetensi'] = $this->db->query("select s.nama,s.nis,s.id_siswa,s.alamat, s.telp,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
        n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
        where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
        and n.thn_ajaran='$thn_ajaran'")->result_array(); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_kompetensi', $data);
    }
    public function cetak_pengembangan_diri(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
        $data['nila'] = $this->db->query("select s.nama,s.nis,s.id_siswa,s.alamat, s.telp,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
        n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
        where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
        and n.thn_ajaran='$thn_ajaran'")->row_array(); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_pengembangan_diri', $data);
    }
    public function cetak_full_raport(){
        $data['title'] = 'Data Raport';
        $data['current_page'] = 'raport';
        $data['siswa'] = $this->db->get('siswa')->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['thn_ajaran'] = $this->db->get('tahun_ajaran')->row_array();
        $data['thn_ajar'] = $this->db->get('tahun_ajaran')->result_array();
        $data['id_siswa'] = $this->db->query('select id_siswa from idraport')->row_array();
        $data['id_mapel'] = $this->db->query('select id_mapel from idraport')->row_array();
        $data['kelaz'] = $this->db->query('select kelas from idraport')->row_array();
        $data['thn_ajaran_where'] = $this->db->query('select thn_ajaran from idraport')->row_array();
        $data['guru'] = $this->db->get('guru')->result_array();
        $data['kelas'] = $this->db->get('wali_kelas')->result_array();
		$data['user'] = $this->Admin_model->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $siswa = $data['id_siswa']['id_siswa'];
        $mapel = $data['id_mapel']['id_mapel'];
        $kelas = $data['kelaz']['kelas'];
        $thn_ajaran = $data['thn_ajaran_where']['thn_ajaran'];
		$data['nila'] = $this->db->query("select s.id_siswa,s.nama,s.nis,m.mata_pelajaran,m.kkm,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran' and n.id_mapel='$mapel'")->row_array();
		$data['raport'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->result_array();
		$data['footer'] = $this->db->query("select s.nama,s.nis,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->row_array();  
        $data['cover'] = $this->db->query("select s.nama,s.nis,s.id_siswa,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->row_array(); 
        $data['bio'] = $this->db->query("select s.nama,s.nis,s.id_siswa,s.alamat, s.telp,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->row_array(); 
        $data['kompetensi'] = $this->db->query("select s.nama,s.nis,s.id_siswa,s.alamat, s.telp,m.mata_pelajaran,m.kkm,m.skk,t.thn_ajaran,t.semester,k.kelas, g.nama_guru,n.id,n.nilai_tm_1,n.nilai_tm_2,n.nilai_tm_3, n.nilai_tm_4,
            n.nilai_tm_5,n.rata_rata_tm,n.nilai_mandiri,n.uts,n.rata_rata_tm_uts,n.nilai_smt,n.sikap,n.nilai_raport,n.ket from siswa s, mapel m, tahun_ajaran t, wali_kelas k, guru g, nilai n
            where s.id_siswa = n.id_siswa and m.id_mapel = n.id_mapel and t.thn_ajaran = n.thn_ajaran and k.kelas = n.kelas and g.id_guru = n.id_guru and n.id_siswa='$siswa' and n.kelas='$kelas'
            and n.thn_ajaran='$thn_ajaran'")->result_array();   
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required|trim', ['required' => 'Siswa wajib di isi!.']);
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|trim', ['required' => 'Mapel wajib di isi!.']);
		$this->form_validation->set_rules('thn_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
        $this->load->view('templates/header', $data);
        $this->load->view('admin/raport/cetak_full_raport', $data);
    }
}
