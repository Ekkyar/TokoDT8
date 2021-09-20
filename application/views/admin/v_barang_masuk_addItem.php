<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-bottom-primary">
                <div class="card-header bg-white py-3">
                    <div class="row">
                        <div class="col">
                            <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                                Form Input Barang Masuk
                            </h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('Admin/Barang_Masuk/keranjang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                                <span class="icon">
                                    <i class="fa fa-arrow-left"></i>
                                </span>
                                <span class="text">
                                    Kembali
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open(); ?>

                    <!-- ID BARANG -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select name="barang_id" id="barang_id" class="custom-select">
                                    <option value="" selected disabled>Pilih Barang</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option <?= $this->uri->segment(4) == $b['id_barang'] ? 'selected' : '';  ?> <?= set_select('barang_id', $b['id_barang']) ?> value="<?= $b['id_barang'] ?>">
                                            <?php foreach ($barangdetail as $bd) : ?>
                                                <?php if ($b['id_barang'] == $bd['id_barang']) : ?>
                                                    <?= $b['id_barang'] . ' | ' . $b['nama_barang'] . ' | ' . $bd['nama_satuan']; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" href="<= base_url('Admin/Data_Barang/add'); ?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <!-- CARI BARANG -->
                    <!-- <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<= set_value('barang_id') ?>" type="text" class="form-control" name="barang_id" id="barang_id" placeholder="Pilih Barang...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalBarang">
                                        <i class="fa fa-fw fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <= form_error('barang_id', '<span class="text-danger small">', '</span>'); ?> -->

                    <!-- NAMA BARANG -->
                    <!-- <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="nama_barang">Nama Barang</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="nama_barang" type="text" class="form-control">
                        </div>
                    </div> -->

                    <!-- STOK -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="stok">Stok</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="stok" type="number" class="form-control">
                        </div>
                    </div>

                    <!-- JUMLAH MASUK -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="jumlah_masuk">Jumlah Masuk</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<?= set_value('qty'); ?>" name="qty" id="jumlah_masuk" type="number" class="form-control" placeholder="Jumlah Masuk...">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="satuan">Satuan</span>
                                </div>
                            </div>
                            <?= form_error('qty', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <!-- JENIS -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="jenis ">Jenis</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="jenis" type="text" class="form-control">
                        </div>
                    </div>

                    <!-- TOTAL STOK -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="total_stok" type="number" class="form-control">
                        </div>
                    </div>

                    <!-- HARGA MASUK -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="harga_masuk">Harga Masuk</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<?= set_value('harga_masuk'); ?>" name="harga_masuk" id="harga_masuk" type="number" class="form-control" placeholder="Harga Masuk..." required>
                            </div>
                            <?= form_error('harga_masuk', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <!-- TOMBOL -->
                    <div class="row form-group">
                        <div class="col offset-md-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                    <?= form_close(); ?>

                </div>

                <!-- Modal Cari Barang -->
                <div id="modalBarang" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Data Barang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>ID Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jenis Barang</th>
                                                    <th>Satuan Barang</th>
                                                    <th>Harga</th>
                                                    <th>Stok</th>
                                                    <th>Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($getbarang as $row) : ?>
                                                    <tr>
                                                        <td><?= $row['id_barang'] ?></td>
                                                        <td><?= $row['nama_barang'] ?></td>
                                                        <td><?= $row['nama_jenis'] ?></td>
                                                        <td><?= $row['nama_satuan'] ?></td>
                                                        <td><?= format_uang($row['harga']); ?></td>
                                                        <td><?= $row['stok']; ?></td>
                                                        <td>
                                                            <button data-jenis="<?= $row['nama_jenis']; ?>" data-stok="<?= $row['stok']; ?>" data-kode="<?= $row['id_barang'] ?>" data-nama_barang="<?= $row['nama_barang'] ?>" type="button" class="btn btn-pilih btn-sm btn-primary">
                                                                <i class="fa fa-check fa-fw"></i> Pilih
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Cari Barang -->

            </div>
        </div>
    </div>
</div>