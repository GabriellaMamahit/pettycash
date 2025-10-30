<style>
.dataTables_wrapper {
    padding-bottom: 20px !important;
}

/* Wrapper untuk checkbox */
.custom-checkbox {
    position: relative;
    display: inline-block;
    width: 15px;
    height: 15px;
}

.custom-checkbox input[type="checkbox"] {
    opacity: 0;
    /* Sembunyikan bawaan */
    position: absolute;
    cursor: pointer;
    width: 0;
    height: 0;
}

.custom-checkbox .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 15px;
    width: 15px;
    background-color: #f1f1f1;
    border: 2px solid #ccc;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
}

.custom-checkbox input:checked~.checkmark {
    background-color: #376464;
    border-color: #376464;
}

.custom-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.custom-checkbox input:checked~.checkmark:after {
    display: block;
}

.custom-checkbox .checkmark:after {
    left: 5px;
    top: 1px;
    width: 4px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Approve Reimbursement</h3>
            </div>
            <div class="col-5 d-none d-xl-block"></div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a>
                    </li>
                    <li class="breadcrumb-item">Finance</li>
                    <li class="breadcrumb-item">Kelola Saldo</li>
                    <li class="breadcrumb-item">Detail Saldo</li>
                    <li class="breadcrumb-item active">Approve Reimbursement</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- === Main Content === -->
<div class="container-fluid default-dashboard2">
    <div class="row">
        <div class="w-100 mb-3">
            <?php
            $status = $detail_permintaansaldo->status_permintaan;
            $badgeClass = 'bg-warning text-dark'; // default

            if (strtolower($status) === 'done') {
                $badgeClass = 'bg-success text-white';
            } elseif (strtolower($status) === 'waiting') {
                $badgeClass = 'bg-warning text-dark';
            }
            ?>
            <span class="badge <?= $badgeClass ?> d-block w-100 text-center" style="font-size: 14px;">
                <strong><?= htmlspecialchars($status) ?></strong>
            </span>
        </div>
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="m-0">PETTY CASH</h4>
                            <?php
                            // Default: semua dianggap approved
                            $semuaApproved = true;
                            foreach ($rowbpkkrembes as $d) {
                                if ($d['status_cab'] !== 'Approved') {
                                    $semuaApproved = false;
                                    break;
                                }
                            }
                            ?>
                            <a class="btn btn-primary btn-sm ms-3 d-flex align-items-center gap-1 <?= $semuaApproved ? '' : 'disabled'; ?>"
                                title=""
                                <?= $semuaApproved ? 'data-bs-toggle="modal" data-bs-target="#tambahsaldopettycash"' : 'onclick="return false;"'; ?>>
                                <i data-feather="plus" style="width:14px; height:14px;"></i>
                                Tambah Saldo
                            </a>
                        </div>
                        <div class="setting-menu">
                            <a class="btn btn-secondary btn-sm d-flex align-items-center gap-1"
                                href="<?= site_url('kelola_saldo/detail_saldo/' . $id_saldo . '/' . $jenis_saldo) ?>"
                                title="Kembali Ke Kelola Saldo">
                                <i data-feather="arrow-left" style="width:14px; height:14px;"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="250px"><strong>NO PETTY CASH</strong></td>
                                <td>: <strong> <?php echo strtoupper($detail_permintaansaldo->no_pettycash) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TANGGAL REIMBURSEMENT</strong></td>
                                <td>: <strong>
                                        <?= date('F Y', strtotime($detail_permintaansaldo->tanggal_pettycash)) ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td><strong>KETERANGAN</strong></td>
                                <td>: <strong><?php echo strtoupper($detail_permintaansaldo->ket_pettycash) ?>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL REIMBURSEMENT</strong></td>
                                <td>: <strong>
                                        Rp <?= number_format($detail_permintaansaldo->saldo_pettycash, 0, ',', '.') ?>
                                    </strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Petty Cash Jakarta</h4>
                        <div>
                            <a href="#" id="buttonapprovecentang"
                                class="btn btn-outline-success btn-sm approve_all_bpkk"
                                style="width:30px; height:30px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                title="Approve Semua">
                                <i data-feather="check-square" style="width:16px; height:16px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center" data-orderable="false">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" id="checkAll">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th class="text-center">No.</th>
                                    <!-- <th>Tanggal</th> -->
                                    <th>Keterangan </th>
                                    <th>Total Pengeluaran</th>
                                    <th></th>
                                    <th>Status</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowbpkkrembes as $data) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if ($data['status_cab'] === 'In progress' || $data['status_cab'] === 'Rejected' || $data['status_cab'] === 'Revisi'): ?>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" class="checkItem"
                                                value="<?= $data['no_bpkk_cab']; ?>">
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <!-- <td><?= date('d F Y', strtotime($data['tgl_kredit_cab'])); ?></td> -->
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['ket_bpkk_cab']; ?></p>
                                                </a><span style="font-size:12px;">
                                                    <?= $data['no_bpkk_cab']; ?> |
                                                    <?= date('d F Y', strtotime($data['tgl_kredit_cab'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.'); ?></td>
                                    <td>

                                    </td>
                                    <td>
                                        <?php if ($data['status_cab'] === 'In progress'): ?>
                                        <span class="badge bg-warning text-dark">In progress</span>
                                        <?php elseif ($data['status_cab'] === 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                        <?php elseif ($data['status_cab'] === 'Rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span>
                                        <?php elseif ($data['status_cab'] === 'Revisi'): ?>
                                        <span class="badge bg-info">Revisi</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><?= ucfirst($data['status_cab']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Lihat -->
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
                                            <a href="#" class="btn btn-outline-info btn-sm viewbpkkrembes"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-bs-toggle="modal" data-bs-target="#viewbpkkrembes"
                                                data-no-bpkk="<?= $data['no_bpkk_cab']; ?>"
                                                data-tgglbpkk="<?= $data['tgl_kredit_cab']; ?>"
                                                data-ketbpkk="<?= $data['ket_bpkk_cab']; ?>"
                                                data-totalbpkk="<?= $data['total_kredit_cab']; ?>"
                                                data-filebpkk="<?= $data['upload_file_cab']; ?>"
                                                data-statusbpkk="<?= $data['status_cab']; ?>"
                                                data-jenis_saldo="<?= $data['jenis_saldo']; ?>">
                                                <i data-feather="eye" style="width:12px; height:12px;"></i>
                                            </a>
                                            <!-- Approve -->
                                            <?php if ($data['status_cab'] === 'In progress' || $data['status_cab'] === 'Rejected' || $data['status_cab'] === 'Revisi'): ?>
                                            <a href="" class="btn btn-outline-success btn-sm proses_saldo_pettycash"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Proses" data-no-bpkk="<?= $data['no_bpkk_cab']; ?>"
                                                data-status="Approved">
                                                <i data-feather="check" style="width:12px; height:12px;"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php if ($data['status_cab'] === 'In progress' || $data['status_cab'] === 'Revisi'): ?>
                                            <a href="" class="btn btn-outline-danger btn-sm reject_saldo_pettycash"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Reject" data-no-bpkk="<?= $data['no_bpkk_cab']; ?>"
                                                data-jenis_saldo="<?= $data['jenis_saldo']; ?>" data-status="Rejected">
                                                <i data-feather="x" style="width:12px; height:12px;"></i>
                                            </a>
                                            <?php endif; ?>
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


<!-- Modal Approve Proses Permintaan Saldo -->
<div class="modal fade" id="viewbpkkrembes" tabindex="-1" role="dialog" aria-labelledby="viewbpkkrembes"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Permintaan Penambahan Saldo Petty Cash
                </h3>
                <div class="modal-body">
                    <div class="w-100">
                        <span class="badge bg-warning d-block w-100 text-dark text-center"
                            style="font-size: 14px;"></span>
                    </div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="220px"><strong>NO BPKK</strong></td>
                                    <td>: <span></span></td>
                                </tr>
                                <tr>
                                    <td><strong>TANGGAL</strong></td>
                                    <td>: <span></span></td>
                                </tr>
                                <tr>
                                    <td><strong>KETERANGAN</strong></td>
                                    <td>: <span></span></td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL PENGELUARAN BPKK</strong></td>
                                    <td>: <span></span></td>
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

<!-- tambah saldo -->
<div class="modal fade" id="tambahsaldopettycash" tabindex="-1" role="dialog" aria-labelledby="tambahsaldopettycash"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">TAMBAH SALDO CABANG</h3>
                <div class="modal-body">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="250px"><strong>NO PETTY CASH</strong></td>
                                    <td>: <strong>
                                            <?php echo strtoupper($detail_permintaansaldo->no_pettycash) ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>TANGGAL REIMBURSEMENT</strong></td>
                                    <td>: <strong>
                                            <?= date('d F Y', strtotime($detail_permintaansaldo->tanggal_pettycash)) ?>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td><strong>KETERANGAN</strong></td>
                                    <td>: <strong><?php echo strtoupper($detail_permintaansaldo->ket_pettycash) ?>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL REIMBURSEMENT</strong></td>
                                    <td>: <strong>
                                            Rp
                                            <?= number_format($detail_permintaansaldo->saldo_pettycash, 0, ',', '.') ?>
                                        </strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form class="row g-3 needs-validation" action="<?= site_url('kelola_saldo/tambahsaldorembes') ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="no_petty_cash-display"
                                            name="no_petty_cash" placeholder="0000/PC-CABANG/MM/YYYY"
                                            value="<?= $no_petty_cash; ?>" readonly>
                                        <button class="btn btn-secondary" type="button" disabled>No BPKK</button>
                                    </div>

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="tanggal_saldo">Tanggal Penambahan Saldo
                                        :</label>
                                    <input class="form-control" id="tanggal_saldo" name="tanggal_saldo" type="text"
                                        value="<?= date('d F Y'); ?>" placeholder="DD/MM/YYYY" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="keterangan_saldo">Keterangan Penambahan
                                        Saldo
                                        :</label>
                                    <input class="form-control" id="keterangan_saldo" name="keterangan_saldo"
                                        type="text"
                                        value="<?php echo 'Penambahan Saldo ' . ucwords($detail_permintaansaldo->kantor_cab); ?>"
                                        placeholder="Pengeluaran Kas Kecil Untuk ...." readonly>
                                    <input class="form-control" id="id_pettycash_saldo" name="id_pettycash_saldo"
                                        type="hidden" value="<?php echo ($detail_permintaansaldo->id_pettycash); ?>"
                                        placeholder="Pengeluaran Kas Kecil Untuk ...." readonly>
                                    <input type="hidden" value="<?= $jenis_saldo ?>" id="jenis_saldo_saldo"
                                        name="jenis_saldo_saldo">
                                    <input type="hidden" value="<?= $id_saldo ?>" id="id_saldo_remb"
                                        name="id_saldo_remb">
                                    <input type="hidden"
                                        value="<?php echo ucwords($detail_permintaansaldo->kantor_cab); ?>"
                                        id="kantorcabang_saldo" name="kantorcabang_saldo">
                                    <input type="hidden"
                                        value="<?php echo ($detail_permintaansaldo->direktorat_pettycash) ?>"
                                        id="sbucabang_saldo" name="sbucabang_saldo">
                                    <input type="hidden" value="<?php echo ($detail_permintaansaldo->no_pettycash) ?>"
                                        id="nopettycash_asal" name="nopettycash_asal">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="totalDebet_saldo">Total Penambahan Saldo
                                        :</label>
                                    <input class="form-control" id="totalDebet_saldo" type="text"
                                        value="<?php echo 'Rp. ' . number_format($detail_permintaansaldo->saldo_pettycash, 0, ',', '.'); ?>"
                                        placeholder="Rp. 0" readonly>
                                    <input type="hidden" id="totalDebetRaw_saldo" name="totalDebetRaw_saldo"
                                        value="<?php echo ($detail_permintaansaldo->saldo_pettycash) ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="file_dokumen_saldo">Upload Dokumen Pendukung
                                        : (PV & Bukti Transfer)</label>
                                    <input class="form-control" id="file_dokumen_saldo" type="file"
                                        name="file_dokumen_saldo" accept=".pdf" required>
                                    <small class="form-text text-danger fst-italic">*File harus dalam format PDF &
                                        maksimal 1 MB</small>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                                <button class="btn btn-primary" type="submit" id="submitBtn">Simpan</button>
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
$(document).on('click', '.viewbpkkrembes', function() {
    const noBpkk = $(this).data('no-bpkk');
    const tanggalBpkk = $(this).data('tgglbpkk');
    const keteranganBpkk = $(this).data('ketbpkk');
    const pengeluaranBpkk = $(this).data('totalbpkk');
    const statusBpkk = $(this).data('statusbpkk');
    const fileBpkk = $(this).data('filebpkk');
    const jenisSaldo = $(this).data('jenis_saldo');

    // Isi info permintaan saldo
    const modal = $('#viewbpkkrembes');
    modal.find('td:contains("NO BPKK")').next().text(': ' + noBpkk);
    modal.find('td:contains("TANGGAL")').next().text(': ' + tanggalBpkk);
    modal.find('td:contains("KETERANGAN")').next().text(': ' + keteranganBpkk);
    modal.find('td:contains("TOTAL PENGELUARAN BPKK")').next().text(': Rp. ' + parseInt(pengeluaranBpkk)
        .toLocaleString(
            'id-ID'));

    const badge = modal.find('.badge');
    badge.text(statusBpkk.toUpperCase()).removeClass('bg-warning bg-success bg-danger text-dark text-white');

    if (statusBpkk.toLowerCase() === 'in progress') {
        badge.addClass('bg-warning text-dark fw-bold');
    } else if (statusBpkk.toLowerCase() === 'approved') {
        badge.addClass('bg-success text-white fw-bold');
    } else if (statusBpkk.toLowerCase() === 'revisi') {
        badge.addClass('bg-info text-white fw-bold');
    } else {
        badge.addClass('bg-secondary text-white');
    }

    if (fileBpkk && fileBpkk !== 'undefined' && fileBpkk !== 'null') {
        const lokasiDokumen = '<?= base_url("uploads/BPKK/") ?>' + jenisSaldo + '/' + fileBpkk;

        $('#pratinjauGambar2').html(`
        <p style="font-weight: bold;">Dokumen: ${fileBpkk}</p>
        <iframe src="${lokasiDokumen}" width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
    `);
    } else {
        $('#pratinjauGambar2').html(`
        <p class="text-danger">Dokumen tidak tersedia.</p>
    `);
    }
});

$(document).on('click', '.proses_saldo_pettycash', function(e) {
    e.preventDefault();

    let no_bpkk = $(this).data('no-bpkk');
    let status = $(this).data('status');

    Swal.fire({
        title: `${status} Bukti Pengeluaran Kecil?`,
        text: "Apakah kamu yakin ingin melanjutkan?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: "#376464",
        cancelButtonColor: "#c06240",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('Kelola_saldo/update_status_bpkk'); ?>",
                type: "POST",
                data: {
                    no_bpkk: no_bpkk,
                    status: status
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status berhasil diubah',
                            confirmButtonColor: "#376464"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mengubah status'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan server'
                    });
                }
            });
        }
    });
});

$(document).on('click', '.reject_saldo_pettycash', function(e) {
    e.preventDefault();

    let no_bpkk = $(this).data('no-bpkk');
    let jenis_saldo = $(this).data('jenis_saldo');
    let status = $(this).data('status');

    Swal.fire({
        title: 'Alasan Reject',
        input: 'textarea',
        inputLabel: 'Tuliskan alasan kenapa ingin menolak BPKK ini:',
        inputPlaceholder: 'Masukkan alasan di sini...',
        inputAttributes: {
            'aria-label': 'Masukkan alasan di sini'
        },
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal',
        confirmButtonColor: "#376464",
        cancelButtonColor: "#c06240",
        reverseButtons: true,
        preConfirm: (alasan) => {
            if (!alasan) {
                Swal.showValidationMessage('Alasan tidak boleh kosong!');
            }
            return alasan;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('Kelola_saldo/update_status_bpkk_rejected'); ?>",
                type: "POST",
                data: {
                    no_bpkk: no_bpkk,
                    jenis_saldo: jenis_saldo,
                    status: status,
                    alasan: result.value
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status berhasil diubah dan alasan tersimpan',
                            confirmButtonColor: "#376464"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mengubah status'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan server'
                    });
                }
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const checkAll = document.getElementById("checkAll");
    const checkItems = document.querySelectorAll(".checkItem");
    const btnApprove = document.getElementById("buttonapprovecentang");

    function disableApproveButton() {
        btnApprove.classList.add("disabled");
        btnApprove.style.pointerEvents = "none";
        btnApprove.style.opacity = "0.5";
    }

    function enableApproveButton() {
        btnApprove.classList.remove("disabled");
        btnApprove.style.pointerEvents = "auto";
        btnApprove.style.opacity = "1";
    }

    function updateButtonState() {
        const anyChecked = document.querySelectorAll(".checkItem:checked").length > 0;
        if (anyChecked) {
            enableApproveButton();
        } else {
            disableApproveButton();
        }
    }

    // Event untuk checkbox "check all"
    checkAll.addEventListener("change", function() {
        checkItems.forEach(item => {
            item.checked = checkAll.checked;
        });
        updateButtonState();
    });

    // Event untuk setiap checkbox item
    checkItems.forEach(item => {
        item.addEventListener("change", function() {
            const allChecked = document.querySelectorAll(".checkItem:checked").length ===
                checkItems.length;
            checkAll.checked = allChecked;
            updateButtonState();
        });
    });

    // Klik tombol approve semua
    btnApprove.addEventListener("click", function(e) {
        e.preventDefault();

        const selectedItems = document.querySelectorAll(".checkItem:checked");
        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Tidak ada data yang dipilih!'
            });
            return;
        }

        Swal.fire({
            title: `Approve ${selectedItems.length} data yang dipilih?`,
            text: "Apakah kamu yakin ingin melanjutkan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Approve',
            cancelButtonText: 'Batal',
            confirmButtonColor: "#376464",
            cancelButtonColor: "#c06240",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let processed = 0;

                selectedItems.forEach(item => {
                    const no_bpkk = item.value;

                    $.ajax({
                        url: "<?= base_url('Kelola_saldo/update_status_bpkk'); ?>",
                        type: "POST",
                        data: {
                            no_bpkk: no_bpkk,
                            status: "Approved"
                        },
                        dataType: "json",
                        // success: function(res) {
                        //     console.log(`BPKK ${no_bpkk} -> ${res.status}`);
                        // },
                        // error: function() {
                        //     console.error(`BPKK ${no_bpkk} -> ERROR`);
                        // },
                        complete: function() {
                            processed++;
                            if (processed === selectedItems.length) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Semua data berhasil diproses.',
                                    confirmButtonColor: "#376464",
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                });
            }
        });
    });


    // Set awal (disable tombol)
    disableApproveButton();
});

document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('file_dokumen_saldo');
    const submitBtn = document.getElementById('submitBtn');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = 1 * 1024 * 1024; // 1 MB
            const fileName = file.name.toLowerCase();
            const isPDF = fileName.endsWith('.pdf');

            if (!isPDF) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Salah!',
                    text: 'File harus dalam format PDF.',
                    confirmButtonColor: '#c06240'
                });
                this.value = ''; // reset input
                submitBtn.disabled = true;
                return;
            }

            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar!',
                    text: 'Maksimal ukuran file adalah 1 MB.',
                    confirmButtonColor: '#c06240'
                });
                this.value = ''; // reset input
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        }
    });
});

$(document).ready(function() {
    $('.proses_saldo_pettycash').each(function(index) {
        let $button = $(this);
        let currentRow = $(this).closest('tr');
        let prevRow = currentRow.prev('tr');

        // Kalau bukan baris pertama, periksa status baris sebelumnya
        if (index > 0 && prevRow.length) {
            let prevStatus = prevRow.find('td:nth-child(6) .badge').text().trim();

            // Kalau sebelumnya belum "Approved", disable tombol
            if (prevStatus !== 'Approved') {
                $button.addClass('disabled')
                    .css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    })
                    .attr('title', 'Tunggu data sebelumnya di-approve');
            }
        }
    });
});
</script>