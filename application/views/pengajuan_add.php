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
                        <h3 class="box-title">Tambah Data Pengajuan</h3>
                        <a href="<?= base_url('pengajuan'); ?>" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?= form_open('pengajuan/saveAdd'); ?>
                        <input type="hidden" name="lembaga" value="<?= $user->lembaga ?>">
                        <div class="form-group">
                            <label for="">Nama yang akan dikunjungi</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kriteria</label>
                            <select name="jenis" id="listKrit" class="form-control">
                                <option value=""> -jenis nikmus- </option>
                                <?php foreach ($jenis as $kd) : ?>
                                    <option value="<?= $kd->jenis; ?>"><?= $kd->jenis ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="isistatus"></div>
                            <label for="">Keterangan Nikmus</label>
                            <input type="text" name="kriteria" class="form-control" placeholder="Keterangan Nikmus" required>
                        </div>
                        <div class="form-group">
                            <label for="">Daerah/Tujuan</label>
                            <!-- <input type="text" name="daerah" class="form-control" required> -->
                            <select name="daerah" id="" class="form-control">
                                <option value=""> -pilih- </option>
                                <?php foreach ($daerah as $kd) : ?>
                                    <option value="<?= $kd->kode_transport; ?>">
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
                                <input type="date" name="tgl_jalan" class="form-control pull-right" id="" required>
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