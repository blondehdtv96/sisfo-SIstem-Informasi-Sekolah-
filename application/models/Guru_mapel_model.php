<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_mapel_model extends CI_Model
{
    protected $table = 'tb_guru_mapel';
    protected $primary_key = 'id_guru_mapel';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all teacher-subject assignments with detailed information
     */
    public function get_all()
    {
        $this->db->select('gm.*, g.nama_guru, g.nip, g.nuptk, m.nama_mapel, m.kode_mapel, ta.tahun_ajar');
        $this->db->from($this->table . ' gm');
        $this->db->join('tb_guru g', 'gm.id_guru = g.id_guru');
        $this->db->join('tb_mata_pelajaran m', 'gm.id_mapel = m.id_mapel');
        $this->db->join('tb_tahun_akademik ta', 'gm.id_tahun_akademik = ta.id_tahun_akademik');
        $this->db->order_by('g.nama_guru, m.nama_mapel');
        return $this->db->get()->result();
    }

    /**
     * Get teacher-subject assignment by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('gm.*, g.nama_guru, g.nip, m.nama_mapel, m.kode_mapel, ta.tahun_ajar');
        $this->db->from($this->table . ' gm');
        $this->db->join('tb_guru g', 'gm.id_guru = g.id_guru');
        $this->db->join('tb_mata_pelajaran m', 'gm.id_mapel = m.id_mapel');
        $this->db->join('tb_tahun_akademik ta', 'gm.id_tahun_akademik = ta.id_tahun_akademik');
        $this->db->where('gm.' . $this->primary_key, $id);
        return $this->db->get()->row();
    }

    /**
     * Get assignments by teacher ID
     */
    public function get_by_guru($id_guru, $id_tahun_akademik = null)
    {
        $this->db->select('gm.*, m.nama_mapel, m.kode_mapel, ta.tahun_ajar');
        $this->db->from($this->table . ' gm');
        $this->db->join('tb_mata_pelajaran m', 'gm.id_mapel = m.id_mapel');
        $this->db->join('tb_tahun_akademik ta', 'gm.id_tahun_akademik = ta.id_tahun_akademik');
        $this->db->where('gm.id_guru', $id_guru);
        
        if ($id_tahun_akademik) {
            $this->db->where('gm.id_tahun_akademik', $id_tahun_akademik);
        }
        
        $this->db->order_by('m.nama_mapel');
        return $this->db->get()->result();
    }

    /**
     * Get assignments by subject ID
     */
    public function get_by_mapel($id_mapel, $id_tahun_akademik = null)
    {
        $this->db->select('gm.*, g.nama_guru, g.nip, ta.tahun_ajar');
        $this->db->from($this->table . ' gm');
        $this->db->join('tb_guru g', 'gm.id_guru = g.id_guru');
        $this->db->join('tb_tahun_akademik ta', 'gm.id_tahun_akademik = ta.id_tahun_akademik');
        $this->db->where('gm.id_mapel', $id_mapel);
        
        if ($id_tahun_akademik) {
            $this->db->where('gm.id_tahun_akademik', $id_tahun_akademik);
        }
        
        $this->db->order_by('g.nama_guru');
        return $this->db->get()->result();
    }

    /**
     * Get active assignments for current academic year
     */
    public function get_active_assignments()
    {
        // Get current academic year
        $this->db->where('status', 'aktif');
        $current_year = $this->db->get('tb_tahun_akademik')->row();
        
        if (!$current_year) return [];
        
        $this->db->select('gm.*, g.nama_guru, g.nip, g.status_kepegawaian, m.nama_mapel, m.kode_mapel, m.kategori, ta.tahun_ajar');
        $this->db->from($this->table . ' gm');
        $this->db->join('tb_guru g', 'gm.id_guru = g.id_guru');
        $this->db->join('tb_mata_pelajaran m', 'gm.id_mapel = m.id_mapel');
        $this->db->join('tb_tahun_akademik ta', 'gm.id_tahun_akademik = ta.id_tahun_akademik');
        $this->db->where('gm.id_tahun_akademik', $current_year->id_tahun_akademik);
        $this->db->where('g.status', 'aktif');
        $this->db->where('m.status', 'aktif');
        $this->db->order_by('g.nama_guru, m.nama_mapel');
        return $this->db->get()->result();
    }

    /**
     * Insert new assignment
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update assignment
     */
    public function update($id, $data)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete assignment
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if assignment already exists
     */
    public function assignment_exists($id_guru, $id_mapel, $id_tahun_akademik, $exclude_id = null)
    {
        $this->db->where('id_guru', $id_guru);
        $this->db->where('id_mapel', $id_mapel);
        $this->db->where('id_tahun_akademik', $id_tahun_akademik);
        
        if ($exclude_id) {
            $this->db->where($this->primary_key . ' !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get available teachers (not assigned to specific subject)
     */
    public function get_available_teachers($id_mapel, $id_tahun_akademik = null)
    {
        if (!$id_tahun_akademik) {
            // Get current academic year
            $this->db->where('status', 'aktif');
            $current_year = $this->db->get('tb_tahun_akademik')->row();
            if (!$current_year) return [];
            $id_tahun_akademik = $current_year->id_tahun_akademik;
        }
        
        // Get teachers not assigned to this subject in this academic year
        $this->db->select('g.*');
        $this->db->from('tb_guru g');
        $this->db->where('g.status', 'aktif');
        $this->db->where_not_in('g.id_guru', function($subquery) use ($id_mapel, $id_tahun_akademik) {
            $this->db->select('gm.id_guru');
            $this->db->from('tb_guru_mapel gm');
            $this->db->where('gm.id_mapel', $id_mapel);
            $this->db->where('gm.id_tahun_akademik', $id_tahun_akademik);
            return $this->db->get_compiled_select();
        });
        $this->db->order_by('g.nama_guru');
        return $this->db->get()->result();
    }

    /**
     * Get available subjects (not assigned to specific teacher)
     */
    public function get_available_subjects($id_guru, $id_tahun_akademik = null)
    {
        if (!$id_tahun_akademik) {
            // Get current academic year
            $this->db->where('status', 'aktif');
            $current_year = $this->db->get('tb_tahun_akademik')->row();
            if (!$current_year) return [];
            $id_tahun_akademik = $current_year->id_tahun_akademik;
        }
        
        // Get subjects not assigned to this teacher in this academic year
        $this->db->select('m.*');
        $this->db->from('tb_mata_pelajaran m');
        $this->db->where('m.status', 'aktif');
        
        // Exclude subjects already assigned to this teacher
        $assigned_subjects = $this->db->select('id_mapel')
                                     ->from('tb_guru_mapel')
                                     ->where('id_guru', $id_guru)
                                     ->where('id_tahun_akademik', $id_tahun_akademik)
                                     ->get()->result_array();
        
        if (!empty($assigned_subjects)) {
            $assigned_ids = array_column($assigned_subjects, 'id_mapel');
            $this->db->where_not_in('m.id_mapel', $assigned_ids);
        }
        
        $this->db->order_by('m.nama_mapel');
        return $this->db->get()->result();
    }

    /**
     * Get statistics
     */
    public function get_statistics($id_tahun_akademik = null)
    {
        if (!$id_tahun_akademik) {
            // Get current academic year
            $this->db->where('status', 'aktif');
            $current_year = $this->db->get('tb_tahun_akademik')->row();
            if (!$current_year) return [];
            $id_tahun_akademik = $current_year->id_tahun_akademik;
        }
        
        $stats = [];
        
        // Total assignments
        $this->db->where('id_tahun_akademik', $id_tahun_akademik);
        $stats['total_assignments'] = $this->db->count_all_results($this->table);
        
        // Teachers with assignments
        $this->db->select('DISTINCT id_guru');
        $this->db->where('id_tahun_akademik', $id_tahun_akademik);
        $stats['teachers_with_assignments'] = $this->db->count_all_results($this->table);
        
        // Subjects with assignments
        $this->db->select('DISTINCT id_mapel');
        $this->db->where('id_tahun_akademik', $id_tahun_akademik);
        $stats['subjects_with_assignments'] = $this->db->count_all_results($this->table);
        
        // Teachers without assignments
        $this->db->where('status', 'aktif');
        $total_teachers = $this->db->count_all_results('tb_guru');
        $stats['teachers_without_assignments'] = $total_teachers - $stats['teachers_with_assignments'];
        
        // Subjects without assignments
        $this->db->where('status', 'aktif');
        $total_subjects = $this->db->count_all_results('tb_mata_pelajaran');
        $stats['subjects_without_assignments'] = $total_subjects - $stats['subjects_with_assignments'];
        
        return $stats;
    }

    /**
     * Get teacher workload (number of subjects per teacher)
     */
    public function get_teacher_workload($id_tahun_akademik = null)
    {
        if (!$id_tahun_akademik) {
            // Get current academic year
            $this->db->where('status', 'aktif');
            $current_year = $this->db->get('tb_tahun_akademik')->row();
            if (!$current_year) return [];
            $id_tahun_akademik = $current_year->id_tahun_akademik;
        }
        
        $this->db->select('g.id_guru, g.nama_guru, g.nip, g.status_kepegawaian, COUNT(gm.id_mapel) as jumlah_mapel');
        $this->db->from('tb_guru g');
        $this->db->join('tb_guru_mapel gm', 'g.id_guru = gm.id_guru', 'left');
        $this->db->where('g.status', 'aktif');
        if ($id_tahun_akademik) {
            $this->db->where('gm.id_tahun_akademik', $id_tahun_akademik);
        }
        $this->db->group_by('g.id_guru');
        $this->db->order_by('jumlah_mapel DESC, g.nama_guru');
        return $this->db->get()->result();
    }

    /**
     * Count total assignments
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Bulk insert assignments
     */
    public function bulk_insert($data_array)
    {
        return $this->db->insert_batch($this->table, $data_array);
    }

    /**
     * Delete assignments by academic year
     */
    public function delete_by_academic_year($id_tahun_akademik)
    {
        $this->db->where('id_tahun_akademik', $id_tahun_akademik);
        return $this->db->delete($this->table);
    }

    /**
     * Copy assignments from previous academic year
     */
    public function copy_from_previous_year($from_year_id, $to_year_id)
    {
        // Get assignments from previous year
        $this->db->select('id_guru, id_mapel');
        $this->db->where('id_tahun_akademik', $from_year_id);
        $previous_assignments = $this->db->get($this->table)->result();
        
        if (empty($previous_assignments)) {
            return false;
        }
        
        // Prepare data for new year
        $new_assignments = [];
        foreach ($previous_assignments as $assignment) {
            $new_assignments[] = [
                'id_guru' => $assignment->id_guru,
                'id_mapel' => $assignment->id_mapel,
                'id_tahun_akademik' => $to_year_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        
        return $this->bulk_insert($new_assignments);
    }
}