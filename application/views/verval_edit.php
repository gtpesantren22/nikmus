<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Data Pengajuan
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
                        <h3 class="box-title">Tambah Data Pengajuan</h3>
                        <a href="<?= base_url('verval'); ?>" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?= form_open('verval/setujui_add'); ?>
                        <input type="hidden" name="kode_pengajuan" class="form-control" value="<?= $data->kode_pengajuan; ?>" readonly>
                        <div class="form-group">
                            <label for="">Nama yang akan dikunjungi</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data->nama; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Lembaga</label>
                            <input type="text" name="lembaga" class="form-control" value="<?= $data->lembaga; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Kriteria</label><br>
                            <span class="label label-success"><?= $kritPilih->status ?></span><br>
                            <span class="label label-warning"><?= $kritPilih->jenis ?></span><span class="label label-danger"><?= $kritPilih->ybs ?></span><br><br>
                            <input type="text" name="kriteria" class="form-control" value="<?= $data->kriteria; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Daerah/Tujuan</label>
                            <input type="text" name="daerah" class="form-control" value="<?= $daerah->daerah; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Mobil/Bensin</label>
                            <input type="text" name="transport" class="form-control uang" value="<?= $data->transport; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Transport Sopir</label>
                            <input type="text" name="sopir" class="form-control uang" value="<?= $data->sopir; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Amplop</label>
                            <input type="text" name="nom_kriteria" class="form-control uang" value="<?= $data->nom_kriteria; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <button class="btn btn-success">Simpan & Setujui</button>
                        </div>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->