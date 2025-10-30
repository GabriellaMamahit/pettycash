<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bpkk extends CI_Model
{
    // public function get_saldo_by_cabang($cabang)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_saldo');
    //     $this->db->where('jenis_saldo', $cabang);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    // public function get_total_kredit_by_jenis_saldo($jenis_saldo)
    // {
    //     $this->db->select_sum('total_kredit_cab', 'total_kredit');
    //     $this->db->from('tb_bpkk_cab');
    //     $this->db->where('jenis_saldo', $jenis_saldo);
    //     $this->db->where('status_cab', 'In progress'); // atau kondisi lain sesuai kebutuhan
    //     return $this->db->get()->row();
    // }

    // public function generateNoBpkk($kode_cabang)
    // {
    //     $bulan = date('m');
    //     $tahun = date('Y');

    //     $this->db->like('no_bpkk', '-BPKK/' . $kode_cabang . '/' . $bulan . '/' . $tahun, 'both');
    //     $this->db->order_by('no_bpkk', 'DESC');
    //     $query = $this->db->get('tb_nobpkk', 1);

    //     $last_number = 0;

    //     if ($query->num_rows() > 0) {
    //         $last_no = $query->row()->no_bpkk;

    //         if (preg_match('/^(\d{4})\-BPKK\/' . preg_quote($kode_cabang, '/') . '\/' . $bulan . '\/' . $tahun . '$/', $last_no, $matches)) {
    //             $last_number = (int) $matches[1];
    //         }
    //     }

    //     $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    //     return "{$new_number}-BPKK/{$kode_cabang}/{$bulan}/{$tahun}";
    // }

    public function getMutasiCabang($address_user, $level)
    {
        // Tentukan akses cabang/jenis saldo sesuai level user
        $akses = [];
        if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg'])) {
            $akses = ['JKT', 'BPP', 'TBK', 'LU', 'PA_BBM', 'PA_SB', 'PA_RTK']; // Semua
        } elseif ($level == 'finance_bdp') {
            $akses = ['LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
        } elseif ($level == 'finance_bsgroup') {
            $akses = ['JKT', 'BPP', 'TBK'];
        } elseif ($level == 'user') {
            switch (strtolower($address_user)) {
                case 'jakarta':
                    $akses = ['JKT'];
                    break;
                case 'balikpapan':
                    $akses = ['BPP'];
                    break;
                case 'karimun':
                    $akses = ['TBK'];
                    break;
                case 'galang':
                    $akses = ['LU'];
                    break;
                case 'sekupang':
                    $akses = ['PA_BBM', 'PA_SB', 'PA_RTK'];
                    break;
            }
        }

        $this->db->select('*');
        $this->db->from('tb_data_mutasi');
        if (!empty($akses)) {
            $this->db->where_in('jenis_saldo', $akses);
        }
        $this->db->order_by('tanggal', 'DESC');

        return $this->db->get()->result_array();
    }

    public function getbpkk_cab($address_user, $level)
    {
        // Mapping untuk akses cabang berdasarkan level user
        $akses = [];
        if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg'])) {
            $akses = ['JKT', 'BPP', 'TBK', 'LU', 'PA_BBM', 'PA_SB', 'PA_RTK']; // Semua
        } elseif ($level == 'finance_bdp') {
            $akses = ['LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
        } elseif ($level == 'finance_bsgroup') {
            $akses = ['JKT', 'BPP', 'TBK'];
        } elseif ($level == 'user') {
            switch (strtolower($address_user)) {
                case 'jakarta':
                    $akses = ['JKT'];
                    break;
                case 'balikpapan':
                    $akses = ['BPP'];
                    break;
                case 'karimun':
                    $akses = ['TBK'];
                    break;
                case 'galang':
                    $akses = ['LU'];
                    break;
                case 'sekupang':
                    $akses = ['PA_BBM', 'PA_SB', 'PA_RTK'];
                    break;
            }
        }

        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where_in('status_cab', ['In Progress', 'Rejected']);
        if (!empty($akses)) {
            $this->db->where_in('jenis_saldo', $akses);
        }
        // Urutkan berdasarkan tanggal terbaru (atau bisa id_bpkk DESC jika ada)
        // $this->db->order_by('id_bpkk_cab', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getbpkk($address_user, $level)
    {
        // Menentukan cabang/jenis_saldo mana saja yang boleh diakses user
        $akses = [];
        if (in_array($level, ['super_admin', 'direktur_finance', 'development', 'finance_bmg'])) {
            $akses = ['JKT', 'BPP', 'TBK', 'LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
        } elseif ($level == 'finance_bdp') {
            $akses = ['LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];
        } elseif ($level == 'finance_bsgroup') {
            $akses = ['JKT', 'BPP', 'TBK'];
        } elseif ($level == 'user') {
            switch (strtolower($address_user)) {
                case 'jakarta':
                    $akses = ['JKT'];
                    break;
                case 'balikpapan':
                    $akses = ['BPP'];
                    break;
                case 'karimun':
                    $akses = ['TBK'];
                    break;
                case 'galang':
                    $akses = ['LU'];
                    break;
                case 'sekupang':
                    $akses = ['PA_BBM', 'PA_SB', 'PA_RTK'];
                    break;
            }
        }

        $this->db->select('tb_bpkk_cab.*, tb_saldo.saldo_pettycash, tb_notifikasi.ket_notifikasi');
        $this->db->from('tb_bpkk_cab');
        $this->db->join('tb_saldo', 'tb_saldo.jenis_saldo = tb_bpkk_cab.jenis_saldo', 'left');
        $this->db->join('tb_notifikasi', 'tb_notifikasi.no_pettycash = tb_bpkk_cab.no_bpkk_cab AND tb_bpkk_cab.status_cab = "Rejected"', 'left');

        // HAPUS filter status supaya ambil semua status
        // $this->db->where_in('tb_bpkk_cab.status_cab', ['In Progress', 'Rejected']);

        if (!empty($akses)) {
            $this->db->where_in('tb_bpkk_cab.jenis_saldo', $akses);
        }
        // $this->db->order_by('tb_bpkk_cab.id_bpkk_cab', 'DESC');
        $this->db->order_by("
    CASE 
        WHEN tb_bpkk_cab.status_cab IN ('Revisi', 'Rejected') THEN 1
        WHEN tb_bpkk_cab.status_cab = 'In progress' THEN 2
        WHEN tb_bpkk_cab.status_cab = 'Approved' THEN 3
        ELSE 4
    END
", "ASC", FALSE);

        // Urutan tambahan dalam tiap grup status: terbaru dulu
        $this->db->order_by('tb_bpkk_cab.id_bpkk_cab', 'DESC');
        return $this->db->get()->result_array();
    }


    public function getLastNoPettyCashBySaldo($jenis_saldo)
    {
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->order_by('id_nopettycash', 'DESC');
        $query = $this->db->get('tb_nopettycash', 1);

        if ($query->num_rows() > 0) {
            return $query->row()->no_petty_cash;
        }

        return null;
    }

    public function getsaldopettycash($jenis_saldo)
    {
        $this->db->select('saldo_pettycash');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get('tb_saldo', 1);

        if ($query->num_rows() > 0) {
            return $query->row()->saldo_pettycash;
        }

        return 0;
    }


    public function notifikasiupdatebpkk($table, $data2)
    {
        return $this->db->insert($table, $data2);
    }

    public function pengeluaranbpkk($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function riwayatbpkk($table, $data2)
    {
        return $this->db->insert($table, $data2);
    }

    public function nobpkk($table, $data3)
    {
        return $this->db->insert($table, $data3);
    }
    public function tambahdatamutasi($table, $data4)
    {
        return $this->db->insert($table, $data4);
    }

    public function tambahsisasaldopending($table, $data5)
    {
        return $this->db->insert($table, $data5);
    }

    public function updateSaldoCabang($jenis_saldo, $jumlah)
    {
        $this->db->set('saldo_pettycash', 'saldo_pettycash - ' . (float)$jumlah, FALSE);
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->update('tb_saldo');
    }

    // Ambil data pengeluaran berdasarkan ID
    public function getPengeluaranById($idbpkk)
    {
        return $this->db->get_where('tb_bpkk_cab', ['id_bpkk_cab' => $idbpkk])->row();
    }

    public function getPermintaanSaldoByNo($no_pettycash)
    {
        return $this->db->get_where('tb_permintaan_saldo', ['no_pettycash' => $no_pettycash])->row();
    }

    public function getSaldoCabang($jenis_saldo)
    {
        $this->db->select('saldo_pettycash');
        $this->db->from('tb_saldo');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get();

        $result = $query->row();
        return $result ? (int)$result->saldo_pettycash : 0;
    }

    // Sesuaikan saldo berdasarkan selisih
    public function adjustSaldoCabang($jenis_saldo, $selisih)
    {
        $this->db->set('saldo_pettycash', 'saldo_pettycash - ' . (float)$selisih, FALSE);
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->update('tb_saldo');
    }

    // public function adjustPermintaanSaldo($no_rembesment, $selisih)
    // {
    //     $this->db->set('saldo_pettycash', 'saldo_pettycash - ' . (int)$selisih, FALSE);
    //     $this->db->where('no_pettycash', $no_rembesment);
    //     $this->db->update('tb_permintaan_saldo');
    // }

    public function adjustPermintaanSaldo($no_rembesment, $selisih)
    {
        $selisih = (int) $selisih;
        // pakai + bukan -, supaya selisih positif nambah, selisih negatif ngurang
        $this->db->set('saldo_pettycash', 'saldo_pettycash + (' . $selisih . ')', FALSE);
        $this->db->where('no_pettycash', $no_rembesment);
        $this->db->update('tb_permintaan_saldo');
    }



    public function updatebpkk($id_bpkk, $data, $table)
    {
        $this->db->where('id_bpkk_cab', $id_bpkk);
        $this->db->update($table, $data);
    }

    public function updatebpkkmutasi($nobpkk, $data2, $table)
    {
        $this->db->where('no_bpkk_cab', $nobpkk);
        $this->db->update($table, $data2);
    }

    public function updatetotalkreditpending($nobpkk, $data3, $table)
    {
        $this->db->where('no_bpkk_cab', $nobpkk);
        $this->db->update($table, $data3);
    }

    public function updateSisaSaldoBerantai($no_pettycash, $no_bpkk)
    {
        $this->db->where('no_pettycash', $no_pettycash);
        $this->db->order_by('id_sisasaldo', 'ASC');
        $data = $this->db->get('tb_sisasaldo')->result();

        if (empty($data)) return;

        // Cari index baris yang diedit (gunakan trim untuk aman)
        $startIndex = null;
        foreach ($data as $i => $row) {
            if (trim($row->no_bpkk_cab) == trim($no_bpkk)) {
                $startIndex = $i;
                break;
            }
        }

        if ($startIndex === null) return;

        // Tentukan saldo awal sebelum perhitungan ulang
        if ($startIndex > 0) {
            // Ambil saldo dari baris sebelumnya apa adanya
            $sisa = (float)$data[$startIndex - 1]->sisa_saldo;
        } else {
            // Kalau baris pertama, ambil sisa + total_kredit (kolom sesuai DB)
            $sisa = (float)$data[$startIndex]->sisa_saldo + (float)$data[$startIndex]->total_kredit_cab;
        }

        // Loop update — gunakan kolom total_kredit_cab sesuai DB
        for ($i = $startIndex; $i < count($data); $i++) {
            // PERHATIAN: pakai nama kolom yang benar
            $total_kredit = isset($data[$i]->total_kredit_cab) ? (float)$data[$i]->total_kredit_cab : 0;
            $sisa -= $total_kredit;

            // Debug (bisa dihapus setelah fix)
            // echo "Update ID {$data[$i]->id_sisasaldo} (No BPKK {$data[$i]->no_bpkk_cab}) → kredit: {$total_kredit} → sisa baru = {$sisa}<br>";

            $this->db->where('id_sisasaldo', $data[$i]->id_sisasaldo);
            $this->db->update('tb_sisasaldo', ['sisa_saldo' => $sisa]);
        }
    }


    public function updateStatusBpkk($id_bpkk, $data)
    {
        $this->db->where('id_bpkk_cab', $id_bpkk); // pakai ID sesuai kebutuhan
        return $this->db->update('tb_bpkk_cab', $data);
    }

    public function getAllMutasiByCabang($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_data_mutasi');
        $this->db->where('jenis_saldo', $kode_cabang);
        $this->db->order_by('tanggal', 'ASC');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function getMutasiByCabang($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_data_mutasi');
        $this->db->where('jenis_saldo', $kode_cabang);
        // $this->db->where('status_mutasi', 'Open');
        $this->db->group_start();
        $this->db->where('status_mutasi', 'Open');
        $this->db->or_where('status_cab', 'Rejected');
        $this->db->group_end();
        $this->db->order_by('tanggal', 'ASC');
        $data = $this->db->get();
        return $data->result_array();
    }

    // public function getMutasiByCabang($kode_cabang)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_data_mutasi');
    //     $this->db->join('tb_bpkk_cab', 'tb_bpkk_cab.jenis_saldo = tb_data_mutasi.jenis_saldo', 'left');
    //     $this->db->where('jenis_saldo', $kode_cabang);
    //     $this->db->where('status_mutasi', 'Open');
    //     $this->db->where('m.status_mutasi', 'Open');
    //     $this->db->order_by('tanggal', 'ASC');
    //     $data = $this->db->get();
    //     return $data->result_array();
    // }

    public function generateNoBpkk($kode_cabang)
    {
        $bulan = date('m');
        $tahun = date('Y');

        $this->db->like('no_bpkk', '-BPKK/' . $kode_cabang . '/' . $bulan . '/' . $tahun, 'both');
        $this->db->order_by('no_bpkk', 'DESC');
        $query = $this->db->get('tb_nobpkk', 1);

        $last_number = 0;

        if ($query->num_rows() > 0) {
            $last_no = $query->row()->no_bpkk;

            if (preg_match('/^(\d{4})\-BPKK\/' . preg_quote($kode_cabang, '/') . '\/' . $bulan . '\/' . $tahun . '$/', $last_no, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
        return "{$new_number}-BPKK/{$kode_cabang}/{$bulan}/{$tahun}";
    }

    public function get_pengeluaran_per_jenis_saldo_bulanan()
    {
        $bulan_ini = date('m');
        $tahun_ini = date('Y');

        $this->db->select('jenis_saldo, COUNT(*) as total');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('MONTH(tgl_kredit_cab)', $bulan_ini);
        $this->db->where('YEAR(tgl_kredit_cab)', $tahun_ini);
        $this->db->group_by('jenis_saldo');
        $query = $this->db->get();

        return $query->result_array(); // langsung balikin hasil
    }

    public function get_rekap_tahunan_per_cabang()
    {
        $tahun_ini = date('Y');

        $this->db->select("jenis_saldo, MONTH(tgl_kredit_cab) as bulan, COUNT(*) as total");
        $this->db->from("tb_bpkk_cab");
        $this->db->where("YEAR(tgl_kredit_cab)", $tahun_ini);
        $this->db->group_by("jenis_saldo, bulan");
        $query = $this->db->get();
        $result = $query->result_array();

        // susun data: jenis_saldo -> bulan (1-12) -> total
        $all_saldo = ['JKT', 'TBK', 'BPP', 'LU', 'PA_BBM', 'PA_SB', 'PA_RTK'];

        $rekap = [];
        foreach ($all_saldo as $saldo) {
            for ($i = 1; $i <= 12; $i++) {
                $rekap[$saldo][$i] = 0; // default 0
            }
        }

        foreach ($result as $row) {
            $rekap[$row['jenis_saldo']][$row['bulan']] = (int)$row['total'];
        }

        return $rekap;
    }

    public function getbudgetsaldo($cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_saldo_cabang');
        $this->db->where('jenis_saldo', $cabang);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_saldo_by_cabang($cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_saldo');
        $this->db->where('jenis_saldo', $cabang);
        $query = $this->db->get();
        return $query->row();
    }

    public function getsisasaldo($jenis_saldo)
    {
        $this->db->select('saldo_pettycash');
        $this->db->from('tb_saldo');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get();
        $row = $query->row();

        return $row ? (float)$row->saldo_pettycash : 0;
    }

    public function get_sisa_saldo_pending_by_bpkk($no_bpkk_cab, $jenis_saldo)
    {
        $this->db->select('sisa_saldo');
        $this->db->from('tb_sisasaldo');
        $this->db->where('no_bpkk_cab', $no_bpkk_cab);
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('status_saldo', 'Pending');
        $query = $this->db->get();
        $row = $query->row_array();
        return $row ? $row['sisa_saldo'] : 0;
    }

    public function get_total_kredit_by_jenis_saldo($jenis_saldo)
    {
        $this->db->select_sum('total_kredit_cab', 'total_kredit');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('rembesment', 'Open');
        $this->db->where('status_cab', 'In progress'); // atau kondisi lain sesuai kebutuhan
        return $this->db->get()->row();
    }

    // public function get_total_kredit_open_by_cabang($jenis_saldo)
    // {
    //     $this->db->select_sum('total_kredit_cab', 'total_kredit_open');
    //     $this->db->from('tb_bpkk_cab');
    //     $this->db->where('jenis_saldo', $jenis_saldo);
    //     $this->db->where('rembesment', 'Close');
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function hitungStatusInprogress($jenis_saldo)
    {
        $this->db->from('tb_bpkk_cab');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('status_cab', 'In progress');
        $count = $this->db->count_all_results();

        return $count;
    }

    public function hitungStatusApproved($jenis_saldo)
    {
        // 1. Ambil no_pettycash terakhir dari tb_data_mutasi
        $this->db->select('no_pettycash');
        $this->db->from('tb_data_mutasi');
        $this->db->where('jenis_transaksi', 'Debet');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->order_by('id_mutasi', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get()->row();

        if (!$query) {
            return 0;
        }

        $last_no_pettycash = $query->no_pettycash;

        // ✅ Debug sementara
        // echo "Last PC: " . $last_no_pettycash;
        // exit;

        // 2. Hitung status Approved di tb_bpkk_cab
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pettycash', $last_no_pettycash);
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('status_cab', 'Approved');
        $count = $this->db->count_all_results();

        // ✅ Debug query
        // echo $this->db->last_query();
        // exit;

        return $count;
    }

    public function hitungStatusRejected($jenis_saldo)
    {
        // 1. Ambil no_pettycash terakhir dari tb_data_mutasi
        $this->db->select('no_pettycash');
        $this->db->from('tb_data_mutasi');
        $this->db->where('jenis_transaksi', 'Debet');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->order_by('id_mutasi', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get()->row();

        if (!$query) {
            return 0;
        }

        $last_no_pettycash = $query->no_pettycash;

        // ✅ Debug sementara
        // echo "Last PC: " . $last_no_pettycash;
        // exit;

        // 2. Hitung status Rejected di tb_bpkk_cab
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pettycash', $last_no_pettycash);
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('status_cab', 'Rejected');
        $count = $this->db->count_all_results();

        // ✅ Debug query
        // echo $this->db->last_query();
        // exit;

        return $count;
    }

    public function getbudgetcabang($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_saldo_cabang');
        $this->db->where('jenis_saldo', $kode_cabang);
        $query = $this->db->get();
        return $query->row();
    }

    public function getpengeluaranjkt_all($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('jenis_saldo', $kode_cabang);
        $this->db->where('status_cab', 'In progress');
        $this->db->where('status_bpkk', 'Done');
        // tidak pakai filter no_pc_saldo
        $data = $this->db->get();
        return $data->result();
    }

    public function getpengeluaranjkt($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('jenis_saldo', $kode_cabang);
        $this->db->where('status_cab', 'In progress');
        $this->db->where('status_bpkk', 'Done');
        $this->db->where('no_pc_saldo IS NULL', null, false);
        $data = $this->db->get();
        return $data->result();
    }

    public function getSaldoCabangjkt($jenis_saldo)
    {
        $this->db->select('*');
        $this->db->from('tb_saldo');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get();

        return $query->row(); // <-- return objek saldo
    }

    // public function getnopettycash($jenis_saldo)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_nopettycash');
    //     $this->db->where('jenis_saldo', $jenis_saldo);
    //     $this->db->order_by('id_nopettycash', 'DESC'); // atau 'nomor_pettycash' DESC jika ada
    //     $this->db->limit(1);

    //     $query = $this->db->get();

    //     // Return seluruh row data (object) atau null jika tidak ada
    //     return $query->num_rows() > 0 ? $query->row() : null;
    // }

    public function getnopettycash($kode_cabang)
    {
        $bulan = date('m');
        $tahun = date('Y');
        $prefix = "PC-{$kode_cabang}";

        // Cari nomor terakhir hanya untuk cabang & bulan & tahun ini
        $this->db->like('no_petty_cash', "/{$prefix}/{$bulan}/{$tahun}", 'both');
        $this->db->order_by('no_petty_cash', 'DESC');
        $query = $this->db->get('tb_nopettycash', 1);

        $last_number = 0;
        if ($query->num_rows() > 0) {
            $last_no = $query->row()->no_petty_cash;

            // Ambil 4 digit pertama (nomor urut)
            $parts = explode('/', $last_no);
            if (count($parts) >= 4 && is_numeric($parts[0])) {
                $last_number = (int) $parts[0];
            }
        }

        // Tambah +1 atau mulai dari 0001 kalau belum ada
        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "{$new_number}/{$prefix}/{$bulan}/{$tahun}";
    }

    public function getpenanggungjawabpc($kode_cabang)
    {
        $this->db->select('*');
        $this->db->from('tb_penanggung_jawab');
        $this->db->where('jenis_saldo', $kode_cabang);
        $data = $this->db->get();
        return $data->row();
    }
}
