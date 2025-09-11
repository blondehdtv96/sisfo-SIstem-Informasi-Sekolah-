<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Ruang_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin and teachers can manage rooms)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Ruang';
        $data['ruang'] = $this->Ruang_model->get_all();
        
        // Get statistics
        $data['total_ruang'] = $this->Ruang_model->count_all();
        $data['total_aktif'] = $this->Ruang_model->count_by_status('Aktif');
        $data['total_nonaktif'] = $this->Ruang_model->count_by_status('Tidak Aktif');
        
        $data['contents'] = $this->load->view('ruang/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add rooms
            show_error('Anda tidak memiliki akses untuk menambah data ruang.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_ruang', 'Kode Ruang', 'required|trim|is_unique[tb_ruang.kode_ruang]');
            $this->form_validation->set_rules('nama_ruang', 'Nama Ruang', 'required|trim');
            $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('jenis_ruang', 'Jenis Ruang', 'required|in_list[Kelas,Lab,Aula,Perpustakaan,Kantor,Lainnya]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[Aktif,Tidak Aktif]');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'kode_ruang' => strtoupper($this->input->post('kode_ruang')),
                    'nama_ruang' => $this->input->post('nama_ruang'),
                    'jenis_ruang' => $this->input->post('jenis_ruang'),
                    'kapasitas' => $this->input->post('kapasitas'),
                    'lokasi' => $this->input->post('lokasi'),
                    'fasilitas' => $this->input->post('fasilitas'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user')
                );

                if ($this->Ruang_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data ruang berhasil ditambahkan.');
                    redirect('ruang');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data ruang.');
                }
            }
        }

        $data['title'] = 'Tambah Ruang';
        $data['contents'] = $this->load->view('ruang/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit rooms
            show_error('Anda tidak memiliki akses untuk mengedit data ruang.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('ruang');
        }

        $data['ruang'] = $this->Ruang_model->get_by_id($id);
        if (!$data['ruang']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('kode_ruang', 'Kode Ruang', 'required|trim|callback_check_unique_kode[' . $id . ']');
            $this->form_validation->set_rules('nama_ruang', 'Nama Ruang', 'required|trim');
            $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('jenis_ruang', 'Jenis Ruang', 'required|in_list[Kelas,Lab,Aula,Perpustakaan,Kantor,Lainnya]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[Aktif,Tidak Aktif]');

            if ($this->form_validation->run() == TRUE) {
                $update_data = array(
                    'kode_ruang' => strtoupper($this->input->post('kode_ruang')),
                    'nama_ruang' => $this->input->post('nama_ruang'),
                    'jenis_ruang' => $this->input->post('jenis_ruang'),
                    'kapasitas' => $this->input->post('kapasitas'),
                    'lokasi' => $this->input->post('lokasi'),
                    'fasilitas' => $this->input->post('fasilitas'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('id_user')
                );

                if ($this->Ruang_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data ruang berhasil diperbarui.');
                    redirect('ruang');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data ruang.');
                }
            }
        }

        $data['title'] = 'Edit Ruang';
        $data['contents'] = $this->load->view('ruang/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete rooms
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data ruang.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $ruang = $this->Ruang_model->get_by_id($id);
        if (!$ruang) {
            echo json_encode(['success' => false, 'message' => 'Data ruang tidak ditemukan.']);
            return;
        }

        // Check if room is used in other tables (classes, schedules, etc.)
        if ($this->Ruang_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Ruang tidak dapat dihapus karena sedang digunakan dalam jadwal atau kelas.']);
            return;
        }

        if ($this->Ruang_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data ruang berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data ruang.']);
        }
    }

    public function check_unique_kode($kode, $id)
    {
        $existing = $this->Ruang_model->get_by_kode($kode);
        if ($existing && $existing->id_ruang != $id) {
            $this->form_validation->set_message('check_unique_kode', 'Kode ruang sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>