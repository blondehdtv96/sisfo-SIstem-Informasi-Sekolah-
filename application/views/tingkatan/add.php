<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Tingkatan
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('tingkatan'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open('tingkatan/add', 'class="needs-validation" novalidate'); ?>
                    <div class="card-body">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo validation_errors(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="nama_tingkatan" class="form-label">
                                        Nama Tingkatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('nama_tingkatan') ? 'is-invalid' : ''; ?>" 
                                           id="nama_tingkatan" 
                                           name="nama_tingkatan" 
                                           value="<?php echo set_value('nama_tingkatan'); ?>"
                                           placeholder="Contoh: X, XI, XII"
                                           maxlength="10"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('nama_tingkatan'); ?>
                                    </div>
                                    <small class="text-muted">Maksimal 10 karakter</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" 
                                              id="keterangan" 
                                              name="keterangan" 
                                              rows="3" 
                                              placeholder="Keterangan tingkatan (opsional)"><?php echo set_value('keterangan'); ?></textarea>
                                    <small class="text-muted">Keterangan tambahan tentang tingkatan ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo site_url('tingkatan'); ?>" class="btn btn-secondary">
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
    $('#nama_tingkatan').focus();
});
</script>