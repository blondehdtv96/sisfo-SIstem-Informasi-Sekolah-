<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit me-2"></i>
                            Edit Kelas
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo site_url('kelas'); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    
                    <?php echo form_open('kelas/edit/' . $kelas->id_kelas, 'class="needs-validation" novalidate'); ?>
                    <div class="card-body">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo validation_errors(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="id_tingkatan" class="form-label">
                                        Tingkatan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('id_tingkatan') ? 'is-invalid' : ''; ?>" 
                                            id="id_tingkatan" 
                                            name="id_tingkatan" 
                                            onchange="updatePreview()"
                                            required>
                                        <option value="">Pilih Tingkatan</option>
                                        <?php foreach ($tingkatan as $t): ?>
                                            <option value="<?php echo $t->id_tingkatan; ?>" 
                                                    <?php echo ($kelas->id_tingkatan == $t->id_tingkatan) ? 'selected' : ''; ?>>
                                                <?php echo $t->nama_tingkatan; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('id_tingkatan'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="id_jurusan" class="form-label">
                                        Jurusan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php echo form_error('id_jurusan') ? 'is-invalid' : ''; ?>" 
                                            id="id_jurusan" 
                                            name="id_jurusan" 
                                            onchange="updatePreview()"
                                            required>
                                        <option value="">Pilih Jurusan</option>
                                        <?php foreach ($jurusan as $j): ?>
                                            <option value="<?php echo $j->id_jurusan; ?>" 
                                                    <?php echo ($kelas->id_jurusan == $j->id_jurusan) ? 'selected' : ''; ?>>
                                                <?php echo $j->nama_jurusan; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('id_jurusan'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="rombel" class="form-label">
                                        Rombongan Belajar <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php echo form_error('rombel') ? 'is-invalid' : ''; ?>" 
                                           id="rombel" 
                                           name="rombel" 
                                           value="<?php echo $kelas->rombel; ?>"
                                           placeholder="Contoh: A, B, 1, 2"
                                           maxlength="5"
                                           onkeyup="updatePreview()"
                                           style="text-transform: uppercase;"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('rombel'); ?>
                                    </div>
                                    <small class="text-muted">Huruf atau angka (A, B, C atau 1, 2, 3)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kapasitas" class="form-label">
                                        Kapasitas Maksimal <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control <?php echo form_error('kapasitas') ? 'is-invalid' : ''; ?>" 
                                           id="kapasitas" 
                                           name="kapasitas" 
                                           value="<?php echo $kelas->kapasitas; ?>"
                                           placeholder="36"
                                           min="1"
                                           max="50"
                                           required>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('kapasitas'); ?>
                                    </div>
                                    <small class="text-muted">Jumlah maksimal siswa dalam kelas</small>
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
                                        <option value="aktif" <?php echo ($kelas->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="nonaktif" <?php echo ($kelas->status == 'nonaktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo form_error('status'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Class Info -->
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-info-circle"></i> Kelas Saat Ini:</h6>
                            <h5 class="text-dark"><?php echo $kelas->nama_kelas; ?></h5>
                            <small class="text-muted">Kode: <?php echo $kelas->kode_kelas; ?></small>
                        </div>

                        <!-- Preview Nama Kelas -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-eye"></i> Preview Nama Kelas Baru:</h6>
                                    <h4 id="preview-nama-kelas" class="text-primary">-</h4>
                                    <small class="text-muted">Nama kelas akan diperbarui berdasarkan tingkatan, jurusan, dan rombel yang dipilih</small>
                                </div>
                            </div>
                        </div>

                        <!-- Information Alert -->
                        <div class="alert alert-success mt-3">
                            <h6><i class="fas fa-info-circle"></i> Panduan Edit Kelas</h6>
                            <ul class="mb-0">
                                <li><strong>Tingkatan:</strong> Pilih tingkat kelas (X, XI, XII)</li>
                                <li><strong>Jurusan:</strong> Pilih program keahlian</li>
                                <li><strong>Rombel:</strong> Masukkan rombongan belajar (A, B, C atau 1, 2, 3)</li>
                                <li><strong>Contoh hasil:</strong> "X TKJ A", "XI MM 1", "XII RPL B"</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo site_url('kelas'); ?>" class="btn btn-secondary">
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
    $('#id_tingkatan').focus();
    
    // Convert rombel to uppercase
    $('#rombel').on('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Initialize preview on page load
    updatePreview();
});

function updatePreview() {
    var tingkatan = $('#id_tingkatan option:selected').text();
    var jurusan = $('#id_jurusan option:selected').text();
    var rombel = $('#rombel').val().toUpperCase();
    
    if (tingkatan && tingkatan !== 'Pilih Tingkatan' && 
        jurusan && jurusan !== 'Pilih Jurusan' && 
        rombel) {
        var preview = tingkatan + ' ' + jurusan + ' ' + rombel;
        $('#preview-nama-kelas').text(preview);
    } else {
        $('#preview-nama-kelas').text('-');
    }
}
</script>