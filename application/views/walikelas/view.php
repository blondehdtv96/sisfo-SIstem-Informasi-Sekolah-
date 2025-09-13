<section class="content">
    <div class="container-fluid">
        <!-- Academic Year Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-primary border-2 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Informasi Tahun Akademik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-calendar fa-2x"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-1">Tahun Akademik</h6>
                                        <h4 class="mb-0 text-dark"><?php echo isset($tahun_akademik) ? $tahun_akademik->tahun_ajar : '-'; ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-graduation-cap fa-2x"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-1">Semester</h6>
                                        <h4 class="mb-0 text-dark"><?php echo isset($tahun_akademik) ? ucfirst($tahun_akademik->semester) : '-'; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Summary Cards -->
        <div class="row mb-4">
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-primary border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-chalkboard-teacher fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark" id="total-classes">0</h3>
                        <p class="card-text text-muted">Total Kelas</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-success border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-check fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark" id="assigned-teachers">0</h3>
                        <p class="card-text text-muted">Wali Kelas Ditugaskan</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-warning border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-times fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark" id="unassigned-classes">0</h3>
                        <p class="card-text text-muted">Belum Ditugaskan</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3">
                <div class="card border-info border-2 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h3 class="card-title text-dark" id="total-students">0</h3>
                        <p class="card-text text-muted">Total Siswa</p>
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

        <!-- Walikelas Data Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-user-tie me-2"></i>
                            Data Wali Kelas
                        </h5>
                        <div class="card-tools">
                            <?php echo anchor('walikelas/add', '<i class="fas fa-plus me-1"></i> Tambah Wali Kelas', 'class="btn btn-primary btn-sm"'); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">No</th>
                                        <th style="width: 12%;">Kode Kelas</th>
                                        <th style="width: 15%;">Nama Kelas</th>
                                        <th class="text-center" style="width: 12%;">Jurusan</th>
                                        <th class="text-center" style="width: 8%;">Tingkat</th>
                                        <th style="width: 20%;">Wali Kelas</th>
                                        <th class="text-center" style="width: 8%;">Siswa</th>
                                        <th class="text-center" style="width: 10%;">Status</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="mt-2">Memuat data wali kelas...</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script type="text/javascript">
    var table;
    var availableTeachers = [];

    function updateWalikelas(id_wali_kelas){
        var id_guru = $("#guru"+id_wali_kelas).val();
        
        // Show loading indicator
        $("#guru"+id_wali_kelas).prop('disabled', true);
        
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>walikelas/update_walikelas',
            data: 'id_walikelas='+id_wali_kelas+'&id_guru='+id_guru,
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if(result.status === 'success') {
                        // Reload data after update
                        loadWalikelasData();
                        // Show success message with SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data wali kelas berhasil diperbarui',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + result.message,
                            icon: 'error'
                        });
                    }
                } catch(e) {
                    console.log('Error parsing response: ' + e.message);
                    loadWalikelasData();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses respons',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ' + error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengupdate data',
                    icon: 'error'
                });
            },
            complete: function() {
                // Re-enable dropdown
                $("#guru"+id_wali_kelas).prop('disabled', false);
            }
        });
    }

    $(document).ready(function() {
        // Load data
        loadAvailableTeachers();
        loadWalikelasData();
    });
    
    function loadAvailableTeachers() {
        $.ajax({
            url: '<?php echo base_url('walikelas/get_available_teachers'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(teachers) {
                if (teachers && !teachers.error) {
                    availableTeachers = teachers;
                } else {
                    availableTeachers = [];
                }
            },
            error: function(xhr, status, error) {
                availableTeachers = [];
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memuat data guru',
                    icon: 'error'
                });
            }
        });
    }

    function loadWalikelasData() {
        $.ajax({
            url: '<?php echo base_url('walikelas/get_walikelas_data'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    // Check if data has error
                    if (data.error) {
                        $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>' + data.error + '</td></tr>');
                        return;
                    }
                    
                    var html = '';

                    if (!data || data.length === 0) {
                        html = '<tr><td colspan="9" class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada data wali kelas untuk tahun akademik aktif</td></tr>';
                    } else {
                        for(var i = 0; i < data.length; i++) {
                            var walikelas = data[i];
                            
                            html += '<tr>';
                            html += '<td class="text-center align-middle">' + (i+1) + '</td>';
                            html += '<td class="align-middle"><span class="badge bg-secondary">' + (walikelas.kode_kelas || '-') + '</span></td>';
                            html += '<td class="align-middle"><strong class="text-dark">' + (walikelas.nama_kelas || '-') + '</strong></td>';
                            html += '<td class="text-center align-middle"><span class="text-dark">' + (walikelas.nama_jurusan || '-') + '</span></td>';
                            html += '<td class="text-center align-middle"><span class="badge bg-info">' + (walikelas.nama_tingkatan || '-') + '</span></td>';
                            html += '<td class="align-middle">' + getTeacherSelect(walikelas.id_wali_kelas, walikelas.id_guru, walikelas.nama_guru, walikelas.nip) + '</td>';
                            html += '<td class="text-center align-middle"><span class="badge bg-primary">' + (walikelas.jumlah_siswa || '0') + ' Siswa</span></td>';
                            html += '<td class="text-center align-middle">' + getStatusBadge(walikelas.status) + '</td>';
                            html += '<td class="text-center align-middle">';
                            html += '<div class="btn-group btn-group-sm" role="group">';
                            html += '<a href="<?php echo base_url('walikelas/edit/'); ?>' + walikelas.id_wali_kelas + '" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>';
                            html += '<a href="<?php echo base_url('walikelas/delete/'); ?>' + walikelas.id_wali_kelas + '" class="btn btn-outline-danger" title="Hapus" onclick="return confirm(\'Apakah Anda yakin ingin menghapus wali kelas ini?\')"><i class="fas fa-trash"></i></a>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        }
                    }

                    $('#mytable tbody').html(html);
                    
                    // Update statistics
                    updateStatistics(data || []);
                    
                    // Initialize DataTable
                    if ($.fn.dataTable.isDataTable('#mytable')) {
                        $('#mytable').DataTable().destroy();
                    }
                    
                    $('#mytable').DataTable({
                        "responsive": true,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                        },
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "columnDefs": [
                            { "orderable": false, "targets": [5, 7, 8] },
                            { "className": "dt-center", "targets": [0, 3, 4, 6, 7, 8] }
                        ],
                        "order": [[4, "asc"], [3, "asc"], [2, "asc"]]
                    });
                    
                } catch(e) {
                    $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>Error parsing data: ' + e.message + '</td></tr>');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses data: ' + e.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Error loading data: ' + error;
                if (xhr.status === 0) {
                    errorMessage = 'Connection error. Please check if the server is running.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Data endpoint not found (404).';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error (500). Please check server logs.';
                }
                
                $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>' + errorMessage + '</td></tr>');
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error'
                });
            }
        });
    }

    function getTeacherSelect(id_wali_kelas, current_teacher_id, current_teacher_name, current_teacher_nip) {
        var selectHtml = '<select class="form-select form-select-sm border-primary shadow-sm" id="guru' + id_wali_kelas + '" onchange="updateWalikelas(' + id_wali_kelas + ')" style="min-width: 200px;">';
        selectHtml += '<option value="0" class="text-muted">-- Pilih Wali Kelas --</option>';

        // Add current teacher if assigned
        if (current_teacher_id && current_teacher_id != '0') {
            var teacherLabel = current_teacher_name;
            if (current_teacher_nip) {
                teacherLabel += ' (' + current_teacher_nip + ')';
            }
            selectHtml += '<option value="' + current_teacher_id + '" selected class="text-dark fw-semibold">' + teacherLabel + '</option>';
        }
        
        // Add available teachers
        if (availableTeachers && availableTeachers.length > 0) {
            availableTeachers.forEach(function(teacher) {
                if (!current_teacher_id || teacher.id_guru != current_teacher_id) {
                    var teacherLabel = teacher.nama_guru;
                    if (teacher.nip) {
                        teacherLabel += ' (' + teacher.nip + ')';
                    }
                    selectHtml += '<option value="' + teacher.id_guru + '" class="text-dark">' + teacherLabel + '</option>';
                }
            });
        }

        selectHtml += '</select>';
        return selectHtml;
    }

    function getStatusBadge(status) {
        if (status === 'aktif') {
            return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>';
        } else {
            return '<span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Nonaktif</span>';
        }
    }
    
    function updateStatistics(data) {
        var totalClasses = data.length;
        var assignedTeachers = 0;
        var unassignedClasses = 0;
        var totalStudents = 0;
        
        data.forEach(function(item) {
            if (item.id_guru && item.id_guru != '0') {
                assignedTeachers++;
            } else {
                unassignedClasses++;
            }
            
            if (item.jumlah_siswa) {
                totalStudents += parseInt(item.jumlah_siswa) || 0;
            }
        });
        
        // Animate the statistics cards
        animateValue('total-classes', 0, totalClasses, 1000);
        animateValue('assigned-teachers', 0, assignedTeachers, 1200);
        animateValue('unassigned-classes', 0, unassignedClasses, 1400);
        animateValue('total-students', 0, totalStudents, 1600);
    }
    
    function animateValue(elementId, start, end, duration) {
        var element = document.getElementById(elementId);
        if (!element) return;
        
        var startTime = null;
        
        function step(currentTime) {
            if (!startTime) startTime = currentTime;
            var progress = Math.min((currentTime - startTime) / duration, 1);
            var value = Math.floor(progress * (end - start) + start);
            element.innerHTML = value;
            
            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        
        requestAnimationFrame(step);
    }
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Professional styling for walikelas management page */
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

.form-select {
    border: 2px solid #e9ecef;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    transform: translateY(-1px);
}

.form-select:hover {
    border-color: #007bff;
    background: #f8f9fa;
}

.badge {
    font-weight: 500;
    border-radius: 12px;
    padding: 6px 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

.card.border-info {
    border-color: #17a2b8 !important;
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
    
    .rounded-circle {
        width: 40px !important;
        height: 40px !important;
    }
}
</style>