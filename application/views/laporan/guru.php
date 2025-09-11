<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Laporan Data Guru
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
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Guru</span>
                                        <span class="info-box-number"><?php echo isset($total_guru) ? number_format($total_guru) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">PNS</span>
                                        <span class="info-box-number"><?php echo isset($guru_pns) ? number_format($guru_pns) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-user"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">GTT/GTY</span>
                                        <span class="info-box-number"><?php echo isset($guru_gtt) ? number_format($guru_gtt) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-book"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Mapel</span>
                                        <span class="info-box-number"><?php echo isset($total_mapel) ? number_format($total_mapel) : '0'; ?></span>
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
                            Cetak Laporan Guru
                        </h4>
                    </div>
                    
                    <?php echo form_open('laporan/cetak_guru', 'class="needs-validation" target="_blank" novalidate'); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status_kepegawaian" class="form-label">Filter Status Kepegawaian</label>
                                    <select class="form-select" id="status_kepegawaian" name="status_kepegawaian">
                                        <option value="">Semua Status</option>
                                        <option value="PNS">PNS</option>
                                        <option value="GTT">GTT (Guru Tidak Tetap)</option>
                                        <option value="GTY">GTY (Guru Tetap Yayasan)</option>
                                        <option value="Honorer">Honorer</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="jenis_kelamin" class="form-label">Filter Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Semua</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
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
                                    <label for="orientasi" class="form-label">Orientasi Halaman</label>
                                    <select class="form-select" id="orientasi" name="orientasi">
                                        <option value="landscape">Landscape (Mendatar)</option>
                                        <option value="portrait">Portrait (Tegak)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="include_mapel" class="form-label">Sertakan Mata Pelajaran</label>
                                    <select class="form-select" id="include_mapel" name="include_mapel">
                                        <option value="yes">Ya</option>
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
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nip" name="columns[]" value="nip" checked>
                                            <label class="form-check-label" for="col_nip">NIP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nuptk" name="columns[]" value="nuptk">
                                            <label class="form-check-label" for="col_nuptk">NUPTK</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nama" name="columns[]" value="nama_guru" checked>
                                            <label class="form-check-label" for="col_nama">Nama Lengkap</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jk" name="columns[]" value="jenis_kelamin" checked>
                                            <label class="form-check-label" for="col_jk">Jenis Kelamin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_ttl" name="columns[]" value="tempat_tanggal_lahir">
                                            <label class="form-check-label" for="col_ttl">Tempat, Tanggal Lahir</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_agama" name="columns[]" value="agama">
                                            <label class="form-check-label" for="col_agama">Agama</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_alamat" name="columns[]" value="alamat">
                                            <label class="form-check-label" for="col_alamat">Alamat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_telp" name="columns[]" value="no_telp">
                                            <label class="form-check-label" for="col_telp">No. Telepon</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_email" name="columns[]" value="email">
                                            <label class="form-check-label" for="col_email">Email</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_pendidikan" name="columns[]" value="pendidikan_terakhir" checked>
                                            <label class="form-check-label" for="col_pendidikan">Pendidikan Terakhir</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_jabatan" name="columns[]" value="jabatan" checked>
                                            <label class="form-check-label" for="col_jabatan">Jabatan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_status_kep" name="columns[]" value="status_kepegawaian" checked>
                                            <label class="form-check-label" for="col_status_kep">Status Kepegawaian</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_golongan" name="columns[]" value="golongan_ruang">
                                            <label class="form-check-label" for="col_golongan">Golongan/Ruang</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_status" name="columns[]" value="status" checked>
                                            <label class="form-check-label" for="col_status">Status</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_mapel" name="columns[]" value="mata_pelajaran">
                                            <label class="form-check-label" for="col_mapel">Mata Pelajaran</label>
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
                                        <li>Laporan akan menampilkan semua data guru yang terdaftar</li>
                                        <li>Termasuk informasi NIP, NUPTK, data pribadi, dan status kepegawaian</li>
                                        <li>Format PDF cocok untuk pencetakan resmi</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="mb-0">
                                        <li>Format Excel dapat diedit dan dianalisis lebih lanjut</li>
                                        <li>Orientasi landscape direkomendasikan untuk data lengkap</li>
                                        <li>Mata pelajaran akan ditampilkan jika guru mengajar</li>
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
                            Ringkasan Data Guru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Berdasarkan Status Kepegawaian</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Status</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PNS</td>
                                                <td class="text-center"><?php echo isset($guru_pns) ? $guru_pns : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($total_guru) && $total_guru > 0 ? round(($guru_pns / $total_guru) * 100, 1) : '0'; ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>GTT/GTY</td>
                                                <td class="text-center"><?php echo isset($guru_gtt) ? $guru_gtt : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($total_guru) && $total_guru > 0 ? round(($guru_gtt / $total_guru) * 100, 1) : '0'; ?>%</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Total</strong></td>
                                                <td class="text-center"><strong><?php echo isset($total_guru) ? $total_guru : '0'; ?></strong></td>
                                                <td class="text-center"><strong>100%</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Berdasarkan Jenis Kelamin</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Laki-laki</td>
                                                <td class="text-center"><?php echo isset($guru_laki) ? $guru_laki : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($total_guru) && $total_guru > 0 ? round(($guru_laki / $total_guru) * 100, 1) : '0'; ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>Perempuan</td>
                                                <td class="text-center"><?php echo isset($guru_perempuan) ? $guru_perempuan : '0'; ?></td>
                                                <td class="text-center"><?php echo isset($total_guru) && $total_guru > 0 ? round(($guru_perempuan / $total_guru) * 100, 1) : '0'; ?>%</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Total</strong></td>
                                                <td class="text-center"><strong><?php echo isset($total_guru) ? $total_guru : '0'; ?></strong></td>
                                                <td class="text-center"><strong>100%</strong></td>
                                            </tr>
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
    alert('Preview functionality will show a sample of the teacher data to be printed.');
}
</script>