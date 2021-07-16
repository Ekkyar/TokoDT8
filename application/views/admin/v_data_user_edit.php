<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4 border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form <?= $title; ?>
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('Admin/Data_User') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
            <div class="card-body pb-2">

                <!-- Form -->
                <?php foreach ($usr as $u) : ?>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open('', [], ['id_user' => $u['id_user']]); ?>
                    <!-- username -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="username">Username</label>
                        <div class="col-md-6">
                            <input value="<?= set_value('username', $u['username']); ?>" type="text" id="username" name="username" class="form-control" placeholder="Username">
                            <?= form_error('username', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>

                    <hr>

                    <!-- nama -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="nama">Nama</label>
                        <div class="col-md-6">
                            <input value="<?= set_value('nama', $u['nama']); ?>" type="text" id="nama" name="nama" class="form-control">
                            <?= form_error('nama', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <!-- alamat -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="alamat">alamat</label>
                        <div class="col-md-6">
                            <input value="<?= set_value('alamat', $u['alamat']); ?>" type="text" id="alamat" name="alamat" class="form-control">
                            <?= form_error('alamat', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <!-- nomor telepon -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="no_telp">Nomor Telepon</label>
                        <div class="col-md-6">
                            <input value="<?= set_value('no_telp', $u['no_telp']); ?>" type="text" id="no_telp" name="no_telp" class="form-control" placeholder="Nomor Telepon">
                            <?= form_error('no_telp', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <!-- email -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="email">Email</label>
                        <div class="col-md-6">
                            <input value="<?= set_value('email', $u['email']); ?>" type="text" id="email" name="email" class="form-control" placeholder="Email">
                            <?= form_error('email', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <!-- Role -->
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="role">Role</label>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio">
                                <input <?= $u['id_akses'] == '1' ? 'checked' : ''; ?> <?= set_radio('id_akses', '1'); ?> value="1" type="radio" id="admin" name="id_akses" class="custom-control-input">
                                <label class="custom-control-label" for="admin">Admin</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input <?= $u['id_akses'] == '2' ? 'checked' : ''; ?> <?= set_radio('id_akses', '2'); ?> value="2" type="radio" id="kasir" name="id_akses" class="custom-control-input">
                                <label class="custom-control-label" for="kasir">Kasir</label>
                            </div>
                            <?= form_error('id_akses', '<span class="text-danger small">', '</span>'); ?>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group justify-content-end">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon"><i class="fa fa-save"></i></span>
                                <span class="text">Simpan</span>
                            </button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                <?php endforeach; ?>
                <!-- End Form -->

            </div>
        </div>
    </div>
</div>