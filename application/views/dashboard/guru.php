<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard Guru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Welcome Message -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5><i class="fas fa-user-tie"></i> Selamat Datang, <?php echo $this->session->userdata('nama_guru'); ?>!</h5>
                    <p class="mb-0">Berikut adalah ringkasan aktivitas mengajar Anda hari ini.</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo isset($stats['total_mapel_ajar']) ? $stats['total_mapel_ajar'] : 0; ?></h3>
                        <p>Mata Pelajaran</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="<?php echo base_url('guru_mapel'); ?>" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo isset($stats['total_kelas_ajar']) ? $stats['total_kelas_ajar'] : 0; ?></h3>
                        <p>Kelas Diajar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?php echo base_url('jadwal'); ?>" class="small-box-footer">
                        Lihat Jadwal <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo isset($stats['total_siswa_ajar']) ? $stats['total_siswa_ajar'] : 0; ?></h3>
                        <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="<?php echo base_url('siswa'); ?>" class="small-box-footer">
                        Lihat Siswa <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo isset($teaching_schedule) ? count($teaching_schedule) : 0; ?></h3>
                        <p>Jadwal Mengajar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <a href="<?php echo base_url('jadwal/my_schedule'); ?>" class="small-box-footer">
                        Lihat Jadwal <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Teaching Schedule -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check"></i> Jadwal Mengajar Minggu Ini
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($teaching_schedule)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($teaching_schedule as $schedule): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo $schedule->hari; ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?php echo substr($schedule->jam_mulai, 0, 5); ?> - <?php echo substr($schedule->jam_selesai, 0, 5); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $schedule->nama_mapel; ?></td>
                                                <td>
                                                    <span class="badge badge-primary"><?php echo $schedule->nama_kelas; ?></span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-muted"></i> <?php echo $schedule->nama_ruangan; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada jadwal mengajar</h5>
                                <p class="text-muted">Jadwal mengajar belum tersedia atau belum ditentukan.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('jadwal/my_schedule'); ?>" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-calendar"></i> Jadwal Saya
                            </a>
                            <a href="<?php echo base_url('nilai'); ?>" class="btn btn-outline-info btn-block">
                                <i class="fas fa-clipboard-list"></i> Input Nilai
                            </a>
                            <a href="<?php echo base_url('absensi'); ?>" class="btn btn-outline-warning btn-block">
                                <i class="fas fa-user-check"></i> Absensi Siswa
                            </a>
                            <a href="<?php echo base_url('profile'); ?>" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-user-cog"></i> Profile Saya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Teacher Info -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-tie"></i> Informasi Guru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <?php if ($this->session->userdata('foto') && file_exists('./assets/uploads/guru/' . $this->session->userdata('foto'))): ?>
                                <img src="<?php echo base_url('assets/uploads/guru/' . $this->session->userdata('foto')); ?>" 
                                     alt="Foto Guru" class="img-circle img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary d-inline-flex align-items-center justify-content-center text-white rounded-circle" 
                                     style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td><?php echo $this->session->userdata('nama_guru'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>NIP:</strong></td>
                                <td><?php echo $this->session->userdata('nip') ?: '-'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>NUPTK:</strong></td>
                                <td><?php echo $this->session->userdata('nuptk') ?: '-'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-success">
                                        <?php echo ucfirst($this->session->userdata('status_kepegawaian')); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> 
                                Login terakhir: <?php echo $this->session->userdata('last_login') ? date('d/m/Y H:i', strtotime($this->session->userdata('last_login'))) : 'Tidak ada data'; ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock"></i> Jadwal Hari Ini - <?php echo date('l, d F Y'); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $today = date('l');
                        $today_indonesian = [
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa', 
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu',
                            'Sunday' => 'Minggu'
                        ];
                        $today_schedule = [];
                        if (!empty($teaching_schedule)) {
                            foreach ($teaching_schedule as $schedule) {
                                if ($schedule->hari == $today_indonesian[$today]) {
                                    $today_schedule[] = $schedule;
                                }
                            }
                        }
                        ?>
                        
                        <?php if (!empty($today_schedule)): ?>
                            <div class="row">
                                <?php foreach ($today_schedule as $schedule): ?>
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <div class="card border-left-primary">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            <?php echo substr($schedule->jam_mulai, 0, 5); ?> - <?php echo substr($schedule->jam_selesai, 0, 5); ?>
                                                        </div>
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                            <?php echo $schedule->nama_mapel; ?>
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-users"></i> <?php echo $schedule->nama_kelas; ?> |
                                                            <i class="fas fa-map-marker-alt"></i> <?php echo $schedule->nama_ruangan; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada jadwal mengajar hari ini</h5>
                                <p class="text-muted">Anda tidak memiliki jadwal mengajar pada hari <?php echo $today_indonesian[$today]; ?>.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.small-box {
    border-radius: 0.35rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}

.small-box > .inner {
    padding: 10px;
}

.small-box .icon {
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}

.small-box:hover {
    text-decoration: none;
    color: #fff;
}

.small-box:hover .icon {
    font-size: 95px;
}

.small-box .small-box-footer {
    background-color: rgba(0,0,0,0.1);
    color: rgba(255,255,255,0.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}

.small-box .small-box-footer:hover {
    color: #fff;
    background-color: rgba(0,0,0,0.15);
}

.table th {
    border-top: none;
    font-weight: 600;
}

.img-circle {
    border-radius: 50%;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.badge {
    font-size: 0.75em;
}

@media (max-width: 768px) {
    .small-box .icon {
        font-size: 60px;
    }
    
    .small-box:hover .icon {
        font-size: 65px;
    }
}
</style>