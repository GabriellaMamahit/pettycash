<nav class="sidebar-main">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <?php
    $level   = strtolower($this->session->userdata('level') ?? '');
    $address = strtolower($this->session->userdata('address_user') ?? '');

    // Role groups
    $developer_roles   = ['development', 'super_admin'];
    $basic_user_roles  = ['user'];
    $direktur_finance  = ['direktur_finance'];
    $finance_roles     = ['finance_bdp', 'finance_bsgroup', 'finance_bmg'];
    $accounting_roles  = ['accounting'];

    // Akses menu
    $akses_dashboard       = array_merge($developer_roles, $finance_roles, $direktur_finance, $accounting_roles);
    $akses_bukti_pengeluaran = array_merge($basic_user_roles, $developer_roles, $direktur_finance);
    $akses_pengajuan_pc    = array_merge($basic_user_roles, $developer_roles);
    $akses_data_transaksi  = array_merge($developer_roles, $basic_user_roles, $finance_roles, $direktur_finance, $accounting_roles);
    $akses_kelola_saldo    = array_merge($developer_roles, $finance_roles, $direktur_finance);
    $akses_laporan_pc      = array_merge($developer_roles, $finance_roles, $accounting_roles, $direktur_finance);
    $akses_users_menu      = $developer_roles; // hanya development & super_admin
    ?>

    <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
            <!-- Logo & Back -->
            <li class="back-btn"><a href="index.html"><img class="img-fluid"
                        src="<?= base_url() ?>assets/images/logo/logo-icon.png" alt=""></a>
                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                        aria-hidden="true"></i></div>
            </li>

            <!-- ================= GENERAL ================= -->
            <li class="sidebar-main-title">
                <div>
                    <h6 class="lan-1">General</h6>
                </div>
            </li>

            <!-- Dashboard -->
            <?php if (in_array($level, $akses_dashboard)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= site_url('dashboard') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Dashboard</span></a>
            </li>
            <?php endif; ?>

            <!-- Kantor Cabang -->
            <?php if (in_array($level, $developer_roles) || in_array($level, $basic_user_roles)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                    <i class="fa fa-thumb-tack"></i>
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
                    <li><a href="<?= site_url('Dashboard_cab/dashboard_balikpapan') ?>">Balikpapan</a>
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

            <!-- Bukti Pengeluaran Kas Kecil -->
            <?php if (in_array($level, $akses_bukti_pengeluaran)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                    href="<?= site_url('bukti_pengeluaran_kas_kecil') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Bukti Pengeluaran Kas Kecil</span></a>
            </li>
            <?php endif; ?>

            <!-- Pengajuan Petty Cash -->
            <?php if (in_array($level, $akses_pengajuan_pc)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                    href="<?= site_url('pengajuan_pettycash') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Pengajuan Petty Cash</span></a>
            </li>
            <?php endif; ?>

            <!-- Data Transaksi -->
            <?php if (in_array($level, $akses_data_transaksi)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                    href="<?= site_url('data_transaksi') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Data Transaksi</span></a>
            </li>
            <?php endif; ?>

            <!-- Kelola Saldo -->
            <?php if (in_array($level, $akses_kelola_saldo)) : ?>
            <li class="sidebar-main-title">
                <div>
                    <h6>Finance</h6>
                </div>
            </li>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                    href="<?= site_url('kelola_saldo') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Kelola Saldo</span></a>
            </li>
            <?php endif; ?>

            <!-- Laporan Petty Cash -->
            <?php if (in_array($level, $akses_laporan_pc)) : ?>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Laporan Petty Cash</span></a>
                <ul class="sidebar-submenu">
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_jkt') ?>">Cabang
                            Jakarta</a></li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_karimun') ?>">Karimun</a>
                    </li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_balikpapan') ?>">Balikpapan</a>
                    </li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_galang') ?>">Galang</a>
                    </li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_bbm') ?>">Sekupang
                            BBM Boat</a></li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_servicesboat') ?>">Sekupang
                            Service Boat</a></li>
                    <li><a href="<?= site_url('laporan_pettycash/laporan_pettycash_sekupang_rtk') ?>">Sekupang
                            RTK</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Users -->
            <?php if (in_array($level, $akses_users_menu)) : ?>
            <li class="sidebar-main-title">
                <div>
                    <h6>Develops</h6>
                </div>
            </li>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= site_url('users') ?>">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Users</span></a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</nav>