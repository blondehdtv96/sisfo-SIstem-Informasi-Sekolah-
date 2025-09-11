<?php
 
	class Walikelas extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_walikelas');
		}

		function data()
		{
			// nama table
			$table      = 'tb_wali_kelas';
			// nama PK
			$primaryKey = 'id_wali_kelas';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'id_wali_kelas', 'dt' => 'id_wali_kelas'),
				array('db' => 'id_guru', 'dt' => 'id_guru'),
				array('db' => 'id_kelas', 'dt' => 'id_kelas'),
				array('db' => 'id_tahun_akademik', 'dt' => 'id_tahun_akademik'),
		    );

			$sql_details = array(
				'user' => $this->db->username,
				'pass' => $this->db->password,
				'db'   => $this->db->database,
				'host' => $this->db->hostname
		    );

		    echo json_encode(
		     	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		     );
		}

		function index()
		{
			// Get active academic year data
			$this->db->where('status', 'aktif');
			$tahun_akademik = $this->db->get('tb_tahun_akademik')->row();
				
			// If no active academic year, provide default values
			if (!$tahun_akademik) {
				$tahun_akademik = (object) array(
					'id_tahun_akademik' => 0,
					'tahun_ajar' => 'Belum Diatur',
					'semester' => 'Belum Diatur'
				);
			}
				
			$data['title'] = 'Data Walikelas';
			$data['page_title'] = 'Data Wali Kelas';
			$data['breadcrumb'] = [
				['title' => 'Manajemen Data'],
				['title' => 'Data Wali Kelas']
			];
			$data['tahun_akademik'] = $tahun_akademik;
			$data['contents'] = $this->load->view('walikelas/view', $data, TRUE);
			$this->load->view('template_new', $data);
		}

		function update_walikelas()
		{
			$id_wali_kelas = $this->input->get('id_walikelas');
			$id_guru	  = $this->input->get('id_guru');
			
			// Validasi input
			if (empty($id_wali_kelas) || !is_numeric($id_wali_kelas)) {
				echo json_encode(array('status' => 'error', 'message' => 'ID walikelas tidak valid'));
				return;
			}
			
			if (empty($id_guru) || !is_numeric($id_guru)) {
				echo json_encode(array('status' => 'error', 'message' => 'ID guru tidak valid'));
				return;
			}
			
			try {
				$this->db->where('id_wali_kelas', $id_wali_kelas);
				$result = $this->db->update('tb_wali_kelas', array('id_guru' => $id_guru));
				
				if ($result) {
					echo json_encode(array('status' => 'success', 'message' => 'Walikelas berhasil diupdate'));
				} else {
					echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate walikelas'));
				}
			} catch (Exception $e) {
				log_message('error', 'Error updating walikelas: ' . $e->getMessage());
				echo json_encode(array('status' => 'error', 'message' => 'Terjadi kesalahan database'));
			}
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_walikelas->save();
				redirect('walikelas');
			} else {
				// Get active academic year data
				$this->db->where('status', 'aktif');
				$tahun_akademik = $this->db->get('tb_tahun_akademik')->row();
					
				// If no active academic year, provide default values
				if (!$tahun_akademik) {
					$tahun_akademik = (object) array(
						'id_tahun_akademik' => 0,
						'tahun_ajar' => 'Belum Diatur',
						'semester' => 'Belum Diatur'
					);
				}
					
				$data['tahun_akademik'] = $tahun_akademik;
				$data['available_teachers'] = $this->model_walikelas->get_available_teachers();
				$data['available_classes'] = $this->model_walikelas->get_available_classes();
				$data['title'] = 'Tambah Walikelas';
				$data['page_title'] = 'Tambah Wali Kelas';
				$data['breadcrumb'] = [
					['title' => 'Manajemen Data'],
					['title' => 'Data Wali Kelas', 'url' => base_url('walikelas')],
					['title' => 'Tambah Wali Kelas']
				];
				$data['contents'] = $this->load->view('walikelas/add', $data, TRUE);
				$this->load->view('template_new', $data);
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_walikelas->update();
				redirect('walikelas');
			} else {
				$id_wali_kelas = $this->uri->segment(3);
					
				// Get active academic year data
				$this->db->where('status', 'aktif');
				$tahun_akademik = $this->db->get('tb_tahun_akademik')->row();
					
				// If no active academic year, provide default values
				if (!$tahun_akademik) {
					$tahun_akademik = (object) array(
						'id_tahun_akademik' => 0,
						'tahun_ajar' => 'Belum Diatur',
						'semester' => 'Belum Diatur'
					);
				}
					
				$data['tahun_akademik'] = $tahun_akademik;
				$data['walikelas'] = $this->model_walikelas->get_by_id($id_wali_kelas);
				$data['available_teachers'] = $this->model_walikelas->get_available_teachers();
				$data['available_classes'] = $this->model_walikelas->get_available_classes();
				$data['title'] = 'Edit Walikelas';
				$data['page_title'] = 'Edit Wali Kelas';
				$data['breadcrumb'] = [
					['title' => 'Manajemen Data'],
					['title' => 'Data Wali Kelas', 'url' => base_url('walikelas')],
					['title' => 'Edit Wali Kelas']
				];
				$data['contents'] = $this->load->view('walikelas/edit', $data, TRUE);
				$this->load->view('template_new', $data);
			}
		}

		function delete()
		{
			$id_wali_kelas = $this->uri->segment(3);
			if (!empty($id_wali_kelas)) {
				$this->model_walikelas->delete($id_wali_kelas);
			}
			redirect('walikelas');
		}

		function get_walikelas_data()
		{
			try {
				// Get active academic year
				$this->db->where('status', 'aktif');
				$active_year = $this->db->get('tb_tahun_akademik')->row();
				
				if (!$active_year) {
					header('Content-Type: application/json');
					echo json_encode(['error' => 'No active academic year found']);
					return;
				}
				
				// Get walikelas data with basic information first
				$this->db->select('
					tb_wali_kelas.id_wali_kelas,
					tb_wali_kelas.id_guru,
					tb_wali_kelas.id_kelas,
					tb_wali_kelas.id_tahun_akademik,
					tb_wali_kelas.status,
					tb_wali_kelas.created_at,
					tb_wali_kelas.updated_at,
					tb_guru.nama_guru,
					tb_guru.nip,
					tb_kelas.nama_kelas,
					tb_kelas.kode_kelas,
					tb_kelas.kapasitas,
					tb_jurusan.nama_jurusan,
					tb_jurusan.kode_jurusan,
					tb_tingkatan.nama_tingkatan,
					tb_tahun_akademik.tahun_ajar,
					tb_tahun_akademik.semester
				');
				$this->db->from('tb_wali_kelas');
				$this->db->join('tb_guru', 'tb_wali_kelas.id_guru = tb_guru.id_guru', 'left');
				$this->db->join('tb_kelas', 'tb_wali_kelas.id_kelas = tb_kelas.id_kelas', 'left');
				$this->db->join('tb_jurusan', 'tb_kelas.id_jurusan = tb_jurusan.id_jurusan', 'left');
				$this->db->join('tb_tingkatan', 'tb_kelas.id_tingkatan = tb_tingkatan.id_tingkatan', 'left');
				$this->db->join('tb_tahun_akademik', 'tb_wali_kelas.id_tahun_akademik = tb_tahun_akademik.id_tahun_akademik', 'left');
				$this->db->where('tb_wali_kelas.id_tahun_akademik', $active_year->id_tahun_akademik);
				$this->db->order_by('tb_tingkatan.nama_tingkatan ASC, tb_jurusan.kode_jurusan ASC, tb_kelas.nama_kelas ASC');
				$walikelas_data = $this->db->get()->result();
				
				// Add student count for each class separately to avoid complex subquery
				foreach ($walikelas_data as $walikelas) {
					if ($walikelas->id_kelas) {
						$this->db->where('id_kelas', $walikelas->id_kelas);
						$this->db->where('status', 'aktif');
						$student_count = $this->db->count_all_results('tb_siswa');
						$walikelas->jumlah_siswa = $student_count;
					} else {
						$walikelas->jumlah_siswa = 0;
					}
				}
				
				// Set proper content type
				header('Content-Type: application/json');
				echo json_encode($walikelas_data);
				
			} catch (Exception $e) {
				// Error handling
				header('Content-Type: application/json');
				echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
			}
		}
		
		function get_available_teachers()
		{
			try {
				// Get all active teachers
				$this->db->select('id_guru, nama_guru, nip');
				$this->db->from('tb_guru');
				$this->db->where('status', 'aktif');
				$this->db->order_by('nama_guru ASC');
				$teachers = $this->db->get()->result();
				
				// Set proper content type
				header('Content-Type: application/json');
				echo json_encode($teachers);
				
			} catch (Exception $e) {
				// Error handling
				header('Content-Type: application/json');
				echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
			}
		}
	
	// Simple test function for debugging
	function test_connection()
	{
		header('Content-Type: application/json');
		echo json_encode([
			'status' => 'success',
			'message' => 'Connection test successful',
			'timestamp' => date('Y-m-d H:i:s')
		]);
	}
	
	// Simple walikelas data without joins for debugging
	function get_simple_walikelas_data()
	{
		try {
			// Get basic walikelas data
			$this->db->select('*');
			$this->db->from('tb_wali_kelas');
			$this->db->limit(10);
			$walikelas_data = $this->db->get()->result();
			
			header('Content-Type: application/json');
			echo json_encode($walikelas_data);
			
		} catch (Exception $e) {
			header('Content-Type: application/json');
			echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
		}
	}

}
