<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Mata Pelajaran Guru: <?php echo $guru['nama_guru']; ?></h3>
              <div class="box-tools pull-right">
                <?php echo anchor('guru/assign_subjects/'.$guru['id_guru'], '<button class="btn btn-success btn-sm">Tambah Mata Pelajaran</button>'); ?>
                <?php echo anchor('guru', '<button class="btn btn-default btn-sm">Kembali</button>'); ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php if(empty($subjects)): ?>
                <div class="alert alert-warning">
                  <h4><i class="icon fa fa-warning"></i> Belum Ada Mata Pelajaran!</h4>
                  <p>Guru ini belum memiliki mata pelajaran yang diampu.</p>
                  <p>Silakan klik tombol "Tambah Mata Pelajaran" untuk menambahkan mata pelajaran ke guru ini.</p>
                  <p>Jika belum ada jadwal yang dibuat, Anda dapat membuatnya terlebih dahulu dari menu Guru.</p>
                </div>
              <?php else: ?>

              <!-- Warning for missing data -->
              <?php if(!empty($teacher_orphaned)): ?>
                <div class="alert alert-danger">
                  <h4><i class="icon fa fa-exclamation-triangle"></i> Data Tidak Lengkap Ditemukan!</h4>
                  <p>Beberapa mata pelajaran guru ini memiliki data yang tidak lengkap atau tidak ditemukan.</p>
                  <p>
                    <a href="<?php echo site_url('guru/fix_teacher_data/'.$guru['id_guru']); ?>" class="btn btn-warning btn-sm" onclick="return confirm('Perbaiki data yang tidak lengkap?')">Perbaiki Data</a>
                  </p>
                </div>
              <?php endif; ?>

              <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>MATA PELAJARAN</th>
                        <th>KELAS</th>
                        <th>JURUSAN</th>
                        <th>TINGKATAN</th>
                        <th>HARI</th>
                        <th>JAM</th>
                        <th>SEMESTER</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($subjects as $row): ?>
                    <tr class="<?php echo (strpos($row->nama_mapel, '[DATA') !== false || strpos($row->nama_kelas, '[DATA') !== false) ? 'danger' : ''; ?>">
                        <td><?php echo $no++; ?></td>
                        <td>
                          <?php echo $row->nama_mapel; ?>
                          <?php if(strpos($row->nama_mapel, '[DATA') !== false): ?>
                            <span class="label label-danger">Data Hilang</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php echo $row->nama_kelas; ?>
                          <?php if(strpos($row->nama_kelas, '[DATA') !== false): ?>
                            <span class="label label-danger">Data Hilang</span>
                          <?php endif; ?>
                        </td>
                        <td><?php echo isset($row->nama_jurusan) ? $row->nama_jurusan : '-'; ?></td>
                        <td><?php echo isset($row->nama_tingkatan) ? $row->nama_tingkatan : '-'; ?></td>
                        <td><?php echo $row->hari ?: '-'; ?></td>
                        <td><?php echo $row->jam ?: '-'; ?></td>
                        <td><?php echo $row->semester ?: '-'; ?></td>
                        <td>
                          <?php if(strpos($row->nama_mapel, '[DATA') !== false || strpos($row->nama_kelas, '[DATA') !== false): ?>
                            <span class="label label-danger">Data Tidak Lengkap</span>
                          <?php else: ?>
                            <span class="label label-success">Data Lengkap</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <button class="btn btn-xs btn-danger" onclick="removeSubject(<?php echo $row->id_jadwal; ?>, <?php echo $guru['id_guru']; ?>)">
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
function removeSubject(id_jadwal, id_guru) {
  if(confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini dari guru?')) {
    $.ajax({
      url: '<?php echo site_url('guru/remove_subject'); ?>',
      type: 'POST',
      data: {id_jadwal: id_jadwal},
      success: function(response) {
        location.reload();
      },
      error: function() {
        alert('Terjadi kesalahan saat menghapus mata pelajaran');
      }
    });
  }
}
</script>