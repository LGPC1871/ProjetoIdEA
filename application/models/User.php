<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class User extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->table= 'a_users';
    }

    function getRows($params = array()){
        $this->db->select('*'); 
        $this->db->from($this->table);

        if(array_key_exists("conditions", $params)){ 
            foreach($params['conditions'] as $chave => $valor){ 
                $this->db->where($chave, $valor);
            } 
        }
        if(array_key_exists("id", $params) || $params['returnType'] == 'single'){
            if(!empty($params['id'])){ 
                $this->db->where('A_id', $params['id']); 
            } 
            $query = $this->db->get(); 
            $result = $query->row_array(); 
            return $result;
        }
    }
}