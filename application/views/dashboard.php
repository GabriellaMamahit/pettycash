<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Dashboard <?= $this->fungsi->user_login()->address_user; ?></h3>
            </div>
            <div class="col-5 d-none d-xl-block"></div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a>
                    </li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid general-widget">
    <div class="row">
        <div class="col-xl-12">
            <div class="card p-3">
                <?php
                $level = $this->fungsi->user_login()->level;
                $address_user = strtolower($this->fungsi->user_login()->address_user);
                $akses = [];

                if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg'])) {
                    $akses = ['JKT', 'BPP', 'TBK', 'LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
                } elseif ($level == 'finance_bdp') {
                    $akses = ['LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
                } elseif ($level == 'finance_bsgroup') {
                    $akses = ['JKT', 'BPP', 'TBK'];
                } elseif ($level == 'user') {
                    if ($address_user == 'sekupang') {
                        $akses = ['PA_BBM', 'PA_SB', 'PA_RTK'];
                    } else {
                        $akses = ['JKT', 'BPP', 'TBK', 'LU'];
                    }
                }

                $labelCabang = [
                    'JKT' => 'Jakarta',
                    'BPP' => 'Balikpapan',
                    'TBK' => 'Karimun',
                    'LU' => 'Galang',
                    'PA_BBM' => 'Sekupang - BBM Pilot Boat',
                    'PA_SB' => 'Sekupang - Service Boat',
                    'PA_RTK' => 'Sekupang - RTK/ATK',
                ];
                ?>

                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <h4 class="mb-0">Status Pengeluaran Kas Kecil</h4>

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-2" style="width:220px;">
                            <label for="filterCabang" class="fw-bold mb-1">Pilih Cabang</label>
                            <select class="form-control" id="filterCabang" onchange="filterWidget()">
                                <option value="all">Semua Cabang</option>
                                <?php foreach ($akses as $kode) : ?>
                                <option value="<?= $kode ?>"><?= $labelCabang[$kode] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card"
                        data-type="all JKT BPP TBK LU PA_BBM PA_SB PA_RTK">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-warning">In Progress</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="inProgressCount"><?= $in_progress['count']; ?></h3>
                                <div>Total: Rp <span id="inProgressTotal"><?= $in_progress['total']; ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- APPROVED -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-success">Approved</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="approvedCount"><?= $approved['count']; ?></h3>
                                <div>Total: Rp <span id="approvedTotal"><?= $approved['total']; ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- REVISI -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-info">Revisi</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="revisiCount"><?= $revisi['count']; ?></h3>
                                <div>Total: Rp <span id="revisiTotal"><?= $revisi['total']; ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- REJECT -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-danger">Rejected</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="rejectedCount"><?= $rejected['count']; ?></h3>
                                <div>Total: Rp <span id="rejectedTotal"><?= $rejected['total']; ?></span></div>
                            </div>
                        </div>
                    </div>

                </div> <!-- END ROW -->
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="faq-wrap">
        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-lg-6">
                <div class="row">

                    <!-- Donut -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4>Donut Chart</h4>
                            </div>
                            <div class="card-body apex-chart">
                                <div class="donut" id="donutchart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Line Chart -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="header-top">
                                    <h4>History Total Pengeluaran</h4>
                                </div>
                            </div>
                            <div class="card-body chart-block" style="height:320px;">
                                <canvas id="myLineCharts" class="lineChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <?php $level = $this->fungsi->user_login()->level; ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Summary Petty Cash</h4>
                    </div>

                    <div class="card-body">
                        <div class="container-fluid general-widget">

                            <?php $saldo = $data_saldo[0]; ?>

                            <ul class="customer-growth">

                                <!-- Jakarta -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-primary.png"
                                                alt="flag">
                                        </div>
                                        <div>
                                            <h4 class="f-w-600">Jakarta</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldojkt'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetjkt'];
                                        $kredit = $saldo['saldokreditjkt'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-primary mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-primary rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-primary progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p> <span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetjkt'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p> <span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditjkt'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p> <span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldojkt'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Karimun -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-success.png"
                                                alt="flag">
                                        </div>
                                        <div>
                                            <h4 class="f-w-600">Karimun</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldokarimun'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetkarimun'];
                                        $kredit = $saldo['saldokreditkarimun'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-success mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-success rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-success progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-success"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetkarimun'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditkarimun'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldokarimun'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>


                                <!-- Balikpapan -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-info.jpg"
                                                alt="flag">
                                        </div>

                                        <div>
                                            <h4 class="f-w-600">Balikpapan</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldobalikpapan'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetbalikpapan'];
                                        $kredit = $saldo['saldokreditbalikpapan'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-info mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-info rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-info progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-info"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetbalikpapan'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditbalikpapan'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldobalikpapan'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>


                                <!-- Layup -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-warning.png"
                                                alt="flag">
                                        </div>
                                        <div>
                                            <h4 class="f-w-600">Layup</h4>
                                            <span class="f-w-600">
                                                Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldogalang'], 0, ',', '.') ?></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetgalang'];
                                        $kredit = $saldo['saldokreditgalang'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-warning mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-warning rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-warning progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-warning"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetgalang'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditgalang'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldogalang'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>


                                <!-- Pemanduan - BBM Pilot Boat -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-secondary.png"
                                                alt="flag">
                                        </div>

                                        <div>
                                            <h4 class="f-w-600">Pemanduan - BBM Pilot Boat</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgbbm'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetskpgbbm'];
                                        $kredit = $saldo['saldokreditskpgbbm'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div
                                        class="progress sm-progress-bar overflow-visible progress-border-secondary mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-secondary rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-secondary progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-secondary"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetskpgbbm'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditskpgbbm'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldoskpgbbm'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>


                                <!-- Pemanduan2 - Service Boat -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-danger.png"
                                                alt="flag">
                                        </div>
                                        <div>
                                            <h4 class="f-w-600">Pemanduan2 - Service Boat</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgserviceboat'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetskpgserviceboat'];
                                        $kredit = $saldo['saldokreditskpgserviceboat'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-danger mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-danger rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-danger progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-danger"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldoskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>


                                <!-- Pemanduan3 - ATK/RTK -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div>
                                            <img src="<?= base_url() ?>assets/images/flags/money-in-hand-grey.png"
                                                alt="flag">
                                        </div>

                                        <div>
                                            <h4 class="f-w-600">Pemanduan3 - ATK/RTK</h4>
                                            <span class="f-w-600">
                                                Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgatkrtk'], 0, ',', '.') ?></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <?php
                                        $debet  = $saldo['saldodebetskpgatkrtk'];
                                        $kredit = $saldo['saldokreditskpgatkrtk'];
                                        $persentase = $debet > 0 ? min(($kredit / $debet) * 100, 100) : 0;
                                        $persentase_format = number_format($persentase, 0);
                                        ?>

                                    <div class="progress sm-progress-bar overflow-visible progress-border-dark mt-4">
                                        <div class="progress-bar-animated small-progressbar bg-dark rounded-pill progress-bar-striped"
                                            role="progressbar" style="width: <?= $persentase_format ?>%"
                                            aria-valuenow="<?= $persentase_format ?>" aria-valuemin="0"
                                            aria-valuemax="100">

                                            <span class="txt-dark progress-label"><?= $persentase_format ?>%</span>
                                            <span class="animate-circle-dark"></span>

                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Debet:</span>
                                                <?= number_format($saldo['saldodebetskpgatkrtk'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:</span>
                                                <?= number_format($saldo['saldokreditskpgatkrtk'], 0, ',', '.') ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:</span>
                                                <?= number_format($saldo['saldoskpgatkrtk'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                            </ul>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
var donutData = <?php echo json_encode($donut_chart); ?>;

var labelMap = {
    "JKT": "Jakarta",
    "TBK": "Karimun",
    "BPP": "Balikpapan",
    "LU": "Lay Up",
    "PA_BBM": "BBM Pilot Boat - Pemanduan",
    "PA_SB": "Service Boat - Pemanduan",
    "PA_RTK": "ATK/RTK - Pemanduan"
};

var dataMap = {};
donutData.forEach(function(item) {
    var label = labelMap[item.jenis_saldo];
    if (label) {
        dataMap[label] = parseInt(item.total);
    }
});

var fixedLabels = [
    "Jakarta",
    "Karimun",
    "Balikpapan",
    "Lay Up",
    "BBM Pilot Boat - Pemanduan",
    "Service Boat - Pemanduan",
    "ATK/RTK - Pemanduan"
];

var seriesData = fixedLabels.map(function(label) {
    return dataMap[label] || 0;
});

// chart
var options9 = {
    chart: {
        width: 380,
        type: "donut",
    },
    series: seriesData,
    labels: fixedLabels,
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
            }
        },
    }],
    colors: ["#2b5f60", "#51bb25", "#0dcaf0", "#eeb407", "#c06240", "#dc3545", "#6f6f6f"]
};

var chart9 = new ApexCharts(document.querySelector("#donutchart"), options9);
chart9.render();
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data LineChart
var rekapTahunan = <?php echo json_encode($rekap_tahunan); ?>;

var cabangConfig = {
    "JKT": {
        label: "Jakarta",
        color: "#2b5f60"
    },
    "TBK": {
        label: "Karimun",
        color: "#51bb25"
    },
    "BPP": {
        label: "Balikpapan",
        color: "#0dcaf0"
    },
    "LU": {
        label: "Lay Up",
        color: "#eeb407"
    },
    "PA_BBM": {
        label: "BBM Pilot Boat - Pemanduan",
        color: "#c06240"
    },
    "PA_SB": {
        label: "Service Boat - Pemanduan",
        color: "#DE0021"
    },
    "PA_RTK": {
        label: "ATK/RTK - Pemanduan",
        color: "#7A7774"
    }
};

// buat datasets Chart.js
var datasets = [];
Object.keys(cabangConfig).forEach(function(key) {
    if (rekapTahunan[key]) {
        datasets.push({
            label: cabangConfig[key].label,
            data: Object.values(rekapTahunan[key]),
            borderColor: cabangConfig[key].color,
            backgroundColor: cabangConfig[key].color + "33",
            pointBackgroundColor: cabangConfig[key].color,
            tension: 0.3
        });
    }
});

var ctx = document.getElementById("myLineCharts").getContext("2d");
var LineChartDemo = new Chart(ctx, {
    type: "line",
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
        datasets: datasets
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: "bottom"
            }
        },
        scales: {
            x: {
                grid: {
                    color: "#eeeeee"
                }
            },
            y: {
                beginAtZero: true,
                min: 0,
                max: 100,
                ticks: {
                    stepSize: 5
                },
                grid: {
                    color: "#eeeeee"
                }
            }
        }
    }
});
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function filterWidget() {
    var selected = $('#filterCabang').val();
    $('#loader').show();

    $.ajax({
        url: "<?php echo base_url('Dashboard/filter_widget'); ?>",
        type: "POST",
        data: {
            jenis_saldo: selected
        },
        dataType: "json",
        success: function(result) {

            $("#inProgressCount").text(result.in_progress.count);
            $("#inProgressTotal").text(result.in_progress.total);

            $("#approvedCount").text(result.approved.count);
            $("#approvedTotal").text(result.approved.total);

            $("#revisiCount").text(result.revisi.count);
            $("#revisiTotal").text(result.revisi.total);

            $("#rejectedCount").text(result.rejected.count);
            $("#rejectedTotal").text(result.rejected.total);

            $('#loader').hide();
        },
        error: function() {
            alert("Gagal mengambil data filter");
            $('#loader').hide();
        }
    });
}
</script>