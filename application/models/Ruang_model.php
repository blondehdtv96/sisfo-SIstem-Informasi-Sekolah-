<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_model extends CI_Model
{
    protected $table = 'tb_ruang';
    protected $primary_key = 'id_ruang';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('nama_ruang', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        $this->db->where('deleted_at IS NULL');
        return $this->db->get()->row();
    }

    public function get_by_kode($kode)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kode_ruang', $kode);
        $this->db->where('deleted_at IS NULL');
        return $this->db->get()->row();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'Aktif');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('nama_ruang', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_jenis($jenis)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('jenis_ruang', $jenis);
        $this->db->where('status', 'Aktif');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('nama_ruang', 'ASC');
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        // Soft delete
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('id_user')
        );
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results();
    }

    public function count_by_status($status)
    {
        $this->db->from($this->table);
        $this->db->where('status', $status);
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results();
    }

    public function count_by_jenis($jenis)
    {
        $this->db->from($this->table);
        $this->db->where('jenis_ruang', $jenis);
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results();
    }

    public function is_used($id)
    {
        // Check if room is used in classes
        $this->db->from('tb_kelas');
        $this->db->where('id_ruang', $id);
        $this->db->where('deleted_at IS NULL');
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if room is used in schedules
        $this->db->from('tb_jadwal');
        $this->db->where('id_ruang', $id);
        $this->db->where('deleted_at IS NULL');
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        return false;
    }

    public function search($keyword)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->like('kode_ruang', $keyword);
        $this->db->or_like('nama_ruang', $keyword);
        $this->db->or_like('jenis_ruang', $keyword);
        $this->db->or_like('lokasi', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->group_end();
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('nama_ruang', 'ASC');
        return $this->db->get()->result();
    }

    public function get_statistics()
    {
        $stats = array();
        
        // Total by type
        $jenis_ruang = array('Kelas', 'Lab', 'Aula', 'Perpustakaan', 'Kantor', 'Lainnya');
        foreach ($jenis_ruang as $jenis) {
            $stats['by_type'][$jenis] = $this->count_by_jenis($jenis);
        }
        
        // Total capacity
        $this->db->select('SUM(kapasitas) as total_kapasitas');
        $this->db->from($this->table);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('status', 'Aktif');
        $result = $this->db->get()->row();
        $stats['total_capacity'] = $result->total_kapasitas ?: 0;
        
        return $stats;
    }
}
?>