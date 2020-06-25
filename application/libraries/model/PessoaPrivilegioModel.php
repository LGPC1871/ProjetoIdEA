<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaPrivilegioModel{
    private $pessoaId;
    private $privilegioId;
    private $privilegioNome;
    /*
    |--------------------------------------------------------------------------
    | PRIVATE STATIC
    |--------------------------------------------------------------------------
    | Todas as funções da classe
    */

        /**
         * Método required, retorna quais atributos do objeto inserido
         * NÃO são nulos
         * @param object $pessoaModel
         * @return array
         */
        public function _verifyObjectAttr(){
            $response = array();

            if($this->getPessoaId()) $response['pessoa_id'] = true;
            if($this->getPrivilegioId()) $response['privilegio_id'] = true;
            if($this->getPrivilegioNome()) $response['nome'] = true;

            return $response;
        }
    /*
    |--------------------------------------------------------------------------
    | Getter`s & Setter`s
    |--------------------------------------------------------------------------
    | Todas as funções get e set dos atributos
    */
        /**
         * Get the value of pessoaId
         */ 
        public function getPessoaId()
        {
            return $this->pessoaId;
        }

        /**
         * Set the value of pessoaId
         *
         * @return  self
         */ 
        public function setPessoaId($pessoaId)
        {
            $this->pessoaId = $pessoaId;

            return $this;
        }

        /**
         * Get the value of privilegioId
         */ 
        public function getPrivilegioId()
        {
            return $this->privilegioId;
        }

        /**
         * Set the value of privilegioId
         *
         * @return  self
         */ 
        public function setPrivilegioId($privilegioId)
        {
            $this->privilegioId = $privilegioId;

            return $this;
        }

        /**
         * Get the value of privilegioNome
         */ 
        public function getPrivilegioNome()
        {
            return $this->privilegioNome;
        }

        /**
         * Set the value of privilegioNome
         *
         * @return  self
         */ 
        public function setPrivilegioNome($privilegioNome)
        {
            $this->privilegioNome = $privilegioNome;

            return $this;
        }
}