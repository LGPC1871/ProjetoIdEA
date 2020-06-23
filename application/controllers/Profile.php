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
        if($this->session->userdata("logged") == true){
            $this->loadProfile();
        }else{
            redirect('user/login');
        }

    }

    private function loadProfile(){
        $userData = $this->userDAO->selectUserData("id",$this->session->userdata("userId"));
        $userPrivilege = $this->userDAO->selectUserPrivilege($userData->getIdPrivilegio());
        if(!$userData || !$userPrivilege){
            exit("Erro, contate o administrador do sistema.");
        }
        
        $content = array(
            "styles" => array("profile.css"),
            "pessoa" => $userData,
            "privilegio" => $userPrivilege
        );
        $this->template->show("profile.php", $content);
    }
}