<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i> Tambah Assignment Guru Mata Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('guru_mapel'); ?>">Guru Mata Pelajaran</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus"></i> Form Tambah Assignment Guru Mata Pelajaran
                </h5>
            </div>
            <div class="card-body">
                <?php echo form_open('guru_mapel/add', ['class' => 'form-horizontal', 'id' => 'assignmentForm']); ?>
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Teacher Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilih Guru <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="id_guru" id="id_guru" class="form-control select2 <?php echo form_error('id_guru') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?php echo $teacher->id_guru; ?>" <?php echo set_select('id_guru', $teacher->id_guru); ?>>
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

                        <!-- Academic Year Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tahun Akademik <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="id_tahun_akademik" id="id_tahun_akademik" class="form-control <?php echo form_error('id_tahun_akademik') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    <?php foreach ($academic_years as $year): ?>
                                        <option value="<?php echo $year->id_tahun_akademik; ?>" 
                                                <?php echo set_select('id_tahun_akademik', $year->id_tahun_akademik, ($current_year && $current_year->id_tahun_akademik == $year->id_tahun_akademik)); ?>>
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

                        <!-- Subject Selection -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div id="subject-selection">
                                    <?php if (!empty($subjects)): ?>
                                        <div class="subject-checkboxes">
                                            <h6 class="mb-3">Pilih Mata Pelajaran:</h6>
                                            
                                            <?php 
                                            // Group subjects by category
                                            $grouped_subjects = [];
                                            foreach ($subjects as $subject) {
                                                $category = $subject->kategori ?? 'umum';
                                                if (!isset($grouped_subjects[$category])) {
                                                    $grouped_subjects[$category] = [];
                                                }
                                                $grouped_subjects[$category][] = $subject;
                                            }
                                            
                                            // Display subjects by category
                                            foreach ($grouped_subjects as $kategori => $subject_list):
                                                $category_class = $kategori === 'umum' ? 'info' : 
                                                                ($kategori === 'kejuruan' ? 'success' : 'warning');
                                            ?>
                                                <h6 class="mt-3">
                                                    <span class="badge badge-<?php echo $category_class; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $kategori)); ?>
                                                    </span>
                                                </h6>
                                                
                                                <div class="row">
                                                    <?php foreach ($subject_list as $subject): ?>
                                                        <div class="col-md-6 col-lg-12">
                                                            <div class="custom-control custom-checkbox mb-2">
                                                                <input type="checkbox" 
                                                                       class="custom-control-input" 
                                                                       id="mapel_<?php echo $subject->id_mapel; ?>" 
                                                                       name="id_mapel[]" 
                                                                       value="<?php echo $subject->id_mapel; ?>">
                                                                <label class="custom-control-label" for="mapel_<?php echo $subject->id_mapel; ?>">
                                                                    <strong><?php echo $subject->nama_mapel; ?></strong>
                                                                    <br><small class="text-muted">(<?php echo $subject->kode_mapel; ?>)</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllSubjects()">
                                                <i class="fas fa-check-square"></i> Pilih Semua
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllSubjects()">
                                                <i class="fas fa-square"></i> Batal Pilih Semua
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Tidak ada mata pelajaran yang tersedia. Silakan tambahkan mata pelajaran terlebih dahulu.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (form_error('id_mapel[]')): ?>
                                    <div class="invalid-feedback d-block"><?php echo form_error('id_mapel[]'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Assignment
                                </button>
                                <a href="<?php echo base_url('guru_mapel'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Info Panel -->
                    <div class="col-lg-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle"></i> Informasi
                                </h3>
                            </div>
                            <div class="card-body">
                                <h6><strong>Petunjuk Penggunaan:</strong></h6>
                                <ol class="pl-3">
                                    <li>Pilih guru yang akan diberi assignment</li>
                                    <li>Pilih tahun akademik</li>
                                    <li>Pilih satu atau lebih mata pelajaran</li>
                                    <li>Klik "Simpan Assignment" untuk menyimpan</li>
                                </ol>
                                
                                <hr>
                                
                                <h6><strong>Catatan:</strong></h6>
                                <ul class="pl-3">
                                    <li>Satu guru dapat mengajar beberapa mata pelajaran</li>
                                    <li>Satu mata pelajaran dapat diajar oleh beberapa guru</li>
                                    <li>Assignment bersifat unik per kombinasi guru-mata pelajaran-tahun akademik</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Current Teacher Info -->
                        <div class="card card-secondary" id="teacher-info" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Info Guru Terpilih
                                </h3>
                            </div>
                            <div class="card-body" id="teacher-info-content">
                                <!-- Teacher information will be loaded here -->
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

    // Handle teacher and academic year changes - for future filtering
    $('#id_guru, #id_tahun_akademik').on('change', function() {
        loadTeacherInfo();
        // Note: Subjects are now shown by default, AJAX filtering can be added later
    });

    // Form validation
    $('#assignmentForm').on('submit', function(e) {
        const selectedSubjects = $('input[name="id_mapel[]"]:checked').length;
        const guru = $('#id_guru').val();
        const tahun = $('#id_tahun_akademik').val();
        
        if (!guru || !tahun) {
            e.preventDefault();
            Swal.fire('Error!', 'Pilih guru dan tahun akademik terlebih dahulu', 'error');
            return false;
        }
        
        if (selectedSubjects === 0) {
            e.preventDefault();
            Swal.fire('Error!', 'Pilih minimal satu mata pelajaran', 'error');
            return false;
        }
    });
});

