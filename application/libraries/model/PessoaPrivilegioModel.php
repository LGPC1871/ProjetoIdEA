<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaPrivilegioModel{
    private $pessoaId;
    private $privilegioId;
    private $privilegioNome;
    
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
}