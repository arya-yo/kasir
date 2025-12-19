<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation');
        
        // Cek apakah user sudah login dan role admin
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    /**
     * List semua user
     */
    public function index()
    {
        $data['title'] = 'Data User';
        $data['current_page'] = 'user';
        $data['users'] = $this->db->get('users')->result();
        $data['page'] = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $data['content'] = 'user/index';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        $data['title'] = 'Tambah User';
        $data['current_page'] = 'user';
        $data['content'] = 'user/create';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses tambah user
     */
    public function store()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.Username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/create');
        } else {
            $data = array(
                'Username' => $this->input->post('username'),
                'Password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'Role' => $this->input->post('role')
            );

            if ($this->db->insert('users', $data)) {
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
                redirect('user');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan user');
                redirect('user/create');
            }
        }
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['current_page'] = 'user';
        $data['user'] = $this->db->where('UserID', $id)->get('users')->row();
        
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User tidak ditemukan');
            redirect('user');
        }
        
        $data['content'] = 'user/edit';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses update user
     */
    public function update($id)
    {
        header('Content-Type: application/json');
        
        $user = $this->db->where('UserID', $id)->get('users')->row();
        
        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
            return;
        }

        // Validasi username unik jika berubah
        $username = $this->input->post('username');
        if ($username != $user->Username) {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.Username]');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
        }
        
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }
        
        $data = array(
            'Username' => $username,
            'Role' => $this->input->post('role')
        );

        // Update password jika diisi
        if ($this->input->post('password')) {
            $data['Password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        if ($this->db->where('UserID', $id)->update('users', $data)) {
            echo json_encode([
                'success' => true,
                'message' => 'User berhasil diupdate'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal mengupdate user'
            ]);
        }
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        header('Content-Type: application/json');
        
        // Jangan hapus user yang sedang login
        if ($id == $this->session->userdata('user_id')) {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak dapat menghapus user yang sedang login'
            ]);
            return;
        }

        // Cek apakah user ada
        $user = $this->db->get_where('users', ['UserID' => $id])->row();
        
        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
            return;
        }

        if ($this->db->where('UserID', $id)->delete('users')) {
            echo json_encode([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus user'
            ]);
        }
    }

    /**
     * Get Detail via AJAX
     */
    public function getDetail($id)
    {
        $user = $this->db->where('UserID', $id)->get('users')->row();
        
        if (!$user) {
            echo '<div class="alert alert-danger">User tidak ditemukan</div>';
            return;
        }
        
        $data['user'] = $user;
        $this->load->view('user/detail_modal', $data);
    }

    /**
     * Get Edit Form via AJAX
     */
    public function getEdit($id)
    {
        $user = $this->db->where('UserID', $id)->get('users')->row();
        
        if (!$user) {
            echo '<div class="alert alert-danger">User tidak ditemukan</div>';
            return;
        }
        
        $data['user'] = $user;
        $this->load->view('user/edit_modal', $data);
    }
}

