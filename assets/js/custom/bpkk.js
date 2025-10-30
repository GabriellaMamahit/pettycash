// === VIEW DATA BPKK ===
$(document).on('click', '[data-bs-target="#viewdatabpkk"]', function () {
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

    modal.find('td').each(function () {
        const label = $(this).text().trim();
        if (infoFields[label] !== undefined) $(this).next().text(': ' + infoFields[label]);
    });

    // Badge status
    statusBadge.removeClass().addClass('badge fw-bold text-white text-uppercase')
        .addClass(data.status === 'In progress' ? 'bg-secondary' :
            data.status === 'Rejected' ? 'bg-danger' : 'bg-warning')
        .text(data.status || 'N/A');

    // Hapus preview dulu
    const preview = $('#pratinjauGambar2');
    preview.empty();

    // Tambahkan iframe setelah modal benar-benar terbuka
    modal.one('shown.bs.modal', function () {
        if (!data.file.trim()) {
            preview.html(`<p style="color:red;font-weight:bold;text-align:center;">
                Dokumen Pendukung belum di-upload.</p>`);
        } else {
            let fileUrl = BASE_URL + "uploads/BPKK/" + data.jenisSaldo + "/" + data.file;
            preview.html(`
                <p style="font-weight:bold;text-align:center;">Dokumen: ${data.file}</p>
                <iframe src="${fileUrl}" width="100%" height="450px" style="border:1px solid #ccc;" loading="lazy"></iframe>
            `);
        }
    });
});

$('#viewdatabpkk').on('hidden.bs.modal', () => $('#pratinjauGambar2').empty());

// === BUTTON PROSES ===
$(document).on('click', '#btn-proses', function (e) {
    e.preventDefault();
    const id = $(this).data('id_bpkk');
    const status = $(this).data('statusbpkk');

    if (!id) {
        Swal.fire({ icon: 'error', title: 'ID tidak ditemukan', text: 'ID BPKK tidak ditemukan' });
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
            $.post(SITE_URL + "bukti_pengeluaran_kas_kecil/proses_bpkk", { id_bpkk: id, status: status })
                .done(res => {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, confirmButtonColor: "#376464" })
                        .then(() => location.reload());
                })
                .fail(xhr => {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memproses: ' + xhr.responseText });
                });
        }
    });
});

// === BUTTON PROSES REJECTED ===
$(document).on('click', '#btn-prosesrerjected', function (e) {
    e.preventDefault();
    const id = $(this).data('id_bpkk');
    const status = $(this).data('statusbpkk');
    const jenis_saldo = $(this).data('jenis_saldo');
    const no_pettycash = $(this).data('no_pettycash');

    if (!id) {
        Swal.fire({ icon: 'error', title: 'ID tidak ditemukan', text: 'ID BPKK tidak ditemukan' });
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
            $.post(SITE_URL + "bukti_pengeluaran_kas_kecil/proses_bpkk_rejected", {
                id_bpkk: id,
                status: status,
                jenis_saldo: jenis_saldo,
                no_pettycash: no_pettycash
            })
                .done(res => {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, confirmButtonColor: "#376464" })
                        .then(() => location.reload());
                })
                .fail(xhr => {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memproses: ' + xhr.responseText });
                });
        }
    });
});

