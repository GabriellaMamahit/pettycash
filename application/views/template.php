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
    <title>Petty Cash BMG - Dashboard</title>
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
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/flatpickr/flatpickr.min.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/bootstrap.css">
    <!-- Sweetalert -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/sweetalert2/sweetalert2.min.css" type="text/css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url() ?>assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/responsive.css">
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start   -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                                src="<?= base_url() ?>assets/images/logo/logo.png" alt=""></a></div>
                    <div class="toggle-sidebar">
                        <svg class="sidebar-toggle">
                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-animation"></use>
                        </svg>
                    </div>
                </div>
                <form class="col-sm-4 form-inline search-full d-none d-xl-block" action="#" method="get">
                    <div class="form-group">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Type to Search .." name="q" title="" autofocus>
                                <svg class="search-bg svg-color">
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#search"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="nav-right col-xl-8 col-lg-12 col-auto pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="serchinput">
                            <div class="serchbox">
                                <svg>
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#search"></use>
                                </svg>
                            </div>
                            <div class="form-group search-form">
                                <input type="text" placeholder="Search here...">
                            </div>
                        </li>
                        <li class="onhover-dropdown">
                            <div class="notification-box" style="position: relative; display: inline-block;">
                                <svg style="width:24px; height:24px;">
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#Bell"></use>
                                </svg>
                                <span id="notif-count"
                                    style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; font-size: 12px; padding: 2px 6px; display: none;">
                                </span>
                            </div>

                            <div class="onhover-show-div notification-dropdown" style="min-width: 350px;">
                                <h6 class="f-18 mb-0 dropdown-title">Notifications</h6>

                                <!-- Tambahkan area scroll -->
                                <div class="notification-card"
                                    style="max-height: 350px; overflow-y: auto; scrollbar-width: thin;">
                                    <ul id="list-notifikasi" style="margin:0; padding:0; list-style:none;">
                                        <li>
                                            <p class="text-center">Loading...</p>
                                        </li>
                                    </ul>
                                </div>

                                <!-- tombol “Lihat Semua” tetap tampil -->
                                <div class="text-center p-2 border-top" style="background:#f8f9fa;">
                                    <a href="<?= site_url('notifikasi') ?>" class="fw-bold text-primary">Lihat Semua</a>
                                </div>
                            </div>
                        </li>



                        <li>
                            <div class="mode">
                                <svg class="for-dark">
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#moon"></use>
                                </svg>
                                <svg class="for-light">
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#Sun"></use>
                                </svg>
                            </div>
                        </li>
                        <li class="profile-nav onhover-dropdown pe-0 py-0">
                            <div class="d-flex align-items-center profile-media"><img class="b-r-25"
                                    src="<?= base_url() ?>assets/images/dashboard/profile.png" alt="">
                                <div class="flex-grow-1 user">
                                    <span><?= $this->fungsi->user_login()->nama_user; ?></span>
                                    <p class="mb-0 font-nunito"><?= $this->fungsi->user_login()->address_user; ?>
                                        <svg>
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#header-arrow-down">
                                            </use>
                                        </svg>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <!-- <li><a href="<?= site_url('akun_user') ?>"><i data-feather="user"></i><span>Account
                                        </span></a>
                                </li>
                                <li><a href="<?= site_url('edit_profile') ?>"><i data-feather="settings"></i><span>Edit
                                            Profile</span></a>
                                </li> -->
                                <li><a href="<?= site_url('auth/logout') ?>"> <i data-feather="log-in"></i><span>Log
                                            Out</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">              
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
                </script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page body Start -->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                <div>
                    <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                                src="<?= base_url() ?>assets/images/logo/logo.png" alt=""><img
                                class="img-fluid for-dark" src="<?= base_url() ?>assets/images/logo/logo_dark.png"
                                alt=""></a>
                        <div class="toggle-sidebar">
                            <svg class="sidebar-toggle">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#toggle-icon"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                                src="<?= base_url() ?>assets/images/logo/logo-icon.png" alt=""></a></div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <?php
                        $level   = strtolower($this->session->userdata('level') ?? '');
                        $address = strtolower($this->session->userdata('address_user') ?? '');

                        // Definisi role akses
                        $developer_roles     = ['development', 'super_admin'];
                        $basic_user_roles    = ['user'];
                        $direktur_finance    = ['direktur_finance'];
                        $finance_roles       = ['finance_bdp', 'finance_bsgroup', 'finance_bmg'];
                        $accounting_roles    = ['accounting'];

                        $akses_dashboard       = array_merge($developer_roles, $finance_roles, $direktur_finance, $accounting_roles);
                        $akses_data_transaksi = array_merge($developer_roles, $basic_user_roles, $finance_roles, $direktur_finance);
                        $akses_kelola_saldo   = array_merge($developer_roles, $finance_roles, $direktur_finance);
                        $akses_laporan_pc     = array_merge($developer_roles, $finance_roles, $accounting_roles, $direktur_finance);
                        $akses_users_menu     = $developer_roles; // hanya development & super_admin
                        ?>

                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <!-- Logo & Back -->
                                <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                            src="<?= base_url() ?>assets/images/logo/logo-icon.png" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                            aria-hidden="true"></i></div>
                                </li>
                                <!-- General -->
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6 class="lan-1">General</h6>
                                    </div>
                                </li>
                                <?php if (in_array($level, $akses_dashboard)) : ?>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('dashboard') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-maps"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-maps"></use>
                                        </svg>
                                        <span>Dashboard</span></a>
                                </li>
                                <?php endif; ?>
                                <?php if (in_array($level, $developer_roles) || in_array($level, $basic_user_roles)) : ?>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-home"></use>
                                        </svg>
                                        <span>Kantor Cabang</span></a>
                                    <ul class="sidebar-submenu">
                                        <?php if (in_array($level, $developer_roles) || $address == 'jakarta') : ?>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_jkt') ?>">Jakarta</a></li>
                                        <?php endif; ?>
                                        <?php if (in_array($level, $developer_roles) || $address == 'karimun') : ?>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_karimun') ?>">Karimun</a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if (in_array($level, $developer_roles) || $address == 'balikpapan') : ?>
                                        <li><a
                                                href="<?= site_url('Dashboard_cab/dashboard_balikpapan') ?>">Balikpapan</a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if (in_array($level, $developer_roles) || $address == 'galang') : ?>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_galang') ?>">Galang</a></li>
                                        <?php endif; ?>
                                        <?php if (in_array($level, $developer_roles) || $address == 'sekupang') : ?>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_sekupang_bbm') ?>">Sekupang
                                                BBM Boat</a></li>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_sekupang_servicesboat') ?>">Sekupang
                                                Service Boat</a></li>
                                        <li><a href="<?= site_url('Dashboard_cab/dashboard_sekupang_rtk') ?>">Sekupang
                                                RTK</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if (in_array($level, array_merge($basic_user_roles, $developer_roles, $direktur_finance))) : ?>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('bukti_pengeluaran_kas_kecil') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-widget"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-widget"></use>
                                        </svg>
                                        <span>Pengeluaran Kas Kecil</span></a>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('pengajuan_pettycash') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-sample-page">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-sample-page">
                                            </use>
                                        </svg>
                                        <span>Pengajuan Petty Cash</span></a>
                                </li>
                                <?php endif; ?>

                                <?php if (in_array($level, $akses_data_transaksi)) : ?>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('data_transaksi') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-starter-kit">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-starter-kit">
                                            </use>
                                        </svg>
                                        <span>Transaksi Debet</span></a>
                                </li>
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('laporan_cabang') ?>">
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-learning">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-learning">
                                            </use>
                                        </svg>
                                        <span>Laporan Cabang</span>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php if (in_array($level, $akses_kelola_saldo)) : ?>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Finance</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('kelola_saldo') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-board"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-board"></use>
                                        </svg>
                                        <span>Approval Center</span></a>
                                </li>
                                <?php endif; ?>

                                <?php if (in_array($level, $akses_laporan_pc)) : ?>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-charts"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-charts"></use>
                                        </svg>
                                        <span>Laporan Petty Cash</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_jkt') ?>">
                                                Jakarta</a></li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_karimun') ?>">Karimun</a>
                                        </li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_balikpapan') ?>">Balikpapan</a>
                                        </li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_galang') ?>">Galang</a>
                                        </li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_bbm') ?>">Sekupang
                                                BBM Boat</a></li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_servicesboat') ?>">Sekupang
                                                Service Boat</a></li>
                                        <li><a
                                                href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_rtk') ?>">Sekupang
                                                RTK</a></li>
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if (in_array($level, $akses_users_menu)) : ?>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Develops</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= site_url('users') ?>">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-user"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#fill-user"></use>
                                        </svg>
                                        <span>Users</span></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <?php echo $contents ?>
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 p-0 footer-copyright">
                            <p class="mb-0">Copyright 2025 © Petty Cash by ICT Team.</p>
                        </div>
                        <div class="col-md-6 p-0">
                            <p class="heart mb-0">Bias Mandiri Group
                                <!-- <svg class="footer-icon">
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#heart"></use>
                                </svg> -->
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
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
    <script src="<?= base_url() ?>assets/js/scrollbar/simplebar.js"></script>
    <script src="<?= base_url() ?>assets/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?= base_url() ?>assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="<?= base_url() ?>assets/js/sidebar-menu.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/sidebar-pin.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/slick/slick.min.js"></script>
    <script src="<?= base_url() ?>assets/js/slick/slick.js"></script>
    <script src="<?= base_url() ?>assets/js/header-slick.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/chart/morris-chart/raphael.js"></script>
    <script src="<?= base_url() ?>assets/js/chart/morris-chart/morris.js"> </script>
    <script src="<?= base_url() ?>assets/js/chart/morris-chart/prettify.min.js"></script> -->
    <script src="<?= base_url() ?>assets/js/chart/apex-chart/apex-chart.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="<?= base_url() ?>assets/js/chart/apex-chart/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/js/notify/bootstrap-notify.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/dashboard/default.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/notify/index.js"></script> -->
    <script src="<?= base_url() ?>assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatable/datatables/datatable.custom.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/datatable/datatables/datatable.custom1.js"></script>
    <script src="<?= base_url() ?>assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="<?= base_url() ?>assets/js/owlcarousel/owl-custom.js"></script>
    <script src="<?= base_url() ?>assets/js/typeahead/handlebars.js"></script>
    <script src="<?= base_url() ?>assets/js/typeahead/typeahead.bundle.js"></script>
    <script src="<?= base_url() ?>assets/js/typeahead/typeahead.custom.js"></script>
    <script src="<?= base_url() ?>assets/js/typeahead-search/handlebars.js"></script>
    <script src="<?= base_url() ?>assets/js/typeahead-search/typeahead-custom.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/chart/chartjs/chart.min.js"></script>
    <script src="<?= base_url() ?>assets/js/chart/chartjs/chart.custom.js"></script> -->
    <script src="<?= base_url() ?>assets/js/flat-pickr/flatpickr.js"></script>
    <script src="<?= base_url() ?>assets/js/flat-pickr/custom-flatpickr.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/height-equal.js"></script> -->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?= base_url() ?>assets/js/script.js"></script>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="<?= base_url() ?>assets/js/theme-customizer/customizer.js"></script> -->
    <!-- Plugin used-->
    <script>
    $(function() {
        var url = window.location;
        // console.log(url);
        $('ul.sidebar-links a').filter(function() {
            return this.href == url;
        }).addClass('active');

        $('ul.sidebar-submenu a').filter(function() {
                return this.href == url;
            }).parentsUntil(".sidebar-links > .sidebar-submenu")
            .css({
                'display': 'block'
            }).prev('a').addClass('active');

        $('div.submenu-title').filter(function() {
            return this.href == url;
        }).addClass('active');

        $('ul.submenu-content a').filter(function() {
                return this.href == url;
            }).parentsUntil(".sidebar-links > .submenu-content")
            .css({
                'display': 'block'
            }).prev('a').addClass('active');

    });
    </script>

    <?php if ($this->session->flashdata('success')): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata("success") ?>',
            confirmButtonColor: '#376464'
        });
    });
    </script>
    <?php $this->session->unset_userdata('success'); ?>
    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: '<?= strip_tags($this->session->flashdata("error")) ?>',
            confirmButtonColor: '#c06240'
        });
    });
    </script>
    <?php $this->session->unset_userdata('error'); ?>
    <?php endif; ?>

    <script>
    function loadNotifikasi() {
        fetch("<?= site_url('notifikasi/get_latest') ?>")
            .then(response => response.json())
            .then(data => {
                let html = "";
                const notifBadge = document.getElementById("notif-count");
                const unreadCount = data.length; // sekarang langsung jumlah total unread

                // Update badge merah
                if (unreadCount > 0) {
                    notifBadge.innerText = unreadCount;
                    notifBadge.style.display = "inline-block";
                } else {
                    notifBadge.style.display = "none";
                }

                // Tampilkan daftar notifikasi
                if (data.length > 0) {
                    data.forEach(row => {
                        const warna = row.jenis_notifikasi === 'Permintaan' ? 'text-warning' :
                            row.jenis_notifikasi === 'Penambahan' ? 'text-success' :
                            row.jenis_notifikasi === 'Revisi' ? 'text-primary' :
                            row.jenis_notifikasi === 'Rejected' ? 'text-danger' : 'text-dark';

                        html += `
                    <li style="background-color:#f8f9fa;">
                        <div class="user-notification">
                            <div><img src="<?= base_url() ?>assets/images/avtar/2.jpg" alt="avatar"></div>
                            <div class="user-description">
                                <a href="javascript:void(0)" class="notif-item" data-id="${row.id_notifikasi}">
                                    <h4 class="${warna}" style="font-weight:bold;">${row.judul_notifikasi}</h4>
                                    <p>${row.ket_notifikasi}</p>
                                </a>
                                <span style="font-size:12px;">${row.tanggal_notifikasi}</span>
                            </div>
                        </div>
                    </li>`;
                    });

                    html +=
                        `<li class="text-center"><a href="<?= site_url('notifikasi/mark_as_read_all') ?>" id="mark-all">Tandai semua sudah dibaca</a></li>`;
                } else {
                    html = `<li><p class="text-center">Tidak ada notifikasi baru</p></li>`;
                }

                document.getElementById("list-notifikasi").innerHTML = html;
            })
            .catch(error => console.error("Error loading notifikasi:", error));
    }

    // load awal
    loadNotifikasi();
    // auto refresh tiap 1 menit
    setInterval(loadNotifikasi, 60000);

    // klik satu notifikasi → tandai dibaca
    $(document).on('click', '.notif-item', function() {
        const id = $(this).data('id');
        fetch("<?= site_url('notifikasi/mark_as_read/') ?>" + id)
            .then(() => loadNotifikasi());
    });

    // klik “tandai semua dibaca”
    $(document).on('click', '#mark-all', function(e) {
        e.preventDefault();
        fetch("<?= site_url('notifikasi/mark_as_read_all') ?>")
            .then(() => loadNotifikasi());
    });
    </script>

</body>

</html>