<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('google');
        $this->config->load('google');
        $this->load->model('users');
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

    public function profile(){
        $this->template->show('profile.php');
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

        $data = $this->verifyGoogleUserData($client, $userToken);
        
        if(!isset($data['Erro'])){
            $userExist = $this->users->userExists($data['AA_googleId']);

            if($userExist){
                $data['AA_updated'] = date("Y-m-d H:i:s");
                $this->users->updateUserData($data);
            }else{
                $data['AA_created'] = date("Y-m-d H:i:s");
                $data['AA_updated'] = date("Y-m-d H:i:s");
                $this->users->insertUserData($data);
            }
            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('userData', $data);
            $this->echoUserData("Entrando...");
        }else{
            //CASO OCORRA ALGUM ERRO
            $this->echoUserData($data);
        }
    }

    private function verifyGoogleUserData($client, $userToken){
        $erros = array();

        $payload = $client->verifyIdToken($userToken);

        if($payload){
            if($payload['email_verified']){
                if($payload['name'] != ""){
                    $userData = array(
                        'AA_googleId' => $payload['sub'],
                        'AA_email' => $payload['email'],
                        'AA_fullName' => $payload['name'],
                        'AA_firstName' => $payload['given_name'],
                        'AA_lastName' => $payload['family_name'],
                        'AA_picture' => $payload['picture'],
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

    public function userLogout(){
        $this->session->set_userdata('loggedIn', false);
        $this->session->unset_userdata('userData');

        $this->session->sess_destroy();

        redirect('user');
    }
}