<section class="content">
    <div class="container-fluid">
        <!-- Academic Year Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Informasi Tahun Akademik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-circle me-3">
                                        <i class="fas fa-calendar fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Tahun Akademik</h6>
                                        <h4 class="mb-0"><?php echo isset($tahun_akademik) ? $tahun_akademik->tahun_ajar : '-'; ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-circle me-3">
                                        <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Semester</h6>
                                        <h4 class="mb-0"><?php echo isset($tahun_akademik) ? ucfirst($tahun_akademik->semester) : '-'; ?></h4>
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
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-primary text-white h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <h4 class="mb-1" id="total-classes">0</h4>
                        <p class="mb-0 small">Total Kelas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-success text-white h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>
                        <h4 class="mb-1" id="assigned-teachers">0</h4>
                        <p class="mb-0 small">Wali Kelas Ditugaskan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-warning text-white h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-user-times fa-2x"></i>
                        </div>
                        <h4 class="mb-1" id="unassigned-classes">0</h4>
                        <p class="mb-0 small">Belum Ditugaskan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-info text-white h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h4 class="mb-1" id="total-students">0</h4>
                        <p class="mb-0 small">Total Siswa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Walikelas Data Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-0"><i class="fas fa-user-tie me-2"></i>Data Wali Kelas</h5>
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <!-- Quick Filter Buttons -->
                            <div class="btn-group" role="group" aria-label="Filter">
                                <button type="button" class="btn btn-outline-light btn-sm" id="filter-all" onclick="filterTable('all')">Semua</button>
                                <button type="button" class="btn btn-outline-light btn-sm" id="filter-assigned" onclick="filterTable('assigned')">Sudah Ditugaskan</button>
                                <button type="button" class="btn btn-outline-light btn-sm" id="filter-unassigned" onclick="filterTable('unassigned')">Belum Ditugaskan</button>
                            </div>
                            <!-- Debug/Reload Buttons -->
                            <div class="btn-group" role="group" aria-label="Debug">
                                <button type="button" class="btn btn-outline-light btn-sm" onclick="loadWalikelasData()" title="Reload Data"><i class="fas fa-sync-alt"></i></button>
                                <button type="button" class="btn btn-outline-light btn-sm" onclick="loadSimpleWalikelasData()" title="Simple Mode"><i class="fas fa-list"></i></button>
                            </div>
                            <?php echo anchor('walikelas/add', '<i class="fas fa-plus-circle me-1"></i> Tambah Wali Kelas', 'class="btn btn-success btn-sm"'); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-striped table-hover table-bordered w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center text-white" width="5%">No</th>
                                        <th class="text-white" width="12%">Kode Kelas</th>
                                        <th class="text-white" width="15%">Nama Kelas</th>
                                        <th class="text-center text-white" width="12%">Jurusan</th>
                                        <th class="text-center text-white" width="8%">Tingkat</th>
                                        <th class="text-white" width="20%">Wali Kelas</th>
                                        <th class="text-center text-white" width="8%">Siswa</th>
                                        <th class="text-center text-white" width="10%">Status</th>
                                        <th class="text-center text-white" width="10%">Aksi</th>
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

<!-- Debug Panel (Hidden by default) -->
<div id="debug-panel" class="card mt-3" style="display: none;">
    <div class="card-header bg-warning text-dark">
        <h6 class="mb-0"><i class="fas fa-bug me-2"></i>Debug Information</h6>
    </div>
    <div class="card-body">
        <div id="debug-content" style="font-family: monospace; font-size: 0.8rem; max-height: 200px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 4px;">
            <div>Debug panel ready...</div>
        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-secondary" onclick="clearDebugLog()">Clear Log</button>
            <button class="btn btn-sm btn-primary" onclick="testEndpoints()">Test All Endpoints</button>
        </div>
    </div>
</div>

<!-- Debug Toggle Button -->
<button id="debug-toggle" class="btn btn-sm btn-warning position-fixed" style="bottom: 20px; right: 20px; z-index: 1000;" onclick="toggleDebugPanel()">
    <i class="fas fa-bug"></i> Debug
