// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin script loading...');
    
    // Initialize sidebar toggle first
    initSidebarToggle();
    
    // Initialize dropdowns
    initDropdowns();
    
    // Initialize tooltips
    initTooltips();
    
    // Initialize data tables
    initDataTables();
    
    // Initialize form validation
    initFormValidation();
    
    // Initialize alerts auto-hide
    initAlerts();
    
    console.log('Admin script initialization complete');
});

// Sidebar Toggle Functionality
function initSidebarToggle() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    
    if (!toggleBtn || !sidebar || !mainContent) {
        console.warn('Sidebar elements not found');
        return;
    }
    
    // Create overlay for mobile
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }
    
    // Toggle function
    function toggleSidebar() {
        const isMobile = window.innerWidth <= 768;
        console.log('Toggle sidebar called - isMobile:', isMobile);
        
        if (isMobile) {
            // Mobile behavior
            const isVisible = sidebar.classList.contains('show');
            console.log('Mobile mode - sidebar currently visible:', isVisible);
            if (isVisible) {
                hideMobileSidebar();
            } else {
                showMobileSidebar();
            }
        } else {
            // Desktop behavior
            const isCollapsed = sidebar.classList.contains('collapsed');
            console.log('Desktop mode - sidebar currently collapsed:', isCollapsed);
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to localStorage
            const newCollapsedState = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', newCollapsedState);
            console.log('Desktop sidebar toggled - new collapsed state:', newCollapsedState);
        }
    }
    
    // Show mobile sidebar
    function showMobileSidebar() {
        console.log('Showing mobile sidebar');
        sidebar.classList.add('show');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    // Hide mobile sidebar
    function hideMobileSidebar() {
        console.log('Hiding mobile sidebar');
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }
    
    // Add click event to toggle button
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Sidebar toggle clicked - Window width:', window.innerWidth);
        toggleSidebar();
    });
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            hideMobileSidebar();
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const isMobile = window.innerWidth <= 768;
        
        if (!isMobile) {
            // Desktop mode - hide mobile sidebar and overlay
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
            
            // Restore desktop state
            const savedState = localStorage.getItem('sidebar-collapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        } else {
            // Mobile mode - ensure proper mobile state
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    });
    
    // Restore sidebar state on load (desktop only)
    if (window.innerWidth > 768) {
        const savedState = localStorage.getItem('sidebar-collapsed');
        if (savedState === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
    }
    
    // Handle submenu toggles - Updated for Bootstrap 5 collapse
    const menuItems = document.querySelectorAll('.sidebar-nav a[data-bs-toggle="collapse"]');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Initialize Bootstrap collapse if available
            if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                const targetId = this.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(targetElement);
                    bsCollapse.toggle();
                }
            }
            
            // Handle icon rotation
            const icon = this.querySelector('i.fa-chevron-down, i.fa-chevron-right');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-right');
            }
        });
    });
    
    // Fallback for old data-toggle submenu items
    const oldMenuItems = document.querySelectorAll('.sidebar-nav a[data-toggle="submenu"]');
    oldMenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('show');
                const icon = this.querySelector('i.fa-chevron-down, i.fa-chevron-right');
                if (icon) {
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-right');
                }
            }
        });
    });
}

