<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Tingkatan</span>
                        <span class="info-box-number"><?php echo $total_tingkatan; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tingkat</span>
                        <span class="info-box-number">SMK</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-school"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sistem</span>
                        <span class="info-box-number">Aktif</span>
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
                    <i class="fas fa-layer-group me-2"></i>
                    Data Tingkatan
                </h3>
                <div class="card-tools">
                    <?php if ($this->session->userdata('id_level_user') == 1): ?>
                        <a href="<?php echo site_url('tingkatan/add'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Tingkatan
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tingkatanTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="width: 20%;">Nama Tingkatan</th>
                                <th style="width: 50%;">Keterangan</th>
                                <th style="width: 20%;">Tanggal Dibuat</th>
                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                    <th style="width: 15%;">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($tingkatan as $tingkat): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><span class="badge bg-info"><?php echo $tingkat->nama_tingkatan; ?></span></td>
                                    <td>
                                        <?php 
                                        $keterangan = $tingkat->keterangan;
                                        echo strlen($keterangan) > 50 ? substr($keterangan, 0, 50) . '...' : ($keterangan ?: '-'); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if ($tingkat->created_at) {
                                            echo date('d/m/Y H:i', strtotime($tingkat->created_at));
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo site_url('tingkatan/edit/' . $tingkat->id_tingkatan); ?>" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Hapus"
                                                        onclick="deleteTingkatan(<?php echo $tingkat->id_tingkatan; ?>, '<?php echo $tingkat->nama_tingkatan; ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
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
    $('#tingkatanTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
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

function deleteTingkatan(id, nama) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Tingkatan "${nama}" akan dihapus dan tidak dapat dikembalikan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("tingkatan/delete/"); ?>' + id,
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