<?php

$dana = $pagu->nominal;
$pake = $pakai->krit + $pakai->sopir + $pakai->trans;
$sisa = $dana - $pake;
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <?php if ($user->level == 'humas') { ?>
        <div class="col-md-4 text-center">
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username">Selamat Datang <?= $user->nama ?></h3>

              <h5 class="widget-user-desc">Humas <?= $user->lembaga ?></h5>

            </div>
            <!-- <div class="widget-user-image">
              <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
            </div> -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?= $jumlah ?> data</h5>
                    <span class="description-text">Jumlah Pengajuan</span>
                  </div>

                </div>

                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?= rupiah($total) ?></h5>
                    <span class="description-text">Total Terpakai</span>
                  </div>

                </div>

              </div>

            </div>
          </div>

        </div>

      <?php } else { ?>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= rupiah($dana) ?></h3>
              <p>Pagu Anggran Nikmus</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= rupiah($pake) ?></h3>
              <p>Dana Terserap - <?= round(($pake) / $dana * 100, 2) ?>%</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= rupiah($sisa) ?></h3>
              <p>Sisa Dana - <?= round(($sisa) / $dana * 100, 2) ?>%</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
      <?php } ?>
    </div><!-- ./col -->
</div><!-- /.row -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->