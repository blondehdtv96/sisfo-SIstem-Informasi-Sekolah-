<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Guru_model');
        $this->load->library('form_validation');
        $this->load->helper('file');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2])) { // Admin and Wali Kelas only
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Guru';
        $data['page_title'] = 'Data Guru';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Guru']
        ];
        $data['guru'] = $this->Guru_model->get_all();
        
        // Get statistics
        $data['total_guru'] = $this->Guru_model->count_all();
        $data['total_aktif'] = $this->Guru_model->count_by_status('aktif');
        $data['total_pns'] = $this->Guru_model->count_by_kepegawaian('PNS');
        $data['total_gtt'] = $this->Guru_model->count_by_kepegawaian('GTT');
        
        $data['contents'] = $this->load->view('guru/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add teachers
            show_error('Anda tidak memiliki akses untuk menambah data guru.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nip', 'NIP', 'trim|is_unique[tb_guru.nip]');
            $this->form_validation->set_rules('nuptk', 'NUPTK', 'trim|is_unique[tb_guru.nuptk]');
            $this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('username', 'Username', 'trim|is_unique[tb_guru.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
            $this->form_validation->set_rules('status_kepegawaian', 'Status Kepegawaian', 'required|in_list[PNS,GTT,GTY,Honorer]');

            if ($this->form_validation->run() == TRUE) {
                $config['upload_path'] = './assets/uploads/guru/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                $foto_name = '';
                if ($_FILES['foto']['name']) {
                    if ($this->upload->do_upload('foto')) {
                        $foto_data = $this->upload->data();
                        $foto_name = $foto_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', 'Gagal upload foto: ' . $this->upload->display_errors());
                        redirect('guru/add');
                    }
                }

                $password = $this->input->post('password');
                $data = array(
                    'nip' => $this->input->post('nip'),
                    'nuptk' => $this->input->post('nuptk'),
                    'nama_guru' => $this->input->post('nama_guru'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                    'agama' => $this->input->post('agama'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'email' => $this->input->post('email'),
                    'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir'),
                    'jabatan' => $this->input->post('jabatan'),
                    'status_kepegawaian' => $this->input->post('status_kepegawaian'),
                    'username' => $this->input->post('username'),
                    'password' => $password ? password_hash($password, PASSWORD_DEFAULT) : null,
                    'foto' => $foto_name,
                    'status' => 'aktif'
                );

                if ($this->Guru_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data guru berhasil ditambahkan.');
                    redirect('guru');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data guru.');
                }
            }
        }

        $data['title'] = 'Tambah Guru';
        $data['page_title'] = 'Tambah Guru';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Guru', 'url' => base_url('guru')],
            ['title' => 'Tambah Guru']
        ];
        $data['contents'] = $this->load->view('guru/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit teachers
            show_error('Anda tidak memiliki akses untuk mengedit data guru.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('guru');
        }

        $data['guru'] = $this->Guru_model->get_by_id($id);
        if (!$data['guru']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nip', 'NIP', 'trim|callback_check_unique_nip[' . $id . ']');
            $this->form_validation->set_rules('nuptk', 'NUPTK', 'trim|callback_check_unique_nuptk[' . $id . ']');
            $this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('username', 'Username', 'trim|callback_check_unique_username[' . $id . ']');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
            $this->form_validation->set_rules('status_kepegawaian', 'Status Kepegawaian', 'required|in_list[PNS,GTT,GTY,Honorer]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                $foto_name = $data['guru']->foto;
                
                if ($_FILES['foto']['name']) {
                    $config['upload_path'] = './assets/uploads/guru/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('foto')) {
                        // Delete old photo
                        if ($foto_name && file_exists('./assets/uploads/guru/' . $foto_name)) {
                            unlink('./assets/uploads/guru/' . $foto_name);
                        }
                        
                        $foto_data = $this->upload->data();
                        $foto_name = $foto_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', 'Gagal upload foto: ' . $this->upload->display_errors());
                        redirect('guru/edit/' . $id);
                    }
                }

                $update_data = array(
                    'nip' => $this->input->post('nip'),
                    'nuptk' => $this->input->post('nuptk'),
                    'nama_guru' => $this->input->post('nama_guru'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                    'agama' => $this->input->post('agama'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'email' => $this->input->post('email'),
                    'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir'),
                    'jabatan' => $this->input->post('jabatan'),
                    'status_kepegawaian' => $this->input->post('status_kepegawaian'),
                    'username' => $this->input->post('username'),
                    'foto' => $foto_name,
                    'status' => $this->input->post('status')
                );

                // Update password only if provided
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                if ($this->Guru_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data guru berhasil diperbarui.');
                    redirect('guru');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data guru.');
                }
            }
        }

        $data['title'] = 'Edit Guru';
        $data['page_title'] = 'Edit Guru';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Guru', 'url' => base_url('guru')],
            ['title' => 'Edit Guru']
        ];
        $data['contents'] = $this->load->view('guru/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete teachers
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data guru.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $guru = $this->Guru_model->get_by_id($id);
        if (!$guru) {
            echo json_encode(['success' => false, 'message' => 'Data guru tidak ditemukan.']);
            return;
        }

        // Check if teacher is used in other tables
        if ($this->Guru_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Guru tidak dapat dihapus karena memiliki data terkait.']);
            return;
        }

        if ($this->Guru_model->delete($id)) {
            // Delete photo if exists
            if ($guru->foto && file_exists('./assets/uploads/guru/' . $guru->foto)) {
                unlink('./assets/uploads/guru/' . $guru->foto);
            }
            echo json_encode(['success' => true, 'message' => 'Data guru berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data guru.']);
        }
    }

    public function detail($id = null)
    {
        if (!$id) {
            redirect('guru');
        }

        $data['guru'] = $this->Guru_model->get_by_id($id);
        if (!$data['guru']) {
            show_404();
        }

        $data['title'] = 'Detail Guru';
        $data['contents'] = $this->load->view('guru/detail', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function reset_password($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) {
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk reset password.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $guru = $this->Guru_model->get_by_id($id);
        if (!$guru) {
            echo json_encode(['success' => false, 'message' => 'Data guru tidak ditemukan.']);
            return;
        }

        $new_password = '123456'; // Default password
        $update_data = array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        );

        if ($this->Guru_model->update($id, $update_data)) {
            echo json_encode(['success' => true, 'message' => 'Password berhasil direset ke: ' . $new_password]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal reset password.']);
        }
    }

    // Validation callbacks
    public function check_unique_nip($nip, $id)
    {
        if (empty($nip)) return TRUE;
        
        $existing = $this->Guru_model->get_by_nip($nip);
        if ($existing && $existing->id_guru != $id) {
            $this->form_validation->set_message('check_unique_nip', 'NIP sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_unique_nuptk($nuptk, $id)
    {
        if (empty($nuptk)) return TRUE;
        
        $existing = $this->Guru_model->get_by_nuptk($nuptk);
        if ($existing && $existing->id_guru != $id) {
            $this->form_validation->set_message('check_unique_nuptk', 'NUPTK sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_unique_username($username, $id)
    {
        if (empty($username)) return TRUE;
        
        $existing = $this->Guru_model->get_by_username($username);
        if ($existing && $existing->id_guru != $id) {
            $this->form_validation->set_message('check_unique_username', 'Username sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>