<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SISFO SMK Bina Mandiri</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: 2.5rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .login-footer {
            text-align: center;
            padding: 1rem 2.5rem 2.5rem;
            color: #6c757d;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1.5rem;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .login-tabs {
            border-bottom: none;
            margin-bottom: 1.5rem;
        }
        
        .login-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            margin-right: 0.5rem;
        }
        
        .login-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .school-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
            text-align: center;
            color: white;
        }
        
        .school-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        
        .school-info p {
            margin: 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-container">
                    <div class="login-header">
                        <i class="fas fa-graduation-cap fa-2x mb-3"></i>
                        <h1>SISFO</h1>
                        <p>Sistem Informasi Sekolah<br>SMK Bina Mandiri</p>
                    </div>
                    
                    <div class="login-body">
                        <!-- Login Tabs -->
                        <ul class="nav nav-pills login-tabs justify-content-center" id="loginTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin-login" type="button" role="tab">
                                    <i class="fas fa-user-tie me-1"></i> Admin/Guru
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="student-tab" data-bs-toggle="pill" data-bs-target="#student-login" type="button" role="tab">
                                    <i class="fas fa-user-graduate me-1"></i> Siswa
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Flash Messages -->
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('info')): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <?php echo $this->session->flashdata('info'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Tab Content -->
                        <div class="tab-content" id="loginTabContent">
                            <!-- Admin/Guru Login -->
                            <div class="tab-pane fade show active" id="admin-login" role="tabpanel">
                                <?php echo form_open('auth/login', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="admin-username" name="username" placeholder="Username" required>
                                        <label for="admin-username"><i class="fas fa-user me-2"></i>Username</label>
                                        <div class="invalid-feedback">
                                            Username harus diisi.
                                        </div>
                                    </div>
                                    
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="admin-password" name="password" placeholder="Password" required>
                                        <label for="admin-password"><i class="fas fa-lock me-2"></i>Password</label>
                                        <div class="invalid-feedback">
                                            Password harus diisi.
                                        </div>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember-admin">
                                        <label class="form-check-label" for="remember-admin">
                                            Ingat saya selama 30 hari
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-login">
                                        <i class="fas fa-sign-in-alt me-2"></i>LOGIN SEBAGAI ADMIN/GURU
                                    </button>
                                <?php echo form_close(); ?>
                            </div>
                            
                            <!-- Student Login -->
                            <div class="tab-pane fade" id="student-login" role="tabpanel">
                                <?php echo form_open('auth/login', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="student-nisn" name="username" placeholder="NISN" pattern="[0-9]{10}" maxlength="10" required>
                                        <label for="student-nisn"><i class="fas fa-id-card me-2"></i>NISN (10 Digit)</label>
                                        <div class="invalid-feedback">
                                            NISN harus 10 digit angka.
                                        </div>
                                    </div>
                                    
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="student-password" name="password" placeholder="Password" required>
                                        <label for="student-password"><i class="fas fa-lock me-2"></i>Password</label>
                                        <div class="invalid-feedback">
                                            Password harus diisi.
                                        </div>
                                        <div class="form-text mt-2">
                                            <small class="text-muted">Default password adalah NISN Anda</small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember-student">
                                        <label class="form-check-label" for="remember-student">
                                            Ingat saya selama 30 hari
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-login">
                                        <i class="fas fa-sign-in-alt me-2"></i>LOGIN SEBAGAI SISWA
                                    </button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="login-footer">
                        <small>&copy; <?php echo date('Y'); ?> SMK Bina Mandiri. All rights reserved.</small>
                    </div>
                </div>
                
                <!-- School Info -->
                <div class="school-info">
                    <h3><i class="fas fa-school me-2"></i>SMK Bina Mandiri</h3>
                    <p>Membangun Generasi Terampil dan Berkarakter</p>
                    <hr style="border-color: rgba(255,255,255,0.3); margin: 1rem 0;">
                    <small>
                        <i class="fas fa-map-marker-alt me-1"></i> Jl. Pendidikan No. 123, Kota<br>
                        <i class="fas fa-phone me-1"></i> (021) 123-4567<br>
                        <i class="fas fa-envelope me-1"></i> info@smkbinamandiri.sch.id
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        
        // Auto-fill NISN validation
        document.getElementById('student-nisn').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); // Only numbers
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            e.target.value = value;
        });
        
        // Auto-focus password when NISN is complete
        document.getElementById('student-nisn').addEventListener('keyup', function(e) {
            if (e.target.value.length === 10) {
                document.getElementById('student-password').focus();
            }
        });
        
        // Tab switching focus management
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function(e) {
                setTimeout(function() {
                    const activePane = document.querySelector(e.target.getAttribute('data-bs-target'));
                    const firstInput = activePane.querySelector('input[type="text"]');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 100);
            });
        });
        
        // Auto-focus first input on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('admin-username').focus();
        });
    </script>
</body>
</html>