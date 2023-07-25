<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Barang_masuk extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('barang_masuk_model');
		$this->load->model('barang_model');
		$this->load->model('gudang_model');
		$this->load->model('warna_model');
		$this->load->model('koli_model');
		$this->load->model('stock_model');
		$this->load->model('stock_gudang_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/barang_masuk/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['gudangs'] = $this->gudang_model->getAllById();
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{

		if ($this->input->post()) {

			for ($i=0; $i < count($this->input->post('jumlah')); $i++) { 
				$koli = $this->koli_model->getOneBy(array('koli.id' => $_POST['id_koli'][$i]));
				
				if($this->data['users_groups']->id == 2){
					$_POST['id_gudang'] = 1;
				}else if($this->data['users_groups']->id == 3){
					$_POST['id_gudang'] = 2;
				}

				$total = $_POST['jumlah'][$i] * $koli->jumlah;
				
				$data = array(
					'id_barang' => $_POST['id_barang'][$i],
					'id_koli' => $_POST['id_koli'][$i],
					'ukuran' => $_POST['ukuran'][$i],
					'id_warna' => $_POST['id_warna'][$i],
					'jumlah_koli' => $_POST['jumlah'][$i],
					'jumlah_barang' => $total,
					'tanggal' => $_POST['tanggal'],
					'id_gudang' => $_POST['id_gudang'],
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->data['users']->id
				);

				$insert = $this->barang_masuk_model->insert($data);
				//UPDATE STOCK KESELURUHAN
				$stock = $this->stock_model->getOneBy(array('id_barang' => $_POST['id_barang'][$i], 'id_warna' => $_POST['id_warna'][$i], 'ukuran' => $_POST['ukuran'][$i]));
				
				$total = $stock->stock + ($_POST['jumlah'][$i] * $koli->jumlah);

				$data_update = array(
					'stock' => $total
				);

				$this->stock_model->update($data_update, array("id" => $stock->id));
				
				//UPDATE STOCK DI GUDANG
				$stock = $this->stock_gudang_model->getOneBy(array('id_barang' => $_POST['id_barang'][$i], 'id_warna' => $_POST['id_warna'][$i], 'ukuran' => $_POST['ukuran'][$i], 'id_gudang' => $data['id_gudang']));

				
				if($stock){
					$total = $stock->stock + ($_POST['jumlah'][$i] * $koli->jumlah);
	
					$data_update = array(
						'stock' => $total
					);
					$this->stock_gudang_model->update($data_update, array("id" => $stock->id));
				}else{
					$data_insert = array(
						'id_barang' => $_POST['id_barang'][$i],
						'id_warna' => $_POST['id_warna'][$i],
						'ukuran' => $_POST['ukuran'][$i],
						'id_gudang' => $_POST['id_gudang'],
						'stock' => $_POST['jumlah'][$i] * $koli->jumlah
					);

					$this->stock_gudang_model->insert($data_insert);
				}
			}

			if ($insert) {
				$this->session->set_flashdata('message', "Barang Masuk Baru Berhasil Disimpan");
				redirect("barang_masuk");
			} else {
				$this->session->set_flashdata('message_error', "Barang Masuk Baru Gagal Disimpan");
				redirect("barang_masuk");
			}
		} else {
			$this->data['content'] = 'admin/barang_masuk/create_v';
			$this->data['barangs'] = $this->stock_model->getAllById();
			$this->data['gudangs'] = $this->gudang_model->getAllById();
			$this->data['warnas'] = $this->warna_model->getAllById();
			$this->data['kolis'] = $this->koli_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('id_barang', "Barang Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('jumlah', "Jumlah Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$barang_masuk = $this->barang_masuk_model->getOneBy(array('barang_masuk.id' => $this->input->post('id')));
			$barang = $this->barang_model->getOneBy(array('barang.id' => $this->input->post('id_barang')));

			$first_total = $barang->stock - $barang_masuk->jumlah;

			$data = array(
				'jumlah' => $this->input->post('jumlah'),
			);

			$id = $this->input->post('id');

			$update = $this->barang_masuk_model->update($data, array("barang_masuk.id" => $id));

			$end_total = $first_total + $this->input->post('jumlah');

			$data_barang = array(
				'stock' => $end_total
			);

			$this->barang_model->update($data_barang, array("barang.id" => $this->input->post('id_barang')));

			if ($update) {
				$this->session->set_flashdata('message', "barang masuk Berhasil Diubah");
				redirect("barang_masuk", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "barang masuk Gagal Diubah");
				redirect("barang_masuk", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("barang_masuk/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$barang = $this->barang_masuk_model->getAllById(array("barang_masuk.id" => $this->data['id']));
				$this->data['tanggal'] 	= (!empty($barang)) ? $barang[0]->tanggal : "";
				$this->data['jumlah'] 	= (!empty($barang)) ? $barang[0]->jumlah : "";
				$this->data['id_barang'] = (!empty($barang)) ? $barang[0]->id_barang : "";
				$this->data['barang_name'] = (!empty($barang)) ? $barang[0]->barang_name : "";
				$this->data['content'] = 'admin/barang_masuk/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'barang.nama',
			1 => 'gudang',
			2 => 'koli.nama',
			3 => 'warna.nama',
			4 => 'barang_masuk.ukuran',
			5 => 'barang_masuk.jumlah_koli',
			6 => 'barang_masuk.jumlah_barang',
			7 => 'barang_masuk.tanggal',
			8 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$where = array();
		if($this->data['users_groups']->id != 1){
			if($this->data['users_groups']->id == 2){
				$where = array(
					'id_gudang' => 1
				);
			}else if($this->data['users_groups']->id == 3){
				$where = array(
					'id_gudang' => 2
				);
			}
		}else{
			$where = array(
				'id_gudang' => $this->input->post('id_gudang')
			);
		}

		$totalData = $this->barang_masuk_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"barang.nama" => $search_value,
				"gudang.nama" => $search_value,
				"warna.nama" => $search_value,
				"barang_masuk.ukuran" => $search_value,
				"barang_masuk.jumlah_koli" => $search_value,
				"barang_masuk.jumlah_barang" => $search_value,
				"barang_masuk.tanggal" => $search_value,
			);

			if($this->data['users_groups']->id == 1){
				$search["koli.nama"] = $search_value;
			}
			$totalFiltered = $this->barang_masuk_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->barang_masuk_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "barang_masuk/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['gudang_name'] = $data->gudang_name;
				if($this->data['users_groups']->id == 2){
					$nestedData['koli_name'] = $data->koli_name;
					$nestedData['jumlah_koli'] = $data->jumlah_koli;
				}else if($this->data['users_groups']->id == 1 && $this->input->post('id_gudang') == 1){
					$nestedData['koli_name'] = $data->koli_name;
					$nestedData['jumlah_koli'] = $data->jumlah_koli;
				}
				$nestedData['ukuran'] = $data->ukuran;
				$nestedData['jumlah_barang'] = $data->jumlah_barang;
				$nestedData['warna_name'] = $data->warna_name;
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

	public function dataListStok() 
	{
		$columns = array(
			0 => 'barang.nama',
			1 => 'ukuran',
			2 => 'warna.nama',
			3 => 'stock_gudang.stock',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$where = array();
		if($this->data['users_groups']->id != 1){
			if($this->data['users_groups']->id == 2){
				$where = array(
					'id_gudang' => 1
				);
			}else if($this->data['users_groups']->id == 3){
				$where = array(
					'id_gudang' => 2
				);
			}
		}else{
			$where = array(
				'id_gudang' => $this->input->post('id_gudang')
			);
		}
		$totalData = $this->stock_gudang_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"barang.nama" => $search_value,
				"ukuran" => $search_value,
				"warna.nama" => $search_value,
				"stock_gudang.stock" => $search_value,
			);
			$totalFiltered = $this->stock_gudang_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->stock_gudang_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$nestedData['id'] = $start + $key + 1;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['warna_name'] = $data->warna_name;
				$nestedData['ukuran'] = $data->ukuran;
				$nestedData['total_barang'] = $data->stock;
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

	public function getData()
	{
		$barang = $this->barang_model->getOneBy(array('kode_barang'=> $this->input->post('kode_barang')));
		if(!empty($barang)){
			$stock = $this->stock_model->getById(array('id_barang'=> $barang->id));
			$gudang = $this->gudang_model->getAllById();
			$koli = $this->koli_model->getAllById();
	
			if(!empty($barang)){	
				$response_data['status'] = true;
				$response_data['data']['barang'] = $stock;
				$response_data['data']['gudang'] = $gudang;
				$response_data['data']['koli'] = $koli;
				$response_data['message'] = 'Berhasil Mengambil Data';
			}else{
				$response_data['status'] = false;
				$response_data['data'] = [];
				$response_data['message'] = 'Gagal Mengambil Data';
			}
		}else{
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

        echo json_encode($response_data);
	}

	public function getDataWarna()
	{

		$where = array(
			'id_barang' => $this->input->post('id_barang')
		);
		$warna = $this->stock_model->getWarna($where);

		if(!empty($warna)){	
            $response_data['status'] = true;
            $response_data['data']['warna']= $warna;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}

	public function getDataUkuran()
	{

		$where = array(
			'id_barang' => $this->input->post('id_barang'),
			'id_warna' => $this->input->post('id_warna')
		);
		$ukuran = $this->stock_model->getUkuran($where);

		if(!empty($ukuran)){	
            $response_data['status'] = true;
            $response_data['data']['ukuran']= $ukuran;
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
			$barang_masuk = $this->barang_masuk_model->getOneBy(array('barang_masuk.id' => $id));
			
			//STOCK KESELURUHAN
			$barang = $this->stock_model->getOneBy(array('id_barang' => $barang_masuk->id_barang, 'ukuran' => $barang_masuk->ukuran, 'id_warna' => $barang_masuk->id_warna));
					
			$total = $barang->stock - $barang_masuk->jumlah_barang;

			$data_update = array(
				'stock' => $total
			);

			$this->stock_model->update($data_update, array("id" => $barang->id));
			
			//UPDATE STOCK DI GUDANG
			$barang = $this->stock_gudang_model->getOneBy(array('id_barang' => $barang_masuk->id_barang, 'ukuran' => $barang_masuk->ukuran, 'id_warna' => $barang_masuk->id_warna, 'id_gudang' => $barang_masuk->id_gudang));

			$total = $barang->stock - $barang_masuk->jumlah_barang;

			$data_update = array(
				'stock' => $total
			);

			$this->stock_gudang_model->update($data_update, array("id" => $barang->id));;
			
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->barang_masuk_model->update($data, array("barang_masuk.id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Barang Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}


	
}
