<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">

                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat User</h1>
                        </div>

                        <!-- Form -->
                        <form class="user" method="POST" action="<?= base_url('Admin/Admin_User/registration'); ?>">
                            <!-- Nama -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= set_value('nama'); ?>">
                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?= set_value('alamat'); ?>">
                                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- Kontak -->
                            <div class="form-group">
                                <input type="number" class="form-control" id="kontak" name="kontak" placeholder="No. telp/hp" value="<?= set_value('kontak'); ?>">
                                <?= form_error('kontak', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- Username -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <br>
                            <!-- Akses -->
                            <div class="form-group">
                                <select class="form-control" name="id_akses" id="id_akses">
                                    <option value="">
                                        --- Pilih User Akses ---
                                    </option>
                                    <?php foreach ($getAkses as $akses) : ?>
                                        <option value="<?php echo $akses['id_akses']; ?>">
                                            <?php echo $akses['nama_akses']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_akses', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Buat User
                            </button>
                        </form>
                        <!-- End Form -->
                        <div class="text-center">
                            <a class="small" href="<?= base_url('Admin/Admin_User'); ?>">Kembali</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>