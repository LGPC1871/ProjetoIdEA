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
            if(!$this->_required($requiredInput, $input)) return false;

            $pessoaTerceiro = $input['pessoaTerceiroModel'];

            //verificar se o objeto contem os atributos requisitados
            $requiredPessoaTerceiroAttr = array(
                'terceiro_id',
                'pessoa_id',
                'id_pessoa_terceiro'
            );
            $pessoaTerceiroAttr = $this->PessoaTerceiroModel->_verifyObjectAttr($pessoaTerceiro);
            if(!$this->_required($requiredPessoaTerceiroAttr, $pessoaTerceiroAttr)) return false;

            //executar insert em @pesoa_terceiro
            $result = $this->create($pessoaTerceiro);

            return $result;
        }
    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    | Funções CRUD da classe
    */
    /**
         * método create insere um novo registro em @pessoa_terceiro
         * @param object $pessoaTerceiroModel
         * @return bool
         */
        private function create($pessoaTerceiroModel){
            $this->db->set("terceiro_id", $pessoaTerceiroModel->getTerceiroId());
            $this->db->set("pessoa_id", $pessoaTerceiroModel->getPessoaId());
            $this->db->set("id_pessoa_terceiro", $pessoaTerceiroModel->getPessoaTerceiroId());
    
            return $this->db->insert('pessoa_terceiro') ? true : false;
        }
}