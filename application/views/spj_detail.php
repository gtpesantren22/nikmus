<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data SPJ
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">Data SPJ Pengajuan Nikmus</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Data SPJ</h3>
                        <a href="<?= base_url('spj'); ?>" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?= form_open('spj/editAct'); ?>
                        <input type="hidden" name="kode_pengajuan" value="<?= $data->kode_pengajuan ?>">
                        <div class="form-group">
                            <label for="">Nama yang dikunjungi</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data->nama; ?>" readonly>
                            <span class="label label-success"><?= $kritPilih->status ?></span><br>
                            <span class="label label-warning"><?= $kritPilih->jenis ?></span><span class="label label-danger"><?= $kritPilih->ybs ?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Anggota Nikmus</label>
                            <p><?= $dataSpj->peserta ?></p>
                        </div>
                        <div class="form-group">
                            <label for="">Hasil Nikmus</label>
                            <p><?= $dataSpj->hasil ?></p>
                        </div>
                        <div class="form-group">
                            <label for="">Dana Terserap</label>
                            <p><?= rupiah($dataSpj->serap) ?></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Foto Nota</label><br>

                                    <?php if ($fileFotoNota) : ?>
                                        <table>
                                            <?php foreach ($fileFotoNota as $foto) : ?>
                                                <tr>
                                                    <td>
                                                        <!-- <img src="<?= base_url('assets/berkas/' . $foto->berkas) ?>" alt="" height="100"> -->
                                                        <a href="<?= base_url('assets/berkas/' . $foto->berkas) ?>" data-lightbox="image-1">
                                                            <img src="<?= base_url('assets/berkas/' . $foto->berkas) ?>" alt="Berkas Image" style="width: 200px;">
                                                        </a>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <!-- <td><a class="btn btn-xs btn-danger" href="<?= base_url('spj/delFoto/' . $foto->id_file) ?>">Hapus</a></td> -->
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Foto Hasil Nikmus</label><br>

                                    <?php if ($fileFotoHasil) : ?>
                                        <table>
                                            <?php foreach ($fileFotoHasil as $foto) : ?>
                                                <tr>
                                                    <td>
                                                        <!-- <img src="<?= base_url('assets/berkas/' . $foto->berkas) ?>" alt="" height="100"> -->
                                                        <a href="<?= base_url('assets/berkas/' . $foto->berkas) ?>" data-lightbox="image-1">
                                                            <img src="<?= base_url('assets/berkas/' . $foto->berkas) ?>" alt="Nota Image" style="width: 200px;">
                                                        </a>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <!-- <td><a class="btn btn-xs btn-danger" href="<?= base_url('spj/delFoto/' . $foto->id_file) ?>">Hapus</a></td> -->
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <?php
                            if ($user->level == 'humas') {
                                if ($dataSpj->status == 'selesai') { ?>
                                    <a href="<?= base_url('spj/cetak/' . $data->kode_pengajuan) ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak SPJ</a>
                                <?php }
                            } else {
                                if ($dataSpj->status == 'selesai') { ?>
                                    <a href="<?= base_url('spj/cetak/' . $data->kode_pengajuan) ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak SPJ</a>
                                <?php } else { ?>
                                    <a href="<?= base_url('spj/setujui/' . $data->kode_pengajuan) ?>" onclick="return confirm('Yakin akan disettujui ?')" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Setujui</a>
                                    <a href="<?= base_url('spj/tolak/' . $data->kode_pengajuan); ?>" onclick="return confirm('Yakin akan ditolak ?')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Tolak</a>
                            <?php }
                            } ?>
                        </div>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="uploadFoto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload SPJ Nikmus</h4>
            </div>
            <?= form_open_multipart('spj/uploadFoto') ?>
            <input type="hidden" name="kode" value="<?= $data->kode_pengajuan ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Upload Foto</label>
                    <input type="file" class="form-control" name="berkas" required>
                    <small class="text-danger">* File gambar dalam bentuk JPG/PNG.</small>
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
</div>