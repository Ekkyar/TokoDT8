<!-- Container -->
<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col">
                    <h5 class="align-middle m-0 font-weight-bold text-primary">
                        Riwayat Transaksi Penjualan
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="<?= base_url('Admin/Penjualan/keranjang') ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-user-plus"></i>
                        </span>
                        <span class="text">
                            Tambah Transaksi
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- tabel -->
        <div class="mt-2 table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th width="30">No.</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($transaksi) :
                        foreach ($transaksi as $row) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td>
                                    <a href="<?= base_url('Admin/Penjualan/detail/') . $row->id_transaksi; ?>">
                                        <?= $row->id_transaksi; ?>
                                    </a>
                                </td>
                                <td>
                                    <!-- <= date('d M Y', $user['date_created']); ?> -->
                                    <?= date($row->tanggal); ?>
                                </td>
                                <td><?= format_uang($row->total); ?></td>
                                <td>

                                    <a onclick="return confirm('Apakah anda yakin ingin hapus data?')" href="<?= base_url('Admin/Penjualan/delete/') . $row->id_transaksi; ?>" class="btn btn-circle btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
            <!-- End tabel -->

        </div>
    </div>


</div>
<!-- End Container -->