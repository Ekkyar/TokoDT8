<div class="container">

    <div class="row">
        <div class="col-md-3">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Petugas</h6>
                        <small class="text-muted"><?= $transaksi->nama; ?></small>
                    </div>
                    <span class="text-muted"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Uang Bayar</h6>
                        <small class="text-muted"><?= format_uang($transaksi->bayar); ?></small>
                    </div>
                    <span class="text-muted"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Kembalian</h6>
                        <small class="text-muted"><?= format_uang($transaksi->kembalian); ?></small>
                    </div>
                    <span class="text-muted"></span>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="font-weight-light mb-0">Detail Transaksi</h5>
                            <span class="text-muted small"><?= $transaksi->id_transaksi ?> &bullet; <?= date($transaksi->tanggal, true) ?></span>
                        </div>
                        <div class="col-sm text-right">
                            <a href="<?= base_url('Admin/Penjualan/cetak_nota/') . $id_transaksi ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Nota</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mt-3 mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Satuan (Rp.)</th>
                                    <th>Jumlah Beli</th>
                                    <th class="text-right">Subtotal (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $no = 1;
                                foreach ($detail as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?>.</td>
                                        <td><?= $row->nama_barang; ?></td>
                                        <td align="right"><?= format_uang2($row->harga) ?></td>
                                        <td><?= $row->qty; ?></td>
                                        <td align="right"><?= format_uang2($row->subtotal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Harga</th>
                                    <th class="text-right"><?= format_uang($transaksi->total) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

</div>