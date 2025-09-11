<?php

  class Model_guru extends CI_Model
  {

    public $table = "tbl_guru";

    function save()
    {
      $data = array(
        //tabel di database => name di form
        'nuptk'       => $this->input->post('nuptk', TRUE),
        'nama_guru'   => $this->input->post('nama_guru', TRUE),
        'gender'      => $this->input->post('gender', TRUE),
        'username'    => $this->input->post('username', TRUE),
        'password'    => md5($this->input->post('password', TRUE)),
      );
      $this->db->insert($this->table, $data);
    }

    function update()
    {
      $data = array(
        //tabel di database => name di form
        'nuptk'       => $this->input->post('nuptk', TRUE),
        'nama_guru'   => $this->input->post('nama_guru', TRUE),
        'gender'      => $this->input->post('gender', TRUE),
        'username'    => $this->input->post('username', TRUE),
        'password'    => md5($this->input->post('password', TRUE)),
        //'semester_aktif'  = $this->input->post('semester_aktif', TRUE)
      );
      $id_guru = $this->input->post('id_guru');
      $this->db->where('id_guru', $id_guru);
      $this->db->update($this->table, $data);
    }

    function login($username, $password)
    {
      $this->db->where('username', $username);
      $user = $this->db->get('tbl_guru')->row_array();

      // Verify password using MD5 only
      if ($user) {
        if (md5($password) === $user['password']) {
          return $user;
        } else {
          return 'password_wrong';
        }
      }
      return 'user_not_found';
    }

    // Check if teacher has any subjects assigned
    function has_subjects($id_guru)
    {
      $this->db->where('id_guru', $id_guru);
      $this->db->where('id_guru !=', 0);
      $count = $this->db->count_all_results('tbl_jadwal');
      return $count > 0;
    }

    // Get subjects assigned to a teacher
    function get_teacher_subjects($id_guru)
    {
      $this->db->select('tbl_jadwal.id_jadwal, tbl_jadwal.kd_mapel, tbl_jadwal.kd_kelas, tbl_jadwal.hari, tbl_jadwal.jam, tbl_jadwal.semester, tbl_mapel.nama_mapel, tbl_kelas.nama_kelas, tbl_jurusan.nama_jurusan, tbl_tingkatan_kelas.nama_tingkatan');
      $this->db->from('tbl_jadwal');
      $this->db->join('tbl_mapel', 'tbl_jadwal.kd_mapel = tbl_mapel.kd_mapel', 'left');
      $this->db->join('tbl_kelas', 'tbl_jadwal.kd_kelas = tbl_kelas.kd_kelas', 'left');
      $this->db->join('tbl_jurusan', 'tbl_kelas.kd_jurusan = tbl_jurusan.kd_jurusan', 'left');
      $this->db->join('tbl_tingkatan_kelas', 'tbl_kelas.kd_tingkatan = tbl_tingkatan_kelas.kd_tingkatan', 'left');
      $this->db->where('tbl_jadwal.id_guru', $id_guru);
      $this->db->where('tbl_jadwal.id_guru !=', 0);
      $this->db->order_by('tbl_jurusan.nama_jurusan, tbl_tingkatan_kelas.nama_tingkatan, tbl_kelas.nama_kelas, tbl_mapel.nama_mapel');
      return $this->db->get()->result();
    }

    // Get teachers without subjects
    function get_teachers_without_subjects()
    {
      $this->db->select('tbl_guru.*');
      $this->db->from('tbl_guru');
      $this->db->join('tbl_jadwal', 'tbl_guru.id_guru = tbl_jadwal.id_guru', 'left');
      $this->db->where('tbl_jadwal.id_guru IS NULL OR tbl_jadwal.id_guru = 0');
      $this->db->group_by('tbl_guru.id_guru');
      return $this->db->get()->result();
    }

    // Get subjects assigned to a teacher with detailed information including missing data
    function get_teacher_subjects_detailed($id_guru)
    {
      // Use the new view for better performance and consistency
      $this->db->select('*');
      $this->db->from('view_guru_mapel');
      $this->db->where('id_guru', $id_guru);
      $this->db->where('id_jadwal IS NOT NULL'); // Only get assigned subjects
      $this->db->order_by('nama_jurusan, nama_tingkatan, nama_kelas, nama_mapel');
      return $this->db->get()->result();
    }

    // Get available subjects for assignment using optimized query
    function get_available_subjects_for_assignment($id_guru)
    {
      // Use stored procedure if available, fallback to regular query
      try {
        $sql = "CALL sp_get_available_subjects_for_guru(?)"; 
        $result = $this->db->query($sql, array($id_guru));
        if ($result && $result->num_rows() > 0) {
          return $result->result();
        }
      } catch (Exception $e) {
        // Log the error for debugging
        log_message('error', 'Stored procedure sp_get_available_subjects_for_guru not available: ' . $e->getMessage());
      }
      
      // Fallback query - enhanced to ensure compatibility
      $this->db->select('tkd.id_kurikulum_detail, tm.kd_mapel, tm.nama_mapel, 
                         tju.kd_jurusan, tju.nama_jurusan, ttk.kd_tingkatan, ttk.nama_tingkatan,
                         COUNT(tk.kd_kelas) as jumlah_kelas,
                         GROUP_CONCAT(tk.nama_kelas ORDER BY tk.nama_kelas SEPARATOR ", ") as daftar_kelas,
                         GROUP_CONCAT(tk.kd_kelas ORDER BY tk.nama_kelas SEPARATOR ",") as kode_kelas');
      $this->db->from('tbl_kurikulum_detail tkd');
      $this->db->join('tbl_kurikulum tku', 'tkd.id_kurikulum = tku.id_kurikulum', 'inner');
      $this->db->join('tbl_mapel tm', 'tkd.kd_mapel = tm.kd_mapel', 'inner');
      $this->db->join('tbl_jurusan tju', 'tkd.kd_jurusan = tju.kd_jurusan', 'inner');
      $this->db->join('tbl_tingkatan_kelas ttk', 'tkd.kd_tingkatan = ttk.kd_tingkatan', 'inner');
      $this->db->join('tbl_kelas tk', 'tkd.kd_jurusan = tk.kd_jurusan AND tkd.kd_tingkatan = tk.kd_tingkatan', 'inner');
      $this->db->where('tku.is_aktif', 'Y');
      
      // Exclude already assigned subjects using subquery
      $subquery = '(SELECT COUNT(*) FROM tbl_jadwal tj 
                    WHERE tj.kd_mapel = tkd.kd_mapel 
                    AND tj.kd_kelas = tk.kd_kelas 
                    AND tj.id_guru = ' . intval($id_guru) . ' 
                    AND tj.id_guru > 0)';
      $this->db->where($subquery . ' = 0', NULL, FALSE);
      
      $this->db->group_by('tkd.id_kurikulum_detail, tm.kd_mapel, tm.nama_mapel, tju.kd_jurusan, tju.nama_jurusan, ttk.kd_tingkatan, ttk.nama_tingkatan');
      $this->db->order_by('tju.nama_jurusan, ttk.nama_tingkatan, tm.nama_mapel');
      
      return $this->db->get()->result();
    }

    // Fix incomplete teacher-subject relationships
    function fix_incomplete_teacher_subjects($id_guru)
    {
      // Get all schedules for this teacher
      $schedules = $this->db->select('*')
                           ->from('tbl_jadwal')
                           ->where('id_guru', $id_guru)
                           ->get()->result();
      
      $fixed_count = 0;
      
      foreach ($schedules as $schedule) {
        $need_update = false;
        $update_data = array();
        
        // Check if mapel exists
        if (!empty($schedule->kd_mapel)) {
          $mapel_exists = $this->db->get_where('tbl_mapel', array('kd_mapel' => $schedule->kd_mapel))->num_rows();
          if ($mapel_exists == 0) {
            // Mapel doesn't exist, set to null or default
            $update_data['kd_mapel'] = null;
            $need_update = true;
          }
        }
        
        // Check if kelas exists
        if (!empty($schedule->kd_kelas)) {
          $kelas_exists = $this->db->get_where('tbl_kelas', array('kd_kelas' => $schedule->kd_kelas))->num_rows();
          if ($kelas_exists == 0) {
            // Kelas doesn't exist, set to null or default
            $update_data['kd_kelas'] = null;
            $need_update = true;
          }
        }
        
        // Update if needed
        if ($need_update) {
          $this->db->where('id_jadwal', $schedule->id_jadwal);
          $this->db->update('tbl_jadwal', $update_data);
          $fixed_count++;
        }
      }
      
      return $fixed_count;
    }

    // Get orphaned schedule entries (referencing non-existent teachers, subjects, or classes)
    function get_orphaned_schedule_entries()
    {
      $sql = "SELECT tj.*, 
                     CASE WHEN tg.id_guru IS NULL THEN 'Guru tidak ditemukan' ELSE '' END as guru_issue,
                     CASE WHEN tm.kd_mapel IS NULL THEN 'Mata pelajaran tidak ditemukan' ELSE '' END as mapel_issue,
                     CASE WHEN tk.kd_kelas IS NULL THEN 'Kelas tidak ditemukan' ELSE '' END as kelas_issue
              FROM tbl_jadwal tj
              LEFT JOIN tbl_guru tg ON tj.id_guru = tg.id_guru
              LEFT JOIN tbl_mapel tm ON tj.kd_mapel = tm.kd_mapel  
              LEFT JOIN tbl_kelas tk ON tj.kd_kelas = tk.kd_kelas
              WHERE (tj.id_guru > 0 AND tg.id_guru IS NULL) 
                 OR (tj.kd_mapel IS NOT NULL AND tj.kd_mapel != '' AND tm.kd_mapel IS NULL)
                 OR (tj.kd_kelas IS NOT NULL AND tj.kd_kelas != '' AND tk.kd_kelas IS NULL)";
      
      return $this->db->query($sql)->result();
    }

    // Clean up orphaned schedule entries using optimized method
    function cleanup_orphaned_entries()
    {
      $cleaned_count = 0;
      
      try {
        // Try to use stored procedure first
        $result = $this->db->query('CALL sp_clean_orphaned_data()');
        if ($result && $result->num_rows() > 0) {
          $row = $result->row();
          return isset($row->total_cleaned) ? $row->total_cleaned : 0;
        }
      } catch (Exception $e) {
        // Log the error for debugging
        log_message('error', 'Stored procedure sp_clean_orphaned_data failed: ' . $e->getMessage());
      }
      
      // Fallback manual cleanup
      // Remove entries with non-existent teachers (but keep unassigned ones with id_guru = 0)
      $sql = "DELETE tj FROM tbl_jadwal tj 
              LEFT JOIN tbl_guru tg ON tj.id_guru = tg.id_guru 
              WHERE tj.id_guru > 0 AND tg.id_guru IS NULL";
      $this->db->query($sql);
      $cleaned_count += $this->db->affected_rows();
      
      // Set invalid mapel to null
      $sql = "UPDATE tbl_jadwal tj 
              LEFT JOIN tbl_mapel tm ON tj.kd_mapel = tm.kd_mapel 
              SET tj.kd_mapel = NULL 
              WHERE tj.kd_mapel IS NOT NULL AND tj.kd_mapel != '' AND tm.kd_mapel IS NULL";
      $this->db->query($sql);
      $cleaned_count += $this->db->affected_rows();
      
      // Set invalid kelas to null
      $sql = "UPDATE tbl_jadwal tj 
              LEFT JOIN tbl_kelas tk ON tj.kd_kelas = tk.kd_kelas 
              SET tj.kd_kelas = NULL 
              WHERE tj.kd_kelas IS NOT NULL AND tj.kd_kelas != '' AND tk.kd_kelas IS NULL";
      $this->db->query($sql);
      $cleaned_count += $this->db->affected_rows();
      
      return $cleaned_count;
    }

    // Assign teacher to subject using optimized method
    function assign_teacher_to_subject($id_guru, $kd_mapel, $kd_kelas, $hari = '', $jam = '', $kd_ruangan = '000')
    {
      try {
        // Try to use stored procedure first
        $sql = "CALL sp_assign_guru_mapel(?, ?, ?, ?, ?, ?)";
        $result = $this->db->query($sql, array($id_guru, $kd_mapel, $kd_kelas, $hari, $jam, $kd_ruangan));
        if ($result) {
          return array('success' => true, 'message' => 'Guru berhasil ditugaskan menggunakan stored procedure');
        }
      } catch (Exception $e) {
        // Log the error for debugging
        log_message('error', 'Stored procedure sp_assign_guru_mapel failed: ' . $e->getMessage());
      }
      
      // Fallback manual assignment
      $tahun_akademik = $this->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row();
      
      if (!$tahun_akademik) {
        return array('success' => false, 'message' => 'Tidak ada tahun akademik yang aktif');
      }
      
      // Get kelas details for jurusan and tingkatan
      $kelas_info = $this->db->get_where('tbl_kelas', array('kd_kelas' => $kd_kelas))->row();
      if (!$kelas_info) {
        return array('success' => false, 'message' => 'Data kelas tidak ditemukan');
      }
      
      // Check if assignment already exists
      $existing = $this->db->get_where('tbl_jadwal', array(
        'kd_mapel' => $kd_mapel,
        'kd_kelas' => $kd_kelas,
        'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik
      ))->row();
      
      if ($existing) {
        // Update existing assignment
        $this->db->where('id_jadwal', $existing->id_jadwal);
        $result = $this->db->update('tbl_jadwal', array(
          'id_guru' => $id_guru,
          'hari' => $hari,
          'jam' => $jam,
          'kd_ruangan' => $kd_ruangan
        ));
        
        if ($result) {
          return array('success' => true, 'message' => 'Penugasan guru berhasil diperbarui');
        } else {
          return array('success' => false, 'message' => 'Gagal memperbarui penugasan guru');
        }
      } else {
        // Insert new assignment
        $result = $this->db->insert('tbl_jadwal', array(
          'id_tahun_akademik' => $tahun_akademik->id_tahun_akademik,
          'semester' => $tahun_akademik->semester,
          'kd_jurusan' => $kelas_info->kd_jurusan,
          'kd_tingkatan' => $kelas_info->kd_tingkatan,
          'kd_kelas' => $kd_kelas,
          'kd_mapel' => $kd_mapel,
          'id_guru' => $id_guru,
          'hari' => $hari,
          'jam' => $jam,
          'kd_ruangan' => $kd_ruangan
        ));
        
        if ($result) {
          return array('success' => true, 'message' => 'Guru berhasil ditugaskan ke mata pelajaran');
        } else {
          return array('success' => false, 'message' => 'Gagal menugaskan guru ke mata pelajaran');
        }
      }
    }

    // Get teacher workload summary using view
    function get_teacher_workload_summary($id_guru = null)
    {
      $this->db->select('*');
      $this->db->from('view_guru_workload');
      
      if ($id_guru) {
        $this->db->where('id_guru', $id_guru);
        return $this->db->get()->row();
      } else {
        $this->db->order_by('nama_guru');
        return $this->db->get()->result();
      }
    }

    // Get class-subject availability matrix
    function get_class_subject_matrix($kd_jurusan = null, $kd_tingkatan = null)
    {
      $this->db->select('*');
      $this->db->from('view_kelas_mapel_available');
      
      if ($kd_jurusan) {
        $this->db->where('kd_jurusan', $kd_jurusan);
      }
      
      if ($kd_tingkatan) {
        $this->db->where('kd_tingkatan', $kd_tingkatan);
      }
      
      $this->db->order_by('nama_jurusan, nama_tingkatan, nama_kelas, nama_mapel');
      return $this->db->get()->result();
    }

  }