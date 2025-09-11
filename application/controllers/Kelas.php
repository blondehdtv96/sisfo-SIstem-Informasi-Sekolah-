<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Kelas_model');
        $this->load->model('Tingkatan_model');
        $this->load->model('Jurusan_model');
        $this->load->model('Tahun_akademik_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (only admin and teachers can manage classes)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Kelas';
        $data['page_title'] = 'Data Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Kelas']
        ];
        $data['kelas'] = $this->Kelas_model->get_all_with_details();
        
        // Get statistics
        $data['total_kelas'] = $this->Kelas_model->count_all();
        $data['total_aktif'] = $this->Kelas_model->count_by_status('aktif');
        $data['total_nonaktif'] = $this->Kelas_model->count_by_status('nonaktif');
        
        $data['contents'] = $this->load->view('kelas/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can add classes
            show_error('Anda tidak memiliki akses untuk menambah data kelas.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('id_tingkatan', 'Tingkatan', 'required|numeric');
            $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|numeric');
            $this->form_validation->set_rules('rombel', 'Rombongan Belajar', 'required|trim|max_length[5]');
            $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                // Get tingkatan and jurusan names for auto-generating class name
                $tingkatan = $this->Tingkatan_model->get_by_id($this->input->post('id_tingkatan'));
                $jurusan = $this->Jurusan_model->get_by_id($this->input->post('id_jurusan'));
                $rombel = strtoupper($this->input->post('rombel'));
                
                // Auto-generate kode_kelas (unique identifier)
                $kode_kelas = $tingkatan->nama_tingkatan . '-' . $jurusan->kode_jurusan . '-' . $rombel;
                
                // Auto-generate nama_kelas (display name)
                $nama_kelas = $tingkatan->nama_tingkatan . ' ' . $jurusan->nama_jurusan . ' ' . $rombel;
                
                // Check if this combination already exists
                if ($this->Kelas_model->check_duplicate_class($this->input->post('id_tingkatan'), $this->input->post('id_jurusan'), $rombel)) {
                    $this->session->set_flashdata('error', 'Kelas dengan kombinasi tingkatan, jurusan, dan rombel ini sudah ada.');
                } else {
                    $data = array(
                        'kode_kelas' => $kode_kelas,
                        'nama_kelas' => $nama_kelas,
                        'id_tingkatan' => $this->input->post('id_tingkatan'),
                        'id_jurusan' => $this->input->post('id_jurusan'),
                        'rombel' => $rombel,
                        'kapasitas' => $this->input->post('kapasitas'),
                        'status' => $this->input->post('status')
                    );

                    if ($this->Kelas_model->insert($data)) {
                        $this->session->set_flashdata('success', 'Data kelas berhasil ditambahkan.');
                        redirect('kelas');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menambahkan data kelas.');
                    }
                }
            }
        }

        $data['title'] = 'Tambah Kelas';
        $data['page_title'] = 'Tambah Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Kelas', 'url' => base_url('kelas')],
            ['title' => 'Tambah Kelas']
        ];
        $data['tingkatan'] = $this->Tingkatan_model->get_active();
        $data['jurusan'] = $this->Jurusan_model->get_active();
        $data['tahun_akademik'] = $this->Tahun_akademik_model->get_active();
        $data['contents'] = $this->load->view('kelas/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can edit classes
            show_error('Anda tidak memiliki akses untuk mengedit data kelas.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('kelas');
        }

        $data['kelas'] = $this->Kelas_model->get_by_id($id);
        if (!$data['kelas']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('id_tingkatan', 'Tingkatan', 'required|numeric');
            $this->form_validation->set_rules('id_jurusan', 'Jurusan', 'required|numeric');
            $this->form_validation->set_rules('rombel', 'Rombongan Belajar', 'required|trim|max_length[5]');
            $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,nonaktif]');

            if ($this->form_validation->run() == TRUE) {
                // Get tingkatan and jurusan names for auto-generating class name
                $tingkatan = $this->Tingkatan_model->get_by_id($this->input->post('id_tingkatan'));
                $jurusan = $this->Jurusan_model->get_by_id($this->input->post('id_jurusan'));
                $rombel = strtoupper($this->input->post('rombel'));
                
                // Auto-generate kode_kelas (unique identifier)
                $kode_kelas = $tingkatan->nama_tingkatan . '-' . $jurusan->kode_jurusan . '-' . $rombel;
                
                // Auto-generate nama_kelas (display name)
                $nama_kelas = $tingkatan->nama_tingkatan . ' ' . $jurusan->nama_jurusan . ' ' . $rombel;
                
                // Check if this combination already exists (excluding current record)
                if ($this->Kelas_model->check_duplicate_class($this->input->post('id_tingkatan'), $this->input->post('id_jurusan'), $rombel, $id)) {
                    $this->session->set_flashdata('error', 'Kelas dengan kombinasi tingkatan, jurusan, dan rombel ini sudah ada.');
                } else {
                    $update_data = array(
                        'kode_kelas' => $kode_kelas,
                        'nama_kelas' => $nama_kelas,
                        'id_tingkatan' => $this->input->post('id_tingkatan'),
                        'id_jurusan' => $this->input->post('id_jurusan'),
                        'rombel' => $rombel,
                        'kapasitas' => $this->input->post('kapasitas'),
                        'status' => $this->input->post('status')
                    );

                    if ($this->Kelas_model->update($id, $update_data)) {
                        $this->session->set_flashdata('success', 'Data kelas berhasil diperbarui.');
                        redirect('kelas');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui data kelas.');
                    }
                }
            }
        }

        $data['title'] = 'Edit Kelas';
        $data['page_title'] = 'Edit Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Master Data'],
            ['title' => 'Kelas', 'url' => base_url('kelas')],
            ['title' => 'Edit Kelas']
        ];
        $data['tingkatan'] = $this->Tingkatan_model->get_active();
        $data['jurusan'] = $this->Jurusan_model->get_active();
        $data['tahun_akademik'] = $this->Tahun_akademik_model->get_active();
        $data['contents'] = $this->load->view('kelas/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete classes
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data kelas.']);
            return;
        }

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $kelas = $this->Kelas_model->get_by_id($id);
        if (!$kelas) {
            echo json_encode(['success' => false, 'message' => 'Data kelas tidak ditemukan.']);
            return;
        }

        // Check if class is used (has students)
        if ($this->Kelas_model->is_used($id)) {
            echo json_encode(['success' => false, 'message' => 'Kelas tidak dapat dihapus karena masih memiliki siswa.']);
            return;
        }

        if ($this->Kelas_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Data kelas berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data kelas.']);
        }
    }

    public function get_preview_nama()
    {
        $id_tingkatan = $this->input->get('tingkatan');
        $id_jurusan = $this->input->get('jurusan');
        $rombel = strtoupper($this->input->get('rombel'));
        
        if ($id_tingkatan && $id_jurusan && $rombel) {
            $tingkatan = $this->Tingkatan_model->get_by_id($id_tingkatan);
            $jurusan = $this->Jurusan_model->get_by_id($id_jurusan);
            
            if ($tingkatan && $jurusan) {
                $preview = $tingkatan->nama_tingkatan . ' ' . $jurusan->nama_jurusan . ' ' . $rombel;
                echo json_encode(array('success' => true, 'preview' => $preview));
                return;
            }
        }
        
        echo json_encode(array('success' => false, 'preview' => ''));
    }

    // For AJAX - get classes by major
    public function get_by_jurusan($id_jurusan)
    {
        $kelas = $this->Kelas_model->get_by_jurusan($id_jurusan);
        echo json_encode($kelas);
    }
}

?>