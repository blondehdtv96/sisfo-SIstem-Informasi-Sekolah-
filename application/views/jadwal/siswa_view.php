<section class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-0">
                                    <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                                </h3>
                                <?php if (isset($student_info)): ?>
                                    <p class="mb-0 mt-2">
                                        <strong>Siswa:</strong> <?php echo $student_info->nama_siswa; ?> | 
                                        <strong>Kelas:</strong> <?php echo isset($student_info->nama_kelas) ? $student_info->nama_kelas : 'Belum Ada Kelas'; ?>
                                        <?php if (isset($student_info->nama_jurusan) && $student_info->nama_jurusan): ?>
                                            | <strong>Jurusan:</strong> <?php echo $student_info->nama_jurusan; ?>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-clock fa-3x" style="opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-day"></i> Jadwal Hari Ini - <?php echo date('l, d F Y'); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $today = date('l');
                        $day_translation = [
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu',
                            'Sunday' => 'Minggu'
                        ];
                        $today_indo = $day_translation[$today];
                        
                        $today_schedule = [];
                        if (!empty($schedule)) {
                            foreach ($schedule as $jadwal) {
                                if ($jadwal->hari == $today_indo) {
                                    $today_schedule[] = $jadwal;
                                }
                            }
                        }
                        ?>
                        
                        <?php if (!empty($today_schedule)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th class="text-center">Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($today_schedule as $jadwal): ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">
                                                        <?php echo isset($jadwal->jam_mulai) ? substr($jadwal->jam_mulai, 0, 5) : $jadwal->jam; ?> - 
                                                        <?php echo isset($jadwal->jam_selesai) ? substr($jadwal->jam_selesai, 0, 5) : ''; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?php echo $jadwal->nama_mapel; ?></strong>
                                                </td>
                                                <td>
                                                    <i class="fas fa-user-tie text-muted"></i> <?php echo $jadwal->nama_guru; ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-secondary"><?php echo $jadwal->nama_ruangan; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-calendar-times fa-4x mb-3"></i>
                                <h5>Tidak ada jadwal pelajaran hari ini</h5>
                                <p>Selamat menikmati hari libur! 😊</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Schedule -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-week"></i> Jadwal Mingguan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($schedule)): ?>
                            <?php
                            $grouped_schedule = [];
                            foreach ($schedule as $jadwal) {
                                $grouped_schedule[$jadwal->hari][] = $jadwal;
                            }
                            
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            $day_colors = [
                                'Senin' => 'primary',
                                'Selasa' => 'success', 
                                'Rabu' => 'info',
                                'Kamis' => 'warning',
                                'Jumat' => 'danger',
                                'Sabtu' => 'secondary'
                            ];
                            ?>
                            
                            <div class="row">
                                <?php foreach ($days as $day): ?>
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <div class="card h-100">
                                            <div class="card-header bg-<?php echo $day_colors[$day]; ?> text-white">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-calendar-day"></i> <?php echo $day; ?>
                                                    <?php if (isset($grouped_schedule[$day])): ?>
                                                        <span class="badge badge-light ml-2"><?php echo count($grouped_schedule[$day]); ?> pelajaran</span>
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <?php if (isset($grouped_schedule[$day])): ?>
                                                    <?php foreach ($grouped_schedule[$day] as $jadwal): ?>
                                                        <div class="border rounded p-3 mb-2 schedule-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-4">
                                                                    <span class="badge badge-primary p-2">
                                                                        <?php echo isset($jadwal->jam_mulai) ? substr($jadwal->jam_mulai, 0, 5) : $jadwal->jam; ?><br>
                                                                        <?php echo isset($jadwal->jam_selesai) ? substr($jadwal->jam_selesai, 0, 5) : ''; ?>
                                                                    </span>
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6 class="mb-1"><?php echo $jadwal->nama_mapel; ?></h6>
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-user-tie"></i> <?php echo $jadwal->nama_guru; ?><br>
                                                                        <i class="fas fa-door-open"></i> <?php echo $jadwal->nama_ruangan; ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="text-center text-muted py-3">
                                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                                        <p class="mb-0">Tidak ada jadwal</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-calendar-times fa-4x mb-3"></i>
                                <h5>Belum ada jadwal pelajaran</h5>
                                <p>Silakan hubungi admin untuk informasi jadwal.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-rocket"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-tachometer-alt fa-2x mb-2"></i><br>
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('nilai/siswa'); ?>" class="btn btn-outline-success btn-lg w-100">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                                    <span>Lihat Nilai</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="javascript:window.print();" class="btn btn-outline-info btn-lg w-100">
                                    <i class="fas fa-print fa-2x mb-2"></i><br>
                                    <span>Cetak Jadwal</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('profile'); ?>" class="btn btn-outline-warning btn-lg w-100">
                                    <i class="fas fa-user fa-2x mb-2"></i><br>
                                    <span>Profil Saya</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.schedule-item {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.schedule-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
}

.badge {
    font-size: 0.75em;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.card-header {
    border-top-left-radius: 8px !important;
    border-top-right-radius: 8px !important;
}

/* Bootstrap 4 compatibility */
.badge-primary {
    background-color: #007bff !important;
    color: white;
}
.badge-secondary {
    background-color: #6c757d !important;
    color: white;
}
.badge-light {
    background-color: #f8f9fa !important;
    color: #495057;
}

.bg-primary {
    background-color: #007bff !important;
}
.bg-success {
    background-color: #28a745 !important;
}
.bg-info {
    background-color: #17a2b8 !important;
}
.bg-warning {
    background-color: #ffc107 !important;
}
.bg-danger {
    background-color: #dc3545 !important;
}
.bg-secondary {
    background-color: #6c757d !important;
}

@media print {
    .card-header, .btn, .schedule-item:hover {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    
    .btn {
        display: none;
    }
    
    .card {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Add smooth animations
    $('.card').hide().fadeIn(800);
    
    // Highlight current day
    var today = '<?php echo $today_indo ?? ""; ?>';
    $('.card-header:contains("' + today + '")').addClass('bg-warning').removeClass('bg-primary bg-success bg-info bg-danger bg-secondary');
    
    // Add click animations for schedule items
    $('.schedule-item').on('click', function() {
        $(this).addClass('border-primary').delay(200).queue(function() {
            $(this).removeClass('border-primary').dequeue();
        });
    });
});
</script>