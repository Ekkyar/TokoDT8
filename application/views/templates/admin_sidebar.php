<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Admin/Dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Toko DT8</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php if ($title == 'Dashboard') : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link" href="<?= base_url('Admin/Dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading User -->
        <div class="sidebar-heading">
            Kontrol User
        </div>

        <!-- User -->
        <?php if ($title == 'Data User') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link mt-0" href="<?= base_url('Admin/Data_User'); ?>">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Data User</span></a>
            </li>
            <!-- End Heading User -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading Data Master -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <!-- Supplier -->
            <?php if ($title == 'Data Supplier') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url('Admin/Supplier'); ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Supplier</span></a>
                </li>

                <!-- Data Barang -->
                <?php if ($title == 'Data Jenis') : ?>
                    <li class="nav-item active">
                    <?php elseif ($title == 'Data Satuan') : ?>
                    <li class="nav-item active">
                    <?php elseif ($title == 'Data Barang') : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarang" aria-expanded="true" aria-controls="collapseBarang">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Barang</span>
                    </a>
                    <div id="collapseBarang" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Master Barang:</h6>
                            <a class="collapse-item" href="<?= base_url('Admin/Data_Jenis'); ?>">Jenis Barang</a>
                            <a class="collapse-item" href="<?= base_url('Admin/Data_Satuan'); ?>">Satuan Barang</a>
                            <a class="collapse-item" href="<?= base_url('Admin/Data_Barang'); ?>">Data Barang</a>
                        </div>
                    </div>
                    </li>
                    <!-- End Heading Data Master -->

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!--Heading Data Transaksi -->
                    <div class="sidebar-heading">
                        Transaksi
                    </div>

                    <!-- Barang Masuk -->
                    <?php if ($title == 'Barang Masuk') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link" href="<?= base_url('Admin/Barang_Masuk'); ?>">
                            <i class="fas fa-fw fa-download"></i>
                            <span>Barang Masuk</span></a>
                        </li>

                        <!-- Barang Keluar -->
                        <?php if ($title == 'Barang Keluar') : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                            <a class="nav-link" href="<?= base_url('Admin/Barang_Keluar'); ?>">
                                <i class="fas fa-fw fa-upload"></i>
                                <span>Barang Keluar</span></a>
                            </li>
                            <!-- End Heading Data Transaksi -->

                            <!-- Divider -->
                            <hr class="sidebar-divider">

                            <!--Heading Data Laporan -->
                            <div class="sidebar-heading">
                                Laporan
                            </div>

                            <!-- Cetak Laporan -->
                            <?php if ($title == 'Cetak Laporan') : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link" href="<?= base_url('Admin/Cetak_Laporan'); ?>">
                                    <i class="fas fa-fw fa-print"></i>
                                    <span>Cetak Laporan</span></a>
                                </li>
                                <!-- End Heading Data Laporan -->

                                <!-- Divider -->
                                <hr class="sidebar-divider d-none d-md-block">

                                <!-- Sidebar Toggler (Sidebar) -->
                                <div class="text-center d-none d-md-inline">
                                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                                </div>

</ul>
<!-- End of Sidebar -->