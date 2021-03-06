<!-- Container -->
<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col">
                    <h5 class="align-middle m-0 font-weight-bold text-primary">
                        Barang
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="<?= base_url('Admin/Data_Barang/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">
                            Tambah Barang
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>ID Barang</th>
                        <th>Qr Code</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($barang) :
                        foreach ($barang as $b) :
                    ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $b['id_barang']; ?></td>
                                <td>
                                    <img src="<?= site_url('Admin/Data_Barang/QRcode/' . $b['id_barang']); ?>" width="50" alt="error">
                                    <br>
                                    <a href="<?= base_url('Admin/Data_Barang/QRcode/') . $b['id_barang'] ?>" class="h5 badge ml-1" target="_blank">Cetak</a>
                                </td>
                                <td><?= $b['nama_barang']; ?></td>
                                <td><?= $b['nama_jenis']; ?></td>
                                <td><?= $b['nama_satuan']; ?></td>
                                <td><?= $b['stok']; ?></td>
                                <td>
                                    <a href="<?= base_url('Admin/Data_Barang/edit/') . $b['id_barang'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                    <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('Admin/Data_Barang/delete/') . $b['id_barang'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- End Container -->