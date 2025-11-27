<style>
#btnGroupDrop1::after {
    display: none;
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
                        <div id="reportrange"
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
                                    <th></th>
                                    <th>Total Kredit</th>
                                    <th>Status</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($rowbpkk as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>

                                    <td><?= date('d/m/Y', strtotime($data['tgl_kredit_cab'])); ?></td>

                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['ket_bpkk_cab']; ?></p>
                                                </a><span
                                                    class="<?= $data['no_bpkk_cab'] ? 'text-success' : 'text-success' ?>"
                                                    style="font-size:12px;">
                                                    <?= $data['no_bpkk_cab']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>Rp. <?= number_format($data['total_kredit_cab'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($data['status_cab'] == 'In progress') : ?>
                                        <span class="badge badge-warning text-dark">In progress</span>

                                        <?php elseif ($data['status_cab'] == 'Rejected') : ?>
                                        <span class="badge badge-danger" data-bs-toggle="popover"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Alasan Ditolak"
                                            data-bs-content="<?= !empty($data['ket_notifikasi']) ? htmlspecialchars($data['ket_notifikasi']) : 'Tidak ada keterangan'; ?>">
                                            Rejected
                                        </span>

                                        <?php elseif ($data['status_cab'] == 'Approved') : ?>
                                        <span class="badge badge-success">Approved</span>

                                        <?php else : ?>
                                        <span class="badge badge-info"><?= ucfirst($data['status_cab']); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="#" class="btn btn-outline-info btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-tanggalbpkk="<?= $data['tgl_kredit_cab']; ?>"
                                                data-keteranganbpkk="<?= $data['ket_bpkk_cab']; ?>"
                                                data-pengeluaran-bpkk="Rp. <?= number_format($data['total_kredit_cab'], 0, ',', '.'); ?>"
                                                data-nobpkk="<?= $data['no_bpkk_cab']; ?>"
                                                data-file="<?= $data['upload_file_cab']; ?>"
                                                data-status="<?= $data['status_cab']; ?>"
                                                data-jenissaldo="<?= $data['jenis_saldo']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#viewriwayatdatabpkk">
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
<div class="modal fade" id="viewriwayatdatabpkk" tabindex="-1" role="dialog" aria-labelledby="viewriwayatdatabpkk"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Bukti Pengeluaran Kas Kecil
                </h3>
                <div class="modal-body">
                    <div style="margin:0 -1rem; padding:0;">
                        <span class="badge d-block text-center"
                            style="font-size:14px; display:block; width:100%; border-radius:0;">
                        </span>
                    </div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="220px"><strong>NO BPKK</strong></td>
                                    <td id="modal_no_bpkk">: </td>
                                </tr>
                                <tr>
                                    <td><strong>TANGGAL</strong></td>
                                    <td id="modal_tanggal">: </td>
                                </tr>
                                <tr>
                                    <td><strong>KETERANGAN</strong></td>
                                    <td id="modal_keterangan">: </td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL PENGELUARAN BPKK</strong></td>
                                    <td id="modal_total">: </td>
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
$(document).on('click', '[data-bs-target="#viewriwayatdatabpkk"]', function() {
    const modal = $('#viewriwayatdatabpkk');

    $('#modal_no_bpkk').text(': ' + ($(this).data('nobpkk') || '-'));
    $('#modal_tanggal').text(': ' + ($(this).data('tanggalbpkk') || '-'));
    $('#modal_keterangan').text(': ' + ($(this).data('keteranganbpkk') || '-'));
    $('#modal_total').text(': ' + ($(this).data('pengeluaran-bpkk') || '-'));

    const status = $(this).data('status') || 'N/A';
    const badge = modal.find('.badge');
    badge
        .removeClass()
        .addClass('badge fw-bold d-block text-center ' +
            (status === 'Approved' ? 'bg-success text-white' :
                status === 'Rejected' ? 'bg-danger text-white' :
                status === 'In process' ? 'bg-secondary text-white' :
                'bg-warning text-dark'))
        .text(status);

    const file = $(this).data('file') || '';
    const jenisSaldo = $(this).data('jenissaldo') || '';

    const preview = $('#pratinjauGambar2');
    preview.empty();

    if (!file.trim()) {
        preview.html(`<p style="color:red;font-weight:bold;text-align:center;">
            Dokumen Pendukung belum di-upload.</p>`);
    } else {
        const fileUrl = "<?= base_url('uploads/BPKK/') ?>" + jenisSaldo + "/" + file;
        preview.html(`
            <p style="font-weight:bold;text-align:center;">Dokumen: ${file}</p>
            <iframe src="${fileUrl}" width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
        `);
    }
});


$('#viewriwayatdatabpkk').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());

$(function() {
    let start = moment().subtract(29, 'days');
    let end = moment();

    function setRangeDisplay(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY'
        }
    }, function(start, end) {
        setRangeDisplay(start, end);
        window.location =
            "<?= site_url('Bukti_pengeluaran_kas_kecil/riwayat_bpkk'); ?>?awal=" +
            start.format('YYYY-MM-DD') + "&akhir=" + end.format('YYYY-MM-DD');
    });

    <?php if (!empty($awal) && !empty($akhir)): ?>
    setRangeDisplay(moment("<?= $awal ?>", "YYYY-MM-DD"), moment("<?= $akhir ?>", "YYYY-MM-DD"));
    <?php else: ?>
    setRangeDisplay(start, end);
    <?php endif; ?>
});

$('#exportPdf').on('click', function(e) {
    e.preventDefault();

    let dateText = $('#reportrange span').text();
    let dates = dateText.split(' - ');
    let awal = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
    let akhir = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');

    let pdfUrl = "<?= site_url('Bukti_pengeluaran_kas_kecil/export_pdf'); ?>?awal=" + awal + "&akhir=" + akhir;
    window.open(pdfUrl, "_blank");
});

$('#exportExcel').on('click', function(e) {
    e.preventDefault();

    let dateText = $('#reportrange span').text();
    let dates = dateText.split(' - ');
    let awal = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
    let akhir = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');

    let excelUrl = "<?= site_url('Bukti_pengeluaran_kas_kecil/export_excel'); ?>?awal=" + awal + "&akhir=" +
        akhir;
    window.location.href = excelUrl;
});
</script>