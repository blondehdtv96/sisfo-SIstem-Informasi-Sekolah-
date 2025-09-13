<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        $user_level = $this->session->userdata('id_level_user');
        $user_type = $this->session->userdata('user_type');
        
        $data['page_title'] = 'Dashboard';
        $data['breadcrumb'] = [
            ['title' => 'Dashboard']
        ];
        
        // Initialize content variable
        $content = '';
        
        // Get statistics based on user level
        if ($user_level == 1) { // Administrator
            try {
                $data['stats'] = $this->Dashboard_model->get_admin_stats();
                $data['recent_activities'] = $this->Dashboard_model->get_recent_activities();
                $data['chart_data'] = $this->Dashboard_model->get_chart_data();
                
                // Debug: Log chart data
                log_message('debug', 'Chart data: ' . json_encode($data['chart_data']));
                
                $content = $this->load->view('dashboard/admin', $data, TRUE);
            } catch (Exception $e) {
                log_message('error', 'Dashboard::index() Admin - ' . $e->getMessage());
                // Provide default values if database error occurs
                $data['stats'] = [
                    'total_siswa' => 0,
                    'total_guru' => 0,
                    'total_kelas' => 0,
                    'total_mapel' => 0,
                    'total_user' => 0,
                    'total_jurusan' => 0
                ];
                $data['recent_activities'] = [];
                $data['chart_data'] = [
                    'gender' => ['labels' => ['Laki-laki', 'Perempuan'], 'data' => [0, 0]],
                    'major' => ['labels' => ['Teknik Komputer Jaringan'], 'data' => [0]]
                ];
                $content = $this->load->view('dashboard/admin', $data, TRUE);
            }
            
        } elseif ($user_level == 2) { // Wali Kelas
            $data['stats'] = $this->Dashboard_model->get_walikelas_stats($this->session->userdata('guru_id'));
            $data['class_info'] = $this->Dashboard_model->get_class_info($this->session->userdata('guru_id'));
            $content = $this->load->view('dashboard/walikelas', $data, TRUE);
            
        } elseif ($user_level == 3) { // Guru
            $data['stats'] = $this->Dashboard_model->get_guru_stats($this->session->userdata('guru_id'));
            $data['teaching_schedule'] = $this->Dashboard_model->get_teaching_schedule($this->session->userdata('guru_id'));
            $content = $this->load->view('dashboard/guru', $data, TRUE);
            
        } elseif ($user_level == 4) { // Siswa
            $data['student_info'] = $this->Dashboard_model->get_student_info($this->session->userdata('siswa_id'));
            $data['grades'] = $this->Dashboard_model->get_student_grades($this->session->userdata('siswa_id'));
            $data['schedule'] = $this->Dashboard_model->get_student_schedule($this->session->userdata('kelas_id'));
            $content = $this->load->view('dashboard/siswa', $data, TRUE);
        } else {
            // Fallback for unknown user level
            $content = '<div class="alert alert-warning">Dashboard tidak tersedia untuk level user ini.</div>';
        }
        
        $data['contents'] = $content;
        $this->load->view('template_new', $data);
    }
}