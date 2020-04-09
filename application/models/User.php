<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class User extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->table= 'a_users';
    }

    function getUserData($username){
        $this->db->select('*')
                ->from($this->table)
                ->where('A_userName', $username);
        
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->row();
        else
            return null;
    }
}