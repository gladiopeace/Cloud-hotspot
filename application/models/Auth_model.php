<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {


    public function first($select=array(),$db,$where=array()){

        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }

        //$this->db->where($key,$value);
        foreach ($select as $value) {
            $this->db->select("{$value}");
        }

        $this->db->limit(1);

        $query=$this->db->get($db);

        $bech = $query->result_array();
        if(!empty($bech)) return $bech[0];

    }

    public function save($data=array(),$db,$where=array()){

        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }

        $this->db->update($db, $data);

        return $this->db->affected_rows();

    }

    public function create($table,$data,$type='rows'){

        $this->db->insert($table, $data);


        switch ($type) {
            case 'rows':
                return $this->db->affected_rows();
                break;

            case 'id':
                return $this->db->insert_id();
                break;

            default:
                return $this->db->affected_rows();
                break;
        }

    }

    public function get($select=array(),$db,$where=array(),$keyfield=null,$order=array(),$limit=''){

        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }


        foreach ($select as $value) {
            $this->db->select("{$value}");
        }

        if(!empty($limit)){
            $this->db->limit($limit);
        }

        $query=$this->db->get($db);

        $data = $query->result_array();

        if(empty($keyfield)){
            return $data;
        }else{

            $rs = array();
            foreach ($data as $v) {

                if(isset($v[$keyfield])){
                    $rs[$v[$keyfield]] = $v;
                }else{
                    $res[] = $v;
                }
            }

            return $rs;
        }

    }

    public function set($data=array(),$db,$where=array(),$type=false){


        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        foreach ($data as $key => $value) {
            $this->db->set($key,$value,$type);
        }


        $this->db->update($db);
        return $this->db->affected_rows();
    }

    public function authDevice($verify_type,$reqData){


    }





}

/* End of file Auth_model.php */
/* Location: ./application/models/Portal_model.php */

?>