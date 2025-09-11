<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo $total_mapel; ?></h3>
                                <p class="mb-0">Total Mata Pelajaran</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo $total_aktif; ?></h3>
                                <p class="mb-0">Mata Pelajaran Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo $total_nonaktif; ?></h3>
                                <p class="mb-0">Mata Pelajaran Nonaktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-book me-2"></i>
                            Data Mata Pelajaran
                        </h3>
                        <div class="card-tools">
                            <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                <a href="<?php echo site_url('matapelajaran/add'); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table id="matapelajaranTable" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Kode</th>
                                        <th width="35%">Nama Mata Pelajaran</th>
                                        <th width="15%">Kategori</th>
                                        <th width="10%">Status</th>
                                        <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                            <th width="20%">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($matapelajaran)): ?>
                                        <?php $no = 1; foreach ($matapelajaran as $mapel): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $mapel->kode_mapel; ?></span>
                                                </td>
                                                <td><?php echo $mapel->nama_mapel; ?></td>
                                                <td>
                                                    <?php
                                                    $badge_class = '';
                                                    switch($mapel->kategori) {
                                                        case 'umum': $badge_class = 'bg-primary'; break;
                                                        case 'kejuruan': $badge_class = 'bg-success'; break;
                                                        case 'muatan_lokal': $badge_class = 'bg-warning'; break;
                                                        default: $badge_class = 'bg-secondary';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $mapel->kategori)); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($mapel->status == 'aktif'): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Nonaktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?php echo site_url('matapelajaran/edit/' . $mapel->id_mapel); ?>" 
                                                               class="btn btn-sm btn-outline-primary" 
                                                               title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    onclick="deleteMapel(<?php echo $mapel->id_mapel; ?>)" 
                                                                    title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="<?php echo ($this->session->userdata('id_level_user') == 1) ? '6' : '5'; ?>" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Belum ada data mata pelajaran</h5>
                                                    <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                        <a href="<?php echo site_url('matapelajaran/add'); ?>" class="btn btn-primary">
                                                            <i class="fas fa-plus"></i> Tambah Mata Pelajaran Pertama
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($this->session->userdata('id_level_user') == 1): ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#matapelajaranTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting on action column
        ]
    });
});

function deleteMapel(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data mata pelajaran akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("matapelajaran/delete/"); ?>' + id,
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
</script>
<?php endif; ?>