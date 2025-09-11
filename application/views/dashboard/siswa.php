<section class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-0">
                                    <i class="fas fa-user-graduate"></i> 
                                    Selamat Datang, <?php echo isset($student_info) ? $student_info->nama_siswa : 'Siswa'; ?>!
                                </h3>
                                <?php if (isset($student_info)): ?>
                                    <p class="mb-0 mt-2">
                                        <strong>NISN:</strong> <?php echo $student_info->nisn; ?> | 
                                        <strong>Kelas:</strong> <?php echo isset($student_info->nama_kelas) ? $student_info->nama_kelas : 'Belum Ada Kelas'; ?>
                                        <?php if (isset($student_info->nama_jurusan) && $student_info->nama_jurusan): ?>
                                            | <strong>Jurusan:</strong> <?php echo $student_info->nama_jurusan; ?>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-graduation-cap fa-3x" style="opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo isset($student_info) && isset($student_info->nama_kelas) && $student_info->nama_kelas ? '1' : '0'; ?></h3>
                                <p class="mb-0">Kelas Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-school fa-2x"></i>
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
                                <h3><?php echo count($grades ?? []); ?></h3>
                                <p class="mb-0">Mata Pelajaran</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
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
                                <h3><?php echo count($schedule ?? []); ?></h3>
                                <p class="mb-0">Jadwal Pelajaran</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>
                                    <?php
                                    $avg_grade = 0;
                                    if (!empty($grades)) {
                                        $total = 0;
                                        $count = 0;
                                        foreach ($grades as $grade) {
                                            if (isset($grade->nilai_akhir) && $grade->nilai_akhir > 0) {
                                                $total += $grade->nilai_akhir;
                                                $count++;
                                            }
                                        }
                                        $avg_grade = $count > 0 ? round($total / $count, 1) : 0;
                                    }
                                    echo $avg_grade;
                                    ?>
                                </h3>
                                <p class="mb-0">Rata-rata Nilai</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-id-card"></i> Profil Siswa
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($student_info)): ?>
                            <div class="text-center mb-3">
                                <?php if ($student_info->foto && file_exists('./assets/uploads/siswa/' . $student_info->foto)): ?>
                                    <img src="<?php echo base_url('assets/uploads/siswa/' . $student_info->foto); ?>" 
                                         alt="Foto <?php echo $student_info->nama_siswa; ?>" 
                                         class="img-fluid rounded-circle shadow" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center shadow" 
                                         style="width: 100px; height: 100px;">
                                        <i class="fas fa-user text-white fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <dl class="row">
                                <dt class="col-sm-5">Nama:</dt>
                                <dd class="col-sm-7"><?php echo $student_info->nama_siswa; ?></dd>
                                
                                <dt class="col-sm-5">NISN:</dt>
                                <dd class="col-sm-7"><?php echo $student_info->nisn; ?></dd>
                                
                                <?php if ($student_info->nis): ?>
                                    <dt class="col-sm-5">NIS:</dt>
                                    <dd class="col-sm-7"><?php echo $student_info->nis; ?></dd>
                                <?php endif; ?>
                                
                                <dt class="col-sm-5">Kelas:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge badge-info"><?php echo isset($student_info->nama_kelas) ? $student_info->nama_kelas : 'Belum Ada Kelas'; ?></span>
                                </dd>
                                
                                <?php if (isset($student_info->nama_jurusan) && $student_info->nama_jurusan): ?>
                                    <dt class="col-sm-5">Jurusan:</dt>
                                    <dd class="col-sm-7"><?php echo $student_info->nama_jurusan; ?></dd>
                                <?php endif; ?>
                                
                                <dt class="col-sm-5">Status:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge badge-success"><?php echo ucfirst($student_info->status); ?></span>
                                </dd>
                            </dl>
                            
                            <div class="text-center mt-3">
                                <a href="<?php echo site_url('siswa/detail/' . $student_info->id_siswa); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Detail Profil
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted">
                                <i class="fas fa-user-slash fa-3x mb-3"></i>
                                <p>Data profil tidak ditemukan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-day"></i> Jadwal Hari Ini (<?php echo date('l, d F Y'); ?>)
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
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($today_schedule as $jadwal): ?>
                                            <tr>
                                                <td>
                                                    <small class="text-primary">
                                                        <?php echo substr($jadwal->jam_mulai, 0, 5); ?> - 
                                                        <?php echo substr($jadwal->jam_selesai, 0, 5); ?>
                                                    </small>
                                                </td>
                                                <td><strong><?php echo $jadwal->nama_mapel; ?></strong></td>
                                                <td><?php echo $jadwal->nama_guru; ?></td>
                                                <td>
                                                    <span class="badge badge-secondary"><?php echo $jadwal->nama_ruangan; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                <p>Tidak ada jadwal pelajaran hari ini</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Grades -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar"></i> Nilai Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($grades)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $displayed_count = 0;
                                        foreach ($grades as $grade): 
                                            if ($displayed_count >= 5) break; // Show only first 5
                                            $displayed_count++;
                                        ?>
                                            <tr>
                                                <td><?php echo $grade->nama_mapel; ?></td>
                                                <td class="text-center">
                                                    <?php if (isset($grade->nilai_akhir) && $grade->nilai_akhir > 0): ?>
                                                        <strong><?php echo $grade->nilai_akhir; ?></strong>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                    if (isset($grade->nilai_akhir) && $grade->nilai_akhir > 0) {
                                                        $nilai = $grade->nilai_akhir;
                                                        if ($nilai >= 90) {
                                                            echo '<span class="badge badge-success">A</span>';
                                                        } elseif ($nilai >= 80) {
                                                            echo '<span class="badge badge-info">B</span>';
                                                        } elseif ($nilai >= 70) {
                                                            echo '<span class="badge badge-warning">C</span>';
                                                        } elseif ($nilai >= 60) {
                                                            echo '<span class="badge badge-orange">D</span>';
                                                        } else {
                                                            echo '<span class="badge badge-danger">E</span>';
                                                        }
                                                    } else {
                                                        echo '<span class="text-muted">-</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if (count($grades) > 5): ?>
                                <div class="text-center mt-2">
                                    <small class="text-muted">Dan <?php echo count($grades) - 5; ?> mata pelajaran lainnya...</small>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-file-alt fa-3x mb-3"></i>
                                <p>Belum ada data nilai</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-week"></i> Jadwal Minggu Ini
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
                            ?>
                            
                            <div class="accordion" id="scheduleAccordion">
                                <?php foreach ($days as $index => $day): ?>
                                    <?php if (isset($grouped_schedule[$day])): ?>
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo $index; ?>">
                                                <h6 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" 
                                                        data-toggle="collapse" 
                                                        data-target="#collapse<?php echo $index; ?>"
                                                        aria-expanded="false" 
                                                        aria-controls="collapse<?php echo $index; ?>">
                                                        <?php echo $day; ?> 
                                                        <span class="badge badge-primary ml-2"><?php echo count($grouped_schedule[$day]); ?> mata pelajaran</span>
                                                    </button>
                                                </h6>
                                            </div>
                                            <div id="collapse<?php echo $index; ?>" 
                                                 class="collapse" 
                                                 aria-labelledby="heading<?php echo $index; ?>"
                                                 data-parent="#scheduleAccordion">
                                                <div class="card-body">
                                                    <?php foreach ($grouped_schedule[$day] as $jadwal): ?>
                                                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                            <div>
                                                                <strong><?php echo $jadwal->nama_mapel; ?></strong><br>
                                                                <small class="text-muted">
                                                                    <?php echo $jadwal->nama_guru; ?> | <?php echo $jadwal->nama_ruangan; ?>
                                                                </small>
                                                            </div>
                                                            <span class="badge badge-secondary">
                                                                <?php echo substr($jadwal->jam_mulai, 0, 5); ?> - 
                                                                <?php echo substr($jadwal->jam_selesai, 0, 5); ?>
                                                            </span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                <p>Belum ada jadwal pelajaran</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
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
                                <a href="<?php echo site_url('siswa/profile'); ?>" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-user fa-2x mb-2"></i><br>
                                    <span>Profil Saya</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('nilai'); ?>" class="btn btn-outline-success btn-lg w-100">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                                    <span>Lihat Nilai</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('jadwal'); ?>" class="btn btn-outline-info btn-lg w-100">
                                    <i class="fas fa-calendar fa-2x mb-2"></i><br>
                                    <span>Jadwal Lengkap</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo site_url('siswa/change_password'); ?>" class="btn btn-outline-warning btn-lg w-100">
                                    <i class="fas fa-key fa-2x mb-2"></i><br>
                                    <span>Ubah Password</span>
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
.bg-orange {
    background-color: #fd7e14 !important;
}
.badge-orange {
    background-color: #fd7e14 !important;
    color: white;
}
.opacity-50 {
    opacity: 0.5;
}
/* Bootstrap 4 compatibility */
.badge-info {
    background-color: #17a2b8 !important;
    color: white;
}
.badge-success {
    background-color: #28a745 !important;
    color: white;
}
.badge-warning {
    background-color: #ffc107 !important;
    color: #212529;
}
.badge-danger {
    background-color: #dc3545 !important;
    color: white;
}
.badge-secondary {
    background-color: #6c757d !important;
    color: white;
}
.badge-primary {
    background-color: #007bff !important;
    color: white;
}
</style>