<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_notifikasi extends CI_Model
{
    // 🔹 Notifikasi umum (digunakan di halaman daftar semua)
    public function get_notifikasi($limit = 50)
    {
        $user = $this->fungsi->user_login();
        $this->db->from('tb_notifikasi');

        // =========================
        // 🔒 FILTER SESUAI LEVEL
        // =========================
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

        $this->db->order_by('tanggal_notifikasi', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // 🔹 Untuk tampilan halaman "Semua notifikasi"
    public function getdatanotifikasi()
    {
        $user = $this->fungsi->user_login();
        $this->db->select('*');
        $this->db->from('tb_notifikasi');

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

        $this->db->order_by('tanggal_notifikasi', 'DESC');
        return $this->db->get()->result_array();
    }

    // 🔔 Ambil semua notifikasi yang BELUM dibaca
    public function get_unread_notifikasi()
    {
        $user = $this->fungsi->user_login();
        $this->db->from('tb_notifikasi');
        $this->db->where('status_notifikasi', 0); // hanya unread

        // Gunakan filter sama seperti di atas
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

        $this->db->order_by('tanggal_notifikasi', 'DESC');
        return $this->db->get()->result_array();
    }
}