</button>

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<style>
    /* Enhanced Professional Table Styling */
    #mytable {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    }
    
    #mytable th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        border: none;
        padding: 15px 10px;
        position: relative;
    }
    
    #mytable th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #007bff, #0056b3);
    }
    
    #mytable td {
        vertical-align: middle;
        font-size: 0.9rem;
        padding: 12px 10px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }
    
    #mytable tbody tr {
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    #mytable tbody tr:nth-child(even) {
        background: #f8f9fa;
    }
    
    #mytable tbody tr:hover {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.08) 0%, rgba(0, 86, 179, 0.05) 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
    }
    
    /* Form Controls */
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        background: #ffffff;
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
    
    /* Enhanced Badges */
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 12px;
        padding: 6px 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
    }
    
    /* Enhanced Buttons */
    .btn {
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-color: #0056b3;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
    
    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-color: #c82333;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        border-color: #1e7e34;
        color: white;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
    }
    
    /* DataTable Enhancements */
    .dataTables_wrapper {
        padding: 20px 0;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 8px 12px;
        font-size: 0.875rem;
        border-radius: 6px;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #007bff;
        color: white !important;
        border-color: #007bff;
        transform: translateY(-1px);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white !important;
        border-color: #0056b3;
    }
    
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        padding: 6px 12px;
        transition: all 0.3s ease;
    }
    
    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        outline: none;
    }
    
    .dataTables_wrapper .dataTables_info {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    /* Card Enhancements */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .card-header {
        background: linear-gradient(135deg, #495057 0%, #343a40 100%);
        border-radius: 12px 12px 0 0 !important;
        border-bottom: none;
        padding: 20px;
    }
    
    .card-header.bg-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    }
    
    .card-header.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    .card-body {
        padding: 25px;
    }
    
    /* Academic Year Info Styling */
    .bg-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    }
    
    /* Loading Spinner Enhancement */
    .spinner-border {
        width: 2rem;
        height: 2rem;
        animation: spinner-border 0.8s linear infinite;
    }
    
    /* Ensure loading states are visible */
    #mytable tbody td {
        min-height: 60px;
    }
    
    /* Loading row styling */
    .loading-row {
        background: linear-gradient(90deg, #f8f9fa 25%, #e9ecef 50%, #f8f9fa 75%);
        animation: loading-shimmer 1.5s infinite;
    }
    
    @keyframes loading-shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    /* Toast Notifications */
    .toast {
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }
    
    /* Responsive Improvements */
    @media (max-width: 768px) {
        #mytable th, #mytable td {
            padding: 8px 5px;
            font-size: 0.8rem;
        }
        
        .form-select {
            min-width: 120px !important;
        }
        
        .btn {
            padding: 4px 8px;
            font-size: 0.75rem;
        }
    }
    
    /* Statistics Cards */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .card.border-0 {
        transition: all 0.3s ease;
        transform: scale(1);
    }
    
    .card.border-0:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Filter Buttons */
    .btn-outline-light {
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
    }
    
    .btn-outline-light:hover,
    .btn-outline-light.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-color: white;
        color: white;
    }
    
    .btn-group .btn {
        border-radius: 0;
    }
    
    .btn-group .btn:first-child {
        border-radius: 6px 0 0 6px;
    }
    
    .btn-group .btn:last-child {
        border-radius: 0 6px 6px 0;
    }
