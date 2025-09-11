<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        if ($this->session->userdata('id_level_user') != 1) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
        
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['page_title'] = 'Data User/Admin';
        $data['title'] = 'Data User/Admin';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data User/Admin']
        ];
        
        $data['users'] = $this->User_model->get_all_users();
        $data['levels'] = $this->User_model->get_user_levels();
        
        $content = $this->load->view('user/index', $data, TRUE);
        $data['contents'] = $content;
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $data['page_title'] = 'Tambah User/Admin';
        $data['title'] = 'Tambah User/Admin';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data User/Admin', 'url' => base_url('user')],
            ['title' => 'Tambah User']
        ];
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tb_user.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('id_level', 'Level User', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $user_data = [
                    'username' => $this->input->post('username', TRUE),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'no_telp' => $this->input->post('no_telp', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'id_level' => $this->input->post('id_level', TRUE),
                    'status' => 'aktif'
                ];
                
                if ($this->User_model->insert_user($user_data)) {
                    $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
                    redirect('user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan user.');
                }
            }
        }
        
        $data['levels'] = $this->User_model->get_user_levels();
        
        $content = $this->load->view('user/add', $data, TRUE);
        $data['contents'] = $content;
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            redirect('user');
        }
        
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('user');
        }
        
        $data['page_title'] = 'Edit User/Admin';
        $data['title'] = 'Edit User/Admin';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data User/Admin', 'url' => base_url('user')],
            ['title' => 'Edit User']
        ];
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check[' . $id . ']');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('id_level', 'Level User', 'required');
            
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
            }
            
            if ($this->form_validation->run() == TRUE) {
                $user_data = [
                    'username' => $this->input->post('username', TRUE),
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'no_telp' => $this->input->post('no_telp', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'id_level' => $this->input->post('id_level', TRUE),
                    'status' => $this->input->post('status', TRUE)
                ];
                
                if ($this->input->post('password')) {
                    $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }
                
                if ($this->User_model->update_user($id, $user_data)) {
                    $this->session->set_flashdata('success', 'User berhasil diperbarui.');
                    redirect('user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui user.');
                }
            }
        }
        
        $data['user'] = $user;
        $data['levels'] = $this->User_model->get_user_levels();
        
        $content = $this->load->view('user/edit', $data, TRUE);
        $data['contents'] = $content;
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        if (!$id) {
            redirect('user');
        }
        
        // Prevent deleting current user
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun sendiri.');
            redirect('user');
        }
        
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('user');
        }
        
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }
        
        redirect('user');
    }

    public function username_check($username, $user_id)
    {
        if ($this->User_model->check_username_exists($username, $user_id)) {
            $this->form_validation->set_message('username_check', 'Username sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    // AJAX function to get user data
    public function get_user_data()
    {
        $users = $this->User_model->get_all_users();
        $data = [];
        
        foreach ($users as $user) {
            $actions = '
                <div class="btn-group btn-group-sm">
                    <a href="' . base_url('user/edit/' . $user->id_user) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deleteUser(' . $user->id_user . ')" class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';
            
            $status_badge = $user->status == 'aktif' 
                ? '<span class="badge bg-success">Aktif</span>' 
                : '<span class="badge bg-danger">Nonaktif</span>';
            
            $data[] = [
                $user->username,
                $user->nama_lengkap,
                $user->email ?: '-',
                $user->no_telp ?: '-',
                $user->nama_level,
                $status_badge,
                date('d/m/Y H:i', strtotime($user->created_at)),
                $actions
            ];
        }
        
        echo json_encode(['data' => $data]);
    }
}