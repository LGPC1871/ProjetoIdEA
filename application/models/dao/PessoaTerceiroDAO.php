<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaTerceiroDAO extends DAO{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/PessoaTerceiroModel.php');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Funções do acesso de dados da classe
    */
        /**
         * Método insere novo registro em @pessoa_terceiro
         * retorna false se o insert falhar
         * @param array $input
         * @return boolean
         */
        public function addPessoaTerceiro($input = array()){
            //verificar se o input bate com os requisitos
            $requiredInput = array(
                'pessoaTerceiroModel',
            );
            if(!$this->_required($requiredInput, $input, 1)) return false;

            $pessoaTerceiro = $input['pessoaTerceiroModel'];

            //verificar se o objeto contem os atributos requisitados
            $requiredPessoaTerceiro = array(
                'terceiro_id',
                'pessoa_id',
                'id_pessoa_terceiro'
            );
            $pessoaTerceiroAttr = $pessoaTerceiro->_verifyObjectAttr($pessoaTerceiro);
            if(!$this->_required($requiredPessoaTerceiro, $pessoaTerceiroAttr, 2)) return false;
            
            //executar insert em @pesoa_terceiro
            $atributos = array(
                'terceiro_id' => $pessoaTerceiro->getTerceiroId(),
                'pessoa_id' => $pessoaTerceiro->getPessoaId(),
                'id_pessoa_terceiro' => $pessoaTerceiro->getPessoaTerceiroId()
            );
            $options = array(
                'table' => 'pessoa_terceiro',
                'values' => $atributos,
                'return' => 'boolean'
            );
            $result = $this->create($options);
            return $result;
        }

        /**
         * Método remove registro da tabela @pessoa_terceiro
         * @param array $input
         * @return boolean
         */
        public function removePessoaTerceiro($input = array()){
            $required = array(
                'where'
            );
            if(!$this->_required($required, $input, 1)) return false;
            
            $input['table'] = 'pessoa_terceiro';

            $result = $this->delete($input);

            return $result;
        }

        /**
         * Método get retorna um registro
         * @param array $options
         * @return PessoaTerceiroModel
         */
        public function getPessoaTerceiro($options = array()){
            $required = array(
                'where'
            );
            if(!$this->_required($required, $options, 1)) return false;
            
            $options['from'] = 'pessoa_terceiro';

            $result = $this->read($options);

            if(!$result)return false;

            $pessoaTerceiro = new PessoaTerceiroModel();
            if(isset($result->terceiro_id)) $pessoaTerceiro->setTerceiroId($result->terceiro_id);
            if(isset($result->pessoa_id)) $pessoaTerceiro->setPessoaId($result->pessoa_id);
            if(isset($result->id_pessoa_terceiro)) $pessoaTerceiro->setPessoaTerceiroId($result->id_pessoa_terceiro);
            return $pessoaTerceiro;
        }

        /**
         * Método update atualiza registro em @pessoa_terceiro
         * retorna false se a operacao falhar
         * @param array $input
         * @return bool
         */
        public function updatePessoaTerceiro($input = array()){
            $required = array(
                'pessoaTerceiroModel',
            );
            if(!$this->_required($required, $input, 1)) return false;

            $pessoaTerceiro = $input['pessoaTerceiroModel'];

            //preparar options para o insert
            $atributos = array(
                'id_pessoa_terceiro' => $pessoaTerceiro->getPessoaTerceiroId(),
            );

            $options = array(
                'where' => array(
                    'terceiro_id' => $pessoaTerceiro->getTerceiroId(),
                    'pessoa_id' => $pessoaTerceiro->getPessoaId()
                ),
                'table' => 'pessoa_terceiro',
                'values' => $atributos
            );

            $result = $this->update($options);

            return $result;
        }
}