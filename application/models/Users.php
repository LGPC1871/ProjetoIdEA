<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->pessoa = 'AA_pessoa';
        $this->pessoaTerceiro = 'AB_pessoaTerceiro';
        $this->terceiro = 'AC_terceiro';
    }
/*
|--------------------------------------------------------------------------
| SELECT
|--------------------------------------------------------------------------
| Todas as funções select que nao alteram o banco de dados
*/
    function selectFromDatabase($select, $from, $where = array(0 => 0)){
        $this->db->select($select);
        $result = $this->db->get_where($from, $where);

        if($result->num_rows() == 1)
            return $result->row();
        else
            return false;
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
    function updateUserData($dataInput){
        foreach($dataInput as $column=>$value){
            $data = array(
                $column => $value
            );
            $this->db->where($column, null);
            $this->db->where('AA_email', $dataInput['AA_email']);
            $this->db->update($this->pessoa, $data);
        }
    }
/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
| Todas as funções INSERT
*/
    /*function insertNewUser($dataInput){
        $insertData = $dataInput["userData"];

        $this->db->insert($this->pessoa, $insertData);
    }*/

    function insertIntoDatabase($table, $data = array()){
        $this->db->insert($table, $data);

        $result = $this->db->insert_id();

        if($result){
            return $result;
        }else{
            return false;
        }
    }

    function insertThirdPartyData($dataInput){
        if(!isset($dataInput['AA_id'])){
            return false;
        }else{
            $this->db->insert($this->pessoaTerceiro, $dataInput);
        }
    }
}