<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        
        // Cek apakah user sudah login dan role admin
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    /**
     * Laporan Penjualan
     */
    public function index()
    {
        $data['title'] = 'Laporan Penjualan';
        $data['current_page'] = 'laporan';
        
        // Ambil semua penjualan dengan detail
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'pelanggan.PelangganID = penjualan.PelangganID', 'left');
        $this->db->order_by('penjualan.TanggalPenjualan', 'DESC');
        $data['penjualans'] = $this->db->get()->result();
        
        // Hitung total penjualan
        $data['total_penjualan'] = $this->db->select_sum('TotalHarga')->get('penjualan')->row()->TotalHarga ?? 0;
        
        $data['page'] = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $data['content'] = 'laporan/index';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Detail Penjualan
     */
    public function detail($id)
    {
        $data['title'] = 'Detail Penjualan';
        $data['current_page'] = 'laporan';
        
        // Ambil data penjualan
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan, pelanggan.Alamat, pelanggan.NomorTelepon');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'pelanggan.PelangganID = penjualan.PelangganID', 'left');
        $this->db->where('penjualan.PenjualanID', $id);
        $data['penjualan'] = $this->db->get()->row();
        
        if (!$data['penjualan']) {
            $this->session->set_flashdata('error', 'Data penjualan tidak ditemukan');
            redirect('laporan');
        }
        
        // Ambil detail penjualan
        $this->db->select('detailpenjualan.*, produk.NamaProduk, produk.Harga');
        $this->db->from('detailpenjualan');
        $this->db->join('produk', 'produk.ProdukID = detailpenjualan.ProdukID');
        $this->db->where('detailpenjualan.PenjualanID', $id);
        $data['details'] = $this->db->get()->result();
        
        $data['content'] = 'laporan/detail';
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
        
        // Ambil detail penjualan
        $this->db->select('detailpenjualan.*, produk.NamaProduk, produk.Harga');
        $this->db->from('detailpenjualan');
        $this->db->join('produk', 'produk.ProdukID = detailpenjualan.ProdukID');
        $this->db->where('detailpenjualan.PenjualanID', $id);
        $details = $this->db->get()->result();
        
        // Render view tanpa layout
        $data['penjualan'] = $penjualan;
        $data['details'] = $details;
        $this->load->view('laporan/detail', $data);
    }

    /**
     * Delete Penjualan
     */
    public function delete($id)
    {
        header('Content-Type: application/json');
        
        // Cek apakah data ada
        $penjualan = $this->db->get_where('penjualan', ['PenjualanID' => $id])->row();
        
        if (!$penjualan) {
            echo json_encode([
                'success' => false,
                'message' => 'Data penjualan tidak ditemukan'
            ]);
            return;
        }
        
        // Hapus detail penjualan terlebih dahulu
        $this->db->delete('detailpenjualan', ['PenjualanID' => $id]);
        
        // Hapus data penjualan
        $this->db->delete('penjualan', ['PenjualanID' => $id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Data penjualan berhasil dihapus'
        ]);
    }
}