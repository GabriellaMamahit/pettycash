<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/fpdf/fpdf.php';

class A_pdf extends FPDF
{
    public $isRekap = false;
    var $widths;
    var $aligns;

    public $jenis_saldo; // property untuk kode cabang
    public $no_pettycash; // property untuk nomor petty cash

    // ============================
    // Setter untuk data petty cash
    // ============================
    public function setDataPetty($jenis_saldo, $no_pettycash)
    {
        $this->jenis_saldo   = $jenis_saldo;
        $this->no_pettycash  = $no_pettycash;
    }

    // ============================
    // Set width & align tabel
    // ============================
    function SetWidths($w)
    {
        $this->widths = $w;
    }
    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    // ============================
    // Row multi-line
    // ============================
    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 6 * $nb;

        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage();

        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 6, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else $i++;
        }
        return $nl;
    }

    // ============================
    // Header
    // ============================
    function Header()
    {
        $CI = &get_instance();
        $CI->load->model('M_pettycash');

        // Ambil data header dari database berdasarkan jenis_saldo dan no_pettycash
        $kantor = $CI->M_pettycash->getpenanggungjawabpc($this->jenis_saldo);
        $pengeluaranbpkkjkt = $CI->M_pettycash->getByNoPettycash($this->no_pettycash, $this->jenis_saldo);
        $rows_all = $CI->M_pettycash->getByNoPettycash_All($this->no_pettycash, $this->jenis_saldo);
        $budgetcabang = $CI->M_pettycash->getbudgetcabang($this->jenis_saldo);
        $saldo_awal_jkt = $CI->M_pettycash->getSaldoCabangjkt($this->jenis_saldo);
        $debetsaldo = $saldo_awal_jkt->saldo_debet ?? 0;

        $sisa_saldo = $debetsaldo;
        foreach ($rows_all as $row) {
            $sisa_saldo -= $row->total_kredit_cab ?? 0;
        }

        $dates = array_column($pengeluaranbpkkjkt, 'tgl_kredit_cab');
        $periode_text = empty($dates)
            ? "Periode: Data Kosong"
            : "Periode " . date('d M', strtotime(min($dates))) . " - " . date('d M Y', strtotime(max($dates)));

        // ============================
        // Header Layout
        // ============================
        $this->Rect(5, 5, 287, 200);
        $this->Image(FCPATH . 'assets/images/logo/logo_bmg.jpg', 10, 8, 20);

        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(120, 8);
        $this->Cell(30, 10, 'REKAP PENGELUARAN', 0, 1, 'C');
        $this->SetXY(100, 14);
        $this->Cell(70, 10, $kantor->perusahaan, 0, 1, 'C');

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(207, 5);
        $this->Cell(85, 10, $kantor->kantor, 1, 1, 'C');
        $this->SetXY(207, 15);
        $this->Cell(85, 10, $periode_text, 1, 1, 'C');

        $this->Line(5, 28, 292, 28);

        // Jika halaman rekap, jangan tampilkan saldo dan tabel
        if ($this->isRekap) return;

        // Budget saldo
        $this->SetXY(10, 32);
        $this->Cell(50, 6, 'Budget Saldo Petty Cash', 0, 0, 'L');
        $this->Cell(5, 6, ':', 0, 0, 'L');
        $this->Cell(40, 6, 'Rp ' . number_format($budgetcabang->saldo_cabang ?? 0, 0, ',', '.'), 1, 1, 'L');

        // ✅ Menampilkan No Petty Cash
        $this->SetXY(210, 32);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(80, 6, 'No Petty Cash : ' . strtoupper($this->no_pettycash ?? '-'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);

        // Saldo awal
        $this->SetXY(10, 38);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 6, 'Saldo Awal', 0, 0, 'L');
        $this->Cell(5, 6, ':', 0, 0, 'L');
        $this->Cell(40, 6, 'Rp ' . number_format($sisa_saldo, 0, ',', '.'), 1, 1, 'L');

        // Header tabel
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(9, 6, 'No', 1, 0, 'C');
        $this->Cell(20, 6, 'Date', 1, 0, 'C');
        $this->Cell(45, 6, 'No BPKK', 1, 0, 'C');
        $this->Cell(113, 6, 'Description', 1, 0, 'C');
        $this->Cell(30, 6, 'Pemasukan', 1, 0, 'C');
        $this->Cell(30, 6, 'Pengeluaran', 1, 0, 'C');
        $this->Cell(30, 6, 'Sisa Saldo', 1, 1, 'C');
    }

    // ============================
    // Footer
    // ============================
    function Footer()
    {
        $CI = &get_instance();
        $CI->load->model('M_pettycash');

        // Ambil data penyetuju sesuai cabang
        $penyetuju = $CI->M_pettycash->getpenanggungjawabpc($this->jenis_saldo);

        $this->SetY(-50);
        $this->SetFont('Arial', '', 10);
        $this->Cell(130, 6, 'Dibuat Oleh,', 0, 0, 'C');
        $this->Cell(130, 6, 'Disetujui Oleh,', 0, 1, 'C');

        $this->Ln(15);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(130, 8, $penyetuju->nama_admin ?? '', 0, 0, 'C');
        $this->Cell(130, 8, $penyetuju->nama_atasan ?? '', 0, 1, 'C');

        $this->Cell(130, 6, date('d/m/Y'), 0, 0, 'C');
        $this->Cell(130, 6, date('d/m/Y'), 0, 1, 'C');
    }
}