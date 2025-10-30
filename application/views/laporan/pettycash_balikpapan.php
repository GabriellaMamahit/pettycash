<style>
.default-dashboard2 .last-orders-table thead tr {
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
}

/* 
#pieChart {
    margin-bottom: 20px;
} */
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Laporan Petty Cash Balikpapan</h3>
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
                    <li class="breadcrumb-item active">Laporan Petty Cash</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- === Main Content === -->
<div class="container-fluid default-dashboard2">
    <div class="row">
        <div class="col-xl-8 col-md-12 box-col-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="text-center">Bukti Pengeluaran Kas Kecil Balikpapan</h4>
                </div>
                <div class="card-body chart-block">
                    <canvas id="bpkkBarGraph"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="text-center">Debet & Kredit Balikpapan</h4>
                </div>
                <div class="card-body chart-block">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Daftar Bukti Pengeluaran Kas Kecil Balikpapan</h4>
                        <div class="dropdown icon-dropdown setting-menu">
                            <button class="btn dropdown-toggle" id="userdropdown3" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg>
                                    <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#setting"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown3">
                                <a class="dropdown-item" href="#">Weekly</a>
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan Pengeluaran</th>
                                    <th>Total Debet</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowlapbpkkcabbpp as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d/m/Y', strtotime($data['tgl_kredit_cab'])); ?>
                                    </td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['ket_bpkk_cab']; ?></p>
                                                </a><span
                                                    class="<?= (!empty($data['no_bpkk_cab'])) ? 'text-success' : 'text-warning' ?>"
                                                    style="font-size:12px;">
                                                    <?= !empty($data['no_bpkk_cab']) ? $data['no_bpkk_cab'] : '-'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp. <?= number_format($data['total_kredit_cab'], 0, ',', '.') ?></td>
                                    <td></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= site_url('laporan_pettycash/cetak_pdf_jkt') ?>" target="_blank"
                                                class="btn btn-outline-danger btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Download PDF">
                                                <i data-feather="file-text" style="width:12px; height:12px;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
// Ambil data dari controller
$labels = array_map(function ($label) {
    // Hilangkan underscore & kapital huruf awal tiap kata
    return ucwords(str_replace('_', ' ', $label));
}, array_column($chart_data, 'jenis_pengeluaran_cab'));

$values = array_column($chart_data, 'total_kredit');
?>

<script>
const ctx = document.getElementById('bpkkBarGraph');

const labels = <?= json_encode($labels) ?>;
const values = <?= json_encode($values) ?>.map(v => Number(v));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pengeluaran (Rp)',
            data: values,
            backgroundColor: 'rgba(43, 95, 96,0.6)',
            borderColor: 'rgba(43, 95, 96,0.6)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw || 0;
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    maxTicksLimit: 8,
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        layout: {
            padding: 20
        }
    }
});

const totalDebet = <?= (int)$total_debet ?>;
const totalKredit = <?= (int)$total_kredit ?>;
const saldoAkhir = totalDebet - totalKredit;

new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: [
            `Total Debet : Rp ${totalDebet.toLocaleString('id-ID')}`,
            `Total Kredit : Rp ${totalKredit.toLocaleString('id-ID')}`,
            `Saldo Akhir : Rp ${saldoAkhir.toLocaleString('id-ID')}`
        ],
        datasets: [{
            data: [totalDebet, totalKredit, saldoAkhir],
            backgroundColor: [
                'rgba(192, 98, 64, 0.6)',
                'rgba(43, 95, 96,0.6)',
                'rgba(90, 130, 180, 0.6)'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 10,
                bottom: 30
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: (context) => {
                        const value = context.raw || 0;
                        return `${context.label}`;
                    }
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            }
        }
    }
});
</script>