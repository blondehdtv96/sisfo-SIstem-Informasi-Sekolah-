<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa</span>
                        <span class="info-box-number"><?php echo $total_siswa; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aktif</span>
                        <span class="info-box-number"><?php echo $total_aktif; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Lulus</span>
                        <span class="info-box-number"><?php echo $total_lulus; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exchange-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pindah</span>
                        <span class="info-box-number"><?php echo $total_pindah; ?></span>
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

        <!-- Filter Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter me-2"></i>
                    Filter Data Siswa
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select id="filter_kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            <?php foreach ($kelas_list as $kelas): ?>
                                <option value="<?php echo $kelas->id_kelas; ?>">
                                    <?php echo $kelas->nama_kelas; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_jurusan" class="form-select">
                            <option value="">Semua Jurusan</option>
                            <?php foreach ($jurusan_list as $jurusan): ?>
                                <option value="<?php echo $jurusan->id_jurusan; ?>">
                                    <?php echo $jurusan->nama_jurusan; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="lulus">Lulus</option>
                            <option value="pindah">Pindah</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="btn_filter" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-graduate me-2"></i>
                    Data Siswa
                </h3>
                <div class="card-tools">
                    <?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
                        <a href="<?php echo site_url('siswa/add'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                        <a href="<?php echo site_url('siswa/export_excel'); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="siswaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 8%;">Foto</th>
                                <th style="width: 12%;">NISN/NIS</th>
                                <th style="width: 20%;">Nama Siswa</th>
                                <th style="width: 15%;">Kelas</th>
                                <th style="width: 8%;">L/P</th>
                                <th style="width: 12%;">Status</th>
                                <th style="width: 10%;">Tgl Masuk</th>
                                <?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
                                    <th style="width: 15%;">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($siswa as $s): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-center">
                                        <?php if ($s->foto && file_exists('./assets/uploads/siswa/' . $s->foto)): ?>
                                            <img src="<?php echo base_url('assets/uploads/siswa/' . $s->foto); ?>" 
                                                 alt="Foto <?php echo $s->nama_siswa; ?>" 
                                                 class="img-circle elevation-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-gray-400 rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo $s->nisn; ?></strong><br>
                                        <small class="text-muted"><?php echo $s->nis ?: '-'; ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('siswa/detail/' . $s->id_siswa); ?>" 
                                           class="text-decoration-none">
                                            <?php echo $s->nama_siswa; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo $s->nama_kelas ?: 'Belum Ada Kelas'; ?>
                                        </span><br>
                                        <small class="text-muted"><?php echo $s->nama_jurusan; ?></small>
                                    </td>
                                    <td>
                                        <?php if ($s->jenis_kelamin == 'L'): ?>
                                            <span class="badge bg-primary">L</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">P</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $status_class = '';
                                        switch($s->status) {
                                            case 'aktif': $status_class = 'bg-success'; break;
                                            case 'lulus': $status_class = 'bg-warning'; break;
                                            case 'pindah': $status_class = 'bg-info'; break;
                                            case 'keluar': $status_class = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $status_class; ?>">
                                            <?php echo ucfirst($s->status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $s->tanggal_masuk ? date('d/m/Y', strtotime($s->tanggal_masuk)) : '-'; ?>
                                    </td>
                                    <?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo site_url('siswa/detail/' . $s->id_siswa); ?>" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo site_url('siswa/edit/' . $s->id_siswa); ?>" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-secondary btn-sm" 
                                                        title="Reset Password"
                                                        onclick="resetPassword(<?php echo $s->id_siswa; ?>, '<?php echo $s->nama_siswa; ?>')">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Hapus"
                                                            onclick="deleteSiswa(<?php echo $s->id_siswa; ?>, '<?php echo $s->nama_siswa; ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
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
    var table = $('#siswaTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 25,
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

    // Filter functionality
    $('#btn_filter').click(function() {
        var kelas = $('#filter_kelas').val();
        var jurusan = $('#filter_jurusan').val();
        var status = $('#filter_status').val();
        
        // Apply filters
        table.columns(4).search(kelas ? kelas : '');
        table.columns(6).search(status ? status : '');
        table.draw();
    });

    $('#btn_reset').click(function() {
        $('#filter_kelas, #filter_jurusan, #filter_status').val('');
        table.search('').columns().search('').draw();
    });
});

function deleteSiswa(id, nama) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Siswa "${nama}" akan dihapus permanen dan tidak dapat dikembalikan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("siswa/delete/"); ?>' + id,
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

function resetPassword(id, nama) {
    Swal.fire({
        title: 'Reset Password',
        text: `Reset password siswa "${nama}" ke NISN?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("siswa/reset_password/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success'
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
                        text: 'Terjadi kesalahan saat reset password.',
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