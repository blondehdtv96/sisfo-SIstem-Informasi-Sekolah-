<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model
{
    protected $table = 'tb_kelas';
    protected $primary_key = 'id_kelas';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get()->result();
    }

    public function get_all_with_details()
    {
        $this->db->select('k.*, t.nama_tingkatan, j.nama_jurusan, j.kode_jurusan, ta.tahun_ajar, ta.semester');
        $this->db->from($this->table . ' k');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tahun_akademik ta', 'ta.status = "aktif"', 'left');
        $this->db->order_by('t.nama_tingkatan', 'ASC');
        $this->db->order_by('j.nama_jurusan', 'ASC');
        $this->db->order_by('k.rombel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get()->result();
    }

    public function get_active_with_details()
    {
        $this->db->select('k.*, t.nama_tingkatan, j.nama_jurusan, j.kode_jurusan, ta.tahun_ajar, ta.semester');
        $this->db->from($this->table . ' k');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tahun_akademik ta', 'ta.status = "aktif"', 'left');
        $this->db->where('k.status', 'aktif');
        $this->db->order_by('t.nama_tingkatan', 'ASC');
        $this->db->order_by('j.nama_jurusan', 'ASC');
        $this->db->order_by('k.rombel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_by_nama($nama)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nama_kelas', $nama);
        return $this->db->get()->row();
    }

    public function get_by_jurusan($id_jurusan)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_kelas', 'ASC');
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
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
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
        // Check if class has students
        $this->db->from('tb_siswa');
        $this->db->where('id_kelas', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        return false;
    }

    public function search($keyword)
    {
        $this->db->select('k.*, t.nama_tingkatan, j.nama_jurusan, j.kode_jurusan, ta.tahun_ajar, ta.semester');
        $this->db->from($this->table . ' k');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tahun_akademik ta', 'ta.status = "aktif"', 'left');
        $this->db->group_start();
        $this->db->like('k.nama_kelas', $keyword);
        $this->db->or_like('k.kode_kelas', $keyword);
        $this->db->or_like('k.rombel', $keyword);
        $this->db->or_like('t.nama_tingkatan', $keyword);
        $this->db->or_like('j.nama_jurusan', $keyword);
        $this->db->group_end();
        $this->db->order_by('t.nama_tingkatan', 'ASC');
        $this->db->order_by('j.nama_jurusan', 'ASC');
        $this->db->order_by('k.rombel', 'ASC');
        return $this->db->get()->result();
    }
    
    public function check_duplicate_class($id_tingkatan, $id_jurusan, $rombel, $exclude_id = null)
    {
        $this->db->where('id_tingkatan', $id_tingkatan);
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->where('rombel', $rombel);
        
        if ($exclude_id) {
            $this->db->where('id_kelas !=', $exclude_id);
        }
        
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }
}