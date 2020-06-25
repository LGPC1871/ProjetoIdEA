<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class TerceiroDAO extends DAO{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/TerceiroModel.php');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Funções do acesso de dados da classe
    */
        /**
         * Método getTerceiro
         * executa um select em uma linha em @terceiro
         * retorna false se o select falhar
         * retorna um objeto da linha selecionada
         * @param array $options
         * @return object
         */
        public function getTerceiro($options = array()){
            //executa a consulta
            $default = array(
                'from' => 'terceiro'
            );
            $options = $this->_default($default, $options);
            $result = $this->readSingle($options);
            if(!$result) return false;
            
            $terceiro = new TerceiroModel();
            if(isset($result->id)) $terceiro->setId($result->id);
            if(isset($result->nome)) $terceiro->setNome($result->nome);

            return $terceiro;
        }
}