<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?> - SISFO SMK Bina Mandiri</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <link href="<?php echo base_url('assets/css/admin-style.css'); ?>" rel="stylesheet">
    
    <!-- Force Black Table Text Override -->
    <style>
        /* CRITICAL: Force all table text to be black */
        table, table *, .table, .table *, .datatable, .datatable *,
        table td, table th, table tr, .table td, .table th, .table tr,
        .dataTables_wrapper table, .dataTables_wrapper table *,
        .dataTables_wrapper .table, .dataTables_wrapper .table *,
        [class*="table"] *, [id*="table"] * {
            color: #000000 !important;
        }
        
        /* Bootstrap table overrides */
        .table-primary, .table-primary *, .table-secondary, .table-secondary *,
        .table-success, .table-success *, .table-danger, .table-danger *,
        .table-warning, .table-warning *, .table-info, .table-info *,
        .table-light, .table-light *, .table-dark, .table-dark * {
            color: #000000 !important;
        }
        
        /* DataTables specific */
        .dataTables_wrapper, .dataTables_wrapper *,
        .dataTables_length, .dataTables_length *,
        .dataTables_filter, .dataTables_filter *,
        .dataTables_info, .dataTables_info *,
        .dataTables_paginate, .dataTables_paginate * {
            color: #000000 !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-graduation-cap"></i> <span>SISFO</span></h3>
            <p class="mb-0"><small>SMK Bina Mandiri</small></p>
        </div>
        
        <ul class="sidebar-nav">
            <?php
            $current_url = uri_string();
            $user_level = $this->session->userdata('id_level_user');
            
            // Menu structure based on user level
            $menu_items = [];
            
            if ($user_level == 1) { // Administrator
                $menu_items = [
                    ['Dashboard', 'dashboard', 'fas fa-tachometer-alt', []],
                    ['Master Data', '#', 'fas fa-database', [
                        ['Mata Pelajaran', 'matapelajaran', 'fas fa-book'],
                        ['Tingkatan Kelas', 'tingkatan', 'fas fa-layer-group'],
                        ['Jurusan', 'jurusan', 'fas fa-graduation-cap'],
                        ['Kelas', 'kelas', 'fas fa-users'],
                        ['Tahun Ajar', 'tahunakademik', 'fas fa-calendar']
                    ]],
                    ['Manajemen Data', '#', 'fas fa-folder-open', [
                        ['Data Siswa', 'siswa', 'fas fa-user-graduate'],
                        ['Data Guru', 'guru', 'fas fa-chalkboard-teacher'],
                        ['Guru Mata Pelajaran', 'guru_mapel', 'fas fa-chalkboard-teacher'],
                        ['Data Wali Kelas', 'walikelas', 'fas fa-user-tie'],
                        ['Data User/Admin', 'user', 'fas fa-user-cog']
                    ]],
                    ['Laporan', '#', 'fas fa-file-alt', [
                        ['Laporan Siswa', 'laporan/siswa', 'fas fa-users'],
                        ['Laporan Guru', 'laporan/guru', 'fas fa-chalkboard-teacher'],
                        ['Laporan Kelas', 'laporan/kelas', 'fas fa-school']
                    ]],
                    ['Pengaturan', '#', 'fas fa-cog', [
                        ['Profile User', 'profile', 'fas fa-user-edit'],
                        ['Ubah Password', 'change_password', 'fas fa-key']
                    ]]
                ];
            } elseif ($user_level == 2) { // Wali Kelas
                $menu_items = [
                    ['Dashboard', 'dashboard', 'fas fa-tachometer-alt', []],
                    ['Data Siswa', 'siswa', 'fas fa-user-graduate', []],
                    ['Laporan', '#', 'fas fa-file-alt', [
                        ['Laporan Siswa', 'laporan/siswa', 'fas fa-users']
                    ]],
                    ['Pengaturan', '#', 'fas fa-cog', [
                        ['Profile User', 'profile', 'fas fa-user-edit'],
                        ['Ubah Password', 'change_password', 'fas fa-key']
                    ]]
                ];
            } elseif ($user_level == 3) { // Guru
                $menu_items = [
                    ['Dashboard', 'dashboard', 'fas fa-tachometer-alt', []],
                    ['Data Siswa', 'siswa', 'fas fa-user-graduate', []],
                    ['Input Nilai', 'nilai', 'fas fa-edit', []],
                    ['Pengaturan', '#', 'fas fa-cog', [
                        ['Profile User', 'profile', 'fas fa-user-edit'],
                        ['Ubah Password', 'change_password', 'fas fa-key']
                    ]]
                ];
            } elseif ($user_level == 4) { // Siswa
                $menu_items = [
                    ['Dashboard', 'dashboard', 'fas fa-tachometer-alt', []],
                    ['Jadwal Pelajaran', 'jadwal', 'fas fa-calendar-alt', []],
                    ['Nilai Saya', 'nilai', 'fas fa-chart-line', []],
                    ['Biodata', 'profile', 'fas fa-user', []],
                    ['Pengaturan', '#', 'fas fa-cog', [
                        ['Ubah Password', 'change_password', 'fas fa-key']
                    ]]
                ];
            }
            
            foreach ($menu_items as $item) {
                $name = $item[0];
                $link = $item[1];
                $icon = $item[2];
                $submenu = $item[3];
                
                $active_class = ($current_url == $link || strpos($current_url, $link) === 0) ? 'active' : '';
                
                if (empty($submenu)) {
                    echo '<li><a href="' . base_url($link) . '" class="' . $active_class . '">';
                    echo '<i class="' . $icon . '"></i><span>' . $name . '</span></a></li>';
                } else {
                    echo '<li>';
                    echo '<a href="#" data-toggle="submenu" class="' . $active_class . '">';
                    echo '<i class="' . $icon . '"></i><span>' . $name . '</span>';
                    echo '<i class="fas fa-chevron-right ms-auto"></i></a>';
                    echo '<ul class="submenu">';
                    
                    foreach ($submenu as $sub) {
                        $sub_name = $sub[0];
                        $sub_link = $sub[1];
                        $sub_icon = $sub[2];
                        $sub_active = ($current_url == $sub_link) ? 'active' : '';
                        
                        echo '<li><a href="' . base_url($sub_link) . '" class="' . $sub_active . '">';
                        echo '<i class="' . $sub_icon . '"></i><span>' . $sub_name . '</span></a></li>';
                    }
                    
                    echo '</ul></li>';
                }
            }
            ?>
        </ul>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                        <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
                            <?php foreach ($breadcrumb as $crumb): ?>
                                <?php if (isset($crumb['url'])): ?>
                                    <li class="breadcrumb-item"><a href="<?php echo $crumb['url']; ?>"><?php echo $crumb['title']; ?></a></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active"><?php echo $crumb['title']; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="breadcrumb-item active">Dashboard</li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
            
            <div class="header-right">
                <!-- User Dropdown -->
                <div class="dropdown user-dropdown">
                    <div class="user-info" data-toggle="dropdown">
                        <img src="<?php echo base_url('assets/img/default-avatar.svg'); ?>" alt="User" class="user-avatar">
                        <div class="user-details d-none d-md-block">
                            <span class="user-name"><?php echo $this->session->userdata('nama_lengkap'); ?></span>
                            <small class="user-role d-block text-muted">
                                <?php 
                                $level_names = [1 => 'Administrator', 2 => 'Wali Kelas', 3 => 'Guru', 4 => 'Siswa'];
                                echo $level_names[$user_level] ?? 'User';
                                ?>
                            </small>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Akun Saya</h6></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('change_password'); ?>"><i class="fas fa-key me-2"></i>Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?php echo base_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" data-auto-dismiss="5000">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" data-auto-dismiss="7000">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <!-- Page Content -->
            <?php echo isset($contents) ? $contents : ''; ?>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url('assets/js/admin-script.js'); ?>"></script>
    
    <!-- Force Black Table Text Script -->
    <script>
        $(document).ready(function() {
            // Force black text in all tables
            function forceBlackTableText() {
                $('table, .table, .datatable').find('*').css({
                    'color': '#000000 !important'
                });
                
                $('table, .table, .datatable').css({
                    'color': '#000000 !important'
                });
                
                // Specifically target DataTables elements
                $('.dataTables_wrapper').find('*').css({
                    'color': '#000000 !important'
                });
            }
            
            // Apply immediately
            forceBlackTableText();
            
            // Apply after any AJAX calls or dynamic content loading
            $(document).ajaxComplete(function() {
                setTimeout(forceBlackTableText, 100);
            });
            
            // Apply periodically to catch any missed elements
            setInterval(forceBlackTableText, 1000);
        });
    </script>
</body>
</html>