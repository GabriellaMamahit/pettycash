<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Laporan Petty Cash Cabang</h3>
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
                    <li class="breadcrumb-item active">Laporan Cabang</li>
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
                        <h4>Daftar Data Transaksi - <?= date('F Y'); ?></h4>
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
                                    <th>Tanggal</th>
                                    <th>Keterangan </th>
                                    <th>Total Debet</th>
                                    <th></th>
                                    <th>Total Kredit</th>
                                    <th>Sisa Saldo</th>
                                    <!-- <th>Status</th> -->
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowpengeluaranbpkk as $data) { ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?>.</td>
                                        <td><?= date('d/m/Y', strtotime(str_replace('/', '-', $data['tanggal']))); ?></td>
                                        <td>
                                            <div class="user-data">
                                                <div><a href="javascript:void(0)" class="text-dark text-decoration-none">
                                                        <p><?= $data['keterangan']; ?></p>
                                                    </a><span
                                                        class="<?= $data['jenis_transaksi'] === 'Kredit' ? 'text-warning' : 'text-success' ?>"
                                                        style="font-size:12px;">
                                                        <?= $data['jenis_transaksi'] === 'Kredit' ? $data['no_bpkk_cab'] : $data['no_pettycash']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= isset($data['total_debet_cab']) && $data['total_debet_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_debet_cab'], 0, ',', '.')
                                                : '-'; ?></td>
                                        <td></td>
                                        <td><?= isset($data['total_kredit_cab']) && $data['total_kredit_cab'] !== null
                                                ? 'Rp. ' . number_format($data['total_kredit_cab'], 0, ',', '.')
                                                : '-'; ?></td>
                                        <td>
                                            <?= isset($data['sisa_saldo']) && $data['sisa_saldo'] !== null
                                                ? 'Rp. ' . number_format($data['sisa_saldo'], 0, ',', '.')
                                                : '-'; ?>
                                        </td>

                                        <td></td>
                                        <td class="text-center">
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
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- <a href="#" class="btn btn-outline-primary btn-sm"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Print">
                                                <i data-feather="printer" style="width:12px; height:12px;"></i>
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
                    <pre><?= base_url(); ?></pre>
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
    const BASE_URL = "<?= base_url(); ?>";
</script>
<script>
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
        <iframe src="${BASE_URL}/uploads/${folder}/${data.file}" 
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

        const formatRupiahText = angka => {
            if (!angka) return 'Rp. 0';
            angka = angka.toString().replace(/[^,\d]/g, '');
            const parts = angka.split(',');
            const sisa = parts[0].length % 3;
            let rupiah = parts[0].substring(0, sisa);
            const ribuan = parts[0].substring(sisa).match(/\d{3}/g);
            if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
            return 'Rp. ' + (parts[1] ? rupiah + ',' + parts[1] : rupiah);
        };

        // Helper untuk update text tanpa trigger reflow berulang
        function updateTextContent(el, text) {
            window.requestAnimationFrame(() => {
                el.textContent = text;
            });
        }

        function checkSaldoCukup() {
            const rawValue = parseInt(document.getElementById('totalDebetRaw').value || 0);
            const addressUser = totalDebet.getAttribute('data-address_user');
            let saldo = 0;

            if (addressUser === 'sekupang') {
                const selected = document.querySelector('input[name="jenis_bpkk"]:checked');
                if (!selected) {
                    saldoAlert.style.display = 'block';
                    updateTextContent(saldoAlert, 'Silakan pilih jenis petty cash terlebih dahulu.');
                    totalDebet.disabled = true;
                    submitBtn.disabled = true;
                    return;
                }
                saldo = parseInt(selected.getAttribute('data-saldo') || 0);
                totalDebet.disabled = false;
            } else {
                saldo = parseInt(totalDebet.getAttribute('data-saldo') || 0);
            }

            if (rawValue > saldo) {
                saldoAlert.style.display = 'block';
                updateTextContent(saldoAlert, 'Saldo petty cash tidak mencukupi.');
                submitBtn.disabled = true;
            } else {
                saldoAlert.style.display = 'none';
                submitBtn.disabled = false;
            }
        }
        // **Tambahkan ini supaya bisa dipanggil dari HTML (oninput)**
        window.checkSaldoCukup = checkSaldoCukup;

        // Listener jenis_bpkk
        $(document).on('change', 'input[name="jenis_bpkk"]', () => {
            const selected = document.querySelector('input[name="jenis_bpkk"]:checked');
            totalDebet.disabled = !selected;
            if (selected) addressCab.value = selected.value;
            checkSaldoCukup();
        });

        // === Tambahkan Class Wrapper ===
        const wrapper = document.querySelector('.summary-wrapper');
        if (wrapper) {
            const count = wrapper.querySelectorAll('.card-inner').length;
            const classMap = {
                1: 'one-card',
                2: 'two-card',
                3: 'three-card',
                4: 'four-card',
                5: 'five-card',
                6: 'six-card',
                7: 'seven-card'
            };
            if (classMap[count]) wrapper.classList.add(classMap[count]);
        }

        // Hilangkan warning Chrome (passive listener)
        window.addEventListener('wheel', () => {}, {
            passive: true
        });
    });
</script>