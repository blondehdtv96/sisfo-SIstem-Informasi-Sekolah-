<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit me-2"></i>
                            Edit Jurusan
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('jurusan'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open('jurusan/edit/' . $jurusan->id_jurusan, 'class="needs-validation" novalidate'); ?>
                    <div class="card-body">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo validation_errors(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kode_jurusan" class="form-label">
                                        Kode Jurusan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('kode_jurusan') ? 'is-invalid' : ''; ?>" 
                                           id="kode_jurusan" 
                                           name="kode_jurusan" 
                                           value="<?php echo set_value('kode_jurusan', $jurusan->kode_jurusan); ?>"
                                           placeholder="Contoh: TKJ, MM, RPL"
                                           style="text-transform: uppercase;"
                                           maxlength="10"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('kode_jurusan'); ?>
                                    </div>
                                    <small class="text-muted">Maksimal 10 karakter, akan otomatis menjadi huruf besar</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('status') ? 'is-invalid' : ''; ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" <?php echo set_select('status', 'Aktif', $jurusan->status == 'Aktif'); ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?php echo set_select('status', 'Tidak Aktif', $jurusan->status == 'Tidak Aktif'); ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('status'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="nama_jurusan" class="form-label">
                                        Nama Jurusan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('nama_jurusan') ? 'is-invalid' : ''; ?>" 
                                           id="nama_jurusan" 
                                           name="nama_jurusan" 
                                           value="<?php echo set_value('nama_jurusan', $jurusan->nama_jurusan); ?>"
                                           placeholder="Contoh: Teknik Komputer dan Jaringan"
                                           maxlength="100"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('nama_jurusan'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('status') ? 'is-invalid' : ''; ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif" <?php echo set_select('status', 'aktif', $jurusan->status == 'aktif'); ?>>Aktif</option>
                                        <option value="nonaktif" <?php echo set_select('status', 'nonaktif', $jurusan->status == 'nonaktif'); ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('status'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="3" 
                                              placeholder="Deskripsi jurusan (opsional)"><?php echo set_value('deskripsi', $jurusan->deskripsi); ?></textarea>
                                    <small class="text-muted">Deskripsi tambahan tentang jurusan ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo site_url('jurusan'); ?>" class="btn btn-secondary">
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
    // Auto uppercase for kode_jurusan
    $('#kode_jurusan').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Auto focus on first input
    $('#kode_jurusan').focus();
});
</script>