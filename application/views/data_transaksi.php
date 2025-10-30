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
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Data Transaksi Debet <?= $this->fungsi->user_login()->address_user; ?></h3>
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
                    <li class="breadcrumb-item active">Data Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- === Main Content === -->
<div class="container-fluid default-dashboard2">
    <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Daftar Transaksi Debet</h4>
                        <!-- <div class="dropdown icon-dropdown setting-menu">
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
                        </div> -->
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Periode</th>
                                    <th>Kantor Cabang</th>
                                    <th>Total Debet</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowdatatransaksi as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d F Y', strtotime($data['tanggal_debet'])); ?></td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['kantor_cabang']; ?></p>
                                                </a><span
                                                    class="<?= (!empty($data['no_petty_cash'])) ? 'text-success' : 'text-warning' ?>"
                                                    style="font-size:12px;">
                                                    <?= !empty($data['no_petty_cash']) ? $data['no_petty_cash'] : '-'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp. <?= number_format($data['saldo_debet'], 0, ',', '.'); ?></td>
                                    <td></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
                                            <a href="#" class="btn btn-outline-info btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-tanggaldebet="<?= $data['tanggal_debet']; ?>"
                                                data-no_pettycash="<?= $data['no_petty_cash']; ?>"
                                                data-totaldebet="Rp. <?= number_format($data['saldo_debet'], 0, ',', '.'); ?>"
                                                data-kantorcab="<?= $data['kantor_cabang']; ?>"
                                                data-filedebet="<?= $data['file']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#viewdatadebet">
                                                <i data-feather="eye" style="width:12px; height:12px;"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- <a href="#" class="btn btn-outline-primary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Print">
                                                <i data-feather="printer" style="width:12px; height:12px;"></i>
                                            </a> -->
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


<!-- modal view data debet -->
<div class="modal fade" id="viewdatadebet" tabindex="-1" role="dialog" aria-labelledby="viewdatadebet"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Bukti Pengeluaran Kas Kecil
                </h3>
                <div class="modal-body">
                    <div class="w-100">
                        <span class="badge bg-success d-block w-100 text-dark text-center"
                            style="font-size: 14px;"></span>
                    </div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="220px"><strong>NO DEBET SALDO</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>PERIODE</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>KANTOR CABANG</strong></td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL DEBET</strong></td>
                                    <td>: </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group" id="pratinjauGambar2"></div>
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '[data-bs-target="#viewdatadebet"]', function() {
    const modal = $('#viewdatadebet');
    const statusBadge = modal.find('.badge');

    const data = {
        tanggal: $(this).data('tanggaldebet') || '-',
        noPetty: $(this).data('no_pettycash') || '-',
        total: $(this).data('totaldebet') || '0',
        kantor: $(this).data('kantorcab') || '-',
        file: $(this).data('filedebet') || ''
    };

    const infoFields = {
        'NO DEBET SALDO': data.noPetty,
        'PERIODE': data.tanggal,
        'KANTOR CABANG': data.kantor,
        'TOTAL DEBET': data.total
    };

    modal.find('td').each(function() {
        const label = $(this).text().trim();
        if (infoFields[label] !== undefined) $(this).next().text(': ' + infoFields[label]);
    });

    const preview = $('#pratinjauGambar2');
    if (!data.file.trim()) {
        preview.html(`<p style="color:red;font-weight:bold;text-align:center;">
            Dokumen Pendukung belum di-upload.</p>`);
    } else {
        preview.html(`
            <p style="font-weight:bold;text-align:center;">Dokumen: ${data.file}</p>
            <iframe src="uploads/finance/${data.file}" 
                    width="100%" height="450px" style="border:1px solid #ccc;"></iframe>`);
    }
});

$('#viewdatadebet').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());
</script>