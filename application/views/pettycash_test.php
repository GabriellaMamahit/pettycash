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
                <h3>Dashboard</h3>
            </div>
            <div class="col-6 d-none d-xl-block">

            </div>
            <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Default</li>
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
                    <div class="row mt-3 ">
                        <div class="col-sm-8">
                            <div class="d-flex">

                                <div class="social-img-wrap">
                                    <div class="social-img"><img
                                            src="<?= base_url() ?>assets/images/dashboard-8/profile.png" alt="profile">
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
                        <div class="col-sm-4 float-sm-end">
                            <div class="float-sm-end">

                                <div class="d-flex">

                                    <h5><a href="javascript:;">Pembelanjaan </a></h5><span class="f-light ms-2"> yang
                                        sudah di settlement</span>

                                </div>
                                <div class="d-flex mt-2">
                                    <h1>Rp. 1.000.000</h1>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- <div class="d-flex mt-3">

            <h5><a href="javascript:;">Pembelanjaan </a></h5></br><span class="f-light ms-2"> yang sudah di settlement</span>

          </div>
          <div class="d-flex mt-2">
            <h1>Rp. 1.000.000</h1>
          </div> -->
                    <div class="progress-showcase row mt-3">
                        <div class="col">
                            <div class="progress progress-border-primary">
                                <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar"
                                    style="width: 30%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
                    </div>
                    <div class="social-details">

                        <ul class="social-follow">
                            <li>
                                <h5 class="mb-0">5.000.000</h5><span class="f-light">Saldo Petty Cash</span>
                            </li>
                            <li>
                                <h5 class="mb-0">1.000.000</h5><span class="f-light">Pembelanjaan</span>
                            </li>
                            <li>
                                <h5 class="mb-0">5 Dokumen</h5><span class="f-light">Settlement</span>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-pill btn-primary btn-air-primary mt-3 btn-exp" type="button"
                        style="width: 50%;">Tambah Belanja</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid ecommerce-dashboard">
    <div class="card">
        <div class="card-header">
            <div class="header-top">
                <h4>History</h4>
                <div class="dropdown icon-dropdown setting-menu">
                    <button class="btn dropdown-toggle" id="userdropdown34" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg>
                            <use href="<?= base_url() ?>assets/svg/icon-sprite.svg#setting"> </use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown34"><a
                            class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly </a><a
                            class="dropdown-item" href="#">Yearly</a></div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive custom-scrollbar">
                <table class="table monthly-selling">
                    <thead>
                        <tr>
                            <th>Deskripsi/No</th>
                            <th>Masuk </th>
                            <th>Keluar </th>
                            <th class="text-end">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="user-data">
                                    <div class="product-image"><img src="../assets/images/dashboard-2/product/20.png"
                                            alt="product"></div>
                                    <div><a href="javascript:;">
                                            <h4>Iphone</h4>
                                        </a><span>#654892 | 2025-00-00</span></div>
                                </div>
                            </td>
                            <td class="txt-primary">3.000.000</td>
                            <td>-</td>
                            <td>6.000.000</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-data">
                                    <div class="product-image"><img src="../assets/images/dashboard-2/product/20.png"
                                            alt="product"></div>
                                    <div><a href="javascript:;">
                                            <h4>Iphone</h4>
                                        </a><span>#654892 | 2025-00-00</span></div>
                                </div>
                            </td>
                            <td class="txt-primary">-</td>
                            <td class="txt-danger">500.000</td>
                            <td>5.500.000</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-data">
                                    <div class="product-image"><img src="../assets/images/dashboard-2/product/20.png"
                                            alt="product"></div>
                                    <div><a href="javascript:;">
                                            <h4>Iphone</h4>
                                        </a><span>#654892 | 2025-00-00</span></div>
                                </div>
                            </td>
                            <td class="txt-primary">-</td>
                            <td class="txt-primary">500.000</td>
                            <td>5.000.000</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->