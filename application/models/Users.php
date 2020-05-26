<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Model{
    
    private $pessoa = 'AA_pessoa';
        private $pessoa_id = 'AA_id';
        private $pessoa_email = 'AA_email';
        private $pessoa_nomecompleto = 'AA_nomecompleto';
        private $pessoa_nome = 'AA_nome';
        private $pessoa_sobrenome = 'AA_sobrenome';
        private $pessoa_picture = 'AA_picture';
        private $pessoa_created = 'AA_created';
        private $pessoa_updated = 'AA_updated';

    private $pessoaTerceiro = 'AB_pessoaTerceiro';
        private $pessoaTerceiro_pessoaTerceiroId = 'AB_pessoaTerceiroId';

    private $terceiro = 'AC_terceiro';
        private $terceiro_id = 'AC_id';
        private $terceiro_nome = 'AC_nome';

    private $privilegios = 'AD_privilegio';
        private $privilegios_id = 'AD_id';
        private $privilegios_nome = 'AD_nome';
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
                "picture" => $data[$this->pessoa_picture],
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
/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
| Todas as funções update
*/
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

    public function searchThirdId($thirdName){
        $this->db->select($this->terceiro_id);
        $this->db->from($this->terceiro);
        $this->db->like($this->terceiro_nome, $thirdName);

        $result = $this->db->get();

        if($result->num_rows() == 1){
            return $result->row($this->terceiro_id);
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
/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
| Todas as funções DELETE
*/
}