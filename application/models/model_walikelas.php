<?php
 
	class Model_walikelas extends CI_Model
	{
		public $table = "tb_wali_kelas";

		// menginset data walikelas secaa otomatis ketika insert tahun akademik ->> dimasukan di function add pada controller Tahunakadmeik
		 function insert_walikelas($idTahunAkademik)
		 {
		 	$kelas = $this->db->get('tb_kelas');
		 	foreach ($kelas->result() as $row) {
		 		$walikelas = array(
		 			'id_guru'				=> '0',
		 			'id_tahun_akademik'		=> $idTahunAkademik,
		 			'id_kelas'				=> $row->id_kelas
		 		);
		 		$this->db->insert('tb_wali_kelas', $walikelas);
		 	}
		 }

		 // Get all walikelas with details
		 function get_walikelas_detail()
		 {
		 	$this->db->select('tb_wali_kelas.*, tb_guru.nama_guru, tb_kelas.nama_kelas, tb_jurusan.nama_jurusan, tb_tingkatan.nama_tingkatan, tb_tahun_akademik.tahun_ajar');
		 	$this->db->from('tb_wali_kelas');
		 	$this->db->join('tb_guru', 'tb_wali_kelas.id_guru = tb_guru.id_guru', 'left');
		 	$this->db->join('tb_kelas', 'tb_wali_kelas.id_kelas = tb_kelas.id_kelas');
		 	$this->db->join('tb_jurusan', 'tb_kelas.id_jurusan = tb_jurusan.id_jurusan');
		 	$this->db->join('tb_tingkatan', 'tb_kelas.id_tingkatan = tb_tingkatan.id_tingkatan');
		 	$this->db->join('tb_tahun_akademik', 'tb_wali_kelas.id_tahun_akademik = tb_tahun_akademik.id_tahun_akademik');
		 	return $this->db->get()->result();
		 }

		 // Get walikelas by ID
		 function get_by_id($id_walikelas)
		 {
		 	$this->db->select('tb_wali_kelas.*, tb_guru.nama_guru, tb_kelas.nama_kelas, tb_jurusan.nama_jurusan, tb_tingkatan.nama_tingkatan');
		 	$this->db->from('tb_wali_kelas');
		 	$this->db->join('tb_guru', 'tb_wali_kelas.id_guru = tb_guru.id_guru', 'left');
		 	$this->db->join('tb_kelas', 'tb_wali_kelas.id_kelas = tb_kelas.id_kelas');
		 	$this->db->join('tb_jurusan', 'tb_kelas.id_jurusan = tb_jurusan.id_jurusan');
		 	$this->db->join('tb_tingkatan', 'tb_kelas.id_tingkatan = tb_tingkatan.id_tingkatan');
		 	$this->db->where('tb_wali_kelas.id_wali_kelas', $id_walikelas);
		 	return $this->db->get()->row();
		 }

		 // Save new walikelas
		 function save()
		 {
		 	$data = array(
		 		'id_guru'				=> $this->input->post('id_guru', TRUE),
		 		'id_tahun_akademik'		=> $this->input->post('id_tahun_akademik', TRUE),
		 		'id_kelas'				=> $this->input->post('id_kelas', TRUE)
		 	);
		 	$this->db->insert($this->table, $data);
		 }

		 // Update walikelas
		 function update()
		 {
		 	$data = array(
		 		'id_guru'				=> $this->input->post('id_guru', TRUE),
		 		'id_tahun_akademik'		=> $this->input->post('id_tahun_akademik', TRUE),
		 		'id_kelas'				=> $this->input->post('id_kelas', TRUE)
		 	);
		 	$id_wali_kelas = $this->input->post('id_walikelas');
		 	$this->db->where('id_wali_kelas', $id_wali_kelas);
		 	$this->db->update($this->table, $data);
		 }

		 // Delete walikelas
		 function delete($id_wali_kelas)
		 {
		 	$this->db->where('id_wali_kelas', $id_wali_kelas);
		 	$this->db->delete($this->table);
		 }

		 // Get available teachers (not assigned as walikelas)
		 function get_available_teachers()
		 {
		 	// Get all teachers
		 	$all_teachers = $this->db->get('tb_guru')->result();

		 	// Get teachers assigned as walikelas (excluding id_guru = 0)
		 	$this->db->distinct();
		 	$this->db->select('id_guru');
		 	$this->db->from('tb_wali_kelas');
		 	$this->db->where('id_guru !=', 0);
		 	$this->db->where('id_guru IS NOT NULL');
		 	$assigned_teachers = $this->db->get()->result_array();
		 	$assigned_ids = array_column($assigned_teachers, 'id_guru');

		 	// Filter out assigned teachers
		 	$available_teachers = array();
		 	foreach ($all_teachers as $teacher) {
		 		if (!in_array($teacher->id_guru, $assigned_ids)) {
		 			$available_teachers[] = $teacher;
		 		}
		 	}

		 	return $available_teachers;
		 }

		 // Get available classes (not assigned to walikelas)
		 function get_available_classes()
		 {
		 	// Get all classes with details
		 	$this->db->select('tb_kelas.*, tb_jurusan.nama_jurusan, tb_tingkatan.nama_tingkatan');
		 	$this->db->from('tb_kelas');
		 	$this->db->join('tb_jurusan', 'tb_kelas.id_jurusan = tb_jurusan.id_jurusan');
		 	$this->db->join('tb_tingkatan', 'tb_kelas.id_tingkatan = tb_tingkatan.id_tingkatan');
		 	$all_classes = $this->db->get()->result();

		 	// Get classes already assigned to walikelas
		 	$this->db->distinct();
		 	$this->db->select('id_kelas');
		 	$this->db->from('tb_wali_kelas');
		 	$assigned_classes = $this->db->get()->result_array();
		 	$assigned_kelas = array_column($assigned_classes, 'id_kelas');

		 	// Filter out assigned classes
		 	$available_classes = array();
		 	foreach ($all_classes as $class) {
		 		if (!in_array($class->id_kelas, $assigned_kelas)) {
		 			$available_classes[] = $class;
		 		}
		 	}

		 	return $available_classes;
		 }

	}

?>