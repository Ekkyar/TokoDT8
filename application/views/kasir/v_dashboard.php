<!-- Begin Page Content -->
<div class="container-fluid">

    <!--  -->
    <div class="row">
        <!-- Pendapatan -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pendapatan Bulan Ini</div>
                            <div class="mb-0 font-weight-bold text-primary">+ <?= format_uang($total_transaksi); ?> </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Barang -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Data Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $barang; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Stok -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Stok Barang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok; ?></div>
                                </div>
                                <div class="col-auto">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

    <!-- Chart -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Chart Transaksi Barang Masuk dan Penjualan Tahun <?= date('Y'); ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myAreaChart" width="669" height="320" class="chartjs-render-monitor" style="display: block; width: 669px; height: 320px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-danger py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">Transaksi Terakhir Penjualan</h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 table-sm table-striped text-center">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi['barang_keluar'] as $tbk) : ?>
                                <tr>
                                    <td><?= $tbk['tanggal']; ?></td>
                                    <td><?= $tbk['nama_barang']; ?></td>
                                    <td><span class="badge badge-danger"><?= $tbk['qty']; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- chart -->

</div>
<!-- /.container-fluid -->