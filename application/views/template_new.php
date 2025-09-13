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
    
    <!-- Professional Sidebar & Navbar Styling -->
    <style>
        /* Enhanced Sidebar Styling */
        .sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #1a2530 100%);
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 15px;
            text-align: center;
        }
        
        .sidebar-header h3 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        
        .sidebar-header p small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }
        
        .sidebar-nav {
            padding: 15px 0;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }
        
        .sidebar-nav li {
            margin-bottom: 5px;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }
        
        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-left: 3px solid #007bff;
        }
        
        .sidebar-nav a.active {
            background: rgba(0, 123, 255, 0.2);
            color: #ffffff;
            border-left: 3px solid #007bff;
        }
        
        .sidebar-nav a i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 15px;
        }
        
        .sidebar-nav .submenu {
            background: rgba(0, 0, 0, 0.2);
            padding: 10px 0;
            margin-top: 5px;
        }
        
        .sidebar-nav .submenu li a {
            padding: 10px 20px 10px 50px;
            font-size: 0.9rem;
            font-weight: 400;
            border-left: none;
        }
        
        .sidebar-nav .submenu li a:hover {
            background: rgba(255, 255, 255, 0.05);
            border-left: none;
        }
        
        .sidebar-nav .submenu li a.active {
            background: rgba(0, 123, 255, 0.15);
        }
        
        /* Collapsed Sidebar */
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar.collapsed .sidebar-header h3 span,
        .sidebar.collapsed .sidebar-header p,
        .sidebar.collapsed .sidebar-nav span,
        .sidebar.collapsed .sidebar-nav .submenu {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-nav a {
            justify-content: center;
            padding: 15px 10px;
        }
        
        .sidebar.collapsed .sidebar-nav a i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        
        /* Enhanced Header Styling */
        .header {
            background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e9ecef;
            height: 60px;
        }
        
        .sidebar-toggle {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .breadcrumb-custom {
            background: rgba(0, 123, 255, 0.1);
            padding: 8px 15px;
            border-radius: 6px;
        }
        
        .breadcrumb-custom a {
            color: #007bff;
            font-weight: 500;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }
        
        /* Enhanced User Dropdown */
        .user-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 15px;
            transition: all 0.3s ease;
            min-width: 180px;
        }
        
        .user-info:hover {
            background: #007bff;
            border-color: #007bff;
        }
        
        .user-info:hover .user-name,
        .user-info:hover .user-role,
        .user-info:hover .fa-chevron-down {
            color: white !important;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border: 2px solid #007bff;
        }
        
        .user-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            margin-top: 10px;
        }
        
        .dropdown-header {
            padding: 8px 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: rgba(0, 123, 255, 0.1);
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .user-details {
                display: none;
            }
        }
        
        /* Force Black Table Text Override */
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
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay"></div>
    
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
            
            foreach ($menu_items as $index => $item) {
                $name = $item[0];
                $link = $item[1];
                $icon = $item[2];
                $submenu = $item[3];
                
                $active_class = ($current_url == $link || strpos($current_url, $link) === 0) ? 'active' : '';
                
                if (empty($submenu)) {
                    echo '<li><a href="' . base_url($link) . '" class="' . $active_class . '">';
                    echo '<i class="' . $icon . '"></i><span>' . $name . '</span></a></li>';
                } else {
                    $submenu_id = 'submenu-' . $index . '-' . str_replace(['/', ' '], ['-', '-'], strtolower($name));
                    echo '<li>';
                    echo '<a href="#" data-bs-toggle="collapse" data-bs-target="#' . $submenu_id . '" class="' . $active_class . '" role="button" aria-expanded="false">';
                    echo '<i class="' . $icon . '"></i><span>' . $name . '</span>';
                    echo '<i class="fas fa-chevron-right ms-auto"></i></a>';
                    echo '<ul class="submenu collapse" id="' . $submenu_id . '">';
                    
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
        <header class="header d-flex align-items-center">
            <div class="header-left d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebar-toggle" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom mb-0">
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
            
            <div class="header-right ms-auto">
                <!-- User Dropdown -->
                <div class="dropdown user-dropdown">
                    <button class="btn user-info d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url('assets/img/default-avatar.svg'); ?>" alt="User" class="user-avatar rounded-circle">
                        <div class="user-details d-none d-md-block ms-2 text-start">
                            <span class="user-name d-block"><?php echo $this->session->userdata('nama_lengkap'); ?></span>
                            <small class="user-role d-block text-muted">
                                <?php 
                                $level_names = [1 => 'Administrator', 2 => 'Wali Kelas', 3 => 'Guru', 4 => 'Siswa'];
                                echo $level_names[$user_level] ?? 'User';
                                ?>
                            </small>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                    
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
    
    <!-- Enhanced Professional Sidebar & Navbar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced sidebar toggle functionality
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (toggleBtn && sidebar && mainContent) {
                // Create overlay if it doesn't exist
                if (!overlay) {
                    const newOverlay = document.createElement('div');
                    newOverlay.className = 'sidebar-overlay';
                    document.body.appendChild(newOverlay);
                }
                
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isMobile = window.innerWidth <= 768;
                    
                    if (isMobile) {
                        sidebar.classList.toggle('show');
                        document.querySelector('.sidebar-overlay').classList.toggle('show');
                        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                    } else {
                        sidebar.classList.toggle('collapsed');
                        mainContent.classList.toggle('expanded');
                        
                        // Save state
                        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
                    }
                });
                
                // Close sidebar when clicking overlay
                document.querySelector('.sidebar-overlay').addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    this.classList.remove('show');
                    document.body.style.overflow = '';
                });
                
                // Restore sidebar state
                if (window.innerWidth > 768) {
                    const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                    }
                }
            }
            
            // Enhanced submenu functionality
            const submenuToggles = document.querySelectorAll('.sidebar-nav a[data-bs-toggle="collapse"]');
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get target submenu
                    const targetId = this.getAttribute('data-bs-target');
                    const submenu = document.querySelector(targetId);
                    const icon = this.querySelector('.fa-chevron-right');
                    
                    if (submenu && icon) {
                        // Toggle submenu
                        submenu.classList.toggle('show');
                        
                        // Rotate icon
                        if (submenu.classList.contains('show')) {
                            icon.classList.remove('fa-chevron-right');
                            icon.classList.add('fa-chevron-down');
                        } else {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-right');
                        }
                    }
                });
            });
        });
    </script>
    
    <!-- Force Black Table Text Script -->
    <script>
        $(document).ready(function() {
            console.log('Template loaded - initializing components');
            
            // Initialize Bootstrap 5 components
            if (typeof bootstrap !== 'undefined') {
                console.log('Bootstrap 5 available');
                
                // Initialize all dropdowns
                const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
                const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
                console.log('Dropdowns initialized:', dropdownList.length);
                
                // Initialize all collapses
                const collapseElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="collapse"]'));
                const collapseList = collapseElementList.map(function (collapseToggleEl) {
                    return new bootstrap.Collapse(collapseToggleEl, {
                        toggle: false
                    });
                });
                console.log('Collapses initialized:', collapseList.length);
                
                // Initialize all tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                console.log('Tooltips initialized:', tooltipList.length);
            } else {
                console.error('Bootstrap 5 not available');
            }
            
            // Verify sidebar toggle exists
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            if (sidebarToggle) {
                console.log('Sidebar toggle found and ready');
            } else {
                console.error('Sidebar toggle not found!');
            }
            
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