<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Notifikasi</h3>
            </div>
            <div class="col-5 d-none d-xl-block">
                <!-- Page Sub Header Start-->

                <!-- Page Sub Header end
                  -->
            </div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active">Notifikasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4></h4><button id="mark-all" class="btn btn-outline-primary btn-sm">Tandai Semua Sudah
                        Dibaca</button>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive mb-4">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Notifikasi</th>
                                    <!-- <th>Keterangan notifikasi</th> -->
                                    <!-- <th></th> -->
                                    <th></th>
                                    <th>Tanggal</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rownotifikasi as $data) { ?>
                                <tr class="<?= $data['status_notifikasi'] == 0 ? 'bg-light' : '' ?>">
                                    <td><?= $no++ ?></td>
                                    <!-- <td>
                                            <strong class="<?=
                                                            $data['jenis_notifikasi'] == 'Permintaan' ? 'text-warning' : ($data['jenis_notifikasi'] == 'Penambahan' ? 'text-success' : ($data['jenis_notifikasi'] == 'Revisi' ? 'text-primary' : ($data['jenis_notifikasi'] == 'Rejected' ? 'text-danger' : 'text-dark')))
                                                            ?>">
                                                <?= $data['jenis_notifikasi']; ?>
                                            </strong>
                                        </td> -->

                                    <td>
                                        <div class="user-data">
                                            <div>
                                                <a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                    <p><?= $data['judul_notifikasi']; ?></p>
                                                </a>
                                                <span style="font-size:12px;" class="<?=
                                                                                            $data['jenis_notifikasi'] == 'Permintaan' ? 'text-warning' : ($data['jenis_notifikasi'] == 'Penambahan' ? 'text-success' : ($data['jenis_notifikasi'] == 'Revisi' ? 'text-primary' : ($data['jenis_notifikasi'] == 'Rejected' ? 'text-danger' : 'text-dark')))
                                                                                            ?>">
                                                    <?= $data['ket_notifikasi']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td style="font-size:12px;">
                                        <?= date('d F Y / H:i', strtotime($data['tanggal_notifikasi'])); ?></td>
                                    <td></td>
                                    </td>
                                    <td class="text-center">
                                        <!-- Baris pertama: 3 tombol -->
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Lihat -->
                                            <a href="#" class="btn btn-outline-info btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Lihat"
                                                data-tanggalnotifikasi="<?= date('d F Y', strtotime($data['tanggal_notifikasi'])); ?>"
                                                data-notifikasi="<?= $data['judul_notifikasi']; ?>"
                                                data-ket_notifikasi="<?= $data['ket_notifikasi']; ?>"
                                                data-jenis_notifikasi="<?= $data['jenis_notifikasi']; ?>"
                                                data-nopettycash="<?= $data['no_pettycash']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#viewnotifikasi">
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
<!-- Container-fluid Ends-->


<!-- modal view notifikasi -->
<div class="modal fade" id="viewnotifikasi" tabindex="-1" role="dialog" aria-labelledby="viewnotifikasi"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">Notifikasi</h3>
                <div class="modal-body">
                    <div class="w-100">
                        <!-- Badge warna atas -->
                        <span class="badge bg-secondary d-block w-100 text-center" style="font-size: 14px;"></span>
                    </div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="220px"><strong>TANGGAL</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>NOTIFIKASI</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>KETERANGAN</strong></td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td><strong>NO TRANSAKSI</strong></td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td><strong>STATUS</strong></td>
                                    <td>: </td>
                                </tr>
                            </tbody>
                        </table>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '[data-bs-target="#viewnotifikasi"]', function() {
    const modal = $('#viewnotifikasi');

    // ambil data dari atribut tombol
    const data = {
        tanggal: $(this).data('tanggalnotifikasi') || '-',
        judnotif: $(this).data('notifikasi') || '-',
        ketnotifik: $(this).data('ket_notifikasi') || '-',
        noPetty: $(this).data('nopettycash') || '-',
        jenis_notifikasi: $(this).data('jenis_notifikasi') || '-'
    };

    // isi field tabel (selain STATUS)
    const infoFields = {
        'TANGGAL': data.tanggal,
        'NOTIFIKASI': data.judnotif,
        'KETERANGAN': data.ketnotifik,
        'NO TRANSAKSI': data.noPetty,
    };

    modal.find('td').each(function() {
        const label = $(this).text().trim();
        if (infoFields[label] !== undefined) {
            $(this).next().text(': ' + infoFields[label]);
        }
    });

    // Tentukan warna badge berdasarkan jenis_notifikasi
    let badgeClass = '';
    switch (data.jenis_notifikasi) {
        case 'Permintaan':
            badgeClass = 'bg-warning text-dark';
            break;
        case 'Penambahan':
            badgeClass = 'bg-success';
            break;
        case 'Revisi':
            badgeClass = 'bg-primary';
            break;
        case 'Rejected':
            badgeClass = 'bg-danger';
            break;
        default:
            badgeClass = 'bg-secondary';
    }

    // 🔹 Ubah warna badge besar di atas modal (tanpa teks)
    const headerBadge = modal.find('.w-100 .badge');
    headerBadge.removeClass().addClass(`badge d-block w-100 text-center ${badgeClass}`);

    // 🔹 Ubah baris STATUS menjadi badge dengan teks jenis_notifikasi
    modal.find('td').each(function() {
        const label = $(this).text().trim();
        if (label === 'STATUS') {
            $(this).next().html(`: <span class="badge ${badgeClass}">${data.jenis_notifikasi}</span>`);
        }
    });
});

$('#mark-all').click(function() {
    fetch("<?= site_url('notifikasi/mark_as_read_all') ?>")
        .then(() => {
            loadNotifikasi();
            location.reload();
        });
});
</script>