<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporanpc extends CI_Model
{
    public function getbpkkjkt($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetjkt($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkjkt($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkkarimun($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetkarimun($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkkarimun($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkbalikpapan($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetbalikpapan($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkbalikpapan($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkgalang($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetgalang($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkgalang($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkpa_bbm($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetpa_bbm($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkpa_bbm($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkpa_seviceboat($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetpa_seviceboat($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkpa_seviceboat($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }

    public function getbpkkpa_atkrtk($jenis_saldo)
    {
        return $this->db->select('jenis_pengeluaran_cab, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_bpkk', 'approve')
            ->group_by('jenis_pengeluaran_cab')
            ->get()
            ->result_array();
    }

    public function getdebetpa_atkrtk($jenis_saldo)
    {
        return $this->db->select('SUM(total_debet_cab) as total_debet, SUM(total_kredit_cab) as total_kredit')
            ->from('tb_data_mutasi')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status', 'approve')
            ->get()
            ->row_array();
    }

    public function getlaporanbpkkpa_atkrtk($jenis_saldo)
    {
        return $this->db->from('tb_bpkk_cab')
            ->where('jenis_saldo', $jenis_saldo)
            // ->where('status_cab', 'approve')
            ->get()
            ->result_array();
    }
}