<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get statistics for Administrator
     */
    public function get_admin_stats()
    {
        $stats = [];
        
        try {
            // Total Siswa
            $this->db->where('status', 'aktif');
            $stats['total_siswa'] = $this->db->count_all_results('tb_siswa');
            
            // Total Guru
            $this->db->where('status', 'aktif');
            $stats['total_guru'] = $this->db->count_all_results('tb_guru');
            
            // Total Kelas
            $this->db->where('status', 'aktif');
            $stats['total_kelas'] = $this->db->count_all_results('tb_kelas');
            
            // Total Mata Pelajaran
            $this->db->where('status', 'aktif');
            $stats['total_mapel'] = $this->db->count_all_results('tb_mata_pelajaran');
            
            // Total User
            $this->db->where('status', 'aktif');
            $stats['total_user'] = $this->db->count_all_results('tb_user');
            
            // Total Jurusan
            $this->db->where('status', 'aktif');
            $stats['total_jurusan'] = $this->db->count_all_results('tb_jurusan');
            
        } catch (Exception $e) {
            // Log error and return default values
            log_message('error', 'Dashboard_model::get_admin_stats() - ' . $e->getMessage());
            $stats = [
                'total_siswa' => 0,
                'total_guru' => 0,
                'total_kelas' => 0,
                'total_mapel' => 0,
                'total_user' => 0,
                'total_jurusan' => 0
            ];
        }
        
        return $stats;
    }

    /**
     * Get statistics for Wali Kelas
     */
    public function get_walikelas_stats($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        // Get wali kelas info
        $this->db->select('wk.*, k.nama_kelas, k.kode_kelas');
        $this->db->from('tb_wali_kelas wk');
        $this->db->join('tb_kelas k', 'wk.id_kelas = k.id_kelas');
        $this->db->where('wk.id_guru', $guru_id);
        $this->db->where('wk.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('wk.status', 'aktif');
        $wali_kelas = $this->db->get()->row();
        
        $stats = [];
        
        if ($wali_kelas) {
            // Total siswa in class
            $this->db->where('id_kelas', $wali_kelas->id_kelas);
            $this->db->where('status', 'aktif');
            $stats['total_siswa_kelas'] = $this->db->count_all_results('tb_siswa');
            
            // Male students
            $this->db->where('id_kelas', $wali_kelas->id_kelas);
            $this->db->where('jenis_kelamin', 'L');
            $this->db->where('status', 'aktif');
            $stats['siswa_laki'] = $this->db->count_all_results('tb_siswa');
            
            // Female students
            $this->db->where('id_kelas', $wali_kelas->id_kelas);
            $this->db->where('jenis_kelamin', 'P');
            $this->db->where('status', 'aktif');
            $stats['siswa_perempuan'] = $this->db->count_all_results('tb_siswa');
            
            $stats['kelas_info'] = $wali_kelas;
        }
        
        return $stats;
    }

    /**
     * Get statistics for Guru
     */
    public function get_guru_stats($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $stats = [];
        
        // Total mata pelajaran yang diajar
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $stats['total_mapel_ajar'] = $this->db->count_all_results('tb_guru_mapel');
        
        // Total kelas yang diajar
        $this->db->distinct();
        $this->db->select('id_kelas');
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('status', 'aktif');
        $stats['total_kelas_ajar'] = $this->db->count_all_results('tb_jadwal');
        
        // Total siswa yang diajar (from all classes)
        $this->db->select('COUNT(DISTINCT s.id_siswa) as total');
        $this->db->from('tb_siswa s');
        $this->db->join('tb_jadwal j', 's.id_kelas = j.id_kelas');
        $this->db->where('j.id_guru', $guru_id);
        $this->db->where('j.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('s.status', 'aktif');
        $result = $this->db->get()->row();
        $stats['total_siswa_ajar'] = $result ? $result->total : 0;
        
        return $stats;
    }

    /**
     * Get student information
     */
    public function get_student_info($siswa_id)
    {
        $this->db->select('s.*, k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan, ta.tahun_ajar');
        $this->db->from('tb_siswa s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_tahun_akademik ta', 's.id_tahun_akademik = ta.id_tahun_akademik', 'left');
        $this->db->where('s.id_siswa', $siswa_id);
        
        return $this->db->get()->row();
    }

    /**
     * Get recent activities (for admin dashboard)
     */
    public function get_recent_activities($limit = 5)
    {
        // This is a simplified version - you can expand based on your audit log requirements
        $activities = [];
        
        // Recent student registrations
        $this->db->select('nama_siswa as name, created_at, "Siswa baru terdaftar" as activity');
        $this->db->from('tb_siswa');
        $this->db->where('status', 'aktif');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(3);
        $students = $this->db->get()->result();
        
        foreach ($students as $student) {
            $activities[] = [
                'icon' => 'fas fa-user-plus text-success',
                'title' => $student->activity,
                'description' => $student->name,
                'time' => time_elapsed_string($student->created_at)
            ];
        }
        
        return array_slice($activities, 0, $limit);
    }

    /**
     * Get chart data for admin dashboard
     */
    public function get_chart_data()
    {
        $data = [];
        
        try {
            // Student by gender
            $this->db->select('jenis_kelamin, COUNT(*) as total');
            $this->db->from('tb_siswa');
            $this->db->where('status', 'aktif');
            $this->db->group_by('jenis_kelamin');
            $gender_data = $this->db->get()->result();
            
            $data['gender'] = [
                'labels' => [],
                'data' => []
            ];
            
            foreach ($gender_data as $item) {
                $data['gender']['labels'][] = $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                $data['gender']['data'][] = (int)$item->total;
            }
            
            // If no gender data, provide default
            if (empty($data['gender']['labels'])) {
                $data['gender']['labels'] = ['Laki-laki', 'Perempuan'];
                $data['gender']['data'] = [0, 0];
            }
            
            // Students by major
            $this->db->select('j.nama_jurusan, COUNT(s.id_siswa) as total');
            $this->db->from('tb_siswa s');
            $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
            $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
            $this->db->where('s.status', 'aktif');
            $this->db->group_by('j.id_jurusan');
            $major_data = $this->db->get()->result();
            
            $data['major'] = [
                'labels' => [],
                'data' => []
            ];
            
            foreach ($major_data as $item) {
                if ($item->nama_jurusan) {
                    $data['major']['labels'][] = $item->nama_jurusan;
                    $data['major']['data'][] = (int)$item->total;
                }
            }
            
            // If no major data, provide default
            if (empty($data['major']['labels'])) {
                $data['major']['labels'] = ['Teknik Komputer Jaringan'];
                $data['major']['data'] = [0];
            }
            
            // Debug log
            log_message('debug', 'Dashboard chart data: ' . json_encode($data));
            
        } catch (Exception $e) {
            // Log error and return default values
            log_message('error', 'Dashboard_model::get_chart_data() - ' . $e->getMessage());
            $data = [
                'gender' => [
                    'labels' => ['Laki-laki', 'Perempuan'],
                    'data' => [0, 0]
                ],
                'major' => [
                    'labels' => ['Teknik Komputer Jaringan'],
                    'data' => [0]
                ]
            ];
        }
        
        return $data;
    }

    /**
     * Get class information for Wali Kelas
     */
    public function get_class_info($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return null;
        
        $this->db->select('wk.*, k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from('tb_wali_kelas wk');
        $this->db->join('tb_kelas k', 'wk.id_kelas = k.id_kelas');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan');
        $this->db->where('wk.id_guru', $guru_id);
        $this->db->where('wk.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('wk.status', 'aktif');
        
        return $this->db->get()->row();
    }

    /**
     * Get teaching schedule for Guru
     */
    public function get_teaching_schedule($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('j.*, m.nama_mapel, k.nama_kelas, r.nama_ruangan');
        $this->db->from('tb_jadwal j');
        $this->db->join('tb_mata_pelajaran m', 'j.id_mapel = m.id_mapel');
        $this->db->join('tb_kelas k', 'j.id_kelas = k.id_kelas');
        $this->db->join('tb_ruangan r', 'j.id_ruangan = r.id_ruangan');
        $this->db->where('j.id_guru', $guru_id);
        $this->db->where('j.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('j.status', 'aktif');
        $this->db->order_by('FIELD(j.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")');
        $this->db->order_by('j.jam_mulai');
        
        return $this->db->get()->result();
    }

    /**
     * Get student grades
     */
    public function get_student_grades($siswa_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('n.*, m.nama_mapel');
        $this->db->from('tb_nilai n');
        $this->db->join('tb_mata_pelajaran m', 'n.id_mapel = m.id_mapel');
        $this->db->where('n.id_siswa', $siswa_id);
        $this->db->where('n.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->order_by('m.nama_mapel');
        
        return $this->db->get()->result();
    }

    /**
     * Get student schedule
     */
    public function get_student_schedule($kelas_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('j.*, m.nama_mapel, g.nama_guru, r.nama_ruangan');
        $this->db->from('tb_jadwal j');
        $this->db->join('tb_mata_pelajaran m', 'j.id_mapel = m.id_mapel');
        $this->db->join('tb_guru g', 'j.id_guru = g.id_guru');
        $this->db->join('tb_ruangan r', 'j.id_ruangan = r.id_ruangan');
        $this->db->where('j.id_kelas', $kelas_id);
        $this->db->where('j.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('j.status', 'aktif');
        $this->db->order_by('FIELD(j.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")');
        $this->db->order_by('j.jam_mulai');
        
        return $this->db->get()->result();
    }
}

// Helper function for time elapsed
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }
}