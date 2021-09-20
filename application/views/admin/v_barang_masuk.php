<!-- Container -->
<div class="container">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="card shadow-sm border-bottom-primary">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col">
                    <h5 class="align-middle m-0 font-weight-bold text-primary">
                        Riwayat Transaksi Barang Masuk
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="<?= base_url('Admin/Barang_Masuk/keranjang') ?>" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-user-plus"></i>
                        </span>
                        <span class="text">
                            Tambah Barang Masuk
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- tabel -->
        <div class="mt-2 table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th width="30">No.</th>
                        <th>ID Barang Masuk</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Supplier</th>
                        <th>Total Harga (Rp.)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($barangmasuk) :
                        foreach ($barangmasuk as $row) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td>
                                    <a href="<?= base_url('Admin/Barang_Masuk/detail/') . $row->id_barang_masuk; ?>">
                                        <?= $row->id_barang_masuk; ?>
                                    </a>
                                </td>
                                <td>
                                    <!-- <= date('d M Y', $user['date_created']); ?> -->
                                    <?= date($row->tanggal); ?>
                                </td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->nama_supplier ?></td>
                                <td class="text-right"><?= format_uang2($row->total) ?></td>
                                <td>
                                    <a onclick="return confirm('Apakah anda yakin ingin hapus data?')" href="<?= base_url('Admin/Barang_Masuk/delete/') . $row->id_barang_masuk; ?>" class="btn btn-circle btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
            <!-- End tabel -->

        </div>
    </div>


</div>
<!-- End Container -->