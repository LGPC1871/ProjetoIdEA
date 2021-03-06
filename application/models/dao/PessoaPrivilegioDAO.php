<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaPrivilegioDAO extends DAO{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/PessoaPrivilegioModel.php');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Funções do acesso de dados da classe
    */
        public function addPrivilege($input = array()){
            //verificar se input bate com requisitos
            $requiredInput = array(
                'pessoaPrivilegioModel',
            );
            if(!$this->_required($requiredInput, $input, 1)) return false;
            $pessoaPrivilegio = $input['pessoaPrivilegioModel'];
            
            //verificar se o objeto contem os atributos requisitados
            $requiredPessoaPrivilegio = array(
                'pessoa_id',
                'privilegio_id',
            );
            $pessoaPrivilegioAttr = $pessoaPrivilegio->_verifyObjectAttr($pessoaPrivilegio);
            if(!$this->_required($requiredPessoaPrivilegio, $pessoaPrivilegioAttr, 2)) return false;

            //preparar options para o insert
            $atributos = array(
                'pessoa_id' => $pessoaPrivilegio->getPessoaId(),
                'privilegio_id' => $pessoaPrivilegio->getPrivilegioId()
            );
            $options = array(
                'table' => 'pessoa_privilegio',
                'values' => $atributos,
                'return' => 'boolean'
            );

            return $this->create($options);
        }

        /**
         * Essa função vai retornar um array
         * com o nome de todos os privilegios
         * que o usuário inserido possui
         * @param int $pessoaId
         * @return array $privilegios
         */
        public function getPessoaPrivilegios($pessoaId){
            if(!$pessoaId) return false;
            $options = array(
                'select' => array('privilegio.nome'),
                'from' => 'pessoa_privilegio',
                'join' => array(array(
                    'table' => 'privilegio',
                    'join' => 'inner',
                    'on' => 'privilegio_id = id'
                    )
                ),
                'where' => array(
                    'pessoa_id' => $pessoaId
                ),
                'return' => 'multiple'
            );

            return $this->read($options);
        }
}