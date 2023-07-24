<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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

    public function edit()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $no_telp = $this->input->post('no_telp');                    
            $alamat = $this->input->post('alamat');                    
            $name = $this->input->post('name');                    
            $email = $this->input->post('email');
    
                  // cek jika ada gambar yang akan diupload
                  $upload_image = $_FILES['image']['name'];

                  if ($upload_image) {
                      $config['allowed_types'] = 'jpg|png';
                      $config['max_size'] = '2048';
                      $config['upload_path'] = '.assets/img/profile/';

                      $this->load->library('upload', $config);

                      if ($this->upload->do_upload('image')) {
                          $old_image = $data['user']['image'];
                          if ($old_image != 'default.jpg') {
                              unlink(FCPATH . 'assets/img/profile/' . $old_image);
                          }
                          $new_image = $this->upload->data('file_name');
                          $this->db->set('image', $new_image);
                      } else {
                          echo $this->upload->display_errors();
                      }
                    }

                    $this->db->set('no_telp', $no_telp);
                    $this->db->set('alamat', $alamat);
                    $this->db->set('name', $name);
                    $this->db->where('email', $email);
                    $this->db->update('user');
  
                    $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
                    Profil Anda telah diupdate!</div>');
                    redirect('user');
         }

    }

    public function ubahPassword()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password Baru', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Konfirmasi Password', 'required|trim|min_length[6]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/ubahpassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Password lama salah!</div>');
                redirect('user/ubahpassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password baru tidak boleh sama dengan password lama!</div>');
                    redirect('user/ubahpassword');
                } else {
                    // password sudah benar
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
                    Password telah diubah!</div>');
                    redirect('user/ubahpassword');
                }
            }
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
            $this->load->view('user/nilai/index', $data);
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
			redirect('user/nilai');
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
            $this->load->view('user/nilai/input', $data);
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
         redirect('user/nilai');
        }
    }
    public function hapus_nilai($id)
	{
		$this->db->delete('nilai', ['id' => $id]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Nilai Berhasil Dihapus.</div>');
		redirect('user/nilai');
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
        $this->load->view('user/nilai/filter', $data);
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
        redirect('user/nilai');
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
            $this->load->view('user/nilai/cetak', $data);
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
			redirect('user/nilai');
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
        $this->load->view('user/raport/index', $data);
        $this->load->view('templates/footer');
    }
    public function raport_set(){
        $data = [
            'id_siswa' => html_escape($this->input->post('id_siswa', true)),
            'thn_ajaran' => html_escape($this->input->post('smt', true))
        ];
        $this->db->update('idraport',$data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Raport Berhasil Diubah</div>');
        redirect('user/raport_show');
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
        $this->load->view('user/raport/show', $data);
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
        $this->load->view('user/raport/cetak_raport', $data);
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
        $this->load->view('user/raport/cetak_cover', $data);
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
        $this->load->view('user/raport/cetak_biodata', $data);
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
        $this->load->view('user/raport/cetak_kompetensi', $data);
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
        $this->load->view('user/raport/cetak_pengembangan_diri', $data);
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
        $this->load->view('user/raport/cetak_full_raport', $data);
    }

}
