<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Tambah Mata Pelajaran untuk Guru: <?php echo $guru['nama_guru']; ?></h3>
              <div class="box-tools pull-right">
                <?php echo anchor('guru/subjects/'.$guru['id_guru'], '<button class="btn btn-default btn-sm">Kembali</button>'); ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php if(isset($error_message)): ?>
                <div class="alert alert-danger">
                  <h4><i class="icon fa fa-exclamation-triangle"></i> Error!</h4>
                  <p><?php echo $error_message; ?></p>
                </div>
              <?php elseif(empty($unassigned_subjects) && empty($available_subjects)): ?>
                <div class="alert alert-warning">
                  <h4><i class="icon fa fa-warning"></i> Tidak Ada Mata Pelajaran Tersedia!</h4>
                  <p>Semua mata pelajaran sudah memiliki guru yang mengampu, atau belum ada jadwal yang dibuat dari kurikulum.</p>
                  <p>
                    <?php echo anchor('guru/generate_schedule_from_curriculum', '<button class="btn btn-primary">Buat Jadwal dari Kurikulum</button>', 'onclick="return confirm(\'Apakah Anda yakin ingin membuat jadwal dari kurikulum aktif?\')"'); ?>
                  </p>
                </div>
              <?php else: ?>

              <form action="<?php echo site_url('guru/save_assignments'); ?>" method="post">
                <input type="hidden" name="id_guru" value="<?php echo $guru['id_guru']; ?>">

                <div class="alert alert-info">
                  <strong>Petunjuk:</strong> Pilih mata pelajaran yang ingin diberikan kepada guru ini, kemudian klik "Simpan".
                </div>

                <?php if(!empty($unassigned_subjects)): ?>
                <h4>Jadwal yang Belum Ditetapkan Guru</h4>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                          <th width="50px">
                            <input type="checkbox" id="checkAllUnassigned">
                          </th>
                          <th>MATA PELAJARAN</th>
                          <th>KELAS</th>
                          <th>JURUSAN</th>
                          <th>TINGKATAN</th>
                          <th>HARI</th>
                          <th>JAM</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach($unassigned_subjects as $row): ?>
                      <tr class="<?php echo (strpos($row->nama_mapel, '[') !== false || strpos($row->nama_kelas, '[') !== false) ? 'warning' : ''; ?>">
                          <td>
                            <input type="checkbox" name="jadwal_ids[]" value="<?php echo $row->id_jadwal; ?>" class="subject-checkbox-unassigned">
                          </td>
                          <td>
                            <?php echo $row->nama_mapel; ?>
                            <?php if(strpos($row->nama_mapel, '[') !== false): ?>
                              <span class="label label-danger">Data Hilang</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php echo $row->nama_kelas; ?>
                            <?php if(strpos($row->nama_kelas, '[') !== false): ?>
                              <span class="label label-danger">Data Hilang</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo $row->nama_jurusan; ?></td>
                          <td><?php echo $row->nama_tingkatan; ?></td>
                          <td><?php echo $row->hari ?: '-'; ?></td>
                          <td><?php echo $row->jam ?: '-'; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?php endif; ?>

                <?php if(!empty($available_subjects)): ?>
                <h4>Mata Pelajaran dari Kurikulum (Belum Dijadwalkan)</h4>
                <p class="text-muted">Mata pelajaran ini akan ditambahkan ke jadwal guru tanpa jadwal spesifik</p>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                          <th width="50px">
                            <input type="checkbox" id="checkAllAvailable">
                          </th>
                          <th>MATA PELAJARAN</th>
                          <th>JURUSAN</th>
                          <th>TINGKATAN</th>
                          <th>JENIS</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach($available_subjects as $row): ?>
                      <tr>
                          <td>
                            <input type="checkbox" name="kurikulum_ids[]" value="<?php echo $row->id_kurikulum_detail; ?>" class="subject-checkbox-available">
                          </td>
                          <td><?php echo $row->nama_mapel; ?></td>
                          <td><?php echo $row->nama_jurusan; ?></td>
                          <td><?php echo $row->nama_tingkatan; ?></td>
                          <td>Kurikulum</td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?php endif; ?>

                <div class="box-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Simpan Penugasan</button>
                  <a href="<?php echo site_url('guru/subjects/'.$guru['id_guru']); ?>" class="btn btn-default">Batal</a>
                </div>

              </form>

              <?php endif; ?>

              <!-- Debug Information (remove in production) -->
              <?php if(isset($debug_info)): ?>
              <div class="box-footer">
                <h5>Debug Information:</h5>
                <ul>
                  <li>Total Mata Pelajaran: <?php echo $debug_info['total_subjects']; ?></li>
                  <li>Total Entri Jadwal: <?php echo $debug_info['total_schedule_entries']; ?></li>
                  <li>Jadwal Belum Ditetapkan: <?php echo $debug_info['unassigned_schedule_entries']; ?></li>
                  <li>Tahun Akademik Aktif: <?php echo $debug_info['active_academic_year'] ? $debug_info['active_academic_year']->tahun_akademik : 'Tidak ada'; ?></li>
                  <li>Kurikulum Aktif: <?php echo $debug_info['active_curriculum'] ? $debug_info['active_curriculum']->nama_kurikulum : 'Tidak ada'; ?></li>
                </ul>
              </div>
              <?php endif; ?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script>
$(document).ready(function() {
  // Check all functionality for unassigned subjects
  $('#checkAllUnassigned').on('change', function() {
    $('.subject-checkbox-unassigned').prop('checked', $(this).prop('checked'));
  });

  // Individual checkbox change for unassigned subjects
  $('.subject-checkbox-unassigned').on('change', function() {
    if (!$(this).prop('checked')) {
      $('#checkAllUnassigned').prop('checked', false);
    } else {
      var allChecked = $('.subject-checkbox-unassigned:checked').length === $('.subject-checkbox-unassigned').length;
      $('#checkAllUnassigned').prop('checked', allChecked);
    }
  });

  // Check all functionality for available subjects
  $('#checkAllAvailable').on('change', function() {
    $('.subject-checkbox-available').prop('checked', $(this).prop('checked'));
  });

  // Individual checkbox change for available subjects
  $('.subject-checkbox-available').on('change', function() {
    if (!$(this).prop('checked')) {
      $('#checkAllAvailable').prop('checked', false);
    } else {
      var allChecked = $('.subject-checkbox-available:checked').length === $('.subject-checkbox-available').length;
      $('#checkAllAvailable').prop('checked', allChecked);
    }
  });
});
</script>