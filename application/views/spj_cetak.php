<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SPJ Nikmus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <center>
            <h2>FORM SPJ NIKMUS <br>PP DARUL LUGHAH WAL KAROMAH</h2>
            <hr>
        </center>

        <div class="row">
            <div class="col-md-4">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Kode</th>
                        <th>:</th>
                        <th><?= $dataSpj->kode_pengajuan ?></th>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <th>:</th>
                        <th><?= $data->nama ?></th>
                    </tr>
                    <tr>
                        <th>Lembaga</th>
                        <th>:</th>
                        <th><?= $data->lembaga ?></th>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <th>:</th>
                        <th><?= $data->kriteria ?></th>
                    </tr>
                    <tr>
                        <th>Daerah</th>
                        <th>:</th>
                        <th><?= $daerah->daerah ?></th>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <th>:</th>
                        <th><?= tanggalIndo($data->tgl_jalan) ?></th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <h5>Nominal Nikmus</h5>
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sopir</th>
                            <th>Transport</th>
                            <th>Nikmus</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td><?= rupiah($data->sopir) ?></td>
                            <td><?= rupiah($data->transport) ?></td>
                            <td><?= rupiah($data->nom_kriteria) ?></td>
                            <th><?= rupiah($data->nom_kriteria + $data->transport + $data->sopir) ?></th>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Pencairan</th>
                            <th><?= rupiah($cair->nom_cair) ?></th>
                        </tr>
                        <tr>
                            <th colspan="4">Terpakai</th>
                            <th><?= rupiah($dataSpj->serap) ?></th>
                        </tr>
                        <tr>
                            <th colspan="4">Sisa</th>
                            <th><?= rupiah($cair->nom_cair - $dataSpj->serap) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <h5>Hasil Nikmus</h5>
            <div class="col-md-12">
                <div class="form-control">
                    <label for=""><b>Anggota Nikmus</b></label>
                    <p><?= $dataSpj->peserta ?></p>
                </div>
                <div class="form-control">
                    <label for=""><b>Hasil Nikmus</b></label>
                    <p><?= $dataSpj->hasil ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($fileFotoHasil as $hsl) : ?>
                <div class="col-md-6">
                    <b>Foto-foto Hasil</b><br>
                    <img style="border: #000 1px solid;" src="<?= base_url('assets/berkas/' . $hsl->berkas) ?>" alt="" width="300px">
                </div>
            <?php endforeach ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <?php foreach ($fileFotoNota as $nt) : ?>
                <div class="col-md-6">
                    <b>Foto-foto Nota</b><br>
                    <img style="border: #000 1px solid;" src="<?= base_url('assets/berkas/' . $nt->berkas) ?>" alt="" width="300px">
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
<script>
    window.print()
</script>

</html>