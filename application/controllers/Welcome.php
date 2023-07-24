<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{

        $this->form_validation->set_rules('id_siswa', 'Siswa', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Siswa ERaport PKBM Budi Utama';
			$data['siswa'] = $this->db->get('siswa')->result();
			$this->load->view('templates/auth_header', $data);
			$this->load->view('welcome_message',$data);
			$this->load->view('templates/auth_footer');
        } else {
            // validasinya success
            $this->_login();
        }
	} private function _login()
    {
        $id_siswa = $this->input->post('id_siswa');
	    $password = $this->input->post('password');
        $where = array(
            'id_siswa' => $id_siswa,
            'password' => $password
            );
        $cek = $this->M_login->cek_login("siswa",$where)->num_rows();
        if($cek > 0){
    
            $data_session = array(
                'id_siswa' => $id_siswa,
                'status' => "login"
                );
    
        $this->session->set_userdata($data_session);
    
        redirect("siswa");
	}else{
		echo "Id User dan password salah !";
	}
    }

    public function logout()
    {
        $this->session->sess_destroy();

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
        Anda telah Logout!</div>');
        redirect('welcome');
    }

}
