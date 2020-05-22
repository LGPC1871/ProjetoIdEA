<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Model{
    function __construct(){
        parent::__construct();

        $this->pessoa = 'AA_pessoa';
            $this->pessoa_id = 'AA_id';
            $this->pessoa_email = 'AA_email';
            $this->pessoa_nomecompleto = 'AA_nomeCompleto';
            $this->pessoa_nome = 'AA_nome';
            $this->pessoa_sobrenome = 'AA_sobrenome';
            $this->pessoa_senha = 'AA_senha';
            $this->pessoa_created = 'AA_created';
            $this->pessoa_updated = 'AA_updated';

        $this->pessoaTerceiro = 'AB_pessoaTerceiro';
            $this->pessoaTerceiro_pessoaTerceiroId = 'AB_pessoaTerceiroId';

        $this->terceiro = 'AC_terceiro';
            $this->terceiro_id = 'AC_id';
            $this->terceiro_nome = 'AC_nome';

        $this->privilegios = 'AD_privilegios';
            $this->privilegios_id = 'AD_id';
            $this->privilegios_nome = 'AD_nome';
        
        $this->senhareset = 'AE_senhaReset';
            $this->senhareset_selector = 'AE_selector';
            $this->senhareset_token = 'AE_token';
            $this->senhareset_expires = 'AE_expires';
    }
/*
|--------------------------------------------------------------------------
| SELECT
|--------------------------------------------------------------------------
| Todas as funções select que nao alteram o banco de dados
*/
    function selectUserData($email){
        $this->db->select('*');
        $this->db->from($this->pessoa);
        $this->db->where($this->pessoa_email, $email);
        $result = $this->db->get();
        
        if($result->num_rows() == 1){
            $data = $result->row_array();

            $retorno =array(
                "id" => $data[$this->pessoa_id],
                "email" => $data[$this->pessoa_email],
                "nomecompleto" => $data[$this->pessoa_nomecompleto],
                "nome" => $data[$this->pessoa_nome],
                "sobrenome" => $data[$this->pessoa_sobrenome],
                "senha" => $data[$this->pessoa_senha],
                "idprivilegio" => $data[$this->privilegios_id],
                "created" => $data[$this->pessoa_created],
                "updated" => $data[$this->pessoa_updated],
            );
            return $retorno;
        }
        else{
            return false;
        }
    }

    function verifyUserPrivilege($id){
        $this->db->select('*');
        $this->db->from($this->privilegios);
        $this->db->where($this->privilegios_id, $id);
        $result = $this->db->get();

        if($result->num_rows() == 1){
            $data = $result->row_array();
            $retorno = array(
                "id" => $data[$this->privilegios_id],
                "privilegio" => $data[$this->privilegios_nome],
            );
            return $retorno;
        }else{
            return false;
        }
    }

    function userHasPassword($id){
        $this->db->select($this->pessoa_senha);
        $this->db->from($this->pessoa);
        $this->db->where($this->pessoa_id, $id);

        $result = $this->db->get();
        if($result->num_rows() == 1){
            $data = $result->row_array();
            if(!empty($data[$this->pessoa_senha])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
  
    function selectFromDatabase($select, $from, $where = array(0 => 0)){
        $this->db->select($select);
        $result = $this->db->get_where($from, $where);

        if($result->num_rows() == 1)
            return $result->row();
        else
            return false;
    }

    function userExists($email){
        $this->db->select($this->pessoa_id);
        $this->db->from($this->pessoa);
        $this->db->where($this->pessoa_email, $email);

        $result = $this->db->get();

        if($result->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    function getUserId($email){
        $this->db->select($this->pessoa_id);
        $this->db->from($this->pessoa);
        $this->db->where($this->pessoa_email, $email);

        $result = $this->db->get();

        if($result->num_rows() == 1){
            return $result->row($this->pessoa_id);
        }else{
            return null;
        }
    }

    function selectResetPassword($selector, $currentDate){
        $this->db->select('*');
        $this->db->from($this->senhareset);
        $this->db->where($this->senhareset_selector, $selector);
        //$this->db->where($this->senhareset_expires . '>=', $currentDate);

        $result = $this->db->get();

        if($result->num_rows() == 1){
            $data = $result->row_array();
            $retorno = array(
                "pessoa_id" => $data[$this->pessoa_id],
                "selector" => $data[$this->senhareset_selector],
                "token" => $data[$this->senhareset_token],
                "expires" => $data[$this->senhareset_expires],
            );
            return $retorno;
        }else{
            return false;
        }
    }
/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
| Todas as funções update
*/
    function updateDatabase($table, $dataInput, $where = array()){
        foreach($dataInput as $column=>$value){
            $data = array(
                $column => $value
            );
            $this->db->update($table, $data, $where);
        }
    }

    function updateGoogleUser($data, $userid){
            $time = date("Y-m-d H:i:s");

            $this->db->select($this->pessoa_id);
            $this->db->from($this->pessoaTerceiro);
            $this->db->where($this->pessoa_id, $userid);
            $result = $this->db->get();
            
            
            if($result->num_rows() == 0){
                $thirdData = array(
                    $this->pessoa_id => $userid,
                    $this->terceiro_id => $data['thirdParty']['thirdId'],
                    $this->pessoaTerceiro_pessoaTerceiroId => $data['thirdParty']['id'],
                );

                $this->db->insert($this->pessoaTerceiro, $thirdData);
            }

            $userData = array(
                $this->pessoa_email => $data['userData']['email'],
                $this->pessoa_nomecompleto => $data['userData']['nomecompleto'],
                $this->pessoa_nome => $data['userData']['nome'],
                $this->pessoa_sobrenome => $data['userData']['sobrenome'],
                $this->pessoa_updated => $time,
            );

            $this->db->update($this->pessoa, $userData, array($this->pessoa_id => $userid));
    }

    function updateUserPassword($userId, $passwordHash){
        $time = date("Y-m-d H:i:s");
        
        $updateData = array(
            $this->pessoa_senha => $passwordHash,
            $this->pessoa_updated => $time,
        );

        $this->db->where($this->pessoa_id, $userId);
        $this->db->update($this->pessoa, $updateData);
        $result = $this->db->affected_rows();
        
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }
/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
| Todas as funções INSERT
*/
    function insertIntoDatabase($table, $data = array()){
        $this->db->insert($table, $data);

        $result = $this->db->insert_id();

        if($result){
            return $result;
        }else{
            return false;
        }
    }

    function insertNewUser($data){
        $time = date("Y-m-d H:i:s");

        $userData = array(
            $this->pessoa_email => $data['email'],
            $this->pessoa_nomecompleto => $data['nomecompleto'],
            $this->pessoa_nome => $data['nome'],
            $this->pessoa_sobrenome => $data['sobrenome'],
            $this->pessoa_senha => $data['senha'],
            $this->pessoa_created => $time,
            $this->pessoa_updated => $time,
        );

        $this->db->insert($this->pessoa, $userData);
        $result = $this->db->insert_id();
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function insertGoogleUser($data){
        if(isset($data["thirdParty"]) && isset($data["userData"])){
            $inputUserData = $data["userData"];

            $time = date("Y-m-d H:i:s");

            $inputThirdParty = $data["thirdParty"];

            $userData = array(
                $this->pessoa_email => $inputUserData['email'],
                $this->pessoa_nomecompleto => $inputUserData['nomecompleto'],
                $this->pessoa_nome => $inputUserData['nome'],
                $this->pessoa_sobrenome => $inputUserData['sobrenome'],
                $this->pessoa_created => $time,
                $this->pessoa_updated => $time,
            );

            $this->db->insert($this->pessoa, $userData);
            $userId = $this->db->insert_id();

            $thirdParty = array(
                $this->pessoa_id => $userId,
                $this->terceiro_id => $inputThirdParty['thirdId'],
                $this->pessoaTerceiro_pessoaTerceiroId => $inputThirdParty['id'],
            );

            $this->db->insert($this->pessoaTerceiro, $thirdParty);
        }else{
            return false;
        }
    }

    function setUserPassword($userId, $passwordHash){
        $this->db->select($this->pessoa_senha);
        $this->db->from($this->pessoa);
        $this->db->where($this->pessoa_senha, NULL);
        $result = $this->db->get();

        if($result->row($this->pessoa_senha) == null){

            $this->db->set($this->pessoa_senha, $passwordHash);
            $this->db->where($this->pessoa_id, $userId);
            $this->db->update($this->pessoa);

            return true;

        }else{

            return false;
            
        }
    }

    function insertResetPassword($inputArray){
        $data = array(
            $this->pessoa_id => $inputArray['id'],
            $this->senhareset_selector => $inputArray['selector'],
            $this->senhareset_token => $inputArray['token'],
            $this->senhareset_expires => $inputArray['expires'],
        );
        
        $this->db->insert($this->senhareset, $data);
        $result = $this->db->affected_rows();
        if($result){
            return true;
        }else{
            return false;
        }
    }
/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
| Todas as funções DELETE
*/
        function deletePasswordToken($userId){
            $this->db->where($this->pessoa_id, $userId);
            $this->db->delete($this->senhareset);
        }
}