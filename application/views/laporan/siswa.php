<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users me-2"></i>
                            Laporan Data Siswa
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
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-user-graduate"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Siswa</span>
                                        <span class="info-box-number"><?php echo isset($total_siswa) ? number_format($total_siswa) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Laki-laki</span>
                                        <span class="info-box-number"><?php echo isset($siswa_laki) ? number_format($siswa_laki) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-female"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Perempuan</span>
                                        <span class="info-box-number"><?php echo isset($siswa_perempuan) ? number_format($siswa_perempuan) : '0'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Kelas</span>
                                        <span class="info-box-number"><?php echo isset($total_kelas) ? number_format($total_kelas) : '0'; ?></span>
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
                            Cetak Laporan Siswa
                        </h4>
                    </div>
                    
                    <?php echo form_open('laporan/cetak_siswa', 'class="needs-validation" target="_blank" novalidate'); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="kelas" class="form-label">Filter Kelas</label>
                                    <select class="form-select" id="kelas" name="kelas">
                                        <option value="">Semua Kelas</option>
                                        <?php if (isset($kelas)): ?>
                                            <?php foreach ($kelas as $k): ?>
                                                <option value="<?php echo $k->id_kelas; ?>">
                                                    <?php echo $k->nama_kelas . ' - ' . $k->nama_jurusan; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="jurusan" class="form-label">Filter Jurusan</label>
                                    <select class="form-select" id="jurusan" name="jurusan">
                                        <option value="">Semua Jurusan</option>
                                        <?php if (isset($jurusan)): ?>
                                            <?php foreach ($jurusan as $j): ?>
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
                                        <option value="aktif">Aktif</option>
                                        <option value="pindah">Pindah</option>
                                        <option value="lulus">Lulus</option>
                                        <option value="keluar">Keluar</option>
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
                                    <label for="include_photo" class="form-label">Sertakan Foto</label>
                                    <select class="form-select" id="include_photo" name="include_photo">
                                        <option value="no">Tidak</option>
                                        <option value="yes">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Information -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Laporan</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="mb-0">
                                        <li>Laporan akan menampilkan data siswa sesuai filter yang dipilih</li>
                                        <li>Format PDF cocok untuk pencetakan resmi</li>
                                        <li>Format Excel dapat diedit dan dianalisis lebih lanjut</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="mb-0">
                                        <li>Jika tidak ada filter yang dipilih, semua data akan ditampilkan</li>
                                        <li>Orientasi landscape direkomendasikan untuk tampilan lengkap</li>
                                        <li>Foto siswa akan memperbesar ukuran file</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Data Preview -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-table me-2"></i>
                                    Kolom Data yang Akan Dicetak
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nisn" name="columns[]" value="nisn" checked>
                                            <label class="form-check-label" for="col_nisn">NISN</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nis" name="columns[]" value="nis" checked>
                                            <label class="form-check-label" for="col_nis">NIS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_nama" name="columns[]" value="nama_siswa" checked>
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
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_agama" name="columns[]" value="agama">
                                            <label class="form-check-label" for="col_agama">Agama</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_alamat" name="columns[]" value="alamat">
                                            <label class="form-check-label" for="col_alamat">Alamat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_ortu" name="columns[]" value="orang_tua">
                                            <label class="form-check-label" for="col_ortu">Nama Orang Tua</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_kelas" name="columns[]" value="kelas" checked>
                                            <label class="form-check-label" for="col_kelas">Kelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="col_status" name="columns[]" value="status" checked>
                                            <label class="form-check-label" for="col_status">Status</label>
                                        </div>
                                    </div>
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

    // Auto focus on first select
    $('#kelas').focus();
    
    // Check/uncheck all columns
    $('#checkAll').change(function() {
        $('input[name="columns[]"]').prop('checked', this.checked);
    });
});

function generatePreview() {
    const formData = new FormData($('form')[0]);
    formData.set('action', 'preview');
    
    // You can implement AJAX preview here
    alert('Preview functionality will show a sample of the data to be printed.');
}
</script>