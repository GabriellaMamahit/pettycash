<?php
defined('BASEPATH') or exit('No direct script access allowed');

use setasign\Fpdi\Fpdi;

class Kelola_saldo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('M_finance');
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

    public function index()
    {
        $data = array(
            'judul' => "Petty Cash | Kelola Saldo Petty Cash",
            'rowsaldocabang' => $this->M_finance->getsaldocabang(),
            'in_progress' => $this->M_finance->getWidgetData('In progress', 'all'),
            'approved'    => $this->M_finance->getWidgetData('Approved', 'all'),
            'revisi'      => $this->M_finance->getWidgetData('Revisi', 'all'),
            'rejected'    => $this->M_finance->getWidgetData('Rejected', 'all'),
        );

        $this->template->load('template', 'keuangan/kelola_saldo', $data);
    }

    public function filter_widget()
    {
        $jenis_saldo = $this->input->post('jenis_saldo');
        // $this->load->model('M_finance');

        $response = [
            'in_progress' => $this->M_finance->getWidgetData('In progress', $jenis_saldo),
            'approved'    => $this->M_finance->getWidgetData('Approved', $jenis_saldo),
            'revisi'      => $this->M_finance->getWidgetData('Revisi', $jenis_saldo),
            'rejected'    => $this->M_finance->getWidgetData('Rejected', $jenis_saldo),
        ];

        echo json_encode($response);
    }



    // public function detail_saldo($id_saldo, $jenis_saldo)
    // {
    //     $address_user = $this->fungsi->user_login()->address_user;
    //     $kode_cabang = $this->getKodeCabangFromAddress($address_user);
    //     $no_petty_cash = $this->M_finance->generatePettycashNumber($kode_cabang);

    //     $data = array(
    //         'judul'   => "Petty Cash | Detail Saldo Petty Cash",
    //         'no_petty_cash' => $no_petty_cash,
    //         'detail_saldo' => $this->M_finance->detail_saldo($id_saldo),
    //         'rowdetailsaldocabang' => $this->M_finance->getdatasaldo($jenis_saldo)
    //     );

    //     $this->template->load('template', 'keuangan/detail_saldo', $data);
    // }

    public function editbudgetsaldo()
    {
        $id_saldo = $this->input->post('idbudgetsaldo');
        $total_budget = $this->input->post('total_budget');

        if (!$id_saldo || $total_budget === null) {
            $this->session->set_flashdata('error', 'Data tidak lengkap!');
            redirect('kelola_saldo');
            return;
        }

        // panggil model untuk update
        $update = $this->M_finance->updatebudget_cab($id_saldo, $total_budget);

        if ($update) {
            $this->session->set_flashdata('success', 'Budget saldo berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate budget saldo!');
        }

        redirect('kelola_saldo');
    }


    public function get_data_bpkk_by_nopettycash()
    {
        $no_pettycash = $this->input->post('no_pettycash');
        $data = $this->M_finance->get_data_bpkk_by_no($no_pettycash);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'tanggal'    => date('d/m/Y', strtotime($row['tgl_kredit_cab'])),
                'keterangan' => $row['ket_bpkk_cab'],
                'total'      => 'Rp. ' . number_format($row['total_kredit_cab'], 0, ',', '.'),
                'status'     => $row['status_cab'],
                'jenis_saldo'         => $row['jenis_saldo'],
                'upload_file_cab'     => $row['upload_file_cab'],
            ];
        }

        echo json_encode($result);
    }

    public function detail_saldo($id_saldo, $jenis_saldo)
    {
        $this->session->set_userdata('id_saldo', $id_saldo);
        $this->session->set_userdata('jenis_saldo', $jenis_saldo);

        $no_petty_cash = $this->M_finance->generatePettycashNumber($jenis_saldo);
        $saldo_cabang = $this->M_finance->saldocabang($jenis_saldo);
        $saldo_pettycash = $this->M_finance->saldopettycash($jenis_saldo);

        // $is_low_saldo = ($saldo_cabang >= 0 && $saldo_cabang <= 10000);

        $data = array(
            'judul'   => "Petty Cash | Detail Saldo Petty Cash",
            'no_petty_cash' => $no_petty_cash,
            'id_saldo'      => $id_saldo,
            'jenis_saldo'   => $jenis_saldo,
            'saldo_cabang'   => $saldo_cabang,
            'saldo_pettycash'   => $saldo_pettycash,
            // 'is_low_saldo'  => $is_low_saldo,
            'detail_saldo'  => $this->M_finance->detail_saldo($id_saldo),
            'rowdetailsaldocabang' => $this->M_finance->getdatasaldo($jenis_saldo)
        );

        $this->template->load('template', 'keuangan/detail_saldo', $data);
    }

    public function approve_saldo($id_pettycash)
    {
        $id_saldo     = $this->session->userdata('id_saldo');
        $jenis_saldo  = $this->session->userdata('jenis_saldo');
        // Ambil data saldo dari model
        $detail_permintaansaldo = $this->M_finance->apprvpermintaansaldo($id_pettycash);
        $no_petty_cash = $this->M_finance->generatePettycashNumber($jenis_saldo);

        // Pastikan datanya ada sebelum ambil no_pettycash
        $no_pettycash = $detail_permintaansaldo ? $detail_permintaansaldo->no_pettycash : null;

        $data = array(
            'judul'                 => "Petty Cash | Detail Saldo Petty Cash",
            'id_saldo'              => $id_saldo,
            'jenis_saldo'           => $jenis_saldo,
            'no_petty_cash' => $no_petty_cash,
            'detail_permintaansaldo' => $detail_permintaansaldo,
            'rowbpkkrembes'         => $this->M_finance->getdatabpkkrembes($no_pettycash),
        );

        $this->template->load('template', 'keuangan/approve_saldo', $data);
    }

    public function tambahsaldo()
    {
        $namauser     = $this->fungsi->user_login()->nama_user;
        $id_saldo          = $this->input->post('id_saldo');
        $no_petty_cash     = $this->input->post('no_pettycash');
        $namacabang        = $this->input->post('kantorcabang');
        $tanggal_input     = $this->input->post('tanggal');
        $tanggal_debet     = date('Y-m-d', strtotime($tanggal_input));
        $keterangan        = $this->input->post('keterangan');
        $sbucabang         = $this->input->post('sbucabang');
        $total_debet       = $this->input->post('total_debet');
        $total_saldodebet      = $this->input->post('saldodebetcabang');
        $jenissaldo        = $this->input->post('jenis_saldo');
        $kode_kantorcab        = $this->input->post('kode_kantocab');

        $cleaned_no_petty_cash = str_replace('/', '_', $no_petty_cash);
        $cleaned_keterangan    = preg_replace('/[^A-Za-z0-9]/', '', $keterangan);
        $cleaned_tanggal       = preg_replace('/[^A-Za-z0-9]/', '', $tanggal_input);
        $upload_folder    = './uploads/finance/';
        $file_name = $cleaned_no_petty_cash . '_' . $cleaned_keterangan . '_' . $cleaned_tanggal . '.pdf';

        $config['upload_path']   = $upload_folder;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 1048;
        $config['encrypt_name']  = FALSE;
        $config['file_name']     = $file_name;

        $this->load->library('upload', $config);
        $filename = null;

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        if ($this->upload->do_upload('file_dokumen')) {
            $filename = $file_name;
        } else {
            // Ambil error CI tanpa tag <p>
            $error = $this->upload->display_errors('', '');

            // Buat pesan user-friendly
            if (stripos($error, 'filetype') !== false) {
                $errorMsg = "File harus dalam format PDF.";
            } elseif (stripos($error, 'exceeds') !== false) {
                $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
            } else {
                $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
            }

            // Set flashdata untuk SweetAlert
            $this->session->set_flashdata('error', $errorMsg);

            redirect('kelola_saldo/detail_saldo/' . $id_saldo . '/' . $jenissaldo);
            return;
        }

        // tb_debet_saldo
        $data = [
            'no_petty_cash'            => $no_petty_cash,
            'kantor_cabang'            => $namacabang,
            'nama_saldo'               => 'Penambahan Saldo ' . $namacabang,
            'saldo_debet'              => $total_debet,
            'jenis_saldo'              => $jenissaldo,
            'tanggal_debet'            => $tanggal_debet,
            'file'                     => $filename,
            'status'                   => 'Done'
        ];

        // tb_nopettycash
        $data2 = [
            'no_petty_cash'       => $no_petty_cash,
            'kantor_cab'               => $namacabang,
            'jenis_saldo'              => $jenissaldo
        ];

        // tb_data_mutasi
        $data3 = [
            'no_pettycash'             => $no_petty_cash,
            'keterangan'               => $keterangan,
            'sbu'                        => $sbucabang,
            'jenis_saldo'              => $jenissaldo,
            'total_debet_cab'          => $total_debet,
            'tanggal'                  => $tanggal_debet,
            'file'                     => $filename,
            'jenis_transaksi'          => 'Debet',
            'status_mutasi'          => 'Open'
        ];

        $data4 = [
            'saldo_pettycash'             => $total_debet + $total_saldodebet,
            'saldo_debet'             => $total_debet + $total_saldodebet,
        ];

        $data5 = [
            'jenis_saldo'              => $jenissaldo,
            'jenis_notifikasi'         => 'Penambahan',
            'nama_penanggung_jwb'      => $namauser,
            'judul_notifikasi'         => 'Penambahan Saldo Awal ' . $namacabang,
            'ket_notifikasi'           => $keterangan . ' ' . $no_petty_cash,
            'no_pettycash'             => $no_petty_cash,
            'status_notifikasi'        => '0',
            'id_data'                  => $kode_kantorcab,
            'tanggal_notifikasi'       => date('Y-m-d H:i:s'),
        ];

        $this->M_finance->tambahdatadebet('tb_debet_saldo', $data);
        $this->M_finance->tambahnopettycash('tb_nopettycash', $data2);
        $this->M_finance->tambahdatamutasi('tb_data_mutasi', $data3);
        $this->M_finance->notifikasitambahsaldo('tb_notifikasi', $data5);
        $this->M_finance->updatesaldo_cab($jenissaldo, $data4, 'tb_saldo');
        // $this->M_finance->update_saldo_cabang($jenissaldo, $total_debet);

        $this->session->set_flashdata('success', 'Saldo petty cash berhasil ditambahkan.');
        redirect('kelola_saldo/detail_saldo/' . $id_saldo . '/' . $jenissaldo);
    }

    // public function tambahsaldorembes()
    // {
    //     $namauser     = $this->fungsi->user_login()->nama_user;
    //     $id_pettycash_saldo          = $this->input->post('id_pettycash_saldo');
    //     $id_saldo          = $this->input->post('id_saldo_remb');
    //     $no_petty_cash     = $this->input->post('no_petty_cash');
    //     $namacabang        = $this->input->post('kantorcabang_saldo');
    //     $tanggal_input     = $this->input->post('tanggal_saldo');
    //     $tanggal_debet     = date('Y-m-d', strtotime($tanggal_input));
    //     $keterangan        = $this->input->post('keterangan_saldo');
    //     $sbucabang         = $this->input->post('sbucabang_saldo');
    //     $nopettycashawal   = $this->input->post('nopettycash_asal');
    //     $total_debet       = $this->input->post('totalDebetRaw_saldo');
    //     $jenissaldo        = $this->input->post('jenis_saldo_saldo');

    //     $cleaned_no_petty_cash = str_replace('/', '_', $no_petty_cash);
    //     $cleaned_keterangan    = preg_replace('/[^A-Za-z0-9]/', '', $keterangan);
    //     $cleaned_tanggal       = preg_replace('/[^A-Za-z0-9]/', '', $tanggal_input);
    //     $upload_folder    = './uploads/finance/';
    //     $file_name = $cleaned_no_petty_cash . '_' . $cleaned_keterangan . '_' . $cleaned_tanggal . '.pdf';

    //     $config['upload_path']   = $upload_folder;
    //     $config['allowed_types'] = 'pdf';
    //     $config['max_size']      = 1048;
    //     $config['encrypt_name']  = FALSE;
    //     $config['file_name']     = $file_name;

    //     $this->load->library('upload', $config);
    //     $filename = null;

    //     if (!is_dir($upload_folder)) {
    //         mkdir($upload_folder, 0777, true);
    //     }

    //     if ($this->upload->do_upload('file_dokumen_saldo')) {
    //         $filename = $file_name;
    //     } else {
    //         // Ambil error CI tanpa tag <p>
    //         $error = $this->upload->display_errors('', '');

    //         // Buat pesan user-friendly
    //         if (stripos($error, 'filetype') !== false) {
    //             $errorMsg = "File harus dalam format PDF.";
    //         } elseif (stripos($error, 'exceeds') !== false) {
    //             $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
    //         } else {
    //             $errorMsg = "Ukuran file terlalu besar, maksimal 1 MB.";
    //         }

    //         // Set flashdata untuk SweetAlert
    //         $this->session->set_flashdata('error', $errorMsg);
    //         redirect('kelola_saldo/approve_saldo/' . $id_pettycash_saldo . '/' . $jenissaldo);
    //         return;
    //     }

    //     // tb_debet_saldo
    //     $data = [
    //         'no_petty_cash'            => $no_petty_cash,
    //         'no_pc_asal'               => $nopettycashawal,
    //         'kantor_cabang'            => $namacabang,
    //         'nama_saldo'               => 'Penambahan Saldo ' . $namacabang,
    //         'saldo_debet'              => $total_debet,
    //         'jenis_saldo'              => $jenissaldo,
    //         'tanggal_debet'            => $tanggal_debet,
    //         'file'                     => $filename,
    //         'status'                   => 'Done'
    //     ];

    //     // tb_nopettycash
    //     $data2 = [
    //         'no_petty_cash'            => $no_petty_cash,
    //         'kantor_cab'               => $namacabang,
    //         'jenis_saldo'              => $jenissaldo
    //     ];

    //     // tb_data_mutasi
    //     $data3 = [
    //         'no_pettycash'             => $no_petty_cash,
    //         'keterangan'               => $keterangan,
    //         'sbu'                      => $sbucabang,
    //         'jenis_saldo'              => $jenissaldo,
    //         'total_debet_cab'          => $total_debet,
    //         'tanggal'                  => $tanggal_debet,
    //         'file'                     => $filename,
    //         'jenis_transaksi'          => 'Debet',
    //         'status_mutasi'            => 'Open'
    //     ];

    //     // tb_permintaan_saldo
    //     $data4 = [
    //         'status_permintaan'        => 'Done'
    //     ];

    //     // tb_bpkk_cab
    //     $data5 = [
    //         'jenis_saldo'              => $jenissaldo,
    //         'jenis_notifikasi'         => 'Penambahan',
    //         'nama_penanggung_jwb'      => $namauser,
    //         'judul_notifikasi'         => 'Penambahan Saldo ' . $namacabang,
    //         'ket_notifikasi'           => $keterangan . ' ' . $no_petty_cash,
    //         'no_pettycash'             => $no_petty_cash,
    //         'status_notifikasi'        => '0',
    //         'tanggal_notifikasi'       => date('Y-m-d H:i:s'),
    //     ];

    //     $this->M_finance->tambahdatadebet('tb_debet_saldo', $data);
    //     $this->M_finance->tambahnopettycash('tb_nopettycash', $data2);
    //     $this->M_finance->tambahdatamutasi('tb_data_mutasi', $data3);
    //     $this->M_finance->notifikasitambahsaldo('tb_notifikasi', $data5);
    //     $this->M_finance->updatestatusrembest($id_pettycash_saldo, $data4, 'tb_permintaan_saldo');
    //     $this->M_finance->update_saldo_cabang($jenissaldo, $total_debet);

    //     $this->session->set_flashdata('success', 'Saldo petty cash berhasil ditambahkan.');
    //     redirect('kelola_saldo/detail_saldo/' . $id_saldo . '/' . $jenissaldo);
    // }

    public function tambahsaldorembes()
    {
        $namauser     = $this->fungsi->user_login()->nama_user;
        $id_pettycash_saldo = $this->input->post('id_pettycash_saldo');
        $id_saldo      = $this->input->post('id_saldo_remb');
        $no_petty_cash = $this->input->post('no_petty_cash');
        $namacabang    = $this->input->post('kantorcabang_saldo');
        $tanggal_input = $this->input->post('tanggal_saldo');
        $tanggal_debet = date('Y-m-d', strtotime($tanggal_input));
        $keterangan    = $this->input->post('keterangan_saldo');
        $sbucabang     = $this->input->post('sbucabang_saldo');
        $nopettycashawal = $this->input->post('nopettycash_asal');
        $total_debet   = $this->input->post('totalDebetRaw_saldo');
        $jenissaldo    = $this->input->post('jenis_saldo_saldo');

        // --- Ambil sisa saldo pending dari tb_sisasaldo_rembes ---
        $pending = $this->db->get_where('tb_sisasaldo_rembes', ['no_pettycash' => $nopettycashawal])->row_array();
        $sisa_saldo = $pending ? $pending['sisasaldo_remb'] : 0;

        // === Upload file ===
        $cleaned_no_petty_cash = str_replace('/', '_', $no_petty_cash);
        $cleaned_keterangan    = preg_replace('/[^A-Za-z0-9]/', '', $keterangan);
        $cleaned_tanggal       = preg_replace('/[^A-Za-z0-9]/', '', $tanggal_input);
        $upload_folder         = './uploads/finance/';
        $file_name = $cleaned_no_petty_cash . '_' . $cleaned_keterangan . '_' . $cleaned_tanggal . '.pdf';

        $config['upload_path']   = $upload_folder;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 1048;
        $config['encrypt_name']  = TRUE;
        $config['file_name']     = $file_name;

        $this->load->library('upload', $config);
        $filename = null;

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true); // buat folder beserta parent
        }

        if (!is_writable($upload_folder)) {
            chmod($upload_folder, 0777);
        }

        if (!empty($_FILES['file_dokumen_saldo']['name'])) {
            $config['upload_path']   = $upload_folder;
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 1048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_dokumen_saldo')) {
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];
            } else {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', $error);
                redirect('kelola_saldo/approve_saldo/' . $id_pettycash_saldo . '/' . $jenissaldo);
                return;
            }
        } else {
            $this->session->set_flashdata('error', 'File PDF harus diunggah.');
            redirect('kelola_saldo/approve_saldo/' . $id_pettycash_saldo . '/' . $jenissaldo);
            return;
        }

        // === tb_debet_saldo ===
        $data = [
            'no_petty_cash'   => $no_petty_cash,
            'no_pc_asal'      => $nopettycashawal,
            'kantor_cabang'   => $namacabang,
            'nama_saldo'      => 'Penambahan Saldo ' . $namacabang,
            'saldo_debet'     => $total_debet,
            'jenis_saldo'     => $jenissaldo,
            'tanggal_debet'   => $tanggal_debet,
            'file'            => $filename,
            'status'          => 'Done',
            'sisa_saldo'      => $sisa_saldo // ⬅️ Tambahkan dari tb_sisasaldo_rembes
        ];

        // === tb_nopettycash ===
        $data2 = [
            'no_petty_cash'   => $no_petty_cash,
            'kantor_cab'      => $namacabang,
            'jenis_saldo'     => $jenissaldo
        ];

        // === tb_data_mutasi ===
        $data3 = [
            'no_pettycash'    => $no_petty_cash,
            'keterangan'      => $keterangan,
            'sbu'             => $sbucabang,
            'jenis_saldo'     => $jenissaldo,
            'total_debet_cab' => $total_debet,
            'tanggal'         => $tanggal_debet,
            'file'            => $filename,
            'jenis_transaksi' => 'Debet',
            'status_mutasi'   => 'Open',
            'sisa_saldo'      => $sisa_saldo // ⬅️ Tambahkan dari tb_sisasaldo_rembes
        ];

        // === tb_permintaan_saldo ===
        $data4 = [
            'status_permintaan' => 'Done',
            'sisa_saldo'        => $sisa_saldo
        ];

        // === tb_notifikasi ===
        $data5 = [
            'jenis_saldo'         => $jenissaldo,
            'jenis_notifikasi'    => 'Penambahan',
            'nama_penanggung_jwb' => $namauser,
            'judul_notifikasi'    => 'Penambahan Saldo ' . $namacabang,
            'ket_notifikasi'      => $keterangan . ' ' . $no_petty_cash,
            'no_pettycash'        => $no_petty_cash,
            'status_notifikasi'   => '0',
            'tanggal_notifikasi'  => date('Y-m-d H:i:s'),
        ];

        // === Simpan ke database ===
        $this->M_finance->tambahdatadebet('tb_debet_saldo', $data);
        $this->M_finance->tambahnopettycash('tb_nopettycash', $data2);
        $this->M_finance->tambahdatamutasi('tb_data_mutasi', $data3);
        $this->M_finance->notifikasitambahsaldo('tb_notifikasi', $data5);
        $this->M_finance->updatestatusrembest($id_pettycash_saldo, $data4, 'tb_permintaan_saldo');
        $this->M_finance->update_saldo_cabang($jenissaldo, $total_debet);

        // === Setelah berhasil simpan, hapus pending dari tb_sisasaldo_rembes ===
        if ($pending) {
            $this->db->delete('tb_sisasaldo_rembes', ['no_pettycash' => $nopettycashawal]);
        }

        $this->session->set_flashdata('success', 'Saldo rembesment berhasil ditambahkan.');
        redirect('kelola_saldo/detail_saldo/' . $id_saldo . '/' . $jenissaldo);
    }

    public function get_databpkk_nopettycash()
    {
        $no_pettycash = $this->input->post('no_pettycash');
        $data = $this->M_finance->getdatabpkk($no_pettycash);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'tanggal'        => date('d/m/Y', strtotime($row['tgl_kredit_cab'])),
                'nobpkk'         => $row['no_bpkk_cab'],
                'keterangan'     => $row['ket_bpkk_cab'],
                'total'          => 'Rp. ' . number_format($row['total_kredit_cab'], 0, ',', '.'),
                'status'         => $row['status_cab'],
                'upload_file_cab' => $row['upload_file_cab'],
                'jenis_saldo'    => $row['jenis_saldo'],
            ];
        }

        echo json_encode($result);
    }

    // public function update_status_bpkk()
    // {
    //     $no_bpkk = $this->input->post('no_bpkk');
    //     $status  = $this->input->post('status');

    //     if (!$no_bpkk || !$status) {
    //         echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    //         return;
    //     }

    //     $this->db->where('no_bpkk_cab', $no_bpkk);
    //     $this->db->update('tb_bpkk_cab', ['status_cab' => $status]);

    //     if ($status === 'Rejected') {
    //         $this->db->where('no_bpkk_cab', $no_bpkk);
    //         $this->db->update('tb_bpkk_cab', ['status_bpkk' => 'Open']);
    //     }

    //     $this->db->where('no_bpkk_cab', $no_bpkk);
    //     $this->db->update('tb_data_mutasi', ['status_cab' => $status]);

    //     echo json_encode(['status' => 'ok']);
    // }

    public function update_status_bpkk()
    {
        $no_bpkk = $this->input->post('no_bpkk');
        $status  = $this->input->post('status');

        if (!$no_bpkk || !$status) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            return;
        }

        // Pastikan data BPKK ada
        $bpkk = $this->db->get_where('tb_bpkk_cab', ['no_bpkk_cab' => $no_bpkk])->row_array();
        if (!$bpkk) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
            return;
        }

        // Update status utama
        $this->db->where('no_bpkk_cab', $no_bpkk);
        $this->db->update('tb_bpkk_cab', ['status_cab' => $status]);

        if ($status === 'Approved') {
            // Ambil data saldo pending dari tb_sisasaldo
            $pending = $this->db->get_where('tb_sisasaldo', ['no_bpkk_cab' => $no_bpkk])->row_array();

            if ($pending) {
                $sisa_saldo = $pending['sisa_saldo'];

                // === 1️⃣ Update ke tb_bpkk_cab (kalau masih kosong) ===
                if (empty($bpkk['sisa_saldo'])) {
                    $this->db->where('no_bpkk_cab', $no_bpkk);
                    $this->db->update('tb_bpkk_cab', ['sisa_saldo' => $sisa_saldo]);
                }

                // === 2️⃣ Update tb_data_mutasi kalau sudah ada record-nya ===
                $mutasi = $this->db->get_where('tb_data_mutasi', ['no_bpkk_cab' => $no_bpkk])->row_array();
                if ($mutasi && empty($mutasi['sisa_saldo'])) {
                    $this->db->where('no_bpkk_cab', $no_bpkk);
                    $this->db->update('tb_data_mutasi', ['sisa_saldo' => $sisa_saldo]);
                }

                // === 3️⃣ Hapus saldo pending ===
                $this->db->delete('tb_sisasaldo', ['no_bpkk_cab' => $no_bpkk]);
            }
        }

        echo json_encode(['status' => 'ok', 'message' => 'Status berhasil diperbarui']);
    }



    public function update_status_bpkk_rejected()
    {
        $namauser          = $this->fungsi->user_login()->nama_user;
        $no_bpkk = $this->input->post('no_bpkk');
        $jenis_saldo = $this->input->post('jenis_saldo');
        $status  = $this->input->post('status');
        $alasan  = $this->input->post('alasan'); // alasan reject

        if (!$no_bpkk || !$status) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            return;
        }

        // update status di tabel utama
        $this->db->where('no_bpkk_cab', $no_bpkk);
        $this->db->update('tb_bpkk_cab', ['status_cab' => $status]);

        if ($status === 'Rejected') {
            $this->db->where('no_bpkk_cab', $no_bpkk);
            $this->db->update('tb_bpkk_cab', ['status_bpkk' => 'Open']);

            // simpan alasan ke tabel notifikasi
            $this->db->insert('tb_notifikasi', [
                'jenis_saldo'           => $jenis_saldo,
                'no_pettycash'          => $no_bpkk,
                'jenis_notifikasi'      => 'Rejected',
                'nama_penanggung_jwb'   => $namauser,
                'judul_notifikasi'      => 'Pengajuan Ditolak',
                'ket_notifikasi'        => $alasan,
                'tanggal_notifikasi'    => date('Y-m-d H:i:s'),
                'status_notifikasi'     => '0'
            ]);
        }

        $this->db->where('no_bpkk_cab', $no_bpkk);
        $this->db->update('tb_data_mutasi', ['status_cab' => $status]);

        echo json_encode(['status' => 'ok']);
    }

    public function downloadLaporan()
    {
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
        require_once APPPATH . 'third_party/fpdi/src/autoload.php';

        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : null;
        $no_pettycash = isset($_GET['no']) ? urldecode($_GET['no']) : null;

        if (!$no_pettycash) {
            show_error('No Petty Cash tidak dikirim.');
            return;
        }

        $perusahaanData = $this->db
            ->where('jenis_saldo', $jenis)
            ->get('tb_penanggung_jawab')
            ->row_array();

        $namaPerusahaan = $perusahaanData['perusahaan'] ?? 'BIAS MANDIRI GROUP';

        // Ambil data tb_debet_saldo
        $dataPermintaan = $this->db
            ->where('no_pc_asal', $no_pettycash)
            ->get('tb_debet_saldo')
            ->row_array();

        if (!$dataPermintaan) {
            $dataPermintaan = $this->db
                ->where('no_petty_cash', $no_pettycash)
                ->get('tb_debet_saldo')
                ->row_array();
        }

        $no_petty_cash = $dataPermintaan['no_pc_asal'] ?? $dataPermintaan['no_petty_cash'];;
        $fileDebet = $dataPermintaan['file'] ?? null;

        // Ambil data tb_permintaan_saldo
        $dataAsal = $this->db
            ->where('no_pettycash', $no_petty_cash)
            ->get('tb_permintaan_saldo')
            ->row_array();

        $filePermintaan = $dataAsal['dokumen_pettycash'] ?? null;

        // Ambil data tb_bpkk_cab
        $dataBpkk = $this->db
            ->where('no_pc_saldo', $no_petty_cash)
            ->order_by('tgl_kredit_cab', 'ASC')
            ->get('tb_bpkk_cab')
            ->result_array();

        $totalPengeluaran = 0;
        $detail = [];
        $no = 1;

        foreach ($dataBpkk as $row) {
            $pemasukan = $row['pemasukan'] ?? '-';
            $pengeluaran = $row['total_kredit_cab'] ?? 0;
            $date = isset($row['tgl_kredit_cab']) ? date('d/m/Y', strtotime($row['tgl_kredit_cab'])) : '-';
            $description = $row['ket_bpkk_cab'] ?? '-';
            $no_bpkk = $row['no_bpkk_cab'] ?? '-';
            $sisa = $row['sisa_saldo'] ?? 0;

            $totalPengeluaran += $pengeluaran;

            $detail[] = [
                'no' => $no++,
                'date' => $date,
                'no_bpkk' => $no_bpkk,
                'description' => $description,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'sisa' => $sisa,
                'upload_file_cab' => $row['upload_file_cab'] ?? '',
            ];
        }

        $detailpemasukan = [];
        if (!empty($dataPermintaan)) {
            $detailpemasukan[] = [
                'no' => 1,
                'tanggaldebet' => isset($dataPermintaan['tanggal_debet']) ? date('d/m/Y', strtotime($dataPermintaan['tanggal_debet'])) : '-',
                'nomor_pettycash' => $dataPermintaan['no_petty_cash'] ?? '-',
                'keterangan_debet' => $dataPermintaan['nama_saldo'] ?? '-',
                'saldo_debet' => $dataPermintaan['saldo_debet'] ?? 0,
            ];
        }

        $dataPettyCash = [
            'tanggal' => isset($dataPermintaan['tanggal_debet']) ? date('d/m/Y', strtotime($dataPermintaan['tanggal_debet'])) : '-',
            'no_pettycash' => $dataPermintaan['no_petty_cash'] ?? '-',
            'keterangan' => $dataPermintaan['nama_saldo'] ?? '-',
            'total_pengeluaran' => $totalPengeluaran,
            'sisa_saldo' => $dataPermintaan['sisa_saldo'] ?? 0,
            'pemasukan' => $dataPermintaan['pemasukan'] ?? 0,
            'penambahan' => $dataPermintaan['saldo_debet'] ?? 0,
            'detail' => $detail,
            'detailpemasukan' => $detailpemasukan
        ];

        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        // $filename = 'laporan-pettycash-' . time() . '.pdf';

        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment; filename="' . $filename . '"');
        // header('Content-Transfer-Encoding: binary');
        // header('Accept-Ranges: bytes');

        // HEADER + Tabel Summary (Tidak diubah)
        $pdf->Rect(5, 5, 200, 285);
        $logo_width = 17;
        $page_width = $pdf->GetPageWidth();
        $logo_x = ($page_width - $logo_width) / 2;
        $logo_path = FCPATH . 'assets/images/logo/logo_bmg.jpg';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, $logo_x, 8, $logo_width);
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(0, 23);
        $pdf->Cell($page_width, 10, 'REIMBURSEMENT', 0, 1, 'C');
        $pdf->SetXY(0, 29);
        $pdf->Cell($page_width, 10, strtoupper($namaPerusahaan), 0, 1, 'C');
        $pdf->Line(5, 40, 205, 40);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(10, 45);
        $pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
        $pdf->Cell(2, 6, ':', 0, 0, 'L');
        $pdf->Cell(23, 6, $dataPettyCash['tanggal'], 0, 1, 'C');

        $pdf->SetXY(145, 45);
        $pdf->Cell(50, 6, 'No Petty cash: ' . $dataPettyCash['no_pettycash'], 0, 0, 'C');

        $pdf->SetXY(10, 51);
        $pdf->Cell(30, 6, 'Keterangan', 0, 0, 'L');
        $pdf->Cell(2, 6, ':', 0, 0, 'L');
        $pdf->Cell(48, 6, $dataPettyCash['keterangan'], 0, 1, 'C');

        // data penambahan saldo
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(6, 6, 'No', 1, 0, 'C');
        $pdf->Cell(16, 6, 'Date', 1, 0, 'C');
        $pdf->Cell(37, 6, 'No Petty Cash', 1, 0, 'C');
        $pdf->Cell(82, 6, 'Uraian', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Pemasukan', 1, 0, 'C');
        $pdf->Ln(6);

        $pdf->SetFont('Arial', '', 8);
        if (!empty($dataPettyCash['detailpemasukan'])) {
            foreach ($dataPettyCash['detailpemasukan'] as $rowdebet) {
                $pdf->Cell(6, 6, $rowdebet['no'], 1, 0, 'C');
                $pdf->Cell(16, 6, $rowdebet['tanggaldebet'], 1, 0, 'C');
                $pdf->Cell(37, 6, $rowdebet['nomor_pettycash'], 1, 0, 'C');
                $pdf->Cell(82, 6, $rowdebet['keterangan_debet'], 1, 0, 'L');
                $pdf->Cell(50, 6, 'Rp ' . number_format($rowdebet['saldo_debet'], 0, ',', '.'), 1, 0, 'C');
                $pdf->Ln(6);
            }
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(141, 6, 'Total Penambahan Saldo', 1, 0, 'R');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(50, 6, 'Rp ' . number_format($dataPettyCash['penambahan'], 0, ',', '.'), 1, 1, 'C', true);


        // data bpkk
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(6, 6, 'No', 1, 0, 'C');
        $pdf->Cell(16, 6, 'Date', 1, 0, 'C');
        $pdf->Cell(37, 6, 'No BPKK', 1, 0, 'C');
        $pdf->Cell(82, 6, 'Uraian', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Pengeluaran', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Sisa Saldo', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        foreach ($dataPettyCash['detail'] as $row) {
            $pdf->Cell(6, 6, $row['no'], 1, 0, 'C');
            $pdf->Cell(16, 6, $row['date'], 1, 0, 'C');
            $pdf->Cell(37, 6, $row['no_bpkk'], 1, 0, 'C');
            $pdf->Cell(82, 6, $row['description'], 1, 0, 'L');
            $pdf->Cell(25, 6, ($row['pengeluaran'] ? 'Rp ' . number_format($row['pengeluaran'], 0, ',', '.') : '-'), 1, 0, 'C');
            $pdf->Cell(25, 6, 'Rp ' . number_format($row['sisa'], 0, ',', '.'), 1, 1, 'R');
        }

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(141, 6, 'Total Pengeluaran', 1, 0, 'L');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(25, 6, 'Rp ' . number_format($dataPettyCash['total_pengeluaran'], 0, ',', '.'), 1, 0, 'C', true);
        $pdf->Cell(25, 6, '', 1, 1, 'R', true);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->Cell(141, 6, 'Sisa Saldo', 1, 0, 'L');
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(25, 6, '', 1, 0, 'C', true);
        $pdf->Cell(25, 6, 'Rp ' . number_format($dataPettyCash['sisa_saldo'], 0, ',', '.'), 1, 1, 'C', true);
        $pdf->SetFillColor(255, 255, 255);

        // ✅ ========== AUTO ORIENTATION: FILE DEBET ==========
        if (!empty($fileDebet)) {
            $pathDebet = FCPATH . 'uploads/finance/' . $fileDebet;

            if (file_exists($pathDebet)) {
                $pageCount = $pdf->setSourceFile($pathDebet);
                for ($i = 1; $i <= $pageCount; $i++) {
                    $tpl = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($tpl);

                    $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P');
                    $pdf->useTemplate($tpl);
                }
            } else {
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'File Debet tidak ditemukan: ' . $fileDebet, 0, 1, 'C');
            }
        }

        // ✅ ========== AUTO ORIENTATION: FILE PERMINTAAN ==========
        if (!empty($filePermintaan)) {
            $pathPermintaan = FCPATH . 'uploads/ppt/' . $filePermintaan;

            if (file_exists($pathPermintaan)) {
                $pageCount = $pdf->setSourceFile($pathPermintaan);
                for ($i = 1; $i <= $pageCount; $i++) {
                    $tpl = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($tpl);

                    $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P');
                    $pdf->useTemplate($tpl);
                }
            } else {
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'File Permintaan tidak ditemukan: ' . $filePermintaan, 0, 1, 'C');
            }
        }

        // ✅ ========== AUTO ORIENTATION: FILE KWITANSI ==========
        foreach ($dataPettyCash['detail'] as $row) {
            if (!empty($row['upload_file_cab'])) {
                $filePath = FCPATH . 'uploads/bpkk/' . $jenis . '/' . $row['upload_file_cab'];

                if (file_exists($filePath)) {
                    $pageCount = $pdf->setSourceFile($filePath);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $tpl = $pdf->importPage($i);
                        $size = $pdf->getTemplateSize($tpl);

                        $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P');
                        $pdf->useTemplate($tpl);
                    }
                } else {
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->Cell(0, 10, "File PDF tidak ditemukan: " . $row['upload_file_cab'], 0, 1, 'C');
                }
            }
        }

        ob_end_clean();
        $pdf->Output('D', 'PettyCash_' . $dataPettyCash['no_pettycash'] . '.pdf');
    }
}