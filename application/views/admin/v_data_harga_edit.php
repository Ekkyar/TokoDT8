<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Edit Harga Barang
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('Admin/Data_Barang/harga') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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

                <?php foreach ($barang as $b) : ?>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open(); ?>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right">ID Barang</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('id_barang', $b['id_barang']); ?>" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right">Nama Barang</label>
                        <div class="col-md-9">
                            <input value="<?= set_value('nama_barang', $b['nama_barang']); ?>" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="harga_masuk">Harga Masuk</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div>
                                <input value="<?= set_value('harga_masuk', $b['harga_masuk']); ?>" name="harga_masuk" id="harga_masuk" type="number" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3 text-md-right" for="harga">Harga Jual</label>
                        <div class="col-md-9 ">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div>
                                <input value="<?= set_value('harga', $b['harga']); ?>" name="harga" id="harga" type="number" class="form-control">
                            </div>
                            <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</bu>
                        </div>
                    </div>
                    <?= form_close(); ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>