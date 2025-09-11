<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Table Guru</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <!-- button add -->
            <?php
                echo anchor('guru/add', '<button class="btn bg-navy btn-flat margin">Tambah Data</button>');
                echo anchor('guru/generate_schedule_from_curriculum', '<button class="btn bg-orange btn-flat margin">Generate Jadwal dari Kurikulum</button>', 'onclick="return confirm(\'Apakah Anda yakin ingin membuat jadwal dari kurikulum aktif?\')"');
                echo anchor('guru/assignment_matrix', '<button class="btn bg-blue btn-flat margin">Matriks Penugasan</button>');
                echo anchor('guru/workload_report', '<button class="btn bg-green btn-flat margin">Laporan Beban Kerja</button>');
                echo anchor('guru/orphaned_data_report', '<button class="btn bg-red btn-flat margin">Laporan Data Bermasalah</button>');
            ?>

              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NUPTK</th>
                        <th>NAMA GURU</th>
                        <th>GENDER</th>
                        <th>STATUS MATA PELAJARAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
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

<!-- punya lama -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script> -->

<!-- baru tapi cdn -->
<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"> -->

<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<script>
        $(document).ready(function() {
            var t = $('#mytable').DataTable( {
                "ajax": '<?php echo site_url('guru/data'); ?>',
                "order": [[ 1, 'asc' ]],
                "columns": [
                    {
                        "data": null,
                        "width": "50px",
                        "class": "text-center",
                        "orderable": false,
                    },
                    {
                        "data": "nuptk",
                        "width": "120px",
                        "class": "text-center"
                    },
                    {
                        "data": "nama_guru",
                    },
                    {
                        "data": "gender",
                        "width": "150px"
                    },
                    {
                        "data": "status_mapel",
                        "width": "150px",
                        "class": "text-center"
                    },
                    {
                        "data": "aksi",
                        "width": "200px",
                        "class": "text-center"
                    },
                ]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
</script>
