<!-- Admin Dashboard -->
<div class="page-title">
    <h1><i class="fas fa-tachometer-alt me-3"></i>Dashboard Administrator</h1>
    <p class="subtitle">Selamat datang di Sistem Informasi Sekolah SMK Bina Mandiri</p>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_siswa']); ?></h3>
            <p class="stat-label">Total Siswa</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_guru']); ?></h3>
            <p class="stat-label">Total Guru</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_kelas']); ?></h3>
            <p class="stat-label">Total Kelas</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_mapel']); ?></h3>
            <p class="stat-label">Mata Pelajaran</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_jurusan']); ?></h3>
            <p class="stat-label">Jurusan</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);">
            <div class="stat-icon">
                <i class="fas fa-user-cog"></i>
            </div>
            <h3 class="stat-number"><?php echo number_format($stats['total_user']); ?></h3>
            <p class="stat-label">Total User</p>
        </div>
    </div>
</div>

<!-- Charts and Activities Row -->
<div class="row">
    <!-- Chart Section -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="genderChart"></canvas>
                        <h6 class="text-center mt-3">Berdasarkan Jenis Kelamin</h6>
                    </div>
                    <div class="col-md-6">
                        <canvas id="majorChart"></canvas>
                        <h6 class="text-center mt-3">Berdasarkan Jurusan</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_activities)): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($recent_activities as $activity): ?>
                            <li class="d-flex align-items-start mb-3">
                                <div class="flex-shrink-0">
                                    <i class="<?php echo $activity['icon']; ?> fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><?php echo $activity['title']; ?></h6>
                                    <p class="mb-1 text-muted small"><?php echo $activity['description']; ?></p>
                                    <small class="text-muted"><?php echo $activity['time']; ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada aktivitas terbaru</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('siswa/add'); ?>" class="btn btn-primary w-100 py-3">
                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                            Tambah Siswa Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('guru/add'); ?>" class="btn btn-success w-100 py-3">
                            <i class="fas fa-chalkboard-teacher fa-2x d-block mb-2"></i>
                            Tambah Guru Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('kelas/add'); ?>" class="btn btn-warning w-100 py-3">
                            <i class="fas fa-users fa-2x d-block mb-2"></i>
                            Tambah Kelas Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-info w-100 py-3">
                            <i class="fas fa-file-alt fa-2x d-block mb-2"></i>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama Sekolah:</strong></td>
                        <td>SMK Bina Mandiri</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Ajaran Aktif:</strong></td>
                        <td>2024/2025</td>
                    </tr>
                    <tr>
                        <td><strong>Semester:</strong></td>
                        <td>Ganjil</td>
                    </tr>
                    <tr>
                        <td><strong>Versi Sistem:</strong></td>
                        <td>SISFO v1.0</td>
                    </tr>
                    <tr>
                        <td><strong>Last Update:</strong></td>
                        <td><?php echo date('d M Y H:i'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Kalender Akademik</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Awal Semester</h6>
                            <p class="timeline-text">15 Juli 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">UTS</h6>
                            <p class="timeline-text">15-20 Oktober 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">UAS</h6>
                            <p class="timeline-text">10-15 Desember 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-danger"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Akhir Semester</h6>
                            <p class="timeline-text">20 Desember 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gender Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($chart_data['gender']['labels']); ?>,
            datasets: [{
                data: <?php echo json_encode($chart_data['gender']['data']); ?>,
                backgroundColor: ['#007bff', '#e83e8c'],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Major Chart
    const majorCtx = document.getElementById('majorChart').getContext('2d');
    new Chart(majorCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($chart_data['major']['labels']); ?>,
            datasets: [{
                data: <?php echo json_encode($chart_data['major']['data']); ?>,
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1'],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 1rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -1.75rem;
    top: 1.5rem;
    width: 2px;
    height: calc(100% + 0.5rem);
    background-color: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 0.5rem;
}

.timeline-title {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    font-size: 0.8rem;
    color: #6c757d;
}
</style>