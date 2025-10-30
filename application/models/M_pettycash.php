<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pettycash extends CI_Model
{
    public function generatePettycashNumber($kode_cabang)
    {
        $bulan = date('m');
        $tahun = date('Y');
        $prefix = "PC-{$kode_cabang}";

        // Ambil data terakhir berdasarkan kode cabang, bulan, dan tahun
        $this->db->like('no_petty_cash', "/{$prefix}/{$bulan}/{$tahun}", 'both');
        $this->db->order_by('no_petty_cash', 'DESC');
        $query = $this->db->get('tb_nopettycash', 1);

        $last_number = 0;
        if ($query->num_rows() > 0) {
            $last_no = $query->row()->no_petty_cash;
            if (preg_match('/^(\d{4})\/' . preg_quote($prefix, '/') . '\/' . $bulan . '\/' . $tahun . '$/', $last_no, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
        return "{$new_number}/{$prefix}/{$bulan}/{$tahun}";
    }

    // public function getlistbpkkwaiting()
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_bpkk_cab');
    //     $this->db->where_in('status_cab', ['In process', 'Rejected']);
    //     $this->db->order_by('id_bpkk_cab', 'DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function getlistpermintaansaldo($level_user, $address_user)
    {
        $this->db->select('tb_permintaan_saldo.*, tb_sisasaldo_rembes.sisasaldo_remb, tb_dokumen_remb.nama_dokumenremb,
    tb_dokumen_remb.jenis_saldo AS jenis_saldo_dok');
        $this->db->from('tb_permintaan_saldo');
        $this->db->join('tb_sisasaldo_rembes', 'tb_sisasaldo_rembes.no_pettycash = tb_permintaan_saldo.no_pettycash AND tb_sisasaldo_rembes.jenis_saldo = tb_permintaan_saldo.jenis_saldo', 'left');
        $this->db->join('tb_dokumen_remb', 'tb_dokumen_remb.no_pettycash = tb_permintaan_saldo.no_pettycash', 'left');

        $level_user = strtolower($level_user);
        $address_user = strtolower($address_user);

        if ($level_user === 'user') {
            $this->db->where('LOWER(kantor_cab)', $address_user);
        } elseif ($level_user === 'finance_bdp') {
            $this->db->where_in('LOWER(kantor_cab)', ['galang', 'sekupang']);
        } elseif ($level_user === 'finance_bsgroup') {
            $this->db->where_in('LOWER(kantor_cab)', ['jakarta', 'balikpapan', 'karimun']);
        } elseif ($level_user === 'finance_bmg' || $level_user === 'direktur_finance' || $level_user === 'super_admin' || $level_user === 'development') {
        } else {
            $this->db->where('kantor_cab', 'unknown');
        }

        $this->db->order_by('id_pettycash', 'DESC');
        return $this->db->get()->result_array();
    }

    public function simpan_no_pettycash($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $data;
    }
    public function simpan_pengajuan_pettycash($table, $data2)
    {
        $insert = $this->db->insert($table, $data2);
        return $data2;
    }

    public function simpandokumenapprove($table, $data8)
    {
        $insert = $this->db->insert($table, $data8);
        return $data8;
    }

    public function simpan_notifikasi($table, $data5)
    {
        $insert = $this->db->insert($table, $data5);
        return $data5;
    }

    public function tambahrembespending($table, $data6)
    {
        $insert = $this->db->insert($table, $data6);
        return $data6;
    }


    // public function update_no_pc_saldo_bpkk($jenis_saldo, $no_pc_saldo)
    // {
    //     $this->db->where('jenis_saldo', $jenis_saldo);
    //     $this->db->where_in('status_cab', ['In progress', 'Rejected']);
    //     $this->db->update('tb_bpkk_cab', ['no_pc_saldo' => $no_pc_saldo]);
    // }

    public function updatebpkkcab($jenis_saldo, $data3)
    {
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where_in('status_cab', ['In progress', 'Rejected']);
        $this->db->where('no_pc_saldo IS NULL', null, false);
        return $this->db->update('tb_bpkk_cab', $data3);
    }

    public function updatesisasaldopending($jenis_saldo, $data7)
    {
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where('no_pc_saldo IS NULL', null, false);
        return $this->db->update('tb_sisasaldo', $data7);
    }

    public function updatestatusmutasi($jenis_saldo, $data4)
    {
        $this->db->where('jenis_saldo', $jenis_saldo);
        $this->db->where_in('status_mutasi', ['Open']);
        return $this->db->update('tb_data_mutasi', $data4);
    }

    public function get_data_bpkk_by_no($no_pettycash)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pc_saldo', $no_pettycash);
        $this->db->order_by('id_bpkk_cab', 'ASC');
        return $this->db->get()->result_array();
    }

    // page data transaksi
    public function getdatadebet($address_user, $level)
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

        $this->db->select('*');
        $this->db->from('tb_debet_saldo');
        if (!empty($akses)) {
            $this->db->where_in('tb_debet_saldo.jenis_saldo', $akses);
        }
        $this->db->order_by('tb_debet_saldo.id_debet', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getMutasiCabang()
    {
        // $bulan = date('m');
        // $tahun = date('Y');
        $this->db->select('*');
        $this->db->from('tb_data_mutasi');
        // Filter bulan dan tahun berjalan
        // $this->db->where('MONTH(tanggal)', $bulan);
        // $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('status_mutasi', 'Close');
        $this->db->order_by('tanggal', 'ASC');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function get_rekap_pengeluaran($no_pettycash)
    {
        // Ambil data header dari tb_permintaan_saldo
        $header = $this->db->get_where('tb_permintaan_saldo', ['no_pettycash' => $no_pettycash])->row_array();

        // Ambil detail dari tb_bpkk_cab berdasarkan no_pc_saldo
        $this->db->where('no_pc_saldo', $no_pettycash);
        $this->db->order_by('tgl_kredit_cab', 'ASC');
        $detail = $this->db->get('tb_bpkk_cab')->result_array();

        if (empty($detail)) {
            return [];
        }

        // Hitung total pengeluaran
        $total_pengeluaran = 0;
        foreach ($detail as $d) {
            $total_pengeluaran += (float)$d['total_kredit_cab'];
        }

        // Sisa saldo akhir dari saldo awal - total pengeluaran
        $saldo_awal = (float)$header['saldo_pettycash'];
        $sisa_saldo = $saldo_awal - $total_pengeluaran;

        // Format detail untuk tampilan rapi
        $formatted_detail = array_map(function ($d) {
            return [
                'tanggal_bpkk' => $d['tgl_kredit_cab'],
                'no_bpkk' => $d['no_bpkk_cab'],
                'keterangan_bpkk' => $d['ket_bpkk_cab'],
                'pengeluaran' => 'Rp ' . number_format((!empty($d['total_kredit_cab']) ? $d['total_kredit_cab'] : 0), 0, ',', '.'),
                'sisa_saldo'  => 'Rp ' . number_format((!empty($d['sisa_saldo']) ? $d['sisa_saldo'] : 0), 0, ',', '.'),
            ];
        }, $detail);

        return [
            'header' => [
                'kantor' => strtoupper($header['kantor_cab']),
                'budget' => $saldo_awal,
                'saldo_awal' => $saldo_awal,
            ],
            'detail' => $formatted_detail,
            'total_pengeluaran' => $total_pengeluaran,
            'sisa_saldo' => $sisa_saldo
        ];
    }

    // widget
}