<style>
.dataTables_wrapper {
    padding-bottom: 20px !important;
}
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Saldo Petty Cash</h3>
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
                    <li class="breadcrumb-item active">Detail Saldo</li>
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
                            <h4 class="m-0">PETTY CASH</h4>
                            <a class="btn btn-primary btn-sm ms-3 d-flex align-items-center gap-1 <?= ($saldo_pettycash > 0) ? 'disabled' : '' ?>"
                                title="<?= ($saldo_pettycash > 0) ? 'Tidak bisa tambah saldo karena masih ada saldo' : 'Tambah Saldo Awal' ?>"
                                data-bs-toggle="modal" data-bs-target="#tambahsaldopettycash"
                                data-jenis="<?= $jenis_saldo ?>"
                                style="<?= ($saldo_pettycash > 0) ? 'pointer-events: none; opacity: 0.5;' : '' ?>">
                                <i data-feather="plus" style="width:14px; height:14px;"></i> Tambah Saldo
                            </a>
                        </div>
                        <div class="setting-menu">
                            <a class="btn btn-secondary btn-sm d-flex align-items-center gap-1"
                                href="<?= site_url('kelola_saldo') ?>" title="Kembali Ke Kelola Saldo">
                                <i data-feather="arrow-left" style="width:14px; height:14px;"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="220px"><strong>KANTOR</strong></td>
                                <td>: <strong><?php echo strtoupper($detail_saldo->nama_saldo) ?></strong></td>
                            </tr>
                            <tr>
                                <td><strong>SALDO PETTY CASH</strong></td>
                                <td>: <strong>Rp
                                        <?= number_format($detail_saldo->saldo_pettycash, 0, ',', '.') ?></strong></td>
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
                                    <th>Keterangan </th>
                                    <th>Status</th>
                                    <th></th>
                                    <th>Permintaan Saldo</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowdetailsaldocabang as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= date('d F Y', strtotime($data['tanggal'])); ?></td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['keterangan']; ?></p>
                                                </a><span
                                                    class="<?= $data['sumber'] === 'Permintaan' ? 'text-danger' : 'text-success' ?>"
                                                    style="font-size:12px;">
                                                    <?= $data['no_pettycash']; ?> / <?= $data['sumber']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (strtolower($data['status']) === 'waiting'): ?>
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                        <?php elseif (strtolower($data['status']) === 'done'): ?>
                                        <span class="badge bg-success">Done</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><?= ucfirst($data['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td></td>
                                    <td><?= 'Rp. ' . number_format($data['saldo'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <!-- Lihat -->
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Approve -->
                                            <?php if ($data['status'] === 'Waiting'): ?>
                                            <a href="<?= site_url('kelola_saldo/approve_saldo/' . $data['id_pettycash'] . '/' . $data['jenis_saldo']) ?>"
                                                class="btn btn-outline-success btn-sm proses_saldo_pettycash"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Proses">
                                                <i data-feather="check" style="width:12px; height:12px;"></i>
                                            </a>
                                            <?php endif; ?>

                                            <!-- view data -->
                                            <a href="#" class="btn btn-outline-info btn-sm view-saldorembesment"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-no-pettycash="<?= $data['no_pettycash']; ?>"
                                                data-no-pc-asal="<?= $data['no_pc_asal'] ?? ''; ?>"
                                                data-tanggal="<?= $data['tanggal']; ?>"
                                                data-keterangan="<?= $data['keterangan']; ?>"
                                                data-saldo="<?= $data['saldo']; ?>"
                                                data-status="<?= $data['status']; ?>"
                                                data-sumber="<?= $data['sumber']; ?>"
                                                data-file="<?= $data['file_dokumen']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#viewdatapermintaansaldorembesment">
                                                <i data-feather="eye" style="width:12px; height:12px"></i>
                                            </a>

                                            <!-- download -->
                                            <!-- <a href="#" class="btn btn-outline-secondary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Download">
                                                <i data-feather="download" style="width:12px; height:12px;"></i>
                                            </a> -->

                                            <!-- <a href="<?= base_url('uploads/BPKK/' . $data['upload_file_cab']) ?>"
                                                download class="btn btn-outline-secondary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Download">
                                                <i data-feather="download" style="width:12px; height:12px;"></i>
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

<!-- tambah saldo -->
<div class="modal fade" id="tambahsaldopettycash" tabindex="-1" role="dialog" aria-labelledby="tambahsaldopettycash"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">TAMBAH SALDO CABANG</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="<?= site_url('kelola_saldo/tambahsaldo') ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="no_pettycash-display"
                                            name="no_pettycash" placeholder="0000/PC-CABANG/MM/YYYY"
                                            value="<?= $no_petty_cash; ?>" readonly>
                                        <button class="btn btn-secondary" type="button" disabled>No BPKK</button>
                                    </div>

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="tanggal">Tanggal :</label>
                                    <input class="form-control" id="tanggal" name="tanggal" type="text"
                                        value="<?= date('d F Y'); ?>" placeholder="DD/MM/YYYY" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="keterangan">Keterangan Pengeluaran :</label>
                                    <input class="form-control" id="keterangan" name="keterangan" type="text"
                                        placeholder="Pengeluaran Kas Kecil Untuk ...." required>
                                    <input type="hidden" value="<?= $jenis_saldo ?>" id="jenis_saldo"
                                        name="jenis_saldo">
                                    <input type="hidden" value="<?= $id_saldo ?>" id="id_saldo" name="id_saldo">
                                    <input type="hidden" value="<?php echo ($detail_saldo->nama_saldo) ?>"
                                        id="kantorcabang" name="kantorcabang">
                                    <input type="hidden" value="<?php echo ($detail_saldo->sbu) ?>" id="sbucabang"
                                        name="sbucabang">
                                    <input type="hidden" value="<?php echo ($detail_saldo->saldo_debet) ?>"
                                        id="saldodebetcabang" name="saldodebetcabang">
                                    <input type="hidden" id="kode_kantocab" name="kode_kantocab" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="totalDebet">Total Kredit :</label>
                                    <input class="form-control" id="totalDebet" type="text"
                                        value="<?= number_format($saldo_cabang, 0, ',', '.') ?>" placeholder="Rp. 0"
                                        required oninput="formatRupiah(this); checkMaxSaldo();"
                                        data-max="<?= $saldo_cabang ?>" readonly>
                                    <input type="hidden" id="totalDebetRaw" name="total_debet"
                                        value="<?= $saldo_cabang ?>">
                                    <small id="saldoAlert" class="text-danger" style="display:none;"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung : (PV &
                                        Bukti Transfer)</label>
                                    <input class="form-control" id="formFile" type="file" name="file_dokumen"
                                        accept=".pdf" required>
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

<!-- Modal View Permintaan Saldo -->
<div class="modal fade" id="viewdatapermintaansaldorembesment" tabindex="-1" role="dialog"
    aria-labelledby="viewdatapermintaansaldorembesment" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Permintaan/Penambahan Saldo Petty Cash
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
                                    <td width="220px"><strong>NO PETTY CASH</strong></td>
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
                                    <td><strong>TOTAL PERMINTAAN SALDO</strong></td>
                                    <td>: </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="w-100">
                                <a id="btnDokumenPendukung" class="btn btn-outline-primary d-block w-100" type="button"
                                    title="Lihat" data-bs-toggle="modal" data-bs-target="#viewdokumenpendukungsaldo">
                                    Dokumen Pendukung
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p><strong>PENGELUARAN BPKK</strong></p>
                            </div>
                            <div class="table-responsive custom-scrollbar signal-table">
                                <table class="viewpermintaan-table table" id="viewpermintaan">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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

<!-- modal view Dokumen pendukung -->
<div class="modal fade" id="viewdokumenpendukungsaldo" tabindex="-1" role="dialog"
    aria-labelledby="viewdokumenpendukungsaldo" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Dokumen Pendukung
                </h3>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group" id="pratinjauGambardok2"></div>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function formatRupiah(el) {
    let number_string = el.value.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika ada ribuan
    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    // hasil akhir (tampilkan dengan "Rp.")
    el.value = 'Rp. ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);

    // simpan ke hidden input (angka murni, tanpa "Rp." dan titik)
    const rawValue = number_string.replace(/\./g, '');
    document.getElementById('totalDebetRaw').value = rawValue;
}

function checkMaxSaldo() {
    const totalDebetInput = document.getElementById('totalDebet');
    const rawValue = parseInt(document.getElementById('totalDebetRaw').value || 0);
    const maxSaldo = parseInt(totalDebetInput.getAttribute('data-max') || 0);
    const saldoAlert = document.getElementById('saldoAlert');
    const submitBtn = document.getElementById('submitBtn');

    if (rawValue > maxSaldo) {
        saldoAlert.style.display = 'block';
        saldoAlert.textContent =
            `Jumlah melebihi saldo cabang. Maksimal: Rp. ${maxSaldo.toLocaleString('id-ID')}`;
        submitBtn.disabled = true;
    } else {
        saldoAlert.style.display = 'none';
        submitBtn.disabled = false;
    }
}

// Supaya fungsi bisa dipanggil dari input HTML
window.checkMaxSaldo = checkMaxSaldo;

$(document).on('click', '.view-saldorembesment', function() {
    const data = $(this).data();
    const modal = $('#viewdatapermintaansaldorembesment');

    // === isi modal permintaan saldo ===
    modal.find('td:contains("NO PETTY CASH")').next().text(': ' + data.noPettycash);
    modal.find('td:contains("TANGGAL")').next().text(': ' + data.tanggal);
    modal.find('td:contains("KETERANGAN")').next().text(': ' + data.keterangan);
    modal.find('td:contains("TOTAL PERMINTAAN SALDO")').next().text(': Rp. ' + parseInt(data.saldo)
        .toLocaleString('id-ID'));

    const badge = modal.find('.badge');
    badge.text(data.status.toUpperCase())
        .removeClass('bg-warning bg-success bg-danger text-dark text-white');

    if (data.status.toLowerCase() === 'waiting') {
        badge.addClass('bg-warning text-dark fw-bold');
    } else if (data.status.toLowerCase() === 'done') {
        badge.addClass('bg-success text-white fw-bold');
    } else {
        badge.addClass('bg-secondary text-white');
    }

    // === Tentukan no_pettycash untuk BPKK ===
    let noForBpkk = data.noPettycash;
    if (data.sumber.toLowerCase() === 'penambahan') {
        if (data.noPcAsal && data.noPcAsal.trim() !== "") {
            noForBpkk = data.noPcAsal;
        } else {
            // kalau null, berarti penambahan awal
            noForBpkk = null;
        }
    }

    // === Tentukan folder dokumen ===
    let folder = "";
    if (data.sumber.toLowerCase() === "permintaan") {
        folder = "uploads/ppt/"; // ✅ pakai folder public
    } else if (data.sumber.toLowerCase() === "penambahan") {
        folder = "uploads/finance/"; // ✅ pakai folder public
    }

    // === Tampilkan dokumen di modal viewdokumenpendukungsaldo ===
    $('#viewdokumenpendukungsaldo').one('shown.bs.modal', function() {
        const preview = $('#pratinjauGambardok2');
        preview.empty();

        if (!data.file || !data.file.trim()) {
            preview.html(`<p style="color:red;font-weight:bold;text-align:center;">
                Dokumen Pendukung belum di-upload.</p>`);
        } else {
            let fileUrl = "<?= base_url(); ?>" + folder + data.file;
            // console.log("Preview dokumen:", fileUrl);

            let ext = data.file.split('.').pop().toLowerCase();
            let previewHtml = "";

            if (ext === "pdf") {
                previewHtml =
                    `<iframe src="${fileUrl}" width="100%" height="600px" style="border:0;"></iframe>`;
            } else if (["jpg", "jpeg", "png"].includes(ext)) {
                previewHtml = `<img src="${fileUrl}" class="img-fluid" alt="Dokumen">`;
            } else {
                previewHtml =
                    `<a href="${fileUrl}" target="_blank" class="btn btn-primary">Lihat Dokumen</a>`;
            }

            preview.html(previewHtml);
        }
    });

    // Bersihkan pratinjau saat modal dokumen ditutup
    $('#viewdokumenpendukungsaldo').on('hidden.bs.modal', () => {
        $('#pratinjauGambardok2').empty();
    });

    // === Ambil data BPKK ===
    if (noForBpkk) {
        $.ajax({
            url: '<?= site_url("kelola_saldo/get_data_bpkk_by_nopettycash") ?>',
            method: 'POST',
            data: {
                no_pettycash: noForBpkk
            },
            dataType: 'json',
            success: function(response) {
                let tbody = '';
                if (response.length > 0) {
                    $.each(response, function(i, row) {
                        tbody += `
                        <tr>
                            <td class="text-center">${i + 1}</td>
                            <td>${row.tanggal}</td>
                            <td>${row.keterangan}</td>
                            <td></td>
                            <td>${row.total}</td>
                            <td>
                                <span class="badge ${
                                    row.status === 'Approved' ? 'bg-success text-white' :
                                    row.status === 'In progress' ? 'bg-warning text-dark' :
                                    row.status === 'Rejected' ? 'bg-danger text-white' :
                                    'bg-secondary'
                                }">
                                    ${row.status}
                                </span>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody =
                        `<tr><td colspan="6" class="text-center text-muted">Tidak ada data pengeluaran BPKK.</td></tr>`;
                }
                modal.find('#viewpermintaan tbody').html(tbody);
            }
        });
    } else {
        // Kalau noForBpkk null (penambahan awal), tampilkan pesan kosong
        modal.find('#viewpermintaan tbody').html(
            `<tr><td colspan="6" class="text-center text-muted">Tidak ada data pengeluaran BPKK (Penambahan awal).</td></tr>`
        );
    }
});

const mapping = {
    "JKT": 1,
    "BPP": 2,
    "TBK": 3,
    "LU": 4,
    "PA_SB": 5,
    "PA_BBM": 6,
    "PA_RTK": 7
};

function updateKodeKantor() {
    const kodeInput = document.getElementById("kode_kantocab");
    const jenisSaldoEl = document.getElementById("jenis_saldo");

    if (jenisSaldoEl && kodeInput) {
        // buang spasi & uppercase
        const val = jenisSaldoEl.value.trim().toUpperCase();
        // console.log("Jenis Saldo (debug):", `"${val}"`);
        kodeInput.value = mapping[val] ?? "";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    updateKodeKantor();

    // kalau user edit manual field jenis_saldo
    const jenisSaldoEl = document.getElementById("jenis_saldo");
    if (jenisSaldoEl) {
        jenisSaldoEl.addEventListener("input", updateKodeKantor);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('formFile');
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
                    confirmButtonColor: '#d33'
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
                    confirmButtonColor: '#d33'
                });
                this.value = ''; // reset input
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        }
    });
});
</script>