<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaDAO extends DAO{
    public function __construct(){
        parent::__construct();
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES
    |--------------------------------------------------------------------------
    | Funções do acesso de dados da classe
    */
        /**
         * Método addUser
         * insere um novo registro na tabela @pessoa
         * retorna false se o insert falhar
         * @param array $input
         * @return int
         * @return false
         */
            public function addUser($input = array()){
                //verificar se input bate com requisitos
                $requiredInput = array(
                    'pessoaModel',
                );
                if(!$this->_required($requiredInput, $input)) return false;

                $pessoa = $input['pessoaModel'];

                //verificar se o objeto bate com os requisitos
                $requiredPessoa = array(
                    'email',
                    'nome',
                );
                $pessoaAttr = $this->PessoaModel->_verifyObjectAttr($pessoa);
                if(!$this->_required($requiredPessoa, $pessoaAttr)) return false;
                
                $newUserId = $this->insertPessoa($pessoa);
                if(!$newUserId) return false;

                return $newUserId;
            }
        /**
         * Método removeUser
         * remove um registro da tabela @pessoa
         * retorna false se o delete falhar
         * @param array $input
         * @return boolean
         * @return false
         */
            public function removeUser($input = array()){
                $requiredInput = array(
                    'userId'
                );
                if(!$this->_required($requiredInput, $input)) return false;

                $userId = $input['userId'];

                $result = $this->delete($userId);

                return $result;
            }

    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    | Funções CRUD da classe
    */
        /**
         * método create insere um novo registro em @pessoa
         * retorna falso se a operação não for concluída com êxito
         * @param object $pessoaModel
         * @return bool
         */
        private function create($pessoaModel){
            $time = date("Y-m-d H:i:s");
    
            $this->db->set("email", $pessoaModel->getEmail());
            $this->db->set("nome_completo", $pessoaModel->getnomeCompleto());
            $this->db->set("nome", $pessoaModel->getNome());
            $this->db->set("sobrenome", $pessoaModel->getSobrenome());
            $this->db->set("created", $time);
            $this->db->set("updated", $time);
    
            return $this->db->insert('pessoa') ? $this->db->insert_id() : false;
        }

        /**
         * método read
         */
        private function read(){}

        /**
         * método update
         */
        private function update(){}

        /**
         * método delete deleta registro em @pessoa,
         * obs: pode deletar em CASCATA em todas as tabelas que possuem
         * relacionamento com @pessoa, usar com EXTREMA CAUTELA
         * @param int $userId
         * @return bool
         */
        private function delete($userId){
            $this->db->where('id', $userId);
            return $this->db->delete('pessoa');
        }
}