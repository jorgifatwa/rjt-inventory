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
		$this->load->model('stock_gudang_model');
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

			$this->data['barang_keluar'] = $barang_keluar;
			$this->data['no_resi'] = $barang_keluar[0]->no_resi;
			$this->data['marketplace'] = $barang_keluar[0]->marketplace_name;
			$this->data['id_marketplace'] = $barang_keluar[0]->id_marketplace;
			$this->data['tanggal'] = $barang_keluar[0]->tanggal;
			$this->data['dibuat_oleh'] = $barang_keluar[0]->first_name." ".$barang_keluar[0]->last_name;

			// $this->data['no_resi'] => $transaksi
			$this->data['content'] = 'admin/transaksi/detail_v';
			$this->load->view('admin/layouts/page', $this->data);
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_resi',
			1 => 'tanggal',
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
					$retur_url = "<a href='" . base_url() . "transaksi/retur/" . $data->id . "' class='btn btn-sm btn-danger white'> Retur</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_resi'] = $data->no_resi;
				$nestedData['tanggal'] = $data->created_at;
				$nestedData['action'] = $edit_url." ".$retur_url;
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

	public function retur(){
		$this->form_validation->set_rules('id_barang', "Barang Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('id_warna', "Warna Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('ukuran', "Warna Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('jumlah', "Jumlah Harus Diisi", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			$barang_keluar = $this->barang_keluar_model->getAllById(array("barang_keluar.id_transaksi" => $this->input->post('id_transaksi'), 'barang_keluar.id_barang' => $this->input->post('id_barang'), 'barang_keluar.id_warna' => $this->input->post('id_warna'), 'barang_keluar.ukuran' => $this->input->post('ukuran')));
			if($barang_keluar[0]->jumlah > $this->input->post('jumlah')){
				$data = array(
					'id_transaksi' => $this->input->post('id_transaksi'),
					'id_barang_keluar' => $barang_keluar[0]->barang_keluar_id,
					'id_barang' => $this->input->post('id_barang'),
					'id_warna' => $this->input->post('id_warna'),
					'ukuran' => $this->input->post('ukuran'),
					'jumlah' => $this->input->post('jumlah'),
					'description' => $this->input->post('description'),
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->data['users']->id
				);

				$total = $barang_keluar[0]->jumlah - $this->input->post('jumlah');

				$data_update = array(
					'jumlah' => $total
				);

				$update = $this->barang_keluar_model->update($data_update, array("id" => $barang_keluar[0]->barang_keluar_id));
				
				$barang = $this->stock_gudang_model->getOneBy(array('id_barang' => $barang_keluar[0]->id_barang, 'ukuran' =>  $barang_keluar[0]->ukuran, 'id_warna' =>  $barang_keluar[0]->id_warna, 'id_gudang' => 2));
	
				$total = $barang->stock + $this->input->post('jumlah');
	
				$data_update = array(
					'stock' => $total
				);
	
				$this->stock_gudang_model->update($data_update, array("id" => $barang->id));

				if ($this->transaksi_model->insert_retur($data)) {
					$this->session->set_flashdata('message', "Retur Baru Berhasil Disimpan");
					redirect("transaksi");
				} else {
					$this->session->set_flashdata('message_error', "Retur Baru Gagal Disimpan");
					redirect("transaksi");
				}
			}else{
				$this->session->set_flashdata('message_error', "Jumlah Terlalu Besar");
				redirect("transaksi/retur/".$this->input->post('id_transaksi'));
			}
			
		} else {
			$this->data['content'] = 'admin/transaksi/retur_v';
			$this->data['id_transaksi'] = $this->uri->segment(3);

			$this->data['barang_keluar'] = $this->barang_keluar_model->getAllByIdRetur(array("barang_keluar.id_transaksi" => $this->data['id_transaksi']));

			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function getWarna(){
		$barang_keluar = $this->barang_keluar_model->getAllById(array("barang_keluar.id_transaksi" => $this->input->post('id_transaksi'), 'barang_keluar.id_barang' => $this->input->post('id_barang')));
		if(!empty($barang_keluar)){	
            $response_data['status'] = true;
            $response_data['data'] = $barang_keluar;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Tidak Ditemukan';
        }

        echo json_encode($response_data);
	}

	public function getUkuran(){
		$barang_keluar = $this->barang_keluar_model->getAllById(array("barang_keluar.id_transaksi" => $this->input->post('id_transaksi'), 'barang_keluar.id_barang' => $this->input->post('id_barang'), 'barang_keluar.id_warna' => $this->input->post('id_warna')));
		if(!empty($barang_keluar)){	
            $response_data['status'] = true;
            $response_data['data'] = $barang_keluar;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Tidak Ditemukan';
        }

        echo json_encode($response_data);
	}
	
}
