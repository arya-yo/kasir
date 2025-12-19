<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * Halaman Dashboard
     */
    public function index()
    {
        $this->load->database();
        
        $data['title'] = 'Dashboard';
        $data['current_page'] = 'dashboard';
        $data['user'] = array(
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('role')
        );
        
        // Hitung statistik untuk admin
        if ($this->session->userdata('role') == 'admin') {
            $data['total_user'] = $this->db->count_all('users');
            $data['total_produk'] = $this->db->count_all('produk');
            $data['total_penjualan'] = $this->db->count_all('penjualan');
        }
        
        $data['content'] = 'dashboard/index';
        $this->load->view('layouts/sidebar', $data);
    }
}

