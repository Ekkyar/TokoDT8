<div class="container">

    <div class="card p-2 shadow-sm border-bottom-primary">
        <div class="card-header bg-white">
            <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                Identitas User
            </h4>
        </div>
        <div class="card-body">
            <?= $this->session->flashdata('pesan'); ?>
            <div class="row">
                <div class="col-md-2 mb-4 mb-md-0">
                    <img src="<?= base_url() ?>assets/img/profil/<?= $user['foto']; ?>" alt="" class="img-thumbnail rounded mb-2">
                    <a href="<?= base_url('Admin/Profil/edit'); ?>" class="btn btn-sm btn-block btn-primary"><i class="fa fa-edit"></i> Edit Profil</a>
                    <a href="<?= base_url('Admin/Profil/ubahpassword'); ?>" class="btn btn-sm btn-block btn-primary"><i class="fa fa-lock"></i> Ubah Password</a>
                </div>
                <div class="col-md-10">
                    <table class="table">
                        <tr>
                            <th width="200">Nama Lengkap</th>
                            <td><?= $user['nama']; ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= $user['alamat']; ?></td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td><?= $user['no_telp']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $user['email']; ?></td>
                        </tr>
                        <tr>
                            <th>username</th>
                            <td><?= $user['username']; ?></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td class="text-capitalize"><?= $akses['nama_akses']; ?></td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td class="text-capitalize"><?= date('d F Y', $user['date_created']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>