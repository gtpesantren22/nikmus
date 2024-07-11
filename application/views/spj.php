<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Data SPJ Pengajuan
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">SPJ Data Pengajuan Nikmus</li>
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
                        <!-- <a href="<?= base_url('pengajuan/add'); ?>" class="btn btn-sm btn-success pull-right"><i
                                class="fa fa-plus-circle"></i> Tambah
                            Data</a> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pengajuan</th>
                                        <th>Tanggal SPJ</th>
                                        <th>Berkas</th>
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
                                            <td><?= $dt->tgl_upload; ?></td>
                                            <td>
                                                <?php if ($dt->status === 'proses' || $dt->status === 'selesai') { ?>
                                                    <!-- <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#view<?= $dt->kode_pengajuan ?>">Lihat SPJ</button> -->
                                                    <button class="btn btn-info btn-xs" onclick="window.location='<?= base_url('spj/detail/' . $dt->kode_pengajuan) ?>'">Lihat SPJ</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?= $dt->status === 'belum' ? "<span class='badge bg-red'>Belum</span>" : "" ?>
                                                <?= $dt->status === 'proses' ? "<span class='badge bg-yellow'>Proses</span>" : "" ?>
                                                <?= $dt->status === 'ditolak' ? "<span class='badge bg-red'>Ditolak</span>" : "" ?>
                                                <?= $dt->status === 'selesai' ? "<span class='badge bg-green'>Selesai</span>" : "" ?>
                                            </td>
                                            <td>
                                                <?php if ($dt->status === 'belum' || $dt->status === 'ditolak') { ?>
                                                    <a href=" <?= base_url('spj/edit/') . $dt->kode_pengajuan ?>" class="btn btn-success btn-xs">Edit SPJ</a>
                                                    <?php } elseif ($dt->status === 'proses') {
                                                    if ($user->level == 'humas') {
                                                    } else {
                                                    ?>
                                                        <a href="<?= base_url('spj/setujui/' . $dt->kode_pengajuan) ?>" onclick="return confirm('Yakin akan disettujui ?')" class="btn btn-success btn-xs">Setujui</a>
                                                        <a href="<?= base_url('spj/tolak/' . $dt->kode_pengajuan); ?>" onclick="return confirm('Yakin akan ditolak ?')" class="btn btn-danger btn-xs">Tolak</a>
                                                <?php }
                                                } ?>
                                            </td>

                                            <?php if ($dt->status === 'proses' || $dt->status === 'selesai') { ?>
                                                <div class="modal fade" id="view<?= $dt->kode_pengajuan ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">SPJ Nikmus</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <iframe src="<?= base_url('/assets/berkas/' . $dt->berkas) ?>" width="100%" height="500" style="border:none;"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </tr>
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

<!-- <div class="modal fade" id="<?= $dt->kode_pengajuan ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload SPJ Nikmus</h4>
            </div>
            <?= form_open_multipart('spj/editAct') ?>
            <input type="hidden" name="file_lama" value="<?= $dt->berkas; ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Kode Pengajuan</label>
                    <input type="text" class="form-control" name="kode_pengajuan" readonly value="<?= $dt->kode_pengajuan; ?>">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Upload</label>
                    <input type="date" class="form-control" name="tgl_upload" required value="<?= $dt->tgl_upload; ?>">
                </div>
                <div class="form-group">
                    <label for="">Upload File SPJ</label>
                    <input type="file" class="form-control" name="berkas" required>
                    <small class="text-danger">* Sebelum file diupload
                        dipastikan sudah benar.
                        Karena automatis akan diajukan secara langsung</small>
                    <small class="text-danger">* SPJ dalam bentuk PDF. Max 10
                        Mb</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan
                    Data</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div> -->