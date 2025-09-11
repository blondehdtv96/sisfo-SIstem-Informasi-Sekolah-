<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit"></i> Input Nilai Siswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('nilai'); ?>">Input Nilai</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('nilai/subject_classes/' . $mapel_id); ?>">Pilih Kelas</a></li>
                    <li class="breadcrumb-item active">Input Nilai</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Class and Subject Info -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informasi Kelas dan Mata Pelajaran
                </h3>
                <div class="card-tools">
                    <a href="<?php echo base_url('nilai/subject_classes/' . $mapel_id); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Mata Pelajaran:</strong></h6>
                        <p>
                            <?php echo isset($subject->nama_mapel) ? $subject->nama_mapel : 'Tidak ditemukan'; ?>
                            <span class="badge badge-primary ml-2">
                                <?php echo isset($subject->kode_mapel) ? $subject->kode_mapel : ''; ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Kelas:</strong></h6>
                        <p>
                            <?php echo isset($class_info->nama_kelas) ? $class_info->nama_kelas : 'Tidak ditemukan'; ?>
                            <?php if (isset($class_info)): ?>
                                <br><small class="text-muted">
                                    <?php echo $class_info->nama_tingkatan; ?> • <?php echo $class_info->nama_jurusan; ?>
                                </small>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Input Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Form Input Nilai
                </h3>
            </div>
            <div class="card-body">
                <?php echo form_open('nilai/input/' . $mapel_id . '/' . $kelas_id, ['class' => 'form-horizontal']); ?>
                
                <!-- Grade Configuration -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semester">Semester <span class="text-danger">*</span></label>
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="ganjil" <?php echo set_select('semester', 'ganjil', ($current_semester == 'ganjil')); ?>>Ganjil</option>
                                <option value="genap" <?php echo set_select('semester', 'genap', ($current_semester == 'genap')); ?>>Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori_nilai">Kategori Nilai <span class="text-danger">*</span></label>
                            <select name="kategori_nilai" id="kategori_nilai" class="form-control" required>
                                <option value="tugas" <?php echo set_select('kategori_nilai', 'tugas'); ?>>Tugas</option>
                                <option value="ulangan_harian" <?php echo set_select('kategori_nilai', 'ulangan_harian'); ?>>Ulangan Harian</option>
                                <option value="uts" <?php echo set_select('kategori_nilai', 'uts'); ?>>UTS</option>
                                <option value="uas" <?php echo set_select('kategori_nilai', 'uas'); ?>>UAS</option>
                                <option value="praktek" <?php echo set_select('kategori_nilai', 'praktek'); ?>>Praktek</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" 
                                   placeholder="Misal: Ulangan Bab 1" value="<?php echo set_value('keterangan'); ?>">
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <?php if (!empty($students)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50px">No</th>
                                    <th width="120px">NISN</th>
                                    <th width="120px">NIS</th>
                                    <th>Nama Siswa</th>
                                    <th width="100px">L/P</th>
                                    <th width="120px">Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($students as $student):
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo $student->nisn; ?></td>
                                        <td class="text-center"><?php echo $student->nis ?: '-'; ?></td>
                                        <td>
                                            <strong><?php echo $student->nama_siswa; ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($student->jenis_kelamin == 'L'): ?>
                                                <span class="badge badge-info">L</span>
                                            <?php else: ?>
                                                <span class="badge badge-pink">P</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="nilai[<?php echo $student->id_siswa; ?>]" 
                                                   class="form-control grade-input" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   placeholder="0-100"
                                                   value="">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info btn-sm" onclick="setAllGrades()">
                                <i class="fas fa-fill"></i> Isi Nilai Sama untuk Semua
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="clearAllGrades()">
                                <i class="fas fa-eraser"></i> Bersihkan Semua
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Nilai
                            </button>
                            <a href="<?php echo base_url('nilai/subject_classes/' . $mapel_id); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Siswa</h5>
                        <p class="text-muted">Tidak ada siswa yang terdaftar di kelas ini.</p>
                        <a href="<?php echo base_url('nilai/subject_classes/' . $mapel_id); ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                <?php endif; ?>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<!-- Set All Grades Modal -->
<div class="modal fade" id="setAllModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Isi Nilai Sama untuk Semua Siswa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="allGradeValue">Nilai (0-100):</label>
                    <input type="number" id="allGradeValue" class="form-control" min="0" max="100" step="0.01" placeholder="Masukkan nilai">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="applyAllGrades()">
                    <i class="fas fa-check"></i> Terapkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function setAllGrades() {
    $('#setAllModal').modal('show');
}

function applyAllGrades() {
    const value = document.getElementById('allGradeValue').value;
    if (value !== '' && value >= 0 && value <= 100) {
        const inputs = document.querySelectorAll('.grade-input');
        inputs.forEach(input => {
            input.value = value;
        });
        $('#setAllModal').modal('hide');
        document.getElementById('allGradeValue').value = '';
    } else {
        alert('Masukkan nilai antara 0-100');
    }
}

function clearAllGrades() {
    if (confirm('Apakah Anda yakin ingin menghapus semua nilai?')) {
        const inputs = document.querySelectorAll('.grade-input');
        inputs.forEach(input => {
            input.value = '';
        });
    }
}

// Auto-validate grade inputs
document.addEventListener('DOMContentLoaded', function() {
    const gradeInputs = document.querySelectorAll('.grade-input');
    gradeInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (this.value !== '' && (isNaN(value) || value < 0 || value > 100)) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Nilai harus antara 0-100';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                if (this.nextElementSibling && this.nextElementSibling.classList.contains('invalid-feedback')) {
                    this.nextElementSibling.remove();
                }
            }
        });
    });
});
</script>

<style>
.badge-pink {
    color: #fff;
    background-color: #e91e63;
}

.grade-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.table th {
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        margin-bottom: 0.5rem;
    }
}
</style>