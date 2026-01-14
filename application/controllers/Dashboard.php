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
        } else if ($this->session->userdata('role') == 'petugas') {
            // Hitung statistik untuk petugas
            $data['total_penjualan'] = $this->db->count_all('penjualan');
            $data['total_pelanggan'] = $this->db->where('PelangganID IS NOT NULL', NULL, FALSE)
                                                  ->count_all_results('penjualan');
        }
        
        $data['content'] = 'dashboard/index';
        $this->load->view('layouts/sidebar', $data);
    }

    /**
     * API: Get chart data (7 hari terakhir dan top produk)
     */
    public function getChartData()
    {
        header('Content-Type: application/json');
        
        if ($this->session->userdata('role') != 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        // Get last 7 days sales
        $labels = array();
        $sales = array();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($date));
            
            $query = $this->db->select_sum('TotalHarga')
                            ->where('DATE(TanggalPenjualan)', $date)
                            ->get('penjualan');
            
            $total = $query->row()->TotalHarga ?? 0;
            $sales[] = (int)$total;
        }

        // Get top 5 products
        $product_query = $this->db->select('p.NamaProduk, SUM(dp.Qty) as total_qty', false)
                                  ->from('detail_penjualan dp')
                                  ->join('produk p', 'dp.ProdukID = p.ProdukID')
                                  ->group_by('dp.ProdukID')
                                  ->order_by('total_qty', 'DESC')
                                  ->limit(5)
                                  ->get();

        $product_labels = array();
        $product_sales = array();
        
        foreach ($product_query->result() as $row) {
            $product_labels[] = $row->NamaProduk;
            $product_sales[] = (int)$row->total_qty;
        }

        echo json_encode([
            'success' => true,
            'labels' => $labels,
            'sales' => $sales,
            'product_labels' => $product_labels,
            'product_sales' => $product_sales
        ]);
    }

    /**
     * API: Get today statistics
     */
    public function getTodayStats()
    {
        header('Content-Type: application/json');
        
        if ($this->session->userdata('role') != 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $today = date('Y-m-d');

        // Today revenue
        $revenue_query = $this->db->select_sum('TotalHarga')
                                  ->where('DATE(TanggalPenjualan)', $today)
                                  ->get('penjualan');
        $today_revenue = $revenue_query->row()->TotalHarga ?? 0;

        // Today transactions
        $transaction_query = $this->db->where('DATE(TanggalPenjualan)', $today)
                                      ->count_all_results('penjualan');
        $today_transactions = $transaction_query;

        // Average transaction
        $avg_transaction = $today_transactions > 0 ? $today_revenue / $today_transactions : 0;

        echo json_encode([
            'success' => true,
            'today_revenue' => (int)$today_revenue,
            'today_transactions' => (int)$today_transactions,
            'avg_transaction' => (int)$avg_transaction
        ]);
    }
}

