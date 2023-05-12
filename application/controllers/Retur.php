<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Retur extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('retur_model');
		$this->load->model('barang_keluar_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/retur/list_v';
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

			if ($this->retur_model->insert($data)) {
				$this->session->set_flashdata('message', "retur Baru Berhasil Disimpan");
				redirect("retur");
			} else {
				$this->session->set_flashdata('message_error', "retur Baru Gagal Disimpan");
				redirect("retur");
			}
		} else {
			$this->data['content'] = 'admin/retur/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$data = array(
				'nama' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			$update = $this->retur_model->update($data, array("retur.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "retur Berhasil Diubah");
				redirect("retur", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "retur Gagal Diubah");
				redirect("retur", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("retur/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$retur = $this->retur_model->getAllById(array("retur.id" => $this->data['id']));
				$this->data['nama'] 	= (!empty($retur)) ? $retur[0]->nama : "";
				$this->data['description'] = (!empty($retur)) ? $retur[0]->description : "";
				$this->data['content'] = 'admin/retur/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'transaksi.no_resi',
			1 => 'barang.nama',
			2 => 'warna.nama',
			3 => 'retur.ukuran',
			4 => 'retur.jumlah',
			5 => 'retur.description',
			6 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->retur_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"transaksi.no_resi" => $search_value,
				"barang.nama" => $search_value,
				"warna.nama" => $search_value,
				"retur.ukuran" => $search_value,
				"retur.jumlah" => $search_value,
				"retur.description" => $search_value,
			);
			$totalFiltered = $this->retur_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->retur_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "retur/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}		

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_resi'] = $data->no_resi;
				$nestedData['barang_name'] = $data->barang_name;
				$nestedData['warna_name'] = $data->warna_name;
				$nestedData['ukuran'] = $data->ukuran;
				$nestedData['jumlah'] = $data->jumlah;
				$nestedData['description'] = $data->description;
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

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("retur_model");
			$retur = $this->retur_model->getOneBy(array('id' => $id));
			$barang_keluar = $this->barang_keluar_model->getOneBy(array('id' => $retur->id_barang_keluar));
			$total = $barang_keluar->jumlah + $retur->jumlah;
			$data_update = array(
				'jumlah' => $total
			);
			$update = $this->barang_keluar_model->update($data_update, array("id" => $barang_keluar->id));

			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->retur_model->update($data, array("id" => $id));


			$response_data['data'] = $data;
			$response_data['msg'] = "retur Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
