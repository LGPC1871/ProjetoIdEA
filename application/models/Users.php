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
}