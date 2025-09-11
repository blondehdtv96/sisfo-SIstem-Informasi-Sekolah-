<!-- Edit User Page -->
<div class="page-title">
    <h1><i class="fas fa-user-edit me-3"></i>Edit User/Admin</h1>
    <p class="subtitle">Perbarui informasi akun user atau administrator</p>
</div>

<!-- Form Card -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Form Edit User: 
                    <strong><?php echo htmlspecialchars($user->nama_lengkap); ?></strong>
                </h5>
            </div>
            <div class="card-body">
                <?php echo form_open('user/edit/' . $user->id_user, ['class' => 'needs-validation', 'novalidate' => '']); ?>
                
                <div class="row">
                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>" 
                               id="username" name="username" value="<?php echo set_value('username', $user->username); ?>" 
                               placeholder="Masukkan username" required>
                        <?php if (form_error('username')): ?>
                            <div class="invalid-feedback"><?php echo form_error('username'); ?></div>
                        <?php else: ?>
                            <div class="invalid-feedback">Username harus diisi.</div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Level User -->
                    <div class="col-md-6 mb-3">
                        <label for="id_level" class="form-label">Level User <span class="text-danger">*</span></label>
                        <select class="form-select <?php echo form_error('id_level') ? 'is-invalid' : ''; ?>" 
                                id="id_level" name="id_level" required>
                            <option value="">Pilih Level User</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?php echo $level->id_level; ?>" 
                                        <?php echo set_select('id_level', $level->id_level, $level->id_level == $user->id_level); ?>>
                                    <?php echo htmlspecialchars($level->nama_level); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (form_error('id_level')): ?>
                            <div class="invalid-feedback"><?php echo form_error('id_level'); ?></div>
                        <?php else: ?>
                            <div class="invalid-feedback">Level user harus dipilih.</div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Password Change Section -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Ubah Password:</strong> Kosongkan field password jika tidak ingin mengubah password.
                </div>
                
                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" 
                                   id="password" name="password" placeholder="Kosongkan jika tidak diubah" minlength="6">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php if (form_error('password')): ?>
                                <div class="invalid-feedback"><?php echo form_error('password'); ?></div>
                            <?php endif; ?>
                        </div>
                        <small class="form-text text-muted">Password minimal 6 karakter jika diisi.</small>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?php echo form_error('confirm_password') ? 'is-invalid' : ''; ?>" 
                                   id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php if (form_error('confirm_password')): ?>
                                <div class="invalid-feedback"><?php echo form_error('confirm_password'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php echo form_error('nama_lengkap') ? 'is-invalid' : ''; ?>" 
                           id="nama_lengkap" name="nama_lengkap" value="<?php echo set_value('nama_lengkap', $user->nama_lengkap); ?>" 
                           placeholder="Masukkan nama lengkap" required>
                    <?php if (form_error('nama_lengkap')): ?>
                        <div class="invalid-feedback"><?php echo form_error('nama_lengkap'); ?></div>
                    <?php else: ?>
                        <div class="invalid-feedback">Nama lengkap harus diisi.</div>
                    <?php endif; ?>
                </div>
                
                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" 
                               id="email" name="email" value="<?php echo set_value('email', $user->email); ?>" 
                               placeholder="contoh@email.com">
                        <?php if (form_error('email')): ?>
                            <div class="invalid-feedback"><?php echo form_error('email'); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- No. Telp -->
                    <div class="col-md-6 mb-3">
                        <label for="no_telp" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                               value="<?php echo set_value('no_telp', $user->no_telp); ?>" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
                
                <!-- Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?php echo set_select('status', 'aktif', $user->status == 'aktif'); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo set_select('status', 'nonaktif', $user->status == 'nonaktif'); ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                
                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" 
                              placeholder="Masukkan alamat lengkap"><?php echo set_value('alamat', $user->alamat); ?></textarea>
                </div>
                
                <!-- User Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Informasi User</h6>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <strong>Dibuat:</strong> <?php echo date('d F Y H:i', strtotime($user->created_at)); ?><br>
                                        <strong>Terakhir Update:</strong> <?php echo date('d F Y H:i', strtotime($user->updated_at)); ?><br>
                                        <strong>Login Terakhir:</strong> <?php echo $user->last_login ? date('d F Y H:i', strtotime($user->last_login)) : 'Belum pernah login'; ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo base_url('user'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPassword = document.getElementById('confirm_password');
    const icon = this.querySelector('i');
    
    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password && confirmPassword && password !== confirmPassword) {
        this.classList.add('is-invalid');
        this.parentNode.nextElementSibling.textContent = 'Password tidak cocok';
    } else {
        this.classList.remove('is-invalid');
    }
});

// Password field validation
document.getElementById('password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (this.value === '') {
        confirmPassword.value = '';
        confirmPassword.classList.remove('is-invalid');
    }
});
</script>