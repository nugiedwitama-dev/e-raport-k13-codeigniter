<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Manajemen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Menu baru ditambahkan!</div>');
            redirect('menu');
        }
    }
    
    public function update($id){
        $data['title'] = 'Manajemen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->query("select id, menu from user_menu where id='$id'")->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/update', $data);
        $this->load->view('templates/footer');
    }

    public function update_aksi(){
        $id = $this->input->post('id');
        $menu = $this->input->post('menu');
        $data = array(
            'menu' => $menu
        );
        $where = array(
            'id' => $id
        );
        $this->Menu_model->update_data($where,$data,'user_menu');
        $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data menu berhasil di update
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('menu'); 
    }

    public function delete($id){
        $where = array('id' => $id);
        $this->Menu_model->hapus_data($where,'user_menu');
        $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Data menu berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('menu');
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Manajemen';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Sub Menu baru ditambahkan!</div>');
            redirect('menu/submenu');
        }
    }

    public function submenu_update($id){
        $data['title'] = 'Update Sub Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['submenu'] = $this->db->query("select * from user_sub_menu where id='$id'")->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/submenu_update', $data);
        $this->load->view('templates/footer');
    }

    public function update_submenu_aksi(){
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $menu = $this->input->post('menu_id');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $is_active = $this->input->post('is_active');
        $data = array(
            'menu_id' => $menu,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $is_active
        );
        $where = array(
            'id' => $id
        );
        $this->Menu_model->update_submenu_data($where,$data,'user_sub_menu');
        $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data submenu berhasil di update
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('menu/submenu'); 
    }   

    public function submenu_delete($id){
        $where = array('id' => $id);
        $this->Menu_model->hapus_submenu_data($where,'user_sub_menu');
        $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Data submenu berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('menu/submenu');
    }
}
