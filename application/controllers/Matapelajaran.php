<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matapelajaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Matapelajaran_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin and teachers can manage subjects)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Mata Pelajaran';
        $data['page_title'] = 'Data Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Mata Pelajaran']
        ];
        $data['matapelajaran'] = $this->Matapelajaran_model->get_all();
        
        // Get statistics
        $data['total_mapel'] = $this->Matapelajaran_model->count_all();
        $data['total_aktif'] = $this->Matapelajaran_model->count_by_status('aktif');
        $data['total_nonaktif'] = $this->Matapelajaran_model->count_by_status('nonaktif');
        
        $data['contents'] = $this->load->view('matapelajaran/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add subjects
            show_error('Anda tidak memiliki akses untuk menambah data mata pelajaran.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_mapel', 'Kode Mata Pelajaran', 'required|trim|is_unique[tb_mata_pelajaran.kode_mapel]');
            $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|trim');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|in_list[umum,kejuruan,muatan_lokal]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'kode_mapel' => strtoupper($this->input->post('kode_mapel')),
                    'nama_mapel' => $this->input->post('nama_mapel'),
                    'kategori' => $this->input->post('kategori'),
                    'status' => $this->input->post('status')
                );

                if ($this->Matapelajaran_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data mata pelajaran berhasil ditambahkan.');
                    redirect('matapelajaran');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data mata pelajaran.');
                }
            }
        }

        $data['title'] = 'Tambah Mata Pelajaran';
        $data['page_title'] = 'Tambah Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Mata Pelajaran', 'url' => base_url('matapelajaran')],
            ['title' => 'Tambah Mata Pelajaran']
        ];
        $data['contents'] = $this->load->view('matapelajaran/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit subjects
            show_error('Anda tidak memiliki akses untuk mengedit data mata pelajaran.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('matapelajaran');
        }

        $data['matapelajaran'] = $this->Matapelajaran_model->get_by_id($id);
        if (!$data['matapelajaran']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_mapel', 'Kode Mata Pelajaran', 'required|trim|callback_check_unique_kode[' . $id . ']');
            $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|trim');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|in_list[umum,kejuruan,muatan_lokal]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                $update_data = array(
                    'kode_mapel' => strtoupper($this->input->post('kode_mapel')),
                    'nama_mapel' => $this->input->post('nama_mapel'),
                    'kategori' => $this->input->post('kategori'),
                    'status' => $this->input->post('status')
                );

                if ($this->Matapelajaran_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data mata pelajaran berhasil diperbarui.');
                    redirect('matapelajaran');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data mata pelajaran.');
                }
            }
        }

        $data['title'] = 'Edit Mata Pelajaran';
        $data['page_title'] = 'Edit Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Mata Pelajaran', 'url' => base_url('matapelajaran')],
            ['title' => 'Edit Mata Pelajaran']
        ];
        $data['contents'] = $this->load->view('matapelajaran/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete subjects
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data mata pelajaran.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $matapelajaran = $this->Matapelajaran_model->get_by_id($id);
        if (!$matapelajaran) {
            echo json_encode(['success' => false, 'message' => 'Data mata pelajaran tidak ditemukan.']);
            return;
        }

        // Check if subject is used in other tables (schedules, grades, etc.)
        if ($this->Matapelajaran_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Mata pelajaran tidak dapat dihapus karena sedang digunakan dalam jadwal atau nilai.']);
            return;
        }

        if ($this->Matapelajaran_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data mata pelajaran berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data mata pelajaran.']);
        }
    }

    public function check_unique_kode($kode, $id)
    {
        $existing = $this->Matapelajaran_model->get_by_kode($kode);
        if ($existing && $existing->id_mapel != $id) {
            $this->form_validation->set_message('check_unique_kode', 'Kode mata pelajaran sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>