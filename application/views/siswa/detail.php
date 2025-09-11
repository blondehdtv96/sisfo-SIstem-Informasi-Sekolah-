<section class="content">
    <div class="container-fluid">
        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="<?php echo site_url('siswa'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Data Siswa
                </a>
            </div>
        </div>

        <!-- Student Detail Card -->
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <!-- Photo and Basic Info -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> Foto & Identitas
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <?php if ($siswa->foto && file_exists('./assets/uploads/siswa/' . $siswa->foto)): ?>
                                <img src="<?php echo base_url('assets/uploads/siswa/' . $siswa->foto); ?>" 
                                     alt="Foto <?php echo $siswa->nama_siswa; ?>" 
                                     class="img-fluid rounded-circle shadow" 
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-gray-400 rounded-circle d-inline-flex align-items-center justify-content-center shadow" 
                                     style="width: 200px; height: 200px;">
                                    <i class="fas fa-user text-white fa-5x"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 class="text-primary"><?php echo $siswa->nama_siswa; ?></h4>
                        <p class="text-muted mb-1">
                            <strong>NISN:</strong> <?php echo $siswa->nisn; ?>
                        </p>
                        <?php if ($siswa->nis): ?>
                            <p class="text-muted mb-1">
                                <strong>NIS:</strong> <?php echo $siswa->nis; ?>
                            </p>
                        <?php endif; ?>
                        <span class="badge badge-lg <?php echo $siswa->status == 'aktif' ? 'bg-success' : ($siswa->status == 'lulus' ? 'bg-warning' : 'bg-danger'); ?>">
                            <?php echo ucfirst($siswa->status); ?>
                        </span>
                    </div>
                </div>

                <!-- Academic Info Card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-graduation-cap"></i> Informasi Akademik
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Tingkatan:</dt>
                            <dd class="col-sm-6">
                                <span class="badge bg-info"><?php echo $siswa->nama_tingkatan ?: '-'; ?></span>
                            </dd>
                            
                            <dt class="col-sm-6">Kelas:</dt>
                            <dd class="col-sm-6">
                                <strong><?php echo $siswa->nama_kelas ?: 'Belum Ada Kelas'; ?></strong>
                                <?php if ($siswa->kode_kelas): ?>
                                    <br><small class="text-muted"><?php echo $siswa->kode_kelas; ?></small>
                                <?php endif; ?>
                            </dd>
                            
                            <dt class="col-sm-6">Jurusan:</dt>
                            <dd class="col-sm-6">
                                <?php echo $siswa->nama_jurusan ?: 'Belum Ada Jurusan'; ?>
                                <?php if ($siswa->kode_jurusan): ?>
                                    <br><small class="text-muted">(<?php echo $siswa->kode_jurusan; ?>)</small>
                                <?php endif; ?>
                            </dd>
                            
                            <dt class="col-sm-6">Tahun Ajar:</dt>
                            <dd class="col-sm-6"><?php echo $siswa->tahun_ajar ?: '-'; ?></dd>
                            
                            <dt class="col-sm-6">Tanggal Masuk:</dt>
                            <dd class="col-sm-6">
                                <?php echo $siswa->tanggal_masuk ? date('d/m/Y', strtotime($siswa->tanggal_masuk)) : '-'; ?>
                            </dd>
                            
                            <?php if ($siswa->tanggal_keluar): ?>
                                <dt class="col-sm-6">Tanggal Keluar:</dt>
                                <dd class="col-sm-6">
                                    <span class="text-danger">
                                        <?php echo date('d/m/Y', strtotime($siswa->tanggal_keluar)); ?>
                                    </span>
                                </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <!-- Personal Information -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-id-card"></i> Data Pribadi
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama Lengkap:</dt>
                            <dd class="col-sm-8"><?php echo $siswa->nama_siswa; ?></dd>
                            
                            <dt class="col-sm-4">Tempat Lahir:</dt>
                            <dd class="col-sm-8"><?php echo $siswa->tempat_lahir; ?></dd>
                            
                            <dt class="col-sm-4">Tanggal Lahir:</dt>
                            <dd class="col-sm-8">
                                <?php 
                                $tanggal_lahir = date('d/m/Y', strtotime($siswa->tanggal_lahir));
                                $umur = date_diff(date_create($siswa->tanggal_lahir), date_create('today'))->y;
                                echo $tanggal_lahir . ' (' . $umur . ' tahun)';
                                ?>
                            </dd>
                            
                            <dt class="col-sm-4">Jenis Kelamin:</dt>
                            <dd class="col-sm-8">
                                <?php if ($siswa->jenis_kelamin == 'L'): ?>
                                    <span class="badge bg-primary"><i class="fas fa-mars"></i> Laki-laki</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="fas fa-venus"></i> Perempuan</span>
                                <?php endif; ?>
                            </dd>
                            
                            <dt class="col-sm-4">Agama:</dt>
                            <dd class="col-sm-8"><?php echo $siswa->agama; ?></dd>
                            
                            <dt class="col-sm-4">Alamat:</dt>
                            <dd class="col-sm-8"><?php echo nl2br($siswa->alamat); ?></dd>
                            
                            <?php if ($siswa->no_telp): ?>
                                <dt class="col-sm-4">No. Telepon:</dt>
                                <dd class="col-sm-8">
                                    <a href="tel:<?php echo $siswa->no_telp; ?>" class="text-decoration-none">
                                        <i class="fas fa-phone"></i> <?php echo $siswa->no_telp; ?>
                                    </a>
                                </dd>
                            <?php endif; ?>
                            
                            <?php if ($siswa->email): ?>
                                <dt class="col-sm-4">Email:</dt>
                                <dd class="col-sm-8">
                                    <a href="mailto:<?php echo $siswa->email; ?>" class="text-decoration-none">
                                        <i class="fas fa-envelope"></i> <?php echo $siswa->email; ?>
                                    </a>
                                </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>

                <!-- Parent Information -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users"></i> Data Orang Tua
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary"><i class="fas fa-male"></i> Data Ayah</h5>
                                <dl class="row">
                                    <dt class="col-sm-5">Nama:</dt>
                                    <dd class="col-sm-7"><?php echo $siswa->nama_ayah; ?></dd>
                                    
                                    <?php if ($siswa->pekerjaan_ayah): ?>
                                        <dt class="col-sm-5">Pekerjaan:</dt>
                                        <dd class="col-sm-7"><?php echo $siswa->pekerjaan_ayah; ?></dd>
                                    <?php endif; ?>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-danger"><i class="fas fa-female"></i> Data Ibu</h5>
                                <dl class="row">
                                    <dt class="col-sm-5">Nama:</dt>
                                    <dd class="col-sm-7"><?php echo $siswa->nama_ibu; ?></dd>
                                    
                                    <?php if ($siswa->pekerjaan_ibu): ?>
                                        <dt class="col-sm-5">Pekerjaan:</dt>
                                        <dd class="col-sm-7"><?php echo $siswa->pekerjaan_ibu; ?></dd>
                                    <?php endif; ?>
                                </dl>
                            </div>
                        </div>
                        
                        <?php if ($siswa->no_telp_ortu): ?>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <strong>No. Telepon Orang Tua:</strong>
                                    <a href="tel:<?php echo $siswa->no_telp_ortu; ?>" class="text-decoration-none">
                                        <i class="fas fa-phone"></i> <?php echo $siswa->no_telp_ortu; ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action Buttons -->
                <?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="btn-group" role="group">
                                <a href="<?php echo site_url('siswa/edit/' . $siswa->id_siswa); ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Data
                                </a>
                                
                                <button type="button" 
                                        class="btn btn-warning" 
                                        onclick="resetPassword(<?php echo $siswa->id_siswa; ?>)">
                                    <i class="fas fa-key"></i> Reset Password
                                </button>
                                
                                <?php if ($this->session->userdata('id_level_user') == 1): ?>
                                    <button type="button" 
                                            class="btn btn-danger" 
                                            onclick="deleteSiswa(<?php echo $siswa->id_siswa; ?>)">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (in_array($this->session->userdata('id_level_user'), [1, 2])): ?>
<script>
function resetPassword(id) {
    Swal.fire({
        title: 'Reset Password?',
        text: 'Password akan direset ke NISN siswa',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("siswa/reset_password/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

<?php if ($this->session->userdata('id_level_user') == 1): ?>
function deleteSiswa(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data siswa akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo site_url("siswa/delete/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.href = '<?php echo site_url("siswa"); ?>';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
}
<?php endif; ?>
</script>
<?php endif; ?>