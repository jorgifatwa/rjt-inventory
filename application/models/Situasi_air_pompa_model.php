<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Situasi_air_pompa_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  
    
    public function getOneBy($where = array())
    {
        $this->db->select("situasi_air_pompa.*")->from("situasi_air_pompa"); 
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = array())
    {
        $this->db->select("situasi_air_pompa.*, unit.kode")->from("situasi_air_pompa");  
        $this->db->join("unit", "unit.id = situasi_air_pompa.unit_id");
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function insert($data)
    {
        $this->db->insert("situasi_air_pompa", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch("situasi_air_pompa", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where)
    {
        $this->db->update("situasi_air_pompa", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where)
    {
        $this->db->where($where);
        $this->db->delete("situasi_air_pompa"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("situasi_air_pompa.*, location.name as location_name")->from("situasi_air_pompa");   
        $this->db->join("location", "location.id = situasi_air_pompa.location_id");
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
        $this->db->select("situasi_air_pompa.*, location.name as location_name")->from("situasi_air_pompa");  
        $this->db->join("location", "location.id = situasi_air_pompa.location_id");
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

    public function getTotal($where = array())
    {
        $this->db->select("count(situasi_air_pompa.id) as total")->from("situasi_air_pompa");  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
}