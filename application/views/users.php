<style>
.default-dashboard2 .last-orders-table thead tr {
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
}
</style>

<!-- === Page Header === -->
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Users</h3>
            </div>
            <div class="col-5 d-none d-xl-block"></div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a>
                    </li>
                    <li class="breadcrumb-item">Super Admin</li>
                    <!-- <li class="breadcrumb-item">Riwayat BPKK</li> -->
                    <li class="breadcrumb-item active">Users</li>
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
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 me-3">Daftar Users</h4>
                        <a class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#tambahuser">
                            <i data-feather="plus" style="width:14px; height:14px;"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <!-- <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#tambahuser">Tambah User</button> -->
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="last-orders-table table" id="last-orders">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama</th>
                                    <th>Email </th>
                                    <th>Kantor</th>
                                    <th></th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($rowusers->result() as $key => $data) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= $data->nama_user ?></td>
                                    <td><?= $data->email_user ?></td>
                                    <td><?= $data->address_user ?></td>
                                    <td></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 mb-1">
                                            <!-- Edit Level -->
                                            <a href="#" class="btn btn-outline-warning btn-sm edit-levelakses"
                                                style="height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Edit" data-userid="<?= $data->id_user ?>"
                                                data-useremail="<?= $data->email_user ?>"
                                                data-kantorcab="<?= $data->address_user ?>"
                                                data-leveluser="<?= $data->level ?>" data-bs-toggle="modal"
                                                data-bs-target="#editaksesModal">
                                                <i data-feather="edit" style="width:12px; height:12px;"></i>Akses
                                            </a>
                                            <!-- Edit Password -->
                                            <a href="#" class="btn btn-outline-secondary btn-sm edit-password"
                                                style="height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Edit" data-userid="<?= $data->id_user ?>"
                                                data-useremail="<?= $data->email_user ?>" data-bs-toggle="modal"
                                                data-bs-target="#editPasswordModal">
                                                <i data-feather="edit" style="width:12px; height:12px;"></i>Password
                                            </a>
                                            <!-- Hapus -->
                                            <a href="#" class="btn btn-outline-danger btn-sm btnDeleteUser"
                                                data-id="<?= $data->id_user ?>"
                                                style="width:20px; height:20px; padding:2px; display:flex; align-items:center; justify-content:center;"
                                                title="Hapus">
                                                <i data-feather="trash-2" style="width:12px; height:12px;"></i>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahuser" tabindex="-1" role="dialog" aria-labelledby="tambahuser" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">TAMBAH USER BARU</h3>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" action="<?= site_url('Users/tambahusers') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-wrapper">
                            <div class="mb-3 col-md-12">
                                <label class="form-label txt-dark" for="namalengkapuser">Nama Lengkap :</label>
                                <input class="form-control" id="namalengkapuser" name="namalengkapuser" type="text"
                                    placeholder="Nama Lengkap Karyawan ...." required autocomplete="name">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label txt-dark" for="emailuser">Email :</label>
                                <input class="form-control" id="emailuser" name="emailuser" type="email"
                                    placeholder="email@biasmandirigroup.id" required autocomplete="email">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="kantorcabang">Kantor :</label>
                                    <select class="form-select" id="kantorcabang" name="kantorcabang" required>
                                        <option selected disabled value="">Pilih ...</option>
                                        <option value="batu ampar">Batu Ampar</option>
                                        <option value="sekupang">Cabang Sekupang</option>
                                        <option value="galang">Cabang Galang</option>
                                        <option value="karimun">Cabang Karimun</option>
                                        <option value="jakarta">Cabang Jakarta</option>
                                        <option value="balikpapan">Cabang Balikpapan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="departement_user">Departement :</label>
                                    <select class="form-select" id="departement_user" name="departement_user" required>
                                        <option selected disabled value="">Pilih ...</option>
                                        <option value="BS GROUP">Bs Group</option>
                                        <option value="BDP">BDP</option>
                                        <option value="BMG">Bias Mandiri Group</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="sbu_user">SBU :</label>
                                    <select class="form-select" id="sbu_user" name="sbu_user" required>
                                        <option selected disabled value="">Pilih ...</option>
                                        <option value="PBS">PBS</option>
                                        <option value="BSL">BSL</option>
                                        <option value="BSJ">BSJ</option>
                                        <option value="BM">BM</option>
                                        <option value="ESA">ESA</option>
                                        <option value="BDP">BDP</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label txt-dark" for="leveluser">Level :</label>
                                    <select class="form-select" id="leveluser" name="leveluser" required>
                                        <option selected disabled value="">Pilih ...</option>
                                        <option value="super_admin">Super Admin</option>
                                        <option value="direktur_finance">Direktur Finance</option>
                                        <option value="finance_bmg">Finance/Accounting</option>
                                        <option value="accounting">Accounting</option>
                                        <option value="finance_bdp">Finance BDP</option>
                                        <option value="finance_bsgroup">Finance BS</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label txt-dark" for="passworduser">Password :</label>
                                <input class="form-control" id="passworduser" name="passworduser" type="password"
                                    placeholder="Masukkan password ..." required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Akses User -->
