<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahunakademik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Tahun_akademik_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin can manage academic years)
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Tahun Akademik';
        $data['page_title'] = 'Tahun Ajar';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tahun Ajar']
        ];
        $data['tahun_akademik'] = $this->Tahun_akademik_model->get_all();
        
        // Get statistics
        $data['total_tahun'] = count($data['tahun_akademik']);
        $data['tahun_aktif'] = 0;
        foreach ($data['tahun_akademik'] as $ta) {
            if ($ta->status == 'aktif') {
                $data['tahun_aktif']++;
            }
        }
        
        $data['contents'] = $this->load->view('tahunakademik/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('tahun_ajar', 'Tahun Ajar', 'required|trim|is_unique[tb_tahun_akademik.tahun_ajar]');
            $this->form_validation->set_rules('semester', 'Semester', 'required|in_list[ganjil,genap]');
            $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                // If setting to active, deactivate all others first
                if ($this->input->post('status') == 'aktif') {
                    $this->db->update('tb_tahun_akademik', ['status' => 'nonaktif']);
                }
                
                $data = array(
                    'tahun_ajar' => $this->input->post('tahun_ajar'),
                    'semester' => $this->input->post('semester'),
                    'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                    'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                    'status' => $this->input->post('status'),
                    'keterangan' => $this->input->post('keterangan')
                );

                if ($this->db->insert('tb_tahun_akademik', $data)) {
                    // Get the inserted ID
                    $idTahunAkademik = $this->db->insert_id();
                    
                    // Load walikelas model and insert dummy data
                    $this->load->model('model_walikelas');
                    $this->model_walikelas->insert_walikelas($idTahunAkademik);
                    
                    $this->session->set_flashdata('success', 'Data tahun akademik berhasil ditambahkan.');
                    redirect('tahunakademik');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data tahun akademik.');
                }
            }
        }

        $data['title'] = 'Tambah Tahun Akademik';
        $data['page_title'] = 'Tambah Tahun Ajar';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tahun Ajar', 'url' => base_url('tahunakademik')],
            ['title' => 'Tambah Tahun Ajar']
        ];
        $data['contents'] = $this->load->view('tahunakademik/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            redirect('tahunakademik');
        }

        $data['tahun_akademik'] = $this->Tahun_akademik_model->get_by_id($id);
        if (!$data['tahun_akademik']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('tahun_ajar', 'Tahun Ajar', 'required|trim|callback_check_unique_tahun[' . $id . ']');
            $this->form_validation->set_rules('semester', 'Semester', 'required|in_list[ganjil,genap]');
            $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                // If setting to active, deactivate all others first
                if ($this->input->post('status') == 'aktif') {
                    $this->db->update('tb_tahun_akademik', ['status' => 'nonaktif']);
                }
                
                $update_data = array(
                    'tahun_ajar' => $this->input->post('tahun_ajar'),
                    'semester' => $this->input->post('semester'),
                    'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                    'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                    'status' => $this->input->post('status'),
                    'keterangan' => $this->input->post('keterangan')
                );

                $this->db->where('id_tahun_akademik', $id);
                if ($this->db->update('tb_tahun_akademik', $update_data)) {
                    // If setting to active, create walikelas records if they don't exist
                    if ($this->input->post('status') == 'aktif') {
                        // Check if walikelas records exist for this academic year
                        $this->db->from('tb_wali_kelas');
                        $this->db->where('id_tahun_akademik', $id);
                        if ($this->db->count_all_results() == 0) {
                            // Load walikelas model and insert dummy data
                            $this->load->model('model_walikelas');
                            $this->model_walikelas->insert_walikelas($id);
                        }
                    }
                    
                    $this->session->set_flashdata('success', 'Data tahun akademik berhasil diperbarui.');
                    redirect('tahunakademik');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data tahun akademik.');
                }
            }
        }

        $data['title'] = 'Edit Tahun Akademik';
        $data['page_title'] = 'Edit Tahun Ajar';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Tahun Ajar', 'url' => base_url('tahunakademik')],
            ['title' => 'Edit Tahun Ajar']
        ];
        $data['contents'] = $this->load->view('tahunakademik/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $tahun_akademik = $this->Tahun_akademik_model->get_by_id($id);
        if (!$tahun_akademik) {
            echo json_encode(['success' => false, 'message' => 'Data tahun akademik tidak ditemukan.']);
            return;
        }

        // Check if academic year is used in other tables
        $this->db->from('tb_siswa');
        $this->db->where('id_tahun_akademik', $id);
        if ($this->db->count_all_results() > 0) {
            echo json_encode(['success' => false, 'message' => 'Tahun akademik tidak dapat dihapus karena sedang digunakan dalam data siswa.']);
            return;
        }

        $this->db->where('id_tahun_akademik', $id);
        if ($this->db->delete('tb_tahun_akademik')) {
            echo json_encode(['success' => true, 'message' => 'Data tahun akademik berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data tahun akademik.']);
        }
    }

    public function aktif($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID tidak valid.');
            redirect('tahunakademik');
        }

        $tahun_akademik = $this->Tahun_akademik_model->get_by_id($id);
        if (!$tahun_akademik) {
            $this->session->set_flashdata('error', 'Data tahun akademik tidak ditemukan.');
            redirect('tahunakademik');
        }

        // Deactivate all academic years first
        $this->db->update('tb_tahun_akademik', ['status' => 'nonaktif']);
        
        // Activate selected academic year
        $this->db->where('id_tahun_akademik', $id);
        if ($this->db->update('tb_tahun_akademik', ['status' => 'aktif'])) {
            // Check if walikelas records exist for this academic year
            $this->db->from('tb_wali_kelas');
            $this->db->where('id_tahun_akademik', $id);
            if ($this->db->count_all_results() == 0) {
                // Load walikelas model and insert dummy data
                $this->load->model('model_walikelas');
                $this->model_walikelas->insert_walikelas($id);
            }
            
            $this->session->set_flashdata('success', 'Tahun akademik berhasil diaktifkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengaktifkan tahun akademik.');
        }
        
        redirect('tahunakademik');
    }

    public function check_unique_tahun($tahun_ajar, $id)
    {
        $this->db->from('tb_tahun_akademik');
        $this->db->where('tahun_ajar', $tahun_ajar);
        $this->db->where('id_tahun_akademik !=', $id);
        if ($this->db->count_all_results() > 0) {
            $this->form_validation->set_message('check_unique_tahun', 'Tahun ajar sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
}
?>