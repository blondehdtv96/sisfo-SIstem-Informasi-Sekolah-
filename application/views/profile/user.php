<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-user"></i> Profil Saya</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- User Photo and Basic Info -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-id-card"></i> Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php 
                        $foto_field = ($user_type == 'guru') ? 'foto' : 'foto';
                        $nama_field = ($user_type == 'guru') ? 'nama_guru' : 'nama_lengkap';
                        ?>
                        
                        <?php if (isset($user->$foto_field) && $user->$foto_field && file_exists('./assets/uploads/' . $user_type . '/' . $user->$foto_field)): ?>
                            <img src="<?php echo base_url('assets/uploads/' . $user_type . '/' . $user->$foto_field); ?>" 
                                 alt="Foto <?php echo $user->$nama_field; ?>" 
                                 class="img-fluid rounded-circle shadow mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center shadow mb-3" 
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user text-white fa-4x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h4 class="text-primary"><?php echo $user->$nama_field; ?></h4>
                        
                        <?php if ($user_type == 'guru'): ?>
                            <p class="text-muted mb-2">NIP: <?php echo $user->nip ?? '-'; ?></p>
                            <div class="badge badge-success badge-lg">
                                <i class="fas fa-chalkboard-teacher"></i> Guru
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-2">Username: <?php echo $user->username; ?></p>
                            <div class="badge badge-info badge-lg">
                                <i class="fas fa-user-tie"></i> <?php echo $user->nama_level ?? 'Admin'; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('profile/change_password'); ?>" class="btn btn-outline-warning">
                                <i class="fas fa-key"></i> Ubah Password
                            </a>
                            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <?php if ($user_type == 'guru'): ?>
                                <a href="<?php echo base_url('jadwal'); ?>" class="btn btn-outline-success">
                                    <i class="fas fa-calendar"></i> Jadwal Mengajar
                                </a>
                                <a href="<?php echo base_url('nilai'); ?>" class="btn btn-outline-info">
                                    <i class="fas fa-clipboard-list"></i> Input Nilai
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Profile Form -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit"></i> Edit Profil
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php echo form_open_multipart('profile', ['class' => 'form-horizontal']); ?>
                        
                        <?php if ($user_type == 'guru'): ?>
                            <!-- Guru Profile Fields -->
                            <?php if (isset($user->nip)): ?>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo $user->nip; ?>" readonly class="form-control-plaintext">
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_guru" value="<?php echo set_value('nama_guru', $user->nama_guru); ?>" 
                                           class="form-control <?php echo form_error('nama_guru') ? 'is-invalid' : ''; ?>" 
                                           placeholder="Masukkan nama lengkap">
                                    <?php if (form_error('nama_guru')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('nama_guru'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-5">
                                    <input type="text" name="tempat_lahir" value="<?php echo set_value('tempat_lahir', $user->tempat_lahir ?? ''); ?>" 
                                           class="form-control <?php echo form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                                           placeholder="Tempat lahir">
                                    <?php if (form_error('tempat_lahir')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('tempat_lahir'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-2">
                                    <input type="date" name="tanggal_lahir" value="<?php echo set_value('tanggal_lahir', $user->tanggal_lahir ?? ''); ?>" 
                                           class="form-control <?php echo form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>">
                                    <?php if (form_error('tanggal_lahir')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('tanggal_lahir'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <select name="jenis_kelamin" class="form-control <?php echo form_error('jenis_kelamin') ? 'is-invalid' : ''; ?>">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" <?php echo set_select('jenis_kelamin', 'Laki-Laki', ($user->jenis_kelamin ?? '') == 'Laki-Laki'); ?>>Laki-Laki</option>
                                        <option value="Perempuan" <?php echo set_select('jenis_kelamin', 'Perempuan', ($user->jenis_kelamin ?? '') == 'Perempuan'); ?>>Perempuan</option>
                                    </select>
                                    <?php if (form_error('jenis_kelamin')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('jenis_kelamin'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- User/Admin Profile Fields -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo $user->username; ?>" readonly class="form-control-plaintext">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_lengkap" value="<?php echo set_value('nama_lengkap', $user->nama_lengkap); ?>" 
                                           class="form-control <?php echo form_error('nama_lengkap') ? 'is-invalid' : ''; ?>" 
                                           placeholder="Masukkan nama lengkap">
                                    <?php if (form_error('nama_lengkap')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('nama_lengkap'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="<?php echo set_value('email', $user->email ?? ''); ?>" 
                                           class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" 
                                           placeholder="Alamat email">
                                    <?php if (form_error('email')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('email'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Level User</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo $user->nama_level ?? 'Admin'; ?>" readonly class="form-control-plaintext">
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Common Fields -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">No. Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_telp" value="<?php echo set_value('no_telp', $user->no_telp ?? ''); ?>" 
                                       class="form-control <?php echo form_error('no_telp') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Nomor telepon">
                                <?php if (form_error('no_telp')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('no_telp'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea name="alamat" class="form-control <?php echo form_error('alamat') ? 'is-invalid' : ''; ?>" 
                                          rows="3" placeholder="Alamat lengkap"><?php echo set_value('alamat', $user->alamat ?? ''); ?></textarea>
                                <?php if (form_error('alamat')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('alamat'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Foto</label>
                            <div class="col-sm-9">
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.card-header {
    border-top-left-radius: 8px !important;
    border-top-right-radius: 8px !important;
}

.form-control-plaintext {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
}

@media print {
    .btn, .card-header {
        display: none !important;
    }
    
    .card {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }
}
</style>