function loadAvailableSubjects() {
    const idGuru = $('#id_guru').val();
    const idTahunAkademik = $('#id_tahun_akademik').val();
    
    if (!idGuru || !idTahunAkademik) {
        $('#subject-selection').html(`
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Pilih guru dan tahun akademik terlebih dahulu untuk melihat mata pelajaran yang tersedia.
            </div>
        `);
        return;
    }

    // Show loading
    $('#subject-selection').html(`
        <div class="text-center py-3">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p class="mt-2">Memuat mata pelajaran yang tersedia...</p>
        </div>
    `);

    $.ajax({
        url: '<?php echo base_url("guru_mapel/get_available_subjects"); ?>',
        type: 'POST',
        data: {
            id_guru: idGuru,
            id_tahun_akademik: idTahunAkademik
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                displaySubjects(data.subjects);
            } else {
                $('#subject-selection').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> ${data.message}
                    </div>
                `);
            }
        },
        error: function() {
            $('#subject-selection').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Terjadi kesalahan saat memuat mata pelajaran
                </div>
            `);
        }
    });
}

function displaySubjects(subjects) {
    if (subjects.length === 0) {
        $('#subject-selection').html(`
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                Tidak ada mata pelajaran yang tersedia untuk guru dan tahun akademik ini.
                Semua mata pelajaran mungkin sudah di-assign.
            </div>
        `);
        return;
    }

    let html = '<div class="subject-checkboxes">';
    html += '<h6 class="mb-3">Pilih Mata Pelajaran:</h6>';
    
    // Group subjects by category
    const groupedSubjects = {};
    subjects.forEach(subject => {
        if (!groupedSubjects[subject.kategori]) {
            groupedSubjects[subject.kategori] = [];
        }
        groupedSubjects[subject.kategori].push(subject);
    });

    // Display subjects by category
    Object.keys(groupedSubjects).forEach(kategori => {
        const categoryClass = kategori === 'umum' ? 'info' : 
                            kategori === 'kejuruan' ? 'success' : 'warning';
        
        html += `<h6 class="mt-3">
                    <span class="badge badge-${categoryClass}">
                        ${kategori.charAt(0).toUpperCase() + kategori.slice(1).replace('_', ' ')}
                    </span>
                </h6>`;
        
        html += '<div class="row">';
        groupedSubjects[kategori].forEach(subject => {
            html += `
                <div class="col-md-6 col-lg-12">
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" 
                               class="custom-control-input" 
                               id="mapel_${subject.id_mapel}" 
                               name="id_mapel[]" 
                               value="${subject.id_mapel}">
                        <label class="custom-control-label" for="mapel_${subject.id_mapel}">
                            <strong>${subject.nama_mapel}</strong>
                            <br><small class="text-muted">(${subject.kode_mapel})</small>
                        </label>
                    </div>
                </div>
            `;
        });
        html += '</div>';
    });

    html += '</div>';
    html += `
        <div class="mt-3">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllSubjects()">
                <i class="fas fa-check-square"></i> Pilih Semua
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllSubjects()">
                <i class="fas fa-square"></i> Batal Pilih Semua
            </button>
        </div>
    `;

    $('#subject-selection').html(html);
}

function loadTeacherInfo() {
    const idGuru = $('#id_guru').val();
    
    if (!idGuru) {
        $('#teacher-info').hide();
        return;
    }

    // You can implement this to show teacher information
    // For now, just show the card
    $('#teacher-info').show();
    $('#teacher-info-content').html(`
        <p><strong>Guru:</strong> ${$('#id_guru option:selected').text()}</p>
        <p><strong>Status:</strong> Aktif</p>
    `);
}

function selectAllSubjects() {
    $('input[name="id_mapel[]"]').prop('checked', true);
}

function deselectAllSubjects() {
    $('input[name="id_mapel[]"]').prop('checked', false);
}
</script>

<style>
.subject-checkboxes {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 1rem;
    background-color: #f8f9fa;
}

.custom-control-label {
    line-height: 1.2;
}

.select2-container--bootstrap4 .select2-selection {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.select2-container--bootstrap4.select2-container--focus .select2-selection {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>