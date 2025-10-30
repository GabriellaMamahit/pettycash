<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Ambil level user sekarang dari session
function get_user_level()
{
    $ci = &get_instance();
    return strtolower($ci->session->userdata('level'));
}

// Cek apakah level user termasuk dalam daftar level yang diperbolehkan
function in_roles($allowed_roles = [])
{
    return in_array(get_user_level(), $allowed_roles);
}

// Daftar level untuk setiap jenis akses
function akses_grouped()
{
    return [
        'akses_data_transaksi' => ['user', 'development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'direktur_finance'],
        'akses_pengajuan_pettycash'  => ['user', 'development', 'super_admin', 'direktur_finance'],
        'akses_kelola_saldo'   => ['development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'direktur_finance'],
        'akses_laporan_pc'     => ['development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'accounting', 'direktur_finance'],
        'akses_users_menu'     => ['development', 'super_admin'], // hanya dev & super_admin
    ];
}

// Optional: fungsi cepat untuk dipakai di view
function can_access($key)
{
    $akses = akses_grouped();
    return in_roles($akses[$key] ?? []);
}