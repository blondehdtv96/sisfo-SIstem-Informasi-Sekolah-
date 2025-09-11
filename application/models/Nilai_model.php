<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_model extends CI_Model
{
    protected $table = 'tb_nilai';
    protected $primary_key = 'id_nilai';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get subjects taught by a teacher in current academic year
     */
    public function get_teacher_subjects($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('gm.*, m.nama_mapel, m.kode_mapel, m.kategori');
        $this->db->from('tb_guru_mapel gm');
        $this->db->join('tb_mata_pelajaran m', 'gm.id_mapel = m.id_mapel');
        $this->db->where('gm.id_guru', $guru_id);
        $this->db->where('gm.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('m.status', 'aktif');
        $this->db->order_by('m.nama_mapel');
        
        return $this->db->get()->result();
    }

    /**
     * Get classes for a specific subject taught by teacher
     */
    public function get_teacher_classes($guru_id, $mapel_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        // First check if teacher is assigned to this subject
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_mapel', $mapel_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $assignment = $this->db->get('tb_guru_mapel')->row();
        
        if (!$assignment) {
            return []; // Teacher not assigned to this subject
        }
        
        // Try to get classes from schedule first
        $this->db->distinct();
        $this->db->select('k.id_kelas, k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from('tb_jadwal jd');
        $this->db->join('tb_kelas k', 'jd.id_kelas = k.id_kelas');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan');
        $this->db->where('jd.id_guru', $guru_id);
        $this->db->where('jd.id_mapel', $mapel_id);
        $this->db->where('jd.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('jd.status', 'aktif');
        $this->db->order_by('t.nama_tingkatan, j.nama_jurusan, k.nama_kelas');
        
        $scheduled_classes = $this->db->get()->result();
        
        // If no scheduled classes found, return all active classes
        // (assuming teacher can teach the subject to any class)
        if (empty($scheduled_classes)) {
            $this->db->select('k.id_kelas, k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan');
            $this->db->from('tb_kelas k');
            $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
            $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan');
            $this->db->where('k.status', 'aktif');
            $this->db->order_by('t.nama_tingkatan, j.nama_jurusan, k.nama_kelas');
            
            return $this->db->get()->result();
        }
        
        return $scheduled_classes;
    }

    /**
     * Get students in a class for grade input
     */
    public function get_class_students($kelas_id)
    {
        $this->db->select('s.id_siswa, s.nisn, s.nis, s.nama_siswa, s.jenis_kelamin');
        $this->db->from('tb_siswa s');
        $this->db->where('s.id_kelas', $kelas_id);
        $this->db->where('s.status', 'aktif');
        $this->db->order_by('s.nama_siswa');
        
        return $this->db->get()->result();
    }

    /**
     * Get existing grades for students in a subject
     */
    public function get_existing_grades($kelas_id, $mapel_id, $kategori_nilai = null, $semester = null)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('n.*, s.nama_siswa, s.nisn');
        $this->db->from('tb_nilai n');
        $this->db->join('tb_siswa s', 'n.id_siswa = s.id_siswa');
        $this->db->where('s.id_kelas', $kelas_id);
        $this->db->where('n.id_mapel', $mapel_id);
        $this->db->where('n.id_tahun_akademik', $current_year->id_tahun_akademik);
        
        if ($kategori_nilai) {
            $this->db->where('n.kategori_nilai', $kategori_nilai);
        }
        
        if ($semester) {
            $this->db->where('n.semester', $semester);
        }
        
        $this->db->order_by('s.nama_siswa');
        
        return $this->db->get()->result();
    }

    /**
     * Insert or update grade
     */
    public function save_grade($data)
    {
        // Check if grade already exists
        $existing = $this->db->get_where($this->table, [
            'id_siswa' => $data['id_siswa'],
            'id_mapel' => $data['id_mapel'],
            'id_tahun_akademik' => $data['id_tahun_akademik'],
            'semester' => $data['semester'],
            'kategori_nilai' => $data['kategori_nilai']
        ])->row();
        
        if ($existing) {
            // Update existing grade
            $this->db->where('id_nilai', $existing->id_nilai);
            return $this->db->update($this->table, [
                'nilai' => $data['nilai'],
                'keterangan' => $data['keterangan'] ?? null,
                'id_guru' => $data['id_guru'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Insert new grade
            return $this->db->insert($this->table, $data);
        }
    }

    /**
     * Get student grades for a specific subject
     */
    public function get_student_subject_grades($siswa_id, $mapel_id = null)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('n.*, m.nama_mapel, m.kode_mapel, g.nama_guru');
        $this->db->from('tb_nilai n');
        $this->db->join('tb_mata_pelajaran m', 'n.id_mapel = m.id_mapel');
        $this->db->join('tb_guru g', 'n.id_guru = g.id_guru', 'left');
        $this->db->where('n.id_siswa', $siswa_id);
        $this->db->where('n.id_tahun_akademik', $current_year->id_tahun_akademik);
        
        if ($mapel_id) {
            $this->db->where('n.id_mapel', $mapel_id);
        }
        
        $this->db->order_by('m.nama_mapel, n.kategori_nilai');
        
        return $this->db->get()->result();
    }

    /**
     * Get all student grades grouped by subject
     */
    public function get_student_all_grades($siswa_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('m.id_mapel, m.nama_mapel, m.kode_mapel, m.kategori,
                          AVG(n.nilai) as rata_rata,
                          MAX(CASE WHEN n.kategori_nilai = "tugas" THEN n.nilai END) as nilai_tugas,
                          MAX(CASE WHEN n.kategori_nilai = "ulangan_harian" THEN n.nilai END) as nilai_uh,
                          MAX(CASE WHEN n.kategori_nilai = "uts" THEN n.nilai END) as nilai_uts,
                          MAX(CASE WHEN n.kategori_nilai = "uas" THEN n.nilai END) as nilai_uas,
                          MAX(CASE WHEN n.kategori_nilai = "praktek" THEN n.nilai END) as nilai_praktek,
                          g.nama_guru');
        $this->db->from('tb_mata_pelajaran m');
        $this->db->join('tb_nilai n', 'm.id_mapel = n.id_mapel', 'left');
        $this->db->join('tb_guru g', 'n.id_guru = g.id_guru', 'left');
        $this->db->where('n.id_siswa', $siswa_id);
        $this->db->where('n.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->group_by('m.id_mapel');
        $this->db->order_by('m.nama_mapel');
        
        return $this->db->get()->result();
    }

    /**
     * Calculate final grade based on category weights
     */
    public function calculate_final_grade($siswa_id, $mapel_id, $semester)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return null;
        
        // Weight configuration (can be moved to config)
        $weights = [
            'tugas' => 0.2,           // 20%
            'ulangan_harian' => 0.3,  // 30%
            'uts' => 0.2,            // 20%
            'uas' => 0.3             // 30%
        ];
        
        $grades = [];
        $this->db->select('kategori_nilai, AVG(nilai) as rata_nilai');
        $this->db->from('tb_nilai');
        $this->db->where('id_siswa', $siswa_id);
        $this->db->where('id_mapel', $mapel_id);
        $this->db->where('semester', $semester);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->group_by('kategori_nilai');
        $result = $this->db->get()->result();
        
        foreach ($result as $row) {
            $grades[$row->kategori_nilai] = $row->rata_nilai;
        }
        
        // Calculate weighted average
        $final_score = 0;
        $total_weight = 0;
        
        foreach ($weights as $category => $weight) {
            if (isset($grades[$category])) {
                $final_score += $grades[$category] * $weight;
                $total_weight += $weight;
            }
        }
        
        return $total_weight > 0 ? round($final_score / $total_weight, 2) : 0;
    }

    /**
     * Get grade statistics for teacher dashboard
     */
    public function get_teacher_grade_stats($guru_id)
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $stats = [];
        
        // Total grades inputted
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $stats['total_grades'] = $this->db->count_all_results('tb_nilai');
        
        // Students graded
        $this->db->select('DISTINCT id_siswa');
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $stats['students_graded'] = $this->db->count_all_results('tb_nilai');
        
        // Average grade
        $this->db->select('AVG(nilai) as rata_rata');
        $this->db->where('id_guru', $guru_id);
        $this->db->where('id_tahun_akademik', $current_year->id_tahun_akademik);
        $result = $this->db->get('tb_nilai')->row();
        $stats['average_grade'] = $result ? round($result->rata_rata, 1) : 0;
        
        return $stats;
    }

    /**
     * Delete grade
     */
    public function delete_grade($id_nilai)
    {
        return $this->db->delete($this->table, [$this->primary_key => $id_nilai]);
    }

    /**
     * Bulk insert grades
     */
    public function bulk_insert_grades($grades_data)
    {
        return $this->db->insert_batch($this->table, $grades_data);
    }
}