<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-users"></i> Pilih Kelas untuk Input Nilai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('nilai'); ?>">Input Nilai</a></li>
                    <li class="breadcrumb-item active">Pilih Kelas</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Subject Info -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book"></i> Mata Pelajaran: 
                    <strong><?php echo isset($subject->nama_mapel) ? $subject->nama_mapel : 'Tidak ditemukan'; ?></strong>
                </h3>
                <div class="card-tools">
                    <a href="<?php echo base_url('nilai'); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($subject)): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Kode Mata Pelajaran:</strong> 
                               <span class="badge badge-primary"><?php echo $subject->kode_mapel; ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jumlah Kelas:</strong> 
                               <span class="badge badge-success"><?php echo count($classes); ?> Kelas</span>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Classes List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Daftar Kelas
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($classes)): ?>
                    <div class="row">
                        <?php foreach ($classes as $class): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">
                                            <strong><?php echo $class->nama_kelas; ?></strong>
                                        </h5>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <?php echo $class->nama_tingkatan; ?> • <?php echo $class->nama_jurusan; ?>
                                            </small>
                                        </p>
                                        <a href="<?php echo base_url('nilai/input/' . $mapel_id . '/' . $class->id_kelas); ?>" 
                                           class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Input Nilai
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Kelas Tersedia</h5>
                        <p class="text-muted">
                            Tidak ada kelas yang ditemukan untuk mata pelajaran ini.<br>
                            <strong>Kemungkinan penyebab:</strong><br>
                            • Jadwal pelajaran belum dibuat untuk mata pelajaran ini<br>
                            • Anda belum ditugaskan mengajar di kelas tertentu<br>
                            • Tidak ada kelas aktif untuk tahun akademik ini<br><br>
                            Silakan hubungi administrator untuk mengatur jadwal atau assignment kelas.
                        </p>
                        <a href="<?php echo base_url('nilai'); ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mata Pelajaran
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informasi
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Ketentuan Input Nilai:</strong></h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Nilai berkisar antara 0-100</li>
                            <li><i class="fas fa-check text-success"></i> Dapat menginput berbagai kategori nilai</li>
                            <li><i class="fas fa-check text-success"></i> Nilai dapat diubah kapan saja</li>
                            <li><i class="fas fa-check text-success"></i> Otomatis tersimpan per siswa</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Kategori Nilai:</strong></h6>
                        <ul class="list-unstyled">
                            <li><span class="badge badge-primary">Tugas</span> - Tugas harian dan PR</li>
                            <li><span class="badge badge-success">Ulangan Harian</span> - Quiz mingguan</li>
                            <li><span class="badge badge-warning">UTS</span> - Ujian Tengah Semester</li>
                            <li><span class="badge badge-danger">UAS</span> - Ujian Akhir Semester</li>
                            <li><span class="badge badge-info">Praktek</span> - Nilai praktikum</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.card-outline {
    border-top: 3px solid #007bff;
}

.card-outline:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.card-body .fa-users {
    color: #6c757d;
}

@media (max-width: 768px) {
    .col-md-6.col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>