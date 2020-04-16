<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
    function __construct() { 
        // Set table name 
        $this->table = 'AA_pessoa'; 
    }

    public function insert($data = array()){
        if(!empty($data)){
            $result = $this->db->insert($this->table, $data);
            return $result?$this->db->insert_id():false;
        }
        return false;
    }
}