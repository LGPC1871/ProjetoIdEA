<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class UserDAO extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
| Todas as funções insert
*/
    public function insertNewUser($userData, $userThirdData){
        $result = $this->insertPessoa($userData);

        if($result){
            
            $userThirdData->setPessoaId($result);

            $result2 = $this->insertPessoaTerceiro($userThirdData);

            if(!$result2){
                $this->deleteNewUser($result);
                return false;
            }

            return true;

        }else{

            return false;

        }
    }

    private function insertPessoa($userData){
        $time = date("Y-m-d H:i:s");

        $this->db->set("email", $userData->getEmail());
        $this->db->set("nome_completo", $userData->getnomeCompleto());
        $this->db->set("nome", $userData->getNome());
        $this->db->set("sobrenome", $userData->getSobrenome());
        $this->db->set("created", $time);
        $this->db->set("updated", $time);

        return $this->db->insert('pessoa') ? $this->db->insert_id() : false;
    }

    private function insertPessoaTerceiro($userThirdData){
        $this->db->set("terceiro_id", $userThirdData->getTerceiroId());
        $this->db->set("pessoa_id", $userThirdData->getPessoaId());
        $this->db->set("id_pessoa_terceiro", $userThirdData->getPessoaTerceiroId());

        return $this->db->insert('pessoa_terceiro') ? true : false;
    }
/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
| Todas as funções delete
*/

    function deleteNewUser($id){
        $this->db->where('id', $id);
        $this->db->delete('pessoa');
    }
/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
| Todas as funções update
*/

    public function updateUser($userData, $userThirdData){
        $userId = $this->selectUserId($userData->getEmail());
        $userData->setId($userId);
        $userThirdData->setPessoaId($userId);

        $updatePessoa = $this->updatePessoa($userData);

        if(!$updatePessoa){
            return false;
        }
        $userThirdExist = $this->userThirdExist($userThirdData);

        if($userThirdExist){
            //update userThirdData
            $updatePessoaTerceiro = true;
        }else{
            $updatePessoaTerceiro = $this->insertPessoaTerceiro($userThirdData);
        }

        if(!$updatePessoaTerceiro){
            return false;
        }

        return true;
    }

    private function updatePessoa($userData){
        
        $time = date("Y-m-d H:i:s");

        $this->db->set("email", $userData->getEmail());
        $this->db->set("nome_completo", $userData->getnomeCompleto());
        $this->db->set("nome", $userData->getNome());
        $this->db->set("sobrenome", $userData->getSobrenome());
        $this->db->set("updated", $time);
        $this->db->where('id', $userData->getId());
        
        return $this->db->update('pessoa') ? true : false;
    }
/*
|--------------------------------------------------------------------------
| SELECT
|--------------------------------------------------------------------------
| Todas as funções select
*/
    public function userExist($email){
        $this->db
            ->select('id')
            ->from('pessoa')
            ->where('email', $email);
        $result = $this->db->get();

        return $result->num_rows() > 0;
    }

    public function userThirdExist($userThirdData){
        $this->db
            ->select('id_pessoa_terceiro')
            ->from('pessoa_terceiro')
            ->where('terceiro_id', $userThirdData->getTerceiroId())
            ->where('pessoa_id', $userThirdData->getPessoaId());
        $result = $this->db->get();

        return $result->num_rows() > 0;
    }

    public function selectThirdId($name){
        $this->db
            ->select('id')
            ->from('terceiro')
            ->like('nome', $name);
        $result = $this->db->get();

        return $result->num_rows() > 0 ? $result->row('id') : false;
    }

    public function selectUserId($email){
        $this->db
            ->select('id')
            ->from('pessoa')
            ->where('email', $email);
        $result = $this->db->get();
        
        return $result->num_rows() > 0 ? $result->row('id') : false;
    }
}