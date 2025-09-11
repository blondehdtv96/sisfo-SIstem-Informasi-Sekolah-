<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tingkatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Tingkatan_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin and teachers can manage grade levels)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Tingkatan';
        $data['page_title'] = 'Tingkatan Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tingkatan Kelas']
        ];
        $data['tingkatan'] = $this->Tingkatan_model->get_all();
        
        // Get statistics
        $data['total_tingkatan'] = $this->Tingkatan_model->count_all();
        
        $data['contents'] = $this->load->view('tingkatan/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add grade levels
            show_error('Anda tidak memiliki akses untuk menambah data tingkatan.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_tingkatan', 'Nama Tingkatan', 'required|trim|is_unique[tb_tingkatan.nama_tingkatan]');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'nama_tingkatan' => $this->input->post('nama_tingkatan'),
                    'keterangan' => $this->input->post('keterangan')
                );

                if ($this->Tingkatan_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data tingkatan berhasil ditambahkan.');
                    redirect('tingkatan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data tingkatan.');
                }
            }
        }

        $data['title'] = 'Tambah Tingkatan';
        $data['page_title'] = 'Tambah Tingkatan Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tingkatan Kelas', 'url' => base_url('tingkatan')],
            ['title' => 'Tambah Tingkatan']
        ];
        $data['contents'] = $this->load->view('tingkatan/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit grade levels
            show_error('Anda tidak memiliki akses untuk mengedit data tingkatan.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('tingkatan');
        }

        $data['tingkatan'] = $this->Tingkatan_model->get_by_id($id);
        if (!$data['tingkatan']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_tingkatan', 'Nama Tingkatan', 'required|trim|callback_check_unique_nama[' . $id . ']');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $update_data = array(
                    'nama_tingkatan' => $this->input->post('nama_tingkatan'),
                    'keterangan' => $this->input->post('keterangan')
                );

                if ($this->Tingkatan_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data tingkatan berhasil diperbarui.');
                    redirect('tingkatan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data tingkatan.');
                }
            }
        }

        $data['title'] = 'Edit Tingkatan';
        $data['page_title'] = 'Edit Tingkatan Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tingkatan Kelas', 'url' => base_url('tingkatan')],
            ['title' => 'Edit Tingkatan']
        ];
        $data['contents'] = $this->load->view('tingkatan/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete grade levels
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data tingkatan.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $tingkatan = $this->Tingkatan_model->get_by_id($id);
        if (!$tingkatan) {
            echo json_encode(['success' => false, 'message' => 'Data tingkatan tidak ditemukan.']);
            return;
        }

        // Check if grade level is used in other tables (classes, etc.)
        if ($this->Tingkatan_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Tingkatan tidak dapat dihapus karena sedang digunakan dalam data kelas.']);
            return;
        }

        if ($this->Tingkatan_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data tingkatan berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data tingkatan.']);
        }
    }

    public function check_unique_nama($nama, $id)
    {
        $existing = $this->Tingkatan_model->get_by_nama($nama);
        if ($existing && $existing->id_tingkatan != $id) {
            $this->form_validation->set_message('check_unique_nama', 'Nama tingkatan sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>