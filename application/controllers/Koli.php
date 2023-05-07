<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Koli extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('koli_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/koli/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('jumlah', "Jumlah Harus Diisi", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'nama' => $this->input->post('name'),
				'jumlah' => $this->input->post('jumlah'),
				'description' => $this->input->post('description'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			if ($this->koli_model->insert($data)) {
				$this->session->set_flashdata('message', "Koli Baru Berhasil Disimpan");
				redirect("koli");
			} else {
				$this->session->set_flashdata('message_error', "Koli Baru Gagal Disimpan");
				redirect("koli");
			}
		} else {
			$this->data['content'] = 'admin/koli/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('jumlah', "Jumlah Harus Diisi", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'nama' => $this->input->post('name'),
				'jumlah' => $this->input->post('jumlah'),
				'description' => $this->input->post('description'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			$update = $this->koli_model->update($data, array("koli.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Koli Berhasil Diubah");
				redirect("koli", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Koli Gagal Diubah");
				redirect("koli", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("koli/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$koli = $this->koli_model->getAllById(array("koli.id" => $this->data['id']));
				$this->data['nama'] 	= (!empty($koli)) ? $koli[0]->nama : "";
				$this->data['jumlah'] 	= (!empty($koli)) ? $koli[0]->jumlah : "";
				$this->data['description'] = (!empty($koli)) ? $koli[0]->description : "";
				$this->data['content'] = 'admin/koli/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'nama',
			1 => 'jumlah',
			2 => 'description',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->koli_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"koli.nama" => $search_value,
				"koli.jumlah" => $search_value,
				"koli.description" => $search_value,
			);
			$totalFiltered = $this->koli_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->koli_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "koli/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "koli/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}
				$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
		

				$nestedData['id'] = $start + $key + 1;
				$nestedData['nama'] = $data->nama;
				$nestedData['jumlah'] = $data->jumlah;
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
			$this->load->model("koli_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->koli_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "koli Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
