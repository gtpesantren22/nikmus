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
                        <a href="<?= base_url('pengajuan/add'); ?>" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-circle"></i> Tambah
                            Data</a>
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
                                        <th>Tanggal</th>
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
                                            <td><?= $dt->daerah; ?></td>
                                            <td><?= rupiah($dt->nom_kriteria + $dt->transport + $dt->sopir); ?></td>
                                            <td><?= $dt->tgl_jalan; ?></td>
                                            <td>
                                                <?= $dt->status === 'belum' ? "<span class='badge bg-red'>Belum</span>" : "" ?>
                                                <?= $dt->status === 'proses' ? "<span class='badge bg-yellow'>Proses</span>" : "" ?>
                                                <?= $dt->status === 'ditolak' ? "<span class='badge bg-red'>Ditolak</span>" : "" ?>
                                                <?= $dt->status === 'disetujui' ? "<span class='badge bg-green'>Disetujui</span>" : "" ?>
                                                <?= $dt->status === 'selesai' ? "<span class='badge bg-blue'>Selesai</span>" : "" ?>
                                            </td>
                                            <td>
                                                <?php if ($dt->status === 'belum' || $dt->status === 'ditolak') { ?>
                                                    <a href="<?= base_url('pengajuan/ajukan/' . $dt->kode_pengajuan); ?>" onclick="return confirm('Yakin akan diajukan ?')" class="btn btn-success btn-xs">Ajukan</a> |
                                                    <a href="<?= base_url('pengajuan/edit/' . $dt->kode_pengajuan) ?>" class="btn btn-warning btn-xs">Edit</a>
                                                    <a href="<?= base_url('pengajuan/del/' . $dt->kode_pengajuan); ?>" onclick="return confirm('Yakin akan dihpaus ?')" class="btn btn-danger btn-xs">Hapus</a>
                                                <?php }  ?>

                                            </td>
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