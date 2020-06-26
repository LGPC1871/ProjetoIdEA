<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaDAO extends DAO{
    public function __construct(){
        parent::__construct();
        $this->load->library('model/PessoaModel', 'pessoaModel');
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
            if(!$this->_required($requiredInput, $input, 1)) return false;

            $pessoa = $input['pessoaModel'];

            //verificar se o objeto bate com os requisitos
            $requiredPessoa = array(
                "email",
                "nome",
            );
            $pessoaAttr = $pessoa->_verifyObjectAttr();
            if(!$this->_required($requiredPessoa, $pessoaAttr, 2)) return false;
            
            //preparar options para o insert
            $time = date("Y-m-d H:i:s");
            $atributos = array(
                'email' => $pessoa->getEmail(),
                'nome_completo' => $pessoa->getNomeCompleto(),
                'nome' => $pessoa->getNome(),
                'sobrenome' => $pessoa->getSobrenome(),
                'created' => $time,
                'updated' => $time
            );

            $options = array(
                'table' => 'pessoa',
                'values' => $atributos
            );
            
            $newUserId = $this->create($options);
            if(!$newUserId) return false;

            return $newUserId;
        }

        /**
         * Método getUser
         * retorna um objeto de um único usuário
         * retorna false se a operacao falhar
         * retorna false se o usuário não existe
         * @param array $options
         * @return PessoaModel
         * @return false
         */
        public function getUser($options = array()){
            $required = array(
                'where'
            );
            if(!$this->_required($required, $options, 1)) return false;
            
            $options['from'] = 'pessoa';

            $result = $this->read($options);

            if(!$result)return false;

            $pessoa = new PessoaModel();
            if(isset($result->id)) $pessoa->setId($result->id);
            if(isset($result->email)) $pessoa->setEmail($result->email);
            if(isset($result->nome_completo)) $pessoa->setNomeCompleto($result->nome_completo);
            if(isset($result->nome)) $pessoa->setNome($result->nome);
            if(isset($result->sobrenome)) $pessoa->setSobrenome($result->sobrenome);
            
            return $pessoa;
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
            $required = array(
                'where'
            );
            if(!$this->_required($required, $input, 1)) return false;
            
            $input['table'] = 'pessoa';

            $result = $this->delete($input);

            return $result;
        }

        /**
         * Método updateUser
         * atualiza registro de um usuário
         * retorna false se a operacao falhar
         * realiza update em
         * nome sobrenome nome_completo updated
         * @param array $input
         * @return boolean
         */
        public function updateUser($input = array()){
            $required = array(
                'pessoaModel',
            );
            if(!$this->_required($required, $input, 1)) return false;

            $pessoa = $input['pessoaModel'];

            //preparar options para o insert
            $time = date("Y-m-d H:i:s");
            $atributos = array(
                'nome_completo' => $pessoa->getNomeCompleto(),
                'nome' => $pessoa->getNome(),
                'sobrenome' => $pessoa->getSobrenome(),
                'updated' => $time
            );

            $options = array(
                'where' => array('email' => $pessoa->getEmail()),
                'table' => 'pessoa',
                'values' => $atributos
            );

            $result = $this->update($options);

            return $result;
        }

}