// Dropdown Functionality
function initDropdowns() {
    console.log('Initializing dropdowns...');
    
    // Initialize Bootstrap 5 dropdowns
    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
        const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            console.log('Initializing dropdown:', dropdownToggleEl);
            return new bootstrap.Dropdown(dropdownToggleEl, {
                autoClose: true,
                boundary: 'viewport'
            });
        });
        console.log('Bootstrap 5 dropdowns initialized:', dropdownList.length);
    } else {
        console.warn('Bootstrap 5 not available for dropdowns');
    }
    
    // Enhanced fallback for custom dropdown functionality
    const customDropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]:not([data-bs-toggle])');
    
    customDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu !== this.nextElementSibling) {
                    menu.classList.remove('show');
                }
            });
            
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-menu')) {
                dropdown.classList.toggle('show');
            }
        });
    });
    
    // Enhanced click outside handler
    document.addEventListener('click', function(e) {
        // Skip if clicking on dropdown toggle or within dropdown
        if (e.target.matches('[data-toggle="dropdown"]') || 
            e.target.matches('[data-bs-toggle="dropdown"]') ||
            e.target.closest('.dropdown-menu') ||
            e.target.closest('[data-bs-toggle="dropdown"]')) {
            return;
        }
        
        // Close all custom dropdowns (not Bootstrap managed ones)
        const customDropdowns = document.querySelectorAll('.dropdown-menu.show:not([data-bs-popper])');
        customDropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    });
    
    // Prevent dropdown menu from closing when clicking inside
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
}

// Tooltip Initialization
function initTooltips() {
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}

// DataTable Initialization
function initDataTables() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        // Add search and pagination if DataTables library is available
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $(table).DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "Tidak ada data yang cocok"
                }
            });
        }
    });
}

// Form Validation
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    
    // Real-time validation for specific fields
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
}

// Field Validation Helper
function validateField(field) {
    const isValid = field.checkValidity();
    
    if (isValid) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    } else {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
    }
    
    return isValid;
}

// Alert Auto-hide
function initAlerts() {
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
    
    alerts.forEach(alert => {
        const delay = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, delay);
    });
}

// Utility Functions
const AdminUtils = {
    // Show loading spinner
    showLoading: function(element) {
        const spinner = document.createElement('div');
        spinner.className = 'spinner';
        spinner.id = 'loading-spinner';
        
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        
        if (element) {
            element.appendChild(spinner);
        }
    },
    
    // Hide loading spinner
    hideLoading: function(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        
        const spinner = element ? element.querySelector('#loading-spinner') : document.querySelector('#loading-spinner');
        if (spinner) {
            spinner.remove();
        }
    },
    
    // Show alert message
    showAlert: function(message, type = 'info', container = '.content-wrapper') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const containerEl = document.querySelector(container);
        if (containerEl) {
            containerEl.insertBefore(alertDiv, containerEl.firstChild);
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    },
    
    // Confirm dialog
    confirm: function(message, callback) {
        if (confirm(message)) {
            if (typeof callback === 'function') {
                callback();
            }
        }
    },
    
    // AJAX helper
    ajax: function(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        const config = Object.assign(defaultOptions, options);
        
        return fetch(url, config)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                this.showAlert('Terjadi kesalahan saat memproses permintaan.', 'danger');
                throw error;
            });
    },
    
    // Format number with thousands separator
    formatNumber: function(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    },
    
    // Format date
    formatDate: function(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        
        const config = Object.assign(defaultOptions, options);
        return new Intl.DateTimeFormat('id-ID', config).format(new Date(date));
    }
};

// Export for use in other scripts
window.AdminUtils = AdminUtils;

// Note: Mobile sidebar handling is now integrated into initSidebarToggle function

/**
 * SISFO SMK Bina Mandiri - Admin Script
 */
