<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_users()
    {
        $this->db->select('u.*, l.nama_level');
        $this->db->from('tb_user u');
        $this->db->join('tb_level_user l', 'u.id_level = l.id_level');
        $this->db->order_by('u.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_user_by_id($id)
    {
        $this->db->select('u.*, l.nama_level');
        $this->db->from('tb_user u');
        $this->db->join('tb_level_user l', 'u.id_level = l.id_level');
        $this->db->where('u.id_user', $id);
        return $this->db->get()->row();
    }

    public function get_user_levels()
    {
        $this->db->order_by('id_level');
        return $this->db->get('tb_level_user')->result();
    }

    public function insert_user($data)
    {
        return $this->db->insert('tb_user', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('tb_user', $data);
    }

    public function delete_user($id)
    {
        // Soft delete by updating status
        $this->db->where('id_user', $id);
        return $this->db->update('tb_user', ['status' => 'nonaktif']);
    }

    public function check_username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id_user !=', $exclude_id);
        }
        $query = $this->db->get('tb_user');
        return $query->num_rows() > 0;
    }

    public function get_active_users_count()
    {
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results('tb_user');
    }

    public function get_users_by_level($level_id)
    {
        $this->db->where('id_level', $level_id);
        $this->db->where('status', 'aktif');
        return $this->db->get('tb_user')->result();
    }
}