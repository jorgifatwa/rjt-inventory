<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Transaksi extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('transaksi_model');
		$this->load->model('barang_keluar_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/transaksi/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'nama' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			if ($this->transaksi_model->insert($data)) {
				$this->session->set_flashdata('message', "transaksi Baru Berhasil Disimpan");
				redirect("transaksi");
			} else {
				$this->session->set_flashdata('message_error', "transaksi Baru Gagal Disimpan");
				redirect("transaksi");
			}
		} else {
			$this->data['content'] = 'admin/transaksi/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function detail() 
	{
		if (!empty($_POST)) {
			$id = $this->input->post('id');
			$this->session->set_flashdata('message_error', validation_errors());
			return redirect("transaksi/detail/" . $id);
		} else {
			$this->data['id'] = $this->uri->segment(3);
			$transaksi = $this->transaksi_model->getDetailTransaksi(array("transaksi.id" => $this->data['id']));
			$barang_keluar = $this->barang_keluar_model->getAllById(array("barang_keluar.id_transaksi" => $this->data['id']));

			echo "<pre>";
			print_r($barang_keluar);
			die();
			$this->data['content'] = 'admin/transaksi/detail_v';
			$this->load->view('admin/layouts/page', $this->data);
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_faktur',
			1 => 'tanggal',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->transaksi_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"transaksi.nama" => $search_value,
				"transaksi.description" => $search_value,
			);
			$totalFiltered = $this->transaksi_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->transaksi_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_read'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "transaksi/detail/" . $data->id . "' class='btn btn-sm btn-info white'> Detail</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['tanggal'] = $data->created_at;
				$nestedData['action'] = $edit_url;
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
			$this->load->model("transaksi_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->transaksi_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "transaksi Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
