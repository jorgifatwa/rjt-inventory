<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stock_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("stock.*")->from("stock"); 
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    
    public function getAllById($where = array()){
        $this->db->select("stock.id_barang, barang.nama as barang_name ")->from("stock");  
        $this->db->join("barang", "barang.id = stock.id_barang");
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  
        $this->db->group_by('stock.id_barang');  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getAllByIdNoGroupBy($where = array()){
        $this->db->select("stock.*, barang.*")->from("stock");
        $this->db->join("barang", "barang.id = stock.id_barang");
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getById($where = array()){
        $this->db->select("stock.*, barang.nama as barang_name ")->from("stock");  
        $this->db->join("barang", "barang.id = stock.id_barang");
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getStock($where = array()){
        $this->db->select("stock.*, warna.nama as warna_name")->from("stock");
        $this->db->join("warna", "warna.id = stock.id_warna");
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getWarna($where = array()){
        $this->db->select("stock.id_warna, warna.nama as warna_name ")->from("stock");  
        $this->db->join("warna", "warna.id = stock.id_warna");
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  
        $this->db->group_by('stock.id_warna');

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getUkuran($where = array()){
        $this->db->select("stock.ukuran")->from("stock");  
        $this->db->where($where);  
        $this->db->where("stock.is_deleted",0);  
        $this->db->group_by('stock.ukuran');

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("stock", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("stock", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("stock"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("stock.*, barang.nama as barang_name, warna.nama as warna_name")->from("stock");   
        $this->db->join("warna", "warna.id = stock.id_warna");
        $this->db->join("barang", "barang.id = stock.id_barang");
        $this->db->where("stock.is_deleted",0);  
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

    function getCountAllBy($limit,$start,$search,$order,$dir)
    { 
        $this->db->select("stock.*, barang.nama as barang_name, warna.nama as warna_name")->from("stock");   
        $this->db->join("warna", "warna.id = stock.id_warna");
        $this->db->join("barang", "barang.id = stock.id_barang");
        $this->db->where("stock.is_deleted",0);  
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
