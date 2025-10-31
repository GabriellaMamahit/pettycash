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

	private function getKodBPKKgFromAddress($address_user)
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
		$user 					= $this->fungsi->user_login();
		$address_user 			= $user->address_user;
		$level 					= $user->level;
		$donut_chart 			= $this->M_bpkk->get_pengeluaran_per_jenis_saldo_bulanan();
		$rekap_tahunan 			= $this->M_bpkk->get_rekap_tahunan_per_cabang();
		$budgetjkt 				= $this->M_bpkk->getbudgetsaldo('JKT');
		$budgetkarimun 			= $this->M_bpkk->getbudgetsaldo('TBK');
		$budgetbalikpapan 		= $this->M_bpkk->getbudgetsaldo('BPP');
		$budgetgalang 			= $this->M_bpkk->getbudgetsaldo('LU');
		$budgetskpg_bbm 		= $this->M_bpkk->getbudgetsaldo('PA_BBM');
		$budgetskpg_serviceboat = $this->M_bpkk->getbudgetsaldo('PA_SB');
		$budgetskpg_atkrkt 		= $this->M_bpkk->getbudgetsaldo('PA_RTK');
		$rowjkt 				= $this->M_bpkk->get_saldo_by_cabang('JKT');
		$rowkarimun 			= $this->M_bpkk->get_saldo_by_cabang('TBK');
		$rowbalikpapan 			= $this->M_bpkk->get_saldo_by_cabang('BPP');
		$rowgalang 				= $this->M_bpkk->get_saldo_by_cabang('LU');
		$rowskpg_bbm 			= $this->M_bpkk->get_saldo_by_cabang('PA_BBM');
		$rowskpg_sb 			= $this->M_bpkk->get_saldo_by_cabang('PA_SB');
		$rowskpg_rtk 			= $this->M_bpkk->get_saldo_by_cabang('PA_RTK');
		$kreditjkt 				= $this->M_bpkk->get_total_kredit_by_jenis_saldo('JKT');
		$kreditkarimun 			= $this->M_bpkk->get_total_kredit_by_jenis_saldo('TBK');
		$kreditbalikpapan 		= $this->M_bpkk->get_total_kredit_by_jenis_saldo('BPP');
		$kreditgalang 			= $this->M_bpkk->get_total_kredit_by_jenis_saldo('LU');
		$kreditskpg_bbm 		= $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_BBM');
		$kreditskpg_sb 			= $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_SB');
		$kreditskpg_rtk 		= $this->M_bpkk->get_total_kredit_by_jenis_saldo('PA_RTK');

		$data_saldojkt = [[
			// Jakarta
			'budgetsaldojkt'       		 => $budgetjkt->saldo_cabang ?? 0,
			'saldojkt'       			 => $rowjkt->saldo_pettycash ?? 0,
			'saldodebetjkt'  			 => $rowjkt->saldo_debet ?? 0,
			'saldokreditjkt' 			 => $kreditjkt->total_kredit ?? 0,
			// Karimun
			'budgetsaldokarimun'       	 => $budgetkarimun->saldo_cabang ?? 0,
			'saldokarimun'       		 => $rowkarimun->saldo_pettycash ?? 0,
			'saldodebetkarimun'  		 => $rowkarimun->saldo_debet ?? 0,
			'saldokreditkarimun' 		 => $kreditkarimun->total_kredit ?? 0,
			// Balikpapan
			'budgetsaldobalikpapan'      => $budgetbalikpapan->saldo_cabang ?? 0,
			'saldobalikpapan'       	 => $rowbalikpapan->saldo_pettycash ?? 0,
			'saldodebetbalikpapan'  	 => $rowbalikpapan->saldo_debet ?? 0,
			'saldokreditbalikpapan' 	 => $kreditbalikpapan->total_kredit ?? 0,
			// Galang
			'budgetsaldogalang'     	 => $budgetgalang->saldo_cabang ?? 0,
			'saldogalang'       		 => $rowgalang->saldo_pettycash ?? 0,
			'saldodebetgalang'  		 => $rowgalang->saldo_debet ?? 0,
			'saldokreditgalang' 		 => $kreditgalang->total_kredit ?? 0,
			// Sekupang BBM
			'budgetsaldoskpgbbm'       	 => $budgetskpg_bbm->saldo_cabang ?? 0,
			'saldoskpgbbm'       		 => $rowskpg_bbm->saldo_pettycash ?? 0,
			'saldodebetskpgbbm'  		 => $rowskpg_bbm->saldo_debet ?? 0,
			'saldokreditskpgbbm' 		 => $kreditskpg_bbm->total_kredit ?? 0,
			// Sekupang Service Boat
			'budgetsaldoskpgserviceboat' => $budgetskpg_serviceboat->saldo_cabang ?? 0,
			'saldoskpgserviceboat'       => $rowskpg_sb->saldo_pettycash ?? 0,
			'saldodebetskpgserviceboat'  => $rowskpg_sb->saldo_debet ?? 0,
			'saldokreditskpgserviceboat' => $kreditskpg_sb->total_kredit ?? 0,
			// Sekupang ATK/RTK
			'budgetsaldoskpgatkrtk'      => $budgetskpg_atkrkt->saldo_cabang ?? 0,
			'saldoskpgatkrtk'       	 => $rowskpg_rtk->saldo_pettycash ?? 0,
			'saldodebetskpgatkrtk'  	 => $rowskpg_rtk->saldo_debet ?? 0,
			'saldokreditskpgatkrtk' 	 => $kreditskpg_rtk->total_kredit ?? 0,
		]];

		// Ambil semua data pengeluaran BPKK
		$pengeluaran = $this->M_bpkk->getbpkk_cab($address_user, $level, 'ASC');
		$transaksi = $this->M_bpkk->getMutasiCabang($address_user, $level, 'ASC');

		// Hitung sisa saldo per baris (berdasarkan jenis_saldo masing-masing)
		$saldo_awal_per_cabang = [];
		$akumulasi_per_cabang = [];

		foreach ($pengeluaran as &$row) {
			$jenis = $row['jenis_saldo'];

			// Ambil saldo awal per cabang jika belum
			if (!isset($saldo_awal_per_cabang[$jenis])) {
				$saldo_awal_per_cabang[$jenis] = $this->M_bpkk->getsaldopettycash($jenis);
				$akumulasi_per_cabang[$jenis] = 0;
			}

			// Tambahkan total kredit ke akumulasi per cabang
			$akumulasi_per_cabang[$jenis] += $row['total_kredit_cab'];

			// Hitung sisa saldo
			$row['sisa_saldo'] = $saldo_awal_per_cabang[$jenis] - $akumulasi_per_cabang[$jenis];
		}
		unset($row); // referensi foreach

		// Generate nomor BPKK
		$kode_cabang = $this->getKodBPKKgFromAddress($address_user);
		$no_bpkk = $this->M_bpkk->generateNoBpkk($kode_cabang);

		// Kirim data ke view
		$data = array(
			'judul' => "Petty Cash | Dashboard",
			'rowpengeluaranbpkk' => $transaksi,
			'donut_chart' => $donut_chart,
			'rekap_tahunan' => $rekap_tahunan,
			'data_saldojkt' => $data_saldojkt,
			'no_bpkk' => $no_bpkk,
			'in_progress' => $this->M_bpkk->getWidgetData('In progress', 'all'),
			'approved'    => $this->M_bpkk->getWidgetData('Approved', 'all'),
			'revisi'      => $this->M_bpkk->getWidgetData('Revisi', 'all'),
			'rejected'    => $this->M_bpkk->getWidgetData('Rejected', 'all'),
		);

		$this->template->load('template', 'dashboard', $data);
	}

	public function filter_widget()
	{
		$jenis_saldo = $this->input->post('jenis_saldo');

		$response = [
			'in_progress' => $this->M_bpkk->getWidgetData('In progress', $jenis_saldo),
			'approved'    => $this->M_bpkk->getWidgetData('Approved', $jenis_saldo),
			'revisi'      => $this->M_bpkk->getWidgetData('Revisi', $jenis_saldo),
			'rejected'    => $this->M_bpkk->getWidgetData('Rejected', $jenis_saldo),
		];

		echo json_encode($response);
	}

	public function tambahpengeluaranbpkk()
	{
		$nobpkk     			= $this->input->post('no_bpkk');
		$sbu               		= $this->input->post('optionsRadios');
		$sbu_unit 				= $this->input->post('check-box');

		// Pastikan hasilnya selalu string
		if (!empty($sbu_unit) && is_array($sbu_unit)) {
			$sbu_unit = implode(', ', $sbu_unit);
		} else {
			$sbu_unit = '';  // biar tidak NULL atau array
		}
		$jenis_saldo          	= $this->input->post('address_cab');
		$tanggal_pengeluaran    = $this->input->post('tanggal');
		$keterangan_bpkk        = $this->input->post('keterangan');
		$jenis_pengeluaran      = $this->input->post('jenis_pengeluaran');
		$totalkredit       		= $this->input->post('total_debet');
		$address_user 			= $this->fungsi->user_login()->address_user;
		$nopettycash 			= $this->M_bpkk->getLastNoPettyCashBySaldo($jenis_saldo);
		$saldopettycash 		= $this->M_bpkk->getsaldopettycash($jenis_saldo);

		if (!$nopettycash) {
			$this->session->set_flashdata('error', 'Nomor petty cash tidak ditemukan untuk jenis saldo: ' . $jenis_saldo);
			redirect('dashboard');
			return;
		}

		$cleaned_keterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $keterangan_bpkk);
		$upload_folder = './uploads/BPKK/' . $jenis_saldo . '/';
		$file_name = $cleaned_keterangan . '.pdf';

		if (!is_dir($upload_folder)) {
			mkdir($upload_folder, 0777, true);
		}

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = 2048; // 2MB
		$config['file_name']     = $file_name;
		$config['overwrite']     = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_dokumen')) {
			$error = $this->upload->display_errors();
			log_message('error', 'Upload error: ' . $error);
			$this->session->set_flashdata('error', 'Gagal upload file: ' . $error);
			redirect('dashboard');
			return;
		}

		$upload_data = $this->upload->data();
		$file_path = $upload_data['file_name'];

		// database tb_bpkk_cab
		$data = [
			'no_bpkk_cab'            => $nobpkk,
			'sbu'  					 => $sbu,
			'sbu_unit'         		 => $sbu_unit,
			'jenis_saldo'         	 => $jenis_saldo,
			'tgl_kredit_cab'     	 => $tanggal_pengeluaran,
			'ket_bpkk_cab'         	 => $keterangan_bpkk,
			'jenis_pengeluaran_cab'  => $jenis_pengeluaran,
			'total_kredit_cab'       => $totalkredit,
			'status_cab'     		 => 'In progress',
			'status_bpkk'     		 => 'Open',
			'upload_file_cab'        => $file_path,
			'no_pettycash'       	 => $nopettycash
		];

		// database tb_riwayat_bpkk
		$data2 = [
			'no_bpkk_cab'            => $nobpkk,
			'sbu'  					 => $sbu,
			'sbu_unit'         		 => $sbu_unit,
			'jenis_saldo'         	 => $jenis_saldo,
			'tgl_kredit_cab'     	 => $tanggal_pengeluaran,
			'ket_bpkk_cab'         	 => $keterangan_bpkk,
			'jenis_pengeluaran_cab'  => $jenis_pengeluaran,
			'total_kredit_cab'       => $totalkredit,
			'upload_file_cab'        => $file_path,
			'no_pettycash'        	 => $nopettycash
		];

		// database tb_riwayat_bpkk
		$data3 = [
			'no_bpkk'            	=> $nobpkk,
			'kantor_cab'            => $address_user,
			'jenis_saldo'         	=> $jenis_saldo
		];

		// database tb_data_mutasi
		$data4 = [
			'no_pettycash'           => $nopettycash,
			'no_bpkk_cab'            => $nobpkk,
			'sbu'  					 => $sbu,
			'sbu_unit'         		 => $sbu_unit,
			'jenis_saldo'         	 => $jenis_saldo,
			'tanggal'     	 		 => $tanggal_pengeluaran,
			'keterangan'         	 => $keterangan_bpkk,
			'total_kredit_cab'       => $totalkredit,
			'jenis_transaksi'        => 'Kredit',
			'file'        			 => $file_path,
		];

		$this->M_bpkk->pengeluaranbpkk('tb_bpkk_cab', $data);
		$this->M_bpkk->riwayatbpkk('tb_riwayat_bpkk', $data2);
		$this->M_bpkk->nobpkk('tb_nobpkk', $data3);
		$this->M_bpkk->tambahdatamutasi('tb_data_mutasi', $data4);
		$this->M_bpkk->updateSaldoCabang($jenis_saldo, $totalkredit);
		$this->session->set_flashdata('success', 'Pengajuan saldo petty cash berhasil disimpan.');
		redirect('dashboard');
	}
}