<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Laporan_cabang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_pettycash');
    }

    public function index()
    {
        $user           = $this->fungsi->user_login();
        $address_user     = $user->address_user;
        $level             = $user->level;
        $transaksi      = $this->M_pettycash->getMutasiCabang($address_user, $level, 'ASC');

        $data = array(
            'judul' => "Petty Cash | Data Transaksi Cabang",
            'rowpengeluaranbpkk' => $transaksi,
        );

        $this->template->load('template', 'laporan_cabang', $data);
    }

    public function riwayat_mutasi()
    {
        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');

        if (
            !empty($awal) && !empty($akhir) &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $awal) &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $akhir)
        ) {
            $rowriwayatmutasi = $this->M_pettycash->filterMutasi($awal, $akhir);
        } else {
            $rowriwayatmutasi = $this->db->get('tb_data_mutasi')->result_array();
        }

        $data = [
            'judul'  => "Petty Cash | Riwayat BPKK",
            'script' => "bpkk.js",
            'rowriwayatmutasi' => $rowriwayatmutasi,
            'awal' => $awal,
            'akhir' => $akhir,
        ];

        $this->template->load('template', 'riwayat_laporan/riwayat_mutasi', $data);
    }

    public function export_pdf()
    {
        $this->load->library('m_pdf');
        $this->load->model('M_pettycash');

        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');

        if ($awal && $akhir) {
            $data_mutasi = $this->M_pettycash->filterMutasi($awal, $akhir);
        } else {
            $data_mutasi = $this->db->get('tb_data_mutasi')->result_array();
        }

        $pdf = new M_pdf('L', 'mm', 'A4');

        $pdf->SetTitle('Rekapan Pengeluaran Kas Kecil', true);
        $pdf->title = 'REKAPAN PENGELUARAN KAS KECIL';
        $pdf->setPeriode($awal, $akhir);

        $pdf->SetWidths([9, 20, 23, 45, 90, 30, 30, 30]);
        $pdf->SetAligns(['C', 'C', 'C', 'L', 'L', 'R', 'R', 'R']);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);

        function formatRp($value)
        {
            return isset($value) && is_numeric($value)
                ? 'Rp ' . number_format($value, 0, ',', '.')
                : '-';
        }

        $total_pemasukan = 0;
        $total_pengeluaran = 0;

        foreach ($data_mutasi as $i => $row) {

            $tgl = !empty($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
            $jenis_transaksi = ($row['jenis_transaksi'] === 'Debet')
                ? 'Pemasukan'
                : (($row['jenis_transaksi'] === 'Kredit') ? 'Pengeluaran' : '-');

            $no_transaksi = ($jenis_transaksi === 'Pemasukan')
                ? ($row['no_pettycash'] ?? '-')
                : ($row['no_bpkk_cab'] ?? '-');

            $ket = $row['keterangan'] ?? '-';

            $pemasukan   = isset($row['total_debet_cab']) ? (float)$row['total_debet_cab'] : null;
            $pengeluaran = isset($row['total_kredit_cab']) ? (float)$row['total_kredit_cab'] : null;

            $saldo = ($jenis_transaksi === 'Debet')
                ? '-'
                : (isset($row['sisa_saldo']) ? (float)$row['sisa_saldo'] : null);

            $total_pemasukan += $pemasukan ?? 0;
            $total_pengeluaran += $pengeluaran ?? 0;

            $pdf->Row([
                $i + 1,
                $tgl,
                $jenis_transaksi,
                $no_transaksi,
                $ket,
                formatRp($pemasukan),
                formatRp($pengeluaran),
                formatRp($saldo)
            ]);
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(187, 6, 'Total Pemasukan', 1, 0, 'R');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(90, 6, formatRp($total_pemasukan), 1, 1, 'L', true);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(187, 6, 'Total Pengeluaran', 1, 0, 'R');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(90, 6, formatRp($total_pengeluaran), 1, 1, 'R', true);

        $nama_file = 'Rekapan_Pengeluaran_Kas_Kecil_' . date('Ymd') . '.pdf';
        $pdf->Output('I', $nama_file);
    }

    public function export_excel()
    {
        ob_end_clean();
        $this->load->model('M_pettycash');

        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $jenis_saldo = $this->input->get('jenis_saldo');

        // Ambil data BPKK
        if ($awal && $akhir) {
            $data_mutasi = $this->M_pettycash->filterMutasi($awal, $akhir);
        } else {
            $data_mutasi = $this->db->get('tb_data_mutasi')->result_array();
        }

        $user_address = $this->fungsi->user_login()->address_user ?? '';
        $kode_saldo = 'BMG';
        switch ($user_address) {
            case 'jakarta':
                $kode_saldo = 'JKT';
                break;
            case 'balikpapan':
                $kode_saldo = 'BPP';
                break;
            case 'karimun':
                $kode_saldo = 'TBK';
                break;
            case 'galang':
                $kode_saldo = 'LU';
                break;
            case 'sekupang':
                $kode_saldo = 'PA_BBM';
                break;
        }

        $perusahaan = 'BIAS MANDIRI GROUP';
        $pj = $this->db->get_where('tb_penanggung_jawab', ['jenis_saldo' => $kode_saldo])->row_array();
        if ($pj && isset($pj['perusahaan'])) {
            $perusahaan = $pj['perusahaan'];
        }

        require_once APPPATH . 'third_party/PhpSpreadsheet/autoload.php';
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Rekapan BPKK');

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'REKAP PENGELUARAN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', $perusahaan);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        if ($awal && $akhir) {
            $firstDate = new DateTime($awal);
            $lastDate = new DateTime($akhir);
            $periode = $firstDate->format('d M') . ' - ' . $lastDate->format('d M Y');

            $sheet->mergeCells('F4:H4');
            $sheet->setCellValue('F4', 'Periode ' . $periode);
            $sheet->getStyle('F4')->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle('F4')->getAlignment()->setHorizontal('left');
        }

        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal');
        $sheet->setCellValue('C6', 'Trasaksi');
        $sheet->setCellValue('D6', 'No BPKK');
        $sheet->setCellValue('E6', 'Keterangan');
        $sheet->setCellValue('F6', 'Pemasukan');
        $sheet->setCellValue('G6', 'Pengeluaran');
        $sheet->setCellValue('H6', 'Sisa Saldo');

        $headerStyle = [
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
        ];
        $sheet->getStyle('A6:H6')->applyFromArray($headerStyle);

        $row_excel = 7;
        $no = 1;
        $first_data_row = $row_excel;

        foreach ($data_mutasi as $row) {
            $sheet->setCellValue("A{$row_excel}", $no++);
            $sheet->setCellValue("B{$row_excel}", date('d/m/Y', strtotime($row['tanggal'])));
            $sheet->setCellValue("C{$row_excel}", $row['jenis_transaksi']);
            $sheet->setCellValue("D{$row_excel}", $row['no_bpkk_cab']);
            $sheet->setCellValue("E{$row_excel}", $row['keterangan']);
            $sheet->setCellValue("F{$row_excel}", $row['total_debet_cab']);
            $sheet->setCellValue("G{$row_excel}", $row['total_kredit_cab']);
            $sheet->setCellValue("H{$row_excel}", $row['sisa_saldo']);

            $sheet->getStyle("A{$row_excel}:A{$row_excel}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row_excel}:C{$row_excel}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle("F{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle("G{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle("H{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');

            $sheet->getStyle("A{$row_excel}:H{$row_excel}")
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $row_excel++;
        }

        $sheet->mergeCells("A{$row_excel}:E{$row_excel}");
        $sheet->setCellValue("A{$row_excel}", "Total Pemasukan");
        $sheet->getStyle("A{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A{$row_excel}")->getFont()->setBold(true);

        $sheet->mergeCells("F{$row_excel}:H{$row_excel}");
        $sheet->setCellValue("F{$row_excel}", "=SUM(F{$first_data_row}:F" . ($row_excel - 1) . ")");
        $sheet->getStyle("F{$row_excel}:H{$row_excel}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ],
        ]);

        $sheet->getStyle("F{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
        $sheet->getStyle("F{$row_excel}")->getFont()->setBold(true);
        $sheet->getStyle("F{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $row_excel++;

        $sheet->mergeCells("A{$row_excel}:E{$row_excel}");
        $sheet->setCellValue("A{$row_excel}", "Total Pengeluaran");
        $sheet->getStyle("A{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A{$row_excel}")->getFont()->setBold(true);

        $sheet->mergeCells("F{$row_excel}:H{$row_excel}");
        $sheet->setCellValue("F{$row_excel}", "=SUM(G{$first_data_row}:G" . ($row_excel - 1) . ")");
        $sheet->getStyle("F{$row_excel}:H{$row_excel}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ],
        ]);

        $sheet->getStyle("F{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
        $sheet->getStyle("F{$row_excel}")->getFont()->setBold(true);
        $sheet->getStyle("F{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A{$row_excel}:H{$row_excel}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        if ($awal && $akhir) {
            $firstDate = new DateTime($awal);
            $lastDate = new DateTime($akhir);
            $awal_format = $firstDate->format('d-m-Y');
            $akhir_format = $lastDate->format('d-m-Y');

            $filename = "Rekapan BPKK_{$awal_format}_s.d._{$akhir_format}.xls";
        } else {
            $filename = 'Rekapan_BPKK_' . date('Ymd') . '.xls';
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($excel);
        $writer->save('php://output');
        exit;
    }
}