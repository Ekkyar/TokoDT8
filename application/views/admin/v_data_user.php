<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm mb-4 border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col">
                    <h5 class="align-middle m-0 font-weight-bold text-primary">
                        Data User
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="<?= base_url('Admin/Data_User/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-user-plus"></i>
                        </span>
                        <span class="text">
                            Tambah User
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th width="30">No.</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No. telp</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($user) :
                        foreach ($getAllUser as $usr) :
                    ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <img src="<?= base_url() ?>assets/img/profil/<?= $usr['foto'] ?>" alt="<?= $usr['nama']; ?>" width="30" class="img-thumbnail rounded-circle">
                                </td>
                                <td><?= $usr['nama']; ?></td>
                                <td><?= $usr['username']; ?></td>
                                <td><?= $usr['email']; ?></td>
                                <td><?= $usr['no_telp']; ?></td>
                                <td>
                                    <?php foreach ($getAllAkses as $aks) : ?>
                                        <?php if ($usr['id_akses'] == $aks['id_akses']) : ?>
                                            <?= $aks['nama_akses'] ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>

                                    <a href="<?= base_url('Admin/Data_User/edit/') . $usr['id_user'] ?>" class="btn btn-circle btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></a>
                                    <a onclick="return confirm('Yakin ingin menghapus data?')" href="<?= base_url('Admin/Data_User/delete/') . $usr['id_user'] ?>" class="btn btn-circle btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="8" class="text-center">Silahkan tambahkan user baru</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>