<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Data Siswa
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('siswa'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open_multipart('siswa/add', 'class="needs-validation" novalidate'); ?>
                    <div class="card-body">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo validation_errors(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="siswaTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab">
                                    <i class="fas fa-user"></i> Data Pribadi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="data-ortu-tab" data-bs-toggle="tab" data-bs-target="#data-ortu" type="button" role="tab">
                                    <i class="fas fa-users"></i> Data Orang Tua
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="data-akademik-tab" data-bs-toggle="tab" data-bs-target="#data-akademik" type="button" role="tab">
                                    <i class="fas fa-graduation-cap"></i> Data Akademik
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="siswaTabContent">
                            <!-- Data Pribadi Tab -->
                            <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-3 text-center">
                                        <div class="form-group">
                                            <label class="form-label">Foto Siswa</label>
                                            <div class="photo-preview mb-3">
                                                <img id="photo-preview" 
                                                     src="<?php echo base_url('assets/img/default-avatar.png'); ?>" 
                                                     alt="Preview Foto" 
                                                     class="img-thumbnail" 
                                                     style="width: 150px; height: 200px; object-fit: cover;">
                                            </div>
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="foto" 
                                                   name="foto" 
                                                   accept="image/*"
                                                   onchange="previewPhoto(this)">
                                            <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="nisn" class="form-label">
                                                        NISN <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control <?php echo form_error('nisn') ? 'is-invalid' : ''; ?>" 
                                                           id="nisn" 
                                                           name="nisn" 
                                                           value="<?php echo set_value('nisn'); ?>"
                                                           placeholder="Nomor Induk Siswa Nasional"
                                                           maxlength="10"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('nisn'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="nis" class="form-label">NIS</label>
                                                    <input type="text" 
                                                           class="form-control <?php echo form_error('nis') ? 'is-invalid' : ''; ?>" 
                                                           id="nis" 
                                                           name="nis" 
                                                           value="<?php echo set_value('nis'); ?>"
                                                           placeholder="Nomor Induk Siswa (Opsional)">
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('nis'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="nama_siswa" class="form-label">
                                                        Nama Lengkap <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control <?php echo form_error('nama_siswa') ? 'is-invalid' : ''; ?>" 
                                                           id="nama_siswa" 
                                                           name="nama_siswa" 
                                                           value="<?php echo set_value('nama_siswa'); ?>"
                                                           placeholder="Nama lengkap siswa"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('nama_siswa'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="tempat_lahir" class="form-label">
                                                        Tempat Lahir <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control <?php echo form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                                                           id="tempat_lahir" 
                                                           name="tempat_lahir" 
                                                           value="<?php echo set_value('tempat_lahir'); ?>"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('tempat_lahir'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="tanggal_lahir" class="form-label">
                                                        Tanggal Lahir <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" 
                                                           class="form-control <?php echo form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" 
                                                           id="tanggal_lahir" 
                                                           name="tanggal_lahir" 
                                                           value="<?php echo set_value('tanggal_lahir'); ?>"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('tanggal_lahir'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="jenis_kelamin" class="form-label">
                                                        Jenis Kelamin <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select <?php echo form_error('jenis_kelamin') ? 'is-invalid' : ''; ?>" 
                                                            id="jenis_kelamin" 
                                                            name="jenis_kelamin" 
                                                            required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="L" <?php echo set_select('jenis_kelamin', 'L'); ?>>Laki-laki</option>
                                                        <option value="P" <?php echo set_select('jenis_kelamin', 'P'); ?>>Perempuan</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('jenis_kelamin'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="agama" class="form-label">
                                                        Agama <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select <?php echo form_error('agama') ? 'is-invalid' : ''; ?>" 
                                                            id="agama" 
                                                            name="agama" 
                                                            required>
                                                        <option value="">Pilih Agama</option>
                                                        <option value="Islam" <?php echo set_select('agama', 'Islam'); ?>>Islam</option>
                                                        <option value="Kristen" <?php echo set_select('agama', 'Kristen'); ?>>Kristen</option>
                                                        <option value="Katolik" <?php echo set_select('agama', 'Katolik'); ?>>Katolik</option>
                                                        <option value="Hindu" <?php echo set_select('agama', 'Hindu'); ?>>Hindu</option>
                                                        <option value="Buddha" <?php echo set_select('agama', 'Buddha'); ?>>Buddha</option>
                                                        <option value="Konghucu" <?php echo set_select('agama', 'Konghucu'); ?>>Konghucu</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('agama'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="alamat" class="form-label">
                                                        Alamat <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control <?php echo form_error('alamat') ? 'is-invalid' : ''; ?>" 
                                                              id="alamat" 
                                                              name="alamat" 
                                                              rows="3"
                                                              placeholder="Alamat lengkap siswa"
                                                              required><?php echo set_value('alamat'); ?></textarea>
                                                    <div class="invalid-feedback">
                                                        <?php echo form_error('alamat'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="no_telp" class="form-label">No. Telepon Siswa</label>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           id="no_telp" 
                                                           name="no_telp" 
                                                           value="<?php echo set_value('no_telp'); ?>"
                                                           placeholder="Nomor telepon siswa">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" 
                                                           class="form-control" 
                                                           id="email" 
                                                           name="email" 
                                                           value="<?php echo set_value('email'); ?>"
                                                           placeholder="Alamat email siswa">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua Tab -->
                            <div class="tab-pane fade" id="data-ortu" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <h5><i class="fas fa-male"></i> Data Ayah</h5>
                                        <div class="form-group mb-3">
                                            <label for="nama_ayah" class="form-label">
                                                Nama Ayah <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control <?php echo form_error('nama_ayah') ? 'is-invalid' : ''; ?>" 
                                                   id="nama_ayah" 
                                                   name="nama_ayah" 
                                                   value="<?php echo set_value('nama_ayah'); ?>"
                                                   required>
                                            <div class="invalid-feedback">
                                                <?php echo form_error('nama_ayah'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="pekerjaan_ayah" 
                                                   name="pekerjaan_ayah" 
                                                   value="<?php echo set_value('pekerjaan_ayah'); ?>"
                                                   placeholder="Pekerjaan ayah">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h5><i class="fas fa-female"></i> Data Ibu</h5>
                                        <div class="form-group mb-3">
                                            <label for="nama_ibu" class="form-label">
                                                Nama Ibu <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control <?php echo form_error('nama_ibu') ? 'is-invalid' : ''; ?>" 
                                                   id="nama_ibu" 
                                                   name="nama_ibu" 
                                                   value="<?php echo set_value('nama_ibu'); ?>"
                                                   required>
                                            <div class="invalid-feedback">
                                                <?php echo form_error('nama_ibu'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="pekerjaan_ibu" 
                                                   name="pekerjaan_ibu" 
                                                   value="<?php echo set_value('pekerjaan_ibu'); ?>"
                                                   placeholder="Pekerjaan ibu">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="no_telp_ortu" class="form-label">No. Telepon Orang Tua</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="no_telp_ortu" 
                                                   name="no_telp_ortu" 
                                                   value="<?php echo set_value('no_telp_ortu'); ?>"
                                                   placeholder="Nomor telepon yang bisa dihubungi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Akademik Tab -->
                            <div class="tab-pane fade" id="data-akademik" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="id_kelas" class="form-label">
                                                Kelas <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select <?php echo form_error('id_kelas') ? 'is-invalid' : ''; ?>" 
                                                    id="id_kelas" 
                                                    name="id_kelas" 
                                                    required>
                                                <option value="">Pilih Kelas</option>
                                                <?php foreach ($kelas_list as $kelas): ?>
                                                    <option value="<?php echo $kelas->id_kelas; ?>" 
                                                            <?php echo set_select('id_kelas', $kelas->id_kelas); ?>>
                                                        <?php echo $kelas->nama_kelas . ' - ' . $kelas->nama_jurusan; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo form_error('id_kelas'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="id_tahun_akademik" class="form-label">
                                                Tahun Akademik <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select <?php echo form_error('id_tahun_akademik') ? 'is-invalid' : ''; ?>" 
                                                    id="id_tahun_akademik" 
                                                    name="id_tahun_akademik" 
                                                    required>
                                                <option value="">Pilih Tahun Akademik</option>
                                                <?php foreach ($tahun_akademik_list as $tahun): ?>
                                                    <option value="<?php echo $tahun->id_tahun_akademik; ?>" 
                                                            <?php echo set_select('id_tahun_akademik', $tahun->id_tahun_akademik, $tahun->status == 'aktif'); ?>>
                                                        <?php echo $tahun->tahun_ajar . ' - ' . ucfirst($tahun->semester); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo form_error('id_tahun_akademik'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Informasi Password:</h6>
                                    <p class="mb-0">Password default untuk login siswa adalah <strong>NISN</strong> yang telah dimasukkan. Siswa dapat menggunakan NISN sebagai username dan password untuk login ke sistem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data Siswa
                        </button>
                        <a href="<?php echo site_url('siswa'); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Auto focus on first input
    $('#nisn').focus();
});

function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#photo-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>