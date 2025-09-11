<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_mapel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_mapel_model');
        $this->load->model('Guru_model');
        $this->load->model('Matapelajaran_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access - only admin can manage teacher-subject assignments
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Manajemen Guru Mata Pelajaran';
        $data['page_title'] = 'Guru Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Guru Mata Pelajaran']
        ];
        
        // Get all assignments
        $data['assignments'] = $this->Guru_mapel_model->get_active_assignments();
        
        // Get statistics
        $data['stats'] = $this->Guru_mapel_model->get_statistics();
        
        // Get teacher workload
        $data['teacher_workload'] = $this->Guru_mapel_model->get_teacher_workload();
        
        $data['contents'] = $this->load->view('guru_mapel/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('id_guru', 'Guru', 'required');
            $this->form_validation->set_rules('id_mapel[]', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('id_tahun_akademik', 'Tahun Akademik', 'required');

            if ($this->form_validation->run() == TRUE) {
                $id_guru = $this->input->post('id_guru');
                $id_mapel_array = $this->input->post('id_mapel');
                $id_tahun_akademik = $this->input->post('id_tahun_akademik');
                
                $success_count = 0;
                $error_messages = [];
                
                foreach ($id_mapel_array as $id_mapel) {
                    // Check if assignment already exists
                    if (!$this->Guru_mapel_model->assignment_exists($id_guru, $id_mapel, $id_tahun_akademik)) {
                        $data = [
                            'id_guru' => $id_guru,
                            'id_mapel' => $id_mapel,
                            'id_tahun_akademik' => $id_tahun_akademik,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        if ($this->Guru_mapel_model->insert($data)) {
                            $success_count++;
                        } else {
                            $error_messages[] = "Gagal menambahkan assignment untuk mata pelajaran ID: $id_mapel";
                        }
                    } else {
                        $error_messages[] = "Assignment untuk mata pelajaran ID: $id_mapel sudah ada";
                    }
                }
                
                if ($success_count > 0) {
                    $this->session->set_flashdata('success', "$success_count assignment berhasil ditambahkan.");
                }
                
                if (!empty($error_messages)) {
                    $this->session->set_flashdata('error', implode('<br>', $error_messages));
                }
                
                redirect('guru_mapel');
            }
        }

        $data['title'] = 'Tambah Assignment Guru Mata Pelajaran';
        $data['page_title'] = 'Tambah Assignment Guru Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Guru Mata Pelajaran', 'url' => base_url('guru_mapel')],
            ['title' => 'Tambah Assignment']
        ];
        $data['teachers'] = $this->Guru_model->get_active();
        $data['subjects'] = $this->Matapelajaran_model->get_active();
        
        // Get current academic year
        $this->db->where('status', 'aktif');
        $data['current_year'] = $this->db->get('tb_tahun_akademik')->row();
        
        // Get all academic years
        $data['academic_years'] = $this->db->order_by('tahun_ajar', 'DESC')->get('tb_tahun_akademik')->result();
        
        $data['contents'] = $this->load->view('guru_mapel/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            redirect('guru_mapel');
        }

        $data['assignment'] = $this->Guru_mapel_model->get_by_id($id);
        if (!$data['assignment']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('id_guru', 'Guru', 'required');
            $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('id_tahun_akademik', 'Tahun Akademik', 'required');

            if ($this->form_validation->run() == TRUE) {
                $id_guru = $this->input->post('id_guru');
                $id_mapel = $this->input->post('id_mapel');
                $id_tahun_akademik = $this->input->post('id_tahun_akademik');
                
                // Check if assignment already exists (excluding current record)
                if (!$this->Guru_mapel_model->assignment_exists($id_guru, $id_mapel, $id_tahun_akademik, $id)) {
                    $update_data = [
                        'id_guru' => $id_guru,
                        'id_mapel' => $id_mapel,
                        'id_tahun_akademik' => $id_tahun_akademik
                    ];
                    
                    if ($this->Guru_mapel_model->update($id, $update_data)) {
                        $this->session->set_flashdata('success', 'Assignment berhasil diperbarui.');
                        redirect('guru_mapel');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui assignment.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Assignment dengan kombinasi guru, mata pelajaran, dan tahun akademik tersebut sudah ada.');
                }
            }
        }

        $data['title'] = 'Edit Assignment Guru Mata Pelajaran';
        $data['page_title'] = 'Edit Assignment Guru Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Guru Mata Pelajaran', 'url' => base_url('guru_mapel')],
            ['title' => 'Edit Assignment']
        ];
        $data['teachers'] = $this->Guru_model->get_active();
        $data['subjects'] = $this->Matapelajaran_model->get_active();
        $data['academic_years'] = $this->db->order_by('tahun_ajar', 'DESC')->get('tb_tahun_akademik')->result();
        
        $data['contents'] = $this->load->view('guru_mapel/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $assignment = $this->Guru_mapel_model->get_by_id($id);
        if (!$assignment) {
            echo json_encode(['success' => false, 'message' => 'Assignment tidak ditemukan.']);
            return;
        }

        if ($this->Guru_mapel_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Assignment berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus assignment.']);
        }
    }

    public function detail($id = null)
    {
        if (!$id) {
            redirect('guru_mapel');
        }

        $data['assignment'] = $this->Guru_mapel_model->get_by_id($id);
        if (!$data['assignment']) {
            show_404();
        }

        $data['title'] = 'Detail Assignment Guru Mata Pelajaran';
        $data['page_title'] = 'Detail Assignment Guru Mata Pelajaran';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Guru Mata Pelajaran', 'url' => base_url('guru_mapel')],
            ['title' => 'Detail Assignment']
        ];
        $data['contents'] = $this->load->view('guru_mapel/detail', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function teacher_assignments($id_guru = null)
    {
        if (!$id_guru) {
            redirect('guru_mapel');
        }

        $teacher = $this->Guru_model->get_by_id($id_guru);
        if (!$teacher) {
            show_404();
        }

        $data['title'] = 'Assignment Mata Pelajaran - ' . $teacher->nama_guru;
        $data['teacher'] = $teacher;
        $data['assignments'] = $this->Guru_mapel_model->get_by_guru($id_guru);
        
        $data['contents'] = $this->load->view('guru_mapel/teacher_assignments', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function subject_teachers($id_mapel = null)
    {
        if (!$id_mapel) {
            redirect('guru_mapel');
        }

        $subject = $this->Matapelajaran_model->get_by_id($id_mapel);
        if (!$subject) {
            show_404();
        }

        $data['title'] = 'Guru Pengampu - ' . $subject->nama_mapel;
        $data['subject'] = $subject;
        $data['assignments'] = $this->Guru_mapel_model->get_by_mapel($id_mapel);
        
        $data['contents'] = $this->load->view('guru_mapel/subject_teachers', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function get_available_subjects()
    {
        $id_guru = $this->input->post('id_guru');
        $id_tahun_akademik = $this->input->post('id_tahun_akademik');
        
        if (!$id_guru || !$id_tahun_akademik) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }
        
        $available_subjects = $this->Guru_mapel_model->get_available_subjects($id_guru, $id_tahun_akademik);
        
        echo json_encode(['success' => true, 'subjects' => $available_subjects]);
    }

    public function bulk_assign()
    {
        if ($this->input->post()) {
            $assignments = $this->input->post('assignments'); // Array of assignments
            
            if (empty($assignments)) {
                $this->session->set_flashdata('error', 'Tidak ada assignment yang dipilih.');
                redirect('guru_mapel');
            }
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($assignments as $assignment) {
                $id_guru = $assignment['id_guru'];
                $id_mapel = $assignment['id_mapel'];
                $id_tahun_akademik = $assignment['id_tahun_akademik'];
                
                // Check if assignment already exists
                if (!$this->Guru_mapel_model->assignment_exists($id_guru, $id_mapel, $id_tahun_akademik)) {
                    $data = [
                        'id_guru' => $id_guru,
                        'id_mapel' => $id_mapel,
                        'id_tahun_akademik' => $id_tahun_akademik,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if ($this->Guru_mapel_model->insert($data)) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                }
            }
            
            if ($success_count > 0) {
                $this->session->set_flashdata('success', "$success_count assignment berhasil ditambahkan.");
            }
            
            if ($error_count > 0) {
                $this->session->set_flashdata('error', "$error_count assignment gagal ditambahkan atau sudah ada.");
            }
        }
        
        redirect('guru_mapel');
    }

    public function workload_report()
    {
        $data['title'] = 'Laporan Beban Kerja Guru';
        $data['teacher_workload'] = $this->Guru_mapel_model->get_teacher_workload();
        $data['stats'] = $this->Guru_mapel_model->get_statistics();
        
        $data['contents'] = $this->load->view('guru_mapel/workload_report', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function copy_assignments()
    {
        if ($this->input->post()) {
            $from_year_id = $this->input->post('from_year_id');
            $to_year_id = $this->input->post('to_year_id');
            
            if (!$from_year_id || !$to_year_id) {
                $this->session->set_flashdata('error', 'Data tahun akademik tidak lengkap.');
                redirect('guru_mapel');
            }
            
            if ($from_year_id == $to_year_id) {
                $this->session->set_flashdata('error', 'Tahun akademik asal dan tujuan tidak boleh sama.');
                redirect('guru_mapel');
            }
            
            if ($this->Guru_mapel_model->copy_from_previous_year($from_year_id, $to_year_id)) {
                $this->session->set_flashdata('success', 'Assignment berhasil disalin dari tahun akademik sebelumnya.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyalin assignment. Mungkin tidak ada data di tahun akademik asal.');
            }
        }
        
        redirect('guru_mapel');
    }

    public function export_excel()
    {
        // This would implement Excel export functionality
        // For now, redirect back to index
        $this->session->set_flashdata('info', 'Fitur export Excel akan segera tersedia.');
        redirect('guru_mapel');
    }

    public function data()
    {
        // DataTables server-side processing
        $assignments = $this->Guru_mapel_model->get_active_assignments();
        
        $data = [];
        $no = 1;
        
        foreach ($assignments as $assignment) {
            $actions = '
                <a href="' . base_url('guru_mapel/detail/' . $assignment->id_guru_mapel) . '" class="btn btn-info btn-xs" title="Detail">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="' . base_url('guru_mapel/edit/' . $assignment->id_guru_mapel) . '" class="btn btn-warning btn-xs" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <button onclick="deleteAssignment(' . $assignment->id_guru_mapel . ')" class="btn btn-danger btn-xs" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            ';
            
            $data[] = [
                $no++,
                $assignment->nama_guru,
                $assignment->nip ?: '-',
                $assignment->nama_mapel,
                $assignment->kode_mapel,
                $assignment->kategori,
                $assignment->tahun_ajar,
                $actions
            ];
        }
        
        echo json_encode(['data' => $data]);
    }
}