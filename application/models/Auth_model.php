<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login for Admin/User
     */
    public function login_user($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('status', 'aktif');
        $query = $this->db->get('tb_user');
        
        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            
            // Check password (support both MD5 and password_hash)
            if (password_verify($password, $user['password']) || md5($password) == $user['password']) {
                // Update last login
                $this->db->where('id_user', $user['id_user']);
                $this->db->update('tb_user', ['last_login' => date('Y-m-d H:i:s')]);
                
                return $user;
            }
        }
        
        return false;
    }

    /**
     * Login for Teacher/Guru
     */
    public function login_guru($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('status', 'aktif');
        $query = $this->db->get('tb_guru');
        
        if ($query->num_rows() == 1) {
            $guru = $query->row_array();
            
            // Check password (support both MD5 and password_hash)
            if (password_verify($password, $guru['password']) || md5($password) == $guru['password']) {
                // Update last login
                $this->db->where('id_guru', $guru['id_guru']);
                $this->db->update('tb_guru', ['last_login' => date('Y-m-d H:i:s')]);
                
                return $guru;
            }
        }
        
        return false;
    }

    /**
     * Login for Student using NISN
     */
    public function login_siswa($nisn, $password)
    {
        $this->db->select('s.*, k.nama_kelas, j.nama_jurusan, t.nama_tingkatan');
        $this->db->from('tb_siswa s');
        $this->db->join('tb_kelas k', 's.id_kelas = k.id_kelas', 'left');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan', 'left');
        $this->db->join('tb_tingkatan t', 'k.id_tingkatan = t.id_tingkatan', 'left');
        $this->db->where('s.nisn', $nisn);
        $this->db->where('s.status', 'aktif');
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            $siswa = $query->row_array();
            
            // For student, password is default NISN or custom password
            $default_password = $nisn; // Default password is NISN
            
            if (empty($siswa['password'])) {
                // If no password set, use NISN as default
                if ($password == $default_password) {
                    return $siswa;
                }
            } else {
                // Check custom password
                if (password_verify($password, $siswa['password']) || md5($password) == $siswa['password'] || $password == $siswa['password']) {
                    return $siswa;
                }
            }
        }
        
        return false;
    }

    /**
     * Save remember token
     */
    public function save_remember_token($user, $type, $token)
    {
        $data = [
            'token' => $token,
            'user_type' => $type,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        switch ($type) {
            case 'user':
                $data['user_id'] = $user['id_user'];
                break;
            case 'guru':
                $data['guru_id'] = $user['id_guru'];
                break;
            case 'siswa':
                $data['siswa_id'] = $user['id_siswa'];
                break;
        }
        
        // Create remember tokens table if not exists
        $this->db->query("
            CREATE TABLE IF NOT EXISTS tb_remember_tokens (
                id INT PRIMARY KEY AUTO_INCREMENT,
                token VARCHAR(255) NOT NULL,
                user_type ENUM('user', 'guru', 'siswa') NOT NULL,
                user_id INT NULL,
                guru_id INT NULL,
                siswa_id INT NULL,
                expires_at TIMESTAMP NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_token (token),
                INDEX idx_expires (expires_at)
            )
        ");
        
        return $this->db->insert('tb_remember_tokens', $data);
    }

    /**
     * Get user by remember token
     */
    public function get_user_by_remember_token($token)
    {
        $this->db->where('token', $token);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $query = $this->db->get('tb_remember_tokens');
        
        if ($query->num_rows() == 1) {
            $token_data = $query->row_array();
            
            switch ($token_data['user_type']) {
                case 'user':
                    $user_query = $this->db->get_where('tb_user', ['id_user' => $token_data['user_id'], 'status' => 'aktif']);
                    if ($user_query->num_rows() == 1) {
                        return [
                            'user_data' => $user_query->row_array(),
                            'user_type' => 'user'
                        ];
                    }
                    break;
                    
                case 'guru':
                    $guru_query = $this->db->get_where('tb_guru', ['id_guru' => $token_data['guru_id'], 'status' => 'aktif']);
                    if ($guru_query->num_rows() == 1) {
                        return [
                            'user_data' => $guru_query->row_array(),
                            'user_type' => 'guru'
                        ];
                    }
                    break;
                    
                case 'siswa':
                    $siswa_query = $this->db->get_where('tb_siswa', ['id_siswa' => $token_data['siswa_id'], 'status' => 'aktif']);
                    if ($siswa_query->num_rows() == 1) {
                        return [
                            'user_data' => $siswa_query->row_array(),
                            'user_type' => 'siswa'
                        ];
                    }
                    break;
            }
        }
        
        return false;
    }

    /**
     * Clear remember token
     */
    public function clear_remember_token($token)
    {
        $this->db->where('token', $token);
        return $this->db->delete('tb_remember_tokens');
    }

    /**
     * Clean expired tokens
     */
    public function clean_expired_tokens()
    {
        $this->db->where('expires_at <', date('Y-m-d H:i:s'));
        return $this->db->delete('tb_remember_tokens');
    }

    /**
     * Change password
     */
    public function change_password($user_id, $user_type, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        switch ($user_type) {
            case 'user':
                $this->db->where('id_user', $user_id);
                return $this->db->update('tb_user', ['password' => $hashed_password]);
                
            case 'guru':
                $this->db->where('id_guru', $user_id);
                return $this->db->update('tb_guru', ['password' => $hashed_password]);
                
            case 'siswa':
                $this->db->where('id_siswa', $user_id);
                return $this->db->update('tb_siswa', ['password' => $hashed_password]);
        }
        
        return false;
    }

    /**
     * Verify current password
     */
    public function verify_current_password($user_id, $user_type, $current_password)
    {
        switch ($user_type) {
            case 'user':
                $query = $this->db->get_where('tb_user', ['id_user' => $user_id]);
                break;
            case 'guru':
                $query = $this->db->get_where('tb_guru', ['id_guru' => $user_id]);
                break;
            case 'siswa':
                $query = $this->db->get_where('tb_siswa', ['id_siswa' => $user_id]);
                break;
            default:
                return false;
        }
        
        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            return password_verify($current_password, $user['password']) || md5($current_password) == $user['password'];
        }
        
        return false;
    }
}