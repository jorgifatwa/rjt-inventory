<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Retur_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("retur.*")->from("retur"); 
        $this->db->where($where);  
        $this->db->where("retur.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    
    public function getAllById($where = array()){
        $this->db->select("retur.*")->from("retur");  

        $this->db->where($where);  
        $this->db->where("retur.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("retur", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("retur", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("retur"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("retur.*, transaksi.no_resi as no_resi, barang.nama as barang_name, warna.nama as warna_name")->from("retur");   
        $this->db->join("transaksi", "transaksi.id = retur.id_transaksi");
        $this->db->join("barang", "barang.id = retur.id_barang");
        $this->db->join("warna", "warna.id = retur.id_warna");
        $this->db->where("retur.is_deleted",0);  
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
        $this->db->select("retur.*")->from("retur");
        $this->db->where("retur.is_deleted",0);  
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
