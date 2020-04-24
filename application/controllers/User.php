<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('google');
        $this->config->load('google');
    }
    
    private function echoUserData($userData){
        echo json_encode($userData);
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

    public function googleAjaxLogin(){
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
            
        $userToken = $_POST['userToken'];

        $result = $this->verifyGoogleUserData($client, $userToken);
        
        if(!isset($result['Erro'])){
            
        }else{
            $this->echoUserData($result);
        }
    }

    private function verifyGoogleUserData($client, $userToken){
        $erros = array();

        $payload = $client->verifyIdToken($userToken);

        if($payload){
            if($payload['email_verified']){
                if($payload['name'] != ""){
                    $userData = array(
                        "user_id" => $payload['sub'],
                        "user_email" => $payload['email'],
                        "user_fullName" => $payload['name'],
                        "user_firstName" => $payload['given_name'],
                        "user_lastName" => $payload['family_name'],
                        "user_picture" => $payload['picture']
                    );
                    return $userData;
                }else{
                    $erros['Erro'] = "Erro: nome invalido!";
                }
            }else{
                $erros['Erro'] = "Falha na verificao do Email!";
            }
        }else{
            $erros['Erro'] = "Token Invalido!";
        }
        return $erros;
    }
}