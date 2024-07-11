<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Pengajuan
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">Data Pengajuan Nikmus</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Pencairan Pengajuan</h3>
                        <a href="<?= base_url('pencairan'); ?>" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Nama Tujuan</th>
                                        <td><?= $data->nama ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kriteria</th>
                                        <td><?= $data->kriteria ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nominal</th>
                                        <td><?= rupiah($data->nom_kriteria) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Daerah</th>
                                        <td><?= $daerah->daerah ?></td>
                                    </tr>
                                    <tr>
                                        <th>Transport</th>
                                        <td><?= rupiah($data->transport) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sopir</th>
                                        <td><?= rupiah($data->sopir) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Jalan</th>
                                        <td><?= $data->tgl_jalan ?></td>
                                    </tr>
                                    <tr style="background-color: lightgreen;">
                                        <th>TOTAL</th>
                                        <th><?= rupiah($data->transport + $data->sopir + $data->nom_kriteria) ?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <?= form_open('pencairan/saveAdd'); ?>
                                <input type="hidden" name="kode_pengajuan" value="<?= $data->kode_pengajuan ?>">
                                <div class="form-group">
                                    <label for="">Nominal Cair</label>
                                    <input type="text" name="nominal" class="form-control uang" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Penerima</label>
                                    <input type="text" name="penerima" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Cair</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" name="tgl_cair" class="form-control pull-right" id="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kasir</label>
                                    <input type="text" name="kasir" class="form-control" value="<?= $user->nama; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <button class="btn btn-primary">Simpan Pencairan</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->