// === EDIT DATA BPKK ===
$(document).on('click', '.edit-databpkk', function () {
    const modal = $("#editdatabpkk");
    const saldo = parseInt($(this).data('saldo')) || 0;
    const total = parseInt($(this).data('totalbpkk')) || 0;

    modal.find("#idbpkk").val($(this).data('idbpkk'));
    modal.find("#no-permintaan_bpkk-display").val($(this).data('nobpkk'));
    modal.find("#jenissaldobpkk").val($(this).data('jenissaldo'));
    modal.find("#no_pc_rembes").val($(this).data('pc-rembesment'));
    modal.find("#keteranganpermintaanbpkk").val($(this).data('ketbpkk'));

    modal.find("#edit-totalDebet").val(formatRupiahText(total)).attr('data-saldo', saldo);
    modal.find("#edit-totalDebetRaw").val(total);
    modal.find("#edit-totalDebetOld").val(total);

    const fileName = $(this).data('filebpkk');
    const jenisSaldo = $(this).data('jenissaldo');
    const previewArea = modal.find("#pratinjauGambar3");
    previewArea.empty();

    modal.one('shown.bs.modal', function () {
        if (fileName) {
            const fileUrl = BASE_URL + "uploads/BPKK/" + jenisSaldo + "/" + fileName;
            previewArea.html(`
                <p style="font-weight:bold;text-align:center;">
                    File lama: <a href="${fileUrl}" target="_blank">${fileName}</a>
                </p>
                <iframe src="${fileUrl}" width="100%" height="450px" style="border:1px solid #ccc;" loading="lazy"></iframe>
            `);
        } else {
            previewArea.html(`<p style="color:red;font-weight:bold;text-align:center;">
                Dokumen Pendukung belum di-upload.
            </p>`);
        }

        if (typeof checkSaldoCukup === 'function') checkSaldoCukup();
    });
});

function checkSaldoCukup() {
    const input = document.getElementById('edit-totalDebet');
    const raw = parseInt(document.getElementById('edit-totalDebetRaw').value || 0);
    const old = parseInt(document.getElementById('edit-totalDebetOld').value || 0);
    const saldo = parseInt(input.getAttribute('data-saldo') || 0);
    const alertBox = document.getElementById('saldo-warning');
    const submitBtn = document.getElementById('submitBtn');

    if (raw > old) {
        const kebutuhan = raw - old;
        const kekurangan = kebutuhan - saldo;

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

// === CHECKBOX MASS APPROVE ===
document.addEventListener("DOMContentLoaded", function () {
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
        if (anyChecked) enableApproveButton(); else disableApproveButton();
    }

    checkAll.addEventListener("change", function () {
        const checkItems = document.querySelectorAll(".checkItem");
        checkItems.forEach(item => { item.checked = checkAll.checked; });
        updateButtonState();
    });

    document.addEventListener("change", function (e) {
        if (e.target.classList.contains("checkItem")) {
            const allItems = document.querySelectorAll(".checkItem");
            const checkedItems = document.querySelectorAll(".checkItem:checked");
            checkAll.checked = (allItems.length > 0 && allItems.length === checkedItems.length);
            updateButtonState();
        }
    });

    btnApprove.addEventListener("click", function (e) {
        e.preventDefault();

        const selectedItems = document.querySelectorAll(".checkItem:checked");
        if (selectedItems.length === 0) {
            Swal.fire({ icon: "warning", title: "Oops...", text: "Tidak ada data yang dipilih!", confirmButtonColor: "#376464" });
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
                        url: SITE_URL + "bukti_pengeluaran_kas_kecil/proses_bpkk",
                        type: "POST",
                        data: { id_bpkk: item.value },
                        dataType: "json",
                        success: function (res) { console.log(`BPKK ${item.value} -> ${res.status}`); },
                        error: function () { console.error(`BPKK ${item.value} -> ERROR`); },
                        complete: function () {
                            processed++;
                            if (processed === selectedItems.length) {
                                Swal.fire({ icon: "success", title: "Berhasil", text: "Semua data berhasil diproses.", confirmButtonColor: "#376464" })
                                    .then(() => { location.reload(); });
                            }
                        }
                    });
                });
            }
        });
    });

    disableApproveButton();
});

// === FILE UPLOAD VALIDATION ===
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('formFile');
    const submitBtn = document.getElementById('submitBtn');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const maxSize = 1 * 1024 * 1024; // 1 MB
            const fileName = file.name.toLowerCase();
            const isPDF = fileName.endsWith('.pdf');

            if (!isPDF) {
                Swal.fire({ icon: 'error', title: 'Format File Salah!', text: 'File harus dalam format PDF.', confirmButtonColor: '#c06240' });
                this.value = '';
                submitBtn.disabled = true;
                return;
            }

            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'Ukuran File Terlalu Besar!', text: 'Maksimal ukuran file adalah 1 MB.', confirmButtonColor: '#c06240' });
                this.value = '';
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        }
    });
});
