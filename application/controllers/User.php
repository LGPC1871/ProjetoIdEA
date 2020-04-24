<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('google');
        $this->config->load('google');
    }
   
    public function index(){
        if($this->session->userdata('loggedIn') == true){
            redirect('user/profile');
        }else{
            redirect('user/login');
        }
    }

    public function login(){
        $content = array(
            "headScripts" => array("https://apis.google.com/js/platform.js"),
            "scripts" => array("loginGoogle.js", "util.js"),
        );
        $this->template->show('login.php', $content);
    }

    public function gLogin(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }
        
        //Google Client Instance
            $client = new Google_Client();

            $config = $this->config->item('google');

            $client->setAccessType("offline");

            $client->setClientId($config['client_id']);

            $client->setClientSecret($config['client_secret']);

            $client->setRedirectUri($config['redirect_uri']);

            foreach($config['scopes'] as $scope){
                $client->addScope($scope);
            }
        
            $payload = $client->verifyIdToken($_POST['userToken']);

            if($payload){
                
                $userData = array(
                    //payload userdata
                );
            }else{
                //Token Inválido
            }

        echo json_encode($payload);
    }
}