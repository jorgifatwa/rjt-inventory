<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Stock extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('stock_model');
		$this->load->model('barang_model');
		$this->load->model('warna_model');
		$this->load->model('stock_gudang_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/stock/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('id_barang', "Barang Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('id_warna', "Warna Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('ukuran', "Ukuran Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('stock', "Stock Harus Dipilih", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'id_barang' => $this->input->post('id_barang'),
				'id_warna' => $this->input->post('id_warna'),
				'ukuran' => $this->input->post('ukuran'),
				'stock' => 0,
				'description' => $this->input->post('description'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);
			$stock = $this->stock_model->getAllByIdNoGroupBy(array("id_barang" => $this->input->post('id_barang'), 'id_warna' => $this->input->post('id_warna'), 'ukuran' => $this->input->post('ukuran')));
			if(!empty($stock)){
				$this->session->set_flashdata('message_error', "stock Barang Sudah Di Set");
				redirect("stock/create", "refresh");
			}else{
				$insert = $this->stock_model->insert($data);
	
				$data['id_gudang'] = 1;
				
				$this->stock_gudang_model->insert($data);
	
				if ($insert) {
					$this->session->set_flashdata('message', "stock Baru Berhasil Disimpan");
					redirect("stock");
				} else {
					$this->session->set_flashdata('message_error', "stock Baru Gagal Disimpan");
					redirect("stock");
				}
			}
		} else {
			$this->data['content'] = 'admin/stock/create_v';
			$this->data['barangs'] = $this->barang_model->getAllById();
			$this->data['warnas'] = $this->warna_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('id_barang', "Barang Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('id_warna', "Warna Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('ukuran', "Ukuran Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('stock', "Stock Harus Dipilih", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'id_barang' => $this->input->post('id_barang'),
				'id_warna' => $this->input->post('id_warna'),
				'ukuran' => $this->input->post('ukuran'),
				'stock' => $this->input->post('stock'),
				'description' => $this->input->post('description'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$stock = $this->stock_model->getAllByIdNoGroupBy(array("id_barang" => $this->input->post('id_barang'), 'id_warna' => $this->input->post('id_warna'), 'ukuran' => $this->input->post('ukuran')));
			if(!empty($stock)){
				$this->session->set_flashdata('message_error', "stock Barang Sudah Di Set");
				redirect("stock/edit/".$this->input->post('id'), "refresh");
			}else{
				$id = $this->input->post('id');
	
				$update = $this->stock_model->update($data, array("stock.id" => $id));
				if ($update) {
					$this->session->set_flashdata('message', "stock Berhasil Diubah");
					redirect("stock", "refresh");
				} else {
					$this->session->set_flashdata('message_error', "stock Gagal Diubah");
					redirect("stock", "refresh");
				}
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("stock/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$stock = $this->stock_model->getAllByIdNoGroupBy(array("stock.id" => $this->data['id']));
				$this->data['barangs'] = $this->barang_model->getAllById();
				$this->data['warnas'] = $this->warna_model->getAllById();
				$this->data['id_barang'] 	= (!empty($stock)) ? $stock[0]->id_barang : "";
				$this->data['id_warna'] 	= (!empty($stock)) ? $stock[0]->id_warna : "";
				$this->data['ukuran'] 	= (!empty($stock)) ? $stock[0]->ukuran : "";
				$this->data['stock'] 	= (!empty($stock)) ? $stock[0]->stock : "";
				$this->data['description'] = (!empty($stock)) ? $stock[0]->description : "";
				$this->data['content'] = 'admin/stock/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'barang.nama',
			1 => 'warna.nama',
			2 => 'ukuran',
			3 => 'stock',
			4 => 'description',
			5 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->stock_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"barang.nama" => $search_value,
				"warna.nama" => $search_value,
				"ukuran" => $search_value,
				"stock" => $search_value,
			);
			$totalFiltered = $this->stock_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->stock_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "stock/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "stock/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}
				$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
		

				$nestedData['id'] = $start + $key + 1;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['warna_name'] = $data->warna_name;
				$nestedData['ukuran'] = $data->ukuran;
				$nestedData['stock'] = $data->stock;
				$nestedData['description'] = substr(strip_tags($data->description), 0, 50);
				$nestedData['action'] = $edit_url . " " . $delete_url;
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

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("stock_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->stock_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "stock Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
