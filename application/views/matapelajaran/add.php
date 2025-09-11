<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Mata Pelajaran
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('matapelajaran'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open('matapelajaran/add', 'class="needs-validation" novalidate'); ?>
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
                                    <label for="kode_mapel" class="form-label">
                                        Kode Mata Pelajaran <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('kode_mapel') ? 'is-invalid' : ''; ?>" 
                                           id="kode_mapel" 
                                           name="kode_mapel" 
                                           value="<?php echo set_value('kode_mapel'); ?>"
                                           placeholder="Contoh: MTK, IPA, IPS"
                                           style="text-transform: uppercase;"
                                           maxlength="10"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('kode_mapel'); ?>
                                    </div>
                                    <small class="text-muted">Maksimal 10 karakter, akan otomatis menjadi huruf besar</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kategori" class="form-label">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('kategori') ? 'is-invalid' : ''; ?>" 
                                            id="kategori" 
                                            name="kategori" 
                                            required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="umum" <?php echo set_select('kategori', 'umum', TRUE); ?>>Umum</option>
                                        <option value="kejuruan" <?php echo set_select('kategori', 'kejuruan'); ?>>Kejuruan</option>
                                        <option value="muatan_lokal" <?php echo set_select('kategori', 'muatan_lokal'); ?>>Muatan Lokal</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('kategori'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="nama_mapel" class="form-label">
                                        Nama Mata Pelajaran <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('nama_mapel') ? 'is-invalid' : ''; ?>" 
                                           id="nama_mapel" 
                                           name="nama_mapel" 
                                           value="<?php echo set_value('nama_mapel'); ?>"
                                           placeholder="Contoh: Matematika, Bahasa Indonesia"
                                           maxlength="100"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('nama_mapel'); ?>
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
                                        <option value="aktif" <?php echo set_select('status', 'aktif', TRUE); ?>>Aktif</option>
                                        <option value="nonaktif" <?php echo set_select('status', 'nonaktif'); ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('status'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo site_url('matapelajaran'); ?>" class="btn btn-secondary">
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
    // Auto uppercase for kode_mapel
    $('#kode_mapel').on('input', function() {
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
    $('#kode_mapel').focus();
});
</script>