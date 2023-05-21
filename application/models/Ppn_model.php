<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Ppn_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("ppn.*")->from("ppn"); 
        $this->db->where($where);  
        $this->db->where("ppn.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    
    public function getAllById($where = array()){
        $this->db->select("ppn.*, marketplace.nama as marketplace_name")->from("ppn");   
        $this->db->join("marketplace", "marketplace.id = ppn.id_marketplace");  

        $this->db->where($where);  
        $this->db->where("ppn.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function getAllByIdWithMarketplace($where = array()){
        $this->db->select("ppn.*, marketplace.nama as marketplace_name, price_marketplace.harga as harga_marketplace")->from("ppn");   
        $this->db->join("marketplace", "marketplace.id = ppn.id_marketplace");  
        $this->db->join("price_marketplace", "price_marketplace.id_marketplace = ppn.id_marketplace");  
        $this->db->where($where);  
        $this->db->where("ppn.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("ppn", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("ppn", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("ppn"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("ppn.*, marketplace.nama as marketplace_name")->from("ppn");   
        $this->db->join("marketplace", "marketplace.id = ppn.id_marketplace");
        $this->db->where("ppn.is_deleted",0);  
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
        $this->db->select("ppn.*, marketplace.nama as marketplace_name")->from("ppn");   
        $this->db->join("marketplace", "marketplace.id = ppn.id_marketplace");
        $this->db->where("ppn.is_deleted",0);  
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
