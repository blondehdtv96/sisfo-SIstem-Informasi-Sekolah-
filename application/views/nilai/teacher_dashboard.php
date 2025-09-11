<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit"></i> Input Nilai Siswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Input Nilai</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo isset($stats['total_grades']) ? $stats['total_grades'] : 0; ?></h3>
                        <p>Total Nilai Diinput</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo isset($stats['students_graded']) ? $stats['students_graded'] : 0; ?></h3>
                        <p>Siswa Sudah Dinilai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo isset($stats['average_grade']) ? $stats['average_grade'] : 0; ?></h3>
                        <p>Rata-rata Nilai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo count($subjects); ?></h3>
                        <p>Mata Pelajaran Diampu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Mata Pelajaran yang Diampu
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($subjects)): ?>
                    <div class="row">
                        <?php foreach ($subjects as $subject): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <strong><?php echo $subject->nama_mapel; ?></strong>
                                        </h5>
                                        <p class="card-text">
                                            <span class="badge badge-primary"><?php echo $subject->kode_mapel; ?></span>
                                            <br>
                                            <small class="text-muted">
                                                Kategori: <?php echo ucfirst(str_replace('_', ' ', $subject->kategori)); ?>
                                            </small>
                                        </p>
                                        <a href="<?php echo base_url('nilai/subject_classes/' . $subject->id_mapel); ?>" 
                                           class="btn btn-primary btn-sm" 
                                           title="Klik untuk memilih kelas dan input nilai">
                                            <i class="fas fa-edit"></i> Input Nilai
                                        </a>
                                        <br><br>
                                        <small class="text-info">
                                            <i class="fas fa-info-circle"></i> 
                                            ID Mapel: <?php echo $subject->id_mapel; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Mata Pelajaran</h5>
                        <p class="text-muted">
                            Anda belum ditugaskan untuk mengajar mata pelajaran apapun.<br>
                            Hubungi administrator untuk assignment mata pelajaran.
                        </p>
                        <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informasi Input Nilai
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Kategori Nilai:</strong></h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-circle text-primary"></i> <strong>Tugas:</strong> Tugas harian, PR, dll</li>
                            <li><i class="fas fa-circle text-success"></i> <strong>Ulangan Harian:</strong> Quiz, kuis mingguan</li>
                            <li><i class="fas fa-circle text-warning"></i> <strong>UTS:</strong> Ujian Tengah Semester</li>
                            <li><i class="fas fa-circle text-danger"></i> <strong>UAS:</strong> Ujian Akhir Semester</li>
                            <li><i class="fas fa-circle text-info"></i> <strong>Praktek:</strong> Nilai praktikum</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Petunjuk:</strong></h6>
                        <ol>
                            <li>Pilih mata pelajaran yang ingin dinilai</li>
                            <li>Pilih kelas dari daftar kelas yang tersedia</li>
                            <li>Input nilai siswa berdasarkan kategori</li>
                            <li>Nilai dapat diubah kapan saja</li>
                            <li>Siswa dapat melihat nilai yang sudah diinput</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.small-box {
    border-radius: 0.25rem;
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

.card-outline {
    border-top: 3px solid #007bff;
}

@media (max-width: 768px) {
    .small-box .icon {
        font-size: 60px;
    }
}
</style>