<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->pessoa = 'AA_pessoa';
    }

    public function userExists($userId){
        $this->db->select('AA_googleId')
                 ->from($this->pessoa)
                 ->where('AA_googleId', $userId);
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    function updateUserData($userData){
        $this->db->where('AA_googleId', $userData['AA_googleId']);
        $this->db->update('AA_pessoa', $userData);
    }

    function insertUserData($userData){
        $this->db->insert('AA_pessoa', $userData);
    }
}