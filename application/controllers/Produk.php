<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation');
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * List semua produk
     */
    public function index()
    {
        $data['title'] = 'Data Produk';
        $data['current_page'] = 'produk';
        // Hanya tampilkan produk yang tidak dihapus (soft delete)
        $data['produks'] = $this->db->where('IsDeleted', 0)->get('produk')->result();
        $data['page'] = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $data['content'] = 'produk/index';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        // Hanya admin yang bisa tambah produk
        if ($this->session->userdata('role') != 'admin') {
            redirect('produk');
        }
        
        $data['title'] = 'Tambah Produk';
        $data['current_page'] = 'produk';
        $data['content'] = 'produk/create';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses tambah produk
     */
    public function store()
    {
        // Hanya admin yang bisa tambah produk
        if ($this->session->userdata('role') != 'admin') {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki izin']);
                return;
            }
            redirect('produk');
        }
        
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|integer|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => strip_tags(validation_errors())]);
                return;
            }
            $this->session->set_flashdata('error', validation_errors());
            redirect('produk/create');
        } else {
            $data = array(
                'NamaProduk' => $this->input->post('nama_produk'),
                'Harga' => $this->input->post('harga'),
                'Stok' => $this->input->post('stok')
            );

            if ($this->db->insert('produk', $data)) {
                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Produk berhasil ditambahkan']);
                    return;
                }
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
                redirect('produk');
            } else {
                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan produk']);
                    return;
                }
                $this->session->set_flashdata('error', 'Gagal menambahkan produk');
                redirect('produk/create');
            }
        }
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        // Hanya admin yang bisa edit produk
        if ($this->session->userdata('role') != 'admin') {
            redirect('produk');
        }
        
        $data['title'] = 'Edit Produk';
        $data['current_page'] = 'produk';
        $data['produk'] = $this->db->where('ProdukID', $id)->get('produk')->row();
        
        if (!$data['produk']) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan');
            redirect('produk');
        }
        
        $data['content'] = 'produk/edit';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses update produk
     */
    public function update($id)
    {
        header('Content-Type: application/json');
        
        // Hanya admin yang bisa update produk
        if ($this->session->userdata('role') != 'admin') {
            echo json_encode([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk update produk'
            ]);
            return;
        }
        
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|integer|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }
        
        $data = array(
            'NamaProduk' => $this->input->post('nama_produk'),
            'Harga' => $this->input->post('harga'),
            'Stok' => $this->input->post('stok')
        );

        if ($this->db->where('ProdukID', $id)->update('produk', $data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Produk berhasil diupdate'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal mengupdate produk'
            ]);
        }
    }

    /**
     * Hapus produk (Soft Delete)
     */
    public function delete($id)
    {
        // Hanya admin yang bisa hapus produk
        if ($this->session->userdata('role') != 'admin') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus produk'
            ]);
            return;
        }
        
        header('Content-Type: application/json');
        
        // Cek apakah produk ada (termasuk yang sudah di-delete untuk validasi)
        $produk = $this->db->get_where('produk', ['ProdukID' => $id])->row();
        
        if (!$produk) {
            echo json_encode([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
            return;
        }
        
        // Cek apakah produk sudah dihapus sebelumnya
        if ($produk->IsDeleted == 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Produk sudah dihapus sebelumnya'
            ]);
            return;
        }
        
        // Soft delete: update IsDeleted = 1
        if ($this->db->where('ProdukID', $id)->update('produk', ['IsDeleted' => 1])) {
            echo json_encode([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus produk'
            ]);
        }
    }

    /**
     * Get Detail via AJAX
     */
    public function getDetail($id)
    {
        $produk = $this->db->where('ProdukID', $id)->get('produk')->row();
        
        if (!$produk) {
            echo '<div class="alert alert-danger">Produk tidak ditemukan</div>';
            return;
        }
        
        $data['produk'] = $produk;
        $this->load->view('produk/detail_modal', $data);
    }

    /**
     * Get Edit Form via AJAX
     */
    public function getEdit($id)
    {
        $produk = $this->db->where('ProdukID', $id)->get('produk')->row();
        
        if (!$produk) {
            echo '<div class="alert alert-danger">Produk tidak ditemukan</div>';
            return;
        }
        
        $data['produk'] = $produk;
        $this->load->view('produk/edit_modal', $data);
    }
}

