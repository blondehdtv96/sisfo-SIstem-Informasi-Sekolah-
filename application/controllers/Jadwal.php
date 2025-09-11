<?php

	class Jadwal extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
				
			// Check if user is logged in
			if (!$this->session->userdata('logged_in')) {
				redirect('auth');
			}
				
			$this->load->model('model_jadwal');
			$this->load->model('Dashboard_model');
		}

		function index()
		{
			$user_level = $this->session->userdata('id_level_user');
			$data['title'] = 'Jadwal Pelajaran';
			
			// Handle different user levels
			if ($user_level == 3) { // Guru
				$data['page_title'] = 'Jadwal Pelajaran';
				$data['breadcrumb'] = [
					['title' => 'Jadwal Pelajaran']
				];
				
				// Validasi session id_guru
				$id_guru = $this->session->userdata('id_guru');
				
				if (empty($id_guru)) {
					$this->session->set_flashdata('error', 'Session guru tidak valid. Silakan login kembali.');
					redirect('auth');
				}
				
				// Gunakan prepared statement untuk keamanan
				$sql = "SELECT tj.id_jadwal, tju.nama_jurusan, ttk.nama_tingkatan, tm.nama_mapel, tj.jam, 
						tr.nama_ruangan, tj.hari, tj.semester 
						FROM tbl_jadwal AS tj 
						INNER JOIN tbl_jurusan AS tju ON tj.kd_jurusan = tju.kd_jurusan 
						INNER JOIN tbl_ruangan AS tr ON tj.kd_ruangan = tr.kd_ruangan 
						INNER JOIN tbl_mapel AS tm ON tj.kd_mapel = tm.kd_mapel 
						INNER JOIN tbl_tingkatan_kelas AS ttk ON tj.kd_tingkatan = ttk.kd_tingkatan 
						WHERE tj.id_guru = ?";
				
				$data['jadwal'] = $this->db->query($sql, array($id_guru));
				
				// Cek jika query berhasil
				if ($data['jadwal'] === FALSE) {
					$this->session->set_flashdata('error', 'Terjadi kesalahan dalam memuat data jadwal.');
					redirect('dashboard');
				}
				
				// Load teacher schedule view
				$data['contents'] = $this->load->view('jadwal/jadwal_ajar_guru', $data, TRUE);
				$this->load->view('template_new', $data);
				
			} elseif ($user_level == 4) { // Siswa
				$data['page_title'] = 'Jadwal Pelajaran';
				$data['breadcrumb'] = [
					['title' => 'Jadwal Pelajaran']
				];
				
				// Get student info and schedule
				$siswa_id = $this->session->userdata('siswa_id');
				$kelas_id = $this->session->userdata('kelas_id');
				
				if (empty($siswa_id) || empty($kelas_id)) {
					$this->session->set_flashdata('error', 'Session siswa tidak valid. Silakan login kembali.');
					redirect('auth');
				}
				
				// Get student information
				$data['student_info'] = $this->Dashboard_model->get_student_info($siswa_id);
				
				// Get student schedule
				$data['schedule'] = $this->Dashboard_model->get_student_schedule($kelas_id);
				
				// Load student schedule view
				$data['contents'] = $this->load->view('jadwal/siswa_view', $data, TRUE);
				$this->load->view('template_new', $data);
				
			} else { // Admin and others
				$data['page_title'] = 'Jadwal Pelajaran';
				$data['breadcrumb'] = [
					['title' => 'Jadwal Pelajaran']
				];
				
				// Load admin schedule management view
				$data['contents'] = $this->load->view('jadwal/view', $data, TRUE);
				$this->load->view('template_new', $data);
			}
		}

		function generate_jadwal()
		{
			if (isset($_POST['submit'])) {
				$this->model_jadwal->generateJadwal();
			}
			redirect('jadwal');
		}

		function dataJadwal()
		{
			$kode_jurusan		= $this->input->get('kd_jurusan');
			$kode_tingkatan		= $this->input->get('kd_tingkatan');
			//$idkurikulum		= $this->input->get('kurikulumnya');
			$kelas 				= $this->input->get('kelas');

			// Validasi input
			if (empty($kode_jurusan) || empty($kode_tingkatan) || empty($kelas)) {
				echo "<div class='alert alert-warning'>Parameter tidak lengkap.</div>";
				return;
			}

			echo "<table class='table table-striped table-bordered table-hover table-full-width dataTable'>
                    <thead>
                        <tr>
                            <th class='text-center'>NO</th>
                            <th class='text-center'>MATA PELAJARAN</th>
                            <th class='text-center'>GURU</th>
                            <th class='text-center'>RUANGAN</th>
                            <th class='text-center'>HARI</th>
                            <th class='text-center'>JAM</th>
                            <th></th>
                        </tr>
                    </thead>";

  			// Gunakan prepared statement untuk keamanan
  			$sql_datajadwal	= "SELECT tj.id_jadwal, tm.nama_mapel, tg.id_guru, tg.nama_guru, tr.kd_ruangan, tj.hari, tj.jam
							   FROM tbl_jadwal AS tj 
							   INNER JOIN tbl_mapel AS tm ON tj.kd_mapel = tm.kd_mapel 
							   INNER JOIN tbl_guru AS tg ON tj.id_guru = tg.id_guru 
							   INNER JOIN tbl_ruangan AS tr ON tj.kd_ruangan = tr.kd_ruangan 
							   WHERE tj.kd_jurusan = ? AND tj.kd_kelas = ?";
			$data_jadwal	= $this->db->query($sql_datajadwal, array($kode_jurusan, $kelas));
			
			if ($data_jadwal === FALSE) {
				echo "<div class='alert alert-danger'>Terjadi kesalahan dalam memuat data.</div>";
				return;
			}
			
			$data_jadwal = $data_jadwal->result();
			$no = 1;
			$jam_pelajaran	= $this->model_jadwal->jamPelajaran();
			$hari           = array(
								'Senin'  => 'Senin',
								'Selasa' => 'Selasa',
								'Rabu'   => 'Rabu',
								'Kamis'  => 'Kamis',
								'Jumat'  => 'Jumat',
								'Sabtu'  => 'Sabtu'
							  );

			// cmb_dinamis(nama, tabelnya, fieldnya, pknya, selected, extra)
			// untuk selected $row->id, harus memasukan field id terlebih dahulu di $sql_datajadwal
			// sbg contoh $row->id_guru, harus menambahkan tg.id_guru di $sql_datajadwal agar ketika di jalankan querynya pada $data_jadwal akan membuat kolom baru yang berisi id_guru lalu baru bisa diambil idnya agar menampilkan data yang selected sesuai database pada cmb_dinamis.
			foreach ($data_jadwal as $row) {
				echo "<tr>
						<td class='text-center'>$no</td>
						<td>$row->nama_mapel</td>
						
						<td>".cmb_dinamis('guru', 'tbl_guru', 'nama_guru', 'id_guru', $row->id_guru, "id='guru".$row->id_jadwal."' onChange='updateGuru(".$row->id_jadwal.")'")."</td>

						<td>".cmb_dinamis('ruangan', 'tbl_ruangan', 'nama_ruangan', 'kd_ruangan', $row->kd_ruangan, "id='ruangan".$row->id_jadwal."' onChange='updateRuangan(".$row->id_jadwal.")'")."</td>
						
						<td>".form_dropdown('hari', $hari, $row->hari, "class='form-control' id='hari".$row->id_jadwal."' onChange='updateHari(".$row->id_jadwal.")'")."</td>

						<td>".form_dropdown('jam', $jam_pelajaran, $row->jam, "class='form-control' id='jam".$row->id_jadwal."' onChange='updateJam(".$row->id_jadwal.")'")."</td>

						<td  class='text-center'>".anchor('jadwal/delete_dataJadwal/'.$row->id_jadwal, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"')."</td>
					 </tr>";
				$no++;
			}

            echo  "</table>";
		}

		function update_guru()
		{
			$idguru 	= $_GET['id_guru'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('id_guru' => $idguru));
		}

		function update_ruangan()
		{
			$kdruangan 	= $_GET['kd_ruangan'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('kd_ruangan' => $kdruangan));
		}

		function update_hari()
		{
			$harinya 	= $_GET['hari'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('hari' => $harinya));
		}

		function update_jam()
		{
			$jamnya 	= $_GET['jam'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('jam' => $jamnya));
		}

		function tampil_kelas()
		{
			$kd_jurusan = $this->input->get('kd_jurusan');
			$kd_tingkatan = $this->input->get('kd_tingkatan');
			
			// Validasi input
			if (empty($kd_jurusan) || empty($kd_tingkatan)) {
				echo "<option value=''>-- Parameter tidak valid --</option>";
				return;
			}
			
			echo "<select id='kelas' name='kelas' class='form-control' onChange='loadPelajaran()'>";

			// menggunakan prepared statement untuk keamanan
			$this->db->where('kd_jurusan', $kd_jurusan);
			$this->db->where('kd_tingkatan', $kd_tingkatan);
			$kelas = $this->db->get('tbl_kelas');
			
			if ($kelas && $kelas->num_rows() > 0) {
				foreach ($kelas->result() as $row) {
					echo "<option value='$row->kd_kelas'>$row->nama_kelas</option>";
				}
			} else {
				echo "<option value=''>-- Tidak ada kelas tersedia --</option>";
			}

			echo "</select>";
		}

		function cetak_jadwal() {
	 		$kelas = $_POST['kelas'];
	 		$this->load->library('CFPDF');

	 		$days            = array(
								'SENIN'  => 'SENIN',
								'SELASA' => 'SELASA',
								'RABU'   => 'RABU',
								'KAMIS'  => 'KAMIS',
								'JUMAT'  => 'JUMAT',
								'SABTU'  => 'SABTU'
							 );

	 		$pdf = new FPDF('L', 'mm', 'A4');
	 		$pdf->AddPage();
	 		$pdf->SetFont('Arial','B',12);
        	$pdf->Cell(10,10,'NO',1,0,'L');
        	$pdf->Cell(30,10,'WAKTU',1,0,'L');

        	foreach ($days as $day) {
        		$pdf->Cell(40,10,$day,1,0,'L');
        	}
        	$pdf->Cell(30,10,'',0,1,'L');

        	$jam_ajar = $this->model_jadwal->jamPelajaran();
        	$no=1;

        	foreach ($jam_ajar as $jam) {
        		$pdf->Cell(10,10,$no,1,0,'L');
            	$pdf->Cell(30,10,$jam,1,0,'L');

            	foreach ($days as $day) {
            		$pdf->Cell(40,10,  $this->getPelajaran($jam, $day, $kelas),1,0,'L');
            	}
            	$pdf->Cell(30,10,'',0,1,'L');
            	$no++;
        	}

	 		$pdf->Output();
	 	}

	 	function getPelajaran($jam, $hari, $kelas) {
	 		// Validasi input
	 		if (empty($jam) || empty($hari) || empty($kelas)) {
	 			return '-';
	 		}
	 		
	 		$sql = "SELECT tj.*, tm.nama_mapel
                   FROM tbl_jadwal as tj 
                   INNER JOIN tbl_mapel as tm ON tj.kd_mapel = tm.kd_mapel 
                   WHERE tj.kd_kelas = ? AND tj.hari = ? AND tj.jam = ?";
	 		$pelajaran = $this->db->query($sql, array($kelas, $hari, $jam));
	 		
	 		if ($pelajaran && $pelajaran->num_rows() > 0) {
	 			$row = $pelajaran->row_array();
	 			return $row['nama_mapel'];
	 		} else {
	 			return '-';
	 		}
	 	}

	}

?>