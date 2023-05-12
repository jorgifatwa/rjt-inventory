<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Barang_keluar_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("barang_keluar.*")->from("barang_keluar"); 
        $this->db->where($where);  
        $this->db->where("barang_keluar.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function cekKodebarang_keluar()
    {
        $query = $this->db->query("SELECT MAX(kode_barang_keluar) as kodebarang_keluar from barang_keluar");
        $hasil = $query->row();
        return $hasil->kodebarang_keluar;
    }
 

    public function getTotal($where = array()){
        $this->db->select("count(barang_keluar.id) as total")->from("barang_keluar");  
        $this->db->where($where);  
        $this->db->where("barang_keluar.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("barang_keluar.*, barang_keluar.id as barang_keluar_id, barang.nama as barang_name, transaksi.*, barang.harga_jual_biasa as harga_jual_biasa, warna.nama as warna_name, marketplace.nama as marketplace_name, users.first_name as first_name, users.last_name as last_name")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->join("transaksi", "transaksi.id = barang_keluar.id_transaksi");
        $this->db->join("warna", "warna.id = barang_keluar.id_warna");
        $this->db->join("marketplace", "marketplace.id = barang_keluar.id_marketplace");
        $this->db->join("users", "users.id = barang_keluar.created_by");
        $this->db->where($where);  
        $this->db->where("barang_keluar.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getAllByIdRetur($where = array()){
        $this->db->select("barang_keluar.id_barang as id_barang, barang.nama as barang_name")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where($where);  
        $this->db->where("barang_keluar.is_deleted",0);  
        $this->db->group_by("barang_keluar.id_barang");  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getTotalKotor($where = array()){
        $this->db->select("barang_keluar.*, barang.harga_jual_biasa as harga_jual_biasa")->from("barang_keluar");
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where($where);  
        $this->db->where("barang_keluar.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("barang_keluar", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("barang_keluar", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("barang_keluar"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = array())
    {
        if($this->data['users_groups']->id == 2){
            $this->db->select("barang_keluar.*, barang.nama as barang_name, gudang.nama as gudang_name, warna.nama as warna_name")->from("barang_keluar");  
            $this->db->join("gudang", "gudang.id = barang_keluar.id_gudang");
        }else if($this->data['users_groups']->id == 3){
            $this->db->select("barang_keluar.*, barang.nama as barang_name, marketplace.nama as marketplace_name, warna.nama as warna_name")->from("barang_keluar");  
            $this->db->join("marketplace", "marketplace.id = barang_keluar.id_marketplace");
        }else{
            if($where['id_gudang'] == 1){
                $this->db->select("barang_keluar.*, barang.nama as barang_name, gudang.nama as gudang_name, warna.nama as warna_name")->from("barang_keluar");  
                $this->db->join("gudang", "gudang.id = barang_keluar.id_gudang");
            }else{
                $this->db->select("barang_keluar.*, barang.nama as barang_name, marketplace.nama as marketplace_name, warna.nama as warna_name")->from("barang_keluar");  
                $this->db->join("marketplace", "marketplace.id = barang_keluar.id_marketplace");
            }
        }
        $this->db->join("warna", "warna.id = barang_keluar.id_warna");
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where("barang_keluar.is_deleted",0);  
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
        if($this->data['users_groups']->id == 2){
            $this->db->select("barang_keluar.*, barang.nama as barang_name, gudang.nama as gudang_name, warna.nama as warna_name")->from("barang_keluar");  
            $this->db->join("gudang", "gudang.id = barang_keluar.id_gudang");
        }else if($this->data['users_groups']->id == 3){
            $this->db->select("barang_keluar.*, barang.nama as barang_name, marketplace.nama as marketplace_name, warna.nama as warna_name")->from("barang_keluar");  
            $this->db->join("marketplace", "marketplace.id = barang_keluar.id_marketplace");
        }else{
            if($where['id_gudang'] == 1){
                $this->db->select("barang_keluar.*, barang.nama as barang_name, gudang.nama as gudang_name, warna.nama as warna_name")->from("barang_keluar");  
                $this->db->join("gudang", "gudang.id = barang_keluar.id_gudang");
            }else{
                $this->db->select("barang_keluar.*, barang.nama as barang_name, marketplace.nama as marketplace_name, warna.nama as warna_name")->from("barang_keluar");  
                $this->db->join("marketplace", "marketplace.id = barang_keluar.id_marketplace");
            }
        }
        $this->db->join("warna", "warna.id = barang_keluar.id_warna");
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where("barang_keluar.is_deleted",0);  
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

    function getAllGrafik(){
        $year = date('Y');
        $this->db->select("barang_keluar.*, (barang.harga_jual_biasa * barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('id_gudang', null);
        // $this->db->group_by('MONTH(tanggal)');  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    function getGrafikPendapatanShopee(){
        $year = date('Y');
        $this->db->select("barang_keluar.*, (barang.harga_jual_biasa * barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('id_gudang', null);
        $this->db->where('id_marketplace', 1);
        // $this->db->group_by('MONTH(tanggal)');  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    function getGrafikPendapatanTokopedia(){
        $year = date('Y');
        $this->db->select("barang_keluar.*, (barang.harga_jual_biasa * barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('id_gudang', null);
        $this->db->where('id_marketplace', 2);
        // $this->db->group_by('MONTH(tanggal)');  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    function getGrafikPendapatanTiktok(){
        $year = date('Y');
        $this->db->select("barang_keluar.*, (barang.harga_jual_biasa * barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('id_gudang', null);
        $this->db->where('id_marketplace', 3);
        // $this->db->group_by('MONTH(tanggal)');  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    function getGrafikPendapatanLazada(){
        $year = date('Y');
        $this->db->select("barang_keluar.*, (barang.harga_jual_biasa * barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('id_gudang', null);
        $this->db->where('id_marketplace', 4);
        // $this->db->group_by('MONTH(tanggal)');  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    function getAllByFavorite($limit,$start,$search,$col,$dir, $where = array())
    {
        $month = date('m');
        $this->db->select("barang_keluar.id_barang, barang.nama as barang_name, sum(barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where("barang_keluar.is_deleted",0);  
        $this->db->where("id_gudang",null);  
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->group_by("barang_keluar.id_barang");  
        $this->db->limit($limit,$start)->order_by('total');
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

    function getCountAllByFavorite($limit,$start,$search,$order,$dir, $where = array())
    { 
        $month = date('m');
        $this->db->select("barang_keluar.id_barang, barang.nama as barang_name, sum(barang_keluar.jumlah) as total")->from("barang_keluar");  
        $this->db->join("barang", "barang.id = barang_keluar.id_barang");
        $this->db->where("barang_keluar.is_deleted",0);  
        $this->db->where("id_gudang",null);  
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->group_by("barang_keluar.id_barang");  
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
