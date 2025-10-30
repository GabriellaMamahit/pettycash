<style>
/* untuk layar kecil (HP) */
@media screen and (max-width: 450px) {
    .btn-exp {
        width: 100% !important;
    }
}

@media screen and (max-width: 767px) {
    .default-dashboard .last-orders-table tbody tr td:first-child {
        min-width: unset;
        /* hapus min-width */
        width: auto;
        /* optional, kembalikan ke default */
    }
}
</style>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-3 col-sm-7 box-col-3">
                <h3>Kantor Jakarta</h3>
            </div>
            <div class="col-6 d-none d-xl-block">

            </div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Kantor Cabang</li>
                    <li class="breadcrumb-item active">Jakarta</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid default-dashboard">
    <div class="row">
        <div class="col-xl-12">
            <div class="card social-profile">
                <div class="card-body">
                    <?php foreach ($data_saldojkt as $saldo): ?>
                    <div class="row mt-3 ">
                        <div class="col-sm-9">
                            <div class="d-flex">

                                <div class="social-img-wrap">
                                    <div class="social-img"><img
                                            src="<?= base_url() ?>assets/images/flags/money-in-hand-primary.png"
                                            alt="profile">
                                    </div>
                                    <div class="edit-icon">
                                        <svg>
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#profile-check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-grow align-self-center ms-2 ">
                                    <h1 class="mt-0 user-name">Akun Jakarta</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-2 text-center text-sm-end mb-3 mb-sm-0 mt-3">
                            <div class="d-inline-block">
                                <div class="d-flex flex-column align-items-center align-items-sm-end">
                                    <h5 class="mb-1">
                                        <a href="javascript:;" class="txt-secondary text-decoration-none">In
                                            Progress</a>
                                    </h5>
                                    <h1 class="mb-0"><?= $jumlahstatusinprogress ?></h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-sm-1 text-center text-sm-end mb-3 mb-sm-0 mt-3">
                            <div class="d-inline-block">
                                <div class="d-flex flex-column align-items-center align-items-sm-end">
                                    <h5 class="mb-1">
                                        <a href="javascript:;" class="text-danger text-decoration-none">Rejected</a>
                                    </h5>
                                    <h1 class="mb-0"><?= $jumlahstatusrejected ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-showcase row mt-3">
                        <div class="col">
                            <div class="progress progress-border-primary">
                                <?php
                                    $debet = $saldo['saldodebetjkt'];   // Pemasukan
                                    $kredit = $saldo['saldokreditjkt']; // Pengeluaran

                                    $persentase = 0;
                                    if ($debet > 0) {
                                        $persentase = ($kredit / $debet) * 100;
                                    }

                                    // Biar gak lebih dari 100%
                                    if ($persentase > 100) {
                                        $persentase = 100;
                                    }
                                    ?>
                                <div class="progress-bar-animated bg-primary progress-bar-striped d-flex align-items-center justify-content-center"
                                    role="progressbar" style="width: <?= $persentase ?>%;"
                                    aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        <strong><?= round($persentase, 1) ?>%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="progress-showcase row mt-3">
                        <div class="col">
                            <div class="progress progress-border-primary">
                                <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar"
                                    style="width: 30%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div> -->
                    <div class="social-details">
                        <ul class="social-follow"
                            style="display: flex; justify-content: space-around; align-items: center; text-align: center; padding: 0; margin: 0; list-style: none; width: 100%;">
                            <li style="flex: 1;">
                                <h5 class="mb-0" style="margin-bottom: 2px; font-size: clamp(11px, 2vw, 18px);">
                                    Rp. <?= number_format($saldo['saldodebetjkt'], 0, ',', '.') ?>
                                </h5>
                                <span class="f-light" style="font-size: clamp(9px, 1.8vw, 13px);">Pemasukan
                                    (Debet)</span>
                            </li>
                            <li
                                style="flex: 1; border-left: 1px solid rgba(0,0,0,0.1); border-right: 1px solid rgba(0,0,0,0.1);">
                                <h5 class="mb-0" style="margin-bottom: 2px; font-size: clamp(11px, 2vw, 18px);">
                                    Rp. <?= number_format($saldo['saldokreditjkt'], 0, ',', '.') ?>
                                </h5>
                                <span class="f-light" style="font-size: clamp(9px, 1.8vw, 13px);">Pengeluaran
                                    (Kredit)</span>
                            </li>
                            <li style="flex: 1;">
                                <h5 class="mb-0" style="margin-bottom: 2px; font-size: clamp(11px, 2vw, 18px);">
                                    Rp. <?= number_format($saldo['saldojkt'], 0, ',', '.') ?>
                                </h5>
                                <span class="f-light" style="font-size: clamp(9px, 1.8vw, 13px);">Sisa Saldo Petty
                                    Cash</span>
                            </li>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                    <button class="btn btn-pill btn-primary btn-air-primary mt-3 btn-exp" type="button"
                        style="width: 50%;" data-bs-toggle="modal" data-bs-target="#tambahbpkk"
                        <?= ($saldo['saldojkt'] <= 15000) ? 'disabled' : '' ?>>Tambah
                        Pengeluaran</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid default-dashboard">
    <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Data Transaksi Jakarta</h4>
                        <?php
                        $hasRembesOpenDone = false;

                        // 1. Hitung total data dengan status_cab = In progress (untuk JKT)
                        $total_inprogress = $this->db->where('jenis_saldo', 'JKT')
                            ->where('status_cab', 'In progress')
                            ->where('rembesment', 'Open')
                            ->count_all_results('tb_bpkk_cab');

                        // 2. Hitung data In progress yang sudah rembesment=Open dan status_bpkk=Done
                        $total_inprogress_done = $this->db->where('jenis_saldo', 'JKT')
                            ->where('status_cab', 'In progress')
                            ->where('rembesment', 'Open')
                            ->where('status_bpkk', 'Done')
                            ->count_all_results('tb_bpkk_cab');

                        // 3. Kondisi tombol
                        if ($total_inprogress > 0 && $total_inprogress == $total_inprogress_done) {
                            $hasRembesOpenDone = true;
                        }

                        // Debug opsional
                        // echo "inprogress = $total_inprogress, inprogress_done = $total_inprogress_done";
                        ?>

                        <div>
                            <?php if ($hasRembesOpenDone): ?>
                            <a href="<?= site_url('Dashboard_cab/generate_pettycash/' . $codecabang) ?>" target="_blank"
                                class="btn btn-outline-primary btn-sm"
                                style="width:30px; height:30px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                title="Print PDF">
                                <i data-feather="printer" style="width:16px; height:16px;"></i>
                            </a>
                            <?php else: ?>
                            <button class="btn btn-outline-secondary btn-sm" disabled
                                style="width:30px; height:30px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                title="Belum semua transaksi Open sudah Done, tidak bisa print">
                                <i data-feather="printer" style="width:16px; height:16px;"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive mb-4">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Deskription/No</th>
                                    <th>Masuk</th>
                                    <th></th>
                                    <th></th>
                                    <th>Keluar</th>
                                    <th>Sisa Saldo </th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowtransaksijkt as $data) { ?>
                                <tr <?= $data['status_cab'] == "Rejected" ? "class='table-danger'" : "" ?>>
                                    <td><?= $no++ ?>.</td>
                                    <td>
                                        <div class="user-data">
                                            <?php
                                                $isKredit = $data['jenis_transaksi'] === 'Kredit';
                                                $icon = $isKredit ? 'arrow-up' : 'arrow-down';
                                                $bgColor = $isKredit ? '#f8d7da' : '#d4edda';
                                                $iconColor = $isKredit ? '#721c24' : '#155724';
                                                ?>
                                            <div class="product-image">
                                                <div class="rounded-circle"
                                                    style="width:30px; height:30px; background-color: <?= $bgColor ?>; display:flex; align-items:center; justify-content:center;">
                                                    <i data-feather="<?= $icon ?>"
                                                        style="color: <?= $iconColor ?>;"></i>
                                                </div>
                                            </div>
                                            <div><a href="javascript:;">
                                                    <h4><?= $data['keterangan']; ?></h4>
                                                </a><span style="font-size:13px;">
                                                    <?= $data['jenis_transaksi'] === 'Kredit' ? $data['no_bpkk_cab'] : $data['no_pettycash']; ?>
                                                    |
                                                    <?= date('d/m/Y', strtotime(str_replace('/', '-', $data['tanggal']))); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="<?= $data['jenis_transaksi'] === 'Kredit' ? 'text-danger' : 'text-success' ?>">
                                        <?= isset($data['total_debet_cab']) && $data['total_debet_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_debet_cab'], 0, ',', '.')
                                                : '-'; ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td
                                        class="<?= $data['jenis_transaksi'] === 'Kredit' ? 'text-danger' : 'text-success' ?>">
                                        <?= isset($data['total_kredit_cab']) && $data['total_kredit_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.')
                                                : '-'; ?></td>

                                    <?php
                                        // $sisa_saldo = '-';
                                        // if ($data['status_cab'] != 'Rejected') {
                                        //     // 1. Ambil saldo awal dari tb_saldo
                                        //     $this->db->select('jenis_saldo, saldo_debet');
                                        //     $this->db->from('tb_saldo');
                                        //     $this->db->where('jenis_saldo', $data['jenis_saldo']);
                                        //     $row_saldo = $this->db->get()->row();

                                        //     $saldo_awal = $row_saldo->saldo_debet ?? 0;

                                        //     // 2. Ambil semua mutasi by jenis_saldo (pakai models)
                                        //     $all_mutasi = $this->M_bpkk->getAllMutasiByCabang($data['jenis_saldo']);

                                        //     $saldo_berjalan = $saldo_awal;
                                        //     $sisa_saldo = '-';

                                        //     // 3. Loop transaksi
                                        //     foreach ($all_mutasi as $row) {
                                        //         // Hanya hitung transaksi Kredit dengan status_cab NULL atau kosong
                                        //         if ($row['jenis_transaksi'] === 'Kredit' && (empty($row['status_cab']))) {
                                        //             $saldo_berjalan -= $row['total_kredit_cab'] ?? 0;
                                        //         }

                                        //         // Saat ketemu id_mutasi aktif, catat sisa saldo
                                        //         if ($row['id_mutasi'] == $data['id_mutasi']) {
                                        //             $sisa_saldo = ($row['jenis_transaksi'] === 'Kredit')
                                        //                 ? 'Rp. ' . number_format($saldo_berjalan, 0, ',', '.')
                                        //                 : '-';
                                        //             break;
                                        //         }
                                        //     }
                                        // }
                                        ?>
                                    <td>
                                        <?= $data['jenis_transaksi'] == 'Debet'
                                                ? '-'
                                                : number_format($data['sisa_saldo_pending'], 0, ',', '.') ?>
                                    </td>
                                    <!-- <td><?= $sisa_saldo; ?></td> -->
                                    <td class="text-center">
                                        <!-- Baris pertama: 3 tombol -->
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
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

