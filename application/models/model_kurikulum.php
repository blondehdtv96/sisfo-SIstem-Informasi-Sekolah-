<?php

	class Model_kurikulum extends CI_Model
	{

		public $table = "tbl_kurikulum";

		function save()
		{
			// Get active academic year ID if not provided
			$id_tahun_akademik = $this->input->post('id_tahun_akademik', TRUE);
			if (empty($id_tahun_akademik)) {
				$tahun_akademik = $this->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row();
				$id_tahun_akademik = $tahun_akademik ? $tahun_akademik->id_tahun_akademik : 1;
			}

		 	$data = array(
		 		//tabel di database => name di form
		 		'nama_kurikulum'	=> $this->input->post('nama_kurikulum', TRUE),
		 		'id_tahun_akademik' => $id_tahun_akademik,
		 		'is_aktif'			=> $this->input->post('is_aktif', TRUE)
		 	);
		 	$this->db->insert($this->table, $data);
		}

		function update()
		{
			// Get active academic year ID if not provided
			$id_tahun_akademik = $this->input->post('id_tahun_akademik', TRUE);
			if (empty($id_tahun_akademik)) {
				$tahun_akademik = $this->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row();
				$id_tahun_akademik = $tahun_akademik ? $tahun_akademik->id_tahun_akademik : 1;
			}

			$data = array(
		 		//tabel di database => name di form
		 		'nama_kurikulum'	=> $this->input->post('nama_kurikulum', TRUE),
		 		'id_tahun_akademik' => $id_tahun_akademik,
		 		'is_aktif'			=> $this->input->post('is_aktif', TRUE)
		 	);
		 	$id_kurikulum = $this->input->post('id_kurikulum');
		 	$this->db->where('id_kurikulum', $id_kurikulum);
		 	$this->db->update($this->table, $data);
		}

		function save_detail()
		{
			$data = array(
				'id_kurikulum'	=> $this->input->post('kurikulum', TRUE),
				'kd_mapel'		=> $this->input->post('mapel', TRUE),
				'kd_jurusan'	=> $this->input->post('jurusan', TRUE),
				'kd_tingkatan'	=> $this->input->post('tingkatan', TRUE)
			);
			$this->db->insert('tbl_kurikulum_detail', $data);
		}

	}

?>
