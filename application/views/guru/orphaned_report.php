<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-danger">
            <div class="box-header  with-border">
              <h3 class="box-title">Laporan Data Jadwal Bermasalah</h3>
              <div class="box-tools pull-right">
                <?php echo anchor('guru/cleanup_orphaned_data', '<button class="btn btn-warning btn-sm" onclick="return confirm(\'Bersihkan semua data bermasalah? Ini akan menghapus data yang tidak valid.\')">Bersihkan Data</button>'); ?>
                <?php echo anchor('guru', '<button class="btn btn-default btn-sm">Kembali</button>'); ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php if(empty($orphaned_entries)): ?>
                <div class="alert alert-success">
                  <h4><i class="icon fa fa-check"></i> Data Bersih!</h4>
                  <p>Tidak ada data jadwal yang bermasalah ditemukan.</p>
                </div>
              <?php else: ?>

              <div class="alert alert-warning">
                <h4><i class="icon fa fa-warning"></i> Ditemukan <?php echo count($orphaned_entries); ?> Data Bermasalah!</h4>
                <p>Berikut adalah data jadwal yang memiliki referensi ke data yang tidak ditemukan:</p>
              </div>

              <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID JADWAL</th>
                        <th>ID GURU</th>
                        <th>KODE MAPEL</th>
                        <th>KODE KELAS</th>
                        <th>MASALAH</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($orphaned_entries as $row): ?>
                    <tr class="danger">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row->id_jadwal; ?></td>
                        <td><?php echo $row->id_guru; ?></td>
                        <td><?php echo $row->kd_mapel; ?></td>
                        <td><?php echo $row->kd_kelas; ?></td>
                        <td>
                          <?php if(!empty($row->guru_issue)): ?>
                            <span class="label label-danger"><?php echo $row->guru_issue; ?></span><br>
                          <?php endif; ?>
                          <?php if(!empty($row->mapel_issue)): ?>
                            <span class="label label-warning"><?php echo $row->mapel_issue; ?></span><br>
                          <?php endif; ?>
                          <?php if(!empty($row->kelas_issue)): ?>
                            <span class="label label-info"><?php echo $row->kelas_issue; ?></span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <button class="btn btn-xs btn-danger" onclick="deleteSchedule(<?php echo $row->id_jadwal; ?>)">
                            <i class="fa fa-times"></i> Hapus
                          </button>
                        </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

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
function deleteSchedule(id_jadwal) {
  if(confirm('Apakah Anda yakin ingin menghapus entri jadwal ini?')) {
    $.ajax({
      url: '<?php echo site_url('guru/delete_schedule_entry'); ?>',
      type: 'POST',
      data: {id_jadwal: id_jadwal},
      success: function(response) {
        location.reload();
      },
      error: function() {
        alert('Terjadi kesalahan saat menghapus entri jadwal');
      }
    });
  }
}
</script>