<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Matriks Penugasan Mata Pelajaran per Kelas</h3>
              <div class="box-tools pull-right">
                <?php echo anchor('guru', '<button class="btn btn-default btn-sm">Kembali</button>'); ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <!-- Filter Form -->
              <form method="get" class="form-inline" style="margin-bottom: 20px;">
                <div class="form-group">
                  <label for="jurusan">Jurusan:</label>
                  <select name="jurusan" id="jurusan" class="form-control">
                    <option value="">-- Semua Jurusan --</option>
                    <?php foreach($jurusan_list as $jurusan): ?>
                      <option value="<?php echo $jurusan->kd_jurusan; ?>" <?php echo ($selected_jurusan == $jurusan->kd_jurusan) ? 'selected' : ''; ?>>
                        <?php echo $jurusan->nama_jurusan; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="form-group" style="margin-left: 10px;">
                  <label for="tingkatan">Tingkatan:</label>
                  <select name="tingkatan" id="tingkatan" class="form-control">
                    <option value="">-- Semua Tingkatan --</option>
                    <?php foreach($tingkatan_list as $tingkatan): ?>
                      <option value="<?php echo $tingkatan->kd_tingkatan; ?>" <?php echo ($selected_tingkatan == $tingkatan->kd_tingkatan) ? 'selected' : ''; ?>>
                        <?php echo $tingkatan->nama_tingkatan; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Filter</button>
              </form>

              <!-- Legend -->
              <div class="alert alert-info">
                <strong>Keterangan Status:</strong>
                <span class="label label-success">ASSIGNED</span> = Sudah ditugaskan ke guru
                <span class="label label-warning">UNASSIGNED</span> = Belum ditugaskan ke guru
                <span class="label label-default">NOT_SCHEDULED</span> = Belum ada jadwal
              </div>

              <?php if(empty($matrix)): ?>
                <div class="alert alert-warning">
                  <h4><i class="icon fa fa-warning"></i> Tidak Ada Data!</h4>
                  <p>Tidak ada data matriks untuk filter yang dipilih.</p>
                </div>
              <?php else: ?>

              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                  <thead>
                      <tr>
                          <th>KELAS</th>
                          <th>JURUSAN</th>
                          <th>TINGKATAN</th>
                          <th>MATA PELAJARAN</th>
                          <th>STATUS</th>
                          <th>GURU</th>
                          <th>AKSI</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach($matrix as $row): ?>
                      <tr class="<?php echo ($row->status_guru == 'UNASSIGNED') ? 'warning' : (($row->status_guru == 'NOT_SCHEDULED') ? 'active' : ''); ?>">
                          <td><?php echo $row->nama_kelas; ?></td>
                          <td><?php echo $row->nama_jurusan; ?></td>
                          <td><?php echo $row->nama_tingkatan; ?></td>
                          <td><?php echo $row->nama_mapel; ?></td>
                          <td>
                            <?php if($row->status_guru == 'ASSIGNED'): ?>
                              <span class="label label-success">ASSIGNED</span>
                            <?php elseif($row->status_guru == 'UNASSIGNED'): ?>
                              <span class="label label-warning">UNASSIGNED</span>
                            <?php else: ?>
                              <span class="label label-default">NOT_SCHEDULED</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($row->id_guru > 0): ?>
                              <?php echo $row->nama_guru; ?>
                            <?php else: ?>
                              <em>Belum ditugaskan</em>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($row->status_guru == 'UNASSIGNED'): ?>
                              <button class="btn btn-xs btn-success" onclick="quickAssign('<?php echo $row->kd_kelas; ?>', '<?php echo $row->kd_mapel; ?>')">
                                <i class="fa fa-plus"></i> Tugaskan
                              </button>
                            <?php elseif($row->status_guru == 'ASSIGNED'): ?>
                              <a href="<?php echo site_url('guru/subjects/'.$row->id_guru); ?>" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i> Lihat
                              </a>
                            <?php endif; ?>
                          </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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

<!-- Quick Assignment Modal -->
<div class="modal fade" id="quickAssignModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tugaskan Guru</h4>
      </div>
      <div class="modal-body">
        <form id="quickAssignForm">
          <input type="hidden" id="assign_kd_kelas" name="kd_kelas">
          <input type="hidden" id="assign_kd_mapel" name="kd_mapel">
          
          <div class="form-group">
            <label>Kelas:</label>
            <input type="text" id="assign_kelas_name" class="form-control" readonly>
          </div>
          
          <div class="form-group">
            <label>Mata Pelajaran:</label>
            <input type="text" id="assign_mapel_name" class="form-control" readonly>
          </div>
          
          <div class="form-group">
            <label>Pilih Guru:</label>
            <select name="id_guru" id="assign_id_guru" class="form-control" required>
              <option value="">-- Pilih Guru --</option>
              <?php
              $guru_list = $this->db->get('tbl_guru')->result();
              foreach($guru_list as $guru):
                if($guru->id_guru > 0):
              ?>
                <option value="<?php echo $guru->id_guru; ?>"><?php echo $guru->nama_guru; ?></option>
              <?php 
                endif;
              endforeach; 
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitQuickAssign()">Tugaskan</button>
      </div>
    </div>
  </div>
</div>

<script>
function quickAssign(kd_kelas, kd_mapel) {
  // Find the row data for better UX
  var row = $('tr').filter(function() {
    return $(this).find('td:eq(0)').text().includes(kd_kelas) && 
           $(this).find('td:eq(3)').text().includes(kd_mapel);
  });
  
  $('#assign_kd_kelas').val(kd_kelas);
  $('#assign_kd_mapel').val(kd_mapel);
  $('#assign_kelas_name').val(row.find('td:eq(0)').text());
  $('#assign_mapel_name').val(row.find('td:eq(3)').text());
  
  $('#quickAssignModal').modal('show');
}

function submitQuickAssign() {
  var formData = $('#quickAssignForm').serialize();
  
  $.ajax({
    url: '<?php echo site_url('guru/quick_assign'); ?>',
    type: 'POST',
    data: formData,
    success: function(response) {
      var data = JSON.parse(response);
      if(data.status === 'success') {
        $('#quickAssignModal').modal('hide');
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    },
    error: function() {
      alert('Terjadi kesalahan saat menugaskan guru');
    }
  });
}
</script>