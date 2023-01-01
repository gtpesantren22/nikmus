<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Data Pengajuan
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">History Data Pengajuan Nikmus</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
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
                                        <td><?= $dt->daerah; ?></td>
                                        <td>
                                            <?= $dt->status === 'belum' ? "<span class='badge bg-red'>Belum</span>" : "" ?>
                                            <?= $dt->status === 'proses' ? "<span class='badge bg-yellow'>Proses</span>" : "" ?>
                                            <?= $dt->status === 'ditolak' ? "<span class='badge bg-red'>Ditolak</span>" : "" ?>
                                            <?= $dt->status === 'disetujui' ? "<span class='badge bg-green'>Disetujui</span>" : "" ?>
                                            <?= $dt->status === 'selesai' ? "<span class='badge bg-blue'>Selesai</span>" : "" ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('history/detail/' . $dt->kode_pengajuan); ?>"
                                                class="btn btn-success btn-xs"><i class="fa fa-search"></i> Lihat
                                                History</a>
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