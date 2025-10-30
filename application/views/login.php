<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Zono admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Zono admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/x-icon">
    <title>Petty Cash BMG - Login</title>
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/bootstrap.css">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/sweetalert2/sweetalert2.min.css" type="text/css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url() ?>assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/responsive.css">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div>
                            <a class="logo" href="index.html"><img class="img-fluid for-light"
                                    src="<?= base_url() ?>assets/images/logo/logobmg.png" alt="looginpage"><img
                                    class="img-fluid for-dark" src="<?= base_url() ?>assets/images/logo/logo_dark.png"
                                    alt="looginpage"></a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" id="formAuthentication" action="<?= base_url('auth/process') ?>"
                                method="post">
                                <h3>Sign in to account</h3>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" id="email" name="email" required=""
                                        placeholder="Enter your email" autocomplete="username">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="password">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" id="password" name="password"
                                            required="" placeholder="*********" autocomplete="current-password">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button name="login" class="btn btn-primary btn-block w-100" type="submit">Sign
                                            in</button>
                                    </div>
                                </div>
                                <p class="mt-4 mb-0 text-center"><a class="ms-2"
                                        href="<?= site_url('lupapassword') ?>">Forgot
                                        password?</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="<?= base_url() ?>assets/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="<?= base_url() ?>assets/js/script.js"></script>
        <!-- Sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php if ($this->session->flashdata('error') && $this->uri->segment(1) == 'auth'): ?>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('error'); ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            <?php endif; ?>
        });
        </script>
        <?php $this->session->unset_userdata('error'); ?>
        <?php endif; ?>
    </div>
</body>

</html>