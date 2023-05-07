<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class barang_masuk_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("barang_masuk.*")->from("barang_masuk"); 
        $this->db->where($where);  
        $this->db->where("barang_masuk.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function cekKodebarang_masuk()
    {
        $query = $this->db->query("SELECT MAX(kode_barang_masuk) as kodebarang_masuk from barang_masuk");
        $hasil = $query->row();
        return $hasil->kodebarang_masuk;
    }
 

    public function getTotal($where = array()){
        $this->db->select("count(barang_masuk.id) as total")->from("barang_masuk");  
        $this->db->where($where);  
        $this->db->where("barang_masuk.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("barang_masuk.*, barang.nama as barang_name")->from("barang_masuk");  
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->where($where);  
        $this->db->where("barang_masuk.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getTotalModal($where = array()){
        $this->db->select("barang_masuk.*, barang.harga_modal as harga_modal")->from("barang_masuk");
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->where($where);  
        $this->db->where("barang_masuk.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("barang_masuk", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("barang_masuk", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("barang_masuk"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = array())
    {
		if($this->data['users_groups']->id == 2){
            $this->db->select("barang_masuk.*, barang.id as id_barang, barang.nama as barang_name, gudang.nama as gudang_name, koli.nama as koli_name, warna.nama as warna_name")->from("barang_masuk");
		}else if($this->data['users_groups']->id == 3){
            $this->db->select("barang_masuk.*, barang.id as id_barang, barang.nama as barang_name, gudang.nama as gudang_name, warna.nama as warna_name")->from("barang_masuk");
        }
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->join("gudang", "gudang.id = barang_masuk.id_gudang");
        $this->db->join("warna", "warna.id = barang_masuk.id_warna");
		if($this->data['users_groups']->id == 2){
            $this->db->join("koli", "koli.id = barang_masuk.id_koli");
        }
        $this->db->where("barang_masuk.is_deleted",0);  
        $this->db->where($where);  
        $this->db->limit($limit,$start)->order_by($col,$dir);
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
  
        $result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();  
        }
        else
        {
            return null;
        }
    }

    function getCountAllBy($limit,$start,$search,$order,$dir, $where = array())
    { 
        $this->db->select("barang_masuk.*, barang.id as id_barang, gudang.id as id_gudang, barang.nama as barang_name, gudang.nama as gudang_name, koli.nama as koli_name, warna.nama as warna_name")->from("barang_masuk");
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->join("gudang", "gudang.id = barang_masuk.id_gudang");
        $this->db->join("koli", "koli.id = barang_masuk.id_koli");
        $this->db->join("warna", "warna.id = barang_masuk.id_warna");
        $this->db->where("barang_masuk.is_deleted",0);  
        $this->db->where($where);  
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 

    function getAllByStok($limit,$start,$search,$col,$dir, $where = array())
    {
        $this->db->select("barang.id as id_barang, barang_masuk.ukuran as ukuran, barang.nama as barang_name, warna.nama as warna_name, SUM(barang_masuk.jumlah_barang) as total_barang")->from("barang_masuk");
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->join("warna", "warna.id = barang_masuk.id_warna");
        $this->db->group_by('barang_masuk.id_barang');  
        $this->db->group_by('barang_masuk.ukuran');  
        $this->db->group_by('barang_masuk.id_warna');  

        $this->db->where("barang_masuk.is_deleted",0);  
        $this->db->where($where);  
        $this->db->group_by('barang_masuk.id_barang');  
        $this->db->limit($limit,$start)->order_by($col,$dir);
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
  
        $result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();  
        }
        else
        {
            return null;
        }
    }

    function getCountAllByStok($limit,$start,$search,$order,$dir, $where = array())
    { 
        $this->db->select("barang.id as id_barang, barang_masuk.ukuran as ukuran, barang.nama as barang_name, warna.nama as warna_name, SUM(barang_masuk.jumlah_barang) as total_barang")->from("barang_masuk");
        $this->db->join("barang", "barang.id = barang_masuk.id_barang");
        $this->db->join("warna", "warna.id = barang_masuk.id_warna");
        $this->db->where("barang_masuk.is_deleted",0);  
        $this->db->where($where);  
        $this->db->group_by('barang_masuk.id_barang');  
        $this->db->group_by('barang_masuk.ukuran');  
        $this->db->group_by('barang_masuk.id_warna');  
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
