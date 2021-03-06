<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PrivilegioDAO extends DAO{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/PrivilegioModel.php');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Funções do acesso de dados da classe
    */
        /**
         * método getPrivilegio
         * retorna um objeto privilegio
         * @param array $options
         * @return PrivilegioModel
         */
            public function getPrivilegio($options = array()){
                $required = array(
                    'like'
                );
                if(!$this->_required($required, $options, 1)) return false;
                
                $default = array(
                    'from' => 'privilegio'
                );
                $options = $this->_default($default, $options);
                
                $result = $this->read($options);

                if(!$result)return false;

                $privilegio = new PrivilegioModel;
                if(isset($result->id)) $privilegio->setId($result->id);
                if(isset($result->nome)) $privilegio->setNome($result->nome);

                return $privilegio;
            }

}