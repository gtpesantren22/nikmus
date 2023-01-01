<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            History Data Pengajuan
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">History Pengajuan Nikmus</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        Rincian Pengajuan
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Kode Pengajuan</th>
                                    <th>:</th>
                                    <th><?= $data->kode_pengajuan; ?></th>
                                </tr>
                                <tr>
                                    <th>Tujuan</th>
                                    <th>:</th>
                                    <th><?= $data->nama; ?></th>
                                </tr>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>:</th>
                                    <th><?= $data->kriteria; ?></th>
                                </tr>
                                <tr>
                                    <th>Daerah</th>
                                    <th>:</th>
                                    <th><?= $data->daerah; ?></th>
                                </tr>
                                <tr>
                                    <th>Nominal</th>
                                    <th>:</th>
                                    <th><?= rupiah($data->nom_kriteria + $data->transport + $data->sopir); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Tanggal Jalan</th>
                                    <th>:</th>
                                    <th><?= tanggalIndo($data->tgl_jalan); ?></th>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        SPJ Pengajuan
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Kode Pengajuan</th>
                                    <th>:</th>
                                    <th><?= $spj->kode_pengajuan; ?></th>
                                </tr>
                                <tr>
                                    <th>Tanggal Upload</th>
                                    <th>:</th>
                                    <th><?= $spj->tgl_upload; ?></th>
                                </tr>
                                <tr>
                                    <th>Berkas/File</th>
                                    <th>:</th>
                                    <th><button class="btn btn-success btn-xs" data-toggle="modal"
                                            data-target="#view"><i class="fa fa-eye"></i> Lihat Berkas SPJ</button></th>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>:</th>
                                    <th><?= $spj->status === 'belum' ? "<span class='badge bg-red'>Belum</span>" : "" ?>
                                        <?= $spj->status === 'proses' ? "<span class='badge bg-yellow'>Proses</span>" : "" ?>
                                        <?= $spj->status === 'ditolak' ? "<span class='badge bg-red'>Ditolak</span>" : "" ?>
                                        <?= $spj->status === 'selesai' ? "<span class='badge bg-green'>Selesai</span>" : "" ?>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-xs-8">
                <ul class="timeline">

                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-red">
                            Tracking Pengajuan
                        </span>
                    </li>
                    <!-- /.timeline-label -->

                    <!-- timeline item -->
                    <?php foreach ($data2 as $row) :
                        if ($row->oleh === 'Accounting') {
                            $bg = 'label label-warning';
                        } elseif ($row->oleh === 'Humas Pesantren') {
                            $bg = 'label label-info';
                        } elseif ($row->oleh === 'Admin Pencairan') {
                            $bg = 'label label-danger';
                        }
                    ?>
                    <li>
                        <!-- timeline icon -->
                        <i class="fa fa-arrow-down bg-blue"></i>
                        <div class="timeline-item">


                            <h3 class="timeline-header">
                                <span class="badge bg-purple pull-right"><i class="fa fa-clock-o"></i>
                                    <?= $row->at; ?></span>
                                <span class="label label-success"><?= $row->status; ?></span> |
                                <span class="<?= $bg; ?>"><?= $row->oleh; ?></span>
                            </h3>

                            <div class="timeline-body">
                                <?= $row->ket; ?>
                            </div>

                        </div>
                    </li>
                    <?php endforeach; ?>
                    <!-- END timeline item -->
                </ul>
            </div>
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">SPJ Nikmus</h4>
            </div>
            <div class="modal-body">
                <iframe src="<?= base_url('/assets/berkas/' . $spj->berkas) ?>" width="100%" height="500"
                    style="border:none;"></iframe>
            </div>
        </div>
    </div>

</div>