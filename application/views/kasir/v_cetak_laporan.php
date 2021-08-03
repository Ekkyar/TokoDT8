<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-bottom-primary">
                <div class="card-header bg-white py-3">
                    <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                        Form Laporan
                    </h4>
                </div>
                <div class="card-body">

                    <form action="<?= base_url('Kasir/Cetak_Laporan') ?>" method="post" accept-charset="utf-8" target="_blank">
                        <div class="row form-group">
                            <label class="col-md-3 text-lg-right" for="transaksi">Laporan Transaksi</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-radio">
                                    <input value="tb_transaksi_detail" type="radio" id="tb_transaksi_detail" name="transaksi" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="tb_transaksi_detail">Penjualan</label>
                                </div>
                                <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-lg-3 text-lg-right my-auto">Tanggal Transaksi</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input value="<?= set_value('tanggal'); ?>" type="text" id="tanggal" name="tanggal" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                                    </div>
                                </div>
                                <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-9 offset-lg-3">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon">
                                        <i class="fa fa-print"></i>
                                    </span>
                                    <span class="text">
                                        Cetak
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>