<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Data Pengajuan
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
                        <?php if ($this->session->flashdata('ok')) : ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check"></i> <?= $this->session->flashdata('ok') ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check"></i> <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="box-title">Data Pengajuan</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pengajuan</th>
                                        <th>Tujuan</th>
                                        <th>Kriteria</th>
                                        <th>Daerah</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dt->kode_pengajuan; ?></td>
                                            <td><?= $dt->nama; ?></td>
                                            <td><?= $dt->kriteria; ?></td>
                                            <td><?= $dt->tujuan; ?></td>
                                            <td><?= rupiah($dt->nom_kriteria + $dt->transport + $dt->sopir); ?></td>
                                            <td>
                                                <?= $dt->status === 'belum' ? "<span class='badge bg-red'>Belum</span>" : "" ?>
                                                <?= $dt->status === 'proses' ? "<span class='badge bg-yellow'>Proses</span>" : "" ?>
                                                <?= $dt->status === 'ditolak' ? "<span class='badge bg-red'>Ditolak</span>" : "" ?>
                                                <?= $dt->status === 'disetujui' ? "<span class='badge bg-green'>Disetujui</span>" : "" ?>
                                                <?= $dt->status === 'selesai' ? "<span class='badge bg-blue'>Selesai</span>" : "" ?>
                                            </td>
                                            <td>

                                                <?php if ($dt->status === 'proses') { ?>
                                                    <a href="<?= base_url('verval/setujui/' . $dt->kode_pengajuan); ?>" class="btn btn-success btn-xs">Setujui</a> |
                                                    <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#<?= $dt->kode_pengajuan; ?>">Tolak</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="<?= $dt->kode_pengajuan; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Penolakan Pengajuan</h4>
                                                    </div>
                                                    <?= form_open('verval/tolak') ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="kode" value="<?= $dt->kode_pengajuan; ?>">
                                                        <div class="form-group">
                                                            <label for="">Tuliskan Catatan Penolakan</label>
                                                            <textarea name="catatan" class="form-control" id="" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Tolak Pengajuan</button>
                                                    </div>
                                                    <?= form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->