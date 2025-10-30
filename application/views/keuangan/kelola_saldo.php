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
                <h3>Reimbursement Petty Cash</h3>
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
                    <li class="breadcrumb-item active">Kelola Saldo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- CARD UTAMA WRAPPER -->
<div class="container-fluid general-widget">
    <div class="row">
        <div class="col-xl-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                    <h4 class="mb-0">Status Pengeluaran Kas Kecil</h4>

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-2" style="width:220px;">
                            <label class="fw-bold mb-1">Pilih Cabang</label>
                            <select class="form-control" id="filterCabang" onchange="filterWidget()">
                                <option value="all">Semua Cabang</option>
                                <option value="JKT">Jakarta</option>
                                <option value="BPP">Balikpapan</option>
                                <option value="TBK">Karimun</option>
                                <option value="LU">Galang</option>
                                <option value="PA_BBM">Sekupang - BBM Pilot Boat</option>
                                <option value="PA_SB">Sekupang - Service Boat</option>
                                <option value="PA_RTK">Sekupang - RTK/ATK</option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- CARD DI DALAM CARD -->
                <div class="row mt-3">

                    <!-- IN PROGRESS -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card"
                        data-type="all JKT BPP TBK LU PA_BBM PA_SB PA_RTK">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-warning">In Progress</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="inProgressCount"><?= $in_progress['count']; ?></h3>
                                <div>Total: Rp <span id="inProgressTotal"><?= $in_progress['total']; ?></span></div>
                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'In progress');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'In progress');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- APPROVED -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-success">Approved</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="approvedCount"><?= $approved['count']; ?></h3>
                                <div>Total: Rp <span id="approvedTotal"><?= $approved['total']; ?></span></div>

                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Approved');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Approved');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- REVISI -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-info">Revisi</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="revisiCount"><?= $revisi['count']; ?></h3>
                                <div>Total: Rp <span id="revisiTotal"><?= $revisi['total']; ?></span></div>

                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Revisi');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Revisi');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- REJECT -->
                    <div class="col-xl-3 col-lg-6 col-md-6 petty-card" data-type="all">
                        <div class="card">
                            <div class="card-body selling-card">
                                <h4 class="text-danger">Rejected</h4>
                                <span class="fw-bold small pb-2"><?= date('F Y'); ?></span>
                                <h3 id="rejectedCount"><?= $rejected['count']; ?></h3>
                                <div>Total: Rp <span id="rejectedTotal"><?= $rejected['total']; ?></span></div>
                                <!-- <h3>
                                    <?php
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Rejected');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    echo $this->db->count_all_results(); ?>
                                </h3>
                                <div>Total: Rp
                                    <?php
                                    $this->db->select_sum('total_kredit_cab');
                                    $this->db->from('tb_bpkk_cab');
                                    $this->db->where('status_cab', 'Rejected');
                                    $this->db->where('MONTH(tgl_kredit_cab)', date('m'), false);
                                    $this->db->where('YEAR(tgl_kredit_cab)', date('Y'), false);
                                    $query = $this->db->get()->row();
                                    echo number_format($query->total_kredit_cab ?? 0, 0, ',', '.');
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div> <!-- END ROW -->
            </div>
        </div>
    </div>
</div>

<script>
function filterWidget() {
    var selected = $('#filterCabang').val();

    // Tampilkan animasi loading
    $('#loader').show();

    $.ajax({
        url: "<?php echo base_url('Kelola_saldo/filter_widget'); ?>",
        type: "POST",
        data: {
            jenis_saldo: selected
        },
        dataType: "json",
        success: function(result) {

            $("#inProgressCount").text(result.in_progress.count);
            $("#inProgressTotal").text(result.in_progress.total);

            $("#approvedCount").text(result.approved.count);
            $("#approvedTotal").text(result.approved.total);

            $("#revisiCount").text(result.revisi.count);
            $("#revisiTotal").text(result.revisi.total);

            $("#rejectedCount").text(result.rejected.count);
            $("#rejectedTotal").text(result.rejected.total);

            $('#loader').hide(); // sembunyikan loading
        },
        error: function() {
            alert("Gagal mengambil data filter");
            $('#loader').hide();
        }
    });
}
</script>





