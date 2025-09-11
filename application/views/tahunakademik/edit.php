<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit me-2"></i>
                            Edit Tahun Akademik
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('tahunakademik'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open('tahunakademik/edit/' . $tahun_akademik->id_tahun_akademik, 'class="needs-validation" novalidate'); ?>
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
                                    <label for="tahun_ajar" class="form-label">
                                        Tahun Ajar <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('tahun_ajar') ? 'is-invalid' : ''; ?>" 
                                           id="tahun_ajar" 
                                           name="tahun_ajar" 
                                           value="<?php echo set_value('tahun_ajar', $tahun_akademik->tahun_ajar); ?>"
                                           placeholder="Contoh: 2024/2025"
                                           maxlength="9"
                                           pattern="[0-9]{4}/[0-9]{4}"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('tahun_ajar'); ?>
                                    </div>
                                    <small class="text-muted">Format: YYYY/YYYY</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="semester" class="form-label">
                                        Semester <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('semester') ? 'is-invalid' : ''; ?>" 
                                            id="semester" 
                                            name="semester" 
                                            required>
                                        <option value="">Pilih Semester</option>
                                        <option value="ganjil" <?php echo set_select('semester', 'ganjil', ($tahun_akademik->semester == 'ganjil')); ?>>Ganjil</option>
                                        <option value="genap" <?php echo set_select('semester', 'genap', ($tahun_akademik->semester == 'genap')); ?>>Genap</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('semester'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_mulai" class="form-label">
                                        Tanggal Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control <?php echo form_error('tanggal_mulai') ? 'is-invalid' : ''; ?>" 
                                           id="tanggal_mulai" 
                                           name="tanggal_mulai" 
                                           value="<?php echo set_value('tanggal_mulai', $tahun_akademik->tanggal_mulai); ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('tanggal_mulai'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_selesai" class="form-label">
                                        Tanggal Selesai <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control <?php echo form_error('tanggal_selesai') ? 'is-invalid' : ''; ?>" 
                                           id="tanggal_selesai" 
                                           name="tanggal_selesai" 
                                           value="<?php echo set_value('tanggal_selesai', $tahun_akademik->tanggal_selesai); ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('tanggal_selesai'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                        <option value="aktif" <?php echo set_select('status', 'aktif', ($tahun_akademik->status == 'aktif')); ?>>Aktif</option>
                                        <option value="nonaktif" <?php echo set_select('status', 'nonaktif', ($tahun_akademik->status == 'nonaktif')); ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('status'); ?>
                                    </div>
                                    <small class="text-muted">Hanya satu tahun akademik yang dapat aktif pada satu waktu</small>
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
                                              placeholder="Keterangan tahun akademik (opsional)"><?php echo set_value('keterangan', $tahun_akademik->keterangan); ?></textarea>
                                    <small class="text-muted">Keterangan tambahan tentang tahun akademik ini</small>
                                </div>
                            </div>
                        </div>

                        <!-- Information Alert -->
                        <div class="alert alert-info mt-3">
                            <h6><i class="fas fa-info-circle"></i> Informasi Penting</h6>
                            <ul class="mb-0">
                                <li>Format tahun ajar: YYYY/YYYY (contoh: 2024/2025)</li>
                                <li>Jika status diatur "Aktif", tahun akademik lain akan otomatis dinonaktifkan</li>
                                <li>Tanggal selesai harus lebih besar dari tanggal mulai</li>
                                <li>Semester Ganjil biasanya: Juli - Desember</li>
                                <li>Semester Genap biasanya: Januari - Juni</li>
                            </ul>
                        </div>

                        <?php if ($tahun_akademik->status == 'aktif'): ?>
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Perhatian</h6>
                                <p class="mb-0">Tahun akademik ini sedang dalam status <strong>AKTIF</strong>. Hati-hati saat melakukan perubahan karena dapat mempengaruhi data siswa dan sistem lainnya.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo site_url('tahunakademik'); ?>" class="btn btn-secondary">
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
    $('#tahun_ajar').focus();

    // Validate date range
    $('#tanggal_selesai').on('change', function() {
        var startDate = $('#tanggal_mulai').val();
        var endDate = $(this).val();
        
        if (startDate && endDate && endDate <= startDate) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('Tanggal selesai harus lebih besar dari tanggal mulai');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Format tahun ajar input
    $('#tahun_ajar').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value.length >= 4) {
            value = value.substring(0, 4) + '/' + value.substring(4, 8);
        }
        $(this).val(value);
    });
});
</script>