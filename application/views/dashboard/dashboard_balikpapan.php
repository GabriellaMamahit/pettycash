<style>
/*untuk layar device berukuran kecil*/
@media screen and (min-width: 450px) {
    .btn-exp {
        width: 100%
    }
}
</style>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-3 col-sm-7 box-col-3">
                <h3>Kantor Balikpapan</h3>
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
                    <li class="breadcrumb-item active">Balikpapan</li>
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
                    <?php foreach ($data_saldobalikpapan as $saldo): ?>
                    <div class="row mt-3 ">
                        <div class="col-sm-8">
                            <div class="d-flex">

                                <div class="social-img-wrap">
                                    <div class="social-img"><img
                                            src="<?= base_url() ?>assets/images/flags/money-in-hand-info.jpg"
                                            alt="profile">
                                    </div>
                                    <div class="edit-icon">
                                        <svg>
                                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#profile-check"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-grow align-self-center ms-2 ">
                                    <h1 class="mt-0 user-name">Akun Balikpapan</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 float-sm-end">
                            <div class="float-sm-end">

                                <div class="d-flex">

                                    <h5><a href="javascript:;" class="txt-secondary text-decoration-none">In Progress
                                        </a>
                                        <!-- </h5><span class="f-light ms-2">Rejected</span> -->

                                </div>
                                <div class="d-flex mt-2">
                                    <h1><?= $jumlahstatusinprogress ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 float-sm-end">
                            <div class="float-sm-end">

                                <div class="d-flex">

                                    <h5><a href="javascript:;">Approved </a></h5>
                                    <!-- <span
                                        class="f-light ms-2">Approved</span> -->

                                </div>
                                <div class="d-flex mt-2">
                                    <h1><?= $jumlahstatusapproved ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 float-sm-end">
                            <div class="float-sm-end">

                                <div class="d-flex">

                                    <h5><a href="javascript:;" class="text-danger text-decoration-none">Rejected </a>
                                    </h5>
                                    <!-- <span
                                        class="f-light ms-2">Approved</span> -->

                                </div>
                                <div class="d-flex mt-2">
                                    <h1><?= $jumlahstatusrejected ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-showcase row mt-3">
                        <div class="col">
                            <div class="progress progress-border-primary">
                                <?php
                                    $debet = $saldo['saldodebetbalikpapan'];   // Pemasukan
                                    $kredit = $saldo['saldokreditbalikpapan']; // Pengeluaran

                                    $persentase = 0;
                                    if ($debet > 0) {
                                        $persentase = ($kredit / $debet) * 100;
                                    }
                                    ?>
                                <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar"
                                    style="width: <?= $persentase ?>%" aria-valuenow="<?= $persentase ?>"
                                    aria-valuemin="0" aria-valuemax="100">
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

                        <ul class="social-follow">
                            <li>
                                <h5 class="mb-0">Rp. <?= number_format($saldo['saldodebetbalikpapan'], 0, ',', '.') ?>
                                </h5>
                                <span class="f-light">Budget Saldo</span>
                            </li>
                            <li>
                                <h5 class="mb-0">Rp. <?= number_format($saldo['saldokreditbalikpapan'], 0, ',', '.') ?>
                                </h5>
                                <span class="f-light">Pengeluaran (Kredit)</span>
                            </li>
                            <li>
                                <h5 class="mb-0">Rp. <?= number_format($saldo['saldobalikpapan'], 0, ',', '.') ?></h5>
                                <span class="f-light">Sisa Saldo Petty Cash</span>
                            </li>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                    <button class="btn btn-pill btn-primary btn-air-primary mt-3 btn-exp" type="button"
                        style="width: 50%;" data-bs-toggle="modal" data-bs-target="#tambahbpkk"
                        <?= ($saldo['saldobalikpapan'] <= 15000) ? 'disabled' : '' ?>>Tambah Belanja</button>
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
                        <h4>Data Transaksi Balikpapan</h4>
                        <?php
                        // 1. Ambil no_pettycash terakhir dari transaksi debit
                        $last_trans = $this->db->select('no_pettycash')
                            ->where('jenis_transaksi', 'Debet')
                            ->order_by('id_mutasi', 'DESC') // bisa diganti id kalau lebih akurat
                            ->limit(1)
                            ->get('tb_data_mutasi')
                            ->row();

                        $hasRembesOpenDone = false;

                        if ($last_trans) {
                            $no_pc = $last_trans->no_pettycash;
                            // echo "Last Debit No Pettycash: " . $no_pc . "<br>";

                            // 2. Hitung semua baris dengan no_pettycash ini
                            $total_all = $this->db->where('no_pettycash', $no_pc)
                                ->count_all_results('tb_bpkk_cab');

                            // 3. Hitung yang rembesment=Open dan status_bpkk=Done
                            $total_done = $this->db->where('no_pettycash', $no_pc)
                                ->where('rembesment', 'Open')
                                ->where('status_bpkk', 'Done')
                                ->count_all_results('tb_bpkk_cab');

                            // 4. Bandingkan
                            if ($total_all > 0 && $total_all == $total_done) {
                                $hasRembesOpenDone = true;
                            }
                        }
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
                                title="Belum ada transaksi Kredit dengan status Open, tidak bisa print">
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
                                    <th>No .</th>
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
                                foreach ($rowtransaksibalikpapan as $data) { ?>
                                <tr <?= $data['status_cab'] == "Rejected" ? "class='table-danger'" : "" ?>>
                                    <th><?= $no++ ?>.</th>
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
                                        // Hitung saldo awal hanya dari Debet yang sesuai dengan no_petty_cash aktif
                                        $this->db->select('jenis_saldo, saldo_debet');
                                        $this->db->from('tb_saldo');
                                        $this->db->where('jenis_saldo', $data['jenis_saldo']);
                                        $row_saldo = $this->db->get()->row();

                                        $saldo_awal = $row_saldo->saldo_debet ?? 0;

                                        // 2. Ambil semua transaksi mutasi sesuai no_pettycash & jenis_saldo
                                        $this->db->from('tb_data_mutasi');
                                        $this->db->where('no_pettycash', $data['no_pettycash']);
                                        $this->db->where('jenis_saldo', $data['jenis_saldo']); // <--- filter tambahan
                                        $this->db->order_by('tanggal', 'ASC');
                                        $rowmutasi = $this->db->get()->result_array();

                                        // 3. Hitung saldo berjalan
                                        $saldo_berjalan = $saldo_awal;
                                        $sisa_saldo = '-'; // default

                                        foreach ($rowmutasi as $row) {
                                            if ($row['jenis_transaksi'] === 'Kredit') {
                                                $saldo_berjalan -= $row['total_kredit_cab'] ?? 0;
                                            }

                                            if ($row['id_mutasi'] == $data['id_mutasi']) {
                                                $sisa_saldo = ($row['jenis_transaksi'] === 'Kredit')
                                                    ? 'Rp. ' . number_format($saldo_berjalan, 0, ',', '.')
                                                    : '-';
                                                break;
                                            }
                                        }
                                        ?>
                                    <!-- <?php
                                                // Hitung saldo awal hanya dari Debet yang sesuai dengan no_petty_cash aktif
                                                // $this->db->select_sum('total_debet_cab', 'saldo_awal');
                                                // $this->db->from('tb_data_mutasi');
                                                // $this->db->where('jenis_transaksi', 'Debet');
                                                // $this->db->where('no_pettycash', $data['no_pettycash']);
                                                // $row_saldo = $this->db->get()->row();
                                                // $saldo_awal = $row_saldo->saldo_awal ?? 0;

                                                // // 2. Ambil semua transaksi berdasarkan no_pettycash
                                                // $this->db->from('tb_data_mutasi');
                                                // $this->db->where('no_pettycash', $data['no_pettycash']);
                                                // $this->db->order_by('tanggal', 'ASC');
                                                // $rowmutasi = $this->db->get()->result_array();

                                                // // 3. Hitung saldo berjalan: hanya tambahkan debet SATU KALI di awal
                                                // $saldo_berjalan = $saldo_awal;
                                                // foreach ($rowmutasi as $row) {
                                                //     if ($row['jenis_transaksi'] === 'Kredit') {
                                                //         $saldo_berjalan -= $row['total_kredit_cab'] ?? 0;
                                                //     }

                                                //     if ($row['id_mutasi'] == $data['id_mutasi']) {
                                                //         $sisa_saldo = ($row['jenis_transaksi'] === 'Kredit')
                                                //             ? 'Rp. ' . number_format($saldo_berjalan, 0, ',', '.')
                                                //             : '-';
                                                //         break;
                                                //     }
                                                // }
                                                ?> -->

                                    <td>
                                        <?= $sisa_saldo; ?>
                                    </td>
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
                                            value="<?= $no_bpkkbalikpapan; ?>" placeholder="BPKK-SBU/0000/MM/YYYY"
                                            readonly>
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
                                            <!-- <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="BSL" id="subUnitBSL"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitBSL">BSL</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="BSJ" id="subUnitBSJ"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitBSJ">BSJ</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="BMG" id="subUnitBM"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitBM">BM</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="ESA" id="subUnitESA"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitESA">ESA</label>
                                            </div> -->
                                        </div>

                                        <!-- <div id="bdp_form" class="form-group"
                                            style="display: none; flex-wrap: wrap; justify-content: center; gap: 10px;">
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="LAYUP" id="subUnitLAYUP"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitLAYUP">LAYUP</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox checkbox-secondary">
                                                <input class="form-check-input" value="PILOTAGE" id="subUnitPILOTAGE"
                                                    name="check-box[]" type="checkbox">
                                                <label class="form-check-label" for="subUnitPILOTAGE">PILOTAGE</label>
                                            </div>
                                        </div> -->
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
                                $saldo = $this->db->get_where('tb_saldo', ['jenis_saldo' => 'BPP'])->row()->saldo_pettycash ?? 0;
                                ?>
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="totalDebet">Total Kredit :</label>
                                    <input class="form-control" id="totalDebet" type="text" placeholder="Rp. 0" required
                                        oninput="formatRupiah(this); checkSaldoCukup();" data-saldo="<?= $saldo ?>"
                                        data-address_user="jakarta">
                                    <input type="hidden" id="totalDebetRaw" name="total_debet">
                                    <input type="hidden" id="address_cab" name="address_cab" value="BPP">

                                    <!-- Notifikasi jika saldo tidak cukup -->
                                    <div id="saldoAlert" class="mt-2 text-danger" style="display:none;">Saldo petty cash
                                        tidak mencukupi.</div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label txt-dark" for="formFile">Upload Dokumen Pendukung :</label>
                                    <input class="form-control" id="formFile" type="file" name="file_dokumen"
                                        accept=".pdf" required>
                                    <small class="form-text text-muted fst-italic">*File harus dalam format PDF</small>
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

    // === Toggle Form (BS Group / BDP) ===
    document.getElementById('optionsRadios1')?.addEventListener('change', () => {
        bsGroupForm.style.display = 'block';
        bdpForm.style.display = 'none';
    });
    document.getElementById('optionsRadios2')?.addEventListener('change', () => {
        bsGroupForm.style.display = 'none';
        bdpForm.style.display = 'block';
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
        let num = el.value.replace(/[^,\d]/g, '');
        const parts = num.split(',');
        const sisa = parts[0].length % 3;
        let rupiah = parts[0].substr(0, sisa);
        const ribuan = parts[0].substr(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        el.value = 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
        const rawInput = document.getElementById(
            el.id === 'edit-totalDebet' ? 'edit-totalDebetRaw' : 'totalDebetRaw'
        );
        if (rawInput) rawInput.value = num.replace(/\./g, '');
    };

    function checkSaldoCukup() {
        const rawValue = parseInt(document.getElementById('totalDebetRaw').value || 0);
        const addressUser = totalDebet.getAttribute('data-address_user');
        let saldo = 0;
        saldo = parseInt(totalDebet.getAttribute('data-saldo') || 0);

        if (rawValue > saldo) {
            saldoAlert.style.display = 'block';
            updateTextContent(saldoAlert, 'Saldo petty cash tidak mencukupi.');
            submitBtn.disabled = true;
        } else {
            saldoAlert.style.display = 'none';
            submitBtn.disabled = false;
        }
    }
    window.checkSaldoCukup = checkSaldoCukup;
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