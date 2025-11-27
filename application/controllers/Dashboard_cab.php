<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_cab extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_bpkk');
    }

    public function dashboard_jkt()
    {
        $transaksijkt = $this->M_bpkk->getMutasiByCabang('JKT');
        $no_bpkkjkt = $this->M_bpkk->generateNoBpkk('JKT');
        $rowjkt = $this->M_bpkk->get_saldo_by_cabang('JKT');
        $kreditjkt = $this->M_bpkk->get_total_kredit_by_jenis_saldo('JKT');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('JKT');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('JKT');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('JKT');

        foreach ($transaksijkt as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldojkt = [[
            'saldojkt'       => $rowjkt->saldo_pettycash ?? 0,
            'saldodebetjkt'  => $rowjkt->saldo_debet ?? 0,
            'saldokreditjkt' => $kreditjkt->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Jakarta",
            'rowtransaksijkt' => $transaksijkt,
            'no_bpkkjkt' => $no_bpkkjkt,
            'data_saldojkt' => $data_saldojkt,
            'codecabang' => 'JKT',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_jkt', $data);
    }

    public function dashboard_karimun()
    {
        $transaksikarimun = $this->M_bpkk->getMutasiByCabang('TBK');
        $no_bpkkkarimun = $this->M_bpkk->generateNoBpkk('TBK');
        $rowkarimun = $this->M_bpkk->get_saldo_by_cabang('TBK');
        $kreditkarimun = $this->M_bpkk->get_total_kredit_by_jenis_saldo('TBK');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('TBK');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('TBK');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('TBK');

        foreach ($transaksikarimun as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldokarimun = [[
            'saldokarimun'       => $rowkarimun->saldo_pettycash ?? 0,
            'saldodebetkarimun'  => $rowkarimun->saldo_debet ?? 0,
            'saldokreditkarimun' => $kreditkarimun->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Karimun",
            'rowtransaksikarimun' => $transaksikarimun,
            'no_bpkkkarimun' => $no_bpkkkarimun,
            'data_saldokarimun' => $data_saldokarimun,
            'codecabang' => 'TBK',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected

        );

        $this->template->load('template', 'dashboard/dashboard_karimun', $data);
    }

    public function dashboard_balikpapan()
    {
        $transaksibalikpapan = $this->M_bpkk->getMutasiByCabang('BPP');
        $no_bpkkbalikpapan = $this->M_bpkk->generateNoBpkk('BPP');
        $rowbalikpapan = $this->M_bpkk->get_saldo_by_cabang('BPP');
        $kreditbalikpapan = $this->M_bpkk->get_total_kredit_by_jenis_saldo('BPP');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('BPP');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('BPP');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('BPP');

        foreach ($transaksibalikpapan as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldobalikpapan = [[
            'saldobalikpapan'       => $rowbalikpapan->saldo_pettycash ?? 0,
            'saldodebetbalikpapan'  => $rowbalikpapan->saldo_debet ?? 0,
            'saldokreditbalikpapan' => $kreditbalikpapan->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Balikpapan",
            'rowtransaksibalikpapan' => $transaksibalikpapan,
            'no_bpkkbalikpapan' => $no_bpkkbalikpapan,
            'data_saldobalikpapan' => $data_saldobalikpapan,
            'codecabang' => 'BPP',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_balikpapan', $data);
    }

    public function dashboard_galang()
    {
        $transaksilayupgalang = $this->M_bpkk->getMutasiByCabang('LU');
        $no_bpkklayupgalang = $this->M_bpkk->generateNoBpkk('LU');
        $rowlayupgalang = $this->M_bpkk->get_saldo_by_cabang('LU');
        $kreditlayupgalang = $this->M_bpkk->get_total_kredit_by_jenis_saldo('LU');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('LU');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('LU');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('LU');

        foreach ($transaksilayupgalang as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldolayupgalang = [[
            'saldolayupgalang'       => $rowlayupgalang->saldo_pettycash ?? 0,
            'saldodebetlayupgalang'  => $rowlayupgalang->saldo_debet ?? 0,
            'saldokreditlayupgalang' => $kreditlayupgalang->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Lay Up",
            'rowtransaksilayupgalang' => $transaksilayupgalang,
            'no_bpkklayupgalang' => $no_bpkklayupgalang,
            'data_saldolayupgalang' => $data_saldolayupgalang,
            'codecabang' => 'LU',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_galang', $data);
    }

    public function dashboard_sekupang_bbm()
    {
        $transaksibbmsekupang = $this->M_bpkk->getMutasiByCabang('PA_BBM');
        $no_bpkkbbmsekupang = $this->M_bpkk->generateNoBpkk('PA_BBM');
        $rowbbmsekupang = $this->M_bpkk->get_saldo_by_cabang('PA_BBM');
        $kreditbbmsekupang = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_BBM');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('PA_BBM');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('PA_BBM');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('PA_BBM');

        foreach ($transaksibbmsekupang as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldobbmsekupang = [[
            'saldobbmsekupang'       => $rowbbmsekupang->saldo_pettycash ?? 0,
            'saldodebetbbmsekupang'  => $rowbbmsekupang->saldo_debet ?? 0,
            'saldokreditbbmsekupang' => $kreditbbmsekupang->total_kredit ?? 0
        ]];


        $data = array(
            'judul' => "Dashboard | Dashboard Sekupang BBM Boat",
            'rowtransaksibbmsekupang' => $transaksibbmsekupang,
            'no_bpkkbbmsekupang' => $no_bpkkbbmsekupang,
            'data_saldobbmsekupang' => $data_saldobbmsekupang,
            'codecabang' => 'PA_BBM',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_skpg_bbm', $data);
    }

    public function dashboard_sekupang_servicesboat()
    {
        $transaksiserviceboatsekupang = $this->M_bpkk->getMutasiByCabang('PA_SB');
        $no_bpkkservicesekupang = $this->M_bpkk->generateNoBpkk('PA_SB');
        $rowservicesekupang = $this->M_bpkk->get_saldo_by_cabang('PA_SB');
        $kreditservicesekupang = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_SB');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('PA_SB');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('PA_SB');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('PA_SB');

        foreach ($transaksiserviceboatsekupang as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldoservicesekupang = [[
            'saldoservicesekupang'       => $rowservicesekupang->saldo_pettycash ?? 0,
            'saldodebetservicesekupang'  => $rowservicesekupang->saldo_debet ?? 0,
            'saldokreditservicesekupang' => $kreditservicesekupang->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Sekupang Service Boat",
            'rowtransaksiserviceboatsekupang' => $transaksiserviceboatsekupang,
            'no_bpkkservicesekupang' => $no_bpkkservicesekupang,
            'data_saldoservicesekupang' => $data_saldoservicesekupang,
            'codecabang' => 'PA_SB',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_skpg_serviceboat', $data);
    }

    public function dashboard_sekupang_rtk()
    {
        $transaksirtksekupang = $this->M_bpkk->getMutasiByCabang('PA_RTK');
        $no_bpkkrtksekupang = $this->M_bpkk->generateNoBpkk('PA_RTK');
        $rowrtksekupang = $this->M_bpkk->get_saldo_by_cabang('PA_RTK');
        $kreditrtksekupang = $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_RTK');
        $jumlahstatusinprogress = $this->M_bpkk->hitungStatusInprogress('PA_RTK');
        $jumlahstatusapproved = $this->M_bpkk->hitungStatusApproved('PA_RTK');
        $jumlahstatusrejected = $this->M_bpkk->hitungStatusRejected('PA_RTK');

        foreach ($transaksirtksekupang as &$data) {
            $data['sisa_saldo_pending'] = $this->M_bpkk->get_sisa_saldo_pending_by_bpkk(
                $data['no_bpkk_cab'],
                $data['jenis_saldo']
            );
        }
        unset($data);

        $data_saldortksekupang = [[
            'saldortksekupang'       => $rowrtksekupang->saldo_pettycash ?? 0,
            'saldodebetrtksekupang'  => $rowrtksekupang->saldo_debet ?? 0,
            'saldokreditrtksekupang' => $kreditrtksekupang->total_kredit ?? 0
        ]];

        $data = array(
            'judul' => "Dashboard | Dashboard Sekupang ATK/RTK",
            'rowtransaksirtksekupang' => $transaksirtksekupang,
            'no_bpkkrtksekupang' => $no_bpkkrtksekupang,
            'data_saldortksekupang' => $data_saldortksekupang,
            'codecabang' => 'PA_RTK',
            'jumlahstatusapproved' => $jumlahstatusapproved,
            'jumlahstatusinprogress' => $jumlahstatusinprogress,
            'jumlahstatusrejected' => $jumlahstatusrejected
        );

        $this->template->load('template', 'dashboard/dashboard_skpg_rtk', $data);
    }

    public function tambahpengeluaranbpkk()
    {
        $nobpkk         = $this->input->post('no_bpkk');
        $sbu            = $this->input->post('optionsRadios');
        $sbu_unit       = $this->input->post('check-box');
        if (!empty($sbu_unit) && is_array($sbu_unit)) {
            $sbu_unit = implode(', ', $sbu_unit);
        } else {
            $sbu_unit = '';
        }

        $jenis_saldo    = $this->input->post('address_cab');
        $tanggal_input  = $this->input->post('tanggal');
        $tanggal_pengeluaran = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_input)));
        $keterangan_bpkk = $this->input->post('keterangan');
        $jenis_pengeluaran = $this->input->post('jenis_pengeluaran');
        $totalkredit    = $this->input->post('total_debet');
        $address_user   = $this->fungsi->user_login()->address_user;
        $nopettycash    = $this->M_bpkk->getLastNoPettyCashBySaldo($jenis_saldo);
        $sisasaldo     = $this->M_bpkk->getsisasaldo($jenis_saldo);
        $sisasaldo_pending = $sisasaldo - $totalkredit;
        if ($sisasaldo_pending < 0) {
            $sisasaldo_pending = 0;
        }

        $redirectMap = [
            'JKT'     => 'dashboard_cab/dashboard_jkt',
            'TBK'     => 'dashboard_cab/dashboard_karimun',
            'BPP'     => 'dashboard_cab/dashboard_balikpapan',
            'LU'      => 'dashboard_cab/dashboard_galang',
            'PA_BBM'  => 'dashboard_cab/dashboard_sekupang_bbm',
            'PA_SB'   => 'dashboard_cab/dashboard_sekupang_servicesboat',
            'PA_RTK'  => 'dashboard_cab/dashboard_sekupang_rtk',
        ];
        $redirectTarget = isset($redirectMap[$jenis_saldo]) ? $redirectMap[$jenis_saldo] : 'dashboard';

        if (!$nopettycash) {
            $this->session->set_flashdata('error', 'Nomor petty cash tidak ditemukan untuk jenis saldo: ' . $jenis_saldo);
            redirect($redirectTarget);
            return;
        }

        // === Upload file ===
        $cleaned_keterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $keterangan_bpkk);
        $upload_folder = './uploads/BPKK/' . $jenis_saldo . '/';
        $file_name = $cleaned_keterangan . '.pdf';
        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        $config['upload_path']   = $upload_folder;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 1024;
        $config['file_name']     = $file_name;
        $config['overwrite']     = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_dokumen')) {
            $error = $this->upload->display_errors('', '');
            if (strpos(strtolower($error), 'filetype') !== false) {
                $errorMsg = "File harus dalam format PDF.";
            } elseif (strpos(strtolower($error), 'exceeds') !== false) {
                $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
            } else {
                $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
            }

            log_message('error', 'Upload error: ' . $error);

            $this->session->set_flashdata('error', $errorMsg);

            redirect($redirectTarget);
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['file_name'];

        $data = [
            'no_bpkk_cab'            => $nobpkk,
            'sbu'                    => $sbu,
            'sbu_unit'               => $sbu_unit,
            'jenis_saldo'            => $jenis_saldo,
            'tgl_kredit_cab'         => $tanggal_pengeluaran,
            'ket_bpkk_cab'           => $keterangan_bpkk,
            'jenis_pengeluaran_cab'  => $jenis_pengeluaran,
            'total_kredit_cab'       => $totalkredit,
            'status_cab'             => 'In progress',
            'status_bpkk'            => 'Open',
            'rembesment'             => 'Open',
            'upload_file_cab'        => $file_path,
            'no_pettycash'           => $nopettycash
        ];

        $data2 = [
            'no_bpkk_cab'            => $nobpkk,
            'sbu'                    => $sbu,
            'sbu_unit'               => $sbu_unit,
            'jenis_saldo'            => $jenis_saldo,
            'tgl_kredit_cab'         => $tanggal_pengeluaran,
            'ket_bpkk_cab'           => $keterangan_bpkk,
            'jenis_pengeluaran_cab'  => $jenis_pengeluaran,
            'total_kredit_cab'       => $totalkredit,
            'upload_file_cab'        => $file_path,
            'no_pettycash'           => $nopettycash
        ];

        $data3 = [
            'no_bpkk'                => $nobpkk,
            'kantor_cab'             => $address_user,
            'jenis_saldo'            => $jenis_saldo
        ];

        $data4 = [
            'no_pettycash'           => $nopettycash,
            'no_bpkk_cab'            => $nobpkk,
            'sbu'                    => $sbu,
            'sbu_unit'               => $sbu_unit,
            'jenis_saldo'            => $jenis_saldo,
            'tanggal'                => $tanggal_pengeluaran,
            'keterangan'             => $keterangan_bpkk,
            'total_kredit_cab'       => $totalkredit,
            'jenis_transaksi'        => 'Kredit',
            'status_mutasi'          => 'Open',
            'file'                   => $file_path,
        ];

        $data5 = [
            'no_pettycash'           => $nopettycash,
            'no_bpkk_cab'            => $nobpkk,
            'ket_bpkk_cab'           => $keterangan_bpkk,
            'jenis_pengeluaran_cab'  => $jenis_pengeluaran,
            'sbu_unit'               => $sbu_unit,
            'jenis_saldo'            => $jenis_saldo,
            'total_kredit_cab'       => $totalkredit,
            'sisa_saldo'             => $sisasaldo_pending,
            'status_saldo'           => 'Pending',
            'tanggal'                => $tanggal_pengeluaran,
        ];

        $this->M_bpkk->pengeluaranbpkk('tb_bpkk_cab', $data);
        $this->M_bpkk->riwayatbpkk('tb_riwayat_bpkk', $data2);
        $this->M_bpkk->nobpkk('tb_nobpkk', $data3);
        $this->M_bpkk->tambahdatamutasi('tb_data_mutasi', $data4);
        $this->M_bpkk->tambahsisasaldopending('tb_sisasaldo', $data5);
        $this->M_bpkk->updateSaldoCabang($jenis_saldo, $totalkredit);

        $this->session->set_flashdata('success', 'Pengeluaran petty cash berhasil disimpan.');
        redirect($redirectTarget);
    }


    public function generate_pettycash($codecabang)
    {
        $this->load->library('pdf');
        $this->load->model('M_bpkk');

        $pdf = new Pdf('L', 'mm', 'A4');

        // ============================
        // Kirim kode cabang ke PDF
        // ============================
        $pdf->setCodeCabang($codecabang);

        $pdf->SetWidths([9, 20, 45, 113, 30, 30, 30]);
        $pdf->SetAligns(['C', 'C', 'L', 'L', 'C', 'R', 'R']);

        $rows = $this->M_bpkk->getpengeluaranjkt($codecabang);
        $rows_all = $this->M_bpkk->getpengeluaranjkt_all($codecabang);
        $saldo_awal_jkt = $this->M_bpkk->getSaldoCabangjkt($codecabang);
        $nopettycashjkt = $this->M_bpkk->getnopettycash($codecabang);
        $debetsaldo = $saldo_awal_jkt->saldo_debet;

        $total_pengeluaran = 0;
        foreach ($rows as $row) {
            $total_pengeluaran += $row->total_kredit_cab ?? 0;
        }

        $running_saldo_list = [];
        $sisa_saldo = $debetsaldo;
        foreach ($rows_all as $row) {
            $sisa_saldo -= $row->total_kredit_cab;
            $running_saldo_list[$row->id_bpkk_cab] = $sisa_saldo;
        }

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 9);

        $count = 0;
        $rowsPerPage = 10;

        $running_saldo = $sisa_saldo;

        $pdf->SetFont('Arial', '', 9);
        foreach ($rows as $i => $row) {
            $total_kredit_cab   = $row->total_kredit_cab ?? 0;
            $running_saldo     -= $total_kredit_cab;
            $pdf->Row([
                $i + 1,
                date('d/m/Y', strtotime($row->tgl_kredit_cab)),
                $row->no_bpkk_cab,
                $row->ket_bpkk_cab,
                '-',
                "Rp " . number_format($row->total_kredit_cab, 0, ',', '.'),
                'Rp ' . number_format($running_saldo_list[$row->id_bpkk_cab] ?? 0, 0, ',', '.')
            ]);
            $count++;
            if ($count == $rowsPerPage && $i < count($rows) - 1) {
                $pdf->AddPage();
                $count = 0;
            }
        }

        //  Total Pengeluaran
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(217, 6, 'Total Pengeluaran', 1, 0, 'L');
        $pdf->Cell(30, 6, 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'), 1, 0, 'C');

        // Sisa Saldo
        $pdf->Cell(30, 6, '', 1, 1, 'R');
        $pdf->Cell(217, 6, 'Sisa Saldo', 1, 0, 'L');
        $pdf->Cell(30, 6, '', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp ' . number_format($sisa_saldo, 0, ',', '.'), 1, 1, 'C'); // Kolom dengan warna latar abu-abu

        // Total Pengajual Saldo
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(217, 6, 'PENGAJUAN SALDO', 1, 0, 'R');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(60, 6, 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'), 1, 1, 'C', true); // Kolom dengan warna latar abu-abu

        // Halaman rekap
        $pdf->isRekap = true;
        $pdf->AddPage();

        $totalWidth = 9 + 80 + 60; // 149
        $marginLeft = ($pdf->GetPageWidth() - $totalWidth) / 2;

        // Judul
        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'LAPORAN PENGAJUAN PETTY CASH', 0, 1, 'C');

        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetX($marginLeft);
        $pdf->Cell(9, 6, 'No', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Nama Item', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Total Pengeluaran Item', 1, 1, 'C');

        // --- Rekap data berdasarkan jenis_pengeluaran_cab ---
        $rekap = [];
        foreach ($rows as $row) {
            $jenis = $row->jenis_pengeluaran_cab;
            if (!isset($rekap[$jenis])) {
                $rekap[$jenis] = 0;
            }
            $rekap[$jenis]++;
        }

        $pdf->SetFont('Arial', '', 11);
        $no = 1;
        foreach ($rekap as $jenis => $jumlah) {
            $namaItem = ucwords(str_replace('_', ' ', $jenis));
            $pdf->SetX($marginLeft);
            $pdf->Cell(9, 6, $no++, 1, 0, 'C');
            $pdf->Cell(80, 6, $namaItem, 1, 0, 'L');
            $pdf->Cell(60, 6, $jumlah, 1, 1, 'C');
        }

        $filename = 'Approve-' . str_replace('/', '_', $nopettycashjkt) . '.pdf';
        $folderPath = FCPATH . 'uploads/approve/' . $codecabang . '/';
        $savePath   = $folderPath . $filename;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $pdf->SetTitle($filename);

        $pdf->Output($savePath, 'F');

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        $pdf->Output('I', $filename);
    }
}