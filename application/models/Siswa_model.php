<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model
{
    protected $table = 'tb_siswa';
    protected $primary_key = 'id_siswa';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nama_siswa', 'ASC');
        return $this->db->get()->result();
    }

    public function get_all_with_details()
    {
        $this->db->select('s.*, k.nama_kelas, j.nama_jurusan, t.nama_tingkatan, ta.tahun_ajar');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_tahun_akademik ta', 's.id_tahun_akademik = ta.id_tahun_akademik', 'left');
        $this->db->order_by('s.nama_siswa', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_detail_by_id($id)
    {
        $this->db->select('s.*, k.nama_kelas, k.kode_kelas, j.nama_jurusan, j.kode_jurusan, t.nama_tingkatan, ta.tahun_ajar');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_tahun_akademik ta', 's.id_tahun_akademik = ta.id_tahun_akademik', 'left');
        $this->db->where('s.' . $this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_by_nisn($nisn)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nisn', $nisn);
        return $this->db->get()->row();
    }

    public function get_by_nis($nis)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nis', $nis);
        return $this->db->get()->row();
    }

    public function get_by_kelas($id_kelas)
    {
        $this->db->select('s.*, k.nama_kelas');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas');
        $this->db->where('s.id_kelas', $id_kelas);
        $this->db->where('s.status', 'aktif');
        $this->db->order_by('s.nama_siswa', 'ASC');
        return $this->db->get()->result();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_siswa', 'ASC');
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
    
    public function count_by_gender($gender)
    {
        $this->db->from($this->table);
        $this->db->where('jenis_kelamin', $gender);
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results();
    }
    

    


    public function count_by_kelas($id_kelas)
    {
        $this->db->from($this->table);
        $this->db->where('id_kelas', $id_kelas);
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results();
    }

    public function count_by_jurusan($id_jurusan)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas');
        $this->db->where('k.id_jurusan', $id_jurusan);
        $this->db->where('s.status', 'aktif');
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    public function has_grades($id_siswa)
    {
        try {
            $this->db->from('tb_nilai');
            $this->db->where('id_siswa', $id_siswa);
            $count = $this->db->count_all_results();
            return $count > 0;
        } catch (Exception $e) {
            log_message('error', 'Error checking student grades: ' . $e->getMessage());
            return false; // If there's an error, allow deletion (safer approach)
        }
    }

    public function search($keyword)
    {
        $this->db->select('s.*, k.nama_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->group_start();
        $this->db->like('s.nisn', $keyword);
        $this->db->or_like('s.nis', $keyword);
        $this->db->or_like('s.nama_siswa', $keyword);
        $this->db->or_like('k.nama_kelas', $keyword);
        $this->db->or_like('j.nama_jurusan', $keyword);
        $this->db->group_end();
        $this->db->order_by('s.nama_siswa', 'ASC');
        return $this->db->get()->result();
    }

    public function get_statistics()
    {
        $stats = array();
        
        // Statistics by gender
        $this->db->select('jenis_kelamin, COUNT(*) as total');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->group_by('jenis_kelamin');
        $gender_stats = $this->db->get()->result_array();
        
        foreach ($gender_stats as $stat) {
            $stats['by_gender'][$stat['jenis_kelamin']] = $stat['total'];
        }
        
        // Statistics by major
        $this->db->select('j.nama_jurusan, COUNT(*) as total');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
        $this->db->where('s.status', 'aktif');
        $this->db->group_by('j.id_jurusan');
        $major_stats = $this->db->get()->result_array();
        
        foreach ($major_stats as $stat) {
            $stats['by_major'][$stat['nama_jurusan']] = $stat['total'];
        }
        
        // Statistics by grade level
        $this->db->select('t.nama_tingkatan, COUNT(*) as total');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan');
        $this->db->where('s.status', 'aktif');
        $this->db->group_by('t.id_tingkatan');
        $grade_stats = $this->db->get()->result_array();
        
        foreach ($grade_stats as $stat) {
            $stats['by_grade'][$stat['nama_tingkatan']] = $stat['total'];
        }
        
        return $stats;
    }

    public function authenticate($nisn, $password)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nisn', $nisn);
        $this->db->where('status', 'aktif');
        $user = $this->db->get()->row();

        if ($user) {
            // Check password (both new hash and legacy methods)
            if (password_verify($password, $user->password) || 
                md5($password) === $user->password || 
                $password === $user->password) {
                return $user;
            }
        }
        return false;
    }

    /**
     * Get all students with details and filters for reporting
     */
    public function get_all_with_details_filtered($where = array())
    {
        $this->db->select('s.*, k.nama_kelas, k.kode_kelas, j.nama_jurusan, t.nama_tingkatan, ta.tahun_ajar');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->join('tb_tahun_akademik ta', 's.id_tahun_akademik = ta.id_tahun_akademik', 'left');
        
        if (!empty($where)) {
            $this->db->where($where);
        }
        
        $this->db->order_by('j.nama_jurusan', 'ASC');
        $this->db->order_by('k.nama_kelas', 'ASC');
        $this->db->order_by('s.nama_siswa', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get statistics by gender for reporting
     */
    public function get_statistics_by_gender()
    {
        $this->db->select('jenis_kelamin, COUNT(*) as total');
        $this->db->from($this->table);
        $this->db->group_by('jenis_kelamin');
        $this->db->order_by('jenis_kelamin', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get statistics by major for reporting
     */
    public function get_statistics_by_jurusan()
    {
        $this->db->select('j.nama_jurusan, COUNT(s.id_siswa) as total');
        $this->db->from($this->table . ' s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->group_by('j.id_jurusan');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }
}
?>