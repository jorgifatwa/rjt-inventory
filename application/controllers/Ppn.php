<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Ppn extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('ppn_model');
		$this->load->model('marketplace_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/ppn/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('id_marketplace', "Marketplace Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('ppn', "PPN Harus Diisi", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'id_marketplace' => $this->input->post('id_marketplace'),
				'ppn' => $this->input->post('ppn'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			if ($this->ppn_model->insert($data)) {
				$this->session->set_flashdata('message', "ppn Baru Berhasil Disimpan");
				redirect("ppn");
			} else {
				$this->session->set_flashdata('message_error', "ppn Baru Gagal Disimpan");
				redirect("ppn");
			}
		} else {
			$this->data['content'] = 'admin/ppn/create_v';
			$this->data['marketplaces'] = $this->marketplace_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('id_marketplace', "Marketplace Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('ppn', "PPN Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$data = array(
				'id_marketplace' => $this->input->post('id_marketplace'),
				'ppn' => $this->input->post('ppn'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			$update = $this->ppn_model->update($data, array("ppn.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "ppn Berhasil Diubah");
				redirect("ppn", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "ppn Gagal Diubah");
				redirect("ppn", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("ppn/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$ppn = $this->ppn_model->getAllById(array("ppn.id" => $this->data['id']));
				$this->data['ppn'] 	= (!empty($ppn)) ? $ppn[0]->ppn : "";
				$this->data['id_marketplace'] = (!empty($ppn)) ? $ppn[0]->id_marketplace : "";
				$this->data['description'] = (!empty($ppn)) ? $ppn[0]->description : "";
				$this->data['content'] = 'admin/ppn/edit_v';
				$this->data['marketplaces'] = $this->marketplace_model->getAllById();
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'marketplace.nama',
			1 => 'ppn',
			2 => 'description',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->ppn_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"marketplace.nama" => $search_value,
				"ppn.ppn" => $search_value,
				"ppn.description" => $search_value,
			);
			$totalFiltered = $this->ppn_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->ppn_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "ppn/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "ppn/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}
				$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
		

				$nestedData['id'] = $start + $key + 1;
				$nestedData['marketplace_name'] = $data->marketplace_name;
				$nestedData['ppn'] = $data->ppn;
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
			$this->load->model("ppn_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->ppn_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "ppn Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
