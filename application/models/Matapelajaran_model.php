<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matapelajaran_model extends CI_Model
{
    protected $table = 'tb_mata_pelajaran';
    protected $primary_key = 'id_mapel';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_by_kode($kode)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kode_mapel', $kode);
        return $this->db->get()->row();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_mapel', 'ASC');
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
            'status' => 'nonaktif',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function count_by_status($status)
    {
        $this->db->from($this->table);
        $this->db->where('status', $status);
        return $this->db->count_all_results();
    }
    
    public function count_active()
    {
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results();
    }

    public function is_used($id)
    {
        // Check if subject is used in guru_mapel
        $this->db->from('tb_guru_mapel');
        $this->db->where('id_mapel', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if subject is used in schedules
        $this->db->from('tb_jadwal');
        $this->db->where('id_mapel', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if subject is used in grades
        $this->db->from('tb_nilai');
        $this->db->where('id_mapel', $id);
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
        $this->db->like('kode_mapel', $keyword);
        $this->db->or_like('nama_mapel', $keyword);
        $this->db->group_end();
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get()->result();
    }
}
?>