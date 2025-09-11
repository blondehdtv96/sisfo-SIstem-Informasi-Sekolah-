<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit"></i> Edit Assignment Guru Mata Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('guru_mapel'); ?>">Guru Mata Pelajaran</a></li>
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
                    <i class="fas fa-edit"></i> Form Edit Assignment Guru Mata Pelajaran
                </h5>
            </div>
            <div class="card-body">
                <?php echo form_open('guru_mapel/edit/' . $assignment->id_guru_mapel, ['class' => 'form-horizontal']); ?>
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Current Assignment Info -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Assignment Saat Ini:</h6>
                            <p class="mb-0">
                                <strong>Guru:</strong> <?php echo $assignment->nama_guru; ?><br>
                                <strong>Mata Pelajaran:</strong> <?php echo $assignment->nama_mapel; ?> (<?php echo $assignment->kode_mapel; ?>)<br>
                                <strong>Tahun Akademik:</strong> <?php echo $assignment->tahun_ajar; ?>
                            </p>
                        </div>

                        <!-- Teacher Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilih Guru <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="id_guru" class="form-control select2 <?php echo form_error('id_guru') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?php echo $teacher->id_guru; ?>" 
                                                <?php echo set_select('id_guru', $teacher->id_guru, $teacher->id_guru == $assignment->id_guru); ?>>
                                            <?php echo $teacher->nama_guru; ?>
                                            <?php if ($teacher->nip): ?>
                                                (NIP: <?php echo $teacher->nip; ?>)
                                            <?php endif; ?>
                                            - <?php echo ucfirst($teacher->status_kepegawaian); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (form_error('id_guru')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('id_guru'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Subject Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="id_mapel" class="form-control select2 <?php echo form_error('id_mapel') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?php echo $subject->id_mapel; ?>"
                                                <?php echo set_select('id_mapel', $subject->id_mapel, $subject->id_mapel == $assignment->id_mapel); ?>>
                                            <?php echo $subject->nama_mapel; ?> (<?php echo $subject->kode_mapel; ?>)
                                            - <?php echo ucwords(str_replace('_', ' ', $subject->kategori)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (form_error('id_mapel')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('id_mapel'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Academic Year Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tahun Akademik <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="id_tahun_akademik" class="form-control <?php echo form_error('id_tahun_akademik') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    <?php foreach ($academic_years as $year): ?>
                                        <option value="<?php echo $year->id_tahun_akademik; ?>" 
                                                <?php echo set_select('id_tahun_akademik', $year->id_tahun_akademik, $year->id_tahun_akademik == $assignment->id_tahun_akademik); ?>>
                                            <?php echo $year->tahun_ajar; ?>
                                            <?php if ($year->status == 'aktif'): ?>
                                                <span class="badge badge-success">Aktif</span>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (form_error('id_tahun_akademik')): ?>
                                    <div class="invalid-feedback"><?php echo form_error('id_tahun_akademik'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Assignment
                                </button>
                                <a href="<?php echo base_url('guru_mapel'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="<?php echo base_url('guru_mapel/detail/' . $assignment->id_guru_mapel); ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Info Panel -->
                    <div class="col-lg-4">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-triangle"></i> Peringatan
                                </h3>
                            </div>
                            <div class="card-body">
                                <h6><strong>Perhatian:</strong></h6>
                                <ul class="pl-3">
                                    <li>Mengubah assignment dapat mempengaruhi jadwal yang sudah ada</li>
                                    <li>Pastikan kombinasi guru-mata pelajaran-tahun akademik yang baru belum ada</li>
                                    <li>Perubahan akan berlaku segera setelah disimpan</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Assignment History -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history"></i> Informasi Assignment
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>ID Assignment:</strong></td>
                                        <td><?php echo $assignment->id_guru_mapel; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($assignment->created_at)); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Related Info -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-link"></i> Terkait
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="<?php echo base_url('guru_mapel/teacher_assignments/' . $assignment->id_guru); ?>" 
                                       class="btn btn-sm btn-outline-primary btn-block">
                                        <i class="fas fa-user"></i> Semua Assignment Guru Ini
                                    </a>
                                    <a href="<?php echo base_url('guru_mapel/subject_teachers/' . $assignment->id_mapel); ?>" 
                                       class="btn btn-sm btn-outline-info btn-block">
                                        <i class="fas fa-book"></i> Semua Guru Mata Pelajaran Ini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Form validation
    $('form').on('submit', function(e) {
        const guru = $('select[name="id_guru"]').val();
        const mapel = $('select[name="id_mapel"]').val();
        const tahun = $('select[name="id_tahun_akademik"]').val();
        
        if (!guru || !mapel || !tahun) {
            e.preventDefault();
            Swal.fire('Error!', 'Semua field harus diisi', 'error');
            return false;
        }
    });

    // Highlight changed fields
    $('select').on('change', function() {
        $(this).addClass('border-warning');
    });
});
</script>

<style>
.select2-container--bootstrap4 .select2-selection {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.select2-container--bootstrap4.select2-container--focus .select2-selection {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.border-warning {
    border-color: #ffc107 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
}

.table-sm td {
    padding: 0.3rem;
    border-top: 1px solid #dee2e6;
}

.d-grid .btn-block {
    width: 100%;
    margin-bottom: 0.5rem;
}
</style>