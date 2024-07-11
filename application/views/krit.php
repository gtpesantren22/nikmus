<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Data Kriteria
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">Data Nominal Kriteria</li>
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
                        <h3 class="box-title">Data Kriteria</h3>
                        <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus-circle"></i> Tambah
                            Data</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Status</th>
                                        <th>Jenis</th>
                                        <th>Yang Bersangkutan</th>
                                        <th>Nominal</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dt->kode_kriteria; ?></td>
                                            <td><?= $dt->status; ?></td>
                                            <td><?= $dt->jenis; ?></td>
                                            <td><?= $dt->ybs; ?></td>
                                            <td><?= rupiah($dt->nominal); ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#<?= $dt->kode_kriteria ?>">Edit</button>
                                                <a href="<?= base_url('kriteria/del/' . $dt->kode_kriteria); ?>" onclick="return confirm('Yakin akan dihpaus ?')" class="btn btn-danger btn-xs">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="<?= $dt->kode_kriteria ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Edit Data Kriteria</h4>
                                                    </div>
                                                    <?= form_open('kriteria/edit') ?>
                                                    <input type="hidden" name="kode_kriteria" value="<?= $dt->kode_kriteria; ?>">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value=""> -pilih status- </option>
                                                                <option value="Pengasuh, Pimpinan dan karyawan/pengurus"> Pengasuh, Pimpinan dan karyawan/pengurus </option>
                                                                <option value="Guru Tetap">Guru Tetap</option>
                                                                <option value="Siswa/santri mukim">Siswa/santri mukim</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Nominal</label>
                                                            <input type="text" class="uang form-control" name="nominal" required value="<?= $dt->nominal; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
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
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data Kriteria</h4>
            </div>
            <?= form_open('kriteria/add') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control" required>
                        <option value=""> -pilih status- </option>
                        <option value="Pengasuh, Pimpinan dan karyawan/pengurus"> Pengasuh, Pimpinan dan karyawan/pengurus </option>
                        <option value="Guru Tetap">Guru Tetap</option>
                        <option value="Siswa/santri mukim">Siswa/santri mukim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value=""> -pilih jenis- </option>
                        <option value="Nikmat"> Nikmat </option>
                        <option value="Musibah">Musibah</option>
                        <option value="Sakit Ringan">Sakit Ringan</option>
                        <option value="Kunjungan">Kunjungan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Yang Bersangkutan</label>
                    <select name="ybs" class="form-control" required>
                        <option value=""> -pilih jenis- </option>
                        <option value="Diri Sendiri"> Diri Sendiri </option>
                        <option value="Istri/suami dan Anak Kandung">Istri/suami dan Anak Kandung</option>
                        <option value="Orang tua Kandung">Orang tua Kandung</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nominal</label>
                    <input type="text" class="uang form-control" name="nominal" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
            <?= form_close() ?>
        </div>

    </div>

</div>