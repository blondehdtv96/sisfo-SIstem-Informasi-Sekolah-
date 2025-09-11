<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-chalkboard-teacher"></i> Manajemen Guru Mata Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Guru Mata Pelajaran</li>
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
                        <h3><?php echo isset($stats['total_assignments']) ? $stats['total_assignments'] : 0; ?></h3>
                        <p>Total Assignment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo isset($stats['teachers_with_assignments']) ? $stats['teachers_with_assignments'] : 0; ?></h3>
                        <p>Guru dengan Assignment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo isset($stats['subjects_with_assignments']) ? $stats['subjects_with_assignments'] : 0; ?></h3>
                        <p>Mata Pelajaran Terassign</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo isset($stats['teachers_without_assignments']) ? $stats['teachers_without_assignments'] : 0; ?></h3>
                        <p>Guru Tanpa Assignment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-times"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Daftar Assignment Guru Mata Pelajaran
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Action Buttons -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <a href="<?php echo base_url('guru_mapel/add'); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Assignment
                        </a>
                        <a href="<?php echo base_url('guru_mapel/workload_report'); ?>" class="btn btn-info">
                            <i class="fas fa-chart-bar"></i> Laporan Beban Kerja
                        </a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#copyAssignmentsModal">
                            <i class="fas fa-copy"></i> Salin dari Tahun Sebelumnya
                        </button>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" id="searchTable" class="form-control" placeholder="Cari guru atau mata pelajaran...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table id="assignmentTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50px">No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>Mata Pelajaran</th>
                                <th>Kode Mapel</th>
                                <th>Kategori</th>
                                <th>Tahun Akademik</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($assignments)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($assignments as $assignment): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td>
                                            <strong><?php echo $assignment->nama_guru; ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-id-badge"></i> 
                                                <?php echo ucfirst($assignment->status_kepegawaian); ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $assignment->nip ?: '<span class="text-muted">-</span>'; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $assignment->nama_mapel; ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary"><?php echo $assignment->kode_mapel; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                            $kategori_class = '';
                                            switch($assignment->kategori) {
                                                case 'umum': $kategori_class = 'badge-info'; break;
                                                case 'kejuruan': $kategori_class = 'badge-success'; break;
                                                case 'muatan_lokal': $kategori_class = 'badge-warning'; break;
                                                default: $kategori_class = 'badge-secondary';
                                            }
                                            ?>
                                            <span class="badge <?php echo $kategori_class; ?>">
                                                <?php echo ucwords(str_replace('_', ' ', $assignment->kategori)); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-dark"><?php echo $assignment->tahun_ajar; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url('guru_mapel/detail/' . $assignment->id_guru_mapel); ?>" 
                                               class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo base_url('guru_mapel/edit/' . $assignment->id_guru_mapel); ?>" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="deleteAssignment(<?php echo $assignment->id_guru_mapel; ?>)" 
                                                    class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada assignment guru mata pelajaran</h5>
                                            <p class="text-muted">Klik tombol "Tambah Assignment" untuk mulai menambahkan assignment.</p>
                                            <a href="<?php echo base_url('guru_mapel/add'); ?>" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Assignment
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Teacher Workload Summary -->
        <?php if (!empty($teacher_workload)): ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Ringkasan Beban Kerja Guru
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach (array_slice($teacher_workload, 0, 6) as $workload): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-user-tie"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $workload->nama_guru; ?></span>
                                    <span class="info-box-number">
                                        <?php echo $workload->jumlah_mapel; ?> Mata Pelajaran
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php echo min(($workload->jumlah_mapel / 10) * 100, 100); ?>%"></div>
                                    </div>
                                    <span class="progress-description">
                                        Status: <?php echo ucfirst($workload->status_kepegawaian); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (count($teacher_workload) > 6): ?>
                    <div class="text-center">
                        <a href="<?php echo base_url('guru_mapel/workload_report'); ?>" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Lihat Laporan Lengkap
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Copy Assignments Modal -->
<div class="modal fade" id="copyAssignmentsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-copy"></i> Salin Assignment dari Tahun Sebelumnya
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('guru_mapel/copy_assignments'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tahun Akademik Asal:</label>
                        <select name="from_year_id" class="form-control" required>
                            <option value="">-- Pilih Tahun Akademik Asal --</option>
                            <?php 
                            $years = $this->db->order_by('tahun_ajar', 'DESC')->get('tb_tahun_akademik')->result();
                            foreach($years as $year): 
                            ?>
                                <option value="<?php echo $year->id_tahun_akademik; ?>">
                                    <?php echo $year->tahun_ajar; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Akademik Tujuan:</label>
                        <select name="to_year_id" class="form-control" required>
                            <option value="">-- Pilih Tahun Akademik Tujuan --</option>
                            <?php foreach($years as $year): ?>
                                <option value="<?php echo $year->id_tahun_akademik; ?>">
                                    <?php echo $year->tahun_ajar; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Fitur ini akan menyalin semua assignment dari tahun akademik asal ke tahun akademik tujuan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-copy"></i> Salin Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#assignmentTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        pageLength: 25,
        order: [[1, 'asc']], // Sort by teacher name
        columnDefs: [
            { orderable: false, targets: [7] }, // Disable sorting for action column
            { className: 'text-center', targets: [0, 2, 4, 5, 6, 7] }
        ]
    });

    // Search functionality
    $('#searchTable').on('keyup', function() {
        $('#assignmentTable').DataTable().search(this.value).draw();
    });
});

function deleteAssignment(id) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus assignment ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("guru_mapel/delete/"); ?>' + id,
                type: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus assignment', 'error');
                }
            });
        }
    });
}
</script>

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

.empty-state {
    padding: 2rem;
}

.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: .25rem;
    background: #fff;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
    width: 100%;
}

.info-box .info-box-icon {
    border-radius: .25rem;
    align-items: center;
    display: flex;
    font-size: 1.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
}

.info-box .info-box-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.8;
    margin-left: 10px;
    padding: 0 10px;
}

.progress {
    background-color: #f4f4f4;
    height: 4px;
    margin: 5px 0;
    border-radius: 2px;
}

.progress .progress-bar {
    background-color: #17a2b8;
    border-radius: 2px;
}

/* Table font color changes to black */
#assignmentTable tbody td {
    color: #000000 !important;
}

#assignmentTable tbody td strong {
    color: #000000 !important;
}

#assignmentTable tbody td small {
    color: #000000 !important;
}

#assignmentTable tbody td .text-muted {
    color: #000000 !important;
}

#assignmentTable tbody td span {
    color: #000000 !important;
}

@media (max-width: 768px) {
    .small-box .icon {
        font-size: 60px;
    }
    
    .card-tools {
        margin-top: 0.5rem;
    }
}
</style>