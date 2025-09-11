<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_akademik_model extends CI_Model
{
    protected $table = 'tb_tahun_akademik';
    protected $primary_key = 'id_tahun_akademik';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tahun_ajar', 'DESC');
        return $this->db->get()->result();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('tahun_ajar', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_current()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->limit(1);
        return $this->db->get()->row();
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
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function is_used($id)
    {
        // Check if academic year is used in students
        $this->db->from('tb_siswa');
        $this->db->where('id_tahun_akademik', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if academic year is used in wali kelas
        $this->db->from('tb_wali_kelas');
        $this->db->where('id_tahun_akademik', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        return false;
    }
}
?>