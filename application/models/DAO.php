<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class DAO extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    | Todas as funções de herança da classe
    */
        /**
         * método _require retorna falso se o array $inputData NÃO conter algum
         * dos parâmetros contidos no array $required
         * @param array $required
         * @param array $inputData
         * @return bool
         */
        protected function _required($required, $inputData){
            foreach($required as $field) if(!isset($inputData[$field])) return false;
            return true;
        }

        /**
         * método _default mescla o array $options com o array $default
         * A ideia é passar valores padrão para a função.
         * @param array $defaults
         * @param array $options
         * @return array
         */
        protected function _default($defaults, $options){
            return array_merge($defaults, $options);
        }
}