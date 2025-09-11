<?php

	class Model_user extends CI_Model
	{

		public $table = "tbl_user";
		
		// mengambil data $username & $password dari hasil parsing controller Auth function check_login() dan mencocokanya dengan data yang ada di database
		function login($username, $password)
		{
			$this->db->where('username', $username);
			$user = $this->db->get('tbl_user')->row_array();

			// Log for debugging
			log_message('info', 'User model login - Username: ' . $username);
			log_message('info', 'User found: ' . ($user ? 'YES' : 'NO'));
			
			if ($user) {
				log_message('info', 'Stored password hash: ' . $user['password']);
				log_message('info', 'Input password MD5: ' . md5($password));
				
				// Try MD5 verification first (legacy support)
				if (md5($password) === $user['password']) {
					log_message('info', 'MD5 password verification: SUCCESS');
					return $user;
				}
				
				// Try bcrypt verification for newer passwords
				if (password_verify($password, $user['password'])) {
					log_message('info', 'Bcrypt password verification: SUCCESS');
					return $user;
				}
				
				// Try direct comparison for edge cases
				if ($password === $user['password']) {
					log_message('info', 'Direct password verification: SUCCESS');
					return $user;
				}
				
				log_message('info', 'All password verification methods failed');
				return 'password_wrong';
			}
			
			log_message('info', 'User not found in database');
			return 'user_not_found';
		}

		function save($foto)
		{
			$data = array(
				//tabel di database => name di form
				'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
				'username'          	  => $this->input->post('username', TRUE),
				'password'          	  => md5($this->input->post('password', TRUE)),
				'id_level_user'           => $this->input->post('level_user', TRUE),
				'foto'					  => $foto
			);
			$this->db->insert($this->table, $data);
		}

		function update($foto)
		{
			if (empty($foto)) {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5($this->input->post('password', TRUE)),
					'id_level_user'           => $this->input->post('level_user', TRUE),
				);
			} else {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5($this->input->post('password', TRUE)),
					'id_level_user'           => $this->input->post('level_user', TRUE),
					'foto'					  => $foto
				);
			}
			$id_user 	= $this->input->post('id_user', TRUE);
			$this->db->where('id_user', $id_user);
			$this->db->update($this->table, $data);
		}

	}