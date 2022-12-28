<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Pengajuan
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
                        <h3 class="box-title">Edit Data Pengajuan</h3>
                        <a href="<?= base_url('pengajuan'); ?>" class="btn btn-sm btn-warning pull-right"><i
                                class="fa fa-arrow-left"></i> Kembali</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?= form_open('pengajuan/editAct'); ?>
                        <input type="hidden" name="kode_pengajuan" value="<?= $data->kode_pengajuan ?>">
                        <div class="form-group">
                            <label for="">Nama yang akan dikunjungi</label>
                            <input type="text" name="nama" class="form-control" required value="<?= $data->nama; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Kriteria</label>
                            <select name="kriteria" id="" class="form-control">
                                <option value=""> -pilih- </option>
                                <?php foreach ($krit as $kd) : ?>
                                <option value="<?= $kd->kode_kriteria; ?>"
                                    <?= $kd->nama === $data->kriteria ? 'selected' : '' ?>>
                                    <?= $kd->kode_kriteria . ' - ' . $kd->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Daerah</label>
                            <select name="transport" id="" class="form-control">
                                <option value=""> -pilih- </option>
                                <?php foreach ($daerah as $kd) : ?>
                                <option value="<?= $kd->kode_transport; ?>"
                                    <?= $kd->daerah === $data->daerah ? 'selected' : '' ?>>
                                    <?= $kd->kode_transport . ' - ' . $kd->daerah; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Jalan</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" name="tgl_jalan" class="form-control pull-right" id="" required
                                    value="<?= $data->tgl_jalan; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <button class="btn btn-primary">Simpan Pengajuan</button>
                        </div>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->