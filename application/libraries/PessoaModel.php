<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class PessoaModel{
    
    private $id;
    private $email;
    private $nomeCompleto;
    private $nome;
    private $sobrenome;
    private $created;
    private $updated;
    private $idPrivilegio;

    public function __construct(){
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
        public function getIdPrivilegio()
        {
            return $this->idPrivilegio;
        }
        public function setIdPrivilegio($idPrivilegio)
        {
            $this->idPrivilegio = $idPrivilegio;

            return $this;
        }
}