<style>
.dataTables_wrapper {
    padding-bottom: 20px !important;
}

#viewpermintaan td {
    white-space: nowrap;
    vertical-align: middle;
}

@media (max-width: 1470px) {
    .signal-table.table-responsive .table tbody tr td:nth-child(n+2) {
        min-width: auto !important;
    }
}
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Detail Reimbursement </h3>
            </div>
            <div class="col-5 d-none d-xl-block"></div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a>
                    </li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item">Reimbursement</li>
                    <li class="breadcrumb-item active">Detail Reimbursement </li>
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
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="m-0">REIMBURSEMENT</h4>
                            <!-- <a class="btn btn-primary btn-sm ms-3 d-flex align-items-center gap-1 <?= ($saldo_pettycash > 0) ? 'disabled' : '' ?>"
                                title="<?= ($saldo_pettycash > 0) ? 'Tidak bisa tambah saldo karena masih ada saldo' : 'Tambah Saldo Awal' ?>"
                                data-bs-toggle="modal" data-bs-target="#tambahsaldopettycash"
                                data-jenis="<?= $jenis_saldo ?>"
                                style="<?= ($saldo_pettycash > 0) ? 'pointer-events: none; opacity: 0.5;' : '' ?>">
                                <i data-feather="plus" style="width:14px; height:14px;"></i> Tambah Saldo
                            </a> -->
                        </div>
                        <div class="setting-menu">
                            <a class="btn btn-secondary btn-sm d-flex align-items-center gap-1"
                                href="<?= site_url('pengajuan_pettycash') ?>" title="Kembali Ke Kelola Saldo">
                                <i data-feather="arrow-left" style="width:14px; height:14px;"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="220px"><strong>NO PETTY CASH</strong></td>
                                <td>: <strong><?php echo strtoupper($detail_reimbursement->no_pettycash) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TANGGAL</strong></td>
                                <td>:
                                    <strong><?php echo date('d/m/Y', strtotime($detail_reimbursement->tanggal_pettycash)); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>KETERANGAN</strong></td>
                                <td>: <strong><?php echo strtoupper($detail_reimbursement->ket_pettycash) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL PERMINTAAN SALDO</strong></td>
                                <td>: <strong>Rp
                                        <?= number_format($detail_reimbursement->saldo_pettycash, 0, ',', '.') ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="w-100">
                    <a id="btnDokumenPendukung" class="btn btn-outline-primary d-block w-100 view-dokumen-pendukung"
                        data-idrembes="<?= $detail_reimbursement->id_pettycash ?>"
                        data-file="<?= $detail_reimbursement->dokumen_pettycash ?>" data-bs-toggle="modal"
                        data-bs-target="#viewdokumenpendukungremb">
                        Dokumen Pendukung
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class=" row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Petty Cash Jakarta</h4>
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
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowdetailremb as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d/m/Y', strtotime($data['tgl_kredit_cab'])); ?></td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['ket_bpkk_cab']; ?></p>
                                                </a><span class="" style="font-size:12px;">
                                                    <?= $data['no_bpkk_cab']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <?php if (strtolower($data['status_cab']) === 'in progress'): ?>
                                        <span class="badge bg-warning text-dark">In progress</span>
                                        <?php elseif (strtolower($data['status_cab']) === 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                        <span
                                            class="badge bg-danger text-white"><?= ucfirst($data['status_cab']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Lihat -->
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- view data -->
                                            <a href="#" class="btn btn-outline-info btn-sm view-dokumen"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-bs-toggle="modal"
                                                data-jenis_saldo="<?= $data['jenis_saldo']; ?>"
                                                data-upload_file_cab="<?= $data['upload_file_cab']; ?>"
                                                data-bs-target="#viewdokumenbpkkrembesment">
                                                <i data-feather="eye" style="width:12px; height:12px"></i>
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

<div class="modal fade" id="viewdokumenbpkkrembesment" tabindex="-1" role="dialog"
    aria-labelledby="viewdokumenbpkkrembesment" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Dokumen Bukti Pengeluaran
                    Kas Kecil
                </h3>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group" id="pratinjauGambardok5"></div>
                    </div>
                    <br>
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

<div class="modal fade" id="viewdokumenpendukungremb" tabindex="-1" role="dialog"
    aria-labelledby="viewdokumenpendukungremb" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Dokumen Pendukung (PPT & Approval
                    Atasan)
                </h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation"
                        action="<?= site_url('pengajuan_pettycash/editdokumenapproval') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label txt-dark" for="formFile">Update Dokumen Pendukung : (PPT &
                                Pesetujuan
                                Atasan)</label>
                            <input class="form-control" id="formFile" type="file" name="file_dokumen" accept=".pdf">
                            <small class="form-text text-danger fst-italic">*Kosongkan jika tidak ingin
                                mengganti
                                file</small><br>
                            <small class="form-text text-danger fst-italic">*File harus dalam format PDF &
                                maksimal 1 MB</small>
                            <input class="form-control" id="idremb" name="idremb" type="hidden" placeholder="...."
                                readonly>
                            <br>
                            <div class="card-body mt-3">
                                <div class="form-group" id="pratinjauGambardok3"></div>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Ketika tombol View Dokumen BPKK Rembesment diklik
    $(document).on('click', '.view-dokumen', function() {
        var fileName = $(this).data('upload_file_cab'); // nama dokumen
        var jenisSaldo = $(this).data('jenis_saldo'); // jenis saldo

        // Elemen tempat preview
        var previewContainer = $('#pratinjauGambardok5');
        previewContainer.empty();

        // Jika file kosong/null
        if (!fileName || fileName === 'null' || fileName.trim() === '') {
            previewContainer.html(
                '<p class="text-center text-danger mt-3">Dokumen tidak tersedia.</p>');
            return;
        }

        // Path file
        var fileUrl = "<?= base_url('uploads/bpkk/'); ?>" + jenisSaldo + "/" + fileName;

        // Cek apakah file ada
        $.ajax({
            url: fileUrl,
            type: 'HEAD',
            success: function() {
                // Tampilkan pratinjau sesuai ekstensi
                var ext = fileName.split('.').pop().toLowerCase();
                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                    previewContainer.html(
                        `<img src="${fileUrl}" alt="Dokumen" class="img-fluid rounded shadow">`
                    );
                } else if (ext === 'pdf') {
                    previewContainer.html(
                        `<iframe src="${fileUrl}" width="100%" height="700px" style="border:none;"></iframe>`
                    );
                } else {
                    previewContainer.html(`
                        <p class="text-center text-muted">Tidak dapat menampilkan pratinjau untuk file ini.</p>
                        <a href="${fileUrl}" target="_blank" class="btn btn-primary btn-sm">Download Dokumen</a>
                    `);
                }
            },
            error: function() {
                previewContainer.html(
                    '<p class="text-center text-danger mt-3">File tidak ditemukan di server.</p>'
                );
            }
        });
    });
});

