<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_pettycash');
    }

    public function index()
    {
        $user = $this->fungsi->user_login();
        $address_user = $user->address_user;
        $level = $user->level;

        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowdatatransaksi' => $this->M_pettycash->getdatadebet($address_user, $level),
        );

        $this->template->load('template', 'data_transaksi', $data);
    }
}