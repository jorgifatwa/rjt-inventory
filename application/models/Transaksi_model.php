<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Transaksi_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("transaksi.*")->from("transaksi"); 
        $this->db->where($where);  
        $this->db->where("transaksi.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function cekKodetransaksi()
    {
        $query = $this->db->query("SELECT MAX(kode_transaksi) as kodetransaksi from transaksi WHERE is_deleted = '0'");
        $hasil = $query->row();
        return $hasil->kodetransaksi;
    }
 

    public function getTotal($where = array()){
        $this->db->select("count(transaksi.id) as total")->from("transaksi");  
        $this->db->where($where);  
        $this->db->where("transaksi.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("transaksi.*")->from("transaksi");  
        $this->db->where($where);  
        $this->db->where("transaksi.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getDetailTransaksi($where = array()){
        $this->db->select("transaksi.*, barang_keluar.*, barang.*, barang.nama as barang_name")->from("transaksi"); 
        $this->db->join("barang_keluar", "barang_keluar.id_transaksi = transaksi.id");
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where($where);  
        $this->db->where("transaksi.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("transaksi", $data);
        return $this->db->insert_id();
    }

    public function insert_retur($data){
        $this->db->insert("retur", $data);
        return $this->db->insert_id();
    }


    public function update($data,$where){
        $this->db->update("transaksi", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("transaksi"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("transaksi.*")->from("transaksi");
        $this->db->where("transaksi.is_deleted",0);  
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
        $this->db->select("transaksi.*")->from("transaksi");
        $this->db->where("transaksi.is_deleted",0);  
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
