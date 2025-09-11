<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i>Edit Wali Kelas</h5>
                        <?php echo anchor('walikelas', '<i class="fas fa-arrow-left me-1"></i> Kembali', 'class="btn btn-light"'); ?>
                    </div>
                    <div class="card-body">
                        <?php echo form_open('walikelas/edit', 'class="row g-3"'); ?>
                            <input type="hidden" name="id_walikelas" value="<?php echo $walikelas->id_wali_kelas; ?>">

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
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-school me-2"></i>Informasi Kelas</h6>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kelas</label>
                                            <input type="text" class="form-control" value="<?php echo $walikelas->nama_kelas; ?> - <?php echo $walikelas->nama_jurusan; ?> (<?php echo $walikelas->nama_tingkatan; ?>)" readonly>
                                        </div>
                                        <input type="hidden" name="id_kelas" value="<?php echo $walikelas->id_kelas; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="id_guru" class="form-label fw-bold">Guru <span class="text-danger">*</span></label>
                                    <select name="id_guru" id="id_guru" class="form-select" required>
                                        <option value="">-- Pilih Guru --</option>
                                        <?php foreach($available_teachers as $guru): ?>
                                            <option value="<?php echo $guru->id_guru; ?>" <?php echo ($walikelas->id_guru == $guru->id_guru) ? 'selected' : ''; ?>>
                                                <?php echo $guru->nama_guru; ?> (<?php echo $guru->nuptk; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" name="submit" class="btn btn-primary me-md-2">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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