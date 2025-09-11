<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Jurusan_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin and teachers can manage majors)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Jurusan';
        $data['page_title'] = 'Data Jurusan';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Jurusan']
        ];
        $data['jurusan'] = $this->Jurusan_model->get_all();
        
        // Get statistics
        $data['total_jurusan'] = $this->Jurusan_model->count_all();
        $data['total_aktif'] = $this->Jurusan_model->count_by_status('aktif');
        $data['total_nonaktif'] = $this->Jurusan_model->count_by_status('nonaktif');
        
        $data['contents'] = $this->load->view('jurusan/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add majors
            show_error('Anda tidak memiliki akses untuk menambah data jurusan.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_jurusan', 'Kode Jurusan', 'required|trim|is_unique[tb_jurusan.kode_jurusan]');
            $this->form_validation->set_rules('nama_jurusan', 'Nama Jurusan', 'required|trim|is_unique[tb_jurusan.nama_jurusan]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'kode_jurusan' => strtoupper($this->input->post('kode_jurusan')),
                    'nama_jurusan' => $this->input->post('nama_jurusan'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status')
                );

                if ($this->Jurusan_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data jurusan berhasil ditambahkan.');
                    redirect('jurusan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data jurusan.');
                }
            }
        }

        $data['title'] = 'Tambah Jurusan';
        $data['page_title'] = 'Tambah Jurusan';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Jurusan', 'url' => base_url('jurusan')],
            ['title' => 'Tambah Jurusan']
        ];
        $data['contents'] = $this->load->view('jurusan/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit majors
            show_error('Anda tidak memiliki akses untuk mengedit data jurusan.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('jurusan');
        }

        $data['jurusan'] = $this->Jurusan_model->get_by_id($id);
        if (!$data['jurusan']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_jurusan', 'Kode Jurusan', 'required|trim|callback_check_unique_kode[' . $id . ']');
            $this->form_validation->set_rules('nama_jurusan', 'Nama Jurusan', 'required|trim|callback_check_unique_nama[' . $id . ']');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                $update_data = array(
                    'kode_jurusan' => strtoupper($this->input->post('kode_jurusan')),
                    'nama_jurusan' => $this->input->post('nama_jurusan'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status')
                );

                if ($this->Jurusan_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data jurusan berhasil diperbarui.');
                    redirect('jurusan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data jurusan.');
                }
            }
        }

        $data['title'] = 'Edit Jurusan';
        $data['page_title'] = 'Edit Jurusan';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Jurusan', 'url' => base_url('jurusan')],
            ['title' => 'Edit Jurusan']
        ];
        $data['contents'] = $this->load->view('jurusan/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete majors
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data jurusan.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $jurusan = $this->Jurusan_model->get_by_id($id);
        if (!$jurusan) {
            echo json_encode(['success' => false, 'message' => 'Data jurusan tidak ditemukan.']);
            return;
        }

        // Check if major is used in other tables (classes, students, etc.)
        if ($this->Jurusan_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Jurusan tidak dapat dihapus karena sedang digunakan dalam data kelas atau siswa.']);
            return;
        }

        if ($this->Jurusan_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data jurusan berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data jurusan.']);
        }
    }

    public function check_unique_kode($kode, $id)
    {
        $existing = $this->Jurusan_model->get_by_kode($kode);
        if ($existing && $existing->id_jurusan != $id) {
            $this->form_validation->set_message('check_unique_kode', 'Kode jurusan sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_unique_nama($nama, $id)
    {
        $existing = $this->Jurusan_model->get_by_nama($nama);
        if ($existing && $existing->id_jurusan != $id) {
            $this->form_validation->set_message('check_unique_nama', 'Nama jurusan sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>