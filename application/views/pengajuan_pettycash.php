<style>
/* Tambahkan jarak bawah kalau pagination terlalu mepet ke border bawah */
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
                <h3>Reimbursement Saldo Petty Cash</h3>
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
                    <li class="breadcrumb-item active">Pengajuan Reimbursement Petty Cash</li>
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
                        <h4>Daftar Reimbursement Saldo Petty Cash</h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <?php
                        $isDisabled = false;
                        $popoverContent = '';

                        // aturan limit per cabang
                        $limitRules = [
                            'JKT' => 1000000,  // 1 jt
                            'BPP' => 1500000,  // 1.5 jt
                            'TBK' => 1000000,  // 1 jt
                            'LU'  => 2000000,  // 2 jt
                            'PA'  => 500000,   // Sekupang dianggap sama kayak cabang normal
                        ];

                        if ($jenispettycashcek === 'BMG') {
                            // BMG tidak boleh ajukan reimbursement
                            $isDisabled = true;
                            $popoverContent = "Tidak dapat mengajukan reimbursement - anda tidak memiliki akses";
                        } else {
                            // Semua cabang termasuk Sekupang: cek saldo tunggal
                            $saldo = $this->db->select('saldo_pettycash')
                                ->where('jenis_saldo', $jenispettycashcek)
                                ->get('tb_saldo')
                                ->row('saldo_pettycash') ?? 0;

                            $limit = $limitRules[$jenispettycashcek] ?? 500000;

                            if ($saldo > $limit) {
                                $isDisabled = true;
                                $popoverContent = "Saldo Rp " . number_format($saldo, 0, ',', '.') .
                                    " (lebih dari Rp " . number_format($limit, 0, ',', '.') . "), tidak bisa ajukan reimbursement.";
                            }
                        }
                        ?>

                        <span <?php if ($popoverContent): ?> data-bs-toggle="popover" data-bs-trigger="hover"
                            data-bs-placement="bottom" data-bs-html="true" title="Informasi"
                            data-bs-content="<?= $popoverContent ?>" <?php endif; ?>>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#pengajuanpettycash" <?= $isDisabled ? 'disabled' : '' ?>>
                                Tambah Reimbursement Saldo
                            </button>
                        </span>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <!-- <th>Tanggal</th> -->
                                    <th>Permintaan </th>
                                    <th>Keterangan </th>
                                    <!-- <th>No Petty Cash</th> -->
                                    <th>Total</th>
                                    <th></th>
                                    <th>sisa Saldo</th>
                                    <th>Status</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowpermintaansaldo as $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= ucfirst($data['kantor_cab']); ?></p>
                                                </a><span
                                                    class="<?= $data['tanggal_pettycash'] ? 'text-success' : 'text-success' ?>"
                                                    style="font-size:12px;">
                                                    <?= date('d/m/Y', strtotime($data['tanggal_pettycash'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- <td><?= date('d/m/Y', strtotime($data['tanggal_pettycash'])); ?></td>
                                    <td><?= ucfirst($data['kantor_cab']); ?> -->
                                    <td>
                                        <div class="user-data">
                                            <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['ket_pettycash']; ?></p>
                                                </a><span
                                                    class="<?= $data['no_pettycash'] ? 'text-success' : 'text-success' ?>"
                                                    style="font-size:12px;">
                                                    <?= $data['no_pettycash']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- <td><?= $data['ket_pettycash']; ?></td> -->
                                    <!-- <td><?= $data['no_pettycash']; ?></td> -->
                                    <td>Rp. <?= number_format($data['saldo_pettycash'], 0, ',', '.'); ?></td>
                                    <td></td>
                                    <td>Rp. <?= number_format($data['sisa_saldo'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($data['status_permintaan'] == 'Waiting') : ?>
                                        <span class="badge badge-warning">Waiting</span>
                                        <?php else : ?>
                                        <span class="badge badge-success">Success</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
                                            <a href="#" class="btn btn-outline-info btn-sm view-permintaan-saldo"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat" data-no-pettycash="<?= $data['no_pettycash']; ?>"
                                                data-tanggal="<?= $data['tanggal_pettycash']; ?>"
                                                data-keterangan="<?= $data['ket_pettycash']; ?>"
                                                data-saldo="<?= $data['saldo_pettycash']; ?>"
                                                data-status="<?= $data['status_permintaan']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#viewdatapermintaansaldo">
                                                <i data-feather="eye" style="width:12px; height:12px;"></i>
                                            </a>
                                            <!-- pdf aprroval -->
                                            <a href="#" class="btn btn-outline-secondary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="View Pdf Approval"
                                                data-nama_dok="<?= $data['nama_dokumenremb']; ?>"
                                                data-jenissaldo_dok="<?= $data['jenis_saldo']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#viewpdfapproval">
                                                <i data-feather="file" style="width:12px; height:12px;"></i>
                                            </a>

                                            <a href="<?= base_url('pengajuan_pettycash/export_excel?no_pettycash=' . urlencode($data['no_pettycash'])); ?>"
                                                class="btn btn-outline-success btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Export ke Excel">
                                                <i data-feather="file-text" style="width:12px; height:12px;"></i>
                                            </a>

                                            <?php if ($this->session->userdata('level') === 'development') : ?>
                                            <!-- Hapus hanya untuk Development -->
                                            <!-- <a href="#" class="btn btn-outline-danger btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Hapus">
                                                <i data-feather="trash-2" style="width:12px; height:12px;"></i>
                                            </a> -->
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

<!-- Modal Tambah Permintaan Saldo -->
<div class="modal fade" id="pengajuanpettycash" tabindex="-1" role="dialog" aria-labelledby="pengajuanpettycash"
    aria-hidden="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Reimbursement Pengeluaran Petty Cash
                </h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation"
                        action="<?= site_url('pengajuan_pettycash/tambahpengajuanpettycash') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="no_pettycash-display"
                                            name="no_pettycash" placeholder="0000/PC-CABANG/MM/YYYY"
                                            value="<?= $no_petty_cash; ?>" readonly>
                                        <button class="btn btn-secondary" type="button" disabled>No Petty Cash</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input class="form-control" name="sbu" id="sbu" type="hidden" placeholder="SBU"
                                            value="<?= $sbu; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" name="sbu_unit" id="sbu_unit" type="hidden"
                                            placeholder="SBU Unit" value="<?= $sbu_unit; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="tanggal_hari_ini">Tanggal :</label>
                                    <input class="form-control" name="tanggal_hari_ini" id="tanggal_hari_ini"
                                        value="<?= $tanggal_hari_ini; ?>" placeholder="DD/MM/YYYY" disabled>
                                    <input type="hidden" name="kantor_cab" id="kantor_cab"
                                        value="<?= $address_user; ?>">
                                </div>
                            </div>
                            <?php if ($address_user === 'sekupang'): ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="form-label txt-dark d-block text-center mb-3">JENIS PETTY CASH</p>
                                        <div class="d-flex justify-content-center gap-4">
                                            <div class="form-check radio radio-primary">
                                                <input class="form-check-input jenis-petty" type="radio"
                                                    name="jenis_petty_cash" id="jenis_bbm" value="PA_BBM" required>
                                                <label class="form-check-label" for="jenis_bbm">BBM PILOT BOAT <i
                                                        class="fa fa-info-circle text-primary ms-1"
                                                        data-bs-toggle="popover" data-bs-placement="bottom"
                                                        data-bs-html="true" title="Informasi"
                                                        data-bs-content="Sedang cek saldo..."></i></label>
                                            </div>
                                            <div class="form-check radio radio-primary">
                                                <input class="form-check-input jenis-petty" type="radio"
                                                    name="jenis_petty_cash" id="jenis_rtk" value="PA_RTK">
                                                <label class="form-check-label" for="jenis_rtk">RTK
                                                    <i class="fa fa-info-circle text-primary ms-1"
                                                        data-bs-toggle="popover" data-bs-placement="bottom"
                                                        data-bs-html="true" title="Informasi"
                                                        data-bs-content="Sedang cek saldo..."></i>
                                                </label>
                                            </div>
                                            <div class="form-check radio radio-primary">
                                                <input class="form-check-input jenis-petty" type="radio"
                                                    name="jenis_petty_cash" id="jenis_sb" value="PA_SB">
                                                <label class="form-check-label" for="jenis_sb">SERVICE BOAT
                                                    <i class="fa fa-info-circle text-primary ms-1"
                                                        data-bs-toggle="popover" data-bs-placement="bottom"
                                                        data-bs-html="true" title="Informasi"
                                                        data-bs-content="Sedang cek saldo..."></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <input type="hidden" name="jenis_petty_cash" id="jenis_petty_cash_hidden"
                                value="<?= $jenis_petty_cash_default ?>">
                            <?php endif; ?>
                            <input type="hidden" name="kode_kantorcab" id="kode_kantorcab" readonly>
                            <!-- <div class="row mb-3">
                                <div class="col-md-9">
                                    <label class="form-label txt-dark" for="keterangan">Keterangan Permintaan Saldo
                                        :</label>
                                    <input class="form-control" name="keterangan" id="keterangan" type="text"
                                        placeholder="Pengajuan Saldo ...." required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label txt-dark" for="totalDebet">Total Debet :</label>
                                    <input class="form-control" id="totalDebet" type="text" placeholder="Rp. 0" readonly
                                        oninput="formatRupiah(this)">
                                    <input type="hidden" id="totalDebetRaw" name="totalDebetRaw">
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="keterangan">Keterangan Permintaan Saldo
                                        :</label>
                                    <input class="form-control" name="keterangan" id="keterangan" type="text"
                                        placeholder="Pengajuan Saldo ...." required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="totalDebet">Total Debet :</label>
                                    <input class="form-control" id="totalDebet" type="text" placeholder="Rp. 0" readonly
                                        oninput="formatRupiah(this)">
                                    <input type="hidden" id="totalDebetRaw" name="totalDebetRaw">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="sisaSaldo">Sisa Saldo :</label>
                                    <input class="form-control" id="sisaSaldo" type="text" placeholder="Rp. 0" readonly>
                                    <input type="hidden" id="sisaSaldoRaw" name="sisaSaldoRaw">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung :
                                        (Pesetujuan Atasan & PPT)</label>
                                    <input class="form-control" name="formFile" id="formFile" type="file" required>
                                    <small class="form-text text-danger fst-italic">*File harus dalam format PDF &
                                        maksimal 1 MB</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body pt-0">
                                        <h6>Pengeluaran BPKK</h6>
                                        <div class="table-responsive">
                                            <table class="pengeluaran_bpkk_saldo-table table"
                                                id="pengeluaran_bpkk_saldo">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
<div class="modal fade" id="viewdatapermintaansaldo" tabindex="-1" role="dialog"
    aria-labelledby="viewdatapermintaansaldo" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                    title="Lihat" data-bs-toggle="modal" data-bs-target="#viewdokumenpendukungsaldo"
                                    data-file="<?= $data['dokumen_pettycash']; ?>">
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
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
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
                        <div class="form-group" id="pratinjauGambardok3"></div>
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

<!-- modal view Dokumen pendukung -->
<div class="modal fade" id="viewpdfapproval" tabindex="-1" role="dialog" aria-labelledby="viewpdfapproval"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Dokumen Approval
                </h3>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group" id="pratinjauGambardok4"></div>
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

<!-- modal view Dokumen pendukung bpkk -->
<div class="modal fade" id="viewdokumenbpkkrembesment" tabindex="-1" role="dialog"
    aria-labelledby="viewdokumenbpkkrembesment" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Dokumen Bukti Pengeluaran Kas Kecil
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

    // hasil akhir
    el.value = 'Rp. ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);

    // simpan ke hidden input tanpa titik dan "Rp."
    const rawValue = number_string.replace(/\./g, '');
    document.getElementById('totalDebetRaw').value = rawValue;
}

// permintaan saldo
$(document).ready(function() {
    // Untuk Sekupang: trigger AJAX saat radio button dipilih
    $('input[name="jenis_petty_cash"]').on('change', function() {
        var jenis_saldo = $(this).val();
        fetchBpkkTable(jenis_saldo);
        fetchSisaSaldo(jenis_saldo);
    });

    // Untuk cabang selain Sekupang (input hidden)
    var jenis_saldo_default = $('input[name="jenis_petty_cash"]:not(:radio)').val();
    if (jenis_saldo_default !== undefined && jenis_saldo_default !== '') {
        fetchBpkkTable(jenis_saldo_default);
        fetchSisaSaldo(jenis_saldo_default);
    } else {
        // kosongkan dulu total debet jika belum ada pilihan jenis saldo
        $('#totalDebet').val('Rp. 0');
        $('#totalDebetRaw').val(0);
        $('#sisaSaldo').val('Rp. 0');
        $('#sisaSaldoRaw').val(0);
        $('#pengeluaran_bpkk_saldo tbody').html(
            '<tr><td colspan="8" class="text-center text-muted">Silakan pilih jenis petty cash terlebih dahulu.</td></tr>'
        );
    }

    function fetchBpkkTable(jenis_saldo) {
        $.ajax({
            url: "<?= site_url('pengajuan_pettycash/get_tabel_bpkk_by_jenis') ?>",
            type: "POST",
            data: {
                jenis_saldo: jenis_saldo
            },
            dataType: "json",
            success: function(response) {
                let html = '';
                const data = response.table_data;

                if (data.length === 0) {
                    html +=
                        '<tr><td colspan="8" class="text-center text-muted">Tidak ada data.</td></tr>';
                } else {
                    data.forEach(function(row) {
                        html += `
                        <tr>
                            <td class="text-center">${row.no}.</td>
                            <td>${row.tanggal}</td>
                            <td>${row.keterangan}</td>
                            <td>${row.total}</td>
                            <td></td>
                            <td>
                                ${row.status === 'In progress' ? '<span class="badge badge-warning">In progress</span>' :
                                row.status === 'Rejected' ? '<span class="badge badge-danger">Rejected</span>' : ''}
                            </td>
                        </tr>`;
                    });
                }

                $('#pengeluaran_bpkk_saldo tbody').html(html);

                // Tampilkan total debet di input form
                const formatted = new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(response.total_debet);

                $('#totalDebet').val('Rp. ' + formatted);
                $('#totalDebetRaw').val(response.total_debet);
            },
            error: function() {
                alert('Gagal mengambil data BPKK!');
            }
        });
    }

    function fetchSisaSaldo(jenis_saldo) {
        $.ajax({
            url: "<?= site_url('pengajuan_pettycash/get_sisa_saldo_by_jenis') ?>",
            type: "POST",
            data: {
                jenis_saldo: jenis_saldo
            },
            dataType: "json",
            success: function(res) {
                const saldo = res.saldo_pettycash ?? 0;

                const formatted = new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(saldo);

                $('#sisaSaldo').val('Rp. ' + formatted);
                $('#sisaSaldoRaw').val(saldo);
            },
            error: function() {
                $('#sisaSaldo').val('Rp. 0');
                $('#sisaSaldoRaw').val(0);
            }
        });
    }
});

// view data permintaan saldo
$(document).on('click', '.view-permintaan-saldo', function() {
    const noPettyCash = $(this).data('no-pettycash');
    const tanggal = $(this).data('tanggal');
    const keterangan = $(this).data('keterangan');
    const saldo = $(this).data('saldo');
    const status = $(this).data('status');

    // Isi info permintaan saldo
    const modal = $('#viewdatapermintaansaldo');
    modal.find('td:contains("NO PETTY CASH")').next().text(': ' + noPettyCash);
    modal.find('td:contains("TANGGAL")').next().text(': ' + tanggal);
    modal.find('td:contains("KETERANGAN")').next().text(': ' + keterangan);
    modal.find('td:contains("TOTAL PERMINTAAN SALDO")').next().text(': Rp. ' + parseInt(saldo).toLocaleString(
        'id-ID'));
    const badge = modal.find('.badge');
    badge.text(status.toUpperCase()).removeClass('bg-warning bg-success bg-danger text-dark text-white');

    if (status.toLowerCase() === 'waiting') {
        badge.text('WAITING').addClass('bg-warning text-white fw-bold');
    } else if (status.toLowerCase() === 'done') {
        badge.text('SUCCESS').addClass('bg-success text-white fw-bold');
    } else {
        badge.addClass('bg-secondary text-white');
    }

    // Panggil AJAX untuk ambil data pengeluaran BPKK
    $.ajax({
        url: '<?= site_url("pengajuan_pettycash/get_data_bpkk_by_nopettycash") ?>',
        method: 'POST',
        data: {
            no_pettycash: noPettyCash
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
                        <td>${row.total}</td>
                        <td>
                            <span class="badge ${
                                row.status === 'Approved' ? 'bg-success text-white' :
                                row.status === 'In progress' ? 'bg-warning text-dark' :
                                row.status === 'Rejected' ? 'bg-danger text-white' :
                                'bg-secondary'}">
                                    ${row.status}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                        <a href="#" 
                           class="btn btn-outline-info btn-sm view-dokumen d-flex align-items-center justify-content-center mx-auto"
                           style="width:24px; height:24px; padding:0;"
                           title="Lihat Dokumen"
                           data-jenis="${row.jenis_saldo}"
                           data-file="${row.upload_file_cab}"
                           data-bs-toggle="modal"
                           data-bs-target="#viewdokumenbpkkrembesment">
                           <i data-feather="eye" style="width:12px; height:12px;"></i>
                        </a>
                    </td>
                    </tr>
                `;
                });
            } else {
                tbody =
                    `<tr><td colspan="6" class="text-center text-muted">Tidak ada data pengeluaran BPKK.</td></tr>`;
            }
            modal.find('#viewpermintaan tbody').html(tbody);

            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        },
        error: function() {
            alert('Gagal mengambil data pengeluaran BPKK.');
        }
    });
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
                    confirmButtonColor: "#c06240"
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
                    confirmButtonColor: "#c06240"
                });
                this.value = ''; // reset input
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        }
    });
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

document.addEventListener("DOMContentLoaded", function() {
    const kodeInput = document.getElementById("kode_kantorcab");

    // Kalau hidden input ada (bukan sekupang)
    const hiddenJenis = document.getElementById("jenis_petty_cash_hidden");
    if (hiddenJenis) {
        let val = hiddenJenis.value;
        kodeInput.value = mapping[val] ?? "";
    }

    // Kalau pakai radio button (sekupang)
    document.querySelectorAll(".jenis-petty").forEach(radio => {
        radio.addEventListener("change", function() {
            let val = this.value;
            kodeInput.value = mapping[val] ?? "";
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
});

$(document).ready(function() {
    <?php if ($address_user === 'sekupang'): ?>
    // Loop semua radio jenis petty cash
    $('.jenis-petty').each(function() {
        var radio = $(this);
        var jenis = radio.val();

        $.ajax({
            url: "<?= site_url('pengajuan_pettycash/cek_limit_saldo') ?>",
            type: "POST",
            data: {
                jenis_saldo: jenis
            },
            dataType: "json",
            success: function(res) {
                // cari icon popover di label radio ini
                let infoIcon = radio.closest('.form-check')
                    .find('[data-bs-toggle="popover"]')[0];

                if (infoIcon) {
                    // update isi popover
                    let content =
                        `Saldo Rp ${res.saldo.toLocaleString('id-ID')} (min: Rp ${res.limit.toLocaleString('id-ID')})`;
                    infoIcon.setAttribute("data-bs-content", content);

                    // kalau sudah ada instance → update
                    let instance = bootstrap.Popover.getInstance(infoIcon);
                    if (instance) {
                        instance.setContent({
                            '.popover-body': content
                        });
                    } else {
                        // kalau belum ada → buat baru
                        new bootstrap.Popover(infoIcon);
                    }
                }

                // kalau saldo < limit → disable radio
                if (!res.allow) {
                    radio.prop('disabled', true);
                }
                // cek kondisi tombol simpan
                checkSubmitButton();
            }
        });
    });

    function checkSubmitButton() {
        let allDisabled = $('.jenis-petty').length === $('.jenis-petty:disabled').length;
        $('#submitBtn').prop('disabled', allDisabled);
    }
    <?php endif; ?>
});

$('input[name="jenis_petty_cash"]').on('change', function() {
    var jenis_saldo = $(this).val();

    // Ambil tabel BPKK seperti biasa
    fetchBpkkTable(jenis_saldo);

    // Ambil sisa saldo dari tb_saldo
    fetchSisaSaldo(jenis_saldo);
});

$(document).ready(function() {
    // Saat tombol Dokumen Pendukung diklik
    $(document).on('click', '#btnDokumenPendukung', function() {
        var fileName = $(this).data('file');
        var baseUrl = '<?= base_url("uploads/ppt/"); ?>';
        console.log('File name:', fileName); // cek di console

        if (fileName) {
            var filePath = baseUrl + fileName;
            console.log('Full path:', filePath); // cek di console

            // tampilkan PDF di iframe
            var previewHtml = `
                <div class="ratio ratio-16x9">
                    <iframe src="${filePath}" width="100%" height="600px"></iframe>
                </div>
            `;
            $('#pratinjauGambardok3').html(previewHtml);
        } else {
            $('#pratinjauGambardok3').html(
                '<p class="text-center text-danger">Tidak ada dokumen yang diunggah.</p>'
            );
        }

        // Tutup modal utama agar tidak tumpuk (optional)
        $('#viewdatapermintaansaldo').modal('hide');
    });
});

$(document).ready(function() {
    // Ketika tombol View PDF Approval diklik
    $(document).on('click', '.btn-outline-secondary[data-bs-target="#viewpdfapproval"]', function() {
        var namaDok = $(this).data('nama_dok');
        var jenisSaldo = $(this).data('jenissaldo_dok');

        // Elemen tempat preview
        var previewContainer = $('#pratinjauGambardok4');
        previewContainer.empty();

        // Jika nama dokumen kosong/null
        if (!namaDok || namaDok === 'null' || namaDok.trim() === '') {
            previewContainer.html('<p class="text-center text-danger mt-3">File tidak tersedia.</p>');
            return;
        }

        // Path file-nya
        var fileUrl = "<?= base_url('uploads/approve/'); ?>" + jenisSaldo + "/" + namaDok;

        // Cek dulu apakah file-nya benar-benar ada
        $.ajax({
            url: fileUrl,
            type: 'HEAD',
            success: function() {
                var iframe = '<iframe src="' + fileUrl +
                    '" width="100%" height="700px" style="border:none;"></iframe>';
                previewContainer.html(iframe);
            },
            error: function() {
                previewContainer.html(
                    '<p class="text-center text-danger mt-3">File tidak ditemukan di server.</p>'
                );
            }
        });
    });
});

$(document).ready(function() {
    // Ketika tombol View Dokumen BPKK Rembesment diklik
    $(document).on('click', '.view-dokumen', function() {
        var fileName = $(this).data('file'); // nama dokumen
        var jenisSaldo = $(this).data('jenis'); // jenis saldo

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
</script>