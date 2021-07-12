<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="container-fluid p-1">


        <!-- Card 1 -->
        <div class="card shadow">

            <!-- Isi -->
            <div class="card-body">
                <!-- Tombol -->
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <a class="btn btn-success" href="<?= base_url('Admin/Admin_User/registration'); ?>">
                            <i class="fas fa-fw fa-plus"></i>
                            Tambah User
                        </a>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="row">
                    <div class="col">
                        <!-- Notif (Sukses insert data, edit data, delete data) -->
                        <?= $this->session->flashdata('message'); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kontak</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Akses</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($getAllUser as $tb) :
                                    ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $no++ ?></th>
                                            <td><?= $tb['nama'] ?></td>
                                            <td><?= $tb['kontak'] ?></td>
                                            <td><?= $tb['email'] ?></td>
                                            <td>
                                                <?php foreach ($getAllAkses as $aks) : ?>
                                                    <?php if ($tb['id_akses'] == $aks['id_akses']) : ?>
                                                        <?= $aks['nama_akses'] ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td class="text-center">

                                                <!-- Edit -->
                                                <a href="<?= base_url('Admin/Admin_User/detail_user/'); ?><?= $tb['id_user']; ?>" class="badge badge-primary">details</a>

                                                <!-- Delete (Button Modal Delete) -->
                                                <button type="button" class="btn btn-danger badge" data-toggle="modal" data-target="#modalDelete<?= $tb['id_user']; ?>">hapus</button>

                                                <!-- Modal Delete -->
                                                <div class="modal fade" id="modalDelete<?= $tb['id_user']; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modelDeleteLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modelDeleteLabel">Perhatian!</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                User <?= $tb['nama']; ?> akan dihapus! Apakah anda yakin?
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <a href="<?= base_url('Admin/Admin_User/delete_user/'); ?><?= $tb['id_user']; ?>" class="btn btn-danger">hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal Delete -->

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Tabel -->

            </div>

        </div>
        <!-- End Card 1 -->


    </div>

</div>
<!-- End of Begin Page -->