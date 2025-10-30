<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $config['encrypt_name']  = FALSE;
        $config['file_name']     = $file_name;

        $this->load->library('upload', $config);
        $filename = null;

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        if ($this->upload->do_upload('file_dokumen_saldo')) {
            $filename = $file_name;
        } else {
            $error = $this->upload->display_errors('', '');
            $errorMsg = (stripos($error, 'filetype') !== false)
                ? "File harus dalam format PDF."
                : "Ukuran file terlalu besar, maksimal 1 MB.";

            $this->session->set_flashdata('error', $errorMsg);
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
            $this->db->delete('tb_sisasaldo_rembes', ['no_petty_cash' => $no_petty_cash]);
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

    // widget


    // public function update_status_bpkk()
    // {
    //     $no_bpkk = $this->input->post('no_bpkk');
    //     $status  = $this->input->post('status');

    //     if (!$no_bpkk || !$status) {
    //         show_error('Data tidak lengkap', 400);
    //     }

    //     $this->db->where('no_bpkk_cab', $no_bpkk);
    //     $this->db->update('tb_bpkk_cab', ['status_cab' => $status]);

    //     echo json_encode(['status' => 'ok']);
    // }
}