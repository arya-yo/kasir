<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

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
     * Halaman transaksi penjualan
     */
    public function index()
    {
        $this->load->library('pagination');
        
        $data['title'] = 'Transaksi Penjualan';
        $data['current_page'] = 'penjualan';
        
        // Search produk
        $search = $this->input->get('search');
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $per_page = 10; // LIMIT TAMPILAN PRODUK: 10 produk per halaman
        $offset = ($page - 1) * $per_page;
        
        // Query untuk menghitung total produk (untuk pagination)
        $this->db->start_cache();
        if (!empty($search)) {
            $this->db->like('NamaProduk', $search);
        }
        $this->db->where('Stok >', 0); // Hanya produk yang ada stoknya
        $this->db->where('IsDeleted', 0); // Hanya produk yang tidak dihapus (soft delete)
        $this->db->stop_cache();
        
        $total_rows = $this->db->count_all_results('produk');
        
        // Query produk dengan pagination (LIMIT 10 per halaman)
        $this->db->limit($per_page, $offset);
        $this->db->order_by('NamaProduk', 'ASC');
        $data['produks'] = $this->db->get('produk')->result();
        $this->db->flush_cache();
        
        // Pagination config
        $config['base_url'] = site_url('penjualan');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['first_link'] = 'Pertama';
        $config['last_link'] = 'Terakhir';
        $config['next_link'] = 'Selanjutnya';
        $config['prev_link'] = 'Sebelumnya';
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $total_rows;
        $data['page'] = $page;
        $data['total_pages'] = ceil($total_rows / $per_page);
        $data['search'] = $search;
        
        $data['content'] = 'penjualan/index';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * Proses transaksi penjualan dengan data pelanggan
     */
    public function proses()
    {
        $produk_ids = $this->input->post('produk_id');
        $jumlahs = $this->input->post('jumlah');
        
        // Data pelanggan dari popup
        $nama_pelanggan = $this->input->post('nama_pelanggan');
        $alamat = $this->input->post('alamat');
        $nomor_telepon = $this->input->post('nomor_telepon');

        if (empty($produk_ids) || !is_array($produk_ids)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu produk');
            redirect('penjualan');
        }

        // Validasi data pelanggan
        if (empty($nama_pelanggan)) {
            $this->session->set_flashdata('error', 'Nama pelanggan harus diisi');
            redirect('penjualan');
        }

        // Validasi stok dan hitung total
        $total_harga = 0;
        $items = array();

        foreach ($produk_ids as $index => $produk_id) {
            $jumlah = isset($jumlahs[$index]) ? (int)$jumlahs[$index] : 0;
            
            if ($jumlah <= 0) continue;

            $produk = $this->db->where('ProdukID', $produk_id)
                               ->where('IsDeleted', 0) // Hanya produk yang tidak dihapus
                               ->get('produk')->row();
            
            if (!$produk) {
                $this->session->set_flashdata('error', 'Produk tidak ditemukan atau sudah dihapus');
                redirect('penjualan');
            }

            if ($produk->Stok < $jumlah) {
                $this->session->set_flashdata('error', 'Stok ' . $produk->NamaProduk . ' tidak mencukupi');
                redirect('penjualan');
            }

            $subtotal = $produk->Harga * $jumlah;
            $total_harga += $subtotal;

            $items[] = array(
                'produk' => $produk,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal
            );
        }

        if (empty($items)) {
            $this->session->set_flashdata('error', 'Tidak ada item yang dipilih');
            redirect('penjualan');
        }

        // Mulai transaksi
        $this->db->trans_start();

        // Insert atau update pelanggan
        $pelanggan = $this->db->where('NamaPelanggan', $nama_pelanggan)->get('pelanggan')->row();
        
        if ($pelanggan) {
            // Update pelanggan jika sudah ada
            $pelanggan_data = array(
                'Alamat' => $alamat,
                'NomorTelepon' => $nomor_telepon
            );
            $this->db->where('PelangganID', $pelanggan->PelangganID)->update('pelanggan', $pelanggan_data);
            $pelanggan_id = $pelanggan->PelangganID;
        } else {
            // Insert pelanggan baru
            $pelanggan_data = array(
                'NamaPelanggan' => $nama_pelanggan,
                'Alamat' => $alamat,
                'NomorTelepon' => $nomor_telepon
            );
            $this->db->insert('pelanggan', $pelanggan_data);
            $pelanggan_id = $this->db->insert_id();
        }

        // Insert penjualan
        $penjualan_data = array(
            'TanggalPenjualan' => date('Y-m-d'),
            'TotalHarga' => $total_harga,
            'PelangganID' => $pelanggan_id
        );
        $this->db->insert('penjualan', $penjualan_data);
        $penjualan_id = $this->db->insert_id();

        // Insert detail penjualan dan update stok
        foreach ($items as $item) {
            // Insert detail
            $detail_data = array(
                'PenjualanID' => $penjualan_id,
                'ProdukID' => $item['produk']->ProdukID,
                'JumlahProduk' => $item['jumlah'],
                'Subtotal' => $item['subtotal']
            );
            $this->db->insert('detailpenjualan', $detail_data);

            // Update stok
            $new_stok = $item['produk']->Stok - $item['jumlah'];
            $this->db->where('ProdukID', $item['produk']->ProdukID)
                     ->update('produk', array('Stok' => $new_stok));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memproses transaksi');
            redirect('penjualan');
        } else {
            $this->session->set_flashdata('success', 'Transaksi berhasil! ID Penjualan: ' . $penjualan_id);
            redirect('penjualan');
        }
    }
}

