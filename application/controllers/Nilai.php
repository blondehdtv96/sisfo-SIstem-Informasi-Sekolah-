<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nilai_model');
        $this->load->model('Dashboard_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $user_level = $this->session->userdata('id_level_user');
        
        if ($user_level == 3) { // Guru
            $this->teacher_dashboard();
        } elseif ($user_level == 4) { // Siswa
            $this->student_grades();
        } else {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('dashboard');
        }
    }

    /**
     * Teacher dashboard for grade management
     */
    private function teacher_dashboard()
    {
        $guru_id = $this->session->userdata('guru_id');
        
        if (!$guru_id) {
            $this->session->set_flashdata('error', 'Session guru tidak valid. Silakan login kembali.');
            redirect('auth');
        }
        
        $data['title'] = 'Input Nilai Siswa';
        $data['page_title'] = 'Input Nilai';
        $data['breadcrumb'] = [
            ['title' => 'Input Nilai']
        ];
        $data['subjects'] = $this->Nilai_model->get_teacher_subjects($guru_id);
        $data['stats'] = $this->Nilai_model->get_teacher_grade_stats($guru_id);
        
        $data['contents'] = $this->load->view('nilai/teacher_dashboard', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    /**
     * Show classes for a subject
     */
    public function subject_classes($mapel_id = null)
    {
        if (!$mapel_id || $this->session->userdata('id_level_user') != 3) {
            redirect('nilai');
        }
        
        $guru_id = $this->session->userdata('guru_id');
        
        if (!$guru_id) {
            $this->session->set_flashdata('error', 'Session guru tidak valid. Silakan login kembali.');
            redirect('auth');
        }
        
        // Verify that the teacher is assigned to this subject
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) {
            $this->session->set_flashdata('error', 'Tahun akademik aktif tidak ditemukan.');
            redirect('nilai');
        }
        
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_mapel', $mapel_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $assignment_check = $this->db->get('tb_guru_mapel')->row();
        
        if (!$assignment_check) {
            $this->session->set_flashdata('error', 'Anda tidak ditugaskan untuk mengajar mata pelajaran ini.');
            redirect('nilai');
        }
        
        $data['title'] = 'Pilih Kelas untuk Input Nilai';
        $data['mapel_id'] = $mapel_id;
        $data['classes'] = $this->Nilai_model->get_teacher_classes($guru_id, $mapel_id);
        
        // Get subject info
        $this->db->select('nama_mapel, kode_mapel');
        $data['subject'] = $this->db->get_where('tb_mata_pelajaran', ['id_mapel' => $mapel_id])->row();
        
        if (!$data['subject']) {
            $this->session->set_flashdata('error', 'Mata pelajaran tidak ditemukan.');
            redirect('nilai');
        }
        
        $data['contents'] = $this->load->view('nilai/select_class', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    /**
     * Grade input form for a class and subject
     */
    public function input($mapel_id = null, $kelas_id = null)
    {
        if (!$mapel_id || !$kelas_id || $this->session->userdata('id_level_user') != 3) {
            redirect('nilai');
        }
        
        $guru_id = $this->session->userdata('guru_id');
        
        if ($this->input->post()) {
            $this->process_grade_input($mapel_id, $kelas_id);
        }
        
        $data['title'] = 'Input Nilai Siswa';
        $data['mapel_id'] = $mapel_id;
        $data['kelas_id'] = $kelas_id;
        
        // Get subject and class info
        $this->db->select('nama_mapel, kode_mapel');
        $this->db->where('id_mapel', $mapel_id);
        $data['subject'] = $this->db->get('tb_mata_pelajaran')->row();
        
        $this->db->select('k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from('tb_kelas k');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan');
        $this->db->where('k.id_kelas', $kelas_id);
        $data['class_info'] = $this->db->get()->row();
        
        // Get students
        $data['students'] = $this->Nilai_model->get_class_students($kelas_id);
        
        // Get current semester
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        $data['current_semester'] = $current_year ? $current_year->semester : 'ganjil';
        
        $data['contents'] = $this->load->view('nilai/input_form', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    /**
     * Process grade input
     */
    private function process_grade_input($mapel_id, $kelas_id)
    {
        $guru_id = $this->session->userdata('guru_id');
        $semester = $this->input->post('semester');
        $kategori_nilai = $this->input->post('kategori_nilai');
        $keterangan = $this->input->post('keterangan');
        $grades = $this->input->post('nilai');
        
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) {
            $this->session->set_flashdata('error', 'Tahun akademik aktif tidak ditemukan.');
            return;
        }
        
        $success_count = 0;
        $error_count = 0;
        
        foreach ($grades as $siswa_id => $nilai) {
            if ($nilai !== '' && is_numeric($nilai) && $nilai >= 0 && $nilai <= 100) {
                $grade_data = [
                    'id_siswa' => $siswa_id,
                    'id_mapel' => $mapel_id,
                    'id_tahun_akademik' => $current_year->id_tahun_akademik,
                    'semester' => $semester,
                    'kategori_nilai' => $kategori_nilai,
                    'nilai' => $nilai,
                    'keterangan' => $keterangan,
                    'tanggal_input' => date('Y-m-d'),
                    'id_guru' => $guru_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                if ($this->Nilai_model->save_grade($grade_data)) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }
        }
        
        if ($success_count > 0) {
            $this->session->set_flashdata('success', "$success_count nilai berhasil disimpan.");
        }
        
        if ($error_count > 0) {
            $this->session->set_flashdata('error', "$error_count nilai gagal disimpan.");
        }
        
        redirect('nilai/input/' . $mapel_id . '/' . $kelas_id);
    }

    /**
     * Student grades view
     */
    public function student_grades()
    {
        $siswa_id = $this->session->userdata('siswa_id');
        
        if (!$siswa_id) {
            $this->session->set_flashdata('error', 'Session siswa tidak valid. Silakan login kembali.');
            redirect('auth');
        }
        
        $data['title'] = 'Nilai Saya';
        $data['page_title'] = 'Nilai Saya';
        $data['breadcrumb'] = [
            ['title' => 'Nilai Saya']
        ];
        $data['student_info'] = $this->Dashboard_model->get_student_info($siswa_id);
        $data['grades'] = $this->Nilai_model->get_student_all_grades($siswa_id);
        
        $data['contents'] = $this->load->view('nilai/siswa_view', $data, TRUE);
        $this->load->view('template_new', $data);
    }

		function siswa()
		{
			// This method is specifically for student access to their grades
			$user_level = $this->session->userdata('id_level_user');
			
			if ($user_level != 4) {
				$this->session->set_flashdata('error', 'Akses ditolak. Halaman ini khusus untuk siswa.');
				redirect('dashboard');
			}
			
			try {
				// Get student info and grades
				$siswa_id = $this->session->userdata('siswa_id');
				$nisn = $this->session->userdata('nisn');
				
				if (empty($siswa_id) || empty($nisn)) {
					$this->session->set_flashdata('error', 'Session siswa tidak valid. Silakan login kembali.');
					redirect('auth');
				}
				
				// Get student information
				$data['student_info'] = $this->Dashboard_model->get_student_info($siswa_id);
				
				// Get student grades using the new grading system
				$data['grades'] = $this->Nilai_model->get_student_all_grades($siswa_id);
				
				$data['title'] = 'Nilai Saya';
				$data['page_title'] = 'Nilai Saya';
				$data['breadcrumb'] = [
					['title' => 'Nilai Saya']
				];
				
				// Load student grade view using template_new
				$data['contents'] = $this->load->view('nilai/siswa_view', $data, TRUE);
				$this->load->view('template_new', $data);
				
			} catch (Exception $e) {
				log_message('error', 'Error in Nilai controller siswa: ' . $e->getMessage());
				$this->session->set_flashdata('error', 'Terjadi kesalahan dalam memuat data nilai. Silakan coba lagi.');
				redirect('dashboard');
			}
		}

		function update_nilai()
		{
			try {
				// Use POST instead of GET for security and use CI input class
				$nisn = $this->input->post('nisn');
				$idjadwal = $this->input->post('id_jadwal');
				$nilai = $this->input->post('nilai');

				// Validate input data
				if (empty($nisn) || empty($idjadwal) || !is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
					echo json_encode(array('status' => 'error', 'message' => 'Data tidak valid'));
					return;
				}

				$parameter = array(
					'nisn' => $nisn,
					'id_jadwal' => $idjadwal,
					'nilai' => $nilai
				);

				$validasi = array(
					'nisn' => $nisn,
					'id_jadwal' => $idjadwal
				);

				$check = $this->db->get_where('tbl_nilai', $validasi);

				if ($check === FALSE) {
					throw new Exception('Database query failed: ' . $this->db->error()['message']);
				}

				if ($check->num_rows() > 0) {
					// Update existing record
					$this->db->where('nisn', $nisn);
					$this->db->where('id_jadwal', $idjadwal);
					$result = $this->db->update('tbl_nilai', array('nilai' => $nilai));

					if ($result) {
						echo json_encode(array('status' => 'success', 'message' => 'Nilai berhasil diupdate'));
					} else {
						echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate nilai'));
					}
				} else {
					// Insert new record
					$result = $this->db->insert('tbl_nilai', $parameter);

					if ($result) {
						echo json_encode(array('status' => 'success', 'message' => 'Nilai berhasil disimpan'));
					} else {
						echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan nilai'));
					}
				}

			} catch (Exception $e) {
				log_message('error', 'Error in Nilai controller update_nilai: ' . $e->getMessage());
				echo json_encode(array('status' => 'error', 'message' => 'Terjadi kesalahan sistem'));
			}
		}
	}