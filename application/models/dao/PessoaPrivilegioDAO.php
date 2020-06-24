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

    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    | Funções CRUD da classe
    */
        /**
         * método create insere um novo registro em @pessoa_privilegio
         * @param object $pessoaPrivilegioModel
         * @return bool
         */
        private function create($pessoaPrivilegioModel){
                
            $this->db->set('pessoa_id', $pessoaPrivilegioModel->getPessoaId());
            $this->db->set('privilegio_id', $pessoaPrivilegioModel->getPrivilegioId());

            return $this->db->insert('pessoa_privilegio') ? true : false;
        }
}