<!-- modal tambah data bukti pengeluaran kas kecil -->
<div class="modal fade" id="tambahbpkk" tabindex="-1" role="dialog" aria-labelledby="tambahbpkk" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">TAMBAH DATA PENGELUARAN KAS KECIL</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation"
                        action="<?= site_url('Dashboard_cab/tambahpengeluaranbpkk') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="no-bpkk-display" name="no_bpkk"
                                            value="<?= $no_bpkkjkt; ?>" placeholder="BPKK-SBU/0000/MM/YYYY" readonly>
                                        <button class="btn btn-secondary" type="button" disabled>No BPKK</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="form-label txt-dark d-block text-center">UNIT KERJA / DIREKTORAT</p>
                                    <div class="position-relative text-center">
                                        <p
                                            class="text-sm font-weight-bold text-secondary text-border d-inline z-index-2 px-3">
                                            ________
                                        </p>
                                    </div>
                                    <div
                                        style="display: flex; flex-direction: row; justify-content: center; gap: 20px;">
                                        <div class="form-check radio radio-primary">
                                            <input class="form-check-input" type="radio" name="optionsRadios"
                                                id="optionsRadios1" value="BS GROUP" required>
                                            <label class="form-check-label" for="optionsRadios1">BS GROUP</label>
                                        </div>
                                        <!-- <div class="form-check radio radio-primary">
                                            <input class="form-check-input" type="radio" name="optionsRadios"
                                                id="optionsRadios2" value="BDP">
                                            <label class="form-check-label" for="optionsRadios2">BDP</label>
                                        </div> -->
                                    </div>
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                                        <div id="bs_group_form" class="form-group"
                                            style="display: none; flex-wrap: wrap; justify-content: center; gap: 10px;">
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="PBS" id="subUnitPBS"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitPBS">PBS</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="tanggal">Tanggal :</label>
                                    <input class="form-control" id="tanggal" name="tanggal" type="date"
                                        value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="keterangan">Keterangan Pengeluaran :</label>
                                    <input class="form-control" id="keterangan" name="keterangan" type="text"
                                        placeholder="Pengeluaran Kas Kecil Untuk ...." required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="pilihjenispengeluaran">Pengeluaran</label>
                                    <select class="form-select" id="pilihjenispengeluaran" name="jenis_pengeluaran"
                                        required="">
                                        <option selected="" disabled="" value="">Pilih ...</option>
                                        <option value="bbm_kantor">BBM Kantor</option>
                                        <option value="bbm_pilot">BBM Pilot Boat</option>
                                        <option value="bbm_service">Service Boat</option>
                                        <option value="atk_rtk">ATK/RTK</option>
                                        <option value="fotocopy">Biaya Fotocopy</option>
                                        <option value="kendaraan_kantor">Biaya Kendaraan Kantor</option>
                                        <option value="listrik_kantor">Biaya Listrik Kantor</option>
                                        <option value="air_pam">Biaya Air Pam</option>
                                        <option value="internet">Biaya Internet</option>
                                        <option value="lainnya">Biaya Lainnya</option>
                                    </select>
                                </div>
                                <?php
                                $saldo = 0;
                                $saldo = $this->db->get_where('tb_saldo', ['jenis_saldo' => 'JKT'])->row()->saldo_pettycash ?? 0;
                                ?>
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="totalDebet">Total Kredit :</label>
                                    <input class="form-control" id="totalDebet" type="text" placeholder="Rp. 0" required
                                        oninput="formatRupiah(this); checkSaldoCukup();" data-saldo="<?= $saldo ?>"
                                        data-address_user="jakarta">
                                    <input type="hidden" id="totalDebetRaw" name="total_debet">
                                    <input type="hidden" id="address_cab" name="address_cab" value="JKT">

                                    <!-- Notifikasi jika saldo tidak cukup -->
                                    <div id="saldoAlert" class="mt-2 text-danger" style="display:none;">Saldo petty cash
                                        tidak mencukupi.</div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung :
                                        (Bukti Pengeluaran - Kwitansi)</label>
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

