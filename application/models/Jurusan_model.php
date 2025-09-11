<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan_model extends CI_Model
{
    protected $table = 'tb_jurusan';
    protected $primary_key = 'id_jurusan';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nama_jurusan', 'ASC');
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
        $this->db->where('kode_jurusan', $kode);
        return $this->db->get()->row();
    }

    public function get_by_nama($nama)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nama_jurusan', $nama);
        return $this->db->get()->row();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_jurusan', 'ASC');
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
        // Check if major is used in classes
        $this->db->from('tb_kelas');
        $this->db->where('id_jurusan', $id);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if major is used in students
        $this->db->from('tb_siswa');
        $this->db->where('id_jurusan', $id);
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
        $this->db->like('kode_jurusan', $keyword);
        $this->db->or_like('nama_jurusan', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->group_end();
        $this->db->order_by('nama_jurusan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from($this->table);

        // Search functionality
        if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search = $_POST['search']['value'];
            $this->db->group_start();
            $this->db->like('kode_jurusan', $search);
            $this->db->or_like('nama_jurusan', $search);
            $this->db->or_like('deskripsi', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        // Order functionality
        if (isset($_POST['order'])) {
            $column_order = array('kode_jurusan', 'nama_jurusan', 'deskripsi', 'status', 'created_at');
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('nama_jurusan', 'ASC');
        }
    }
}
?>