<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->pessoa = 'AA_pessoa';
    }
/*
|--------------------------------------------------------------------------
| SELECT
|--------------------------------------------------------------------------
| Todas as funções select que n"ao alteram o banco de dados
*/
    function userExists($userEmail){
        $this->db->select('AA_email')
                 ->from($this->pessoa)
                 ->where('AA_email', $userEmail);
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    function getUserData($userEmail){
        $this->db->select('*')
                 ->from($this->pessoa)
                 ->where('AA_email', $userEmail);
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->row();
        else
            return null;
    }
    
    function getUserEmailPassword($userEmail){
        $this->db->select('AA_email', 'AA_password')
                 ->from($this->pessoa)
                 ->where('AA_email', $userEmail);
        
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->row();
        else
            return null;
    }
/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
| Todas as funções update
*/
    function updateUserData($userData){
        foreach($userData as $column=>$value){
            $data = array(
                $column => $value
            );
            $this->db->where($column, null);
            $this->db->where('AA_Email', $userData['AA_email']);
            $this->db->update($this->pessoa, $data);
        }
    }
/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
| Todas as funções INSERT
*/
    function insertNewUser($userData){
        $this->db->insert($this->pessoa, $userData);
    }
}