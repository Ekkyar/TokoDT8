<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col text-right">
            <a href="<?= base_url('Kasir/Penjualan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                <span class="icon">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <span class="text">
                    Kembali
                </span>
            </a>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-9 pb-4 pb-sm-0">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="font-weight-light mb-0">Keranjang Penjualan</h5>
                            <span class="text-muted small">Daftar Barang</span>
                        </div>
                        <div class="col-auto mt-3">
                            <a href="<?= base_url('Kasir/Penjualan/add_item') ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon">
                                    <i class="fa fa-sm fa-plus"></i>
                                </span>
                                <span class="text">
                                    Tambah
                                </span>
                            </a>
                            <a onclick="return confirm('Data pemesanan akan dihapus. anda yakin ingin batal?')" href="<?= base_url('Kasir/Penjualan/batal') ?>" class="btn btn-secondary btn-icon-split">
                                <span class="icon">
                                    <i class="fa fa-sm fa-eraser"></i>
                                </span>
                                <span class="text">
                                    Reset
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-3 table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Beli</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!$keranjang) : ?>
                                    <tr>
                                        <td class=" text-center" colspan="6">
                                            Tidak ada barang dikeranjang
                                        </td>
                                    </tr>
                                    <?php
                                else :
                                    $no = 1;
                                    foreach ($keranjang as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $row->nama_barang; ?></td>
                                            <td><?= $row->qty; ?></td>
                                            <td><?= format_uang($row->harga) ?></td>
                                            <td><?= format_uang($row->harga * $row->qty) ?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin ingin menghapus item?');" href="<?= base_url('Kasir/Penjualan/delete_item/' . $row->id_item) ?>" class="btn btn-circle btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">

                    <?= form_open(); ?>
                    <div class="form-group">
                        <label for="total">Total Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="hidden" name="total" id="total" value="<?= $total_harga; ?>">
                            <input type="text" class="form-control" readonly value="<?= format_uang($total_harga, false); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bayar">Uang Bayar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input name="bayar" type="number" class="form-control" id="bayar" placeholder="0">
                        </div>
                        <?= form_error('bayar', '<span class="text-danger small">', '</span>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="kembalian">Kembalian</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" class="form-control" id="kembalian" readonly value="0">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-check"></i> Checkout
                        </button>
                    </div>
                    <?= form_close(); ?>

                </div>
            </div>
        </div>
    </div>

</div>