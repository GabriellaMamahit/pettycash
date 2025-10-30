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
} */

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 20px !important;
    }

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
                <h3>Bukti Pengeluaran Kas Kecil <?= $this->fungsi->user_login()->address_user; ?></h3>
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
                    <li class="breadcrumb-item active">Bukti Pengeluaran Kas Kecil</li>
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
                        <h4>Daftar Bukti Pengeluaran Kas Kecil</h4>
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
                                    <th>Tanggal</th>
                                    <th>Keterangan </th>
                                    <th></th>
                                    <th>Total Kredit</th>
                                    <th>Status</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowbpkk as $data) { ?>
                                    <tr <?= $data['status_bpkk'] == "Open" ? "class='table-danger'" : "" ?>>
                                        <td class="text-center">
                                            <?php if ($data['status_bpkk'] === 'Open' && $data['status_cab'] === 'In progress'): ?>
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="checkItem"
                                                        value="<?= $data['id_bpkk_cab']; ?>">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= $no++ ?>.</td>
                                        <td><?= date('d/m/Y', strtotime($data['tgl_kredit_cab'])); ?></td>
                                        <!-- <td><?= $data['ket_bpkk_cab']; ?></td> -->
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
                                        <!-- <td>
                                        <?php if ($data['status_cab'] == 'In progress') : ?>
                                        <span class="badge badge-warning text-dark">In progress</span>
                                        <?php elseif ($data['status_cab'] == 'Rejected') : ?>
                                        <span class="badge badge-danger">Rejected</span>
                                        <?php if (!empty($data['ket_notifikasi'])): ?>
                                        <br><small class="text-danger"><?= $data['ket_notifikasi']; ?></small>
                                        <?php endif; ?>
                                        <?php elseif ($data['status_cab'] == 'Approved') : ?>
                                        <span class="badge badge-success">Approved</span>
                                        <?php else : ?>
                                        <span class="badge badge-secondary"><?= ucfirst($data['status_cab']); ?></span>
                                        <?php endif; ?>
                                    </td> -->
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
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1 mb-1">
                                                <!-- Lihat -->
                                                <a href="#" class="btn btn-outline-info btn-sm"
                                                    style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                    title="Lihat" data-tanggalbpkk="<?= $data['tgl_kredit_cab']; ?>"
                                                    data-keteranganbpkk="<?= $data['ket_bpkk_cab']; ?>"
                                                    data-pengeluaran-bpkk="Rp. <?= number_format($data['total_kredit_cab'], 0, ',', '.'); ?>"
                                                    data-nobpkk="<?= $data['no_bpkk_cab']; ?>"
                                                    data-file="<?= $data['upload_file_cab']; ?>"
                                                    data-status="<?= $data['status_cab']; ?>"
                                                    data-jenissaldo="<?= $data['jenis_saldo']; ?>" data-bs-toggle="modal"
                                                    data-bs-target="#viewdatabpkk">
                                                    <i data-feather="eye" style="width:12px; height:12px;"></i>
                                                </a>
                                                <?php if ($data['status_bpkk'] === 'Open'): ?>
                                                    <!-- Edit -->
                                                    <a href="#" class="btn btn-outline-secondary btn-sm edit-databpkk"
                                                        style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                        title="Edit" data-idbpkk="<?= $data['id_bpkk_cab']; ?>"
                                                        data-nobpkk="<?= $data['no_bpkk_cab']; ?>"
                                                        data-ketbpkk="<?= $data['ket_bpkk_cab']; ?>"
                                                        data-jenissaldo="<?= $data['jenis_saldo']; ?>"
                                                        data-pc-rembesment="<?= $data['no_pc_saldo']; ?>"
                                                        data-pettycashnumber="<?= $data['no_pettycash']; ?>"
                                                        data-totalbpkk="<?= $data['total_kredit_cab']; ?>"
                                                        data-saldo="<?= $data['saldo_pettycash'] ?? 0; ?>"
                                                        data-filebpkk="<?= $data['upload_file_cab']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#editdatabpkk">
                                                        <i data-feather="edit" style="width:12px; height:12px;"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <!-- Hapus -->
                                                <!-- <a href="#" class="btn btn-outline-danger btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Hapus">
                                                <i data-feather="trash-2" style="width:12px; height:12px;"></i>
                                            </a> -->
                                            </div>
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- <a href="#" class="btn btn-outline-primary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Print">
                                                <i data-feather="printer" style="width:12px; height:12px;"></i>
                                            </a> -->
                                                <?php if ($data['status_bpkk'] === 'Open' && $data['status_cab'] === 'In progress'): ?>
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        style="height:20px; padding:2px 4px; font-size:10px; display:flex; align-items:center; justify-content:center;"
                                                        title="Submit BPKK" data-id_bpkk="<?= $data['id_bpkk_cab']; ?>"
                                                        data-statusbpkk="<?= $data['status_bpkk']; ?>" id="btn-proses">
                                                        <i data-feather="refresh-cw" class="me-1"
                                                            style="width:12px; height:12px;"></i>
                                                        Submit
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($data['status_bpkk'] === 'Open' && $data['status_cab'] === 'Rejected'): ?>
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        style="height:20px; padding:2px 4px; font-size:10px; display:flex; align-items:center; justify-content:center;"
                                                        title="Submit BPKK" data-id_bpkk="<?= $data['id_bpkk_cab']; ?>"
                                                        data-jenis_saldo="<?= $data['jenis_saldo']; ?>"
                                                        data-no_pettycash="<?= $data['no_bpkk_cab']; ?>"
                                                        data-statusbpkk="<?= $data['status_bpkk']; ?>" id="btn-prosesrerjected">
                                                        <i data-feather="refresh-cw" class="me-1"
                                                            style="width:12px; height:12px;"></i>
                                                        Submit
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

<!-- modal edit data bukti pengeluaran kas kecil -->
<div class="modal fade" id="editdatabpkk" tabindex="-1" role="dialog" aria-labelledby="editdatabpkk" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">EDIT DATA PENGELUARAN KAS KECIL</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation"
                        action="<?= site_url('bukti_pengeluaran_kas_kecil/editpengeluaranbpkk') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="no-permintaan_bpkk-display"
                                            name="no_permintaan_bpkk" placeholder="BPKK-SBU/0000/MM/YYYY" readonly>
                                        <button class="btn btn-secondary" type="button" disabled>No BPKK</button>
                                    </div>

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="keteranganpermintaanbpkk">Keterangan
                                        Pengeluaran :</label>
                                    <input class="form-control" id="keteranganpermintaanbpkk"
                                        name="keteranganpermintaanbpkk" type="text"
                                        placeholder="Pengeluaran Kas Kecil Untuk ....">
                                    <input class="form-control" id="idbpkk" name="idbpkk" type="hidden"
                                        placeholder="...." readonly>
                                    <input class="form-control" id="jenissaldobpkk" name="jenissaldobpkk" type="hidden"
                                        placeholder="...." readonly>
                                    <input class="form-control" id="no_pc_rembes" name="no_pc_rembes" type="hidden"
                                        placeholder="...." readonly>
                                    <input class="form-control" id="nopettycash" name="nopettycash" type="hidden"
                                        placeholder="...." readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="edit-totalDebet">Total Kredit :</label>
                                    <input class="form-control" id="edit-totalDebet" name="totalDebet" type="text"
                                        placeholder="Rp. 0" oninput="formatRupiah(this); checkSaldoCukup();">
                                    <input type="hidden" id="edit-totalDebetRaw" name="total_debet">
                                    <input type="hidden" id="edit-totalDebetOld" value="">
                                    <small id="saldo-warning" class="mt-2 text-danger" style="display:none;"></small>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung :</label>
                                    <input class="form-control" id="formFile" type="file" name="file_dokumen"
                                        accept=".pdf">
                                    <small class="form-text text-muted fst-italic">*File harus dalam format PDF</small>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung :
                                        (Bukti Pengeluaran - Kwitansi)</label>
                                    <input class="form-control" id="formFile" type="file" name="file_dokumen"
                                        accept=".pdf">
                                    <small class="form-text text-danger fst-italic">*Kosongkan jika tidak ingin
                                        mengganti
                                        file</small><br>
                                    <small class="form-text text-danger fst-italic">*File harus dalam format PDF &
                                        maksimal 1 MB</small>
                                    <br>
                                    <div class="form-group mt-2" id="pratinjauGambar3"></div>
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

<!-- modal view data bpkk -->
<div class="modal fade" id="viewdatabpkk" tabindex="-1" role="dialog" aria-labelledby="viewdatabpkk" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Bukti Pengeluaran Kas Kecil
                </h3>
                <div class="modal-body">
                    <div style="margin:0 -1rem; padding:0;">
                        <!-- minus margin untuk hilangkan padding modal -->
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
                                    <td><strong>TOTAL PENGELUARAN BPKK</strong></td>
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
    // === VIEW DATA BPKK ===
    $(document).on('click', '[data-bs-target="#viewdatabpkk"]', function() {
        const modal = $('#viewdatabpkk');
        const statusBadge = modal.find('.badge');

        const data = {
            noBpkk: $(this).data('nobpkk') || '-',
            tanggal: $(this).data('tanggalbpkk') || '-',
            keterangan: $(this).data('keteranganbpkk') || '-',
            total: $(this).data('pengeluaran-bpkk') || '0',
            status: $(this).data('status') || '',
            file: $(this).data('file') || '',
            jenisSaldo: $(this).data('jenissaldo') || ''
        };

        const infoFields = {
            'NO BPKK': data.noBpkk,
            'TANGGAL': data.tanggal,
            'KETERANGAN': data.keterangan,
            'TOTAL PENGELUARAN BPKK': data.total
        };

        modal.find('td').each(function() {
            const label = $(this).text().trim();
            if (infoFields[label] !== undefined) $(this).next().text(': ' + infoFields[label]);
        });

        // Badge status
        statusBadge.removeClass()
            .addClass('badge fw-bold text-uppercase d-block text-center')
            .addClass(
                data.status === 'In progress' ? 'bg-secondary text-white' :
                data.status === 'Rejected' ? 'bg-danger text-white' :
                data.status === 'Approved' ? 'bg-success text-white' :
                data.status === 'Revisi' ? 'bg-info text-white' :
                'bg-warning text-dark'
            )
            .text(data.status || 'N/A');

        // Hapus preview dulu
        const preview = $('#pratinjauGambar2');
        preview.empty();

        // Tambahkan iframe setelah modal benar-benar terbuka
        modal.one('shown.bs.modal', function() {
            if (!data.file.trim()) {
                preview.html(`<p style="color:red;font-weight:bold;text-align:center;">
                Dokumen Pendukung belum di-upload.</p>`);
            } else {
                let fileUrl = "<?= base_url('uploads/BPKK/') ?>" + data.jenisSaldo + "/" + data.file;
                preview.html(`
                <p style="font-weight:bold;text-align:center;">Dokumen: ${data.file}</p>
                <iframe src="${fileUrl}" width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
            `);
            }
        });
    });

    $('#viewdatabpkk').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());

    // button proses
    $(document).on('click', '#btn-proses', function(e) {
        e.preventDefault();
        const id = $(this).data('id_bpkk');
        const status = $(this).data('statusbpkk');

        if (!id) {
            Swal.fire({
                icon: 'error',
                title: 'ID tidak ditemukan',
                text: 'ID BPKK tidak ditemukan'
            });
            return;
        }

        Swal.fire({
            title: 'Apakah Anda yakin ingin memproses data ini?',
            text: "Data ini akan di submit dan tidak bisa di edit",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, submit',
            cancelButtonText: 'Batal',
            confirmButtonColor: "#376464",
            cancelButtonColor: "#c06240",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= site_url("bukti_pengeluaran_kas_kecil/proses_bpkk") ?>', {
                        id_bpkk: id,
                        status: status
                    })
                    .done(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: "#376464"
                        }).then(() => location.reload());
                    })
                    .fail(xhr => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memproses: ' + xhr.responseText
                        });
                    });
            }
        });
    });

    // button proses
    $(document).on('click', '#btn-prosesrerjected', function(e) {
        e.preventDefault();
        const id = $(this).data('id_bpkk');
        const status = $(this).data('statusbpkk');
        const jenis_saldo = $(this).data('jenis_saldo');
        const no_pettycash = $(this).data('no_pettycash');
        if (!id) {
            Swal.fire({
                icon: 'error',
                title: 'ID tidak ditemukan',
                text: 'ID BPKK tidak ditemukan'
            });
            return;
        }
        Swal.fire({
            title: 'Apakah Anda yakin ingin memproses data ini?',
            text: "Data ini akan di submit dan tidak bisa di edit",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, submit',
            cancelButtonText: 'Batal',
            confirmButtonColor: "#376464",
            cancelButtonColor: "#c06240",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= site_url("bukti_pengeluaran_kas_kecil/proses_bpkk_rejected") ?>', {
                        id_bpkk: id,
                        status: status,
                        jenis_saldo: jenis_saldo,
                        no_pettycash: no_pettycash
                    })
                    .done(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            confirmButtonColor: "#376464"
                        }).then(() => location.reload());
                    })
                    .fail(xhr => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memproses: ' + xhr.responseText
                        });
                    });
            }
        });
    });

    // === EDIT DATA BPKK ===
    $(document).on('click', '.edit-databpkk', function() {
        const modal = $("#editdatabpkk");
        const saldo = parseInt($(this).data('saldo')) || 0;
        const total = parseInt($(this).data('totalbpkk')) || 0;

        modal.find("#idbpkk").val($(this).data('idbpkk'));
        modal.find("#no-permintaan_bpkk-display").val($(this).data('nobpkk'));
        modal.find("#jenissaldobpkk").val($(this).data('jenissaldo'));
        modal.find("#no_pc_rembes").val($(this).data('pc-rembesment'));
        modal.find("#nopettycash").val($(this).data('pettycashnumber'));
        modal.find("#keteranganpermintaanbpkk").val($(this).data('ketbpkk'));

        modal.find("#edit-totalDebet").val(formatRupiahText(total)).attr('data-saldo', saldo);
        modal.find("#edit-totalDebetRaw").val(total);
        modal.find("#edit-totalDebetOld").val(total);

        const fileName = $(this).data('filebpkk');
        const jenisSaldo = $(this).data('jenissaldo');
        const previewArea = modal.find("#pratinjauGambar3");
        previewArea.empty();

        modal.one('shown.bs.modal', function() {
            if (fileName) {
                const fileUrl = "<?= base_url('uploads/BPKK/') ?>" + jenisSaldo + "/" + fileName;
                previewArea.html(`
                <p style="font-weight:bold;text-align:center;">
                    File lama: <a href="${fileUrl}" target="_blank">${fileName}</a>
                </p>
                <iframe src="${fileUrl}" width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
            `);
            } else {
                previewArea.html(`<p style="color:red;font-weight:bold;text-align:center;">
                Dokumen Pendukung belum di-upload.
            </p>`);
            }

            // Panggil fungsi cek saldo, pastikan sudah didefinisikan sebelumnya
            if (typeof checkSaldoCukup === 'function') {
                checkSaldoCukup();
            } else {
                console.warn('checkSaldoCukup() belum didefinisikan');
            }
        });
    });


    function checkSaldoCukup() {
        const input = document.getElementById('edit-totalDebet'); // jangan dihapus
        const raw = parseInt(document.getElementById('edit-totalDebetRaw').value || 0);
        const old = parseInt(document.getElementById('edit-totalDebetOld').value || 0);
        const saldo = parseInt(input.getAttribute('data-saldo') || 0);
        const alertBox = document.getElementById('saldo-warning');
        const submitBtn = document.getElementById('submitBtn');

        // Hitung tambahan pengeluaran (hanya jika total baru > total lama)
        if (raw > old) {
            const kebutuhan = raw - old; // total tambahan permintaan
            const kekurangan = kebutuhan - saldo; // sisa kekurangan setelah dipotong saldo

            if (kekurangan > 0) {
                alertBox.style.display = 'block';
                alertBox.innerHTML = `
                Saldo petty cash tidak mencukupi!<br>
                Kekurangan: Rp ${kekurangan.toLocaleString('id-ID')}<br>
                Saldo saat ini: Rp ${saldo.toLocaleString('id-ID')}
            `;
                submitBtn.disabled = true;
            } else {
                alertBox.style.display = 'none';
                alertBox.innerHTML = '';
                submitBtn.disabled = false;
            }
        } else {
            // Jika tidak ada tambahan (raw <= old) aman
            alertBox.style.display = 'none';
            alertBox.innerHTML = '';
            submitBtn.disabled = false;
        }
    }


    window.checkSaldoCukup = checkSaldoCukup;

    function formatRupiah(el) {
        let num = el.value.replace(/[^,\d]/g, '');
        const parts = num.split(',');
        const sisa = parts[0].length % 3;
        let rupiah = parts[0].substr(0, sisa);
        const ribuan = parts[0].substr(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        el.value = 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
        document.getElementById('edit-totalDebetRaw').value = num.replace(/\./g, '');
    }

    function formatRupiahText(angka) {
        if (!angka) return 'Rp. 0';
        angka = angka.toString().replace(/[^,\d]/g, '');
        const parts = angka.split(',');
        const sisa = parts[0].length % 3;
        let rupiah = parts[0].substring(0, sisa);
        const ribuan = parts[0].substring(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        return 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById("checkAll");
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

        // ✅ Event untuk checkbox "check all"
        checkAll.addEventListener("change", function() {
            const checkItems = document.querySelectorAll(".checkItem"); // ambil ulang setiap kali
            checkItems.forEach(item => {
                item.checked = checkAll.checked;
            });
            updateButtonState();
        });

        // ✅ Delegasi event untuk setiap checkbox item
        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("checkItem")) {
                const allItems = document.querySelectorAll(".checkItem");
                const checkedItems = document.querySelectorAll(".checkItem:checked");
                checkAll.checked = (allItems.length > 0 && allItems.length === checkedItems.length);
                updateButtonState();
            }
        });

        // ✅ Klik tombol approve semua
        btnApprove.addEventListener("click", function(e) {
            e.preventDefault();

            const selectedItems = document.querySelectorAll(".checkItem:checked");
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Tidak ada data yang dipilih!",
                    confirmButtonColor: "#376464"

                });
                return;
            }

            Swal.fire({
                icon: "question",
                title: `Submit ${selectedItems.length} data petty cash yang dipilih?`,
                text: "Apakah kamu yakin ingin melanjutkan?",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Ya, Submit",
                confirmButtonColor: "#376464",
                cancelButtonColor: "#c06240",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let processed = 0;

                    selectedItems.forEach(item => {
                        $.ajax({
                            url: "<?= base_url('bukti_pengeluaran_kas_kecil/proses_bpkk'); ?>",
                            type: "POST",
                            data: {
                                id_bpkk: item.value
                            },
                            dataType: "json",
                            // success: function(res) {
                            //     console.log(
                            //         `BPKK ${item.value} -> ${res.status}`);
                            // },
                            error: function() {
                                console.error(`BPKK ${item.value} -> ERROR`);
                            },
                            complete: function() {
                                processed++;
                                if (processed === selectedItems.length) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Berhasil",
                                        text: "Semua data berhasil diproses.",
                                        confirmButtonColor: "#376464"
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

    document.addEventListener("DOMContentLoaded", function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    });
</script>