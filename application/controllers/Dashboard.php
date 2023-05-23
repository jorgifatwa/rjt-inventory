<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Dashboard extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('barang_masuk_model');
		$this->load->model('barang_keluar_model');
		$this->load->model('transaksi_model');
		$this->load->model('stock_model');
		$this->load->model('price_marketplace_model');
	}
	public function index() {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/dashboard';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$barang_masuk = $this->stock_model->getAllByIdNoGroupBy();

		if($barang_masuk){
			for ($i=0; $i < count($barang_masuk); $i++) { 
				$total[$i] = $barang_masuk[$i]->harga_modal * $barang_masuk[$i]->stock;
			}
		}else{
			$total = [];
		}

		$barang_keluar = $this->barang_keluar_model->getTotalKotor(array(
			'MONTH(barang_keluar.tanggal)' => date('m'),
			'YEAR(barang_keluar.tanggal)' => date('Y'),
			'id_gudang' => null
		));

		$price_marketplace = $this->price_marketplace_model->getAllById();

		if($barang_keluar){
			for ($i=0; $i < count($barang_keluar); $i++) { 
				foreach ($price_marketplace as $key => $price) {
					if($barang_keluar[$i]->id_barang == $price->id_barang && $barang_keluar[$i]->id_marketplace == $price->id_marketplace ){
						$total_keluar[$i] = $price->harga * $barang_keluar[$i]->jumlah;
						$total_bersih[$i] = $price->harga - $barang_keluar[$i]->harga_modal; 
					}
				}
			}
		}else{
			$total_keluar = [];
			$total_bersih = [];
		}

		$this->data['modal'] = array_sum($total);
		$this->data['pendapatan_kotor'] = array_sum($total_keluar);
		$this->data['pendapatan_bersih'] = array_sum($total_bersih);

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function grafikPendapatan() {

		$bulan = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];

		$datas = $this->barang_keluar_model->getAllGrafik();
		
		$month = [];
		$data_pendapatan = [];
		$data_bulan = [];

		for ($i=1; $i <= count($bulan); $i++) { 
			$data_pendapatan[$i] = 0;
			$data_bulan[$i] = $bulan[$i];
		}
		
		$i = 1;

		$price_marketplace = $this->price_marketplace_model->getAllById();
		
		if(!empty($datas)){
			foreach ($datas as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				
				for ($index=1; $index <= count($bulan); $index++) { 
					if($bulan[$month[$i]] == $data_bulan[$index]){
						foreach ($price_marketplace as $key => $price) {
							if($data->id_barang == $price->id_barang && $data->id_marketplace == $price->id_marketplace){
								$data_pendapatan[$index] = $data_pendapatan[$index] + ($data->jumlah * $price->harga);
							}
						}
					}
					$data_bulan[$i] = $bulan[$i];
				}
				$i++;
			}
		}
		
		$data_grafik = [
			"tahun" => date('Y'),
			"category" => $data_bulan,
			"pendapatan" => $data_pendapatan,
		];

		if (!empty($data_grafik)) {
			// $return_data['data'] = $datas;
			$return_data['grafik'] = $data_grafik;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['data'] = [];
			$return_data['grafik'] = [];
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function grafikPendapatanMarketplace() {

		$bulan = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];

		$data_shopees = $this->barang_keluar_model->getGrafikPendapatanShopee();
		$data_tiktoks = $this->barang_keluar_model->getGrafikPendapatanTiktok();
		$data_tokopedias = $this->barang_keluar_model->getGrafikPendapatanTokopedia();
		$data_lazadas = $this->barang_keluar_model->getGrafikPendapatanLazada();
		
		$month = [];
		$data_pendapatan_shopee = [];
		$data_pendapatan_tiktok = [];
		$data_pendapatan_tokopedia = [];
		$data_pendapatan_lazada = [];
		$data_bulan = [];

		for ($i=1; $i <= count($bulan); $i++) { 
			$data_pendapatan_shopee[$i] = 0;
			$data_pendapatan_tiktok[$i] = 0;
			$data_pendapatan_tokopedia[$i] = 0;
			$data_pendapatan_lazada[$i] = 0;
			$data_bulan[$i] = $bulan[$i];
		}
		
		$i = 1;

		$price_marketplace = $this->price_marketplace_model->getAllById();
		
		if(!empty($data_shopees)){
			foreach ($data_shopees as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				
				for ($index=1; $index <= count($bulan); $index++) { 
					if($bulan[$month[$i]] == $data_bulan[$index]){
						foreach ($price_marketplace as $key => $price) {
							if($data->id_barang == $price->id_barang && $data->id_marketplace == $price->id_marketplace){
								$data_pendapatan_shopee[$index] = $data_pendapatan_shopee[$index] + ($data->jumlah * $price->harga);
							}
						}
					}
					$data_bulan[$i] = $bulan[$i];
				}
				$i++;
			}
		}

		$i = 1;

		if(!empty($data_tiktoks)){
			foreach ($data_tiktoks as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				
				for ($index=1; $index <= count($bulan); $index++) { 
					if($bulan[$month[$i]] == $data_bulan[$index]){
						foreach ($price_marketplace as $key => $price) {
							if($data->id_barang == $price->id_barang && $data->id_marketplace == $price->id_marketplace){
								$data_pendapatan_tiktok[$index] = $data_pendapatan_tiktok[$index] + ($data->jumlah * $price->harga);
							}
						}
					}
					$data_bulan[$i] = $bulan[$i];
				}
				$i++;
			}
		}

		$i = 1;

		if(!empty($data_tokopedias)){
			foreach ($data_tokopedias as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				
				for ($index=1; $index <= count($bulan); $index++) { 
					if($bulan[$month[$i]] == $data_bulan[$index]){
						foreach ($price_marketplace as $key => $price) {
							if($data->id_barang == $price->id_barang && $data->id_marketplace == $price->id_marketplace){
								$data_pendapatan_tokopedia[$index] = $data_pendapatan_tokopedia[$index] + ($data->jumlah * $price->harga);
							}
						}
					}
					$data_bulan[$i] = $bulan[$i];
				}
				$i++;
			}
		}

		$i = 1;

		if(!empty($data_lazadas)){
			foreach ($data_lazadas as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				
				for ($index=1; $index <= count($bulan); $index++) { 
					if($bulan[$month[$i]] == $data_bulan[$index]){
						foreach ($price_marketplace as $key => $price) {
							if($data->id_barang == $price->id_barang && $data->id_marketplace == $price->id_marketplace){
								$data_pendapatan_lazada[$index] = $data_pendapatan_lazada[$index] + ($data->jumlah * $price->harga);
							}
						}
					}
					$data_bulan[$i] = $bulan[$i];
				}
				$i++;
			}
		}
		
		$data_grafik = [
			"tahun" => date('Y'),
			"category" => $data_bulan,
			"pendapatan_shopee" => $data_pendapatan_shopee,
			"pendapatan_tiktok" => $data_pendapatan_tiktok,
			"pendapatan_lazada" => $data_pendapatan_lazada,
			"pendapatan_tokopedia" => $data_pendapatan_tokopedia
		];

		$return_data['grafik'] = $data_grafik;
		$return_data['status'] = true;
		$return_data['message'] = "Berhasil mengambil data!";

		echo json_encode($return_data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'nomor',
			1 => 'barang.nama',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array('id_gudang' => null);

		$limit = 0;
		$start = 0;
		$totalData = $this->barang_keluar_model->getCountAllByFavorite($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"barang.nama" => $search_value,
			);

			$totalFiltered = $this->barang_keluar_model->getCountAllByFavorite($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->barang_keluar_model->getAllByFavorite($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$nestedData['nomor'] = $start + $key + 1;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['total'] = $data->total;
				$new_data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $new_data,
		);

		echo json_encode($json_data);
	}
}
