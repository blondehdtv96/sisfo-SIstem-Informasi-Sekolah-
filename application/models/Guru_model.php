<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model
{
    protected $table = 'tb_guru';
    protected $primary_key = 'id_guru';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nama_guru', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->primary_key, $id);
        return $this->db->get()->row();
    }

    public function get_by_nip($nip)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nip', $nip);
        return $this->db->get()->row();
    }

    public function get_by_nuptk($nuptk)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nuptk', $nuptk);
        return $this->db->get()->row();
    }

    public function get_by_username($username)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        return $this->db->get()->row();
    }

    public function get_active()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_guru', 'ASC');
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
    
    public function count_by_status_kepegawaian($status_kepegawaian)
    {
        $this->db->from($this->table);
        $this->db->where('status_kepegawaian', $status_kepegawaian);
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results();
    }
    


    public function count_by_kepegawaian($status_kepegawaian)
    {
        $this->db->from($this->table);
        $this->db->where('status_kepegawaian', $status_kepegawaian);
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results();
    }

    public function is_used($id_guru)
    {
        // Check if teacher is used in wali kelas
        $this->db->from('tb_wali_kelas');
        $this->db->where('id_guru', $id_guru);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if teacher is used in guru mapel
        $this->db->from('tb_guru_mapel');
        $this->db->where('id_guru', $id_guru);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if teacher is used in jadwal
        $this->db->from('tb_jadwal');
        $this->db->where('id_guru', $id_guru);
        if ($this->db->count_all_results() > 0) {
            return true;
        }

        // Check if teacher is used in nilai
        $this->db->from('tb_nilai');
        $this->db->where('id_guru', $id_guru);
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
        $this->db->like('nip', $keyword);
        $this->db->or_like('nuptk', $keyword);
        $this->db->or_like('nama_guru', $keyword);
        $this->db->or_like('jabatan', $keyword);
        $this->db->or_like('pendidikan_terakhir', $keyword);
        $this->db->group_end();
        $this->db->order_by('nama_guru', 'ASC');
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
        
        // Statistics by employment status
        $this->db->select('status_kepegawaian, COUNT(*) as total');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->group_by('status_kepegawaian');
        $employment_stats = $this->db->get()->result_array();
        
        foreach ($employment_stats as $stat) {
            $stats['by_employment'][$stat['status_kepegawaian']] = $stat['total'];
        }
        
        return $stats;
    }

    public function authenticate($username, $password)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->where('status', 'aktif');
        $user = $this->db->get()->row();

        if ($user) {
            // Check password (both new hash and legacy methods)
            if (password_verify($password, $user->password) || 
                md5($password) === $user->password || 
                $password === $user->password) {
                
                // Update last login
                $this->update($user->id_guru, array('last_login' => date('Y-m-d H:i:s')));
                return $user;
            }
        }
        return false;
    }

    /**
     * Get statistics by gender for reporting
     */
    public function get_statistics_by_gender()
    {
        $this->db->select('jenis_kelamin, COUNT(*) as total');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->group_by('jenis_kelamin');
        $this->db->order_by('jenis_kelamin', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get statistics by employment status for reporting
     */
    public function get_statistics_by_employment()
    {
        $this->db->select('status_kepegawaian, COUNT(*) as total');
        $this->db->from($this->table);
        $this->db->where('status', 'aktif');
        $this->db->group_by('status_kepegawaian');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }
}
?>