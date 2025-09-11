<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-chalkboard-teacher"></i> Data Guru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Guru</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Guru</span>
                        <span class="info-box-number"><?php echo $total_guru; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aktif</span>
                        <span class="info-box-number"><?php echo $total_aktif; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-certificate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">PNS</span>
                        <span class="info-box-number"><?php echo $total_pns; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">GTT</span>
                        <span class="info-box-number"><?php echo $total_gtt; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Daftar Guru
                </h3>
                <div class="card-tools">
                    <?php if ($this->session->userdata('id_level_user') == 1): ?>
                        <a href="<?php echo base_url('guru/add'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Guru
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="guruTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th>NIP/NUPTK</th>
                                <th>Nama Guru</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>Status Kepegawaian</th>
                                <th>Status</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($guru as $g): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <?php if (!empty($g->nip)): ?>
                                        <span class="badge badge-primary">NIP: <?php echo $g->nip; ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($g->nuptk)): ?>
                                        <span class="badge badge-info">NUPTK: <?php echo $g->nuptk; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($g->foto && file_exists('./assets/uploads/guru/' . $g->foto)): ?>
                                            <img src="<?php echo base_url('assets/uploads/guru/' . $g->foto); ?>" 
                                                 alt="<?php echo $g->nama_guru; ?>" 
                                                 class="img-circle me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?php echo $g->nama_guru; ?></strong>
                                            <?php if (!empty($g->email)): ?>
                                                <br><small class="text-muted">
                                                    <i class="fas fa-envelope"></i> <?php echo $g->email; ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if ($g->jenis_kelamin == 'L'): ?>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-mars"></i> Laki-laki
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-pink">
                                            <i class="fas fa-venus"></i> Perempuan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $g->jabatan ?? '-'; ?></td>
                                <td class="text-center">
                                    <?php 
                                    $kepegawaian_colors = [
                                        'PNS' => 'success',
                                        'GTT' => 'warning',
                                        'GTY' => 'info',
                                        'Honorer' => 'secondary'
                                    ];
                                    $color = $kepegawaian_colors[$g->status_kepegawaian] ?? 'secondary';
                                    ?>
                                    <span class="badge badge-<?php echo $color; ?>">
                                        <?php echo $g->status_kepegawaian; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($g->status == 'aktif'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times"></i> Non-Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo base_url('guru/detail/' . $g->id_guru); ?>" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                            <a href="<?php echo base_url('guru/edit/' . $g->id_guru); ?>" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Hapus"
                                                    onclick="deleteGuru(<?php echo $g->id_guru; ?>, '<?php echo $g->nama_guru; ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-secondary btn-sm" 
                                                    title="Reset Password"
                                                    onclick="resetPassword(<?php echo $g->id_guru; ?>, '<?php echo $g->nama_guru; ?>')">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.info-box {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.info-box-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 24px;
    color: white;
}

.info-box-content {
    flex: 1;
    margin-left: 15px;
}

.info-box-text {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #666;
}

.info-box-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.badge-pink {
    background-color: #e91e63;
    color: white;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 8px !important;
    border-top-right-radius: 8px !important;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: none;
}

.btn-group-sm > .btn {
    margin-right: 2px;
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    .info-box {
        margin-bottom: 15px;
    }
    
    .info-box-icon {
        width: 50px;
        height: 50px;
        font-size: 18px;
    }
    
    .info-box-number {
        font-size: 20px;
    }
}
</style>

<script>
$(document).ready(function() {
    $('#guruTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        "buttons": [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm'
            }
        ]
    });
});

function deleteGuru(id, nama) {
    Swal.fire({
        title: 'Hapus Data Guru?',
        text: `Apakah Anda yakin ingin menghapus data guru "${nama}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("guru/delete/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
}

function resetPassword(id, nama) {
    Swal.fire({
        title: 'Reset Password?',
        text: `Reset password untuk guru "${nama}" ke password default?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("guru/reset_password/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
}
</script>

<?php if ($this->session->userdata('id_level_user') == 1): ?>
<script>
// Add DataTable buttons for admin users
$(document).ready(function() {
    var table = $('#guruTable').DataTable();
    
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm me-1'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm me-1'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm'
            }
        ]
    });
    
    table.buttons().container().appendTo('.card-tools');
});
</script>
<?php endif; ?>