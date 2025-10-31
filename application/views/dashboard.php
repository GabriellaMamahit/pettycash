<style>
/* .default-dashboard2 .last-orders-table thead tr {
    border-bottom: 1px solid #f5f5f5;
}

.default-dashboard2 .last-orders-table thead tr th {
    color: #848789;
    padding: 0 5px 11px;
}

.default-dashboard2 .last-orders-table thead tr th:first-child {
    padding-left: 0;
}

.default-dashboard2 .last-orders-table thead tr th:first-child:after {
    display: none;
}

.default-dashboard2 .last-orders-table tbody tr td {
    padding: 18px 5px;
}

.default-dashboard2 .last-orders-table tbody tr td:first-child {
    padding-left: 0 !important;
}

.default-dashboard2 .last-orders-table tbody tr td:last-child {
    padding-right: 0 !important;
}

.default-dashboard2 .last-orders-table tbody tr:last-child {
    border-bottom: none;
}

.default-dashboard2 .last-orders-table tbody tr:last-child td {
    border-bottom: none !important;
    padding-bottom: 0;
}

.default-dashboard2 .search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.default-dashboard2 .search-bar label {
    margin-bottom: 0;
    color: #333;
}

.default-dashboard2 .search-bar input {
    min-width: 200px;
}

.dataTables_wrapper .dataTables_paginate {
    margin-top: 20px !important;
}

.dataTables_wrapper {
    padding-bottom: 20px !important;
} */

/* .btn-outline-teal {
    color: #215c5c;
    border-color: #215c5c;
    border-radius: 0;
}

.btn-check:checked+.btn-outline-teal {
    background-color: #215c5c;
    color: white;
    border-color: #215c5c;
}

.btn-group .btn-outline-teal:first-of-type {
    border-top-left-radius: 999px;
    border-bottom-left-radius: 999px;
}

.btn-group .btn-outline-teal:last-of-type {
    border-top-right-radius: 999px;
    border-bottom-right-radius: 999px;
}

.btn-check:focus+.btn-outline-teal,
.btn-check:active+.btn-outline-teal,
.btn-check:hover+.btn-outline-teal,
.btn-outline-teal:hover {
    border-color: #215c5c;
    box-shadow: 0 0 0 0.15rem rgba(33, 92, 92, 0.35);
    outline: none;
} */

.donut {
    position: relative;
    width: 100%;
    height: 200%;
}

.lineChart {
    /* width: 595px;
    height: 296px; */
    /* width: 100%;
    height: 400%; */
}
</style>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Dashboard <?= $this->fungsi->user_login()->address_user; ?></h3>
            </div>
            <div class="col-5 d-none d-xl-block"></div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a>
                    </li>
                    <li class="breadcrumb-item">General</li>
                    <!-- <li class="breadcrumb-item">Riwayat BPKK</li> -->
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
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <h4 class="mb-0">Status Pengeluaran Kas Kecil</h4>

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-2" style="width:220px;">
                            <label class="fw-bold mb-1">Pilih Cabang</label>
                            <select class="form-control" id="filterCabang" onchange="filterWidget()">
                                <option value="all">Semua Cabang</option>
                                <option value="JKT">Jakarta</option>
                                <option value="BPP">Balikpapan</option>
                                <option value="TBK">Karimun</option>
                                <option value="LU">Galang</option>
                                <option value="PA_BBM">Sekupang - BBM Pilot Boat</option>
                                <option value="PA_SB">Sekupang - Service Boat</option>
                                <option value="PA_RTK">Sekupang - RTK/ATK</option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- CARD DI DALAM CARD -->
                <div class="row mt-3">

                    <!-- IN PROGRESS -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card"
                        data-type="all JKT BPP TBK LU PA_BBM PA_SB PA_RTK">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-warning">In Progress</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="inProgressCount"><?= $in_progress['count']; ?></h3>
                                <div>Total: Rp <span id="inProgressTotal"><?= $in_progress['total']; ?></span></div>
                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'In progress');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'In progress');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
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

                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Approved');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Approved');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
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

                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Revisi');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Revisi');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
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
                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Rejected');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Rejected');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div> <!-- END ROW -->
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<!-- <div class="container-fluid default-dashboard">
    <div class="row">


    </div>
