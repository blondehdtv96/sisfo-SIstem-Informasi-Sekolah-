<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Beban Kerja Guru</h3>
              <div class="box-tools pull-right">
                <?php echo anchor('guru', '<button class="btn btn-default btn-sm">Kembali</button>'); ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php if(empty($workload_summary)): ?>
                <div class="alert alert-warning">
                  <h4><i class="icon fa fa-warning"></i> Tidak Ada Data!</h4>
                  <p>Tidak ada data beban kerja guru.</p>
                </div>
              <?php else: ?>

              <div class="row">
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Guru</span>
                      <span class="info-box-number"><?php echo count($workload_summary); ?></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Guru Aktif Mengajar</span>
                      <span class="info-box-number">
                        <?php 
                        $active_teachers = array_filter($workload_summary, function($teacher) {
                          return $teacher->total_mapel > 0;
                        });
                        echo count($active_teachers);
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-warning"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Guru Tanpa Mapel</span>
                      <span class="info-box-number">
                        <?php 
                        $inactive_teachers = array_filter($workload_summary, function($teacher) {
                          return $teacher->total_mapel == 0;
                        });
                        echo count($inactive_teachers);
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Rata-rata Mapel</span>
                      <span class="info-box-number">
                        <?php 
                        $total_mapel = array_sum(array_column($workload_summary, 'total_mapel'));
                        $avg = count($workload_summary) > 0 ? round($total_mapel / count($workload_summary), 1) : 0;
                        echo $avg;
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <table class="table table-striped table-bordered table-hover" id="workloadTable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA GURU</th>
                        <th>TOTAL MATA PELAJARAN</th>
                        <th>TOTAL KELAS</th>
                        <th>TOTAL JAM MENGAJAR</th>
                        <th>DAFTAR MATA PELAJARAN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($workload_summary as $row): ?>
                    <tr class="<?php echo ($row->total_mapel == 0) ? 'warning' : ''; ?>">
                        <td><?php echo $no++; ?></td>
                        <td>
                          <strong><?php echo $row->nama_guru; ?></strong>
                          <?php if($row->total_mapel == 0): ?>
                            <br><small class="text-muted">Belum ada penugasan</small>
                          <?php endif; ?>
                        </td>
                        <td class="text-center">
                          <span class="badge <?php echo ($row->total_mapel > 0) ? 'bg-green' : 'bg-red'; ?>">
                            <?php echo $row->total_mapel; ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <span class="badge <?php echo ($row->total_kelas > 0) ? 'bg-blue' : 'bg-gray'; ?>">
                            <?php echo $row->total_kelas; ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <span class="badge <?php echo ($row->total_jam_mengajar > 0) ? 'bg-purple' : 'bg-gray'; ?>">
                            <?php echo $row->total_jam_mengajar; ?>
                          </span>
                        </td>
                        <td>
                          <?php if(!empty($row->daftar_mapel)): ?>
                            <small><?php echo $row->daftar_mapel; ?></small>
                          <?php else: ?>
                            <em class="text-muted">Belum ada mata pelajaran</em>
                          <?php endif; ?>
                        </td>
                        <td class="text-center">
                          <?php if($row->total_mapel == 0): ?>
                            <span class="label label-warning">Tidak Aktif</span>
                          <?php elseif($row->total_mapel >= 1 && $row->total_mapel <= 3): ?>
                            <span class="label label-success">Normal</span>
                          <?php elseif($row->total_mapel >= 4 && $row->total_mapel <= 6): ?>
                            <span class="label label-info">Sibuk</span>
                          <?php else: ?>
                            <span class="label label-danger">Overload</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <div class="btn-group">
                            <a href="<?php echo site_url('guru/subjects/'.$row->id_guru); ?>" class="btn btn-xs btn-info" title="Lihat Mata Pelajaran">
                              <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?php echo site_url('guru/assign_subjects/'.$row->id_guru); ?>" class="btn btn-xs btn-success" title="Tambah Mata Pelajaran">
                              <i class="fa fa-plus"></i>
                            </a>
                            <a href="<?php echo site_url('guru/edit/'.$row->id_guru); ?>" class="btn btn-xs btn-warning" title="Edit Guru">
                              <i class="fa fa-edit"></i>
                            </a>
                          </div>
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
$(document).ready(function() {
  $('#workloadTable').DataTable({
    "order": [[ 2, "desc" ]], // Sort by total mata pelajaran descending
    "pageLength": 25,
    "language": {
      "search": "Pencarian:",
      "lengthMenu": "Tampilkan _MENU_ data per halaman",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      "paginate": {
        "first": "Pertama",
        "last": "Terakhir",
        "next": "Selanjutnya",
        "previous": "Sebelumnya"
      }
    }
  });
});
</script>