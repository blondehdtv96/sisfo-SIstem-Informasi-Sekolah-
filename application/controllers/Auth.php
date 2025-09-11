<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['page_title'] = 'Login';
        $this->load->view('auth/login', $data);
    }

    public function login()
    {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username/NISN', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username/NISN dan Password harus diisi!');
            redirect('auth');
        }
        
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $remember_me = $this->input->post('remember_me');
        
        // Check if input is NISN (numeric) for student login
        if (is_numeric($username) && strlen($username) == 10) {
            // Student login with NISN
            $user = $this->Auth_model->login_siswa($username, $password);
            if ($user) {
                $this->_set_session($user, 'siswa', $remember_me);
                $this->session->set_flashdata('success', 'Selamat datang, ' . $user['nama_siswa'] . '!');
                redirect('dashboard');
            }
        } else {
            // Try admin/user login first
            $user = $this->Auth_model->login_user($username, $password);
            if ($user) {
                $this->_set_session($user, 'user', $remember_me);
                $level_name = $this->_get_level_name($user['id_level']);
                $this->session->set_flashdata('success', 'Selamat datang, ' . $user['nama_lengkap'] . '! Login sebagai ' . $level_name);
                redirect('dashboard');
            }
            
            // Try teacher login
            $user = $this->Auth_model->login_guru($username, $password);
            if ($user) {
                $this->_set_session($user, 'guru', $remember_me);
                $this->session->set_flashdata('success', 'Selamat datang, ' . $user['nama_guru'] . '!');
                redirect('dashboard');
            }
        }
        
        // Login failed
        $this->session->set_flashdata('error', 'Username/NISN atau Password salah!');
        redirect('auth');
    }

    private function _set_session($user, $type, $remember_me = false)
    {
        $session_data = [
            'logged_in' => TRUE,
            'login_time' => time(),
            'user_type' => $type
        ];
        
        switch ($type) {
            case 'user':
                $session_data['user_id'] = $user['id_user'];
                $session_data['username'] = $user['username'];
                $session_data['nama_lengkap'] = $user['nama_lengkap'];
                $session_data['id_level_user'] = $user['id_level'];
                break;
                
            case 'guru':
                $session_data['guru_id'] = $user['id_guru'];
                $session_data['username'] = $user['username'];
                $session_data['nama_lengkap'] = $user['nama_guru'];
                $session_data['id_level_user'] = 3; // Guru level
                break;
                
            case 'siswa':
                $session_data['siswa_id'] = $user['id_siswa'];
                $session_data['nisn'] = $user['nisn'];
                $session_data['nama_lengkap'] = $user['nama_siswa'];  
                $session_data['id_level_user'] = 4; // Siswa level
                $session_data['kelas_id'] = $user['id_kelas'];
                break;
        }
        
        $this->session->set_userdata($session_data);
        
        // Set remember me cookie if requested
        if ($remember_me) {
            $cookie_data = [
                'name' => 'remember_token',
                'value' => $this->_generate_remember_token($user, $type),
                'expire' => 86400 * 30, // 30 days
                'secure' => FALSE
            ];
            $this->input->set_cookie($cookie_data);
        }
    }

    private function _generate_remember_token($user, $type)
    {
        $token = bin2hex(random_bytes(32));
        // Store token in database for security
        $this->Auth_model->save_remember_token($user, $type, $token);
        return $token;
    }

    private function _get_level_name($level_id)
    {
        $levels = [
            1 => 'Administrator',
            2 => 'Wali Kelas', 
            3 => 'Guru',
            4 => 'Siswa'
        ];
        return $levels[$level_id] ?? 'User';
    }

    public function logout()
    {
        // Clear remember token if exists
        $remember_token = $this->input->cookie('remember_token');
        if ($remember_token) {
            $this->Auth_model->clear_remember_token($remember_token);
            delete_cookie('remember_token');
        }
        
        $this->session->set_flashdata('info', 'Anda telah berhasil logout.');
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function check_remember_me()
    {
        $remember_token = $this->input->cookie('remember_token');
        if ($remember_token && !$this->session->userdata('logged_in')) {
            $user = $this->Auth_model->get_user_by_remember_token($remember_token);
            if ($user) {
                $this->_set_session($user['user_data'], $user['user_type']);
                redirect('dashboard');
            }
        }
    }
}