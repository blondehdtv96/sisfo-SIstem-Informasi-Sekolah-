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
        <!-- Profile Information Card -->
        <div class="row">
            <div class="col-md-4">
                <!-- Student Photo and Basic Info -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-id-card"></i> Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($siswa->foto && file_exists('./assets/uploads/siswa/' . $siswa->foto)): ?>
                            <img src="<?php echo base_url('assets/uploads/siswa/' . $siswa->foto); ?>" 
                                 alt="Foto <?php echo $siswa->nama_siswa; ?>" 
                                 class="img-fluid rounded-circle shadow mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center shadow mb-3" 
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user text-white fa-4x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h4 class="text-primary"><?php echo $siswa->nama_siswa; ?></h4>
                        <p class="text-muted mb-2">NISN: <?php echo $siswa->nisn; ?></p>
                        <?php if ($siswa->nis): ?>
                            <p class="text-muted mb-2">NIS: <?php echo $siswa->nis; ?></p>
                        <?php endif; ?>
                        
                        <?php if ($siswa->nama_kelas): ?>
                            <div class="badge badge-info badge-lg">
                                <i class="fas fa-graduation-cap"></i> 
                                <?php echo $siswa->nama_kelas; ?>
                                <?php if ($siswa->nama_jurusan): ?>
                                    - <?php echo $siswa->nama_jurusan; ?>
                                <?php endif; ?>
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
                            <a href="<?php echo base_url('nilai'); ?>" class="btn btn-outline-success">
                                <i class="fas fa-chart-line"></i> Lihat Nilai
                            </a>
                            <a href="<?php echo base_url('jadwal'); ?>" class="btn btn-outline-info">
                                <i class="fas fa-calendar"></i> Jadwal Pelajaran
                            </a>
                            <a href="<?php echo base_url('profile/change_password'); ?>" class="btn btn-outline-warning">
                                <i class="fas fa-key"></i> Ubah Password
                            </a>
                            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
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
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">NISN</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $siswa->nisn; ?>" readonly class="form-control-plaintext">
                            </div>
                        </div>

                        <?php if ($siswa->nis): ?>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">NIS</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $siswa->nis; ?>" readonly class="form-control-plaintext">
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_siswa" value="<?php echo set_value('nama_siswa', $siswa->nama_siswa); ?>" 
                                       class="form-control <?php echo form_error('nama_siswa') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Masukkan nama lengkap">
                                <?php if (form_error('nama_siswa')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('nama_siswa'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="tempat_lahir" value="<?php echo set_value('tempat_lahir', $siswa->tempat_lahir); ?>" 
                                       class="form-control <?php echo form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                                       placeholder="Tempat lahir">
                                <?php if (form_error('tempat_lahir')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('tempat_lahir'); ?></div>
                                <?php endif; ?>
                            </div>
                            <label class="col-sm-2 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <input type="date" name="tanggal_lahir" value="<?php echo set_value('tanggal_lahir', $siswa->tanggal_lahir); ?>" 
                                       class="form-control <?php echo form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>">
                                <?php if (form_error('tanggal_lahir')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('tanggal_lahir'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="jenis_kelamin" class="form-control <?php echo form_error('jenis_kelamin') ? 'is-invalid' : ''; ?>">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki" <?php echo set_select('jenis_kelamin', 'Laki-Laki', $siswa->jenis_kelamin == 'Laki-Laki'); ?>>Laki-Laki</option>
                                    <option value="Perempuan" <?php echo set_select('jenis_kelamin', 'Perempuan', $siswa->jenis_kelamin == 'Perempuan'); ?>>Perempuan</option>
                                </select>
                                <?php if (form_error('jenis_kelamin')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('jenis_kelamin'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">No. Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_telp" value="<?php echo set_value('no_telp', $siswa->no_telp); ?>" 
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
                                          rows="3" placeholder="Alamat lengkap"><?php echo set_value('alamat', $siswa->alamat); ?></textarea>
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

                        <?php if ($siswa->nama_kelas): ?>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kelas</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $siswa->nama_kelas; ?>" readonly class="form-control-plaintext">
                            </div>
                        </div>
                        <?php endif; ?>

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