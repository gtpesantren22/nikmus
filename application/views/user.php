<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Data User
            <small>Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Data</a></li>
            <li class="active">Data User Pengguna</li>
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
                        <h3 class="box-title">Data User</h3>
                        <button class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus-circle"></i> Tambah
                            Data</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Lembaga</th>
                                        <th>Aktif</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $dt->nama; ?></td>
                                            <td><?= $dt->username; ?></td>
                                            <td><?= $dt->level; ?></td>
                                            <td><?= $dt->lembaga; ?></td>
                                            <td><?= $dt->aktif; ?></td>
                                            <td>
                                                <!-- <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#<?= $dt->id_user ?>">Edit</button> -->
                                                <a href="<?= base_url('user/del/' . $dt->id_user); ?>" onclick="return confirm('Yakin akan dihpaus ?')" class="btn btn-danger btn-xs">Hapus</a>
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
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data User</h4>
            </div>
            <?= form_open('user/add') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="">Level</label>
                    <select name="level" id="" class="form-control" required>
                        <option value=""> -pilih- </option>
                        <option value="humas">Humas</option>
                        <option value="kasir">Kasir</option>
                        <option value="account">Accounting</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="text" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="">Lembaga</label>
                    <select name="lembaga" id="" class="form-control" required>
                        <option value=""> -pilih- </option>
                        <option value="MTs">MTs</option>
                        <option value="SMP">SMP</option>
                        <option value="MA">MA</option>
                        <option value="SMK">SMK</option>
                        <option value="Madin PA">Madin PA</option>
                        <option value="Madin Pi">Madin Pi</option>
                        <option value="Pesantren">Pesantren</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Aktif</label>
                    <div class="radio">
                        <label for="">
                            <input type="radio" name="aktif" id="optionsRadios1" value="Y">Ya
                        </label>
                    </div>
                    <div class="radio">
                        <label for="">
                            <input type="radio" name="aktif" id="optionsRadios1" value="T">Tidak
                        </label>
                    </div>
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