</div> -->

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="faq-wrap">

        <div class="row">
            <!-- <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Donut Chart</h4>
                    </div>
                    <div class="card-body apex-chart">
                        <div id="donutchart"></div>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4>Donut Chart</h4>
                            </div>
                            <div class="card-body apex-chart">
                                <div id="donutchart"></div>
                            </div>
                        </div>
                    </div>
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

            <?php $level = $this->fungsi->user_login()->level; ?>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Summary Petty Cash</h4>
                    </div>
                    <div class="card-body">
                        <?php foreach ($data_saldojkt as $saldo): ?>
                        <div class="container-fluid general-widget">
                            <ul class="customer-growth">

                                <!-- Jakarta -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-primary.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Jakarta</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldojkt'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetjkt'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetjkt'], 0, ',', '.') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditjkt'], 0, ',', '.') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldojkt'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Karimun -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-success.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Karimun</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldokarimun'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetkarimun'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetkarimun'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditkarimun'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldokarimun'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Balikpapan -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bsgroup'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-info.jpg"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Balikpapan</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldobalikpapan'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetbalikpapan'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetbalikpapan'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditbalikpapan'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldobalikpapan'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Layup -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-warning.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Layup</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldogalang'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetgalang'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetgalang'], 0, ',', '.') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditgalang'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldogalang'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Pemanduan - BBM Pilot Boat -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-secondary.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Pemanduan - BBM Pilot Boat</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgbbm'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetskpgbbm'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetskpgbbm'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditskpgbbm'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldoskpgbbm'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Pemanduan2 - Service Boat -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-danger.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Pemanduan2 - Service Boat</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgserviceboat'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetskpgserviceboat'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldoskpgserviceboat'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                                <!-- Pemanduan3 - ATK/RTK -->
                                <?php if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg', 'keuangan', 'finance_bdp'])): ?>
                                <li>
                                    <div class="customer-details">
                                        <div><img src="<?= base_url() ?>assets/images/flags/money-in-hand-grey.png"
                                                alt="flag"></div>
                                        <div>
                                            <h4 class="f-w-600">Pemanduan3 - ATK/RTK</h4>
                                            <span class="f-w-600">Plafon <strong>Rp.
                                                    <?= number_format($saldo['budgetsaldoskpgatkrtk'], 0, ',', '.') ?></strong></span>
                                        </div>
                                    </div>
                                    <?php
                                            $debet = $saldo['saldodebetskpgatkrtk'];
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
                                            <p><span class="f-w-600" style="color:#848789">Debet:
                                                </span><?= number_format($saldo['saldodebetskpgatkrtk'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Kredit:
                                                </span><?= number_format($saldo['saldokreditskpgatkrtk'], 0, ',', '.') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><span class="f-w-600" style="color:#848789">Saldo:
                                                </span><?= number_format($saldo['saldoskpgatkrtk'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
      </div> -->
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// data dari controller
var donutData = <?php echo json_encode($donut_chart); ?>;

// mapping kode jenis_saldo → label chart
var labelMap = {
    "JKT": "Jakarta",
    "TBK": "Karimun",
    "BPP": "Balikpapan",
    "LU": "Lay Up",
    "PA_BBM": "BBM Pilot Boat - Pemanduan",
    "PA_SB": "Service Boat - Pemanduan",
    "PA_RTK": "ATK/RTK - Pemanduan"
};

// hasil query jadi key-value {label: total}
var dataMap = {};
donutData.forEach(function(item) {
    var label = labelMap[item.jenis_saldo]; // ubah kode jadi label
    if (label) {
        dataMap[label] = parseInt(item.total);
    }
});

// urutan label fix
var fixedLabels = [
    "Jakarta",
    "Karimun",
    "Balikpapan",
    "Lay Up",
    "BBM Pilot Boat - Pemanduan",
    "Service Boat - Pemanduan",
    "ATK/RTK - Pemanduan"
];

// isi series sesuai urutan label fix
var seriesData = fixedLabels.map(function(label) {
    return dataMap[label] || 0; // kalau tidak ada, isi 0
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

// Data LineChart
var rekapTahunan = <?php echo json_encode($rekap_tahunan); ?>;

// mapping kode saldo ke label chart dan warna
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
            data: Object.values(rekapTahunan[key]), // urutan bulan 1-12
            borderColor: cabangConfig[key].color,
            backgroundColor: cabangConfig[key].color + "33", // warna transparan
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
                max: 100, // <--- batas atas Y axis
                ticks: {
                    stepSize: 5 // biar rapi (0, 5, 10, 15, 20, 25, 30)
                },
                grid: {
                    color: "#eeeeee"
                }
            }
        }
    }
});
</script>


<!-- === Main Content === -->
<!-- <div class="container-fluid default-dashboard2">
    <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Daftar Data Transaksi - <?= date('F Y'); ?></h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mb-4">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan </th>
                                    <th>Total Debet</th>
                                    <th></th>
                                    <th>Total Kredit</th>
                                    <th>Sisa Saldo</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowpengeluaranbpkk as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d/m/Y', strtotime(str_replace('/', '-', $data['tanggal']))); ?>
                                    </td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['keterangan']; ?></p>
                                                </a><span
                                                    class="<?= $data['jenis_transaksi'] === 'Kredit' ? 'text-warning' : 'text-success' ?>"
                                                    style="font-size:12px;">
                                                    <?= $data['jenis_transaksi'] === 'Kredit' ? $data['no_bpkk_cab'] : $data['no_pettycash']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?= isset($data['total_debet_cab']) && $data['total_debet_cab'] !== null
                                            ? 'Rp. ' . number_format($data['total_debet_cab'], 0, ',', '.')
                                            : '-'; ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <?= isset($data['total_kredit_cab']) && $data['total_kredit_cab'] !== null
                                            ? 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.')
                                            : '-'; ?>
                                    </td>
                                    <?php
                                    $this->db->select_sum('total_debet_cab', 'saldo_awal');
                                    $this->db->from('tb_data_mutasi');
                                    $this->db->where('jenis_transaksi', 'Debet');
                                    $this->db->where('no_pettycash', $data['no_pettycash']);
                                    $row_saldo = $this->db->get()->row();
                                    $saldo_awal = $row_saldo->saldo_awal ?? 0;

                                    $this->db->from('tb_data_mutasi');
                                    $this->db->where('no_pettycash', $data['no_pettycash']);
                                    $this->db->order_by('tanggal', 'ASC');
                                    $rowmutasi = $this->db->get()->result_array();

                                    $saldo_berjalan = $saldo_awal;
                                    foreach ($rowmutasi as $row) {
                                        if ($row['jenis_transaksi'] === 'Kredit') {
                                            $saldo_berjalan -= $row['total_kredit_cab'] ?? 0;
                                        }

                                        if ($row['id_mutasi'] == $data['id_mutasi']) {
                                            $sisa_saldo = ($row['jenis_transaksi'] === 'Kredit')
                                                ? 'Rp. ' . number_format($saldo_berjalan, 0, ',', '.')
                                                : '-';
                                            break;
                                        }
                                    }
                                    ?>

                                    <td>
                                        <?= $sisa_saldo; ?>
                                    </td>

                                    <td></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <a href="#" class="btn btn-outline-info btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat"
                                                data-jenistransaksi="<?= $data['jenis_transaksi'] ?? ''; ?>"
                                                data-nobpkk="<?= $data['no_bpkk_cab'] ?? ''; ?>"
                                                data-nodebet="<?= $data['no_pettycash'] ?? ''; ?>"
                                                data-tanggalbpkk="<?= $data['tanggal'] ?? '-'; ?>"
                                                data-keteranganbpkk="<?= $data['keterangan'] ?? '-'; ?>"
                                                data-totalkredit="<?= $data['total_kredit_cab'] ?? 0; ?>"
                                                data-totaldebet="<?= $data['total_debet_cab'] ?? 0; ?>"
                                                data-file="<?= $data['file'] ?? ''; ?>"
                                                data-jenissaldo="<?= $data['jenis_saldo'] ?? ''; ?>"
                                                data-bs-toggle="modal" data-bs-target="#viewdatatransaksi">
                                                <i data-feather="eye" style="width:12px; height:12px;"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-primary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Print">
                                                <i data-feather="printer" style="width:12px; height:12px;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const BASE_URL = "<?= base_url(); ?>";
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bsGroupForm = document.getElementById('bs_group_form');
    const bdpForm = document.getElementById('bdp_form');
    const totalDebet = document.getElementById('totalDebet');
    const saldoAlert = document.getElementById('saldoAlert');
    const submitBtn = document.getElementById('submitBtn');
    const addressCab = document.getElementById('address_cab');

    // === Toggle Form (BS Group / BDP) ===
    document.getElementById('optionsRadios1')?.addEventListener('change', () => {
        bsGroupForm.style.display = 'block';
        bdpForm.style.display = 'none';
    });
    document.getElementById('optionsRadios2')?.addEventListener('change', () => {
        bsGroupForm.style.display = 'none';
        bdpForm.style.display = 'block';
    });

    // === Modal View Data BPKK ===
    $(document).on('click', '[data-bs-target="#viewdatatransaksi"]', function() {
        const modal = $('#viewdatatransaksi');
        const badge = modal.find('#jenisTransaksiBadge');

        const data = {
            jenisTransaksi: $(this).data('jenistransaksi') || '',
            noBpkk: $(this).data('nobpkk') || '-',
            noDebet: $(this).data('nodebet') || '-',
            tanggal: $(this).data('tanggalbpkk') || '-',
            keterangan: $(this).data('keteranganbpkk') || '-',
            totalKredit: $(this).data('totalkredit') || '0',
            totalDebet: $(this).data('totaldebet') || '0',
            file: $(this).data('file') || '',
            jenisSaldo: $(this).data('jenissaldo') || ''
        };

        // Tentukan No Transaksi & Total berdasarkan jenis transaksi
        let noTransaksi = '-';
        let totalTransaksi = '-';

        if (data.jenisTransaksi === 'Debet') {
            noTransaksi = data.noDebet;
            totalTransaksi = data.totalDebet ? 'Rp. ' + Number(data.totalDebet).toLocaleString(
                'id-ID') : '-';
            badge.removeClass().addClass(
                    'badge bg-success d-block w-100 text-white text-center fw-bold')
                .text('TRANSAKSI DEBET');
        } else if (data.jenisTransaksi === 'Kredit') {
            noTransaksi = data.noBpkk;
            totalTransaksi = data.totalKredit ? 'Rp. ' + Number(data.totalKredit).toLocaleString(
                'id-ID') : '-';
            badge.removeClass().addClass('badge bg-warning d-block w-100 text-dark text-center fw-bold')
                .text('TRANSAKSI KREDIT');
        } else {
            badge.removeClass().addClass(
                    'badge bg-secondary d-block w-100 text-white text-center fw-bold')
                .text('TRANSAKSI TIDAK DIKETAHUI');
        }

        // Isi field di tabel modal
        const infoFields = {
            'NO TRANSAKSI': noTransaksi,
            'TANGGAL': data.tanggal,
            'KETERANGAN': data.keterangan,
            'TOTAL': totalTransaksi
        };

        modal.find('td').each(function() {
            const label = $(this).text().trim();
            if (infoFields[label] !== undefined) {
                $(this).next().text(': ' + infoFields[label]);
            }
        });

        // Tampilkan dokumen
        const preview = $('#pratinjauGambar2');
        if (!data.file.trim()) {
            preview.html(
                '<p style="color:red;font-weight:bold;text-align:center;">Dokumen Pendukung belum di-upload.</p>'
            );
        } else {
            const folder = data.jenisTransaksi === 'Debet' ? 'finance' : `BPKK/${data.jenisSaldo}`;
            preview.html(`
        <p style="font-weight:bold;text-align:center;">Dokumen: ${data.file}</p>
        <iframe src="${BASE_URL}/uploads/${folder}/${data.file}" 
                width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
    `);
        }
    });

    $('#viewdatatransaksi').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());

    // === Format Rupiah Input ===
    window.formatRupiah = el => {
        let num = el.value.replace(/[^,\d]/g, '');
        const parts = num.split(',');
        const sisa = parts[0].length % 3;
        let rupiah = parts[0].substr(0, sisa);
        const ribuan = parts[0].substr(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        el.value = 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
        const rawInput = document.getElementById(
            el.id === 'edit-totalDebet' ? 'edit-totalDebetRaw' : 'totalDebetRaw'
        );
        if (rawInput) rawInput.value = num.replace(/\./g, '');
    };

    const formatRupiahText = angka => {
        if (!angka) return 'Rp. 0';
        angka = angka.toString().replace(/[^,\d]/g, '');
        const parts = angka.split(',');
        const sisa = parts[0].length % 3;
        let rupiah = parts[0].substring(0, sisa);
        const ribuan = parts[0].substring(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        return 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
    };

    // Helper untuk update text tanpa trigger reflow berulang
    function updateTextContent(el, text) {
        window.requestAnimationFrame(() => {
            el.textContent = text;
        });
    }

    function checkSaldoCukup() {
        const rawValue = parseInt(document.getElementById('totalDebetRaw').value || 0);
        const addressUser = totalDebet.getAttribute('data-address_user');
        let saldo = 0;

        if (addressUser === 'sekupang') {
            const selected = document.querySelector('input[name="jenis_bpkk"]:checked');
            if (!selected) {
                saldoAlert.style.display = 'block';
                updateTextContent(saldoAlert, 'Silakan pilih jenis petty cash terlebih dahulu.');
                totalDebet.disabled = true;
                submitBtn.disabled = true;
                return;
            }
            saldo = parseInt(selected.getAttribute('data-saldo') || 0);
            totalDebet.disabled = false;
        } else {
            saldo = parseInt(totalDebet.getAttribute('data-saldo') || 0);
        }

        if (rawValue > saldo) {
            saldoAlert.style.display = 'block';
            updateTextContent(saldoAlert, 'Saldo petty cash tidak mencukupi.');
            submitBtn.disabled = true;
        } else {
            saldoAlert.style.display = 'none';
            submitBtn.disabled = false;
        }
    }
    // **Tambahkan ini supaya bisa dipanggil dari HTML (oninput)**
    window.checkSaldoCukup = checkSaldoCukup;

    // Listener jenis_bpkk
    $(document).on('change', 'input[name="jenis_bpkk"]', () => {
        const selected = document.querySelector('input[name="jenis_bpkk"]:checked');
        totalDebet.disabled = !selected;
        if (selected) addressCab.value = selected.value;
        checkSaldoCukup();
    });

    // === Tambahkan Class Wrapper ===
    const wrapper = document.querySelector('.summary-wrapper');
    if (wrapper) {
        const count = wrapper.querySelectorAll('.card-inner').length;
        const classMap = {
            1: 'one-card',
            2: 'two-card',
            3: 'three-card',
            4: 'four-card',
            5: 'five-card',
            6: 'six-card',
            7: 'seven-card'
        };
        if (classMap[count]) wrapper.classList.add(classMap[count]);
    }

    // Hilangkan warning Chrome (passive listener)
    window.addEventListener('wheel', () => {}, {
        passive: true
    });
});

function filterWidget() {
    var selected = $('#filterCabang').val();

    // Tampilkan animasi loading
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

            $('#loader').hide(); // sembunyikan loading
        },
        error: function() {
            alert("Gagal mengambil data filter");
            $('#loader').hide();
        }
    });
}
</script>