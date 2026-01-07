<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

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
     * List riwayat pembelian pelanggan
     */
    public function index()
    {
        $data['title'] = 'Riwayat Pembelian Pelanggan';
        $data['current_page'] = 'pelanggan';
        
        // Ambil semua penjualan dengan data pelanggan
        // Diurutkan berdasarkan FIFO (First In First Out) - yang masuk pertama di atas
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan, pelanggan.Alamat, pelanggan.NomorTelepon');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'pelanggan.PelangganID = penjualan.PelangganID', 'left');
        $this->db->where('penjualan.PelangganID IS NOT NULL');
        $this->db->order_by('penjualan.TanggalPenjualan', 'ASC');
        $data['riwayats'] = $this->db->get()->result();
        
        // Dapatkan halaman dari URL, default 1
        $data['page'] = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        
        $data['content'] = 'pelanggan/index';
        $this->load->view('layouts/sidebar', $data);
    }
    
    /**
     * Detail penjualan pelanggan
     */
    public function detail($id)
    {
        $data['title'] = 'Detail Penjualan';
        $data['current_page'] = 'pelanggan';
        
        // Ambil data penjualan
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan, pelanggan.Alamat, pelanggan.NomorTelepon');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'pelanggan.PelangganID = penjualan.PelangganID', 'left');
        $this->db->where('penjualan.PenjualanID', $id);
        $data['penjualan'] = $this->db->get()->row();
        
        if (!$data['penjualan']) {
            $this->session->set_flashdata('error', 'Data penjualan tidak ditemukan');
            redirect('pelanggan');
        }
        
        // Ambil detail penjualan (menggunakan LEFT JOIN agar tetap bisa mengakses produk yang sudah di-delete)
        $this->db->select('detailpenjualan.*, produk.NamaProduk, produk.Harga');
        $this->db->from('detailpenjualan');
        $this->db->join('produk', 'produk.ProdukID = detailpenjualan.ProdukID', 'left');
        $this->db->where('detailpenjualan.PenjualanID', $id);
        $data['details'] = $this->db->get()->result();
        
        $data['content'] = 'pelanggan/detail';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Get Detail via AJAX
     */
    public function getDetail($id)
    {
        // Ambil data penjualan
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan, pelanggan.Alamat, pelanggan.NomorTelepon');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'pelanggan.PelangganID = penjualan.PelangganID', 'left');
        $this->db->where('penjualan.PenjualanID', $id);
        $penjualan = $this->db->get()->row();
        
        if (!$penjualan) {
            echo '<div class="alert alert-danger">Data penjualan tidak ditemukan</div>';
            return;
        }
        
        // Ambil detail penjualan (menggunakan LEFT JOIN agar tetap bisa mengakses produk yang sudah di-delete)
        $this->db->select('detailpenjualan.*, produk.NamaProduk, produk.Harga');
        $this->db->from('detailpenjualan');
        $this->db->join('produk', 'produk.ProdukID = detailpenjualan.ProdukID', 'left');
        $this->db->where('detailpenjualan.PenjualanID', $id);
        $details = $this->db->get()->result();
        
        // Render view tanpa layout
        $data['penjualan'] = $penjualan;
        $data['details'] = $details;
        $this->load->view('pelanggan/detail', $data);
    }

    /**
     * Form tambah pelanggan
     */
    public function create()
    {
        $data['title'] = 'Tambah Pelanggan';
        $data['current_page'] = 'pelanggan';
        $data['content'] = 'pelanggan/create';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses tambah pelanggan
     */
    public function store()
    {
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pelanggan/create');
        } else {
            $data = array(
                'NamaPelanggan' => $this->input->post('nama_pelanggan'),
                'Alamat' => $this->input->post('alamat'),
                'NomorTelepon' => $this->input->post('nomor_telepon')
            );

            if ($this->db->insert('pelanggan', $data)) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan');
                redirect('pelanggan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan');
                redirect('pelanggan/create');
            }
        }
    }

    /**
     * Form edit pelanggan
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Pelanggan';
        $data['current_page'] = 'pelanggan';
        $data['pelanggan'] = $this->db->where('PelangganID', $id)->get('pelanggan')->row();
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('pelanggan');
        }
        
        $data['content'] = 'pelanggan/edit';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses update pelanggan
     */
    public function update($id)
    {
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pelanggan/edit/' . $id);
        } else {
            $data = array(
                'NamaPelanggan' => $this->input->post('nama_pelanggan'),
                'Alamat' => $this->input->post('alamat'),
                'NomorTelepon' => $this->input->post('nomor_telepon')
            );

            if ($this->db->where('PelangganID', $id)->update('pelanggan', $data)) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil diupdate');
                redirect('pelanggan');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate pelanggan');
                redirect('pelanggan/edit/' . $id);
            }
        }
    }

    /**
     * Hapus pelanggan
     */
    public function delete($id)
    {
        if ($this->db->where('PelangganID', $id)->delete('pelanggan')) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pelanggan');
        }
        
        redirect('pelanggan');
    }
}

