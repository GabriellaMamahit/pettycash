<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/fpdf/fpdf.php';

class R_pdf extends FPDF
{
    public $isRekap = false;
    var $widths;
    var $aligns;

    // ✅ Tambahkan penyimpan periode
    public $tglAwal;
    public $tglAkhir;

    // ============================
    // Setter Periode PDF
    // ============================
    public function setPeriode($awal, $akhir)
    {
        $this->tglAwal  = $awal;
        $this->tglAkhir = $akhir;
    }

    public function getCabangAlias($alamat)
    {
        switch (strtolower($alamat)) {
            case 'jakarta':
                return 'JKT';
            case 'balikpapan':
                return 'BPP';
            case 'karimun':
                return 'TBK';
            case 'galang':
                return 'LU';
            case 'sekupang':
                return 'PA_BBM';
            default:
                return null;
        }
    }

    public function getNamaPerusahaan($alamat)
    {
        $ci = &get_instance();
        $ci->db->where('jenis_saldo', $this->getCabangAlias($alamat));
        $data = $ci->db->get('tb_penanggung_jawab')->row();

        return $data ? $data->perusahaan : 'BIAS MANDIRI GROUP';
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
    // HEADER PDF
    // ============================
    function Header()
    {
        $this->Rect(5, 5, 287, 200);
        $this->Image(FCPATH . 'assets/images/logo/logo_bmg.jpg', 10, 8, 20);

        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(120, 8);
        $this->Cell(30, 10, 'REKAP PENGELUARAN KAS KECIL', 0, 1, 'C');

        // 🔥 ambil perusahaan dari cabang user login
        $ci = &get_instance();
        $alamatUser = strtolower($ci->fungsi->user_login()->address_user);
        $namaPerusahaan = $this->getNamaPerusahaan($alamatUser);

        $this->SetXY(100, 14);
        $this->Cell(70, 10, strtoupper($namaPerusahaan), 0, 1, 'C');

        // ================= PERIODE =================
        $periodAwal  = $this->tglAwal ? date('d F Y', strtotime($this->tglAwal)) : '-';
        $periodAkhir = $this->tglAkhir ? date('d F Y', strtotime($this->tglAkhir)) : '-';

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(207, 5);
        $this->Cell(85, 10, 'PERIODE', 1, 1, 'C');

        $this->SetXY(207, 15);
        $this->Cell(85, 10, $periodAwal . " - " . $periodAkhir, 1, 1, 'C');

        $this->Line(5, 28, 292, 28);

        if ($this->isRekap) return;

        // HEADER TABEL
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
}