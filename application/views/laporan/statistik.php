<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie me-2"></i>
                            Laporan Statistik Sekolah
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('laporan'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Statistics Overview -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_siswa; ?></h4>
                                                <p class="mb-0">Total Siswa</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-users fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_guru; ?></h4>
                                                <p class="mb-0">Total Guru</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_kelas; ?></h4>
                                                <p class="mb-0">Total Kelas</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-school fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_jurusan; ?></h4>
                                                <p class="mb-0">Total Jurusan</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-graduation-cap fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Statistics -->
                        <div class="row">
                            <!-- Student by Gender -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Siswa Berdasarkan Jenis Kelamin</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($siswa_by_gender)): ?>
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Kelamin</th>
                                                        <th class="text-end">Jumlah</th>
                                                        <th class="text-end">Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siswa_by_gender as $stat): ?>
                                                        <tr>
                                                            <td><?php echo $stat->jenis_kelamin; ?></td>
                                                            <td class="text-end"><?php echo $stat->total; ?></td>
                                                            <td class="text-end">
                                                                <?php echo round(($stat->total / $total_siswa) * 100, 1); ?>%
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p class="text-muted">Tidak ada data siswa.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Teacher by Gender -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Guru Berdasarkan Jenis Kelamin</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($guru_by_gender)): ?>
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Kelamin</th>
                                                        <th class="text-end">Jumlah</th>
                                                        <th class="text-end">Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($guru_by_gender as $stat): ?>
                                                        <tr>
                                                            <td><?php echo $stat->jenis_kelamin; ?></td>
                                                            <td class="text-end"><?php echo $stat->total; ?></td>
                                                            <td class="text-end">
                                                                <?php echo round(($stat->total / $total_guru) * 100, 1); ?>%
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p class="text-muted">Tidak ada data guru.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Student by Major -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Siswa Berdasarkan Jurusan</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($siswa_by_jurusan)): ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Jurusan</th>
                                                        <th class="text-end">Jumlah Siswa</th>
                                                        <th class="text-end">Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $no = 1;
                                                    foreach ($siswa_by_jurusan as $stat): 
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $stat->nama_jurusan ?: 'Belum Ditentukan'; ?></td>
                                                            <td class="text-end"><?php echo $stat->total; ?></td>
                                                            <td class="text-end">
                                                                <?php echo round(($stat->total / $total_siswa) * 100, 1); ?>%
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p class="text-muted">Tidak ada data siswa berdasarkan jurusan.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Print Options -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cetak Laporan Statistik</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php echo form_open('laporan/cetak_statistik', 'class="needs-validation" target="_blank" novalidate'); ?>
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
                                            <div class="col-md-8">
                                                <label class="form-label">&nbsp;</label>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-print"></i> Cetak Laporan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
});
</script>