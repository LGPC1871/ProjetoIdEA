<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaTerceiroModel{
    private $terceiroId;
    private $pessoaId;
    private $pessoaTerceiroId;

    public function __construct(){
    }

    /*
    |--------------------------------------------------------------------------
    | Getter`s & Setter`s
    |--------------------------------------------------------------------------
    | Todas as funções get e set dos atributos
    */
        /**
         * Get the value of pessoaTerceiroId
         */ 
        public function getPessoaTerceiroId()
        {
            return $this->pessoaTerceiroId;
        }

        /**
         * Set the value of pessoaTerceiroId
         *
         * @return  self
         */ 
        public function setPessoaTerceiroId($pessoaTerceiroId)
        {
            $this->pessoaTerceiroId = $pessoaTerceiroId;

            return $this;
        }

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
         * Get the value of terceiroId
         */ 
        public function getTerceiroId()
        {
            return $this->terceiroId;
        }

        /**
         * Set the value of terceiroId
         *
         * @return  self
         */ 
        public function setTerceiroId($terceiroId)
        {
            $this->terceiroId = $terceiroId;

            return $this;
        }
}