$(document).ready(function() {
    // Sidebar toggle functionality - Updated to work with new system
    $('#sidebar-toggle').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // Let the vanilla JS handler take care of this
    });

    // Submenu toggle - Updated for Bootstrap 5
    $('[data-bs-toggle="collapse"]').click(function(e) {
        e.preventDefault();
        const targetId = $(this).attr('data-bs-target');
        const targetElement = $(targetId);
        const icon = $(this).find('.fa-chevron-right');
        
        // Close other submenus
        $('.submenu.collapse').not(targetElement).removeClass('show');
        $('.fa-chevron-right').not(icon).removeClass('fa-rotate-90');
        
        // Toggle current submenu
        targetElement.toggleClass('show');
        icon.toggleClass('fa-rotate-90');
    });
    
    // Fallback for old submenu toggle
    $('[data-toggle="submenu"]').click(function(e) {
        e.preventDefault();
        const submenu = $(this).next('.submenu');
        const icon = $(this).find('.fa-chevron-right');
        
        // Close other submenus
        $('.submenu').not(submenu).removeClass('show');
        $('.fa-chevron-right').not(icon).removeClass('fa-rotate-90');
        
        // Toggle current submenu
        submenu.toggleClass('show');
        icon.toggleClass('fa-rotate-90');
    });

    // User dropdown - Updated for Bootstrap 5 with better debugging
    $('.user-info[data-bs-toggle="dropdown"]').off('click').on('click', function(e) {
        console.log('User dropdown clicked (Bootstrap 5):', this);
        // Let Bootstrap handle this, but add some debugging
        e.stopPropagation();
    });
    
    // Fallback for old user dropdown with debugging
    $('.user-info:not([data-bs-toggle])').off('click').on('click', function(e) {
        console.log('User dropdown clicked (fallback):', this);
        e.preventDefault();
        e.stopPropagation();
        
        // Close other dropdowns
        $('.dropdown-menu').not($(this).next()).removeClass('show').hide();
        
        // Toggle current dropdown
        const menu = $(this).next('.dropdown-menu');
        if (menu.length) {
            menu.toggleClass('show').toggle();
            console.log('Dropdown menu toggled:', menu.hasClass('show'));
        }
    });

    // Close dropdown when clicking outside - Updated for Bootstrap 5
    $(document).click(function(e) {
        if (!$(e.target).closest('.user-dropdown').length && !$(e.target).closest('[data-bs-toggle="dropdown"]').length) {
            $('.dropdown-menu:not(.show)').hide(); // Only hide non-Bootstrap dropdowns
        }
    });

    // DataTables initialization
    if ($.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25,
            order: [[0, 'asc']]
        });
    }

    // Auto-dismiss alerts
    $('[data-auto-dismiss]').each(function() {
        const alert = $(this);
        const delay = parseInt(alert.data('auto-dismiss'));
        
        setTimeout(function() {
            alert.fadeOut(500, function() {
                $(this).remove();
            });
        }, delay);
    });

    // Form validation enhancement
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Confirm delete dialogs
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const name = $(this).data('name') || 'item ini';
        
        if (confirm(`Apakah Anda yakin ingin menghapus ${name}?`)) {
            window.location.href = url;
        }
    });

    // Loading state for buttons
    $('.btn-loading').click(function() {
        const btn = $(this);
        const originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
        
        setTimeout(function() {
            btn.html(originalText).prop('disabled', false);
        }, 3000);
    });

    // Tooltip initialization
    if ($.fn.tooltip) {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    // Number formatting
    $('.number-format').each(function() {
        const number = parseFloat($(this).text());
        if (!isNaN(number)) {
            $(this).text(number.toLocaleString('id-ID'));
        }
    });

    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut(500);
    }, 5000);
});

// Utility functions
function showLoading(message = 'Loading...') {
    $('body').append(`
        <div class="loading-overlay" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: white;
            font-size: 1.2rem;
        ">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                <div>${message}</div>
            </div>
        </div>
    `);
}

function hideLoading() {
    $('.loading-overlay').remove();
}

function showAlert(type, message, title = '') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${title ? `<strong>${title}</strong> ` : ''}${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('.content-wrapper').prepend(alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert:first-child').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Export function for reports
function exportData(format, url, data = {}) {
    showLoading('Menyiapkan ' + format.toUpperCase() + '...');
    
    const form = $('<form>', {
        method: 'POST',
        action: url,
        target: '_blank'
    });
    
    // Add format
    form.append($('<input>', {
        type: 'hidden',
        name: 'format',
        value: format
    }));
    
    // Add other data
    Object.keys(data).forEach(key => {
        form.append($('<input>', {
            type: 'hidden',
            name: key,
            value: data[key]
        }));
    });
    
    $('body').append(form);
    form.submit();
    form.remove();
    
    setTimeout(hideLoading, 2000);
}