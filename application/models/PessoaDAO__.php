<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaDAO extends CI_Model{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
        require_once(APPPATH . 'libraries/model/PessoaTerceiroModel.php');
        require_once(APPPATH . 'libraries/model/PessoaPrivilegioModel.php');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Todas as funções de operação complexa com banco de dados
    */    
        /**
         * método adiciona um novo usuário na aplicação
         * - insert em @pessoa
         * - insert em @pessoa_terceiro
         * - insert em @pessoa_privilegio
         * retorna falso se a operação não for concluída com êxito
         * @param array $inputData
         * @return bool
         */
            public function addUser($inputData = array()){
                //required objects
                $requiredObjects = array(
                    'pessoaModel',
                    'pessoaTerceiroModel'
                );
                if(!$this->_required($requiredObjects, $inputData)) return false;
                
                //instanciar objetos
                $pessoa = $inputData['pessoaModel'];
                $pessoaTerceiro = $inputData['pessoaTerceiroModel'];

                //required pessoaModel Attr
                $requiredPessoaAttr = array(
                    'email',
                    'nome',
                );
                $pessoaAttr = $this->PessoaModel->_verifyObjectAttr($pessoa);
                if(!$this->_required($requiredPessoaAttr, $pessoaAttr)) return false;
                
                //executar insert em @pessoa
                $newUserId = $this->insertPessoa($pessoa);
                if(!$newUserId) return false;
                $pessoa->setId($newUserId);
                $pessoaTerceiro->setPessoaId($pessoa->getId());
                
                //required pessoaTerceiroModel Attr
                $requiredPessoaTerceiroAttr = array(
                    'terceiro_id',
                    'pessoa_id',
                    'id_pessoa_terceiro'
                );
                $pessoaTerceiroAttr = $this->PessoaTerceiroModel->_verifyObjectAttr($pessoaTerceiro);
                if(!$this->_required($requiredPessoaTerceiroAttr, $pessoaTerceiroAttr)) return false;

                //Se qualquer um dos processos seguintes falhar, deve ser executado
                //um deleteUser para apagar os rastros da tentativa.

                //executar insert em @pessoa_terceiro
                $result = $this->insertPessoaTerceiro($pessoaTerceiro);
                if(!$result){
                    $this->deleteUser(array('userId' => $pessoa->getId()));
                    return false;
                }

                //executar insert padrão em @pessoa_privilegio
                $pessoaPrivilegio = new PessoaPrivilegioModel();
                $pessoaPrivilegio->setPessoaId($pessoa->getId());
                $pessoaPrivilegio->setPrivilegioNome('participante');

                $this->insertPessoaPrivilegio($pessoaPrivilegio);
            }

        /**
         * método remove usuário da aplicação
         * remove foreign keys CASCATE
         * pode remover em:
         *  @pessoa, @pessoa_terceiro, @pessoa_privilegio
         * @param array $inputData
         * @return bool
         */
            public function deleteUser($inputData = array()){
                $required = array(
                    'userId'
                );
                if(!$this->_required($required, $inputData)) return false;
                $userId = $inputData['userId'];
                $this->deletePessoa($userId);

                return true;
            }
}