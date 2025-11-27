<?php
defined('BASEPATH') or exit('No direct script access allowed');

function get_user_level()
{
    $ci = &get_instance();
    return strtolower($ci->session->userdata('level'));
}

function in_roles($allowed_roles = [])
{
    return in_array(get_user_level(), $allowed_roles);
}

function akses_grouped()
{
    return [
        'akses_data_transaksi' => ['user', 'development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'direktur_finance'],
        'akses_pengajuan_pettycash'  => ['user', 'development', 'super_admin', 'direktur_finance'],
        'akses_kelola_saldo'   => ['development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'direktur_finance'],
        'akses_laporan_pc'     => ['development', 'super_admin', 'finance_bdp', 'finance_bsgroup', 'finance_bmg', 'accounting', 'direktur_finance'],
        'akses_users_menu'     => ['development', 'super_admin'],
    ];
}

function can_access($key)
{
    $akses = akses_grouped();
    return in_roles($akses[$key] ?? []);
}