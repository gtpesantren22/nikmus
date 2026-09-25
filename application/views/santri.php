<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Santri
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">Data Santri Aktif</li>
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
                                <i class="fa fa-times"></i> <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="box-title">Data Santri Putra</h3>
                        <a href="<?= base_url('santri/sync'); ?>" onclick="return confirm('Apakah Anda yakin ingin melakukan sinkronisasi data santri dari Database Sentral? Data santri lokal akan diperbarui.')" class="btn btn-sm btn-primary pull-right">
                            <i class="fa fa-refresh"></i> Sync Data Santri
                        </a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kelas</th>
                                        <th>HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($baru as $dt) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dt->nis; ?></td>
                                            <td><?= $dt->nama; ?></td>
                                            <td><?= $dt->jln . ' RT ' . $dt->rt . '/RW ' . $dt->rw . ' - ' . $dt->desa . ' - ' . $dt->kec . ' - ' . $dt->kab; ?></td>
                                            <td><?= $dt->k_formal . ' - ' . $dt->t_formal; ?></td>
                                            <td><?= $dt->hp; ?></td>
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