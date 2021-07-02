<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Admin/Admin_Dashboard') ?>">
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
        <a class="nav-link" href="<?= base_url('Admin/Admin_Dashboard') ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading Kontrol -->
        <div class="sidebar-heading">
            Kontrol
        </div>

        <!-- Akun -->
        <?php if ($title == 'Akun') : ?>
            <li class="nav-item active">
            <?php elseif ($title == 'Detail Akun') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link" href="<?= base_url('Admin/Admin_Akun'); ?>">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Akun</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading Data Master -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <!-- Kategori -->
            <?php if ($title == 'Kategori') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kategori</span></a>
                </li>

                <!-- Data Barang -->
                <?php if ($title == 'Data Barang') : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Data Barang</span></a>
                    </li>
                    <!-- End Data Master -->

                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">

                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>

</ul>
<!-- End of Sidebar -->