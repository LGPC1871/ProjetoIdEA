<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{
    public function __construct(){
        parent::__construct();

        //REQUIRES\\
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
        require_once(APPPATH . 'libraries/model/PessoaTerceiroModel.php');
        require_once(APPPATH . 'libraries/model/PrivilegioModel.php');
        $this->load->model('UserDAO', 'userDAO');

    }
    public function index(){
        if($this->session->userdata("logged")){
            $this->loadProfile();
        }else{
            redirect('user/login');
        }

    }

    private function loadProfile(){
        $userData = $this->userDAO->selectUserData("id",$this->session->userdata("userId"));
        $userPrivilege = $this->userDAO->selectPrivilege("id", $userData->getIdPrivilegio());
        if(!$userData || !$userPrivilege){
            exit("Erro, contate o administrador do sistema.");
        }
        
        $content = array(
            "styles" => array("profile.css"),
            "scripts" => array("restrict.js"),
            "pessoa" => $userData,
            "privilegio" => $userPrivilege
        );
        $this->template->show("profile.php", $content);
    }

    /*
    |--------------------------------------------------------------------------
    | Ajax
    |--------------------------------------------------------------------------
    | Todas as funções de requisições ajax
    */

    public function ajaxRequestTabContent(){
        if (!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }
        if(!$this->session->userdata("logged")){
            exit("Acesso negado!");
        }

        $nomePrivilegio = $this->input->post("id");
        $result = $this->checkRequest($nomePrivilegio);

        echo json_encode($result);
    }

    private function checkRequest($inputInfo){
        $privilegio = $this->userDAO->selectPrivilege("nome", $inputInfo);
        $userData = $this->userDAO->selectUserData("id", $this->session->userdata("userId"));

        if(!($userData->getIdPrivilegio() <= $privilegio->getId())){
            return false;
        }
        
        return $this->load->view("restrict/");
    }
}