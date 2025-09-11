<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-eye"></i> Detail Assignment Guru Mata Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('guru_mapel'); ?>">Guru Mata Pelajaran</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Assignment Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Detail Assignment
                        </h5>
                        <div class="card-tools">
                            <a href="<?php echo base_url('guru_mapel/edit/' . $assignment->id_guru_mapel); ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Guru</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120px"><strong>Nama Guru:</strong></td>
                                        <td><?php echo $assignment->nama_guru; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIP:</strong></td>
                                        <td><?php echo $assignment->nip ?: '<span class="text-muted">-</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge badge-success">Aktif</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Mata Pelajaran</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120px"><strong>Nama Mapel:</strong></td>
                                        <td><?php echo $assignment->nama_mapel; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kode Mapel:</strong></td>
                                        <td><span class="badge badge-primary"><?php echo $assignment->kode_mapel; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategori:</strong></td>
                                        <td>
                                            <?php 
                                            $kategori_class = '';
                                            $kategori_name = '';
                                            switch($assignment->kategori ?? 'umum') {
                                                case 'umum': 
                                                    $kategori_class = 'badge-info'; 
                                                    $kategori_name = 'Umum';
                                                    break;
                                                case 'kejuruan': 
                                                    $kategori_class = 'badge-success'; 
                                                    $kategori_name = 'Kejuruan';
                                                    break;
                                                case 'muatan_lokal': 
                                                    $kategori_class = 'badge-warning'; 
                                                    $kategori_name = 'Muatan Lokal';
                                                    break;
                                                default: 
                                                    $kategori_class = 'badge-secondary';
                                                    $kategori_name = 'Lainnya';
                                            }
                                            ?>
                                            <span class="badge <?php echo $kategori_class; ?>">
                                                <?php echo $kategori_name; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted">Informasi Assignment</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120px"><strong>ID Assignment:</strong></td>
                                        <td><?php echo $assignment->id_guru_mapel; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tahun Akademik:</strong></td>
                                        <td><span class="badge badge-dark"><?php echo $assignment->tahun_ajar; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Dibuat:</strong></td>
                                        <td><?php echo date('d F Y, H:i', strtotime($assignment->created_at)); ?> WIB</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('guru_mapel/edit/' . $assignment->id_guru_mapel); ?>" 
                               class="btn btn-warning btn-block">
                                <i class="fas fa-edit"></i> Edit Assignment
                            </a>
                            <a href="<?php echo base_url('guru_mapel/teacher_assignments/' . $assignment->id_guru); ?>" 
                               class="btn btn-info btn-block">
                                <i class="fas fa-user"></i> Assignment Guru Ini
                            </a>
                            <a href="<?php echo base_url('guru_mapel/subject_teachers/' . $assignment->id_mapel); ?>" 
                               class="btn btn-success btn-block">
                                <i class="fas fa-book"></i> Guru Mata Pelajaran Ini
                            </a>
                            <a href="<?php echo base_url('guru_mapel'); ?>" 
                               class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Related Information -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-link"></i> Informasi Terkait
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Statistik Assignment:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-user text-info"></i>
                                <strong>Guru:</strong> <?php echo $assignment->nama_guru; ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-book text-success"></i>
                                <strong>Mata Pelajaran:</strong> <?php echo $assignment->nama_mapel; ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-calendar text-warning"></i>
                                <strong>Tahun Akademik:</strong> <?php echo $assignment->tahun_ajar; ?>
                            </li>
                        </ul>

                        <hr>

                        <h6 class="mb-3">Status Assignment:</h6>
                        <div class="text-center">
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle"></i> Assignment Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Warning Card -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle"></i> Peringatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <i class="fas fa-info-circle text-info"></i>
                            Assignment ini merupakan data aktif dalam sistem
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Perubahan atau penghapusan dapat mempengaruhi jadwal dan nilai
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-shield-alt text-success"></i>
                            Pastikan koordinasi dengan admin akademik
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Button (Separate for safety) -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-trash"></i> Zona Bahaya
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Tindakan ini akan menghapus assignment secara permanen dan tidak dapat dibatalkan.
                            Pastikan tidak ada data terkait sebelum menghapus.
                        </p>
                        <button onclick="deleteAssignment(<?php echo $assignment->id_guru_mapel; ?>)" 
                                class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Assignment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script>
function deleteAssignment(id) {
    Swal.fire({
        title: 'Konfirmasi Hapus Assignment',
        text: 'Apakah Anda yakin ingin menghapus assignment ini? Tindakan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("guru_mapel/delete/"); ?>' + id,
                type: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => {
                            window.location.href = '<?php echo base_url("guru_mapel"); ?>';
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
.table-borderless td {
    border: none;
    padding: 0.375rem 0.75rem;
}

.badge-lg {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.d-grid .btn-block {
    width: 100%;
    margin-bottom: 0.5rem;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border: none;
    border-radius: 0.25rem;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.list-unstyled li {
    border-bottom: 1px solid #f8f9fa;
    padding-bottom: 0.5rem;
}

.list-unstyled li:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

@media (max-width: 768px) {
    .d-grid .btn-block {
        margin-bottom: 0.75rem;
    }
}
</style>