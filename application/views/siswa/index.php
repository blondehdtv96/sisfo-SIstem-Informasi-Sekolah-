<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row mb-4">
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-primary border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark"><?php echo $total_siswa; ?></h3>
                        <p class="card-text text-muted">Total Siswa</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-success border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark"><?php echo $total_aktif; ?></h3>
                        <p class="card-text text-muted">Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-warning border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark"><?php echo $total_lulus; ?></h3>
                        <p class="card-text text-muted">Lulus</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-danger border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-exchange-alt fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark"><?php echo $total_pindah; ?></h3>
                        <p class="card-text text-muted">Pindah</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Filter Section - Only for Admin -->
        <?php if ($this->session->userdata('id_level_user') == 1 && isset($kelas_list)): ?>
        <div class="bg-light rounded p-2 mb-3 border">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <small class="text-muted fw-medium">
                        <i class="fas fa-filter me-1"></i>Filter:
                    </small>
                </div>
                <div class="col-md-2 col-sm-6">
                    <select id="filter_kelas" class="form-select form-select-sm">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?php echo $kelas->nama_kelas; ?>">
                                <?php echo $kelas->nama_kelas; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <select id="filter_jurusan" class="form-select form-select-sm">
                        <option value="">Semua Jurusan</option>
                        <?php foreach ($jurusan_list as $jurusan): ?>
                            <option value="<?php echo $jurusan->nama_jurusan; ?>">
                                <?php echo $jurusan->nama_jurusan; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <select id="filter_status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Pindah">Pindah</option>
                        <option value="Keluar">Keluar</option>
                    </select>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button type="button" id="btn_filter" class="btn btn-primary btn-sm" title="Terapkan Filter">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main content -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-user-graduate me-2"></i>
                    Data Siswa
                </h5>
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
                    <table id="siswaTable" class="table table-hover table-bordered">
                        <thead class="table-light">
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
                                    <td class="align-middle"><?php echo $no++; ?></td>
                                    <td class="text-center align-middle">
                                        <?php if ($s->foto && file_exists('./assets/uploads/siswa/' . $s->foto)): ?>
                                            <img src="<?php echo base_url('assets/uploads/siswa/' . $s->foto); ?>" 
                                                 alt="Foto <?php echo $s->nama_siswa; ?>" 
                                                 class="rounded-circle" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" 
                                                 style="width: 40px; height: 40px; border: 2px solid #dee2e6;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <strong class="text-dark"><?php echo $s->nisn; ?></strong><br>
                                        <small class="text-muted"><?php echo $s->nis ?: '-'; ?></small>
                                    </td>
                                    <td class="align-middle">
                                        <a href="<?php echo site_url('siswa/detail/' . $s->id_siswa); ?>" 
                                           class="text-decoration-none text-dark fw-medium">
                                            <?php echo $s->nama_siswa; ?>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-info">
                                            <?php echo $s->nama_kelas ?: 'Belum Ada Kelas'; ?>
                                        </span><br>
                                        <small class="text-muted"><?php echo $s->nama_jurusan; ?></small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php if ($s->jenis_kelamin == 'L'): ?>
                                            <span class="badge bg-primary">L</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">P</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php 
                                        $status_class = '';
                                        switch($s->status) {
                                            case 'aktif': $status_class = 'bg-success'; break;
                                            case 'lulus': $status_class = 'bg-warning'; break;
                                            case 'pindah': $status_class = 'bg-info'; break;
                                            case 'keluar': $status_class = 'bg-danger'; break;
                                            default: $status_class = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?php echo $status_class; ?>">
                                            <?php echo ucfirst($s->status); ?>
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $s->tanggal_masuk ? date('d/m/Y', strtotime($s->tanggal_masuk)) : '-'; ?>
                                    </td>
                                    <?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
                                        <td class="align-middle">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo site_url('siswa/detail/' . $s->id_siswa); ?>" 
                                                   class="btn btn-outline-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo site_url('siswa/edit/' . $s->id_siswa); ?>" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-secondary" 
                                                        title="Reset Password"
                                                        onclick="resetPassword(<?php echo $s->id_siswa; ?>, '<?php echo $s->nama_siswa; ?>')">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger" 
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
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, -1] }
        ]
    });

    // Filter functionality for admin
    function applyFilter() {
        var kelas = $('#filter_kelas').val();
        var jurusan = $('#filter_jurusan').val();
        var status = $('#filter_status').val();
        
        // Show loading
        Swal.fire({
            title: 'Memfilter data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Send AJAX request for server-side filtering
        $.ajax({
            url: '<?php echo site_url("siswa/filter_data"); ?>',
            type: 'POST',
            data: {
                kelas: kelas,
                jurusan: jurusan,
                status: status
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Clear and reload table with filtered data
                    table.clear();
                    table.rows.add(response.data);
                    table.draw();
                    
                    // Show filter info
                    var activeFilters = [];
                    if (kelas) activeFilters.push('Kelas: ' + kelas);
                    if (jurusan) activeFilters.push('Jurusan: ' + jurusan);
                    if (status) activeFilters.push('Status: ' + status);
                    
                    Swal.close();
                    
                    if (activeFilters.length > 0) {
                        toastr.success('Filter diterapkan: ' + activeFilters.join(', '), 'Filter Aktif');
                    } else {
                        toastr.info('Menampilkan semua data siswa', 'Filter');
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'Terjadi kesalahan saat memfilter data.',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Filter error:', xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memfilter data.',
                    icon: 'error'
                });
            }
        });
    }

    // Filter button click
    $('#btn_filter').click(function() {
        applyFilter();
    });

    // Reset filter
    $('#btn_reset').click(function() {
        $('#filter_kelas, #filter_jurusan, #filter_status').val('');
        // Reload page to show all data
        location.reload();
    });

    // Apply filter on Enter key
    $('#filter_kelas, #filter_jurusan, #filter_status').keypress(function(e) {
        if (e.which == 13) { // Enter key
            applyFilter();
        }
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
            // Show loading
            Swal.fire({
                title: 'Menghapus data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '<?php echo site_url("siswa/delete/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response, textStatus, xhr) {
                    console.log('Delete response details:', {
                        response: response,
                        textStatus: textStatus,
                        status: xhr.status,
                        responseText: xhr.responseText
                    });
                    
                    // Check if response is valid
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            console.log('Failed to parse response as JSON:', e);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Server mengembalikan response yang tidak valid.',
                                icon: 'error'
                            });
                            return;
                        }
                    }
                    
                    if (response && response.success === true) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'Data siswa berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response && response.message ? response.message : 'Terjadi kesalahan tidak diketahui.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Delete error details:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    let errorMessage = 'Terjadi kesalahan saat menghapus data.';
                    
                    // Handle different types of errors
                    if (xhr.status === 200 && xhr.responseText) {
                        // Status 200 but treated as error - likely invalid JSON
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response && response.message) {
                                errorMessage = response.message;
                            } else {
                                errorMessage = 'Response tidak valid dari server.';
                            }
                        } catch (e) {
                            console.log('JSON parse error:', e);
                            errorMessage = 'Server mengembalikan response yang tidak valid. Silakan periksa log server.';
                        }
                    } else if (xhr.status === 0) {
                        errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Akses ditolak. Anda tidak memiliki izin untuk menghapus data.';
                    } else if (xhr.status === 404) {
                        errorMessage = 'Endpoint tidak ditemukan. Silakan hubungi administrator.';
                    } else if (xhr.status >= 500) {
                        errorMessage = 'Terjadi kesalahan server internal. Silakan coba lagi atau hubungi administrator.';
                    } else if (status === 'timeout') {
                        errorMessage = 'Request timeout. Silakan coba lagi.';
                    } else if (xhr.responseText) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response && response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            errorMessage = `Server error (${xhr.status}): ${xhr.statusText}`;
                        }
                    }
                    
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        footer: xhr.status ? `Status Code: ${xhr.status}` : ''
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

