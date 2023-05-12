<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Barang_keluar extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('barang_keluar_model');
		$this->load->model('barang_masuk_model');
		$this->load->model('barang_model');
		$this->load->model('gudang_model');
		$this->load->model('transaksi_model');
		$this->load->model('stock_model');
		$this->load->model('marketplace_model');
		$this->load->model('stock_gudang_model');
		$this->load->model('pendapatan_model');
		$this->load->helper('printer_helper');
		$this->load->model('printer_setting_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/barang_keluar/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['gudangs'] = $this->gudang_model->getAllById();
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{

		if ($this->input->post()) {

			$status_stock = false;
			for ($i=0; $i < count($this->input->post('jumlah')); $i++) {
				$barang = $this->stock_model->getStock(array('id_barang' => $_POST['id_barang'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_warna' => $_POST['id_warna'][$i]));
				$total = $barang[0]->stock - $_POST['jumlah'][$i];
				if($total < 0){
					$status_stock = false;
				}else{
					$status_stock = true;
				}	
			}

			if($status_stock == true){
				if($this->data['users_groups']->id == 3){
					$data_transaksi = array(
						'no_resi' => $_POST['no_resi'],
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->data['users']->id
					);

					$insert_transaksi = $this->transaksi_model->insert($data_transaksi);
				}
	
				for ($i=0; $i < count($this->input->post('jumlah')); $i++) {

						if($this->data['users_groups']->id != 3){
							$insert_transaksi = 0;
						}

						$data = array(
							'id_transaksi' => $insert_transaksi,
							'id_barang' => $_POST['id_barang'][$i],
							'jumlah' => $_POST['jumlah'][$i],
							'tanggal' => $_POST['tanggal'],
							'ukuran' => $_POST['ukuran'][$i],
							'id_warna' => $_POST['id_warna'][$i],
							'created_at' => date('Y-m-d H:i:s'),
							'created_by' => $this->data['users']->id
						);
						if($this->data['users_groups']->id == 2){
							$data['id_gudang'] = $_POST['id_gudang'];
						}else if($this->data['users_groups']->id == 3){
							$data['id_marketplace'] = $_POST['id_marketplace'];
						}

						$insert_barang_keluar = $this->barang_keluar_model->insert($data);

						if($this->data['users_groups']->id == 2){
							$data = array(
								'id_barang' => $_POST['id_barang'][$i],
								'id_warna' => $_POST['id_warna'][$i],
								'ukuran' => $_POST['ukuran'][$i],
								'id_gudang' => $_POST['id_gudang'],
								'jumlah_barang' => $_POST['jumlah'][$i],
								'tanggal' => $_POST['tanggal'],
								'created_at' => date('Y-m-d H:i:s'),
								'created_by' => $this->data['users']->id
							);
	
							$insert_barang_masuk = $this->barang_masuk_model->insert($data);

							//UPDATE STOCK DI GUDANG
							$stock = $this->stock_gudang_model->getOneBy(array('id_barang' => $_POST['id_barang'][$i], 'id_warna' => $_POST['id_warna'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_gudang' => 1));
						
							$total = $stock->stock - $_POST['jumlah'][$i];
			
							$data_update = array(
								'stock' => $total
							);

							$this->stock_gudang_model->update($data_update, array("id" => $stock->id));
							//INSERT ATAU UPDATE DATA DI STOCK GUDANG YANG DI PINDAHKAN
							$stock = $this->stock_gudang_model->getOneBy(array('id_barang' => $_POST['id_barang'][$i], 'id_warna' => $_POST['id_warna'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_gudang' => $_POST['id_gudang']));
							if($stock){
								$total = $stock->stock + $_POST['jumlah'][$i];
			
								$data_update = array(
									'stock' => $total
								);

								$this->stock_gudang_model->update($data_update, array("id" => $stock->id));
							}else{
								$data = array(
									'id_barang' => $_POST['id_barang'][$i],
									'id_gudang' => $_POST['id_gudang'],
									'stock' => $_POST['jumlah'][$i],
									'ukuran' => $_POST['ukuran'][$i],
									'id_warna' => $_POST['id_warna'][$i],
									'created_at' => date('Y-m-d H:i:s'),
									'created_by' => $this->data['users']->id
								);
								$insert_stock_gudang = $this->stock_gudang_model->insert($data);
							}
						}else{
							//UPDATE STOCK DI GUDANG
							$stock = $this->stock_gudang_model->getOneBy(array('id_barang' => $_POST['id_barang'][$i], 'id_warna' => $_POST['id_warna'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_gudang' => 2));
						
							$total = $stock->stock - $_POST['jumlah'][$i];
			
							$data_update = array(
								'stock' => $total
							);

							$this->stock_gudang_model->update($data_update, array("id" => $stock->id));
						}

						//UPDATE STOK KESELURUHAN
						$barang = $this->stock_model->getStock(array('id_barang' => $_POST['id_barang'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_warna' => $_POST['id_warna'][$i]));

						$total = $barang[0]->stock - $_POST['jumlah'][$i];

						$data_update = array(
							'stock' => $total
						);
		
						$this->stock_model->update($data_update, array('id_barang' => $_POST['id_barang'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_warna' => $_POST['id_warna'][$i]));
				}
				
				$this->session->set_flashdata('message', "Barang Keluar Baru Berhasil Disimpan");
				redirect("barang_keluar");
			}else {
				$this->session->set_flashdata('message_error', "Barang Keluar Baru Gagal Disimpan");
				redirect("barang_keluar");
			}
		} else {
			$this->data['content'] = 'admin/barang_keluar/create_v';
			$this->data['barangs'] = $this->barang_model->getAllById();
			$this->data['marketplaces'] = $this->marketplace_model->getAllById();
			$this->data['gudangs'] = $this->gudang_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function dataList() 
	{
		if($this->data['users_groups']->id == 2){
			$columns = array(
				0 => 'barang.nama',
				1 => 'barang_keluar.ukuran',
				2 => 'barang_keluar.warna',
				3 => 'gudang.name',
				4 => 'barang_keluar.jumlah',
				5 => 'barang_keluar.tanggal',
				6 => '',
			);
		}else if($this->data['users_groups']->id == 3){
			$columns = array(
				0 => 'barang.nama',
				1 => 'barang_keluar.ukuran',
				2 => 'barang_keluar.warna',
				3 => 'marketplace.name',
				4 => 'barang_keluar.jumlah',
				5 => 'barang_keluar.tanggal',
				6 => '',
			);
		}else{
			$id_gudang = $this->input->post('id_gudang');
			if($id_gudang == 1){
				$columns = array(
					0 => 'barang.nama',
					1 => 'barang_keluar.ukuran',
					2 => 'barang_keluar.warna',
					3 => 'gudang.name',
					4 => 'barang_keluar.jumlah',
					5 => 'barang_keluar.tanggal',
					6 => '',
				);
			}else{
				$columns = array(
					0 => 'barang.nama',
					1 => 'barang_keluar.ukuran',
					2 => 'barang_keluar.warna',
					3 => 'marketplace.name',
					4 => 'barang_keluar.jumlah',
					5 => 'barang_keluar.tanggal',
					6 => '',
				);
			}
		}

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		if($this->data['users_groups']->id == 2){
			$where = array('id_marketplace' => null);
		}else if($this->data['users_groups']->id == 3){
			$where = array('id_gudang' => null);
		}else{
			if($id_gudang == 1){
				$where = array('id_marketplace' => null, 'id_gudang' => $id_gudang);
			}else{
				$where = array('id_gudang' => null, 'id_gudang' => $id_gudang);
			}
		}
		$limit = 0;
		$start = 0;
		$totalData = $this->barang_keluar_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			if($this->data['users_groups']->id == 2){
				$search = array(
					"barang.nama" => $search_value,
					"gudang.nama" => $search_value,
					"barang_keluar.jumlah" => $search_value,
					"barang_keluar.tanggal" => $search_value,
				);
			}else if($this->data['users_groups']->id == 3){
				$search = array(
					"barang.nama" => $search_value,
					"marketplace.nama" => $search_value,
					"barang_keluar.jumlah" => $search_value,
					"barang_keluar.tanggal" => $search_value,
				);
			}else{
				if($id_gudang == 1){
					$search = array(
						"barang.nama" => $search_value,
						"gudang.nama" => $search_value,
						"barang_keluar.jumlah" => $search_value,
						"barang_keluar.tanggal" => $search_value,
					);
				}else{
					$search = array(
						"barang.nama" => $search_value,
						"marketplace.nama" => $search_value,
						"barang_keluar.jumlah" => $search_value,
						"barang_keluar.tanggal" => $search_value,
					);
				}
			}
			$totalFiltered = $this->barang_keluar_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->barang_keluar_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "barang_keluar/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['ukuran'] = $data->ukuran;
				$nestedData['warna_name'] = $data->warna_name;
				if($this->data['users_groups']->id == 2){
					$nestedData['gudang_name'] = $data->gudang_name;
				}else if($this->data['users_groups']->id == 3){
					$nestedData['marketplace_name'] = $data->marketplace_name;
				}else{
					if($id_gudang == 1){
						$nestedData['gudang_name'] = $data->gudang_name;
					}else{
						$nestedData['marketplace_name'] = $data->marketplace_name;
					}
				}
				$nestedData['jumlah'] = $data->jumlah;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['action'] = $delete_url;
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

	public function getDataBarang()
	{
		$barang = $this->barang_model->getAllById();

		if(!empty($barang)){	
            $response_data['status'] = true;
            $response_data['data'] = $barang;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$barang_keluar = $this->barang_keluar_model->getOneBy(array('barang_keluar.id' => $id));
			
			//STOCK KESELURUHAN
			$barang = $this->stock_model->getOneBy(array('id_barang' => $barang_keluar->id_barang, 'ukuran' => $barang_keluar->ukuran, 'id_warna' => $barang_keluar->id_warna));
					
			$total = $barang->stock + $barang_keluar->jumlah;

			$data_update = array(
				'stock' => $total
			);

			$this->stock_model->update($data_update, array("id" => $barang->id));
			
			//UPDATE STOCK DI GUDANG
			if($barang_keluar->id_gudang != null){
				$barang = $this->stock_gudang_model->getOneBy(array('id_barang' => $barang_keluar->id_barang, 'ukuran' => $barang_keluar->ukuran, 'id_warna' => $barang_keluar->id_warna, 'id_gudang' => $barang_keluar->id_gudang));
	
				$total = $barang->stock - $barang_keluar->jumlah;
	
				$data_update = array(
					'stock' => $total
				);
	
				$this->stock_gudang_model->update($data_update, array("id" => $barang->id));

				$barang = $this->stock_gudang_model->getOneBy(array('id_barang' => $barang_keluar->id_barang, 'ukuran' => $barang_keluar->ukuran, 'id_warna' => $barang_keluar->id_warna, 'id_gudang' => 1));
	
				$total = $barang->stock + $barang_keluar->jumlah;
	
				$data_update = array(
					'stock' => $total
				);
	
				$this->stock_gudang_model->update($data_update, array("id" => $barang->id));
			}else{
				$barang = $this->stock_gudang_model->getOneBy(array('id_barang' => $barang_keluar->id_barang, 'ukuran' => $barang_keluar->ukuran, 'id_warna' => $barang_keluar->id_warna, 'id_gudang' => 2));
	
				$total = $barang->stock + $barang_keluar->jumlah;
	
				$data_update = array(
					'stock' => $total
				);
	
				$this->stock_gudang_model->update($data_update, array("id" => $barang->id));
			}
			
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->barang_keluar_model->update($data, array("barang_keluar.id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Barang Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function getBarang()
	{
		$barang = $this->barang_model->getAllById(array('barang.kode_barang' => $this->input->post('kode_barang')));

		$where = array(
			'id_barang' => $barang[0]->id
		);

		if($this->data['users_groups']->id == 2){
			$warna = $this->stock_gudang_model->getAllByWarna(array('id_barang' => $barang[0]->id,  'id_gudang' => 1));
		}else if($this->data['users_groups']->id == 3){
			$warna = $this->stock_gudang_model->getAllByWarna(array('id_barang' => $barang[0]->id,  'id_gudang' => 2));
		}

		$ukuran = $this->stock_model->getUkuran($where);

		if(!empty($barang)){	
            $response_data['status'] = true;
            $response_data['data']['barang'] = $barang;
            $response_data['data']['ukuran'] = $ukuran;
            $response_data['data']['warna'] = $warna;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Kode Yang Dimasukkan Salah / Tidak Ditemukan';
        }

        echo json_encode($response_data);
	}

	public function getUkuran()
	{		
		if($this->data['users_groups']->id == 2){
			$ukuran = $this->stock_gudang_model->getAllByUkuran(array('id_barang' => $this->input->post('id_barang'),  'id_gudang' => 1, 'id_warna' => $this->input->post('id_warna')));
		}else if($this->data['users_groups']->id == 3){
			$ukuran = $this->stock_gudang_model->getAllByUkuran(array('id_barang' => $this->input->post('id_barang'),  'id_gudang' => 2, 'id_warna' => $this->input->post('id_warna')));
		}

		if(!empty($ukuran)){	
            $response_data['status'] = true;
            $response_data['data']['ukuran'] = $ukuran;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Kode Yang Dimasukkan Salah / Tidak Ditemukan';
        }

        echo json_encode($response_data);
	}

	public function cekStock(){
		if($this->data['users_groups']->id == 2){
			$barang = $this->stock_gudang_model->getAllById(array('id_barang' => $this->input->post('id'), 'ukuran' => $this->input->post('ukuran'), 'id_warna' => $this->input->post('id_warna'), 'id_gudang' => 1));
		}else if($this->data['users_groups']->id == 3){
			$barang = $this->stock_gudang_model->getAllById(array('id_barang' => $this->input->post('id'), 'ukuran' => $this->input->post('ukuran'), 'id_warna' => $this->input->post('id_warna'), 'id_gudang' => 2));
		}
		$total = $barang[0]->stock - $this->input->post('jumlah');
		
		if($total > 0){	
            $response_data['status'] = true;
            $response_data['data'] = $barang;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Stock Tidak Cukup!';
        }

        echo json_encode($response_data);
	}

	public function printSementara($id)
	{
		$response_data['data']   = []; 
		$response_data['status'] = false;
		$response_data['msg'] = "Berhasil Print Sementara";

		// $id = $this->input->post('id');
		// $order = $this->order_model->getOneBy(['order.id' => $id]);
		// $cabang = $this->branch_model->getOneBy(['branch.id' => $order->cabang_id]);
		
		// $where_detail = [
		// 	'order_detail.kode_order' => $order->kode_order, 
		// 	'order_detail.type_item' => 'barang'
		// ];
		// $order_barang = $this->order_detail_model->getAllById($where_detail);

		// $where_detail['order_detail.type_item'] = 'jasa';
		// $order_jasa = $this->order_detail_model->getAllById($where_detail);
		$datas = $this->barang_keluar_model->getAllById(array('barang_keluar.id_transaksi' => $id));

		$ip="";
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		if($ip){
			if($ip == '::1' || $ip == 'localhost' || $ip =='127.0.0.1'){
				$setting_printer = $this->printer_setting_model->getOneBy(array("jenis_printer_id"=>1,'target_ip'=>'::1'));
				if(!$setting_printer){
					$setting_printer = $this->printer_setting_model->getOneBy(array("jenis_printer_id"=>1));
				}
			}else{
				$setting_printer = $this->printer_setting_model->getOneBy(array("jenis_printer_id"=>1,'target_ip'=>$ip));
			}
		}else{
			$setting_printer = $this->printer_setting_model->getOneBy(array("jenis_printer_id"=>1));
		}
		if(!empty($setting_printer)){
			$print = print_struk($setting_printer, $datas);
			if($print){
				$response_data['data']   = []; 
				$response_data['status'] = true;
				$response_data['msg'] = "Berhasil Print Sementara";
			}
		}

		echo json_encode($response_data);
	}


	
}
