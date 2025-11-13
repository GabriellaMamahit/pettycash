<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Pengajuan_pettycash extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_pettycash');
    }

    private function getKodeCabangFromAddress($address_user)
    {
        switch (strtolower($address_user)) {
            case 'jakarta':
                return 'JKT';
            case 'balikpapan':
                return 'BPP';
            case 'karimun':
                return 'TBK';
            case 'galang':
                return 'LU';
            case 'sekupang':
                return 'PA';
            default:
                return 'BMG';
        }
    }

    private function getJenisPettyCashFromAddress($address_user)
    {
        switch (strtolower($address_user)) {
            case 'jakarta':
                return 'JKT';
            case 'balikpapan':
                return 'BPP';
            case 'karimun':
                return 'TBK';
            case 'galang':
                return 'LU';
            default:
                return 'BMG'; // fallback untuk selain Sekupang
        }
    }

    private function getJenisPettyCashCek($address_user)
    {
        switch (strtolower($address_user)) {
            case 'jakarta':
                return 'JKT';
            case 'balikpapan':
                return 'BPP';
            case 'karimun':
                return 'TBK';
            case 'galang':
                return 'LU';
            case 'sekupang':
                return 'PA'; // langsung PA
            default:
                return 'BMG';
        }
    }

    public function index()
    {
        $address_user = $this->fungsi->user_login()->address_user;
        $leveluser = $this->fungsi->user_login()->level;
        $SBU = $this->fungsi->user_login()->sbu;
        $sbu_unit = $this->fungsi->user_login()->sbu_unit;
        $kode_cabang = $this->getKodeCabangFromAddress($address_user);
        $jenis_petty_cash_default = $this->getJenisPettyCashFromAddress($address_user); // yang baru
        $jenispettycashcek = $this->getJenisPettyCashCek($address_user); // yang baru

        $no_petty_cash = $this->M_pettycash->generatePettycashNumber($kode_cabang);

        $tanggal_hari_ini = date('d/m/Y');

        $data = array(
            'judul' => "Petty Cash BMG - Permintaan Saldo",
            'tanggal_hari_ini' => $tanggal_hari_ini,
            'no_petty_cash' => $no_petty_cash,
            'sbu' => $SBU,
            'sbu_unit' => $sbu_unit,
            'address_user' => $address_user,
            'jenis_petty_cash_default' => $jenis_petty_cash_default,
            'jenispettycashcek' => $jenispettycashcek,
            // 'rowlistbpkk' => $this->M_pettycash->getlistbpkkwaiting(),
            'rowpermintaansaldo' => $this->M_pettycash->getlistpermintaansaldo($leveluser, $address_user),
        );

        $this->template->load('template', 'pengajuan_pettycash', $data);
    }

    public function get_tabel_bpkk_by_jenis()
    {
        $jenis_saldo = $this->input->post('jenis_saldo');
        $user_cabang = $this->fungsi->user_login()->sbu_unit;
        $user_saldo = $this->fungsi->user_login()->address_user;

        $this->db->select('*');
        $this->db->from('tb_bpkk_cab');
        $this->db->where('jenis_saldo', $jenis_saldo);
        // $this->db->where('sbu_unit', $user_cabang);
        $this->db->where('no_pc_saldo IS NULL');
        $this->db->where_in('status_cab', ['In progress', 'Rejected']);
        $this->db->where('status_bpkk', 'Done');
        $this->db->order_by('id_bpkk_cab', 'DESC');
        $query = $this->db->get();

        $data = [];
        $total = 0;
        $no = 1;

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = [
                    'no' => $no++,
                    'tanggal' => date('d/m/Y', strtotime($row['tgl_kredit_cab'])),
                    'keterangan' => $row['ket_bpkk_cab'],
                    'total' => 'Rp. ' . number_format($row['total_kredit_cab'], 0, ',', '.'),

                    'status' => $row['status_cab'],
                ];
                $total += $row['total_kredit_cab'];
            }
        } else {
            // Fallback jika tidak ada data di tb_bpkk_cab
            $this->db->select('saldo_cabang');
            $this->db->from('tb_saldo_cabang');
            $this->db->where('jenis_saldo', $jenis_saldo);
            $this->db->where('kantor_cabang', $user_saldo); // ini penting: match 'address_user' dengan 'kantor_cabang'
            $row = $this->db->get()->row();

            if ($row) {
                $total = $row->saldo_cabang;
            }
        }

        $response = [
            'table_data' => $data,
            'total_debet' => $total
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_sisa_saldo_by_jenis()
    {
        $jenis_saldo = $this->input->post('jenis_saldo');
        $data = $this->db->select('saldo_pettycash')
            ->from('tb_saldo')
            ->where('jenis_saldo', $jenis_saldo)
            ->get()
            ->row();

        $saldo = $data ? $data->saldo_pettycash : 0;

        echo json_encode(['saldo_pettycash' => $saldo]);
    }

    public function tambahpengajuanpettycash()
    {
        $namauser               = $this->fungsi->user_login()->nama_user;
        $no_petty_cash          = $this->input->post('no_pettycash');
        $keterangan             = $this->input->post('keterangan');
        $total_debet            = $this->input->post('totalDebetRaw');
        $sisasaldo_rembesment   = $this->input->post('sisaSaldoRaw');
        $jenis_petty_cash       = $this->input->post('jenis_petty_cash');
        $sbu                    = $this->input->post('sbu');
        $sbu_unit               = $this->input->post('sbu_unit');
        $kantor_cabang          = $this->input->post('kantor_cab');
        $kode_kantorcab         = $this->input->post('kode_kantorcab');

        $cleaned_filename = str_replace('/', '_', $no_petty_cash);
        $upload_folder    = './uploads/ppt/';
        $file_name        = 'PPT_' . $cleaned_filename . '.pdf';

        $config['upload_path']   = $upload_folder;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 1048;
        $config['encrypt_name']  = FALSE;
        $config['file_name']     = $file_name;

        $this->load->library('upload', $config);
        $filename = null;

        if (!$this->upload->do_upload('formFile')) {
            $error = $this->upload->display_errors('', ''); // ambil pesan tanpa <p></p>

            // cek tipe error biar bisa kasih pesan custom
            if (strpos($error, 'filetype') !== false) {
                $error_message = 'File harus dalam format PDF.';
            } elseif (strpos($error, 'exceeds the maximum allowed size') !== false) {
                $error_message = 'Ukuran file terlalu besar, maksimal 1 MB.';
            } else {
                $error_message = 'Ukuran file terlalu besar, maksimal 1 MB.';
            }

            $this->session->set_flashdata('error', $error_message);
            redirect('pengajuan_pettycash');
            return;
        } else {
            $filename = $file_name;
        }

        // database tb_nopettycash
        $data = [
            'no_petty_cash'          => $no_petty_cash,
            'jenis_saldo'           => $jenis_petty_cash,
            'kantor_cab'            => $kantor_cabang,
        ];

        // database tb_permintaan_saldo
        $data2 = [
            'no_pettycash'          => $no_petty_cash,
            'tanggal_pettycash'     => date('Y-m-d H:i:s'),
            'ket_pettycash'         => $keterangan,
            'saldo_pettycash'       => $total_debet,
            'jenis_saldo'           => $jenis_petty_cash,
            'direktorat_pettycash'  => $sbu,
            'sbu_pettycash'         => $sbu_unit,
            'kantor_cab'            => $kantor_cabang,
            'dokumen_pettycash'     => $filename,
            'status_permintaan'     => 'Waiting'
        ];

        // update status dan no pettycash baru di tb_bpkk_cab
        $data3 = [
            'no_pc_saldo'          => $no_petty_cash,
            'rembesment'          => 'Close',
        ];

        // update status dan no pettycash baru di tb_data_mutasi
        $data4 = [
            'status_mutasi'          => 'Close',
        ];

        // database tb_notifikasi
        $data5 = [
            'jenis_saldo'           => $jenis_petty_cash,
            'no_pettycash'          => $no_petty_cash,
            'tanggal_notifikasi'    => date('Y-m-d H:i:s'),
            'jenis_notifikasi'      => 'Permintaan',
            'nama_penanggung_jwb'   => $namauser,
            'judul_notifikasi'      => 'Permintaan Reimbursement',
            'ket_notifikasi'        => 'Pemintaan reimbursement petty cash ' . $kantor_cabang,
            'status_notifikasi'     => '0',
            'id_data'               => $kode_kantorcab,
        ];

        // database tb_sisasaldo_rembes
        $data6 = [
            'no_pettycash'              => $no_petty_cash,
            'ket_pettycash'             => $keterangan,
            'saldo_pettycash_remb'      => $total_debet,
            'sisasaldo_remb'            => $sisasaldo_rembesment,
            'jenis_saldo'               => $jenis_petty_cash,
            'sbu_pettycash'             => $sbu_unit,
            'status_sisasaldo_remb'     => 'Pending'
        ];

        // update no pettycash baru di tb_sisasaldo
        $data7 = [
            'no_pc_saldo'          => $no_petty_cash,
        ];

        // database tb_dokumen_remb
        $data8 = [
            'no_pettycash'          => $no_petty_cash,
            'nama_dokumenremb'     => 'Approve-' . $filename,
            'jenis_saldo'           => $jenis_petty_cash,
        ];

        $this->M_pettycash->simpan_no_pettycash('tb_nopettycash', $data);
        $this->M_pettycash->simpan_pengajuan_pettycash('tb_permintaan_saldo', $data2);
        $this->M_pettycash->updatebpkkcab($jenis_petty_cash, $data3);
        $this->M_pettycash->updatestatusmutasi($jenis_petty_cash, $data4);
        $this->M_pettycash->simpan_notifikasi('tb_notifikasi', $data5);
        $this->M_pettycash->tambahrembespending('tb_sisasaldo_rembes', $data6);
        $this->M_pettycash->updatesisasaldopending($jenis_petty_cash, $data7);
        $this->M_pettycash->simpandokumenapprove('tb_dokumen_remb', $data8);
        // $this->M_pettycash->update_no_pc_saldo_bpkk($jenis_petty_cash, $no_petty_cash);
        $this->session->set_flashdata('success', 'Pengajuan reimbursement saldo petty cash berhasil diajukan.');
        redirect('pengajuan_pettycash');
    }


    public function get_data_bpkk_by_nopettycash()
    {
        $no_pettycash = $this->input->post('no_pettycash');
        $data = $this->M_pettycash->get_data_bpkk_by_no($no_pettycash);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'tanggal'             => date('d/m/Y', strtotime($row['tgl_kredit_cab'])),
                'keterangan'          => $row['ket_bpkk_cab'],
                'total'               => 'Rp. ' . number_format($row['total_kredit_cab'], 0, ',', '.'),
                'status'              => $row['status_cab'],
                'jenis_saldo'         => $row['jenis_saldo'],
                'upload_file_cab'     => $row['upload_file_cab'],
            ];
        }

        echo json_encode($result);
    }

    public function cek_bpkk_ready()
    {
        $jenis_saldo = $this->input->post('jenis_saldo');

        $cek = $this->db->where('jenis_saldo', $jenis_saldo)
            ->where('status_cab', 'In progress')
            ->where('status_bpkk', 'Done')
            ->get('tb_bpkk_cab')
            ->num_rows();

        echo json_encode([
            'allow' => $cek > 0 // true kalau ada data selesai
        ]);
    }

    public function export_excel()
    {
        $no_pettycash = urldecode($this->input->get('no_pettycash'));

        if (empty($no_pettycash)) {
            echo "No Petty Cash tidak ditemukan.";
            return;
        }

        // $this->load->model('M_pettycash');
        $rekap = $this->M_pettycash->get_rekap_pengeluaran($no_pettycash);

        if (empty($rekap['detail'])) {
            show_error('Data pengeluaran tidak ditemukan untuk No Petty Cash: ' . $no_pettycash);
            return;
        }

        $noPettyCash = isset($rekap['header']['no_pettycash']) ? $rekap['header']['no_pettycash'] : $no_pettycash;

        // Ambil periode dari detail tb_bpkk_cab
        $firstDate = \DateTime::createFromFormat('Y-m-d', $rekap['detail'][0]['tanggal_bpkk']);
        $lastDate = \DateTime::createFromFormat('Y-m-d', end($rekap['detail'])['tanggal_bpkk']);
        $periode = $firstDate->format('d M') . ' - ' . $lastDate->format('d M Y');

        // Ambil header petty cash untuk jenis_saldo
        $header_pc = $this->db->get_where('tb_permintaan_saldo', ['no_pettycash' => $no_pettycash])->row_array();
        $jenis_saldo = isset($header_pc['jenis_saldo']) ? $header_pc['jenis_saldo'] : null;

        $perusahaan = 'Bias Mandiri Group'; // default
        if ($jenis_saldo) {
            $pj = $this->db->get_where('tb_penanggung_jawab', ['jenis_saldo' => $jenis_saldo])->row_array();
            if ($pj && isset($pj['perusahaan'])) {
                $perusahaan = $pj['perusahaan'];
            }
        }

        // Ambil Budget Saldo Petty Cash dari tb_saldo_cabang
        $budget_saldo = 0;
        if ($jenis_saldo) {
            $saldo_cabang = $this->db->get_where('tb_saldo_cabang', ['jenis_saldo' => $jenis_saldo])->row_array();
            if ($saldo_cabang && isset($saldo_cabang['saldo_cabang'])) {
                $budget_saldo = (float)$saldo_cabang['saldo_cabang'];
            }
        }


        // Load autoload manual PhpSpreadsheet
        require_once APPPATH . 'third_party/PhpSpreadsheet/autoload.php';

        // Panggil namespace (tanpa "use" di dalam function)
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Rekap Pengeluaran');

        // Header
        $sheet->mergeCells('A1:N1');
        $sheet->setCellValue('A1', 'REKAP PENGELUARAN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A2:N2');
        $sheet->setCellValue('A2', $perusahaan);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A4:C4');
        $sheet->setCellValue('A4', 'Budget Saldo Petty Cash');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('Left');

        $sheet->mergeCells('D4:E4');
        $sheet->setCellValue('D4', ': Rp ' . number_format($budget_saldo, 0, ',', '.'));
        $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('D4')->getAlignment()->setHorizontal('Left');

        $sheet->mergeCells('A5:C5');
        $sheet->setCellValue('A5', 'Saldo Awal');
        $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal('Left');

        $sheet->mergeCells('D5:E5');
        // $sheet->setCellValue('D5', ': Rp. 988.000');
        $sheet->getStyle('D5')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('D5')->getAlignment()->setHorizontal('Left');

        $sheet->mergeCells('K4:N4');
        $sheet->setCellValue('K4', 'Periode ' . $periode);
        $sheet->getStyle('K4')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('K4')->getAlignment()->setHorizontal('Left');

        $sheet->mergeCells('K5:N5');
        $sheet->setCellValue('K5', 'No Petty Cash : ' . $noPettyCash);
        $sheet->getStyle('K5')->getFont()
            ->setBold(true)
            ->setSize(11)
            ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED); // warna merah
        $sheet->getStyle('K5')->getAlignment()->setHorizontal('left');

        // Header tabel
        $headers = [
            'A9' => 'No',
            'B9' => 'Tanggal',
            'D9' => 'No BPKK',
            'G9' => 'Keterangan',
            'J9' => 'Pemasukan',
            'K9' => 'Pengeluaran',
            'M9' => 'Sisa Saldo'
        ];
        foreach ($headers as $cell => $title) {
            $sheet->setCellValue($cell, $title);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal('center');
        }

        $sheet->mergeCells('B9:C9');
        $sheet->mergeCells('D9:F9');
        $sheet->mergeCells('G9:I9');
        $sheet->mergeCells('K9:L9');
        $sheet->mergeCells('M9:N9');

        $sheet->getStyle('A9:N9')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // === DATA ===
        $row = 10;
        $no = 1;
        $last_sisa_saldo = 0;

        foreach ($rekap['detail'] as $r) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->getStyle("A{$row}:A{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Tanggal
            $sheet->mergeCells("B{$row}:C{$row}");
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTime($r['tanggal_bpkk']));
            $sheet->setCellValue("B{$row}", $date);
            $sheet->getStyle("B{$row}:C{$row}")
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->getStyle("B{$row}:C{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // No BPKK
            $sheet->mergeCells("D{$row}:F{$row}");
            $sheet->setCellValue("D{$row}", $r['no_bpkk']);
            $sheet->getStyle("D{$row}:F{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Keterangan
            $sheet->mergeCells("G{$row}:I{$row}");
            $sheet->setCellValue("G{$row}", $r['keterangan_bpkk']);
            $sheet->getStyle("G{$row}:I{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Pemasukan
            $sheet->setCellValue("J{$row}", isset($r['pemasukan']) ? $r['pemasukan'] : '-');
            $sheet->getStyle("J{$row}")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Pengeluaran
            $sheet->mergeCells("K{$row}:L{$row}");
            $pengeluaran = (float)preg_replace('/[^\d]/', '', $r['pengeluaran']);
            $sheet->setCellValue("K{$row}", $pengeluaran);
            $sheet->getStyle("K{$row}:L{$row}")
                ->getNumberFormat()
                ->setFormatCode('[$Rp-421] #,##0');
            $sheet->getStyle("K{$row}:L{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Sisa Saldo
            $sheet->mergeCells("M{$row}:N{$row}");
            $sisa_saldo = (float)preg_replace('/[^\d]/', '', $r['sisa_saldo']);
            $sheet->setCellValue("M{$row}", $sisa_saldo);
            $sheet->getStyle("M{$row}:N{$row}")
                ->getNumberFormat()
                ->setFormatCode('[$Rp-421] #,##0');
            $sheet->getStyle("M{$row}:N{$row}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $last_sisa_saldo = $sisa_saldo;
            $row++;
        }

        $sheet->setCellValue('D5', ': Rp ' . number_format($last_sisa_saldo, 0, ',', '.'));

        // ===== TOTAL PENGELUARAN =====
        $startDataRow = 10;
        $endDataRow = $row - 1;
        $sheet->mergeCells("A{$row}:J{$row}");
        $sheet->setCellValue("A{$row}", "Total Pengeluaran");

        // RATA KIRI HANYA UNTUK TEKS
        $sheet->getStyle("A{$row}:J{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("K{$row}:L{$row}");
        $sheet->setCellValue("K{$row}", "=SUM(K{$startDataRow}:K{$endDataRow})");

        $sheet->mergeCells("M{$row}:N{$row}");
        $sheet->setCellValue("M{$row}", '');

        $sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:N{$row}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle("K{$row}:L{$row}")
            ->getNumberFormat()
            ->setFormatCode('[$Rp-421] #,##0');

        // RATA TENGAH UNTUK ANGKA TOTAL
        $sheet->getStyle("K{$row}:N{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $totalRow = $row; // simpan baris total pengeluaran

        $row++;

        // ===== TOTAL SISA SALDO (ambil dari nilai terakhir) =====
        $sheet->mergeCells("A{$row}:J{$row}");
        $sheet->setCellValue("A{$row}", "Total Sisa Saldo");

        // RATAKAN KE KIRI HANYA UNTUK TEKS “Total Sisa Saldo”
        $sheet->getStyle("A{$row}:J{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells("K{$row}:L{$row}");
        $sheet->setCellValue("K{$row}", '');

        $sheet->mergeCells("M{$row}:N{$row}");
        $sheet->setCellValue("M{$row}", $last_sisa_saldo);
        $sheet->getStyle("M{$row}:N{$row}")
            ->getNumberFormat()
            ->setFormatCode('[$Rp-421] #,##0');

        $sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:N{$row}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // RATAKAN KE TENGAH UNTUK SEMUA SEL LAIN (SUPAYA ANGKA TETAP CENTER)
        $sheet->getStyle("K{$row}:N{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $row++;

        // ===== PENGAJUAN SALDO =====
        $sheet->mergeCells("A{$row}:J{$row}");
        $sheet->setCellValue("A{$row}", "Pengajuan Saldo");

        // RATA KANAN UNTUK TEKS
        $sheet->getStyle("A{$row}:J{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->mergeCells("K{$row}:N{$row}");

        // Ambil hasil sum dari total pengeluaran (bukan hitung ulang)
        $sheet->setCellValue("K{$row}", "=K{$totalRow}");

        // Format sebagai Rupiah
        $sheet->getStyle("K{$row}")
            ->getNumberFormat()
            ->setFormatCode('[$Rp-421] #,##0');

        // Styling umum
        $sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:N{$row}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // ANGKA TETAP DI TENGAH
        $sheet->getStyle("K{$row}:N{$row}")
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // === OUTPUT ===
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rekap_Pengeluaran_' . $no_pettycash . '.xls"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($excel);
        $writer->save('php://output');
    }

    public function cetak_approval()
    {
        // Mulai buffer output (hindari PDF corrupt)
        ob_start();

        $id = $this->input->get('id');
        $jenis_saldo = $this->input->get('jenis_saldo');

        // Ambil data berdasarkan id
        $this->db->where('id_pettycash', $id);
        $data = $this->db->get('tb_permintaan_saldo')->row();

        if (!$data) {
            show_error("Data petty cash tidak ditemukan berdasarkan ID $id", 400);
            return;
        }

        // Ambil no_pettycash dari database
        $no_pettycash = $data->no_pettycash;

        if (empty($no_pettycash) || empty($jenis_saldo)) {
            show_error("No pettycash atau jenis saldo tidak ditemukan", 400);
            return;
        }

        $this->load->library('A_pdf');
        $this->load->model('M_pettycash');

        $pdf = new A_pdf('L', 'mm', 'A4');

        // ✅ Set data petty cash ke PDF (penting!)
        $pdf->setDataPetty($jenis_saldo, $no_pettycash);

        // ✅ Ambil Data
        $rows       = $this->M_pettycash->getByNoPettycash($no_pettycash, $jenis_saldo);
        $rows_all   = $this->M_pettycash->getByNoPettycash_All($no_pettycash, $jenis_saldo);
        $saldo_awal = $this->M_pettycash->getSaldoAwalByNoPetty($jenis_saldo);

        if (!$saldo_awal) {
            show_error("Saldo awal petty cash tidak ditemukan", 400);
            return;
        }

        $debetsaldo = $saldo_awal->saldo_debet;

        // ✅ Hitung total pengeluaran
        $total_pengeluaran = 0;
        foreach ($rows as $row) {
            $total_pengeluaran += $row->total_kredit_cab ?? 0;
        }

        // ✅ Hitung running saldo
        $running_saldo_list = [];
        $sisa_saldo = $debetsaldo;
        foreach ($rows_all as $row) {
            $sisa_saldo -= $row->total_kredit_cab;
            $running_saldo_list[$row->id_bpkk_cab] = $sisa_saldo;
        }

        // =============================
        //  HALAMAN UTAMA
        // =============================
        $pdf->AddPage();
        $pdf->SetWidths([9, 20, 45, 113, 30, 30, 30]);
        $pdf->SetAligns(['C', 'C', 'L', 'L', 'C', 'R', 'R']);
        $pdf->SetFont('Arial', '', 9);

        $count = 0;
        $rowsPerPage = 10;

        foreach ($rows as $i => $row) {
            $pdf->Row([
                $i + 1,
                date('d/m/Y', strtotime($row->tgl_kredit_cab)),
                $row->no_bpkk_cab,
                $row->ket_bpkk_cab,
                '-',
                "Rp " . number_format($row->total_kredit_cab, 0, ',', '.'),
                "Rp " . number_format($running_saldo_list[$row->id_bpkk_cab] ?? 0, 0, ',', '.')
            ]);

            $count++;
            if ($count == $rowsPerPage && $i < count($rows) - 1) {
                $pdf->AddPage();
                $count = 0;
            }
        }

        // ✅ Total & sisa saldo
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(217, 6, 'Total Pengeluaran', 1, 0, 'L');
        $pdf->Cell(30, 6, 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(30, 6, '', 1, 1, 'C');

        $pdf->Cell(217, 6, 'Sisa Saldo', 1, 0, 'L');
        $pdf->Cell(30, 6, '', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp ' . number_format($sisa_saldo, 0, ',', '.'), 1, 1, 'C');

        // =============================
        //  HALAMAN REKAP
        // =============================
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

        // Isi tabel dari hasil rekap
        $pdf->SetFont('Arial', '', 11);
        $no = 1;
        foreach ($rekap as $jenis => $jumlah) {
            $namaItem = ucwords(str_replace('_', ' ', $jenis));
            $pdf->SetX($marginLeft);
            $pdf->Cell(9, 6, $no++, 1, 0, 'C');   // No urut
            $pdf->Cell(80, 6, $namaItem, 1, 0, 'L'); // Nama Item
            $pdf->Cell(60, 6, $jumlah, 1, 1, 'C'); // Total Pengeluaran Item
        }

        // =============================
        //  SIMPAN & TAMPILKAN PDF
        // =============================
        $filename = 'Approve-' . str_replace(['/', ' '], '_', $no_pettycash) . '.pdf';
        $folderPath = FCPATH . 'uploads/approve/' . $jenis_saldo . '/';
        $savePath   = $folderPath . $filename;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $pdf->SetTitle($filename);
        $pdf->Output($savePath, 'F');

        // ✅ Bersihkan buffer sebelum output PDF
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        $pdf->Output('I', $filename);
    }
}