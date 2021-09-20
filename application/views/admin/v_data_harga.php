<!-- Container -->
<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col">
                    <h5 class="align-middle m-0 font-weight-bold text-primary">
                        Harga Barang
                    </h5>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Satuan</th>
                        <th class="text-right">Harga Masuk (Rp.)</th>
                        <th class="text-right">Harga Jual (Rp.)</th>
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
                                <td><?= $b['nama_barang']; ?></td>
                                <td><?= $b['nama_jenis']; ?></td>
                                <td><?= $b['nama_satuan']; ?></td>
                                <td class="text-right"><?= format_uang2($b['harga_masuk']); ?></td>
                                <td class="text-right"><?= format_uang2($b['harga']); ?></td>
                                <td>
                                    <a href="<?= base_url('Admin/Data_Barang/edit_harga/') . $b['id_barang'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
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