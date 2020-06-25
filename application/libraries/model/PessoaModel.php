<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaModel{
    
    private $id;
    private $email;
    private $nomeCompleto;
    private $nome;
    private $sobrenome;
    private $created;
    private $updated;

    public function __construct(){
    }
    /*
    |--------------------------------------------------------------------------
    | PUBLIC
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
            if($this->getId()) $response['id'] = true;
            if($this->getEmail()) $response['email'] = true;
            if($this->getNomeCompleto()) $response['nomeCompleto'] = true;
            if($this->getNome()) $response['nome'] = true;
            if($this->getSobrenome()) $response['sobrenome'] = true;
            if($this->getCreated()) $response['created'] = true;
            if($this->getUpdated()) $response['updated'] = true;
            
            return $response;
        }
    /*
    |--------------------------------------------------------------------------
    | Getter`s & Setter`s
    |--------------------------------------------------------------------------
    | Todas as funções get e set dos atributos
    */
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getEmail()
        {
            return $this->email;
        }
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }
        public function getNomeCompleto()
        {
            return $this->nomeCompleto;
        }
        public function setNomeCompleto($nomeCompleto)
        {
            $this->nomeCompleto = $nomeCompleto;

            return $this;
        }
        public function getNome()
        {
            return $this->nome;
        }
        public function setNome($nome)
        {
            $this->nome = $nome;

            return $this;
        }
        public function getSobrenome()
        {
            return $this->sobrenome;
        }
        public function setSobrenome($sobrenome)
        {
            $this->sobrenome = $sobrenome;

            return $this;
        }
        public function getCreated()
        {
            return $this->created;
        }
        public function setCreated($created)
        {
            $this->created = $created;
        }
        public function getUpdated()
        {
            return $this->updated;
        }
        public function setUpdated($updated)
        {
            $this->updated = $updated;

            return $this;
        }
}