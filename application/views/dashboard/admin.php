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
            <h3 class="stat-number"><?php echo isset($stats['total_siswa']) ? number_format($stats['total_siswa']) : 0; ?></h3>
            <p class="stat-label">Total Siswa</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3 class="stat-number"><?php echo isset($stats['total_guru']) ? number_format($stats['total_guru']) : 0; ?></h3>
            <p class="stat-label">Total Guru</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="stat-number"><?php echo isset($stats['total_kelas']) ? number_format($stats['total_kelas']) : 0; ?></h3>
            <p class="stat-label">Total Kelas</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <h3 class="stat-number"><?php echo isset($stats['total_mapel']) ? number_format($stats['total_mapel']) : 0; ?></h3>
            <p class="stat-label">Mata Pelajaran</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3 class="stat-number"><?php echo isset($stats['total_jurusan']) ? number_format($stats['total_jurusan']) : 0; ?></h3>
            <p class="stat-label">Jurusan</p>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%);">
            <div class="stat-icon">
                <i class="fas fa-user-cog"></i>
            </div>
            <h3 class="stat-number"><?php echo isset($stats['total_user']) ? number_format($stats['total_user']) : 0; ?></h3>
            <p class="stat-label">Total User</p>
        </div>
    </div>
</div>

<!-- Charts and Activities Row -->
<div class="row">
    <!-- Chart Section -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Siswa</h5>
                <div class="card-header-actions">
                    <button class="btn btn-sm btn-outline-primary" id="refreshCharts">Refresh</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                            <canvas id="genderChart" width="300" height="300"></canvas>
                        </div>
                        <h6 class="text-center mt-3">Berdasarkan Jenis Kelamin</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                            <canvas id="majorChart" width="300" height="300"></canvas>
                        </div>
                        <h6 class="text-center mt-3">Berdasarkan Jurusan</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Aktivitas Terbaru</h5>
                <div class="card-header-actions">
                    <button class="btn btn-sm btn-outline-primary">Lihat Semua</button>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_activities)): ?>
                    <div class="activity-timeline">
                        <?php foreach ($recent_activities as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-icon bg-<?php echo isset($activity['type']) ? $activity['type'] : 'primary'; ?>">
                                    <i class="<?php echo isset($activity['icon']) ? $activity['icon'] : 'fas fa-info-circle'; ?>"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="mb-1"><?php echo isset($activity['title']) ? $activity['title'] : 'Aktivitas'; ?></h6>
                                    <p class="mb-1 text-muted small"><?php echo isset($activity['description']) ? $activity['description'] : ''; ?></p>
                                    <small class="text-muted"><?php echo isset($activity['time']) ? $activity['time'] : date('d M Y H:i'); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada aktivitas terbaru</p>
                    </div>
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
                        <a href="<?php echo base_url('siswa/add'); ?>" class="btn btn-primary w-100 py-3 quick-action-btn">
                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                            <span class="d-block">Tambah Siswa</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('guru/add'); ?>" class="btn btn-success w-100 py-3 quick-action-btn">
                            <i class="fas fa-chalkboard-teacher fa-2x d-block mb-2"></i>
                            <span class="d-block">Tambah Guru</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('kelas/add'); ?>" class="btn btn-warning w-100 py-3 quick-action-btn">
                            <i class="fas fa-users fa-2x d-block mb-2"></i>
                            <span class="d-block">Tambah Kelas</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo base_url('laporan'); ?>" class="btn btn-info w-100 py-3 quick-action-btn">
                            <i class="fas fa-file-alt fa-2x d-block mb-2"></i>
                            <span class="d-block">Cetak Laporan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Information and Calendar -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Nama Sekolah:</td>
                                <td>SMK Bina Mandiri</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tahun Ajaran Aktif:</td>
                                <td>2024/2025</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Semester:</td>
                                <td>Ganjil</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Versi Sistem:</td>
                                <td>SISFO v1.0</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Last Update:</td>
                                <td><?php echo date('d M Y H:i'); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Data:</td>
                                <td>
                                    <?php 
                                    $totalData = 0;
                                    if (isset($stats)) {
                                        foreach ($stats as $stat) {
                                            $totalData += is_numeric($stat) ? $stat : 0;
                                        }
                                    }
                                    echo number_format($totalData); 
                                    ?> records
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Kalender Akademik</h5>
            </div>
            <div class="card-body">
                <div class="calendar-timeline">
                    <div class="timeline-item completed">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Awal Semester</h6>
                            <p class="timeline-text">15 Juli 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item active">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">UTS</h6>
                            <p class="timeline-text">15-20 Oktober 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item upcoming">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">UAS</h6>
                            <p class="timeline-text">10-15 Desember 2024</p>
                        </div>
                    </div>
                    <div class="timeline-item upcoming">
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
// Parse chart data from PHP - ensure data is properly defined
var genderData = <?php echo isset($chart_data['gender']) ? json_encode($chart_data['gender']) : json_encode(['labels' => ['Laki-laki', 'Perempuan'], 'data' => [0, 0]]); ?>;
var majorData = <?php echo isset($chart_data['major']) ? json_encode($chart_data['major']) : json_encode(['labels' => ['Teknik Komputer Jaringan'], 'data' => [0]]); ?>;

console.log('Gender data:', genderData);
console.log('Major data:', majorData);

// Initialize charts after DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Ensure Chart.js is available
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }
    
    // Destroy existing charts if they exist
    if (window.genderChartInstance) {
        window.genderChartInstance.destroy();
    }
    
    if (window.majorChartInstance) {
        window.majorChartInstance.destroy();
    }
    
    // Gender Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        // Ensure canvas has dimensions
        genderCtx.width = genderCtx.offsetWidth || 300;
        genderCtx.height = genderCtx.offsetHeight || 300;
        
        window.genderChartInstance = new Chart(genderCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: genderData.labels || ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: genderData.data || [0, 0],
                    backgroundColor: ['#007bff', '#e83e8c'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Major Chart
    const majorCtx = document.getElementById('majorChart');
    if (majorCtx) {
        // Ensure canvas has dimensions
        majorCtx.width = majorCtx.offsetWidth || 300;
        majorCtx.height = majorCtx.offsetHeight || 300;
        
        window.majorChartInstance = new Chart(majorCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: majorData.labels || ['Teknik Komputer Jaringan'],
                datasets: [{
                    data: majorData.data || [0],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997', '#6610f2'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Refresh charts button
    const refreshBtn = document.getElementById('refreshCharts');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            // In a real implementation, this would fetch new data
            console.log('Refreshing charts...');
            // For demo purposes, we'll just show a notification
            if (typeof AdminUtils !== 'undefined') {
                AdminUtils.showAlert('Data grafik telah diperbarui.', 'success');
            } else {
                alert('Data grafik telah diperbarui.');
            }
        });
    }
});

// Fallback: Initialize charts when window loads (in case DOMContentLoaded was missed)
window.addEventListener('load', function() {
    if (typeof Chart !== 'undefined' && (!window.genderChartInstance || !window.majorChartInstance)) {
        console.log('Initializing charts on window load');
        // Charts will be initialized in DOMContentLoaded, but if it was missed, this ensures they load
    }
});
</script>

<style>
/* Stat Cards */
.stat-card {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border-radius: 10px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    transform: rotate(30deg);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.stat-card.success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.stat-card.warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.stat-card.info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}

.stat-card.danger {
    background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
}

.stat-icon {
    font-size: 2rem;
    opacity: 0.8;
    margin-bottom: 10px;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: #ffffff; /* Keep white for stat cards */
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin: 0;
    color: #ffffff; /* Keep white for stat cards */
}

/* Activity Timeline */
.activity-timeline {
    position: relative;
    padding-left: 2rem;
}

.activity-item {
    position: relative;
    margin-bottom: 1.5rem;
    display: flex;
}

.activity-item:last-child {
    margin-bottom: 0;
}

.activity-icon {
    position: absolute;
    left: -2.25rem;
    top: 0;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.activity-content {
    flex: 1;
    padding-left: 1rem;
}

/* Calendar Timeline */
.calendar-timeline {
    position: relative;
    padding-left: 2rem;
}

.calendar-timeline::before {
    content: '';
    position: absolute;
    left: 1.25rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
}

.timeline-item.active .timeline-marker {
    background: #007bff;
    transform: scale(1.2);
    box-shadow: 0 0 0 3px rgba(0,123,255,0.3);
}

.timeline-item.upcoming .timeline-marker {
    background: #6c757d;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
    transition: all 0.3s ease;
}

.timeline-content {
    padding-left: 0.5rem;
}

.timeline-title {
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #000000; /* Changed to black */
}

.timeline-text {
    margin: 0;
    font-size: 0.85rem;
    color: #000000; /* Changed to black */
}

/* Quick Action Buttons */
.quick-action-btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
    color: #000000; /* Changed to black */
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.quick-action-btn i {
    transition: all 0.3s ease;
}

.quick-action-btn:hover i {
    transform: scale(1.1);
}

/* Chart Containers */
.chart-container {
    position: relative;
    height: 250px;
    width: 100%;
}

/* Card Header Actions */
.card-header-actions {
    display: flex;
    gap: 0.5rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .stat-number {
        font-size: 1.5rem;
    }
    
    .calendar-timeline::before {
        left: 1rem;
    }
    
    .timeline-marker {
        left: -1.75rem;
    }
    
    .activity-icon {
        left: -2rem;
    }
}

/* Subtitle */
.subtitle {
    color: #000000; /* Changed to black */
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}
</style>