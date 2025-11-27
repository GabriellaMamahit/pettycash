<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_notifikasi');
        if (!$this->fungsi->user_login()) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'notifikasi' => $this->M_notifikasi->get_notifikasi(),
            'rownotifikasi' => $this->M_notifikasi->getdatanotifikasi(),
        );

        $this->template->load('template', 'notifikasi', $data);
    }

    public function get_latest()
    {
        $notifikasi = $this->M_notifikasi->get_unread_notifikasi();
        echo json_encode($notifikasi);
    }

    public function mark_as_read($id)
    {
        $this->db->where('id_notifikasi', $id);
        $this->db->update('tb_notifikasi', ['status_notifikasi' => 1]);
        echo json_encode(['status' => 'success']);
    }
    public function mark_as_read_all()
    {
        $user = $this->fungsi->user_login();

        $this->db->where('status_notifikasi', 0);

        if ($user->level == 'user') {
            switch ($user->address_user) {
                case 'jakarta':
                    $this->db->where('jenis_saldo', 'JKT');
                    break;
                case 'balikpapan':
                    $this->db->where('jenis_saldo', 'BPP');
                    break;
                case 'karimun':
                    $this->db->where('jenis_saldo', 'TBK');
                    break;
                case 'galang':
                    $this->db->where('jenis_saldo', 'LU');
                    break;
                case 'sekupang':
                    $this->db->where_in('jenis_saldo', ['PA_SB', 'PA_BBM', 'PA_RTK']);
                    break;
                default:
                    $this->db->where('1=0');
                    break;
            }
            $this->db->where_in('jenis_notifikasi', ['Rejected', 'Penambahan']);
        } elseif ($user->level == 'finance_bdp' || $user->level == 'finance_bsgroup') {
            if ($user->level == 'finance_bdp') {
                $this->db->where_in('jenis_saldo', ['PA_SB', 'PA_BBM', 'PA_RTK', 'LU']);
            } else {
                $this->db->where_in('jenis_saldo', ['JKT', 'BPP', 'TBK']);
            }

            $this->db->where_in('jenis_notifikasi', ['Permintaan', 'Revisi']);
        } elseif (!in_array($user->level, ['development', 'accounting', 'direktur_finance', 'auditor', 'super_admin'])) {
            $this->db->where('1=0');
        }
        $this->db->update('tb_notifikasi', ['status_notifikasi' => 1]);

        echo json_encode(['status' => 'success']);
    }
}