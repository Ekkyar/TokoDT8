<!-- Container -->
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col d-flex">
                            <h3 class="h5 mb-0 card-title align-self-center">
                                Data <?= $title; ?>
                            </h3>
                        </div>
                        <div class="col text-right">
                            <a href="<?= base_url('Admin/Penjualan/add') ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped mb-0 datatable">
                        <thead>
                            <tr>
                                <th width="100">No.</th>
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
                                            <!-- <= indo_date($row->tanggal); ?> -->
                                            <!-- <= date('d M Y', $user['date_created']); ?> -->
                                            <?= date($row->tanggal); ?>
                                        </td>
                                        <td><?= format_uang($row->total); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a onclick="return confirm('Apakah anda yakin ingin hapus data?')" href="<?= base_url('Admin/Penjualan/hapus/') . $row->id_transaksi; ?>" class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
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
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Container -->