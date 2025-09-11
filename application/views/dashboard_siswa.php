<!-- Main content -->
<section class="content">

  <!-- Welcome Section -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-graduation-cap"></i> Selamat Datang, <?php echo $siswa['nama']; ?>!
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-id-card"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">NISN</span>
                  <span class="info-box-number"><?php echo $siswa['nisn']; ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-school"></i></span>
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

  <!-- Charts Section -->
  <div class="row">
    <div class="col-md-8">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-chart-bar"></i> Perkembangan Nilai per Mata Pelajaran
          </h3>
        </div>
        <div class="box-body">
          <canvas id="barChart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-chart-pie"></i> Distribusi Nilai
          </h3>
        </div>
        <div class="box-body">
          <canvas id="doughnutChart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Grade Details Table -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-table"></i> Detail Nilai Akademik
          </h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Mata Pelajaran</th>
                  <th class="text-center">Nilai</th>
                  <th class="text-center">Keterangan</th>
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

                if ($nilai_siswa->num_rows() > 0) {
                  foreach ($nilai_siswa->result() as $row) {
                    $subjects[] = $row->nama_mapel;
                    $grades[] = $row->nilai;

                    if($row->nilai > 90){
                      $keterangan = '<span class="label label-success"><i class="fa fa-star"></i> Sangat Baik</span>';
                      $excellent++;
                    }elseif($row->nilai > 80 && $row->nilai <= 90){
                      $keterangan = '<span class="label label-primary"><i class="fa fa-thumbs-up"></i> Baik</span>';
                      $good++;
                    }elseif($row->nilai > 70 && $row->nilai <= 80){
                      $keterangan = '<span class="label label-warning"><i class="fa fa-exclamation-triangle"></i> Cukup</span>';
                      $fair++;
                    }else{
                      $keterangan = '<span class="label label-danger"><i class="fa fa-times"></i> Kurang</span>';
                      $poor++;
                    }

                    echo "<tr>
                            <td class='text-center'>$no</td>
                            <td>$row->nama_mapel</td>
                            <td class='text-center'><strong>$row->nilai</strong></td>
                            <td class='text-center'>$keterangan</td>
                          </tr>";
                    $no++;
                  }
                } else {
                  echo "<tr><td colspan='4' class='text-center text-muted'>Belum ada data nilai</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->

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
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        borderRadius: 4,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 100,
          ticks: {
            stepSize: 10
          },
          grid: {
            color: 'rgba(0,0,0,0.1)'
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },
      animation: {
        duration: 2000,
        easing: 'easeInOutQuart'
      }
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
        borderWidth: 2,
        hoverBorderWidth: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              var label = context.label || '';
              if (label) {
                label += ': ';
              }
              label += context.parsed + ' mata pelajaran';
              return label;
            }
          }
        }
      },
      animation: {
        animateScale: true,
        animateRotate: true,
        duration: 2000,
        easing: 'easeInOutQuart'
      }
    }
  });
});
</script>