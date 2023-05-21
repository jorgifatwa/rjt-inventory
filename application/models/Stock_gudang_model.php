<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stock_gudang_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("stock_gudang.*")->from("stock_gudang"); 
        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    
    public function getAllById($where = array()){
        $this->db->select("stock_gudang.*, warna.nama as warna_name, barang.*")->from("stock_gudang");  
        $this->db->join("barang", "barang.id = stock_gudang.id_barang");
        $this->db->join("warna", "warna.id = stock_gudang.id_warna");

        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function getAllByWarna($where = array()){
        $this->db->select("stock_gudang.id_warna, warna.nama as warna_name")->from("stock_gudang");  
        $this->db->join("warna", "warna.id = stock_gudang.id_warna");

        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  
        $this->db->group_by("stock_gudang.id_warna");  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function getAllByUkuran($where = array()){
        $this->db->select("stock_gudang.ukuran")->from("stock_gudang");  

        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  
        $this->db->group_by("stock_gudang.ukuran");  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("stock_gudang", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("stock_gudang", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("stock_gudang"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = array())
    {
        $this->db->select("stock_gudang.*, barang.nama as barang_name, warna.nama as warna_name")->from("stock_gudang");   
        $this->db->join("barang", "barang.id = stock_gudang.id_barang");
        $this->db->join("warna", "warna.id = stock_gudang.id_warna");
        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  
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
        $this->db->select("stock_gudang.*, barang.nama as barang_name, warna.nama as warna_name")->from("stock_gudang");   
        $this->db->join("barang", "barang.id = stock_gudang.id_barang");
        $this->db->join("warna", "warna.id = stock_gudang.id_warna");
        $this->db->where($where);  
        $this->db->where("stock_gudang.is_deleted",0);  
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
