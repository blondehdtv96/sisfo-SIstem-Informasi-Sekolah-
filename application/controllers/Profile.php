<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $user_level = $this->session->userdata('id_level_user');
        
        if ($user_level == 4) { // Student
            $this->_student_profile();
        } else { // Admin, Guru, Wali Kelas
            $this->_user_profile();
        }
    }

    private function _student_profile()
    {
        $siswa_id = $this->session->userdata('siswa_id');
        
        if (empty($siswa_id)) {
            $this->session->set_flashdata('error', 'Session siswa tidak valid. Silakan login kembali.');
            redirect('auth');
        }

        if ($this->input->post()) {
            $this->_handle_student_profile_update($siswa_id);
        }

        // Get student information with complete details
        $this->db->select('s.*, k.nama_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from('tb_siswa s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->where('s.id_siswa', $siswa_id);
        $data['siswa'] = $this->db->get()->row();

        if (!$data['siswa']) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
            redirect('dashboard');
        }

        $data['title'] = 'Profil Saya';
        $data['page_title'] = 'Biodata';
        $data['breadcrumb'] = [
            ['title' => 'Pengaturan'],
            ['title' => 'Biodata']
        ];
        $data['contents'] = $this->load->view('profile/siswa', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    private function _user_profile()
    {
        $user_level = $this->session->userdata('id_level_user');
        $user_id = null;
        $user_data = null;

        if ($user_level == 3) { // Guru
            $user_id = $this->session->userdata('guru_id');
            if ($user_id) {
                $data['user'] = $this->db->get_where('tb_guru', ['id_guru' => $user_id])->row();
                $data['user_type'] = 'guru';
            }
        } else { // Admin, Wali Kelas
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $this->db->select('u.*, l.nama_level');
                $this->db->from('tb_user u');
                $this->db->join('tb_level_user l', 'u.id_level = l.id_level', 'left');
                $this->db->where('u.id_user', $user_id);
                $data['user'] = $this->db->get()->row();
                $data['user_type'] = 'user';
            }
        }

        if (!isset($data['user']) || !$data['user']) {
            $this->session->set_flashdata('error', 'Data pengguna tidak ditemukan.');
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->_handle_user_profile_update($user_id, $data['user_type']);
        }

        $data['title'] = 'Profil Saya';
        $data['page_title'] = 'Profile User';
        $data['breadcrumb'] = [
            ['title' => 'Pengaturan'],
            ['title' => 'Profile User']
        ];
        $data['contents'] = $this->load->view('profile/user', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    private function _handle_student_profile_update($siswa_id)
    {
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_telp', 'No. Telepon', 'trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $update_data = [
                'nama_siswa' => $this->input->post('nama_siswa', TRUE),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'no_telp' => $this->input->post('no_telp', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle photo upload
            if (isset($_FILES['foto']) && $_FILES['foto']['name']) {
                $foto_name = $this->_upload_photo('siswa');
                if ($foto_name) {
                    // Delete old photo if exists
                    $old_data = $this->db->get_where('tb_siswa', ['id_siswa' => $siswa_id])->row();
                    if ($old_data && $old_data->foto && file_exists('./assets/uploads/siswa/' . $old_data->foto)) {
                        unlink('./assets/uploads/siswa/' . $old_data->foto);
                    }
                    $update_data['foto'] = $foto_name;
                }
            }

            $this->db->where('id_siswa', $siswa_id);
            if ($this->db->update('tb_siswa', $update_data)) {
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
            }
            redirect('profile');
        }
    }

    private function _handle_user_profile_update($user_id, $user_type)
    {
        if ($user_type == 'guru') {
            $this->form_validation->set_rules('nama_guru', 'Nama', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim');
            $this->form_validation->set_rules('no_telp', 'No. Telepon', 'trim');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $update_data = [
                    'nama_guru' => $this->input->post('nama_guru', TRUE),
                    'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                    'no_telp' => $this->input->post('no_telp', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Handle photo upload
                if (isset($_FILES['foto']) && $_FILES['foto']['name']) {
                    $foto_name = $this->_upload_photo('guru');
                    if ($foto_name) {
                        $update_data['foto'] = $foto_name;
                    }
                }

                $this->db->where('id_guru', $user_id);
                if ($this->db->update('tb_guru', $update_data)) {
                    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                }
                redirect('profile');
            }
        } else {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('no_telp', 'No. Telepon', 'trim');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $update_data = [
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'no_telp' => $this->input->post('no_telp', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->db->where('id_user', $user_id);
                if ($this->db->update('tb_user', $update_data)) {
                    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                }
                redirect('profile');
            }
        }
    }

    public function change_password()
    {
        $user_level = $this->session->userdata('id_level_user');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Password Lama', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

            if ($this->form_validation->run() == TRUE) {
                $this->_handle_password_change($user_level);
            }
        }

        $data['title'] = 'Ubah Password';
        $data['page_title'] = 'Ubah Password';
        $data['breadcrumb'] = [
            ['title' => 'Pengaturan'],
            ['title' => 'Ubah Password']
        ];
        $data['contents'] = $this->load->view('profile/change_password', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    private function _handle_password_change($user_level)
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');

        if ($user_level == 4) { // Student
            $siswa_id = $this->session->userdata('siswa_id');
            $user_data = $this->db->get_where('tb_siswa', ['id_siswa' => $siswa_id])->row();
            
            if ($user_data) {
                // Check current password
                if ($this->_verify_password($current_password, $user_data->password)) {
                    $this->db->where('id_siswa', $siswa_id);
                    if ($this->db->update('tb_siswa', ['password' => password_hash($new_password, PASSWORD_DEFAULT)])) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
                }
            }
        } elseif ($user_level == 3) { // Guru
            $guru_id = $this->session->userdata('guru_id');
            $user_data = $this->db->get_where('tb_guru', ['id_guru' => $guru_id])->row();
            
            if ($user_data) {
                if ($this->_verify_password($current_password, $user_data->password)) {
                    $this->db->where('id_guru', $guru_id);
                    if ($this->db->update('tb_guru', ['password' => password_hash($new_password, PASSWORD_DEFAULT)])) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
                }
            }
        } else { // Admin, Wali Kelas
            $user_id = $this->session->userdata('user_id');
            $user_data = $this->db->get_where('tb_user', ['id_user' => $user_id])->row();
            
            if ($user_data) {
                if ($this->_verify_password($current_password, $user_data->password)) {
                    $this->db->where('id_user', $user_id);
                    if ($this->db->update('tb_user', ['password' => password_hash($new_password, PASSWORD_DEFAULT)])) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
                }
            }
        }
        
        redirect('profile/change_password');
    }

    private function _verify_password($input_password, $stored_password)
    {
        // Support both new password_hash and old MD5
        return password_verify($input_password, $stored_password) || 
               md5($input_password) == $stored_password || 
               $input_password == $stored_password;
    }

    private function _upload_photo($type)
    {
        $config['upload_path'] = './assets/uploads/' . $type . '/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        // Create directory if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Gagal upload foto: ' . $error);
            return false;
        }
    }
}