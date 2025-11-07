<style>
#btnGroupDrop1::after {
    display: none;
    /* Hilangkan panah default */
}
</style>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Riwayat Pengeluaran Kas Kecil</h3>
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
                    <li class="breadcrumb-item">Pengeluaran Kas Kecil</li>
                    <li class="breadcrumb-item active">Riwayat </li>
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
                        <h4>Riwayat Bukti Pengeluaran Kas Kecil</h4>
                        <div id="reportrange1"
                            style="cursor:pointer; padding:6px 12px; border:1px solid #ddd; border-radius:4px;">
                            <span></span> <i class="fa fa-calendar"></i>
                        </div>

                        <div class="btn-group" role="group">
                            <button
                                class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center justify-content-center"
                                type="button" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width:30px; height:30px; padding:0;">
                                <i data-feather="printer" style="width:18px; height:18px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#" id="exportPdf">Export PDF</a></li>
                                <li><a class="dropdown-item" href="#" id="exportExcel">Export Excel</a></li>
                            </ul>
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
                                <?php
                                $no = 1;
                                foreach ($rowriwayatmutasi as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d/m/Y', strtotime(str_replace('/', '-', $data['tanggal']))); ?></td>
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
                                    <td><?= isset($data['total_debet_cab']) && $data['total_debet_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_debet_cab'], 0, ',', '.')
                                                : '-'; ?></td>
                                    <td></td>
                                    <td><?= isset($data['total_kredit_cab']) && $data['total_kredit_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.')
                                                : '-'; ?></td>
                                    <td>
                                        <?= isset($data['sisa_saldo']) && $data['sisa_saldo'] !== null
                                                ? 'Rp. ' . number_format($data['sisa_saldo'], 0, ',', '.')
                                                : '-'; ?>
                                    </td>

                                    <td></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
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
                                        </div>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal view data bpkk -->
<div class="modal fade" id="viewdatatransaksi" tabindex="-1" role="dialog" aria-labelledby="viewdatatransaksi"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">VIEW DATA DEBET/KREDIT
                </h3>
                <div class="modal-body">
                    <div class="w-100">
                        <span id="jenisTransaksiBadge" class="badge bg-warning d-block w-100 text-dark text-center"
                            style="font-size: 14px;"></span>
                    </div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="220px"><strong>NO TRANSAKSI</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>TANGGAL</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>KETERANGAN</strong></td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL</strong></td>
                                    <td>: </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group" id="pratinjauGambar2"></div>
                    <pre><?= base_url(); ?></pre>
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
const BASE_URL = "<?= base_url(); ?>";
</script>
<script>
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

$(function() {
    let start = moment().subtract(29, 'days');
    let end = moment();

    function setRangeDisplay(start, end) {
        $('#reportrange1 span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    $('#reportrange1').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY'
        }
    }, function(start, end) {
        setRangeDisplay(start, end);
        window.location =
            "<?= site_url('Laporan_cabang/riwayat_mutasi'); ?>?awal=" +
            start.format('YYYY-MM-DD') + "&akhir=" + end.format('YYYY-MM-DD');
    });

    // ✅ tampilkan tanggal saat halaman pertama kali load
    <?php if (!empty($awal) && !empty($akhir)): ?>
    setRangeDisplay(moment("<?= $awal ?>", "YYYY-MM-DD"), moment("<?= $akhir ?>", "YYYY-MM-DD"));
    <?php else: ?>
    setRangeDisplay(start, end);
    <?php endif; ?>
});

$('#exportPdf').on('click', function(e) {
    e.preventDefault();

    let dateText = $('#reportrange1 span').text();
    let dates = dateText.split(' - ');
    let awal = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
    let akhir = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');

    let pdfUrl = "<?= site_url('Laporan_cabang/export_pdf'); ?>?awal=" + awal + "&akhir=" + akhir;
    window.open(pdfUrl, "_blank");
});

$('#exportExcel').on('click', function(e) {
    e.preventDefault();

    let dateText = $('#reportrange1 span').text();
    let dates = dateText.split(' - ');
    let awal = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
    let akhir = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');

    let excelUrl = "<?= site_url('Laporan_cabang/export_excel'); ?>?awal=" + awal + "&akhir=" +
        akhir;
    window.location.href = excelUrl;
});
</script>