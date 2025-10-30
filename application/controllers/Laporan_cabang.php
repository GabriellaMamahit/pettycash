<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_cabang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_pettycash');
    }

    public function index()
    {
        $user           = $this->fungsi->user_login();
        $address_user     = $user->address_user;
        $level             = $user->level;
        $transaksi      = $this->M_pettycash->getMutasiCabang($address_user, $level, 'ASC');

        $data = array(
            'judul' => "Petty Cash | Data Transaksi Cabang",
            'rowpengeluaranbpkk' => $transaksi,
        );

        $this->template->load('template', 'laporan_cabang', $data);
    }
}