<div class="modal fade" id="editaksesModal" tabindex="-1" role="dialog" aria-labelledby="editaksesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">UBAH AKSES</h3>
                <div class="modal-body" id="Editdatauser">
                    <form class="needs-validation" novalidate method="post"
                        action="<?= site_url('Users/editaksesuser') ?>">

                        <!-- hidden id -->
                        <input type="hidden" name="editUserIdakses" id="editUserIdakses">

                        <div class="mb-3 col-md-12">
                            <label class="form-label txt-dark" for="editemailuserakses">Email :</label>
                            <input class="form-control" id="editemailuserakses" name="editemailuserakses" type="email"
                                placeholder="email@biasmandirigroup.id" readonly autocomplete="username">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label txt-dark" for="kantorcabanguser">Kantor :</label>
                            <select class="form-select" id="kantorcabanguser" name="kantorcabanguser" required>
                                <option selected disabled value="">Pilih ...</option>
                                <option value="batu ampar">Batu Ampar</option>
                                <option value="sekupang">Cabang Sekupang</option>
                                <option value="galang">Cabang Galang</option>
                                <option value="karimun">Cabang Karimun</option>
                                <option value="jakarta">Cabang Jakarta</option>
                                <option value="balikpapan">Cabang Balikpapan</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label class="form-label txt-dark" for="editleveluser">Level :</label>
                            <select class="form-select" id="editleveluser" name="editleveluser" required>
                                <option selected disabled value="">Pilih ...</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="direktur_finance">Direktur Finance</option>
                                <option value="finance_bmg">Finance/Accounting</option>
                                <option value="accounting">Accounting</option>
                                <option value="finance_bdp">Finance BDP</option>
                                <option value="finance_bsgroup">Finance BS</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan Akses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h3 class="modal-header justify-content-center border-0 txt-dark">UBAH PASSWORD</h3>
                <div class="modal-body" id="Editdatapassworduser">
                    <form class="needs-validation" novalidate method="post"
                        action="<?= site_url('Users/editpassworduser') ?>">

                        <!-- hidden id -->
                        <input type="hidden" name="editUserId" id="editUserId">

                        <div class="mb-3 col-md-12">
                            <label class="form-label txt-dark" for="editemailuser">Email :</label>
                            <input class="form-control" id="editemailuser" name="editemailuser" type="email"
                                placeholder="email@biasmandirigroup.id" readonly autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label class="form-label txt-dark" for="newPassword">Password Baru :</label>
                            <input class="form-control" id="newPassword" name="newPassword" type="password"
                                placeholder="Masukkan password baru" required autocomplete="new-password">
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).on("click", ".edit-levelakses", function() {
    var iduser = $(this).data('userid');
    var emailuser = $(this).data('useremail');
    var addressuser = $(this).data('kantorcab');
    var leveluser = $(this).data('leveluser');

    // masukkan ke form modal
    $("#editUserIdakses").val(iduser);
    $("#editemailuserakses").val(emailuser);
    $("#kantorcabanguser").val(addressuser);
    $("#editleveluser").val(leveluser);
});

$(document).on("click", ".edit-password", function() {
    var iduser = $(this).data('userid');
    var emailuser = $(this).data('useremail');
    // var passworduser = $(this).data('userpassword');

    // masukkan ke form modal
    $("#editUserId").val(iduser);
    $("#editemailuser").val(emailuser);
    // $("#newPassword").val(passworduser);
});

$(document).ready(function() {
    $(".btnDeleteUser").click(function(e) {
        e.preventDefault();

        var userId = $(this).data("id");

        Swal.fire({
            title: "Yakin ingin menghapus user ini?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#376464",
            cancelButtonColor: "#c06240",
            reverseButtons: true,
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke controller hapus
                window.location.href = "<?= site_url('users/delete/') ?>" + userId;
            }
        });
    });
});
</script>