$(document).on('click', '.view-dokumen-pendukung', function() {

    var fileName = $(this).data('file'); // nama dokumen pendukung
    var idRemb = $(this).data('idrembes'); // ambil id petty cash
    var previewContainer = $('#pratinjauGambardok3');
    previewContainer.empty();

    // SET ID di input hidden
    $('#idremb').val(idRemb);

    // Jika tidak ada file
    if (!fileName || fileName === 'null' || fileName.trim() === '') {
        previewContainer.html('<p class="text-center text-danger mt-3">Dokumen tidak tersedia.</p>');
        return;
    }

    // Lokasi file
    var fileUrl = "<?= base_url('uploads/ppt/'); ?>" + fileName;

    // Cek apakah file ada
    $.ajax({
        url: fileUrl,
        type: 'HEAD',
        success: function() {
            var ext = fileName.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                previewContainer.html(`<img src="${fileUrl}" class="img-fluid rounded shadow">`);
            } else if (ext === 'pdf') {
                previewContainer.html(
                    `<iframe src="${fileUrl}" width="100%" height="700px" style="border:none;"></iframe>`
                );
            } else {
                previewContainer.html(`
                    <p class="text-center text-muted">Tidak dapat menampilkan pratinjau file ini.</p>
                    <a href="${fileUrl}" target="_blank" class="btn btn-primary btn-sm">Download Dokumen</a>
                `);
            }
        },
        error: function() {
            previewContainer.html(
                '<p class="text-center text-danger mt-3">File tidak ditemukan di server.</p>');
        }
    });
});
</script>