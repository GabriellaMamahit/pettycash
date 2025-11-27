<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_bpkk');
    }

    public function index()
    {

        // Data chart dan rekap
        $donut_chart  = $this->M_bpkk->get_pengeluaran_per_jenis_saldo_bulanan();
        $rekap_tahunan = $this->M_bpkk->get_rekap_tahunan_per_cabang();

        // Ambil semua saldo, budget, kredit berdasarkan cabang
        $budgetjkt         = $this->M_bpkk->getbudgetsaldo('JKT');
        $budgetkarimun     = $this->M_bpkk->getbudgetsaldo('TBK');
        $budgetbalikpapan  = $this->M_bpkk->getbudgetsaldo('BPP');
        $budgetgalang      = $this->M_bpkk->getbudgetsaldo('LU');
        $budgetskpg_bbm    = $this->M_bpkk->getbudgetsaldo('PA_BBM');
        $budgetskpg_sb     = $this->M_bpkk->getbudgetsaldo('PA_SB');
        $budgetskpg_rtk    = $this->M_bpkk->getbudgetsaldo('PA_RTK');

        $rowjkt            = $this->M_bpkk->get_saldo_by_cabang('JKT');
        $rowkarimun        = $this->M_bpkk->get_saldo_by_cabang('TBK');
        $rowbalikpapan     = $this->M_bpkk->get_saldo_by_cabang('BPP');
        $rowgalang         = $this->M_bpkk->get_saldo_by_cabang('LU');
        $rowskpg_bbm       = $this->M_bpkk->get_saldo_by_cabang('PA_BBM');
        $rowskpg_sb        = $this->M_bpkk->get_saldo_by_cabang('PA_SB');
        $rowskpg_rtk       = $this->M_bpkk->get_saldo_by_cabang('PA_RTK');

        $kreditjkt         = $this->M_bpkk->get_total_kredit_by_jenis_saldo('JKT');
        $kreditkarimun     = $this->M_bpkk->get_total_kredit_by_jenis_saldo('TBK');
        $kreditbalikpapan  = $this->M_bpkk->get_total_kredit_by_jenis_saldo('BPP');
        $kreditgalang      = $this->M_bpkk->get_total_kredit_by_jenis_saldo('LU');
        $kreditskpg_bbm    = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_BBM');
        $kreditskpg_sb     = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_SB');
        $kreditskpg_rtk    = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_RTK');

        /**
         * Dibuat satu array, sesuai format code lama Anda.
         * Tidak ada perubahan struktur.
         */
        $data_saldo = [[
            // Jakarta
            'budgetsaldojkt'       => $budgetjkt->saldo_cabang ?? 0,
            'saldojkt'             => $rowjkt->saldo_pettycash ?? 0,
            'saldodebetjkt'        => $rowjkt->saldo_debet ?? 0,
            'saldokreditjkt'       => $kreditjkt->total_kredit ?? 0,

            // Karimun (TBK)
            'budgetsaldokarimun'   => $budgetkarimun->saldo_cabang ?? 0,
            'saldokarimun'         => $rowkarimun->saldo_pettycash ?? 0,
            'saldodebetkarimun'    => $rowkarimun->saldo_debet ?? 0,
            'saldokreditkarimun'   => $kreditkarimun->total_kredit ?? 0,

            // Balikpapan
            'budgetsaldobalikpapan' => $budgetbalikpapan->saldo_cabang ?? 0,
            'saldobalikpapan'        => $rowbalikpapan->saldo_pettycash ?? 0,
            'saldodebetbalikpapan'   => $rowbalikpapan->saldo_debet ?? 0,
            'saldokreditbalikpapan'  => $kreditbalikpapan->total_kredit ?? 0,

            // Galang
            'budgetsaldogalang'     => $budgetgalang->saldo_cabang ?? 0,
            'saldogalang'           => $rowgalang->saldo_pettycash ?? 0,
            'saldodebetgalang'      => $rowgalang->saldo_debet ?? 0,
            'saldokreditgalang'     => $kreditgalang->total_kredit ?? 0,

            // Sekupang BBM
            'budgetsaldoskpgbbm'     => $budgetskpg_bbm->saldo_cabang ?? 0,
            'saldoskpgbbm'           => $rowskpg_bbm->saldo_pettycash ?? 0,
            'saldodebetskpgbbm'      => $rowskpg_bbm->saldo_debet ?? 0,
            'saldokreditskpgbbm'     => $kreditskpg_bbm->total_kredit ?? 0,

            // Sekupang Service Boat
            'budgetsaldoskpgserviceboat' => $budgetskpg_sb->saldo_cabang ?? 0,
            'saldoskpgserviceboat'       => $rowskpg_sb->saldo_pettycash ?? 0,
            'saldodebetskpgserviceboat'  => $rowskpg_sb->saldo_debet ?? 0,
            'saldokreditskpgserviceboat' => $kreditskpg_sb->total_kredit ?? 0,

            // Sekupang ATK/RTK
            'budgetsaldoskpgatkrtk'  => $budgetskpg_rtk->saldo_cabang ?? 0,
            'saldoskpgatkrtk'        => $rowskpg_rtk->saldo_pettycash ?? 0,
            'saldodebetskpgatkrtk'   => $rowskpg_rtk->saldo_debet ?? 0,
            'saldokreditskpgatkrtk'  => $kreditskpg_rtk->total_kredit ?? 0,
        ]];

        // Widget
        $in_progress = $this->M_bpkk->getWidgetData('In progress', 'all');
        $approved    = $this->M_bpkk->getWidgetData('Approved', 'all');
        $revisi      = $this->M_bpkk->getWidgetData('Revisi', 'all');
        $rejected    = $this->M_bpkk->getWidgetData('Rejected', 'all');

        // Data untuk view
        $data = [
            'judul'              => "Petty Cash | Dashboard",
            'donut_chart'        => $donut_chart,
            'rekap_tahunan'      => $rekap_tahunan,
            'data_saldo'      => $data_saldo,
            'in_progress'        => $in_progress,
            'approved'           => $approved,
            'revisi'             => $revisi,
            'rejected'           => $rejected,
        ];

        // Load template
        $this->template->load('template', 'dashboard', $data);
    }

    /**
     * Filter widget via AJAX
     */
    public function filter_widget()
    {
        $jenis_saldo = $this->input->post('jenis_saldo');

        $response = [
            'in_progress' => $this->M_bpkk->getWidgetData('In progress', $jenis_saldo),
            'approved'    => $this->M_bpkk->getWidgetData('Approved', $jenis_saldo),
            'revisi'      => $this->M_bpkk->getWidgetData('Revisi', $jenis_saldo),
            'rejected'    => $this->M_bpkk->getWidgetData('Rejected', $jenis_saldo),
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}