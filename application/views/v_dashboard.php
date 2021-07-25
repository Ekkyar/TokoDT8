<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Pendapatan/Pengeluaran -->
    <div class="row">
        <!-- Pendapatan -->
        <div class="col-xl mb-4">
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
        <!-- Pengeluaran -->
        <div class="col-xl mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengeluaran Bulan Ini</div>
                            <div class="mb-0 font-weight-bold text-danger">- <?= format_uang($total_pengeluaran); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Laba -->
        <div class="col-xl mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Laba Bulan Ini</div>
                            <div class="mb-0 font-weight-bold text-success">+ <?= format_uang($laba); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Data Barang -->
        <div class="col-xl-3 col-6 mb-4">
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

        <!-- Data Supplier -->
        <div class="col-xl-3 col-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Data Supplier</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $supplier; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="col-xl-3 col-6 mb-4">
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

        <!-- Total User -->
        <div class="col-xl-3 col-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $users; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Data barang, stok, supplier, user -->

    <!-- Chart Pendapaatan, Pengeluaran, dan Laba -->
    <div class="row">
        <!-- Area Chart  -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Chart Pendapatan Tahun <?= date('Y'); ?></h6>
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
                        <canvas id="myAreaChart2" width="669" height="320" class="chartjs-render-monitor" style="display: block; width: 669px; height: 320px;"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Transaksi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myPieChart2" width="302" height="245" class="chartjs-render-monitor" style="display: block; width: 302px; height: 245px;"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Pendapatan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Pengeluaran
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Laba
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Chart Pendapaatan, Pengeluaran, dan Laba -->

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
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

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Transaksi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myPieChart" width="302" height="245" class="chartjs-render-monitor" style="display: block; width: 302px; height: 245px;"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Barang Masuk
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Penjualan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  -->
    <div class="row">

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-warning py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">Stok Barang Minimum</h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                                <th>Pasok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($barang_min) :
                                foreach ($barang_min as $b) :
                            ?>
                                    <tr>
                                        <td><?= $b['nama_barang']; ?></td>
                                        <td><?= $b['stok']; ?></td>
                                        <td>
                                            <a href="<?= base_url('Admin/Barang_Masuk/add_item/') . $b['id_barang'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Tidak ada barang stok minim
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">5 Transaksi Terakhir Barang Masuk</h6>
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
                            <?php foreach ($transaksi['barang_masuk'] as $tbm) : ?>
                                <tr>
                                    <td><?= $tbm['tanggal']; ?></td>
                                    <td><?= $tbm['nama_barang']; ?></td>
                                    <td><span class="badge badge-success"><?= $tbm['qty']; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-danger py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">5 Transaksi Terakhir Penjualan</h6>
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
                                    <td><?= $tbm['tanggal']; ?></td>
                                    <td><?= $tbm['nama_barang']; ?></td>
                                    <td><span class="badge badge-danger"><?= $tbm['qty']; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
    <!--  -->

</div>
<!-- /.container-fluid -->