<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Bukti_pengeluaran_kas_kecil extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_bpkk');
    }

    public function index()
    {
        $user = $this->fungsi->user_login();
        $address_user = $user->address_user;
        $level = $user->level;

        $data = array(
            'judul'  => "Petty Cash | Riwayat BPKK",
            'script' => "bpkk.js",
            'rowbpkk' => $this->M_bpkk->getbpkk($address_user, $level),
        );

        $this->template->load('template', 'laporan_bpkk', $data);
    }

    public function riwayat_bpkk()
    {
        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');

        // Cek apakah format tanggal valid (YYYY-MM-DD)
        if (
            !empty($awal) && !empty($akhir) &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $awal) &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $akhir)
        ) {
            // Ambil data berdasarkan filter
            $rowbpkk = $this->M_bpkk->filterBpkkByDate($awal, $akhir);
        } else {
            // Jika tidak ada filter → tampilkan semua data
            $rowbpkk = $this->db->get('tb_bpkk_cab')->result_array();
        }

        $data = [
            'judul'  => "Petty Cash | Riwayat BPKK",
            'script' => "bpkk.js",
            'rowbpkk' => $rowbpkk,
            'awal' => $awal,
            'akhir' => $akhir,
        ];

        $this->template->load('template', 'riwayat_laporan/riwayat_bpkk', $data);
    }




    // public function index()
    // {
    //     $user = $this->fungsi->user_login();
    //     $address_user = $user->address_user;
    //     $level = $user->level;

    //     // Ambil tanggal dari URL (GET)
    //     $awal  = $this->input->get('awal');
    //     $akhir = $this->input->get('akhir');

    //     // Jika ada filter tanggal → kirim tanggal ke Model
    //     if ($awal && $akhir) {
    //         $rowbpkk = $this->M_bpkk->filterBpkkByDate($address_user, $level, $awal, $akhir);
    //     } else {
    //         // Tanpa filter → data normal
    //         $rowbpkk = $this->M_bpkk->getbpkk($address_user, $level);
    //     }

    //     $data = array(
    //         'judul'  => "Petty Cash | Riwayat BPKK",
    //         'script' => "bpkk.js",
    //         'rowbpkk' => $rowbpkk,
    //         'awal' => $awal,
    //         'akhir' => $akhir,
    //     );

    //     $this->template->load('template', 'laporan_bpkk', $data);
    // }


    public function proses_bpkk()
    {
        $id_bpkk = $this->input->post('id_bpkk');

        if (!$id_bpkk) {
            $this->session->set_flashdata('error', 'ID BPKK tidak valid');
            redirect('Bukti_pengeluaran_kas_kecil');
            return;
        }

        $data = [
            'status_bpkk' => 'Done',
        ];

        $this->M_bpkk->updateStatusBpkk($id_bpkk, $data, 'tb_bpkk_cab');
        $updated = $this->M_bpkk->updateStatusBpkk($id_bpkk, $data, 'tb_bpkk_cab');

        if ($updated) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Status berhasil diperbarui ke Done.'
                ]));
        } else {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui status BPKK.'
                ]));
        }
    }

    public function proses_bpkk_rejected()
    {
        $namauser     = $this->fungsi->user_login()->nama_user;
        $jenis_saldo  = $this->input->post('jenis_saldo');
        $no_pettycash = $this->input->post('no_pettycash');
        $id_bpkk      = $this->input->post('id_bpkk');

        if (!$id_bpkk) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'ID BPKK tidak valid'
                ]));
            return;
        }

        $data = [
            'status_bpkk' => 'Done',
            'status_cab'  => 'Revisi'
        ];

        $data2 = [
            'jenis_saldo'       => $jenis_saldo,
            'jenis_notifikasi'  => 'Revisi',
            'nama_penanggung_jwb' => $namauser,
            'judul_notifikasi'  => 'Revisi BPKK',
            'ket_notifikasi'    => 'Update data BPKK ' . $no_pettycash,
            'no_pettycash'      => $no_pettycash,
            'status_notifikasi' => '0',
            'tanggal_notifikasi' => date('Y-m-d H:i:s')
        ];
        $data3 = [
            'status_mutasi' => 'Close',
            'status_cab' => 'Revisi',
        ];

        $updated = $this->M_bpkk->updateStatusBpkk($id_bpkk, $data, 'tb_bpkk_cab');
        if ($updated) {
            $this->M_bpkk->notifikasiupdatebpkk('tb_notifikasi', $data2);
            $this->M_bpkk->updateStatusBpkkmutasi($no_pettycash, $data3, 'tb_data_mutasi');

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Status berhasil diperbarui ke Done.'
                ]));
        } else {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui status BPKK.'
                ]));
        }
    }


    // public function editpengeluaranbpkk()
    // {
    //     $idbpkk          = $this->input->post('idbpkk');
    //     $nobpkk          = $this->input->post('no_permintaan_bpkk');
    //     $keterangan_bpkk = $this->input->post('keteranganpermintaanbpkk');
    //     $jenis_saldo     = $this->input->post('jenissaldobpkk');
    //     $no_rembesment     = $this->input->post('no_pc_rembes');
    //     $totalBaru       = (int)$this->input->post('total_debet');

    //     // Ambil data lama
    //     $pengeluaran = $this->M_bpkk->getPengeluaranById($idbpkk);
    //     if (!$pengeluaran) {
    //         $this->session->set_flashdata('error', 'Data tidak ditemukan.');
    //         redirect('Bukti_pengeluaran_kas_kecil');
    //         return;
    //     }

    //     $totalLama = (int)$pengeluaran->total_kredit_cab;
    //     $selisih   = $totalBaru - $totalLama;

    //     $permintaan = $this->M_bpkk->getPermintaanSaldoByNo($no_rembesment);
    //     if (!$permintaan) {
    //         $this->session->set_flashdata('error', 'Data permintaan saldo tidak ditemukan.');
    //         redirect('Bukti_pengeluaran_kas_kecil');
    //         return;
    //     }
    //     $saldoPermintaanLama = (int)$permintaan->saldo_pettycash;

    //     // Cek saldo cabang sebelum update (hanya jika selisih positif = tambah debit)
    //     if ($selisih > 0) {
    //         $saldoCabang = $this->M_bpkk->getSaldoCabang($jenis_saldo);
    //         if ($saldoCabang < $selisih) {
    //             $this->session->set_flashdata('error', 'Saldo petty cash cabang tidak mencukupi.');
    //             redirect('Bukti_pengeluaran_kas_kecil');
    //             return;
    //         }
    //         if ($saldoPermintaanLama < $selisih) {
    //             $this->session->set_flashdata('error', 'Saldo petty cash permintaan tidak mencukupi.');
    //             redirect('Bukti_pengeluaran_kas_kecil');
    //             return;
    //         }
    //     }

    //     // Update saldo jika ada perubahan
    //     if ($selisih != 0) {
    //         $this->M_bpkk->adjustSaldoCabang($jenis_saldo, $selisih);

    //         $this->M_bpkk->adjustPermintaanSaldo($no_rembesment, $selisih);
    //     }

    //     // Upload file
    //     $cleaned_keterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $keterangan_bpkk);
    //     $upload_folder = './uploads/BPKK/' . $jenis_saldo . '/';
    //     $file_name_base = $cleaned_keterangan . '.pdf';

    //     if (!is_dir($upload_folder)) mkdir($upload_folder, 0777, true);

    //     $final_file_name = $file_name_base;
    //     $i = 1;
    //     while (file_exists($upload_folder . $final_file_name)) {
    //         $final_file_name = $cleaned_keterangan . '_update' . $i . '.pdf';
    //         $i++;
    //     }

    //     $config['upload_path']   = $upload_folder;
    //     $config['allowed_types'] = 'pdf';
    //     $config['max_size']      = 2048;
    //     $config['file_name']     = $final_file_name;
    //     $config['overwrite']     = false;

    //     $this->load->library('upload', $config);

    //     if (!$this->upload->do_upload('file_dokumen')) {
    //         $error = $this->upload->display_errors();
    //         $this->session->set_flashdata('error', 'Gagal upload file: ' . $error);
    //         redirect('Bukti_pengeluaran_kas_kecil');
    //         return;
    //     }

    //     $upload_data = $this->upload->data();
    //     $file_path   = $upload_data['file_name'];

    //     // (Opsional) Hapus file lama jika perlu
    //     if (!empty($pengeluaran->upload_file_cab) && file_exists($upload_folder . $pengeluaran->upload_file_cab)) {
    //         unlink($upload_folder . $pengeluaran->upload_file_cab);
    //     }

    //     // Update data BPKK
    //     $data = [
    //         'total_kredit_cab' => $totalBaru,
    //         'upload_file_cab'  => $file_path,
    //         'ket_bpkk_cab'     => $keterangan_bpkk
    //     ];

    //     $data2 = [
    //         'total_kredit_cab' => $totalBaru,
    //         'file'             => $file_path,
    //     ];
    //     $this->M_bpkk->updatebpkk($idbpkk, $data, 'tb_bpkk_cab');
    //     $this->M_bpkk->updatebpkkmutasi($nobpkk, $data2, 'tb_data_mutasi');

    //     $this->session->set_flashdata('success', 'Data BPKK berhasil diperbarui.');
    //     redirect('Bukti_pengeluaran_kas_kecil');
    // }

    public function editpengeluaranbpkk()
    {
        $idbpkk          = $this->input->post('idbpkk');
        $nobpkk          = $this->input->post('no_permintaan_bpkk');
        $keterangan_bpkk = $this->input->post('keteranganpermintaanbpkk');
        $jenis_saldo     = $this->input->post('jenissaldobpkk');
        $no_rembesment   = $this->input->post('no_pc_rembes');
        $no_pettycash    = $this->input->post('nopettycash');
        $totalBaru       = (int)$this->input->post('total_debet');
        $kreditpending       = (int)$this->input->post('totalkreditpending');
        $sisasaldopending    = (int)$this->input->post('totalsisasaldopending');

        // Ambil data lama
        $pengeluaran = $this->M_bpkk->getPengeluaranById($idbpkk);
        if (!$pengeluaran) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('Bukti_pengeluaran_kas_kecil');
            return;
        }

        $totalLama = (int)$pengeluaran->total_kredit_cab;
        $selisih   = $totalBaru - $totalLama;

        // ✅ Hanya cek permintaan saldo jika $no_rembesment tidak kosong
        $saldoPermintaanLama = null;
        if (!empty($no_rembesment)) {
            $permintaan = $this->M_bpkk->getPermintaanSaldoByNo($no_rembesment);
            if (!$permintaan) {
                $this->session->set_flashdata('error', 'Data permintaan saldo tidak ditemukan.');
                redirect('Bukti_pengeluaran_kas_kecil');
                return;
            }
            $saldoPermintaanLama = (int)$permintaan->saldo_pettycash;
        }

        // Cek saldo cabang sebelum update (hanya jika selisih positif = tambah debit)
        if ($selisih > 0) {
            $saldoCabang = $this->M_bpkk->getSaldoCabang($jenis_saldo);
            if ($saldoCabang < $selisih) {
                $this->session->set_flashdata('error', 'Saldo petty cash cabang tidak mencukupi.');
                redirect('Bukti_pengeluaran_kas_kecil');
                return;
            }

            if (!empty($no_rembesment) && $saldoPermintaanLama < $selisih) {
                $this->session->set_flashdata('error', 'Saldo petty cash permintaan tidak mencukupi.');
                redirect('Bukti_pengeluaran_kas_kecil');
                return;
            }
        }

        // Update saldo jika ada perubahan
        if ($selisih != 0) {
            $this->M_bpkk->adjustSaldoCabang($jenis_saldo, $selisih);

            if (!empty($no_rembesment)) {
                $this->M_bpkk->adjustPermintaanSaldo($no_rembesment, $selisih);
                $this->M_bpkk->adjustsaldoremb($no_rembesment, $selisih);
                $this->M_bpkk->adjustSisaPermintaanSaldo($no_rembesment, $selisih);
            }
        }

        // ============================
        // 📂 Proses file upload (opsional)
        // ============================
        $file_path = $pengeluaran->upload_file_cab; // default: pakai file lama

        if (!empty($_FILES['file_dokumen']['name'])) {
            // Jika user upload file baru
            $cleaned_keterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $keterangan_bpkk);
            $upload_folder = './uploads/BPKK/' . $jenis_saldo . '/';
            $file_name_base = $cleaned_keterangan . '.pdf';

            if (!is_dir($upload_folder)) mkdir($upload_folder, 0777, true);

            $final_file_name = $file_name_base;
            $i = 1;
            while (file_exists($upload_folder . $final_file_name)) {
                $final_file_name = $cleaned_keterangan . '_update' . $i . '.pdf';
                $i++;
            }

            $config['upload_path']   = $upload_folder;
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 1048;
            $config['file_name']     = $final_file_name;
            $config['overwrite']     = false;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_dokumen')) {
                $error = $this->upload->display_errors('', ''); // hilangkan <p> bawaan CI

                // Custom error message
                if (strpos($error, 'filetype') !== false) {
                    $error_message = 'File harus dalam format PDF.';
                } elseif (strpos(strtolower($error), 'exceeds') !== false) {
                    $error_message = "Ukuran file terlalu besar, maksimal 1 MB.";
                } else {
                    $error_message = "Ukuran file terlalu besar, maksimal 1 MB.";
                }

                $this->session->set_flashdata('error', $error_message);
                redirect('Bukti_pengeluaran_kas_kecil');
                return;
            }

            $upload_data = $this->upload->data();
            $file_path   = $upload_data['file_name'];

            // Hapus file lama kalau ada
            if (!empty($pengeluaran->upload_file_cab) && file_exists($upload_folder . $pengeluaran->upload_file_cab)) {
                unlink($upload_folder . $pengeluaran->upload_file_cab);
            }
        }

        // ============================
        // 💾 Update data ke DB
        // ============================
        $data = [
            'total_kredit_cab' => $totalBaru,
            'upload_file_cab'  => $file_path,
            'ket_bpkk_cab'     => $keterangan_bpkk
        ];

        $data2 = [
            'total_kredit_cab' => $totalBaru,
            'file'             => $file_path,
        ];

        $data3 = [
            'total_kredit_cab' => $totalBaru,
        ];

        $this->M_bpkk->updatebpkk($idbpkk, $data, 'tb_bpkk_cab');
        $this->M_bpkk->updatebpkkmutasi($nobpkk, $data2, 'tb_data_mutasi');
        $this->M_bpkk->updatetotalkreditpending($nobpkk, $data3, 'tb_sisasaldo');

        $saldo_awal = $kreditpending + $sisasaldopending;

        if (!empty($no_pettycash) && !empty($nobpkk)) {
            // echo "CALLING updateSisaSaldoBerantai<BR>";
            // echo "NO PC = $no_pettycash | NO BPKK = $nobpkk<BR>";
            $this->M_bpkk->updateSisaSaldoBerantai($no_pettycash, $nobpkk, $saldo_awal);
            // exit;
        }
        // else {
        //     echo "NO PC ATAU NO BPKK KOSONG<BR>";
        //     exit;
        // }

        // if (!empty($no_pettycash) && !empty($nobpkk)) {
        //     $this->M_bpkk->updateSisaSaldoBerantai($no_pettycash, $nobpkk);
        // }

        $this->session->set_flashdata('success', 'Data Petty Cash berhasil diperbarui.');
        redirect('Bukti_pengeluaran_kas_kecil');
    }

    public function export_pdf()
    {
        $this->load->library('r_pdf');
        $this->load->model('M_bpkk');

        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');

        if ($awal && $akhir) {
            $data_bpkk = $this->M_bpkk->filterBpkkByDate($awal, $akhir);
        } else {
            $data_bpkk = $this->db->get('tb_bpkk_cab')->result_array();
        }

        $pdf = new R_pdf('L', 'mm', 'A4');

        // ✅ Judul tampilan pada PDF Viewer
        $pdf->SetTitle('Rekapan Pengeluaran Kas Kecil', true);

        // ✅ Simpan judul agar header menggunakan ini
        $pdf->title = 'REKAPAN PENGELUARAN KAS KECIL';

        // ✅ Simpan periode (untuk header/subjudul jika digunakan)
        $pdf->setPeriode($awal, $akhir);

        $pdf->SetWidths([9, 20, 45, 113, 30, 30, 30]);
        $pdf->SetAligns(['C', 'C', 'L', 'L', 'C', 'R', 'R']);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);

        $total_pengeluaran = 0;

        foreach ($data_bpkk as $i => $row) {
            $tgl = date('d/m/Y', strtotime($row['tgl_kredit_cab']));
            $no_bpkk = $row['no_bpkk_cab'] ?? '-';
            $ket = $row['ket_bpkk_cab'] ?? '-';
            $pengeluaran = $row['total_kredit_cab'] ?? 0;
            $saldo = $row['sisa_saldo'] ?? 0;

            $total_pengeluaran += $pengeluaran;

            $pdf->Row([
                $i + 1,
                $tgl,
                $no_bpkk,
                $ket,
                '-',
                'Rp ' . number_format($pengeluaran, 0, ',', '.'),
                'Rp ' . number_format($saldo, 0, ',', '.')
            ]);
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(217, 6, 'Total Pengeluaran', 1, 0, 'R');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(60, 6, 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'), 1, 1, 'C', true);

        // ✅ Nama file download
        $nama_file = 'Rekapan_Pengeluaran_Kas_Kecil_' . date('Ymd') . '.pdf';
        $pdf->Output('I', $nama_file);
    }

    public function export_excel()
    {
        ob_end_clean();
        $this->load->model('M_bpkk');

        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $jenis_saldo = $this->input->get('jenis_saldo');

        // Ambil data BPKK
        if ($awal && $akhir) {
            $data_bpkk = $this->M_bpkk->filterBpkkByDate($awal, $akhir);
        } else {
            $data_bpkk = $this->db->get('tb_bpkk_cab')->result_array();
        }

        // Mapping address_user ke kode saldo
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

        // Ambil nama perusahaan
        $perusahaan = 'Bias Mandiri Group';
        $pj = $this->db->get_where('tb_penanggung_jawab', ['jenis_saldo' => $kode_saldo])->row_array();
        if ($pj && isset($pj['perusahaan'])) {
            $perusahaan = $pj['perusahaan'];
        }

        require_once APPPATH . 'third_party/PhpSpreadsheet/autoload.php';
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Rekapan BPKK');

        // HEADER UTAMA
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'REKAP PENGELUARAN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', $perusahaan);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        if ($awal && $akhir) {
            $firstDate = new DateTime($awal);
            $lastDate = new DateTime($akhir);
            $periode = $firstDate->format('d M') . ' - ' . $lastDate->format('d M Y');

            $sheet->mergeCells('E4:F4');
            $sheet->setCellValue('E4', 'Periode ' . $periode);
            $sheet->getStyle('E4')->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle('E4')->getAlignment()->setHorizontal('left');
        }

        // HEADER TABEL
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal');
        $sheet->setCellValue('C6', 'No BPKK');
        $sheet->setCellValue('D6', 'Keterangan');
        $sheet->setCellValue('E6', 'Total Pengeluaran');
        $sheet->setCellValue('F6', 'Sisa Saldo');

        $headerStyle = [
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
        ];
        $sheet->getStyle('A6:F6')->applyFromArray($headerStyle);

        // DATA BPKK
        $row_excel = 7;
        $no = 1;
        $first_data_row = $row_excel;

        foreach ($data_bpkk as $row) {
            $sheet->setCellValue("A{$row_excel}", $no++);
            $sheet->setCellValue("B{$row_excel}", date('d/m/Y', strtotime($row['tgl_kredit_cab'])));
            $sheet->setCellValue("C{$row_excel}", $row['no_bpkk_cab']);
            $sheet->setCellValue("D{$row_excel}", $row['ket_bpkk_cab']);
            $sheet->setCellValue("E{$row_excel}", $row['total_kredit_cab']);
            $sheet->setCellValue("F{$row_excel}", $row['sisa_saldo']);

            // Rata tengah untuk No & No BPKK
            $sheet->getStyle("A{$row_excel}:A{$row_excel}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row_excel}:C{$row_excel}")
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Format Rupiah untuk Total Pengeluaran & Sisa Saldo
            $sheet->getStyle("E{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle("F{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');

            // Border per baris
            $sheet->getStyle("A{$row_excel}:F{$row_excel}")
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $row_excel++;
        }

        // TOTAL PENGELUARAN DI BAWAH TABEL
        $sheet->mergeCells("A{$row_excel}:D{$row_excel}");
        $sheet->setCellValue("A{$row_excel}", "Total Pengeluaran");
        $sheet->getStyle("A{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A{$row_excel}")->getFont()->setBold(true);

        // Merge kolom E dan F dan isi dengan rumus SUM
        $sheet->mergeCells("E{$row_excel}:F{$row_excel}");
        $sheet->setCellValue("E{$row_excel}", "=SUM(E{$first_data_row}:E" . ($row_excel - 1) . ")");
        $sheet->getStyle("E{$row_excel}")->getNumberFormat()->setFormatCode('"Rp"#,##0');
        $sheet->getStyle("E{$row_excel}")->getFont()->setBold(true);
        $sheet->getStyle("E{$row_excel}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Border untuk seluruh baris
        $sheet->getStyle("A{$row_excel}:F{$row_excel}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Auto size kolom
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // --- Nama file dengan format tanggal awal - akhir ---
        if ($awal && $akhir) {
            $firstDate = new DateTime($awal);
            $lastDate = new DateTime($akhir);
            $awal_format = $firstDate->format('d-m-Y');
            $akhir_format = $lastDate->format('d-m-Y');

            $filename = "Rekapan BPKK_{$awal_format}_s.d._{$akhir_format}.xls";
        } else {
            $filename = 'Rekapan_BPKK_' . date('Ymd') . '.xls';
        }

        // Kirim header dan download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($excel);
        $writer->save('php://output');
        exit;
    }


    // public function editpengeluaranbpkkold()
    // {
    //     $idbpkk          = $this->input->post('idbpkk');
    //     $nobpkk          = $this->input->post('no_permintaan_bpkk');
    //     $keterangan_bpkk = $this->input->post('keteranganpermintaanbpkk');
    //     $jenis_saldo     = $this->input->post('jenissaldobpkk');
    //     $no_rembesment   = $this->input->post('no_pc_rembes');
    //     $totalBaru       = (int)$this->input->post('total_debet');

    //     // Ambil data lama
    //     $pengeluaran = $this->M_bpkk->getPengeluaranById($idbpkk);
    //     if (!$pengeluaran) {
    //         $this->session->set_flashdata('error', 'Data tidak ditemukan.');
    //         redirect('Bukti_pengeluaran_kas_kecil');
    //         return;
    //     }

    //     $totalLama = (int)$pengeluaran->total_kredit_cab;
    //     $selisih   = $totalBaru - $totalLama;

    //     // ✅ Hanya cek permintaan saldo jika $no_rembesment tidak kosong
    //     $saldoPermintaanLama = null;
    //     if (!empty($no_rembesment)) {
    //         $permintaan = $this->M_bpkk->getPermintaanSaldoByNo($no_rembesment);
    //         if (!$permintaan) {
    //             $this->session->set_flashdata('error', 'Data permintaan saldo tidak ditemukan.');
    //             redirect('Bukti_pengeluaran_kas_kecil');
    //             return;
    //         }
    //         $saldoPermintaanLama = (int)$permintaan->saldo_pettycash;
    //     }

    //     // Cek saldo cabang sebelum update (hanya jika selisih positif = tambah debit)
    //     if ($selisih > 0) {
    //         $saldoCabang = $this->M_bpkk->getSaldoCabang($jenis_saldo);
    //         if ($saldoCabang < $selisih) {
    //             $this->session->set_flashdata('error', 'Saldo petty cash cabang tidak mencukupi.');
    //             redirect('Bukti_pengeluaran_kas_kecil');
    //             return;
    //         }

    //         // ✅ Hanya cek saldo permintaan kalau ada rembesment
    //         if (!empty($no_rembesment) && $saldoPermintaanLama < $selisih) {
    //             $this->session->set_flashdata('error', 'Saldo petty cash permintaan tidak mencukupi.');
    //             redirect('Bukti_pengeluaran_kas_kecil');
    //             return;
    //         }
    //     }

    //     // Update saldo jika ada perubahan
    //     if ($selisih != 0) {
    //         $this->M_bpkk->adjustSaldoCabang($jenis_saldo, $selisih);

    //         // ✅ Update saldo permintaan hanya jika ada rembesment
    //         if (!empty($no_rembesment)) {
    //             $this->M_bpkk->adjustPermintaanSaldo($no_rembesment, $selisih);
    //         }
    //     }

    //     // Upload file
    //     $cleaned_keterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $keterangan_bpkk);
    //     $upload_folder = './uploads/BPKK/' . $jenis_saldo . '/';
    //     $file_name_base = $cleaned_keterangan . '.pdf';

    //     if (!is_dir($upload_folder)) mkdir($upload_folder, 0777, true);

    //     $final_file_name = $file_name_base;
    //     $i = 1;
    //     while (file_exists($upload_folder . $final_file_name)) {
    //         $final_file_name = $cleaned_keterangan . '_update' . $i . '.pdf';
    //         $i++;
    //     }

    //     $config['upload_path']   = $upload_folder;
    //     $config['allowed_types'] = 'pdf';
    //     $config['max_size']      = 2048;
    //     $config['file_name']     = $final_file_name;
    //     $config['overwrite']     = false;

    //     $this->load->library('upload', $config);

    //     if (!$this->upload->do_upload('file_dokumen')) {
    //         $error = $this->upload->display_errors();
    //         $this->session->set_flashdata('error', 'Gagal upload file: ' . $error);
    //         redirect('Bukti_pengeluaran_kas_kecil');
    //         return;
    //     }

    //     $upload_data = $this->upload->data();
    //     $file_path   = $upload_data['file_name'];

    //     // (Opsional) Hapus file lama jika perlu
    //     if (!empty($pengeluaran->upload_file_cab) && file_exists($upload_folder . $pengeluaran->upload_file_cab)) {
    //         unlink($upload_folder . $pengeluaran->upload_file_cab);
    //     }

    //     // Update data BPKK
    //     $data = [
    //         'total_kredit_cab' => $totalBaru,
    //         'upload_file_cab'  => $file_path,
    //         'ket_bpkk_cab'     => $keterangan_bpkk
    //     ];

    //     $data2 = [
    //         'total_kredit_cab' => $totalBaru,
    //         'file'             => $file_path,
    //     ];
    //     $this->M_bpkk->updatebpkk($idbpkk, $data, 'tb_bpkk_cab');
    //     $this->M_bpkk->updatebpkkmutasi($nobpkk, $data2, 'tb_data_mutasi');

    //     $this->session->set_flashdata('success', 'Data BPKK berhasil diperbarui.');
    //     redirect('Bukti_pengeluaran_kas_kecil');
    // }
}