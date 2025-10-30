<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_finance extends CI_Model
{

    public function getsaldocabang()
    {
        $this->db->select('*');
        $this->db->from('tb_saldo');
        $data = $this->db->get();
        return $data->result_array();
    }

    public function apprvpermintaansaldo($id_pettycash = NULL)
    {
        $query = $this->db->get_where('tb_permintaan_saldo', array('id_pettycash' => $id_pettycash))->row();
        return $query;
    }

    public function detail_saldo($id_saldo = NULL)
    {
        $query = $this->db->get_where('tb_saldo', array('id_saldopc' => $id_saldo))->row();
        return $query;
    }

    public function generatePettycashNumber($jenis_saldo)
    {
        $bulan = date('m');
        $tahun = date('Y');
        $prefix = "PC-{$jenis_saldo}"; // langsung pakai jenis_saldo (JKT, PA_BBM, dll)

        // Cari nomor terakhir sesuai prefix + bulan + tahun
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

    public function saldocabang($jenis_saldo)
    {
        $this->db->select('saldo_cabang');
        $this->db->from('tb_saldo_cabang');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->saldo_cabang;
        }
        return 0; // default kalau tidak ada data
    }

    public function saldopettycash($jenis_saldo)
    {
        $this->db->select('saldo_pettycash');
        $this->db->from('tb_saldo');
        $this->db->where('jenis_saldo', $jenis_saldo);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->saldo_pettycash;
        }
        return 0; // default kalau tidak ada data
    }
    public function tambahdatadebet($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function tambahnopettycash($table, $data2)
    {
        return $this->db->insert($table, $data2);
    }
    public function tambahdatamutasi($table, $data3)
    {
        return $this->db->insert($table, $data3);
    }
    public function notifikasitambahsaldo($table, $data5)
    {
        return $this->db->insert($table, $data5);
    }

    public function update_saldo_cabang($jenissaldo, $jumlah_tambah)
    {
        $this->db->set('saldo_pettycash', 'saldo_pettycash + ' . (int)$jumlah_tambah, false);
        $this->db->where('jenis_saldo', $jenissaldo);
        return $this->db->update('tb_saldo');
    }

    public function updatesaldo_cab($jenissaldo, $data4)
    {
        $this->db->where('jenis_saldo', $jenissaldo);
        return $this->db->update('tb_saldo', $data4);
    }

    // public function getdatasaldo($jenis_saldo)
    // {
    //     $this->db->select('tb_permintaan_saldo.*');
    //     $this->db->from('tb_permintaan_saldo');
    //     $this->db->join('tb_saldo', 'tb_saldo.jenis_saldo = tb_permintaan_saldo.jenis_saldo');
    //     $this->db->where('tb_permintaan_saldo.jenis_saldo', $jenis_saldo);
    //     $query = $this->db->get();
    //     return $query->result_array(); // Karena bisa banyak permintaan saldo
    // }

    public function getdatasaldo($jenis_saldo)
    {
        $sql = "
        SELECT 
            id_pettycash,
            no_pettycash,
            tanggal_pettycash AS tanggal,
            ket_pettycash AS keterangan,
            saldo_pettycash AS saldo,
            'Permintaan' AS sumber,
            status_permintaan AS status,
            jenis_saldo,
            dokumen_pettycash AS file_dokumen,
            NULL AS no_pc_asal
        FROM tb_permintaan_saldo
        WHERE jenis_saldo = ?

        UNION ALL

        SELECT 
            '' AS id_pettycash, 
            no_petty_cash AS no_pettycash, 
            tanggal_debet AS tanggal, 
            nama_saldo AS keterangan, 
            saldo_debet AS saldo,
            'Penambahan' AS sumber,
            status AS status,
            jenis_saldo,
            file AS file_dokumen,
            no_pc_asal
        FROM tb_debet_saldo
        WHERE jenis_saldo = ?
        
        ORDER BY 
            YEAR(tanggal) DESC,
            MONTH(tanggal) DESC,
            CAST(SUBSTRING_INDEX(no_pettycash, '/', 1) AS UNSIGNED) DESC
    ";

        return $this->db->query($sql, [$jenis_saldo, $jenis_saldo])->result_array();
    }


    public function getdatabpkkrembes($no_pettycash)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pc_saldo', $no_pettycash);
        $this->db->order_by('id_bpkk_cab', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getdatabpkk($no_pettycash)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pc_saldo', $no_pettycash);
        $this->db->order_by('id_bpkk_cab', 'ASC');
        return $this->db->get()->result_array();
    }

    public function updatestatusrembest($id_pettycash_saldo, $data4)
    {
        $this->db->where('id_pettycash', $id_pettycash_saldo);
        return $this->db->update('tb_permintaan_saldo', $data4);
    }

    public function get_data_bpkk_by_no($no_pettycash)
    {
        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('no_pc_saldo', $no_pettycash);
        $this->db->order_by('id_bpkk_cab', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getWidgetData($status, $jenis_saldo)
    {
        // Hitung jumlah data
        $this->db->from('tb_bpkk_cab');
        $this->db->where('status_cab', $status);
        $this->db->where('MONTH(tgl_kredit_cab)', date('m'));
        $this->db->where('YEAR(tgl_kredit_cab)', date('Y'));
        if ($jenis_saldo != 'all') {
            $this->db->where('jenis_saldo', $jenis_saldo);
        }
        $count = $this->db->count_all_results();

        // Hitung total nominal
        $this->db->select_sum('total_kredit_cab');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('status_cab', $status);
        $this->db->where('MONTH(tgl_kredit_cab)', date('m'));
        $this->db->where('YEAR(tgl_kredit_cab)', date('Y'));
        if ($jenis_saldo != 'all') {
            $this->db->where('jenis_saldo', $jenis_saldo);
        }
        $totalRow = $this->db->get()->row();
        $total = $totalRow && $totalRow->total_kredit_cab ? $totalRow->total_kredit_cab : 0;

        return [
            'count' => $count,
            'total' => number_format($total, 0, ',', '.')
        ];
    }



    // public function getdatasaldo($id_saldo)
    // {
    //     // Ambil jenis_saldo berdasarkan ID saldo
    //     $this->db->select('jenis_saldo');
    //     $this->db->from('tb_saldo');
    //     $this->db->where('id_saldo', $id_saldo);
    //     $result = $this->db->get()->row();

    //     if ($result) {
    //         $jenis_saldo = $result->jenis_saldo;

    //         // Ambil data dari tb_permintaan_saldo sesuai jenis_saldo
    //         $this->db->select('*');
    //         $this->db->from('tb_permintaan_saldo');
    //         $this->db->where('jenis_saldo', $jenis_saldo);
    //         return $this->db->get()->result_array();
    //     } else {
    //         return []; // kosong jika id_saldo tidak ditemukan
    //     }
    // }
}