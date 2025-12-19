<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Log Helper
 * Helper untuk logging yang lebih detail dan mudah digunakan
 */

if (!function_exists('app_log_error')) {
    /**
     * Log error dengan detail lengkap
     * 
     * @param string $message Pesan error
     * @param array $context Data tambahan (opsional)
     * @param string $file File dimana error terjadi (opsional)
     * @param int $line Line number dimana error terjadi (opsional)
     */
    function app_log_error($message, $context = array(), $file = '', $line = 0)
    {
        $ci =& get_instance();
        $ci->load->library('session');
        
        $log_message = "[ERROR] " . $message;
        
        // Tambahkan informasi file dan line jika ada
        if (!empty($file)) {
            $log_message .= " | File: " . basename($file);
        }
        if ($line > 0) {
            $log_message .= " | Line: " . $line;
        }
        
        // Tambahkan informasi user jika sudah login
        if ($ci->session->userdata('logged_in')) {
            $log_message .= " | User: " . $ci->session->userdata('username') . 
                           " (" . $ci->session->userdata('role') . ")";
        }
        
        // Tambahkan IP address
        $log_message .= " | IP: " . $ci->input->ip_address();
        
        // Tambahkan context jika ada
        if (!empty($context)) {
            $log_message .= " | Context: " . json_encode($context);
        }
        
        // Tambahkan stack trace untuk error
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
        if (!empty($trace)) {
            $log_message .= " | Trace: " . json_encode(array_slice($trace, 0, 3));
        }
        
        log_message('error', $log_message);
    }
}

if (!function_exists('app_log_info')) {
    /**
     * Log informasi
     * 
     * @param string $message Pesan informasi
     * @param array $context Data tambahan (opsional)
     */
    function app_log_info($message, $context = array())
    {
        $ci =& get_instance();
        $ci->load->library('session');
        
        $log_message = "[INFO] " . $message;
        
        // Tambahkan informasi user jika sudah login
        if ($ci->session->userdata('logged_in')) {
            $log_message .= " | User: " . $ci->session->userdata('username');
        }
        
        // Tambahkan context jika ada
        if (!empty($context)) {
            $log_message .= " | Context: " . json_encode($context);
        }
        
        log_message('info', $log_message);
    }
}

if (!function_exists('app_log_debug')) {
    /**
     * Log debug
     * 
     * @param string $message Pesan debug
     * @param mixed $data Data untuk debug (opsional)
     */
    function app_log_debug($message, $data = null)
    {
        $log_message = "[DEBUG] " . $message;
        
        if ($data !== null) {
            $log_message .= " | Data: " . json_encode($data);
        }
        
        log_message('debug', $log_message);
    }
}

if (!function_exists('app_log_database')) {
    /**
     * Log database error
     * 
     * @param string $query SQL query yang error
     * @param string $error Pesan error dari database
     */
    function app_log_database($query, $error)
    {
        $ci =& get_instance();
        $ci->load->library('session');
        
        $log_message = "[DATABASE ERROR] Query: " . $query . " | Error: " . $error;
        
        // Tambahkan informasi user jika sudah login
        if ($ci->session->userdata('logged_in')) {
            $log_message .= " | User: " . $ci->session->userdata('username');
        }
        
        log_message('error', $log_message);
    }
}

if (!function_exists('app_log_auth')) {
    /**
     * Log aktivitas authentication
     * 
     * @param string $action Aksi (login, logout, failed_login, dll)
     * @param string $username Username yang terlibat
     * @param bool $success Apakah berhasil atau tidak
     */
    function app_log_auth($action, $username = '', $success = true)
    {
        $ci =& get_instance();
        
        $log_message = "[AUTH] Action: " . $action . 
                      " | Username: " . ($username ? $username : 'N/A') . 
                      " | Status: " . ($success ? 'SUCCESS' : 'FAILED') .
                      " | IP: " . $ci->input->ip_address();
        
        log_message('info', $log_message);
    }
}

if (!function_exists('app_log_transaction')) {
    /**
     * Log transaksi penting
     * 
     * @param string $type Tipe transaksi (penjualan, pembelian, dll)
     * @param string $action Aksi (create, update, delete)
     * @param int $id ID transaksi
     * @param array $data Data transaksi (opsional)
     */
    function app_log_transaction($type, $action, $id, $data = array())
    {
        $ci =& get_instance();
        $ci->load->library('session');
        
        $log_message = "[TRANSACTION] Type: " . $type . 
                      " | Action: " . $action . 
                      " | ID: " . $id;
        
        // Tambahkan informasi user jika sudah login
        if ($ci->session->userdata('logged_in')) {
            $log_message .= " | User: " . $ci->session->userdata('username');
        }
        
        // Tambahkan data jika ada
        if (!empty($data)) {
            $log_message .= " | Data: " . json_encode($data);
        }
        
        log_message('info', $log_message);
    }
}