</style>

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
                        // Show success message
                        showToast('Berhasil', 'Data wali kelas berhasil diperbarui', 'success');
                    } else {
                        showToast('Error', 'Error: ' + result.message, 'error');
                    }
                } catch(e) {
                    console.log('Error parsing response: ' + e.message);
                    loadWalikelasData();
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ' + error);
                showToast('Error', 'Terjadi kesalahan saat mengupdate data', 'error');
            },
            complete: function() {
                // Re-enable dropdown
                $("#guru"+id_wali_kelas).prop('disabled', false);
            }
        });
    }

    $(document).ready(function() {
        debugLog('Document ready - Starting walikelas initialization...');
        console.log('Document ready - Starting walikelas initialization...');
        
        // Show initial loading state
        $('#mytable tbody').html('<tr><td colspan="9" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><div class="mt-2">Memuat data wali kelas...</div></td></tr>');
        
        // Set default active filter
        $('#filter-all').addClass('active');
        
        // Load data with a small delay to ensure DOM is fully ready
        setTimeout(function() {
            debugLog('Starting to load teachers and walikelas data...');
            loadAvailableTeachers();
            loadWalikelasData();
        }, 500);
        
        // Add error fallback - if data doesn't load in 10 seconds, show error
        setTimeout(function() {
            if ($('#mytable tbody tr:first-child td').text().includes('Memuat data')) {
                debugLog('Data loading timeout - showing fallback message');
                console.warn('Data loading timeout - showing fallback message');
                $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-warning py-4"><i class="fas fa-exclamation-triangle me-2"></i>Data membutuhkan waktu lebih lama untuk dimuat. <button class="btn btn-sm btn-primary ms-2" onclick="loadWalikelasData()">Coba Lagi</button><button class="btn btn-sm btn-secondary ms-2" onclick="loadSimpleWalikelasData()">Mode Sederhana</button></td></tr>');
            }
        }, 10000);
    });
    
    function loadAvailableTeachers() {
        console.log('Loading available teachers...');
        
        $.ajax({
            url: '<?php echo base_url('walikelas/get_available_teachers'); ?>',
            type: 'GET',
            dataType: 'json',
            timeout: 15000,
            success: function(teachers) {
                console.log('Teachers loaded successfully:', teachers);
                if (teachers && !teachers.error) {
                    availableTeachers = teachers;
                } else {
                    console.error('Error loading teachers:', teachers.error || 'Unknown error');
                    availableTeachers = [];
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading teachers:', error);
                console.error('Response:', xhr.responseText);
                availableTeachers = [];
            }
        });
    }

    function loadWalikelasData() {
        console.log('Starting to load walikelas data...');
        
        $.ajax({
            url: '<?php echo base_url('walikelas/get_walikelas_data'); ?>',
            type: 'GET',
            dataType: 'json',
            timeout: 30000, // 30 second timeout
            beforeSend: function() {
                console.log('Sending request to load walikelas data...');
            },
            success: function(data) {
                try {
                    console.log('Data received successfully:', data);
                    
                    // Check if data has error
                    if (data.error) {
                        console.error('Server returned error:', data.error);
                        $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>' + data.error + '</td></tr>');
                        return;
                    }
                    
                    var html = '';

                    if (!data || data.length === 0) {
                        html = '<tr><td colspan="9" class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada data wali kelas untuk tahun akademik aktif</td></tr>';
                        console.log('No walikelas data found');
                    } else {
                        console.log('Processing', data.length, 'walikelas records');
                        
                        for(var i = 0; i < data.length; i++) {
                            var walikelas = data[i];
                            console.log('Processing walikelas', i, walikelas);
                            
                            html += '<tr class="border-bottom">';
                            html += '<td class="text-center align-middle text-muted fw-bold">' + (i+1) + '</td>';
                            html += '<td class="align-middle"><span class="badge bg-secondary text-white">' + (walikelas.kode_kelas || '-') + '</span></td>';
                            html += '<td class="align-middle"><strong class="text-primary">' + (walikelas.nama_kelas || '-') + '</strong></td>';
                            html += '<td class="text-center align-middle"><span class="text-dark fw-semibold">' + (walikelas.nama_jurusan || '-') + '</span></td>';
                            html += '<td class="text-center align-middle"><span class="badge bg-info text-white">' + (walikelas.nama_tingkatan || '-') + '</span></td>';
                            html += '<td class="align-middle">' + getTeacherSelect(walikelas.id_wali_kelas, walikelas.id_guru, walikelas.nama_guru, walikelas.nip) + '</td>';
                            html += '<td class="text-center align-middle"><span class="badge bg-primary text-white">' + (walikelas.jumlah_siswa || '0') + ' Siswa</span></td>';
                            html += '<td class="text-center align-middle">' + getStatusBadge(walikelas.status) + '</td>';
                            html += '<td class="text-center align-middle">';
                            html += '<div class="btn-group" role="group">';
                            html += '<a href="<?php echo base_url('walikelas/edit/'); ?>' + walikelas.id_wali_kelas + '" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>';
                            html += '<a href="<?php echo base_url('walikelas/delete/'); ?>' + walikelas.id_wali_kelas + '" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm(\'Apakah Anda yakin ingin menghapus wali kelas ini?\')"><i class="fas fa-trash"></i></a>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        }
                    }

                    $('#mytable tbody').html(html);
                    console.log('Table HTML updated successfully');
                    
                    // Update statistics
                    updateStatistics(data || []);
                    
                    // Initialize DataTable if not already initialized
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
                        "order": [[4, "asc"], [3, "asc"], [2, "asc"]],
                        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                        "initComplete": function(settings, json) {
                            $('.dataTables_filter input').addClass('form-control form-control-sm');
                            $('.dataTables_length select').addClass('form-select form-select-sm');
                            console.log('DataTable initialized successfully');
                        }
                    });
                    
                } catch(e) {
                    console.error('Error parsing data:', e);
                    $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>Error parsing data: ' + e.message + '</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);
                
                var errorMessage = 'Error loading data: ' + error;
                if (xhr.status === 0) {
                    errorMessage = 'Connection error. Please check if the server is running.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Data endpoint not found (404).';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error (500). Please check server logs.';
                }
                
                $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>' + errorMessage + '</td></tr>');
            },
            complete: function() {
                console.log('AJAX request completed');
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
            return '<span class="badge bg-success text-white px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i>Aktif</span>';
        } else {
            return '<span class="badge bg-secondary text-white px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i>Nonaktif</span>';
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
        
        // Update the statistics cards with animation
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
    
    // Simple fallback loading function for debugging
    function loadSimpleWalikelasData() {
        console.log('Loading simple walikelas data as fallback...');
        
        $.get('<?php echo base_url('walikelas/get_simple_walikelas_data'); ?>')
        .done(function(data) {
            console.log('Simple data loaded:', data);
            
            if (typeof data === 'string') {
                try {
                    data = JSON.parse(data);
                } catch (e) {
                    console.error('Failed to parse simple data:', e);
                    return;
                }
            }
            
            var html = '';
            if (data && data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    html += '<tr>';
                    html += '<td class="text-center">' + (i + 1) + '</td>';
                    html += '<td>-</td>'; // kode_kelas
                    html += '<td>Kelas ID: ' + (item.id_kelas || '-') + '</td>';
                    html += '<td>-</td>'; // jurusan
                    html += '<td>-</td>'; // tingkatan
                    html += '<td>Guru ID: ' + (item.id_guru || 'Belum ditugaskan') + '</td>';
                    html += '<td class="text-center">-</td>'; // siswa
                    html += '<td class="text-center"><span class="badge bg-' + (item.status === 'aktif' ? 'success' : 'secondary') + '">' + (item.status || 'unknown') + '</span></td>';
                    html += '<td class="text-center">-</td>'; // aksi
                    html += '</tr>';
                }
            } else {
                html = '<tr><td colspan="9" class="text-center">Tidak ada data (simple mode)</td></tr>';
            }
            
            $('#mytable tbody').html(html);
            
            // Simple DataTable initialization
            if ($.fn.dataTable.isDataTable('#mytable')) {
                $('#mytable').DataTable().destroy();
            }
            $('#mytable').DataTable({
                "pageLength": 10,
                "ordering": false,
                "info": true
            });
        })
        .fail(function(xhr, status, error) {
            console.error('Simple data loading failed:', error);
            $('#mytable tbody').html('<tr><td colspan="9" class="text-center text-danger">Error loading simple data: ' + error + '</td></tr>');
        });
    }
    
    function filterTable(type) {
        // Update active button
        $('.btn-group button').removeClass('active');
        $('#filter-' + type).addClass('active');
        
        if ($.fn.dataTable.isDataTable('#mytable')) {
            var table = $('#mytable').DataTable();
            
            if (type === 'all') {
                table.search('').draw();
            } else if (type === 'assigned') {
                table.column(5).search('(?!.*Pilih Guru)', true, false).draw();
            } else if (type === 'unassigned') {
                table.column(5).search('Pilih Guru', false, false).draw();
            }
        }
            
        // Debug functions
        function debugLog(message) {
            var timestamp = new Date().toLocaleTimeString();
            var debugContent = document.getElementById('debug-content');
            if (debugContent) {
                debugContent.innerHTML += '<div>[' + timestamp + '] ' + message + '</div>';
                debugContent.scrollTop = debugContent.scrollHeight;
            }
            console.log('[DEBUG] ' + message);
        }
            
        function clearDebugLog() {
            var debugContent = document.getElementById('debug-content');
            if (debugContent) {
                debugContent.innerHTML = '<div>Debug log cleared...</div>';
            }
        }
            
        function toggleDebugPanel() {
            var panel = document.getElementById('debug-panel');
            if (panel) {
                panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
            }
        }
            
        function testEndpoints() {
            debugLog('Testing all endpoints...');
                
            // Test connection
            $.get('<?php echo base_url('walikelas/test_connection'); ?>')
            .done(function(data) {
                debugLog('✓ Connection test: ' + JSON.stringify(data));
            })
            .fail(function(xhr, status, error) {
                debugLog('✗ Connection test failed: ' + error);
            });
                
            // Test simple data
            $.get('<?php echo base_url('walikelas/get_simple_walikelas_data'); ?>')
            .done(function(data) {
                debugLog('✓ Simple data test: ' + data.length + ' records');
            })
            .fail(function(xhr, status, error) {
                debugLog('✗ Simple data test failed: ' + error);
            });
                
            // Test full data
            $.get('<?php echo base_url('walikelas/get_walikelas_data'); ?>')
            .done(function(data) {
                debugLog('✓ Full data test: ' + (data.length || 'unknown') + ' records');
            })
            .fail(function(xhr, status, error) {
                debugLog('✗ Full data test failed: ' + error);
            });
                
            // Test teachers
            $.get('<?php echo base_url('walikelas/get_available_teachers'); ?>')
            .done(function(data) {
                debugLog('✓ Teachers test: ' + (data.length || 'unknown') + ' teachers');
            })
            .fail(function(xhr, status, error) {
                debugLog('✗ Teachers test failed: ' + error);
            });
        }
    }

    // Toast notification function
    function showToast(title, message, type) {
        // Create toast element
        var toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}</strong><br>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        // Add to toast container
        if ($('#toast-container').length === 0) {
            $('body').append('<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>');
        }
        
        $('#toast-container').append(toastHtml);
        
        // Show toast
        var toastEl = $('#toast-container .toast:last');
        var toast = new bootstrap.Toast(toastEl[0], {delay: 3000});
        toast.show();
        
        // Remove toast after it's hidden
        toastEl.on('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
</script>