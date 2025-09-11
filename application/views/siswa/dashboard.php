<section class="content-header">
  <h1>
    Dashboard Siswa
    <small>Informasi dan perkembangan nilai</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Selamat Datang, <?php echo $siswa['nama']; ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">NISN</span>
                  <span class="info-box-number"><?php echo $siswa['nisn']; ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-graduation-cap"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Kelas</span>
                  <span class="info-box-number"><?php echo $siswa['kd_kelas']; ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Nilai per Mata Pelajaran</h3>
        </div>
        <div class="box-body">
          <canvas id="barChart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Distribusi Nilai</h3>
        </div>
        <div class="box-body">
          <canvas id="doughnutChart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Nilai</h3>
        </div>
        <div class="box-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $subjects = [];
              $grades = [];
              $excellent = 0;
              $good = 0;
              $fair = 0;
              $poor = 0;

              foreach ($nilai_siswa->result() as $row) {
                $subjects[] = $row->nama_mapel;
                $grades[] = $row->nilai;

                if($row->nilai > 90){
                  $keterangan = '<span class="label label-success">Sangat Baik</span>';
                  $excellent++;
                }elseif($row->nilai > 80 && $row->nilai <= 90){
                  $keterangan = '<span class="label label-primary">Baik</span>';
                  $good++;
                }elseif($row->nilai > 70 && $row->nilai <= 80){
                  $keterangan = '<span class="label label-warning">Cukup</span>';
                  $fair++;
                }else{
                  $keterangan = '<span class="label label-danger">Kurang</span>';
                  $poor++;
                }

                echo "<tr>
                        <td>$no</td>
                        <td>$row->nama_mapel</td>
                        <td>$row->nilai</td>
                        <td>$keterangan</td>
                      </tr>";
                $no++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Chart.js -->
<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/Chart.js"></script>

<script>
$(document).ready(function() {
  // Bar Chart
  var ctxBar = document.getElementById('barChart').getContext('2d');
  var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($subjects); ?>,
      datasets: [{
        label: 'Nilai',
        data: <?php echo json_encode($grades); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            max: 100
          }
        }]
      },
      responsive: true,
      maintainAspectRatio: false
    }
  });

  // Doughnut Chart
  var ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
  var doughnutChart = new Chart(ctxDoughnut, {
    type: 'doughnut',
    data: {
      labels: ['Sangat Baik (>90)', 'Baik (81-90)', 'Cukup (71-80)', 'Kurang (≤70)'],
      datasets: [{
        data: [<?php echo $excellent; ?>, <?php echo $good; ?>, <?php echo $fair; ?>, <?php echo $poor; ?>],
        backgroundColor: [
          'rgba(40, 167, 69, 0.8)',
          'rgba(0, 123, 255, 0.8)',
          'rgba(255, 193, 7, 0.8)',
          'rgba(220, 53, 69, 0.8)'
        ],
        borderColor: [
          'rgba(40, 167, 69, 1)',
          'rgba(0, 123, 255, 1)',
          'rgba(255, 193, 7, 1)',
          'rgba(220, 53, 69, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: 'bottom'
      }
    }
  });
});
</script>