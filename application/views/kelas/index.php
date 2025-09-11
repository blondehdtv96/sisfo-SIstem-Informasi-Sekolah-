<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3><?php echo $total_kelas; ?></h3>
                                <p class="mb-0">Total Kelas</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-school fa-2x"></i>
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
                                <p class="mb-0">Kelas Aktif</p>
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
                                <p class="mb-0">Kelas Nonaktif</p>
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
                            <i class="fas fa-school me-2"></i>
                            Data Kelas
                        </h3>
                        <div class="card-tools">
                            <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                <a href="<?php echo site_url('kelas/add'); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Kelas
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
                            <table id="kelasTable" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Nama Kelas</th>
                                        <th width="15%">Tingkatan</th>
                                        <th width="20%">Jurusan</th>
                                        <th width="10%">Rombel</th>
                                        <th width="10%">Kapasitas</th>
                                        <th width="10%">Status</th>
                                        <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                            <th width="15%">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($kelas)): ?>
                                        <?php $no = 1; foreach ($kelas as $k): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <strong class="text-primary"><?php echo $k->nama_kelas; ?></strong>
                                                    <br><small class="text-muted"><?php echo $k->kode_kelas; ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $k->nama_tingkatan ? $k->nama_tingkatan : '-'; ?></span>
                                                </td>
                                                <td><?php echo $k->nama_jurusan ? $k->nama_jurusan : '<em class="text-muted">-</em>'; ?></td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo $k->rombel ? $k->rombel : '-'; ?></span>
                                                </td>
                                                <td><?php echo $k->kapasitas ? $k->kapasitas . ' siswa' : '<em class="text-muted">-</em>'; ?></td>
                                                <td>
                                                    <?php if ($k->status == 'aktif'): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?php echo site_url('kelas/edit/' . $k->id_kelas); ?>" 
                                                               class="btn btn-sm btn-outline-primary" 
                                                               title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    onclick="deleteKelas(<?php echo $k->id_kelas; ?>)" 
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
                                            <td colspan="<?php echo ($this->session->userdata('id_level_user') == 1) ? '8' : '7'; ?>" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-school fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Belum ada data kelas</h5>
                                                    <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                        <a href="<?php echo site_url('kelas/add'); ?>" class="btn btn-primary">
                                                            <i class="fas fa-plus"></i> Tambah Kelas Pertama
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
    $('#kelasTable').DataTable({
        responsive: true,
        order: [[1, 'asc']], // Sort by class name
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting on action column
        ]
    });
});

function deleteKelas(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data kelas akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("kelas/delete/"); ?>' + id,
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