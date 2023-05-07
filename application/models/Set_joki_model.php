<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Set_joki_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("order.*")->from("order"); 
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getTotal($where = array()){
        $this->db->select("count(order.id) as total")->from("order");  
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("order.*")->from("order");  

        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("order", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("order", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("order"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("order.*,pelayanan.name as pelayanan_name, paket.name as paket_name, paket.harga as paket_harga")->from("order");   
        $this->db->join("paket", "paket.id = order.id_paket");
        $this->db->join("pelayanan", "pelayanan.id = paket.id_pelayanan");
        $this->db->where("order.is_deleted",0);  
        $this->db->where("order.status_orderan",1);  
        $this->db->where("order.id_joki",null);  
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
        $this->db->select("order.*, pelayanan.name as pelayanan_name, paket.name as paket_name, paket.harga as paket_harga")->from("order");   
        $this->db->join("paket", "paket.id = order.id_paket");
        $this->db->join("pelayanan", "pelayanan.id = paket.id_pelayanan");
        $this->db->where("order.is_deleted",0);  
        $this->db->where("order.id_joki",null);  
        $this->db->where("order.status_orderan",1);  
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
