<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Siswa_model');
        $this->load->model('Guru_model');
        $this->load->model('Kelas_model');
        $this->load->model('Matapelajaran_model');
        $this->load->model('Jurusan_model');
        $this->load->model('Tingkatan_model');
        $this->load->model('Tahun_akademik_model');
        $this->load->library('form_validation');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Check user level access (admin, teachers can access reports)
        $user_level = $this->session->userdata('id_level_user');
        if (!in_array($user_level, [1, 2, 3])) { // Admin, Wali Kelas, Guru
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Sistem';
        $data['page_title'] = 'Dashboard Laporan';
        $data['breadcrumb'] = [
            ['title' => 'Laporan'],
            ['title' => 'Dashboard Laporan']
        ];
        $data['contents'] = $this->load->view('laporan/index', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    // Student Reports
    public function siswa()
    {
        $data['title'] = 'Laporan Data Siswa';
        $data['page_title'] = 'Laporan Siswa';
        $data['breadcrumb'] = [
            ['title' => 'Laporan'],
            ['title' => 'Laporan Siswa']
        ];
        
        // Get filter options
        $data['kelas'] = $this->Kelas_model->get_active_with_details();
        $data['jurusan'] = $this->Jurusan_model->get_active();
        $data['tahun_akademik'] = $this->Tahun_akademik_model->get_active();
        
        // Get statistics for display
        $data['total_siswa'] = $this->Siswa_model->count_active();
        $data['siswa_laki'] = $this->Siswa_model->count_by_gender('L');
        $data['siswa_perempuan'] = $this->Siswa_model->count_by_gender('P');
        $data['total_kelas'] = $this->Kelas_model->count_active();
        
        $data['contents'] = $this->load->view('laporan/siswa', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function cetak_siswa()
    {
        if (!$this->input->post()) {
            redirect('laporan/siswa');
        }

        $filter_kelas = $this->input->post('kelas');
        $filter_jurusan = $this->input->post('jurusan');
        $format = $this->input->post('format');
        
        if ($format == 'pdf') {
            $this->cetak_siswa_pdf($filter_kelas, $filter_jurusan);
        } else {
            $this->cetak_siswa_excel($filter_kelas, $filter_jurusan);
        }
    }

    private function cetak_siswa_pdf($filter_kelas = null, $filter_jurusan = null)
    {
        $this->load->library('CFPDF');
        require_once APPPATH . '/libraries/fpdf.php';
        
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 10, 'SMK BINA MANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(277, 8, 'LAPORAN DATA SISWA', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(277, 6, 'Tanggal: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(5);

        // Filter info
        if ($filter_kelas || $filter_jurusan) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 6, 'Filter:', 0, 0, 'L');
            if ($filter_kelas) {
                $kelas = $this->Kelas_model->get_by_id($filter_kelas);
                $pdf->Cell(100, 6, 'Kelas: ' . ($kelas ? $kelas->nama_kelas : 'Semua'), 0, 1, 'L');
            }
            if ($filter_jurusan) {
                $jurusan = $this->Jurusan_model->get_by_id($filter_jurusan);
                $pdf->Cell(100, 6, 'Jurusan: ' . ($jurusan ? $jurusan->nama_jurusan : 'Semua'), 0, 1, 'L');
            }
            $pdf->Ln(3);
        }

        // Table Header
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'NISN', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Nama Siswa', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'L/P', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Tempat Lahir', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Tgl Lahir', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Kelas', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Jurusan', 1, 0, 'C', true);
        $pdf->Cell(17, 8, 'Status', 1, 1, 'C', true);

        // Get data with filters
        $where = array();
        if ($filter_kelas) $where['s.id_kelas'] = $filter_kelas;
        if ($filter_jurusan) $where['k.id_jurusan'] = $filter_jurusan;
        
        $siswa = $this->Siswa_model->get_all_with_details_filtered($where);

        // Table Data
        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        foreach ($siswa as $row) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(25, 6, $row->nisn, 1, 0, 'C');
            $pdf->Cell(50, 6, substr($row->nama_siswa, 0, 30), 1, 0, 'L');
            $pdf->Cell(20, 6, $row->jenis_kelamin, 1, 0, 'C');
            $pdf->Cell(35, 6, substr($row->tempat_lahir, 0, 20), 1, 0, 'L');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($row->tanggal_lahir)), 1, 0, 'C');
            $pdf->Cell(30, 6, $row->nama_kelas ?: '-', 1, 0, 'C');
            $pdf->Cell(35, 6, substr($row->nama_jurusan ?: '-', 0, 20), 1, 0, 'L');
            $pdf->Cell(17, 6, $row->status, 1, 1, 'C');
        }

        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(200, 6, 'Dicetak pada: ' . date('d F Y, H:i:s'), 0, 0, 'L');
        $pdf->Cell(77, 6, 'Total: ' . count($siswa) . ' siswa', 0, 1, 'R');

        $pdf->Output('I', 'Laporan_Siswa_' . date('Y-m-d') . '.pdf');
    }

    private function cetak_siswa_excel($filter_kelas = null, $filter_jurusan = null)
    {
        // Get data with filters
        $where = array();
        if ($filter_kelas) $where['s.id_kelas'] = $filter_kelas;
        if ($filter_jurusan) $where['k.id_jurusan'] = $filter_jurusan;
        
        $siswa = $this->Siswa_model->get_all_with_details_filtered($where);

        // Create Excel file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Siswa_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        echo '<table border="1">';
        echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        echo '<td>No</td>';
        echo '<td>NISN</td>';
        echo '<td>Nama Siswa</td>';
        echo '<td>Jenis Kelamin</td>';
        echo '<td>Tempat Lahir</td>';
        echo '<td>Tanggal Lahir</td>';
        echo '<td>Kelas</td>';
        echo '<td>Jurusan</td>';
        echo '<td>Status</td>';
        echo '</tr>';

        $no = 1;
        foreach ($siswa as $row) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $row->nisn . '</td>';
            echo '<td>' . $row->nama_siswa . '</td>';
            echo '<td>' . $row->jenis_kelamin . '</td>';
            echo '<td>' . $row->tempat_lahir . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($row->tanggal_lahir)) . '</td>';
            echo '<td>' . ($row->nama_kelas ?: '-') . '</td>';
            echo '<td>' . ($row->nama_jurusan ?: '-') . '</td>';
            echo '<td>' . $row->status . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }

    // Teacher Reports
    public function guru()
    {
        $data['title'] = 'Laporan Data Guru';
        $data['page_title'] = 'Laporan Guru';
        $data['breadcrumb'] = [
            ['title' => 'Laporan'],
            ['title' => 'Laporan Guru']
        ];
        
        // Get statistics for display
        $data['total_guru'] = $this->Guru_model->count_active();
        $data['guru_pns'] = $this->Guru_model->count_by_status_kepegawaian('PNS');
        $data['guru_gtt'] = $this->Guru_model->count_by_status_kepegawaian('GTT') + $this->Guru_model->count_by_status_kepegawaian('GTY');
        $data['guru_laki'] = $this->Guru_model->count_by_gender('L');
        $data['guru_perempuan'] = $this->Guru_model->count_by_gender('P');
        $data['total_mapel'] = $this->Matapelajaran_model->count_active();
        
        $data['contents'] = $this->load->view('laporan/guru', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function cetak_guru()
    {
        $format = $this->input->post('format');
        
        if ($format == 'pdf') {
            $this->cetak_guru_pdf();
        } else {
            $this->cetak_guru_excel();
        }
    }

    private function cetak_guru_pdf()
    {
        $this->load->library('CFPDF');
        require_once APPPATH . '/libraries/fpdf.php';
        
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 10, 'SMK BINA MANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(277, 8, 'LAPORAN DATA GURU', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(277, 6, 'Tanggal: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(8);

        // Table Header
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'NIP', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'NUPTK', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Nama Guru', 1, 0, 'C', true);
        $pdf->Cell(15, 8, 'L/P', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Tempat Lahir', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Tgl Lahir', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Pendidikan', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Status', 1, 0, 'C', true);
        $pdf->Cell(22, 8, 'Gol/Ruang', 1, 1, 'C', true);

        // Get data
        $guru = $this->Guru_model->get_all();

        // Table Data
        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        foreach ($guru as $row) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(25, 6, $row->nip ?: '-', 1, 0, 'C');
            $pdf->Cell(20, 6, $row->nuptk ?: '-', 1, 0, 'C');
            $pdf->Cell(50, 6, substr($row->nama_guru, 0, 30), 1, 0, 'L');
            $pdf->Cell(15, 6, $row->jenis_kelamin, 1, 0, 'C');
            $pdf->Cell(25, 6, substr($row->tempat_lahir, 0, 15), 1, 0, 'L');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($row->tanggal_lahir)), 1, 0, 'C');
            $pdf->Cell(30, 6, substr($row->pendidikan_terakhir, 0, 15), 1, 0, 'L');
            $pdf->Cell(25, 6, $row->status_kepegawaian, 1, 0, 'C');
            $pdf->Cell(22, 6, $row->golongan_ruang ?: '-', 1, 1, 'C');
        }

        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(200, 6, 'Dicetak pada: ' . date('d F Y, H:i:s'), 0, 0, 'L');
        $pdf->Cell(77, 6, 'Total: ' . count($guru) . ' guru', 0, 1, 'R');

        $pdf->Output('I', 'Laporan_Guru_' . date('Y-m-d') . '.pdf');
    }

    private function cetak_guru_excel()
    {
        $guru = $this->Guru_model->get_all();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Guru_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        echo '<table border="1">';
        echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        echo '<td>No</td>';
        echo '<td>NIP</td>';
        echo '<td>NUPTK</td>';
        echo '<td>Nama Guru</td>';
        echo '<td>Jenis Kelamin</td>';
        echo '<td>Tempat Lahir</td>';
        echo '<td>Tanggal Lahir</td>';
        echo '<td>Pendidikan Terakhir</td>';
        echo '<td>Status Kepegawaian</td>';
        echo '<td>Golongan/Ruang</td>';
        echo '</tr>';

        $no = 1;
        foreach ($guru as $row) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . ($row->nip ?: '-') . '</td>';
            echo '<td>' . ($row->nuptk ?: '-') . '</td>';
            echo '<td>' . $row->nama_guru . '</td>';
            echo '<td>' . $row->jenis_kelamin . '</td>';
            echo '<td>' . $row->tempat_lahir . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($row->tanggal_lahir)) . '</td>';
            echo '<td>' . $row->pendidikan_terakhir . '</td>';
            echo '<td>' . $row->status_kepegawaian . '</td>';
            echo '<td>' . ($row->golongan_ruang ?: '-') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }

    // Class Reports
    public function kelas()
    {
        $data['title'] = 'Laporan Data Kelas';
        $data['page_title'] = 'Laporan Kelas';
        $data['breadcrumb'] = [
            ['title' => 'Laporan'],
            ['title' => 'Laporan Kelas']
        ];
        
        // Get filter options
        $data['jurusan_list'] = $this->Jurusan_model->get_active();
        
        // Get statistics for display
        $data['total_kelas'] = $this->Kelas_model->count_active();
        $data['total_jurusan'] = $this->Jurusan_model->count_active();
        $data['total_walikelas'] = $this->db->where('status', 'aktif')->count_all_results('tb_wali_kelas');
        
        // Get class statistics by tingkatan
        $this->db->select('COUNT(*) as count, SUM((SELECT COUNT(*) FROM tb_siswa WHERE tb_siswa.id_kelas = tb_kelas.id_kelas AND tb_siswa.status = "aktif")) as siswa_count');
        $this->db->where('id_tingkatan', 1);
        $this->db->where('status', 'aktif');
        $kelas_x_data = $this->db->get('tb_kelas')->row();
        $data['kelas_x'] = $kelas_x_data ? $kelas_x_data->count : 0;
        $data['siswa_x'] = $kelas_x_data ? $kelas_x_data->siswa_count : 0;
        
        $this->db->select('COUNT(*) as count, SUM((SELECT COUNT(*) FROM tb_siswa WHERE tb_siswa.id_kelas = tb_kelas.id_kelas AND tb_siswa.status = "aktif")) as siswa_count');
        $this->db->where('id_tingkatan', 2);
        $this->db->where('status', 'aktif');
        $kelas_xi_data = $this->db->get('tb_kelas')->row();
        $data['kelas_xi'] = $kelas_xi_data ? $kelas_xi_data->count : 0;
        $data['siswa_xi'] = $kelas_xi_data ? $kelas_xi_data->siswa_count : 0;
        
        $this->db->select('COUNT(*) as count, SUM((SELECT COUNT(*) FROM tb_siswa WHERE tb_siswa.id_kelas = tb_kelas.id_kelas AND tb_siswa.status = "aktif")) as siswa_count');
        $this->db->where('id_tingkatan', 3);
        $this->db->where('status', 'aktif');
        $kelas_xii_data = $this->db->get('tb_kelas')->row();
        $data['kelas_xii'] = $kelas_xii_data ? $kelas_xii_data->count : 0;
        $data['siswa_xii'] = $kelas_xii_data ? $kelas_xii_data->siswa_count : 0;
        
        $data['total_siswa_all'] = $data['siswa_x'] + $data['siswa_xi'] + $data['siswa_xii'];
        $data['avg_siswa_per_kelas'] = $data['total_kelas'] > 0 ? $data['total_siswa_all'] / $data['total_kelas'] : 0;
        
        // Get class statistics by jurusan
        $this->db->select('j.nama_jurusan, COUNT(k.id_kelas) as jumlah_kelas, SUM((SELECT COUNT(*) FROM tb_siswa WHERE tb_siswa.id_kelas = k.id_kelas AND tb_siswa.status = "aktif")) as jumlah_siswa');
        $this->db->from('tb_kelas k');
        $this->db->join('tb_jurusan j', 'k.id_jurusan = j.id_jurusan');
        $this->db->where('k.status', 'aktif');
        $this->db->group_by('j.id_jurusan');
        $data['kelas_by_jurusan'] = $this->db->get()->result();
        
        $data['contents'] = $this->load->view('laporan/kelas', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function cetak_kelas()
    {
        $format = $this->input->post('format');
        
        if ($format == 'pdf') {
            $this->cetak_kelas_pdf();
        } else {
            $this->cetak_kelas_excel();
        }
    }

    private function cetak_kelas_pdf()
    {
        $this->load->library('CFPDF');
        require_once APPPATH . '/libraries/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'SMK BINA MANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 8, 'LAPORAN DATA KELAS', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'Tanggal: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(8);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Kode Kelas', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Nama Kelas', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Tingkatan', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Jurusan', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'Status', 1, 1, 'C', true);

        // Get data
        $kelas = $this->Kelas_model->get_all();

        // Table Data
        $pdf->SetFont('Arial', '', 9);
        $no = 1;
        foreach ($kelas as $row) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, $row->kode_kelas, 1, 0, 'C');
            $pdf->Cell(50, 6, $row->nama_kelas, 1, 0, 'L');
            $pdf->Cell(40, 6, $row->nama_tingkatan, 1, 0, 'L');
            $pdf->Cell(40, 6, $row->nama_jurusan, 1, 0, 'L');
            $pdf->Cell(20, 6, $row->status, 1, 1, 'C');
        }

        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(150, 6, 'Dicetak pada: ' . date('d F Y, H:i:s'), 0, 0, 'L');
        $pdf->Cell(40, 6, 'Total: ' . count($kelas) . ' kelas', 0, 1, 'R');

        $pdf->Output('I', 'Laporan_Kelas_' . date('Y-m-d') . '.pdf');
    }

    private function cetak_kelas_excel()
    {
        $kelas = $this->Kelas_model->get_all();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Kelas_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        echo '<table border="1">';
        echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        echo '<td>No</td>';
        echo '<td>Kode Kelas</td>';
        echo '<td>Nama Kelas</td>';
        echo '<td>Tingkatan</td>';
        echo '<td>Jurusan</td>';
        echo '<td>Status</td>';
        echo '</tr>';

        $no = 1;
        foreach ($kelas as $row) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $row->kode_kelas . '</td>';
            echo '<td>' . $row->nama_kelas . '</td>';
            echo '<td>' . $row->nama_tingkatan . '</td>';
            echo '<td>' . $row->nama_jurusan . '</td>';
            echo '<td>' . $row->status . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }

    // Statistics Report
    public function statistik()
    {
        $data['title'] = 'Laporan Statistik';
        
        // Get statistics data
        $data['total_siswa'] = $this->Siswa_model->count_all();
        $data['total_guru'] = $this->Guru_model->count_all();
        $data['total_kelas'] = $this->Kelas_model->count_all();
        $data['total_jurusan'] = $this->Jurusan_model->count_all();
        
        $data['siswa_by_gender'] = $this->Siswa_model->get_statistics_by_gender();
        $data['guru_by_gender'] = $this->Guru_model->get_statistics_by_gender();
        $data['siswa_by_jurusan'] = $this->Siswa_model->get_statistics_by_jurusan();
        
        $data['contents'] = $this->load->view('laporan/statistik', $data, TRUE);
        $this->load->view('template_new', $data);
    }

    public function cetak_statistik()
    {
        $format = $this->input->post('format');
        
        if ($format == 'pdf') {
            $this->cetak_statistik_pdf();
        } else {
            $this->cetak_statistik_excel();
        }
    }

    private function cetak_statistik_pdf()
    {
        $this->load->library('CFPDF');
        require_once APPPATH . '/libraries/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'SMK BINA MANDIRI', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 8, 'LAPORAN STATISTIK SEKOLAH', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'Tanggal: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(10);

        // General Statistics
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'STATISTIK UMUM', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        
        $total_siswa = $this->Siswa_model->count_all();
        $total_guru = $this->Guru_model->count_all();
        $total_kelas = $this->Kelas_model->count_all();
        $total_jurusan = $this->Jurusan_model->count_all();
        
        $pdf->Cell(50, 6, 'Total Siswa', 0, 0, 'L');
        $pdf->Cell(10, 6, ':', 0, 0, 'C');
        $pdf->Cell(30, 6, $total_siswa . ' siswa', 0, 1, 'L');
        
        $pdf->Cell(50, 6, 'Total Guru', 0, 0, 'L');
        $pdf->Cell(10, 6, ':', 0, 0, 'C');
        $pdf->Cell(30, 6, $total_guru . ' guru', 0, 1, 'L');
        
        $pdf->Cell(50, 6, 'Total Kelas', 0, 0, 'L');
        $pdf->Cell(10, 6, ':', 0, 0, 'C');
        $pdf->Cell(30, 6, $total_kelas . ' kelas', 0, 1, 'L');
        
        $pdf->Cell(50, 6, 'Total Jurusan', 0, 0, 'L');
        $pdf->Cell(10, 6, ':', 0, 0, 'C');
        $pdf->Cell(30, 6, $total_jurusan . ' jurusan', 0, 1, 'L');
        
        $pdf->Ln(8);

        // Statistics by Gender
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'STATISTIK BERDASARKAN JENIS KELAMIN', 0, 1, 'L');
        
        $siswa_by_gender = $this->Siswa_model->get_statistics_by_gender();
        $guru_by_gender = $this->Guru_model->get_statistics_by_gender();
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(70, 6, 'Siswa:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        foreach ($siswa_by_gender as $stat) {
            $pdf->Cell(30, 6, '- ' . $stat->jenis_kelamin, 0, 0, 'L');
            $pdf->Cell(10, 6, ':', 0, 0, 'C');
            $pdf->Cell(30, 6, $stat->total . ' siswa', 0, 1, 'L');
        }
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(70, 6, 'Guru:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        foreach ($guru_by_gender as $stat) {
            $pdf->Cell(30, 6, '- ' . $stat->jenis_kelamin, 0, 0, 'L');
            $pdf->Cell(10, 6, ':', 0, 0, 'C');
            $pdf->Cell(30, 6, $stat->total . ' guru', 0, 1, 'L');
        }
        
        $pdf->Ln(8);

        // Statistics by Major
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'STATISTIK SISWA BERDASARKAN JURUSAN', 0, 1, 'L');
        
        $siswa_by_jurusan = $this->Siswa_model->get_statistics_by_jurusan();
        
        $pdf->SetFont('Arial', '', 10);
        foreach ($siswa_by_jurusan as $stat) {
            $pdf->Cell(100, 6, '- ' . $stat->nama_jurusan, 0, 0, 'L');
            $pdf->Cell(10, 6, ':', 0, 0, 'C');
            $pdf->Cell(30, 6, $stat->total . ' siswa', 0, 1, 'L');
        }

        // Footer
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(190, 6, 'Dicetak pada: ' . date('d F Y, H:i:s'), 0, 1, 'C');

        $pdf->Output('I', 'Laporan_Statistik_' . date('Y-m-d') . '.pdf');
    }
}
?>