<!-- === Main Content === -->
<div class="container-fluid default-dashboard2">
    <div class="row">
        <div class="col-xl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h4>Daftar Saldo Petty Cash</h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Kantor Cabang</th>
                                    <th class="text-center">Dokumen In Progress </th>
                                    <th>Total Saldo</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <?php $no = 1;
                            foreach ($rowsaldocabang as $data) { ?>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= $data['nama_saldo']; ?></td>
                                    <td class="text-center"><?php
                                                                $this->db->from('tb_saldo');
                                                                $this->db->join('tb_bpkk_cab', 'tb_bpkk_cab.jenis_saldo = tb_saldo.jenis_saldo', 'left');
                                                                $this->db->where('tb_saldo.jenis_saldo', $data['jenis_saldo']);
                                                                $this->db->group_start(); // Mulai grup kondisi OR
                                                                $this->db->where('tb_bpkk_cab.status_cab', 'In progress');
                                                                $this->db->or_where('tb_bpkk_cab.status_cab', 'Rejected');
                                                                $this->db->or_where('tb_bpkk_cab.status_cab', 'Revisi');
                                                                $this->db->group_end();
                                                                $this->db->where('tb_bpkk_cab.no_pc_saldo IS NOT NULL', null, false);
                                                                echo $this->db->count_all_results();
                                                                ?></td>
                                    <td>Rp. <?= number_format($data['saldo_pettycash'], 0, ',', '.'); ?></td>
                                    <td></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
                                            <a href="<?= site_url('kelola_saldo/detail_saldo/' . $data['id_saldopc'] . '/' . $data['jenis_saldo']) ?>"
                                                class="btn btn-outline-info btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat">
                                                <i data-feather="eye" style="width:12px; height:12px;"></i>
                                            </a>
                                            <!-- Edit -->
                                            <a href="#" class="btn btn-outline-secondary btn-sm edit-databpkk"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Edit Budget Saldo" data-bs-toggle="modal"
                                                data-bs-target="#editbudgetsaldocabang">
                                                <i data-feather="edit" style="width:12px; height:12px;"></i>
                                            </a>

                                    </td>
                                    <!-- <td class="text-center">
                                        <a href="<?= site_url('kelola_saldo/detail_saldo/' . $data['id_saldopc'] . '/' . $data['jenis_saldo']) ?>"
                                            class="btn btn-outline-info btn-sm"
                                            style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                            title="Lihat">
                                            <i data-feather="eye" style="width:12px; height:12px;"></i>
                                        </a>
                                    </td> -->
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
<div class="modal fade" id="editbudgetsaldocabang" tabindex="-1" role="dialog" aria-labelledby="editbudgetsaldocabang"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">EDIT BUDGET SALDO CABANG</h3>
                <div class="modal-body">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="250px"><strong>KANTOR CABANG</strong></td>
                                    <td>: <strong>

                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>LOKASI KANTOR</strong></td>
                                    <td>: <strong>

                                        </strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form class="row g-3 needs-validation" action="<?= site_url('kelola_saldo/editbudgetsaldo') ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label txt-dark" for="edit-totalbudget">Total Kredit :</label>
                                    <input class="form-control" id="edit-totalbudget" name="totalbudget" type="text"
                                        placeholder="Rp. 0" oninput="formatRupiah(this); checkSaldoCukup();">
                                    <input type="hidden" id="edit-totalbudgetRaw" name="total_budget">
                                    <input type="hidden" id="edit-totalbudgetOld" value="">
                                    <small id="saldo-warning" class="mt-2 text-danger" style="display:none;"></small>
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