// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar toggle
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
});

// Sidebar Toggle Functionality
function initSidebarToggle() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });
    }
    
    // Restore sidebar state
    const savedState = localStorage.getItem('sidebar-collapsed');
    if (savedState === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    }
    
    // Handle submenu toggles
    const menuItems = document.querySelectorAll('.sidebar-nav a[data-toggle="submenu"]');
    menuItems.forEach(item => {
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
    const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.matches('[data-toggle="dropdown"]')) {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
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

// Handle responsive sidebar for mobile
function handleMobileSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    `;
    
    document.body.appendChild(overlay);
    
    // Show sidebar on mobile
    function showMobileSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('show');
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Hide sidebar on mobile
    function hideMobileSidebar() {
        sidebar.classList.remove('show');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }
    
    // Toggle sidebar on mobile
    const mobileToggle = document.querySelector('.sidebar-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('show')) {
                    hideMobileSidebar();
                } else {
                    showMobileSidebar();
                }
            }
        });
    }
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', hideMobileSidebar);
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            hideMobileSidebar();
            sidebar.classList.remove('collapsed');
        }
    });
}

// Initialize mobile sidebar handling
handleMobileSidebar();

/**
 * SISFO SMK Bina Mandiri - Admin Script
 */
$(document).ready(function() {
    // Sidebar toggle functionality
    $('#sidebar-toggle').click(function() {
        $('#sidebar').toggleClass('show');
        $('#main-content').toggleClass('sidebar-collapsed');
    });

    // Submenu toggle
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

    // User dropdown
    $('.user-info').click(function() {
        $(this).next('.dropdown-menu').toggle();
    });

    // Close dropdown when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.user-dropdown').length) {
            $('.dropdown-menu').hide();
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
