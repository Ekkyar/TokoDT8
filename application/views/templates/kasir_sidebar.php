<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Kasir/Dashboard') ?>">
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
        <a class="nav-link" href="<?= base_url('Kasir/Dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading Data Master -->
        <div class="sidebar-heading">
            Data Master
        </div>

        <!-- Data Barang -->
        <!-- Barang Masuk -->
        <?php if ($title == 'Data Barang') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link" href="<?= base_url('Kasir/Data_Barang'); ?>">
                <i class="fas fa-fw fa-folder"></i>
                <span>Data Barang</span></a>
            </li>
            <!-- End Heading Data Master -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!--Heading Data Transaksi -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <!-- Penjualan -->
            <?php if ($title == 'Penjualan') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url('Kasir/Penjualan'); ?>">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Penjualan</span></a>
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
                    <a class="nav-link" href="<?= base_url('Kasir/Cetak_Laporan'); ?>">
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