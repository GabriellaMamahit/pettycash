<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pettycash extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_laporanpc');
    }

    public function laporan_pettycash_jkt()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabjkt' => $this->M_laporanpc->getlaporanbpkkjkt('JKT'),
            'chart_data' => $this->M_laporanpc->getbpkkjkt('JKT')
        );

        $summary = $this->M_laporanpc->getdebetjkt('JKT');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_jkt', $data);
    }

    public function laporan_pettycash_karimun()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabkarimun' => $this->M_laporanpc->getlaporanbpkkkarimun('TBK'),
            'chart_data' => $this->M_laporanpc->getbpkkkarimun('TBK')
        );

        $summary = $this->M_laporanpc->getdebetkarimun('TBK');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_karimun', $data);
    }

    public function laporan_pettycash_balikpapan()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabbpp' => $this->M_laporanpc->getlaporanbpkkbalikpapan('BPP'),
            'chart_data' => $this->M_laporanpc->getbpkkbalikpapan('BPP')
        );

        $summary = $this->M_laporanpc->getdebetbalikpapan('BPP');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_balikpapan', $data);
    }

    public function laporan_pettycash_galang()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabgalang' => $this->M_laporanpc->getlaporanbpkkgalang('LU'),
            'chart_data' => $this->M_laporanpc->getbpkkgalang('LU')
        );

        $summary = $this->M_laporanpc->getdebetgalang('LU');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_galang', $data);
    }

    public function laporan_pettycash_sekupang_bbm()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabpa_bbm' => $this->M_laporanpc->getlaporanbpkkpa_bbm('PA_BBM'),
            'chart_data' => $this->M_laporanpc->getbpkkpa_bbm('PA_BBM')
        );

        $summary = $this->M_laporanpc->getdebetpa_bbm('PA_BBM');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_skpg_bbm', $data);
    }

    public function laporan_pettycash_sekupang_servicesboat()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabpa_sevicesboat' => $this->M_laporanpc->getlaporanbpkkpa_seviceboat('PA_SB'),
            'chart_data' => $this->M_laporanpc->getbpkkpa_seviceboat('PA_SB')
        );

        $summary = $this->M_laporanpc->getdebetpa_seviceboat('PA_SB');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_skpg_serviceboat', $data);
    }

    public function laporan_pettycash_sekupang_rtk()
    {
        $data = array(
            'judul' => "Petty Cash | Riwayat BPKK",
            'rowlapbpkkcabpa_atkrtk' => $this->M_laporanpc->getlaporanbpkkpa_atkrtk('PA_RTK'),
            'chart_data' => $this->M_laporanpc->getbpkkpa_atkrtk('PA_RTK')
        );

        $summary = $this->M_laporanpc->getdebetpa_atkrtk('PA_RTK');
        $data['total_debet'] = $summary['total_debet'] ?? 0;
        $data['total_kredit'] = $summary['total_kredit'] ?? 0;

        $this->template->load('template', 'laporan/pettycash_skpg_rtk', $data);
    }
}