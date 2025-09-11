<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-user-edit"></i> Edit Guru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('guru'); ?>">Data Guru</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit"></i> Form Edit Guru
                </h5>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart('guru/edit/' . $guru->id_guru, ['class' => 'form-horizontal']); ?>
                
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">NIP</label>
                    <div class="col-sm-9">
                        <input type="text" name="nip" value="<?php echo set_value('nip', $guru->nip); ?>" 
                               class="form-control <?php echo form_error('nip') ? 'is-invalid' : ''; ?>" 
                               placeholder="Masukkan NIP (opsional)">
                        <?php if (form_error('nip')): ?>
                            <div class="invalid-feedback"><?php echo form_error('nip'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">NUPTK</label>
                    <div class="col-sm-9">
                        <input type="text" name="nuptk" value="<?php echo set_value('nuptk', $guru->nuptk); ?>" 
                               class="form-control <?php echo form_error('nuptk') ? 'is-invalid' : ''; ?>" 
                               placeholder="Masukkan NUPTK (opsional)">
                        <?php if (form_error('nuptk')): ?>
                            <div class="invalid-feedback"><?php echo form_error('nuptk'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Guru <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_guru" value="<?php echo set_value('nama_guru', $guru->nama_guru); ?>" 
                               class="form-control <?php echo form_error('nama_guru') ? 'is-invalid' : ''; ?>" 
                               placeholder="Masukkan nama lengkap guru">
                        <?php if (form_error('nama_guru')): ?>
                            <div class="invalid-feedback"><?php echo form_error('nama_guru'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" name="tempat_lahir" value="<?php echo set_value('tempat_lahir', $guru->tempat_lahir); ?>" 
                               class="form-control <?php echo form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                               placeholder="Tempat lahir">
                        <?php if (form_error('tempat_lahir')): ?>
                            <div class="invalid-feedback"><?php echo form_error('tempat_lahir'); ?></div>
                        <?php endif; ?>
                    </div>
                    <label class="col-sm-2 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <div class="col-sm-2">
                        <input type="date" name="tanggal_lahir" value="<?php echo set_value('tanggal_lahir', $guru->tanggal_lahir); ?>" 
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
                            <option value="L" <?php echo set_select('jenis_kelamin', 'L', $guru->jenis_kelamin == 'L'); ?>>Laki-Laki</option>
                            <option value="P" <?php echo set_select('jenis_kelamin', 'P', $guru->jenis_kelamin == 'P'); ?>>Perempuan</option>
                        </select>
                        <?php if (form_error('jenis_kelamin')): ?>
                            <div class="invalid-feedback"><?php echo form_error('jenis_kelamin'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Agama <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="agama" class="form-control <?php echo form_error('agama') ? 'is-invalid' : ''; ?>">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" <?php echo set_select('agama', 'Islam', $guru->agama == 'Islam'); ?>>Islam</option>
                            <option value="Kristen" <?php echo set_select('agama', 'Kristen', $guru->agama == 'Kristen'); ?>>Kristen</option>
                            <option value="Katolik" <?php echo set_select('agama', 'Katolik', $guru->agama == 'Katolik'); ?>>Katolik</option>
                            <option value="Hindu" <?php echo set_select('agama', 'Hindu', $guru->agama == 'Hindu'); ?>>Hindu</option>
                            <option value="Buddha" <?php echo set_select('agama', 'Buddha', $guru->agama == 'Buddha'); ?>>Buddha</option>
                            <option value="Konghucu" <?php echo set_select('agama', 'Konghucu', $guru->agama == 'Konghucu'); ?>>Konghucu</option>
                        </select>
                        <?php if (form_error('agama')): ?>
                            <div class="invalid-feedback"><?php echo form_error('agama'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">No. Telepon</label>
                    <div class="col-sm-9">
                        <input type="text" name="no_telp" value="<?php echo set_value('no_telp', $guru->no_telp); ?>" 
                               class="form-control <?php echo form_error('no_telp') ? 'is-invalid' : ''; ?>" 
                               placeholder="Nomor telepon">
                        <?php if (form_error('no_telp')): ?>
                            <div class="invalid-feedback"><?php echo form_error('no_telp'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" value="<?php echo set_value('email', $guru->email); ?>" 
                               class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" 
                               placeholder="Alamat email">
                        <?php if (form_error('email')): ?>
                            <div class="invalid-feedback"><?php echo form_error('email'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Alamat <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <textarea name="alamat" class="form-control <?php echo form_error('alamat') ? 'is-invalid' : ''; ?>" 
                                  rows="3" placeholder="Alamat lengkap"><?php echo set_value('alamat', $guru->alamat); ?></textarea>
                        <?php if (form_error('alamat')): ?>
                            <div class="invalid-feedback"><?php echo form_error('alamat'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                    <div class="col-sm-9">
                        <select name="pendidikan_terakhir" class="form-control <?php echo form_error('pendidikan_terakhir') ? 'is-invalid' : ''; ?>">
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="SMA/SMK" <?php echo set_select('pendidikan_terakhir', 'SMA/SMK', $guru->pendidikan_terakhir == 'SMA/SMK'); ?>>SMA/SMK</option>
                            <option value="D3" <?php echo set_select('pendidikan_terakhir', 'D3', $guru->pendidikan_terakhir == 'D3'); ?>>D3</option>
                            <option value="S1" <?php echo set_select('pendidikan_terakhir', 'S1', $guru->pendidikan_terakhir == 'S1'); ?>>S1</option>
                            <option value="S2" <?php echo set_select('pendidikan_terakhir', 'S2', $guru->pendidikan_terakhir == 'S2'); ?>>S2</option>
                            <option value="S3" <?php echo set_select('pendidikan_terakhir', 'S3', $guru->pendidikan_terakhir == 'S3'); ?>>S3</option>
                        </select>
                        <?php if (form_error('pendidikan_terakhir')): ?>
                            <div class="invalid-feedback"><?php echo form_error('pendidikan_terakhir'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-9">
                        <input type="text" name="jabatan" value="<?php echo set_value('jabatan', $guru->jabatan); ?>" 
                               class="form-control <?php echo form_error('jabatan') ? 'is-invalid' : ''; ?>" 
                               placeholder="Jabatan">
                        <?php if (form_error('jabatan')): ?>
                            <div class="invalid-feedback"><?php echo form_error('jabatan'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Status Kepegawaian <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="status_kepegawaian" class="form-control <?php echo form_error('status_kepegawaian') ? 'is-invalid' : ''; ?>">
                            <option value="">Pilih Status Kepegawaian</option>
                            <option value="PNS" <?php echo set_select('status_kepegawaian', 'PNS', $guru->status_kepegawaian == 'PNS'); ?>>PNS</option>
                            <option value="GTT" <?php echo set_select('status_kepegawaian', 'GTT', $guru->status_kepegawaian == 'GTT'); ?>>GTT</option>
                            <option value="GTY" <?php echo set_select('status_kepegawaian', 'GTY', $guru->status_kepegawaian == 'GTY'); ?>>GTY</option>
                            <option value="Honorer" <?php echo set_select('status_kepegawaian', 'Honorer', $guru->status_kepegawaian == 'Honorer'); ?>>Honorer</option>
                        </select>
                        <?php if (form_error('status_kepegawaian')): ?>
                            <div class="invalid-feedback"><?php echo form_error('status_kepegawaian'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" name="username" value="<?php echo set_value('username', $guru->username); ?>" 
                               class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>" 
                               placeholder="Username untuk login (opsional)">
                        <?php if (form_error('username')): ?>
                            <div class="invalid-feedback"><?php echo form_error('username'); ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Kosongkan jika tidak ingin memberikan akses login</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Password Baru</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" 
                               class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" 
                               placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)">
                        <?php if (form_error('password')): ?>
                            <div class="invalid-feedback"><?php echo form_error('password'); ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Status <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="status" class="form-control <?php echo form_error('status') ? 'is-invalid' : ''; ?>">
                            <option value="aktif" <?php echo set_select('status', 'aktif', $guru->status == 'aktif'); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo set_select('status', 'nonaktif', $guru->status == 'nonaktif'); ?>>Non-Aktif</option>
                        </select>
                        <?php if (form_error('status')): ?>
                            <div class="invalid-feedback"><?php echo form_error('status'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Foto</label>
                    <div class="col-sm-9">
                        <?php if ($guru->foto && file_exists('./assets/uploads/guru/' . $guru->foto)): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url('assets/uploads/guru/' . $guru->foto); ?>" 
                                     alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                <p class="text-muted">Foto saat ini</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo base_url('guru'); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <a href="<?php echo base_url('guru/detail/' . $guru->id_guru); ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
