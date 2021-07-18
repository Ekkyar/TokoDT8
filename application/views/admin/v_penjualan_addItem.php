<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="h5 mb-0 card-title align-self-center">
                            Tambah Barang
                        </h3>
                    </div>
                    <div class="col text-right">
                        <a href="<?= base_url('Admin/Penjualan/add') ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-chevron-left"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">

                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open(); ?>
                <div class="form-group">
                    <label for="barang_id">Kode Barang</label>
                    <div class="input-group">
                        <input value="<?= set_value('barang_id') ?>" type="text" class="form-control" name="barang_id" id="barang_id" placeholder="ID Barang...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalBarang">
                                <i class="fa fa-fw fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <?= form_error('barang_id'); ?>
                </div>
                <div class="form-group">
                    <label for="qty">Jumlah Beli</label>
                    <input value="<?= set_value('qty'); ?>" placeholder="Jumlah Beli..." type="text" class="form-control" id="qty" name="qty">
                    <?= form_error('qty'); ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-shopping-cart"></i> Tambah
                    </button>
                </div>
                <?= form_close(); ?>

            </div>
        </div>
    </div>
</div>

<div id="modalBarang" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table" id="search-only-datatable">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Satuan Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $row) : ?>
                            <tr>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= $row['nama_jenis'] ?></td>
                                <td><?= $row['nama_satuan'] ?></td>
                                <td><?= format_uang($row['harga']); ?></td>
                                <td><?= $row['stok']; ?></td>
                                <td>
                                    <button data-stok="<?= $row['stok']; ?>" data-kode="<?= $row['id_barang'] ?>" type="button" class="btn btn-pilih btn-sm btn-primary">
                                        <i class="fa fa-check fa-fw"></i> Pilih
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>