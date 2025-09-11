<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Informasi Kelas</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                <tr>
                    <td width="200">Tahun Akademik</td>
                    <td> : <?php echo get_tahun_akademik('tahun_akademik'); ?></td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td> : <?php echo get_tahun_akademik('semester'); ?></td>
                </tr>
                <tr>
                    <td>Jurusan &amp; Tingkatan</td>
                    <td> : <?php echo "Jurusan".' '.$kelas['nama_jurusan'].' '.$kelas['nama_tingkatan']; ?> (<?php echo $kelas['nama_kelas']; ?>)</td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td><?php echo $kelas['nama_mapel']?></td>
                </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Daftar Siswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" width="100">NISN</th>
                        <th>NAMA SISWA</th>
                        <th class="text-center">NILAI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($siswa)) {
                            foreach ($siswa as $row) {
                                $current_nilai = check_nilai($row->nisn, $this->uri->segment(3));
                                echo "<tr>
                                        <td class='text-center'>{$row->nisn}</td>
                                        <td>{$row->nama}</td>
                                        <td width='100'>
                                            <input type='number' min='0' max='100' onKeyUp='updateNilai(\"{$row->nisn}\")' id='nilai{$row->nisn}' value='{$current_nilai}' class='form-control' placeholder='0-100'>
                                        </td>
                                     </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center text-muted'>Tidak ada data siswa</td></tr>";
                        }
                    ?>
                </tbody>

              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<!-- onKeyUp='updateNilai(\"$row->nisn\")' -->
<!-- untuk memberikan parameter string di javascript harus diikuti dengan \" \" -->

<script type="text/javascript">
    function updateNilai(nisn)
    {
        var nilai = $("#nilai"+nisn).val();
        var id_jadwal = <?php echo json_encode($this->uri->segment(3)); ?>;

        // Basic validation
        if (nilai === '' || isNaN(nilai) || nilai < 0 || nilai > 100) {
            alert('Nilai harus berupa angka antara 0-100');
            return;
        }

        // Disable input during update
        $("#nilai"+nisn).prop('disabled', true);

        $.ajax({
            type    : 'POST',
            url     : '<?php echo base_url(); ?>nilai/update_nilai',
            data    : {
                nisn: nisn,
                id_jadwal: id_jadwal,
                nilai: nilai
            },
            dataType: 'json',
            success : function(response) {
                if (response.status === 'success') {
                    // Show success message (you can use a toast notification here)
                    console.log(response.message);
                    // Optional: Add visual feedback
                    $("#nilai"+nisn).addClass('success-input');
                    setTimeout(function() {
                        $("#nilai"+nisn).removeClass('success-input');
                    }, 1000);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Terjadi kesalahan saat menyimpan nilai. Silakan coba lagi.');
            },
            complete: function() {
                // Re-enable input
                $("#nilai"+nisn).prop('disabled', false);
            }
        });
    }
</script>

<style>
.success-input {
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
}
</style>