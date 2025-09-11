<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-school me-2"></i>
                            Laporan Data Kelas
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('laporan'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Statistics -->
                    <div class="card-body pb-2">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-school"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Kelas</span>
                                        <span class="info-box-number"><?php echo isset($total_kelas) ? number_format($total_kelas) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Jurusan</span>
                                        <span class="info-box-number"><?php echo isset($total_jurusan) ? number_format($total_jurusan) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Wali Kelas</span>
                                        <span class="info-box-number"><?php echo isset($total_walikelas) ? number_format($total_walikelas) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Rata-rata Siswa</span>
                                        <span class="info-box-number"><?php echo isset($avg_siswa_per_kelas) ? number_format($avg_siswa_per_kelas, 0) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter and Print Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-print me-2"></i>
                            Cetak Laporan Kelas
                        </h4>
                    </div>
                    
                    <?php echo form_open('laporan/cetak_kelas', 'class="needs-validation" target="_blank" novalidate'); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="tingkatan" class="form-label">Filter Tingkatan</label>
                                    <select class="form-select" id="tingkatan" name="tingkatan">
                                        <option value="">Semua Tingkatan</option>
                                        <option value="1">Kelas X</option>
                                        <option value="2">Kelas XI</option>
                                        <option value="3">Kelas XII</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="jurusan" class="form-label">Filter Jurusan</label>
                                    <select class="form-select" id="jurusan" name="jurusan">
                                        <option value="">Semua Jurusan</option>
                                        <?php if (isset($jurusan_list)): ?>
                                            <?php foreach ($jurusan_list as $j): ?>
                                                <option value="<?php echo $j->id_jurusan; ?>">
                                                    <?php echo $j->nama_jurusan; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Filter Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="nonaktif">Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="format" class="form-label">
                                        Format Output <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="format" name="format" required>
                                        <option value="">Pilih Format</option>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">Excel</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Silakan pilih format output.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="include_siswa" class="form-label">Sertakan Data Siswa</label>
                                    <select class="form-select" id="include_siswa" name="include_siswa">
                                        <option value="count">Hanya Jumlah Siswa</option>
                                        <option value="list">Daftar Nama Siswa</option>
                                        <option value="detail">Detail Lengkap Siswa</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="include_walikelas" class="form-label">Sertakan Wali Kelas</label>
                                    <select class="form-select" id="include_walikelas" name="include_walikelas">
                                        <option value="yes" selected>Ya</option>
                                        <option value="no">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Data Columns Selection -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-table me-2"></i>
                                    Kolom Data yang Akan Dicetak
                                </h6>
                                <div class="card-tools">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" checked>
                                        <label class="form-check-label" for="checkAll">
                                            Pilih Semua
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6 class="text-primary">Data Kelas</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_kode" name="columns[]" value="kode_kelas" checked>
                                            <label class="form-check-label" for="col_kode">Kode Kelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nama" name="columns[]" value="nama_kelas" checked>
                                            <label class="form-check-label" for="col_nama">Nama Kelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_tingkatan" name="columns[]" value="tingkatan" checked>
                                            <label class="form-check-label" for="col_tingkatan">Tingkatan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jurusan" name="columns[]" value="jurusan" checked>
                                            <label class="form-check-label" for="col_jurusan">Jurusan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_kapasitas" name="columns[]" value="kapasitas">
                                            <label class="form-check-label" for="col_kapasitas">Kapasitas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-success">Data Wali Kelas</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_walikelas" name="columns[]" value="nama_walikelas" checked>
                                            <label class="form-check-label" for="col_walikelas">Nama Wali Kelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nip_wali" name="columns[]" value="nip_walikelas">
                                            <label class="form-check-label" for="col_nip_wali">NIP Wali Kelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_kontak_wali" name="columns[]" value="kontak_walikelas">
                                            <label class="form-check-label" for="col_kontak_wali">Kontak Wali Kelas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-warning">Data Siswa</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jml_siswa" name="columns[]" value="jumlah_siswa" checked>
                                            <label class="form-check-label" for="col_jml_siswa">Jumlah Siswa</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jml_laki" name="columns[]" value="jumlah_laki">
                                            <label class="form-check-label" for="col_jml_laki">Jumlah Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jml_perempuan" name="columns[]" value="jumlah_perempuan">
                                            <label class="form-check-label" for="col_jml_perempuan">Jumlah Perempuan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_status" name="columns[]" value="status" checked>
                                            <label class="form-check-label" for="col_status">Status Kelas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Information -->
                        <div class="alert alert-info mt-3">
                            <h6><i class="fas fa-info-circle"></i> Informasi Laporan</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="mb-0">
                                        <li>Laporan akan menampilkan semua data kelas yang terdaftar</li>
                                        <li>Termasuk informasi kode kelas, nama kelas, tingkatan, dan jurusan</li>
                                        <li>Format PDF cocok untuk pencetakan resmi</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="mb-0">
                                        <li>Format Excel dapat diedit dan dianalisis lebih lanjut</li>
                                        <li>Data wali kelas akan ditampilkan jika tersedia</li>
                                        <li>Jumlah siswa dihitung berdasarkan data terkini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                        <button type="button" class="btn btn-success btn-lg" onclick="generatePreview()">
                            <i class="fas fa-eye"></i> Preview Data
                        </button>
                        <a href="<?php echo site_url('laporan'); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            Ringkasan Data Kelas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Berdasarkan Tingkatan</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tingkatan</th>
                                                <th class="text-center">Jumlah Kelas</th>
                                                <th class="text-center">Jumlah Siswa</th>
                                                <th class="text-center">Rata-rata</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kelas X</td>
                                                <td class="text-center"><?php echo isset($kelas_x) ? $kelas_x : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($siswa_x) ? $siswa_x : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($kelas_x) && $kelas_x > 0 ? round($siswa_x / $kelas_x, 1) : '0'; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kelas XI</td>
                                                <td class="text-center"><?php echo isset($kelas_xi) ? $kelas_xi : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($siswa_xi) ? $siswa_xi : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($kelas_xi) && $kelas_xi > 0 ? round($siswa_xi / $kelas_xi, 1) : '0'; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kelas XII</td>
                                                <td class="text-center"><?php echo isset($kelas_xii) ? $kelas_xii : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($siswa_xii) ? $siswa_xii : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($kelas_xii) && $kelas_xii > 0 ? round($siswa_xii / $kelas_xii, 1) : '0'; ?></td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Total</strong></td>
                                                <td class="text-center"><strong><?php echo isset($total_kelas) ? $total_kelas : '0'; ?></strong></td>
                                                <td class="text-center"><strong><?php echo isset($total_siswa_all) ? $total_siswa_all : '0'; ?></strong></td>
                                                <td class="text-center"><strong><?php echo isset($avg_siswa_per_kelas) ? round($avg_siswa_per_kelas, 1) : '0'; ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Berdasarkan Jurusan</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jurusan</th>
                                                <th class="text-center">Jumlah Kelas</th>
                                                <th class="text-center">Jumlah Siswa</th>
                                                <th class="text-center">Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($kelas_by_jurusan)): ?>
                                                <?php foreach ($kelas_by_jurusan as $jurusan): ?>
                                                    <tr>
                                                        <td><?php echo $jurusan->nama_jurusan; ?></td>
                                                        <td class="text-center"><?php echo $jurusan->jumlah_kelas; ?></td>
                                                        <td class="text-center"><?php echo $jurusan->jumlah_siswa; ?></td>
                                                        <td class="text-center"><?php echo isset($total_siswa_all) && $total_siswa_all > 0 ? round(($jurusan->jumlah_siswa / $total_siswa_all) * 100, 1) : '0'; ?>%</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.info-box {
    display: block;
    min-height: 90px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
}
.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 90px;
    width: 90px;
    text-align: center;
    font-size: 45px;
    line-height: 90px;
    background: rgba(0,0,0,0.2);
    color: rgba(255,255,255,0.8);
}
.info-box-content {
    padding: 5px 10px;
    margin-left: 90px;
}
.info-box-text {
    text-transform: uppercase;
    font-weight: bold;
    font-size: 13px;
    color: #fff;
}
.info-box-number {
    display: block;
    font-weight: bold;
    font-size: 18px;
    color: #fff;
}
</style>

<script>
$(document).ready(function() {
    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Auto focus on format select
    $('#format').focus();
    
    // Check/uncheck all columns
    $('#checkAll').change(function() {
        $('input[name="columns[]"]').prop('checked', this.checked);
    });
    
    // Update check all state when individual checkboxes change
    $('input[name="columns[]"]').change(function() {
        const totalCheckboxes = $('input[name="columns[]"]').length;
        const checkedCheckboxes = $('input[name="columns[]"]:checked').length;
        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
});

function generatePreview() {
    const formData = new FormData($('form')[0]);
    formData.set('action', 'preview');
    
    // You can implement AJAX preview here
    alert('Preview functionality will show a sample of the class data to be printed.');
}
</script>