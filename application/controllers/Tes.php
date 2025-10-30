<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tes extends CI_Controller
{
    public function index()
    {;

        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK"
        );

        $this->load->view('template_ols');
    }
}