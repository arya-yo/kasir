<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hook untuk menangkap semua error dan exception
 * Otomatis mencatat ke log file
 */
class Log_errors {

    public function __construct()
    {
        // Set error handler
        set_error_handler(array($this, 'error_handler'));
        set_exception_handler(array($this, 'exception_handler'));
        register_shutdown_function(array($this, 'shutdown_handler'));
    }
    
    public function index()
    {
        // Hook method - dipanggil saat pre_system
        // Error handler sudah di-set di constructor
    }

    /**
     * Handle PHP errors
     */
    public function error_handler($errno, $errstr, $errfile, $errline)
    {
        // Hanya log jika error reporting diaktifkan
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $error_types = array(
            E_ERROR => 'ERROR',
            E_WARNING => 'WARNING',
            E_PARSE => 'PARSE',
            E_NOTICE => 'NOTICE',
            E_CORE_ERROR => 'CORE_ERROR',
            E_CORE_WARNING => 'CORE_WARNING',
            E_COMPILE_ERROR => 'COMPILE_ERROR',
            E_COMPILE_WARNING => 'COMPILE_WARNING',
            E_USER_ERROR => 'USER_ERROR',
            E_USER_WARNING => 'USER_WARNING',
            E_USER_NOTICE => 'USER_NOTICE',
            E_STRICT => 'STRICT',
            E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
            E_DEPRECATED => 'DEPRECATED',
            E_USER_DEPRECATED => 'USER_DEPRECATED'
        );

        $error_type = isset($error_types[$errno]) ? $error_types[$errno] : 'UNKNOWN';
        
        $message = "[PHP {$error_type}] {$errstr} | File: " . basename($errfile) . " | Line: {$errline}";
        
        // Tambahkan IP dan user info jika ada
        $ci =& get_instance();
        if (isset($ci)) {
            $ci->load->library('session');
            $message .= " | IP: " . $ci->input->ip_address();
            
            if ($ci->session->userdata('logged_in')) {
                $message .= " | User: " . $ci->session->userdata('username');
            }
        }
        
        log_message('error', $message);
        
        // Return false untuk melanjutkan error handling default
        return false;
    }

    /**
     * Handle uncaught exceptions
     */
    public function exception_handler($exception)
    {
        $message = "[EXCEPTION] " . $exception->getMessage() . 
                   " | File: " . basename($exception->getFile()) . 
                   " | Line: " . $exception->getLine() .
                   " | Trace: " . $exception->getTraceAsString();
        
        // Tambahkan IP dan user info jika ada
        $ci =& get_instance();
        if (isset($ci)) {
            $ci->load->library('session');
            $message .= " | IP: " . $ci->input->ip_address();
            
            if ($ci->session->userdata('logged_in')) {
                $message .= " | User: " . $ci->session->userdata('username');
            }
        }
        
        log_message('error', $message);
    }

    /**
     * Handle fatal errors pada shutdown
     */
    public function shutdown_handler()
    {
        $error = error_get_last();
        
        if ($error !== NULL && in_array($error['type'], array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE))) {
            $message = "[FATAL ERROR] " . $error['message'] . 
                      " | File: " . basename($error['file']) . 
                      " | Line: " . $error['line'];
            
            // Tambahkan IP dan user info jika ada
            $ci =& get_instance();
            if (isset($ci)) {
                $ci->load->library('session');
                $message .= " | IP: " . $ci->input->ip_address();
                
                if ($ci->session->userdata('logged_in')) {
                    $message .= " | User: " . $ci->session->userdata('username');
                }
            }
            
            log_message('error', $message);
        }
    }
}

