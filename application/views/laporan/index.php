<section class="content">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line me-2"></i>
                            Sistem Laporan
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Pilih jenis laporan yang ingin Anda buat dan cetak.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Menu Cards -->
        <div class="row">
            <!-- Student Reports -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Laporan Siswa
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo site_url('laporan/siswa'); ?>" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-eye"></i> Buat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teacher Reports -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Laporan Guru
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo site_url('laporan/guru'); ?>" class="btn btn-success btn-sm btn-block">
                                <i class="fas fa-eye"></i> Buat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Reports -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Laporan Kelas
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-school fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo site_url('laporan/kelas'); ?>" class="btn btn-info btn-sm btn-block">
                                <i class="fas fa-eye"></i> Buat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Reports -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Laporan Statistik
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-chart-pie fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo site_url('laporan/statistik'); ?>" class="btn btn-warning btn-sm btn-block">
                                <i class="fas fa-eye"></i> Buat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Laporan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-pdf text-danger"></i> Format PDF</h6>
                                <ul class="list-unstyled">
                                    <li>• Cocok untuk pencetakan formal</li>
                                    <li>• Format profesional dan terstruktur</li>
                                    <li>• Dapat dibuka di semua perangkat</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-excel text-success"></i> Format Excel</h6>
                                <ul class="list-unstyled">
                                    <li>• Dapat diedit dan dianalisis lebih lanjut</li>
                                    <li>• Mendukung kalkulasi dan formula</li>
                                    <li>• Mudah untuk berbagi data</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>