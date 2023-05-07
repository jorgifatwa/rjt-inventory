<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Printer_setting extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('jenis_printer_model');
		$this->load->model('printer_setting_model');
    }

	public function index()
	{
		$this->load->helper('url');

		$this->data['jenis_printer'] = $this->jenis_printer_model->getAllById([]);
		$this->data['content'] = 'pos/printer';   
		
		$this->load->view('pos/layouts/settings_page',$this->data);   

	}

	public function create()
    { 
		$this->form_validation->set_rules('jenis_printer_id',"jenis_printer_id Is Required", 'trim|required'); 
		$this->form_validation->set_rules('printer_output',"printer_output Is Required", 'trim|required'); 
		$this->form_validation->set_rules('alias',"alias Is Required", 'trim|required'); 
		$this->form_validation->set_rules('nama_printer',"nama_printer Is Required", 'trim|required'); 
		if ($this->form_validation->run() === TRUE)
		{ 
			$data = array(
				'jenis_printer_id'  => $this->input->post('jenis_printer_id'),
				'printer_output' => $this->input->post('printer_output'),
				'nama_printer'  => $this->input->post('nama_printer'),
				'alias'         => $this->input->post('alias'),
				'target_ip'     => $this->input->post('target_ip'),
				'created_at'    => date('Y-m-d H:i:s'),
				'updated_at'    => date('Y-m-d H:i:s'),
				'is_deleted'    => 0,
			);
			$insert_printer = $this->printer_setting_model->insert($data);

			if ($insert_printer)
			{ 
				$this->session->set_flashdata('message', "Berhasil Menambahkan Printer Setting");
				redirect("printer_setting");
			}
			else
			{
				$this->session->set_flashdata('message_error',"Gagal Menambahkan Printer Setting");
				redirect("printer_setting");
			}
		}   
        
    } 

    public function edit()
    { 
		$this->form_validation->set_rules('jenis_printer_id_edit',"jenis_printer_id Is Required", 'trim|required'); 
		$this->form_validation->set_rules('printer_output_edit',"printer_output Is Required", 'trim|required'); 
		$this->form_validation->set_rules('alias_edit',"alias Is Required", 'trim|required'); 
		$this->form_validation->set_rules('nama_printer_edit',"nama_printer Is Required", 'trim|required'); 
		if ($this->form_validation->run() === TRUE)
		{
			$data = array(
				'jenis_printer_id'  => $this->input->post('jenis_printer_id_edit'),
				'printer_output'  => $this->input->post('printer_output_edit'),
				'nama_printer'  => $this->input->post('nama_printer_edit'),
				'alias'         => $this->input->post('alias_edit'),
				'target_ip'     => $this->input->post('target_ip_edit'),
				'updated_at'    => date('Y-m-d H:i:s'),
			);
			$update = $this->printer_setting_model->update($data, ['printer_settings.id' => $this->input->post('printer_settings_id_edit')]);
			if ($update)
			{ 
				$this->session->set_flashdata('message', "Berhasil Mengubah Data Printer Setting");
				redirect("printer_setting","refresh");
			}else{
				$this->session->set_flashdata('message_error', "Gagal Mengubah Data Printer Setting");
				redirect("printer_setting","refresh");
			}
		}  
    }

	public function dataList()
	{
		$columns = array(
            0 =>'jenis_printer.nama_jenis',
            1 =>'printer_settings.nama_printer',
            2 =>'printer_settings.alias',
            3 =>'printer_settings.target_ip',
            4 =>'printer_settings.printer_output',
            5 =>'printer_settings.is_deleted',
            6 =>'action'
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$where= array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->printer_setting_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);

        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            if(strtolower($search_value) == "aktif"){
                $search = array(
                    "printer_settings.is_deleted"=>0,
                );
            }elseif (strtolower($search_value) == "tidak aktif") {
                $search = array(
                    "printer_settings.is_deleted"=>1,
                );
            }else{
                $search = array(
                    "printer_settings.alias" =>$search_value,
                    "printer_settings.target_ip" =>$search_value,
                    "jenis_printer.nama_jenis" =>$search_value,
                    "printer_settings.nama_printer" =>$search_value,
                    "printer_settings.printer_output" =>$search_value,
                );
            }
			$totalFiltered = $this->printer_setting_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
        	$totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->printer_setting_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {
                $test_url = "";
            	$edit_url = "";
     			$delete_url = "";

            	if($data->is_deleted == 0){
                    $test_url = "<a href='#' class='dropdown-item test' data-id='".$data->id."'><i class='fa fa-print mr-2'></i> Test Print</a>";
                }

				$edit_url = "<a href='#' class='dropdown-item edit' data-id='".$data->id."'><i class='fa fa-pencil mr-2'></i> Ubah</a>";
                
				if($data->is_deleted == 0){
					$delete_url = "<a href='#' 
						url='".base_url()."printer_setting/destroy/".$data->id."/".$data->is_deleted."'
						data-status='1' class='dropdown-item delete'><i class='fa fa-lock mr-2'></i> NonAktifkan</a>";
				}else{
					$delete_url = "<a href='#' 
						url='".base_url()."printer_setting/destroy/".$data->id."/".$data->is_deleted."'
						data-status='2' class='dropdown-item delete'><i class='fa fa-lock mr-2'></i> Aktifkan</a>";
				}

                if($data->is_deleted == 0){
                    $is_deleted = 'Aktif';
                }elseif ($data->is_deleted == 1) {
                    $is_deleted = 'Tidak Aktif';
                }


                $nestedData['id'] = $start+$key+1;
                $nestedData['nama_jenis'] = $data->nama_jenis;
                $nestedData['nama_printer'] = $data->nama_printer;
                $nestedData['alias'] = $data->alias;
                $nestedData['target_ip'] = $data->target_ip;
                $nestedData['printer_output'] = $data->printer_output;
           		$nestedData['is_deleted'] = $is_deleted;
                $nestedData['action'] = '<div class="dropdown">
                    <button type="button" class="btn btn-yellow" data-toggle="dropdown">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="dropdown-menu">
                        '.$test_url.''.$edit_url.''.$delete_url.'
                    </div>
                </div>';
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $new_data
                    );

        echo json_encode($json_data);
	}

    public function destroy()
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

        $id =$this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted' => ($is_deleted == 1)?0:1
            ); 
            $update = $this->printer_setting_model->update($data,array("id"=>$id));

            $response_data['data'] = $data; 
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }
        
        echo json_encode($response_data); 
    }

    public function getPrinter()
    {
        $response_data = array();
        $id = $this->input->get('id');
        $data_printer = $this->printer_setting_model->getOneBy(['printer_settings.id' => $id]);

        if($data_printer){
            $response_data['status'] = true;
            $response_data['data'] = $data_printer;
            $response_data['message'] = "Berhasil Mengambil Data";
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = "Gagal Mengambil Data";
        }

        echo json_encode($response_data);
    }

    public function testPrinter($id)
    {
        $printer_settings = $this->printer_setting_model->getOneBy(['printer_settings.id' => $id]);
        if($printer_settings){
            $this->data['menu_privilleges'] = 'false';
            $this->load->helper('printer_helper');
            
            $printer = tesprinter($printer_settings);
        }
    }

	
}
