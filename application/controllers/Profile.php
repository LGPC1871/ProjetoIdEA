<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{
    public function __construct(){
        parent::__construct();

        //REQUIRES\\
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
        require_once(APPPATH . 'libraries/model/PessoaPrivilegioModel.php');

        //LOADS\\
        $this->load->model('dao/PessoaDAO', 'pessoaDAO');
        $this->load->model('dao/PessoaPrivilegioDAO', 'pessoaPrivilegioDAO');
    }

    public function index(){
        if($this->session->userdata("logged")){
            $content = $this->pageContent();
            if(!$content){
                redirect('login/endSession');
            };
            $this->template->show("profile.php", $content);
        }else{
            redirect('user/login');
        }
    }
    /*
    |--------------------------------------------------------------------------
    | PRIVATE
    |--------------------------------------------------------------------------
    | Todas as funções da classe
    */

        /**
         * Gerador de conteúdo
         * essa função irá gerar um array $content, com
         * todas as chaves de informacoes que
         * podem ser dispostas na página
         * @return array
         */
        public function pageContent(){ 
            if(!$this->session->userdata('logged')) return false;
            $pessoaId = $this->session->userdata('id');
            $content = array(
                'styles' => array('profile.css'),
                'scripts' => array('profile.js'),
                'privilegios' => array(),
                'pessoa' => null,
                'thirdData' => array(),
            );

            //recolhendo privilegios do usuário
            $privilegios = $this->pessoaPrivilegioDAO->getPessoaPrivilegios($pessoaId);
            if($privilegios){
                foreach($privilegios as $privilegio){
                    array_push($content['privilegios'], $privilegio->nome);
                }
            }
            //recolhendo informacao do usuário
            $pessoa = $this->pessoaDAO->getUser(array('where'=>array('id' => $pessoaId)));
            if(!$pessoa) return false;

            $content['pessoa'] = $pessoa;

            //recolhendo informações de terceiros
            if($this->session->userdata('thirdData')){
                $content['thirdData'] = $this->session->userdata('thirdData');
            }
            return $content;
        }
}