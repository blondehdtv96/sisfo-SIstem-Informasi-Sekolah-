<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Tahun Akademik</span>
                        <span class="info-box-number"><?php echo $total_tahun; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tahun Aktif</span>
                        <span class="info-box-number"><?php echo $tahun_aktif; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sistem</span>
                        <span class="info-box-number">Akademik</span>
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

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Data Tahun Akademik
                </h3>
                <div class="card-tools">
                    <a href="<?php echo site_url('tahunakademik/add'); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Tahun Akademik
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tahunAkademikTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="width: 20%;">Tahun Ajar</th>
                                <th style="width: 15%;">Semester</th>
                                <th style="width: 15%;">Tanggal Mulai</th>
                                <th style="width: 15%;">Tanggal Selesai</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($tahun_akademik as $ta): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo $ta->tahun_ajar; ?></strong></td>
                                    <td>
                                        <span class="badge bg-<?php echo $ta->semester == 'ganjil' ? 'primary' : 'secondary'; ?>">
                                            <?php echo ucfirst($ta->semester); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($ta->tanggal_mulai)); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ta->tanggal_selesai)); ?></td>
                                    <td>
                                        <?php if ($ta->status == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if ($ta->status != 'aktif'): ?>
                                                <button type="button" 
                                                        class="btn btn-warning btn-sm" 
                                                        title="Aktifkan"
                                                        onclick="aktivasiTahun(<?php echo $ta->id_tahun_akademik; ?>, '<?php echo $ta->tahun_ajar; ?>')">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?php echo site_url('tahunakademik/edit/' . $ta->id_tahun_akademik); ?>" 
                                               class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($ta->status != 'aktif'): ?>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Hapus"
                                                        onclick="deleteTahun(<?php echo $ta->id_tahun_akademik; ?>, '<?php echo $ta->tahun_ajar; ?>')">
                                                    <i class="fas fa-trash"></i>
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

<!-- DataTables CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">

<!-- DataTables JS -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>

<script>
$(document).ready(function() {
    $('#tahunAkademikTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
        "order": [[1, 'desc']], // Sort by tahun ajar descending
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});

function aktivasiTahun(id, tahun) {
    Swal.fire({
        title: 'Aktifkan Tahun Akademik?',
        text: `Tahun akademik "${tahun}" akan diaktifkan dan tahun akademik lain akan dinonaktifkan!`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, aktifkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?php echo site_url("tahunakademik/aktif/"); ?>' + id;
        }
    });
}

function deleteTahun(id, tahun) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Tahun akademik "${tahun}" akan dihapus dan tidak dapat dikembalikan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("tahunakademik/delete/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus data.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>