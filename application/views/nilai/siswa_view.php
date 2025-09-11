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
                                    <i class="fas fa-chart-line"></i> Nilai Akademik Saya
                                </h3>
                                <?php if (isset($student_info)): ?>
                                    <p class="mb-0 mt-2">
                                        <strong>Siswa:</strong> <?php echo $student_info->nama_siswa; ?> | 
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <?php 
            $total_subjects = !empty($grades) ? count($grades) : 0;
            $total_score = 0;
            $passed_subjects = 0;
            $failed_subjects = 0;
            $excellent_subjects = 0;
            
            if (!empty($grades)) {
                foreach ($grades as $grade) {
                    if ($grade->rata_rata) {
                        $total_score += $grade->rata_rata;
                        if ($grade->rata_rata >= 70) $passed_subjects++;
                        else $failed_subjects++;
                        if ($grade->rata_rata >= 90) $excellent_subjects++;
                    }
                }
            }
            
            $average_score = $total_subjects > 0 ? round($total_score / $total_subjects, 1) : 0;
            ?>
            
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo $total_subjects; ?></h3>
                                <p class="mb-0">Total Mata Pelajaran</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
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
                                <h3><?php echo $passed_subjects; ?></h3>
                                <p class="mb-0">Mata Pelajaran Lulus</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
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
                                <h3><?php echo $average_score; ?></h3>
                                <p class="mb-0">Rata-rata Nilai</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calculator fa-2x"></i>
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
                                <h3><?php echo $excellent_subjects; ?></h3>
                                <p class="mb-0">Nilai Sangat Baik (≥90)</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-alt"></i> Detail Nilai Mata Pelajaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($grades)): ?>
                            <div class="table-responsive">
                                <table id="gradesTable" class="table table-striped table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" width="50px">No</th>
                                            <th>Mata Pelajaran</th>
                                            <th class="text-center" width="70px">Tugas</th>
                                            <th class="text-center" width="70px">UH</th>
                                            <th class="text-center" width="70px">UTS</th>
                                            <th class="text-center" width="70px">UAS</th>
                                            <th class="text-center" width="70px">Praktek</th>
                                            <th class="text-center" width="80px">Rata-rata</th>
                                            <th class="text-center" width="80px">Grade</th>
                                            <th>Guru Pengajar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($grades as $grade) {
                                            $rata_rata = $grade->rata_rata ? round($grade->rata_rata, 1) : 0;
                                            
                                            // Determine grade and status
                                            if ($rata_rata >= 90) {
                                                $grade_letter = 'A';
                                                $grade_class = 'badge-success';
                                                $keterangan = '<span class="badge badge-success">Sangat Baik</span>';
                                            } elseif ($rata_rata >= 80) {
                                                $grade_letter = 'B';
                                                $grade_class = 'badge-info';
                                                $keterangan = '<span class="badge badge-info">Baik</span>';
                                            } elseif ($rata_rata >= 70) {
                                                $grade_letter = 'C';
                                                $grade_class = 'badge-warning';
                                                $keterangan = '<span class="badge badge-warning">Cukup</span>';
                                            } elseif ($rata_rata >= 60) {
                                                $grade_letter = 'D';
                                                $grade_class = 'badge-orange';
                                                $keterangan = '<span class="badge badge-orange">Kurang</span>';
                                            } else {
                                                $grade_letter = 'E';
                                                $grade_class = 'badge-danger';
                                                $keterangan = '<span class="badge badge-danger">Sangat Kurang</span>';
                                            }
                                            
                                            echo "<tr>
                                                    <td class='text-center'>$no</td>
                                                    <td>
                                                        <strong>$grade->nama_mapel</strong><br>
                                                        <small class='text-muted'>$grade->kode_mapel</small>
                                                    </td>
                                                    <td class='text-center'>" . 
                                                        ($grade->nilai_tugas ? "<span class='badge badge-secondary'>$grade->nilai_tugas</span>" : "<span class='text-muted'>-</span>") . 
                                                    "</td>
                                                    <td class='text-center'>" . 
                                                        ($grade->nilai_uh ? "<span class='badge badge-secondary'>$grade->nilai_uh</span>" : "<span class='text-muted'>-</span>") . 
                                                    "</td>
                                                    <td class='text-center'>" . 
                                                        ($grade->nilai_uts ? "<span class='badge badge-secondary'>$grade->nilai_uts</span>" : "<span class='text-muted'>-</span>") . 
                                                    "</td>
                                                    <td class='text-center'>" . 
                                                        ($grade->nilai_uas ? "<span class='badge badge-secondary'>$grade->nilai_uas</span>" : "<span class='text-muted'>-</span>") . 
                                                    "</td>
                                                    <td class='text-center'>" . 
                                                        ($grade->nilai_praktek ? "<span class='badge badge-secondary'>$grade->nilai_praktek</span>" : "<span class='text-muted'>-</span>") . 
                                                    "</td>
                                                    <td class='text-center'><span class='badge badge-primary'>$rata_rata</span></td>
                                                    <td class='text-center'><span class='badge $grade_class'>$grade_letter</span></td>
                                                    <td>" . ($grade->nama_guru ? $grade->nama_guru : 'Belum ditentukan') . "</td>
                                                 </tr>";
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-file-alt fa-4x mb-3"></i>
                                <h5>Belum Ada Data Nilai</h5>
                                <p>Nilai mata pelajaran belum diinput oleh guru. Silakan hubungi guru mata pelajaran untuk informasi lebih lanjut.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Summary -->
        <?php if (!empty($grades)): ?>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie"></i> Ringkasan Performa
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-success"><?php echo $passed_subjects; ?></h4>
                                <p class="mb-0">Lulus</p>
                            </div>
                            <div class="col-6">
                                <h4 class="text-danger"><?php echo $failed_subjects; ?></h4>
                                <p class="mb-0">Belum Lulus</p>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h3 class="<?php echo $average_score >= 70 ? 'text-success' : 'text-danger'; ?>">
                                <?php echo $average_score; ?>
                            </h3>
                            <p class="mb-0">Rata-rata Keseluruhan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-trophy"></i> Pencapaian
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($average_score >= 90): ?>
                            <div class="text-center text-success">
                                <i class="fas fa-trophy fa-3x mb-2"></i>
                                <h5>Prestasi Luar Biasa!</h5>
                                <p>Pertahankan performa yang sangat baik ini.</p>
                            </div>
                        <?php elseif ($average_score >= 80): ?>
                            <div class="text-center text-info">
                                <i class="fas fa-medal fa-3x mb-2"></i>
                                <h5>Performa Baik</h5>
                                <p>Tingkatkan sedikit lagi untuk mencapai prestasi terbaik.</p>
                            </div>
                        <?php elseif ($average_score >= 70): ?>
                            <div class="text-center text-warning">
                                <i class="fas fa-thumbs-up fa-3x mb-2"></i>
                                <h5>Performa Cukup</h5>
                                <p>Terus belajar untuk meningkatkan nilai.</p>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle fa-3x mb-2"></i>
                                <h5>Perlu Peningkatan</h5>
                                <p>Konsultasikan dengan guru untuk strategi belajar yang lebih baik.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

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
                                <a href="<?php echo site_url('jadwal'); ?>" class="btn btn-outline-success btn-lg w-100">
                                    <i class="fas fa-calendar fa-2x mb-2"></i><br>
                                    <span>Jadwal Pelajaran</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="javascript:window.print();" class="btn btn-outline-info btn-lg w-100">
                                    <i class="fas fa-print fa-2x mb-2"></i><br>
                                    <span>Cetak Nilai</span>
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
.badge-orange {
    background-color: #fd7e14 !important;
    color: white;
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
.badge-success {
    background-color: #28a745 !important;
    color: white;
}
.badge-info {
    background-color: #17a2b8 !important;
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
    .btn, .card-header {
        display: none !important;
    }
    
    .card {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }
    
    .table {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable if grades exist
    <?php if (!empty($grades)): ?>
    $('#gradesTable').DataTable({
        "order": [[ 1, "asc" ]],
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        },
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    <?php endif; ?>
    
    // Add smooth animations
    $('.card').hide().fadeIn(800);
});
</script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>