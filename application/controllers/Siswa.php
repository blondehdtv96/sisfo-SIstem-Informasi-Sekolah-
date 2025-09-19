<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Siswa_model');
        $this->load->model('Kelas_model');
        $this->load->model('Jurusan_model');
        $this->load->model('Tingkatan_model');
        $this->load->model('Tahun_akademik_model');
        $this->load->library('form_validation');
        $this->load->helper('file');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access
        $user_level = $this->session->userdata('id_level_user');
        $method = $this->router->method;
        
        // Allow students to access only the nilai method
        if ($method === 'nilai' && $user_level == 4) {
            // Students can access the nilai method
            return;
        }
        
        // For all other methods, require admin/teacher/wali kelas access
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Siswa';
        $data['page_title'] = 'Data Siswa';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Siswa']
        ];
        $data['siswa'] = $this->Siswa_model->get_all_with_details();
        
        // Get statistics
        $data['total_siswa'] = $this->Siswa_model->count_all();
        $data['total_aktif'] = $this->Siswa_model->count_by_status('aktif');
        $data['total_lulus'] = $this->Siswa_model->count_by_status('lulus');
        $data['total_pindah'] = $this->Siswa_model->count_by_status('pindah');
        
        // Get filter options for admin
        if ($this->session->userdata('id_level_user') == 1) { // Only for admin
            $data['kelas_list'] = $this->Kelas_model->get_active_with_details();
            $data['jurusan_list'] = $this->Jurusan_model->get_active();
        }
        
        $data['contents'] = $this->load->view('siswa/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function add()
    {
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2])) { // Only admin and wali kelas can add students
            show_error('Anda tidak memiliki akses untuk menambah data siswa.', 403, 'Akses Ditolak');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nisn', 'NISN', 'required|trim|exact_length[10]|numeric|is_unique[tb_siswa.nisn]');
            $this->form_validation->set_rules('nis', 'NIS', 'trim|is_unique[tb_siswa.nis]');
            $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required|trim');
            $this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required|trim');
            $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
            $this->form_validation->set_rules('id_tahun_akademik', 'Tahun Akademik', 'required');

            if ($this->form_validation->run() == TRUE) {
                $config['upload_path'] = './assets/uploads/siswa/';
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
                        redirect('siswa/add');
                    }
                }

                // Generate default password (NISN)
                $default_password = $this->input->post('nisn');

                $data = array(
                    'nisn' => $this->input->post('nisn'),
                    'nis' => $this->input->post('nis'),
                    'nama_siswa' => $this->input->post('nama_siswa'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                    'agama' => $this->input->post('agama'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'email' => $this->input->post('email'),
                    'nama_ayah' => $this->input->post('nama_ayah'),
                    'nama_ibu' => $this->input->post('nama_ibu'),
                    'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                    'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
                    'no_telp_ortu' => $this->input->post('no_telp_ortu'),
                    'id_kelas' => $this->input->post('id_kelas'),
                    'id_tahun_akademik' => $this->input->post('id_tahun_akademik'),
                    'password' => password_hash($default_password, PASSWORD_DEFAULT),
                    'foto' => $foto_name,
                    'status' => 'aktif',
                    'tanggal_masuk' => date('Y-m-d')
                );

                if ($this->Siswa_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan dengan password default: ' . $default_password);
                    redirect('siswa');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data siswa.');
                }
            }
        }

        $data['title'] = 'Tambah Siswa';
        $data['page_title'] = 'Tambah Siswa';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Siswa', 'url' => base_url('siswa')],
            ['title' => 'Tambah Siswa']
        ];
        $data['kelas_list'] = $this->Kelas_model->get_active_with_details();
        $data['tahun_akademik_list'] = $this->Tahun_akademik_model->get_active();
        $data['contents'] = $this->load->view('siswa/add', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function edit($id = null)
    {
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2])) { // Only admin and wali kelas can edit students
            show_error('Anda tidak memiliki akses untuk mengedit data siswa.', 403, 'Akses Ditolak');
        }

        if (!$id) {
            redirect('siswa');
        }

        $data['siswa'] = $this->Siswa_model->get_by_id($id);
        if (!$data['siswa']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nisn', 'NISN', 'required|trim|exact_length[10]|numeric|callback_check_unique_nisn[' . $id . ']');
            $this->form_validation->set_rules('nis', 'NIS', 'trim|callback_check_unique_nis[' . $id . ']');
            $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required|trim');
            $this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required|trim');
            $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[aktif,pindah,lulus,keluar]');

            if ($this->form_validation->run() == TRUE) {
                $foto_name = $data['siswa']->foto;
                
                if ($_FILES['foto']['name']) {
                    $config['upload_path'] = './assets/uploads/siswa/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('foto')) {
                        // Delete old photo
                        if ($foto_name && file_exists('./assets/uploads/siswa/' . $foto_name)) {
                            unlink('./assets/uploads/siswa/' . $foto_name);
                        }
                        
                        $foto_data = $this->upload->data();
                        $foto_name = $foto_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', 'Gagal upload foto: ' . $this->upload->display_errors());
                        redirect('siswa/edit/' . $id);
                    }
                }

                $update_data = array(
                    'nisn' => $this->input->post('nisn'),
                    'nis' => $this->input->post('nis'),
                    'nama_siswa' => $this->input->post('nama_siswa'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                    'agama' => $this->input->post('agama'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'email' => $this->input->post('email'),
                    'nama_ayah' => $this->input->post('nama_ayah'),
                    'nama_ibu' => $this->input->post('nama_ibu'),
                    'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                    'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
                    'no_telp_ortu' => $this->input->post('no_telp_ortu'),
                    'id_kelas' => $this->input->post('id_kelas'),
                    'foto' => $foto_name,
                    'status' => $this->input->post('status')
                );

                // Set tanggal_keluar if status changed to non-active
                if (in_array($this->input->post('status'), ['pindah', 'lulus', 'keluar'])) {
                    $update_data['tanggal_keluar'] = date('Y-m-d');
                } else {
                    $update_data['tanggal_keluar'] = null;
                }

                if ($this->Siswa_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui.');
                    redirect('siswa');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data siswa.');
                }
            }
        }

        $data['title'] = 'Edit Siswa';
        $data['page_title'] = 'Edit Siswa';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Siswa', 'url' => base_url('siswa')],
            ['title' => 'Edit Siswa']
        ];
        $data['kelas_list'] = $this->Kelas_model->get_active_with_details();
        $data['contents'] = $this->load->view('siswa/edit', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function delete($id = null)
    {
        // Disable any output buffering and clear any existing output
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers for JSON response
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        // Validate request method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
            exit;
        }
        
        // Log the request for debugging
        log_message('info', 'Delete request received for student ID: ' . $id);
        
        $user_level = $this->session->userdata('id_level_user');
        if ($user_level != 1) { // Only admin can delete students
            log_message('info', 'Delete denied - insufficient privileges. User level: ' . $user_level);
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus data siswa.']);
            exit;
        }

        if (!$id || !is_numeric($id)) {
            log_message('info', 'Delete denied - invalid ID: ' . $id);
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            exit;
        }

        try {
            $siswa = $this->Siswa_model->get_by_id($id);
            if (!$siswa) {
                log_message('info', 'Delete denied - student not found: ' . $id);
                echo json_encode(['success' => false, 'message' => 'Data siswa tidak ditemukan.']);
                exit;
            }

            // Check if student has grades
            $has_grades = $this->Siswa_model->has_grades($id);
            log_message('info', 'Student has grades check: ' . ($has_grades ? 'true' : 'false'));
            
            if ($has_grades) {
                echo json_encode(['success' => false, 'message' => 'Siswa tidak dapat dihapus karena memiliki data nilai. Silakan ubah status siswa menjadi "keluar" atau "pindah".']);
                exit;
            }

            // Start transaction
            $this->db->trans_start();
            
            // Delete student record
            $delete_result = $this->Siswa_model->delete($id);
            log_message('info', 'Delete result: ' . ($delete_result ? 'success' : 'failed'));
            
            if ($delete_result) {
                // Delete photo if exists
                if ($siswa->foto && file_exists('./assets/uploads/siswa/' . $siswa->foto)) {
                    $photo_deleted = @unlink('./assets/uploads/siswa/' . $siswa->foto);
                    log_message('info', 'Photo deletion: ' . ($photo_deleted ? 'success' : 'failed'));
                }
                
                $this->db->trans_complete();
                
                if ($this->db->trans_status() === FALSE) {
                    log_message('error', 'Transaction failed during student deletion');
                    echo json_encode(['success' => false, 'message' => 'Gagal menghapus data siswa karena kesalahan database.']);
                } else {
                    log_message('info', 'Student deleted successfully: ' . $id);
                    echo json_encode(['success' => true, 'message' => 'Data siswa "' . $siswa->nama_siswa . '" berhasil dihapus.']);
                }
            } else {
                $this->db->trans_rollback();
                log_message('error', 'Failed to delete student from database: ' . $id);
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus data siswa dari database.']);
            }
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Exception during student deletion: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
        
        exit; // Ensure no additional output
    }

    public function detail($id = null)
    {
        if (!$id) {
            redirect('siswa');
        }

        $data['siswa'] = $this->Siswa_model->get_detail_by_id($id);
        if (!$data['siswa']) {
            show_404();
        }

        $data['title'] = 'Detail Siswa';
        $data['page_title'] = 'Detail Siswa';
        $data['breadcrumb'] = [
            ['title' => 'Manajemen Data'],
            ['title' => 'Data Siswa', 'url' => base_url('siswa')],
            ['title' => 'Detail Siswa']
        ];
        $data['contents'] = $this->load->view('siswa/detail', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function reset_password($id = null)
    {
        // Set content type for JSON response
        $this->output->set_content_type('application/json');
        
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2])) {
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk reset password.']);
            return;
        }

        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        try {
            $siswa = $this->Siswa_model->get_by_id($id);
            if (!$siswa) {
                echo json_encode(['success' => false, 'message' => 'Data siswa tidak ditemukan.']);
                return;
            }

            $new_password = $siswa->nisn; // Reset to NISN
            $update_data = array(
                'password' => password_hash($new_password, PASSWORD_DEFAULT)
            );

            if ($this->Siswa_model->update($id, $update_data)) {
                echo json_encode(['success' => true, 'message' => 'Password berhasil direset ke NISN: ' . $new_password]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal reset password.']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error resetting password: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    public function check_unique_nisn($nisn, $id)
    {
        $existing = $this->Siswa_model->get_by_nisn($nisn);
        if ($existing && $existing->id_siswa != $id) {
            $this->form_validation->set_message('check_unique_nisn', 'NISN sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_unique_nis($nis, $id)
    {
        if (empty($nis)) return TRUE;
        
        $existing = $this->Siswa_model->get_by_nis($nis);
        if ($existing && $existing->id_siswa != $id) {
            $this->form_validation->set_message('check_unique_nis', 'NIS sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }



    public function test_delete()
    {
        // Simple test endpoint to check if JSON response works
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'message' => 'Test endpoint working',
            'timestamp' => date('Y-m-d H:i:s'),
            'user_level' => $this->session->userdata('id_level_user')
        ]);
        exit;
    }

    public function filter_data()
    {
        header('Content-Type: application/json');
        
        $kelas = $this->input->post('kelas');
        $jurusan = $this->input->post('jurusan');
        $status = $this->input->post('status');
        
        // Build where conditions
        $where = array();
        if (!empty($kelas)) {
            $where['k.nama_kelas'] = $kelas;
        }
        if (!empty($jurusan)) {
            $where['j.nama_jurusan'] = $jurusan;
        }
        if (!empty($status)) {
            $where['s.status'] = strtolower($status);
        }
        
        try {
            $siswa = $this->Siswa_model->get_all_with_details_filtered($where);
            
            $data = array();
            $no = 1;
            foreach ($siswa as $s) {
                $foto = '';
                if ($s->foto && file_exists('./assets/uploads/siswa/' . $s->foto)) {
                    $foto = '<img src="' . base_url('assets/uploads/siswa/' . $s->foto) . '" alt="Foto ' . $s->nama_siswa . '" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">';
                } else {
                    $foto = '<div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; border: 2px solid #dee2e6;"><i class="fas fa-user"></i></div>';
                }
                
                $nisn_nis = '<strong class="text-dark">' . $s->nisn . '</strong><br><small class="text-muted">' . ($s->nis ?: '-') . '</small>';
                
                $nama = '<a href="' . site_url('siswa/detail/' . $s->id_siswa) . '" class="text-decoration-none text-dark fw-medium">' . $s->nama_siswa . '</a>';
                
                $kelas_info = '<span class="badge bg-info">' . ($s->nama_kelas ?: 'Belum Ada Kelas') . '</span><br><small class="text-muted">' . $s->nama_jurusan . '</small>';
                
                $jk = $s->jenis_kelamin == 'L' ? '<span class="badge bg-primary">L</span>' : '<span class="badge bg-danger">P</span>';
                
                $status_class = '';
                switch($s->status) {
                    case 'aktif': $status_class = 'bg-success'; break;
                    case 'lulus': $status_class = 'bg-warning'; break;
                    case 'pindah': $status_class = 'bg-info'; break;
                    case 'keluar': $status_class = 'bg-danger'; break;
                    default: $status_class = 'bg-secondary';
                }
                $status_badge = '<span class="badge ' . $status_class . '">' . ucfirst($s->status) . '</span>';
                
                $tanggal = $s->tanggal_masuk ? date('d/m/Y', strtotime($s->tanggal_masuk)) : '-';
                
                $aksi = '';
                if (in_array($this->session->userdata('id_level_user'), [1, 2])) {
                    $aksi = '<div class="btn-group btn-group-sm" role="group">';
                    $aksi .= '<a href="' . site_url('siswa/detail/' . $s->id_siswa) . '" class="btn btn-outline-info" title="Detail"><i class="fas fa-eye"></i></a>';
                    $aksi .= '<a href="' . site_url('siswa/edit/' . $s->id_siswa) . '" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>';
                    $aksi .= '<button type="button" class="btn btn-outline-secondary" title="Reset Password" onclick="resetPassword(' . $s->id_siswa . ', \'' . addslashes($s->nama_siswa) . '\')"><i class="fas fa-key"></i></button>';
                    if ($this->session->userdata('id_level_user') == 1) {
                        $aksi .= '<button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteSiswa(' . $s->id_siswa . ', \'' . addslashes($s->nama_siswa) . '\')"><i class="fas fa-trash"></i></button>';
                    }
                    $aksi .= '</div>';
                }
                
                $data[] = array(
                    $no++,
                    $foto,
                    $nisn_nis,
                    $nama,
                    $kelas_info,
                    $jk,
                    $status_badge,
                    $tanggal,
                    $aksi
                );
            }
            
            echo json_encode(array(
                'success' => true,
                'data' => $data,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data)
            ));
            
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ));
        }
        
        exit;
    }

    public function export_excel()
    {
        // Export functionality can be added here
        $this->session->set_flashdata('info', 'Fitur export Excel akan segera tersedia.');
        redirect('siswa');
    }

    /**
     * Handle grades view for students
     * Redirects students to the proper grading system
     */
    public function nilai()
    {
        $user_level = $this->session->userdata('id_level_user');
        
        // Check if user is a student
        if ($user_level == 4) {
            // Redirect to the proper nilai controller for students
            redirect('nilai');
        } else {
            // For non-students, show access denied
            $this->session->set_flashdata('error', 'Halaman ini khusus untuk siswa. Silakan gunakan menu yang sesuai dengan level akses Anda.');
            redirect('dashboard');
        }
    }
}
?>