<!-- Modal View Data Transaksi -->
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
const BASE_URL = '<?= base_url(); ?>';
document.addEventListener('DOMContentLoaded', () => {
    const bsGroupForm = document.getElementById('bs_group_form');
    const bdpForm = document.getElementById('bdp_form');
    const totalDebet = document.getElementById('totalDebet');
    const saldoAlert = document.getElementById('saldoAlert');
    const submitBtn = document.getElementById('submitBtn');
    const addressCab = document.getElementById('address_cab');

    document.getElementById('optionsRadios1')?.addEventListener('change', () => {
        if (bsGroupForm) {
            bsGroupForm.style.display = 'block';
        }
        if (bdpForm) {
            bdpForm.style.display = 'none';
        }
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
            <iframe src="${BASE_URL}uploads/${folder}/${data.file}" 
            width="100%" height="450px" style="border:1px solid #ccc;"></iframe>
            `);
        }
    });

    $('#viewdatatransaksi').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());

    // === Format Rupiah Input ===
    window.formatRupiah = el => {
        let angka = el.value.replace(/[^0-9]/g, ''); // hanya angka
        let hasil = '';
        let sisa = angka.length % 3;
        hasil = angka.substr(0, sisa);
        let ribuan = angka.substr(sisa).match(/\d{3}/g);
        if (ribuan) hasil += (sisa ? '.' : '') + ribuan.join('.');
        el.value = angka ? 'Rp. ' + hasil : '';

        // Simpan angka mentah di hidden input
        const rawInput = document.getElementById(
            el.id === 'edit-totalDebet' ? 'edit-totalDebetRaw' : 'totalDebetRaw'
        );
        if (rawInput) rawInput.value = angka;

        // Jalankan pengecekan saldo langsung tiap input
        checkSaldoCukup();
    };

    function checkSaldoCukup() {
        const rawValue = parseInt(document.getElementById('totalDebetRaw').value || 0);
        const totalDebet = document.getElementById('totalDebet');
        const saldoAlert = document.getElementById('saldoAlert');
        const submitBtn = document.getElementById('submitBtn');

        const saldo = parseInt(totalDebet.getAttribute('data-saldo') || 0);

        if (isNaN(rawValue)) return; // kalau belum diisi, lewati saja

        if (rawValue > saldo) {
            saldoAlert.style.display = 'block';
            saldoAlert.textContent = 'Saldo petty cash tidak mencukupi.';
            submitBtn.setAttribute('disabled', true);
            submitBtn.classList.add('disabled');
        } else {
            saldoAlert.style.display = 'none';
            submitBtn.removeAttribute('disabled');
            submitBtn.classList.remove('disabled');
        }
    }
    window.checkSaldoCukup = checkSaldoCukup;
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#tambahbpkk form');
    form.addEventListener('submit', function(e) {
        const checkboxes = form.querySelectorAll('input[name="check-box[]"]:checked');
        if (checkboxes.length === 0) {
            e.preventDefault(); // stop submit
            Swal.fire({
                icon: 'warning',
                title: 'Harus Pilih Sub Unit!',
                text: 'Minimal pilih 1 checkbox sebelum submit.',
                confirmButtonColor: "#c06240"
            });
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
</script>