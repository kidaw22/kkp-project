<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BantuWarga | Log in</title>
    <link rel="shortcut icon" href="<?= site_url() ?>assets/adminlte/img/newlogo.jpeg" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= site_url() ?>assets/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= site_url() ?>assets/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= site_url() ?>assets/adminlte/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= site_url() ?>assets/sweetalert2/sweetalert2.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= site_url() ?>assets.html"><b>Bantu</b>Warga</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Selamat Datang, silahkan masuk</p>

                <form method="post" id="frm_login">
                    <div class="form-group">
                        <input type="text" name="nik" class="form-control" placeholder="NIK" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btn_login" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= site_url() ?>assets/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= site_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= site_url() ?>assets/adminlte/js/adminlte.min.js"></script>

    <script src="<?= site_url() ?>assets/jquery-validation/jquery.validate.min.js"></script>

    <script src="<?= site_url() ?>assets/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#btn_login').on('click', function(e) {
                $('#frm_login').validate({
                    submitHandler: function() {
                        e.preventDefault();

                        $.ajax({
                            url: "<?= site_url() ?>login/check",
                            type: 'POST',
                            dataType: 'JSON',
                            data: $('#frm_login').serialize(),
                            success: function(data) {
                                if (data.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message
                                    }).then(() => {
                                        window.location.replace("<?= site_url() ?>dashboard")
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: data.message
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>