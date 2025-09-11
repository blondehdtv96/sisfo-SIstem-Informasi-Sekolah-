<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-key"></i> Ubah Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('profile'); ?>">Profil</a></li>
                    <li class="breadcrumb-item active">Ubah Password</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lock"></i> Ganti Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Password minimal 6 karakter</li>
                                <li>Gunakan kombinasi huruf, angka dan simbol untuk keamanan yang lebih baik</li>
                                <li>Jangan gunakan password yang mudah ditebak</li>
                            </ul>
                        </div>

                        <?php echo form_open('profile/change_password', ['class' => 'form-horizontal']); ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control <?php echo form_error('current_password') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Masukkan password lama">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                                <?php if (form_error('current_password')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('current_password'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password"
                                       class="form-control <?php echo form_error('new_password') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Masukkan password baru (minimal 6 karakter)">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                                <?php if (form_error('new_password')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('new_password'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password"
                                       class="form-control <?php echo form_error('confirm_password') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Ulangi password baru">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">
                                    <i class="fas fa-eye" id="confirm_password_icon"></i>
                                </button>
                                <?php if (form_error('confirm_password')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('confirm_password'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo base_url('profile'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Ubah Password
                            </button>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-shield-alt"></i> Tips Keamanan Password
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success"><i class="fas fa-check"></i> Yang Sebaiknya Dilakukan:</h6>
                                <ul class="small">
                                    <li>Gunakan minimal 8 karakter</li>
                                    <li>Kombinasi huruf besar dan kecil</li>
                                    <li>Sertakan angka dan simbol</li>
                                    <li>Ganti password secara berkala</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger"><i class="fas fa-times"></i> Yang Sebaiknya Dihindari:</h6>
                                <ul class="small">
                                    <li>Tanggal lahir atau nama sendiri</li>
                                    <li>Password yang mudah ditebak</li>
                                    <li>Menggunakan password sama di semua akun</li>
                                    <li>Membagikan password ke orang lain</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.card-header {
    border-top-left-radius: 8px !important;
    border-top-right-radius: 8px !important;
}

.input-group .btn {
    border-left: none;
}

.form-control:focus + .btn {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    let strengthText = '';
    let strengthClass = '';
    
    switch(strength) {
        case 0:
        case 1:
            strengthText = 'Lemah';
            strengthClass = 'text-danger';
            break;
        case 2:
            strengthText = 'Sedang';
            strengthClass = 'text-warning';
            break;
        case 3:
            strengthText = 'Kuat';
            strengthClass = 'text-info';
            break;
        case 4:
            strengthText = 'Sangat Kuat';
            strengthClass = 'text-success';
            break;
    }
    
    // Remove existing strength indicator
    const existingIndicator = document.querySelector('.password-strength');
    if (existingIndicator) {
        existingIndicator.remove();
    }
    
    // Add new strength indicator
    if (password.length > 0) {
        const indicator = document.createElement('small');
        indicator.className = `password-strength ${strengthClass} d-block mt-1`;
        indicator.innerHTML = `<i class="fas fa-info-circle"></i> Kekuatan password: ${strengthText}`;
        this.parentNode.appendChild(indicator);
    }
});
</script>