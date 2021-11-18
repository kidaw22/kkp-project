<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BantuWarga</title>
    <?php
    $this->load->view('partials/header');
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= site_url() ?>/assets/adminlte/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php
            $this->load->view('partials/top_nav');
            ?>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php $this->load->view('partials/sidebar') ?>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $breadcrumb ?></h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <?php
            $this->load->view($content);
            ?>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

    </div>
</body>

</html>