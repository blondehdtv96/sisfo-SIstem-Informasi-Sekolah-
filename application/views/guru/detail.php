<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-user"></i> Detail Guru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('guru'); ?>">Data Guru</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Card -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-id-card"></i> Profil Guru
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($guru->foto && file_exists('./assets/uploads/guru/' . $guru->foto)): ?>
                            <img src="<?php echo base_url('assets/uploads/guru/' . $guru->foto); ?>" 
                                 alt="Foto <?php echo $guru->nama_guru; ?>" 
                                 class="img-fluid rounded-circle shadow mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center shadow mb-3" 
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user text-white fa-4x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h4 class="text-primary"><?php echo $guru->nama_guru; ?></h4>
                        
                        <?php if (!empty($guru->nip)): ?>
                            <p class="text-muted mb-1">NIP: <?php echo $guru->nip; ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($guru->nuptk)): ?>
                            <p class="text-muted mb-2">NUPTK: <?php echo $guru->nuptk; ?></p>
                        <?php endif; ?>
                        
                        <div class="mb-2">
                            <?php 
                            $kepegawaian_colors = [
                                'PNS' => 'success',
                                'GTT' => 'warning',
                                'GTY' => 'info',
                                'Honorer' => 'secondary'
                            ];
                            $color = $kepegawaian_colors[$guru->status_kepegawaian] ?? 'secondary';
                            ?>
                            <span class="badge badge-<?php echo $color; ?> badge-lg">
                                <i class="fas fa-certificate"></i> <?php echo $guru->status_kepegawaian; ?>
                            </span>
                        </div>
                        
                        <div>
                            <?php if ($guru->status == 'aktif'): ?>
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge badge-danger badge-lg">
                                    <i class="fas fa-times-circle"></i> Non-Aktif
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('guru'); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                            <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                <a href="<?php echo base_url('guru/edit/' . $guru->id_guru); ?>" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i> Edit Data
                                </a>
                                <button type="button" class="btn btn-outline-info" onclick="resetPassword(<?php echo $guru->id_guru; ?>, '<?php echo $guru->nama_guru; ?>')">
                                    <i class="fas fa-key"></i> Reset Password
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Personal Information -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle"></i> Informasi Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">Nama Lengkap</td>
                                        <td>: <?php echo $guru->nama_guru; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Jenis Kelamin</td>
                                        <td>: 
                                            <?php if ($guru->jenis_kelamin == 'L'): ?>
                                                <span class="badge badge-primary">
                                                    <i class="fas fa-mars"></i> Laki-laki
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-pink">
                                                    <i class="fas fa-venus"></i> Perempuan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Tempat Lahir</td>
                                        <td>: <?php echo $guru->tempat_lahir ?? '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Tanggal Lahir</td>
                                        <td>: 
                                            <?php 
                                            if ($guru->tanggal_lahir && $guru->tanggal_lahir != '0000-00-00') {
                                                echo date('d F Y', strtotime($guru->tanggal_lahir));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Agama</td>
                                        <td>: <?php echo $guru->agama ?? '-'; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">No. Telepon</td>
                                        <td>: 
                                            <?php if (!empty($guru->no_telp)): ?>
                                                <a href="tel:<?php echo $guru->no_telp; ?>" class="text-decoration-none">
                                                    <i class="fas fa-phone"></i> <?php echo $guru->no_telp; ?>
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Email</td>
                                        <td>: 
                                            <?php if (!empty($guru->email)): ?>
                                                <a href="mailto:<?php echo $guru->email; ?>" class="text-decoration-none">
                                                    <i class="fas fa-envelope"></i> <?php echo $guru->email; ?>
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Alamat</td>
                                        <td>: <?php echo $guru->alamat ?? '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Username</td>
                                        <td>: 
                                            <?php if (!empty($guru->username)): ?>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-user"></i> <?php echo $guru->username; ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum diatur</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Last Login</td>
                                        <td>: 
                                            <?php 
                                            if ($guru->last_login && $guru->last_login != '0000-00-00 00:00:00') {
                                                echo date('d F Y H:i:s', strtotime($guru->last_login));
                                            } else {
                                                echo 'Belum pernah login';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-briefcase"></i> Informasi Kepegawaian
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">NIP</td>
                                        <td>: 
                                            <?php if (!empty($guru->nip)): ?>
                                                <span class="badge badge-primary"><?php echo $guru->nip; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">NUPTK</td>
                                        <td>: 
                                            <?php if (!empty($guru->nuptk)): ?>
                                                <span class="badge badge-info"><?php echo $guru->nuptk; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Status Kepegawaian</td>
                                        <td>: 
                                            <span class="badge badge-<?php echo $color; ?>">
                                                <?php echo $guru->status_kepegawaian; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold text-muted">Jabatan</td>
                                        <td>: <?php echo $guru->jabatan ?? '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Pendidikan Terakhir</td>
                                        <td>: <?php echo $guru->pendidikan_terakhir ?? '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Status Akun</td>
                                        <td>: 
                                            <?php if ($guru->status == 'aktif'): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Non-Aktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock"></i> Informasi Sistem
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-calendar-plus text-success"></i>
                                    <strong>Dibuat:</strong> 
                                    <?php 
                                    if (isset($guru->created_at) && $guru->created_at != '0000-00-00 00:00:00') {
                                        echo date('d F Y H:i:s', strtotime($guru->created_at));
                                    } else {
                                        echo 'Data tidak tersedia';
                                    }
                                    ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                    <strong>Terakhir Diupdate:</strong> 
                                    <?php 
                                    if (isset($guru->updated_at) && $guru->updated_at != '0000-00-00 00:00:00') {
                                        echo date('d F Y H:i:s', strtotime($guru->updated_at));
                                    } else {
                                        echo 'Belum pernah diupdate';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-sign-in-alt text-info"></i>
                                    <strong>Login Terakhir:</strong> 
                                    <?php 
                                    if ($guru->last_login && $guru->last_login != '0000-00-00 00:00:00') {
                                        echo date('d F Y H:i:s', strtotime($guru->last_login));
                                    } else {
                                        echo 'Belum pernah login';
                                    }
                                    ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-key text-secondary"></i>
                                    <strong>Password:</strong> 
                                    <?php if (!empty($guru->password)): ?>
                                        <span class="badge badge-success">Sudah diatur</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Belum diatur</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.badge-pink {
    background-color: #e91e63;
    color: white;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    margin-bottom: 20px;
}

.card-header {
    border-top-left-radius: 8px !important;
    border-top-right-radius: 8px !important;
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.fw-bold {
    font-weight: 600;
    min-width: 150px;
}

@media print {
    .btn, .card-header {
        display: none !important;
    }
    
    .card {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .fw-bold {
        min-width: auto;
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .table-borderless td {
        display: block;
        padding: 0.25rem 0;
    }
}
</style>

<script>
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

// Print functionality
function printDetail() {
    window.print();
}
</script>