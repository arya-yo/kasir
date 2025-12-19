<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('app_log');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * Default method - redirect ke halaman login
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in') === TRUE) {
            redirect('dashboard');
            return;
        }
        // Jika belum login, tampilkan halaman login
        $this->login();
    }

    /**
     * Halaman Login dan Proses Login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        // Jika ada POST request, proses login
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');

            // Validasi input
            $this->form_validation->set_rules('email', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', 'Username dan Password harus diisi');
                redirect('auth/login');
                return;
            }

            // Load database
            $this->load->database();
            
            // Cek di database
            $user = $this->db->where('Username', $email)->get('users')->row();

            // Verifikasi password
            if ($user && password_verify($password, $user->Password)) {
                $user_data = array(
                    'user_id' => $user->UserID,
                    'username' => $user->Username,
                    'role' => $user->Role,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($user_data);

                // Log aktivitas login berhasil
                app_log_auth('login', $email, true);

                // Jika remember me dicentang
                if ($remember) {
                    // Set cookie (optional)
                    setcookie('remember_email', $email, time() + (86400 * 30), "/");
                }

                $this->session->set_flashdata('success', 'Login berhasil!');
                
                // Redirect berdasarkan role
                if ($user->Role == 'admin') {
                    redirect('dashboard');
                } else {
                    redirect('dashboard');
                }
            } else {
                // Log aktivitas login gagal
                app_log_auth('login', $email, false);
                
                $this->session->set_flashdata('error', 'Username atau Password salah');
                redirect('auth/login');
            }
        } else {
            // Tampilkan halaman login
            $this->load->view('Login');
        }
    }

    /**
     * Halaman Registrasi
     */
    public function register()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        $this->load->view('Register');
    }

    /**
     * Proses Registrasi
     */
    public function process_register()
    {
        if ($this->input->post()) {
            // Validasi input
            $this->form_validation->set_rules('first_name', 'Nama Depan', 'required|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Nama Belakang', 'required|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('phone', 'Nomor Telepon', 'numeric');
            $this->form_validation->set_rules('address', 'Alamat', 'required');
            $this->form_validation->set_rules('agree_terms', 'Persetujuan Syarat', 'required');

            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect('auth/register');
                return;
            }

            // Persiapkan data user
            $user_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active'
            );

            // Insert ke database
            // $insert = $this->db->insert('users', $user_data);

            // Dummy insert (ganti dengan database query)
            $insert = true;

            if ($insert) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
                redirect('auth/register');
            }
        } else {
            redirect('auth/register');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $username = $this->session->userdata('username');
        
        // Log aktivitas logout
        app_log_auth('logout', $username, true);
        
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    /**
     * Halaman Lupa Password
     */
    public function forgot()
    {
        // TODO: Implementasi fitur lupa password
        $this->load->view('ForgotPassword');
    }
}
?>
