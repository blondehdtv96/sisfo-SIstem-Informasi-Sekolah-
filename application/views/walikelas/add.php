<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Wali Kelas</h5>
                        <?php echo anchor('walikelas', '<i class="fas fa-arrow-left me-1"></i> Kembali', 'class="btn btn-light"'); ?>
                    </div>
                    <div class="card-body">
                        <?php echo form_open('walikelas/add', 'class="row g-3"'); ?>
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-calendar-alt me-2"></i>Informasi Tahun Akademik</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tahun Akademik</label>
                                                    <input type="text" class="form-control" value="<?php echo $tahun_akademik ? $tahun_akademik->tahun_ajar : ''; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Semester</label>
                                                    <input type="text" class="form-control" value="<?php echo $tahun_akademik ? ucfirst($tahun_akademik->semester) : ''; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_tahun_akademik" value="<?php echo $tahun_akademik ? $tahun_akademik->id_tahun_akademik : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="id_guru" class="form-label fw-bold">Guru <span class="text-danger">*</span></label>
                                    <select name="id_guru" id="id_guru" class="form-select" required>
                                        <option value="">-- Pilih Guru --</option>
                                        <?php foreach($available_teachers as $guru): ?>
                                            <option value="<?php echo $guru->id_guru; ?>"><?php echo $guru->nama_guru; ?> (<?php echo $guru->nuptk; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="id_kelas" class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                                    <select name="id_kelas" id="id_kelas" class="form-select" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php foreach($available_classes as $kelas): ?>
                                            <option value="<?php echo $kelas->id_kelas; ?>">
                                                <?php echo $kelas->nama_kelas; ?> - <?php echo $kelas->nama_jurusan; ?> (<?php echo $kelas->nama_tingkatan; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" name="submit" class="btn btn-primary me-md-2">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                    <?php echo anchor('walikelas', '<i class="fas fa-times me-1"></i> Batal', 'class="btn btn-secondary"'); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>