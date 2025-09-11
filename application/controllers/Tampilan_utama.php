<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Tampilan_utama extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
		}

		function index()
		{
			// Check if user is logged in and is a student (id_level_user = 4)
			if ($this->session->userdata('id_level_user') == 4) {
				// Student dashboard
				$nisn = $this->session->userdata('nisn');

				// Get student info using new table structure
				$siswa_id = $this->session->userdata('siswa_id');
				$data['siswa'] = $this->db->get_where('tb_siswa', array('id_siswa' => $siswa_id))->row_array();

				// Get grades data for charts
				$sql = "SELECT ts.nama_siswa as nama, tm.nama_mapel, tn.nilai
						FROM tb_nilai AS tn
						INNER JOIN tb_mata_pelajaran AS tm ON tn.id_mapel = tm.id_mapel
						INNER JOIN tb_siswa AS ts ON tn.id_siswa = ts.id_siswa
						WHERE tn.id_siswa = ?
						ORDER BY tm.nama_mapel ASC";
				$data['nilai_siswa'] = $this->db->query($sql, array($siswa_id));

				$this->template->load('template', 'dashboard_siswa', $data);
			} else {
				// Admin dashboard
				$quser = 'SELECT COUNT(*) AS hasil FROM tb_user';
				$data['user'] = $this->db->query($quser)->row_array();

				$qsiswa = 'SELECT COUNT(*) AS hasil FROM tb_siswa';
				$data['siswa'] = $this->db->query($qsiswa)->row_array();

				$qguru = 'SELECT COUNT(*) AS hasil FROM tb_guru';
				$data['guru'] = $this->db->query($qguru)->row_array();

				$qruangan = 'SELECT COUNT(*) AS hasil FROM tb_ruangan';
				$data['ruangan'] = $this->db->query($qruangan)->row_array();

				$this->template->load('template', 'dashboard', $data);
			}
		}

	}

?>