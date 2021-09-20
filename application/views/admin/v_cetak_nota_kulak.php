<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="text-center text-monospace">

            <div class="row mt-3">
                <div class="col">
                    <h1 class="font-weight-bold ">TOKO DT8 </h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>JL. Danau Toba 22 Link Panji</h4>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <h5>
                        082234827215
                    </h5>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <h2 class="font-weight-bold">NOTA BARANG MASUK</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mx-auto">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <td class="border-top border-bottom">
                                    <div>
                                        <?= $barangmasuk->nama; ?> / <?= $barangmasuk->id_barang_masuk ?> / <?= date($barangmasuk->tanggal, true) ?>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Header -->

        <div class="row text-monospace">
            <div class="col">
                <table class="table table-borderless">
                    <thead class="border text-center">
                        <tr>
                            <th scope="col" class="border">No</th>
                            <th scope="col" class="border">Nama Barang</th>
                            <th scope="col" class="border">Harga Satuan (Rp.)</th>
                            <th scope="col" class="border">Jumlah Beli</th>
                            <th scope="col" class="border text-right">Subtotal (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody class="border">

                        <?php
                        $no = 1;
                        foreach ($detail as $row) : ?>
                            <tr class="border-bottom text-center">
                                <td class="border"><?= $no++; ?>.</td>
                                <td class="border"><?= $row->nama_barang; ?></td>
                                <td class="border text-right"><?= format_uang2($row->harga) ?></td>
                                <td class="border"><?= $row->qty; ?></td>
                                <td class="border text-right"><?= format_uang2($row->subtotal) ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr class="text-right font-weight-bold">
                            <td colspan="4">Total Harga</td>
                            <td>
                                <?= format_uang2($barangmasuk->total) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- <div>
            <div class="row">
                <div class="col">
                    <p> &bullet; Terimakasih atas kunjungan anda.</p>
                    <p> &bullet; Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
                </div>
            </div>
        </div> -->

    </div>

    <script>
        window.print();
    </script>
</body>