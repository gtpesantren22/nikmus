<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aplikasi NIKMUS Pesantren</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous" > -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-red-light sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?= base_url() ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>S</b>PST</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Nik</b>Mus</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">


                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= base_url('assets/') ?>dist/img/avatar2.png" class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs"><?= $user->nama; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= base_url('assets/') ?>dist/img/avatar2.png" class="img-circle"
                                        alt="User Image">
                                    <p>
                                        <?= $user->nama; ?>
                                        <small><?= $user->level; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= base_url('login/logout'); ?>"
                                            onclick="return confirm('Yakin akan keluar ?')"
                                            class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="<?= base_url('login/logout'); ?>" onclick="return confirm('Yakin akan keluar ?')">
                                <i class="fa fa-power-off"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= base_url('assets/') ?>dist/img/avatar2.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $user->nama; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="<?= $judul === 'index' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li
                        class="treeview <?= $judul === 'santri' || $judul === 'transport' || $judul === 'kriteria' || $judul === 'user' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Master Data</span> <i
                                class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $judul === 'santri' ? 'active' : '' ?>"><a
                                    href="<?= base_url('santri') ?>"><i class="fa fa-circle-o"></i> Data
                                    Santri</a></li>
                            <li class="<?= $judul === 'transport' ? 'active' : '' ?>"><a
                                    href="<?= base_url('transport') ?>"><i class="fa fa-circle-o"></i> Data
                                    Transportasi</a></li>
                            <li class="<?= $judul === 'kriteria' ? 'active' : '' ?>"><a
                                    href="<?= base_url('kriteria') ?>"><i class="fa fa-circle-o"></i> Data
                                    Kriteria</a></li>
                            <li class="<?= $judul === 'user' ? 'active' : '' ?>"><a href="<?= base_url('user') ?>"><i
                                        class="fa fa-circle-o"></i> Data User</a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="treeview <?= $judul === 'data' || $judul === 'verval' || $judul === 'cair' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-plus-circle"></i> <span>Pengajuan</span> <i
                                class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $judul === 'data' ? 'active' : '' ?>"><a
                                    href="<?= base_url('pengajuan') ?>"><i class="fa fa-circle-o"></i>Data Pengajuan</a>
                            </li>
                            <li class="<?= $judul === 'verval' ? 'active' : '' ?>"><a
                                    href="<?= base_url('verval') ?>"><i class="fa fa-circle-o"></i> Verval</a></li>
                            <li class="<?= $judul === 'cair' ? 'active' : '' ?>"><a
                                    href="<?= base_url('pencairan') ?>"><i class="fa fa-circle-o"></i> Pencairan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= $judul === 'spj' ? 'active' : '' ?>">
                        <a href="<?= base_url('spj') ?>">
                            <i class="fa fa-file"></i> <span>SPJ</span>
                        </a>
                    </li>
                    <li class="<?= $judul === 'history' ? 'active' : '' ?>">
                        <a href="<?= base_url('history') ?>">
                            <i class="fa fa-line-chart"></i> <span>History Pengajuan</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>