<!-- Toastr for notifications -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
/* Professional styling for student management page */
.content {
    color: #000000 !important;
}

.card {
    border-radius: 10px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid #e9ecef;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
    background-color: #ffffff;
}

.card-title {
    font-weight: 600;
    color: #2c3e50;
}

.table {
    color: #000000 !important;
    background-color: #ffffff;
}

.table th {
    font-weight: 600;
    color: #000000 !important;
    background-color: #f8f9fa;
}

.table td {
    color: #000000 !important;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-color: #dee2e6;
}

.form-label {
    font-weight: 500;
    color: #000000 !important;
}

.badge {
    font-weight: 500;
}

.alert {
    border: none;
    border-radius: 8px;
}

/* Info boxes styling */
.card.border-2 {
    border-width: 2px !important;
}

.card.border-primary {
    border-color: #007bff !important;
}

.card.border-success {
    border-color: #28a745 !important;
}

.card.border-warning {
    border-color: #ffc107 !important;
}

.card.border-danger {
    border-color: #dc3545 !important;
}

/* DataTables customization */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_processing,
.dataTables_wrapper .dataTables_paginate {
    color: #000000 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #000000 !important;
    border-radius: 5px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #007bff;
    color: white !important;
    border: 1px solid #007bff;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e9ecef;
    color: #000000 !important;
}

/* Minimalist filter styling */
.bg-light.rounded {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef !important;
}

.form-select-sm {
    font-size: 0.875rem;
    border: 1px solid #ced4da;
}

.form-select-sm:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
    
    .bg-light.rounded {
        padding: 0.75rem !important;
    }
    
    .col-md-2 {
        flex: 0 0 auto;
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

<script>
// Configure Toastr
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
</script>
</style>
