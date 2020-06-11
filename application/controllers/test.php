<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('google');
        $this->config->load('google');
        $this->load->model('users');
        $this->load->library('form_validation');

        $this->default_session_data =array(
            "status" => false,
            "user_data" => array(),
            "user_privilege" => array()
        );
        $this->session_data = $this->default_session_data;
    }

    public function index(){ 
        if($this->session->userdata("status") == true){
            redirect('user/profile');
        }else{
            redirect('user/login');
        }
    }
/*
|--------------------------------------------------------------------------
| Debug
|--------------------------------------------------------------------------
| Todas as funções debug do controller
*/
    private function echoUserData($userData){
        echo json_encode($userData);
    }
/*
|--------------------------------------------------------------------------
| View
|--------------------------------------------------------------------------
| Todas as funções do contexto view
*/
    public function profile(){
        if($this->session->userdata("status") == true){
            $this->template->show('profile.php');
        }else{
            redirect('user/index');
        }
    }

    public function login(){
        if($this->session->userdata("status") == true){
            redirect('user/index');
        }else{
            $content = array(
                "styles" => array('login.css', 'form.css'),
                "headScripts" => array('https://apis.google.com/js/platform.js', 'https://apis.google.com/js/platform.js?onload=renderButton'),
                "scripts" => array('loginGoogle.js', 'util.js', 'form.js'),
            );
            $this->template->show('login.php', $content);
        }
    }
/*
|--------------------------------------------------------------------------
| Login/Cadastro Google
|--------------------------------------------------------------------------
| Todas as funções login google
*/
    public function ajax_googleSignIn(){

        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }

        $response = array(
            "status" => 0,
            "generic_error" => false,
        );

        $client = $this->googleClientInstance();

        $userToken = $this->input->post('userToken');

        $googleUserData = $this->verifyGoogleUserData($client, $userToken);
        
        if(isset($googleUserData['error'])){
            $response['status'] = 1;
            $response['generic_error'] = true;
        }
        $result = $this->users->searchThirdId("teste");
        /*if($response['status'] == 0){

            $userExist = $this->users->userExists($googleUserData["userData"]["email"]);
            
            if($userExist){
                
                $userId = $this->users->getUserId($googleUserData["userData"]["email"]);
                $this->users->updateGoogleUser($googleUserData, $userId);

            }else{

                $this->users->insertGoogleUser($googleUserData);

            }

            $userData = $this->users->selectUserData($googleUserData["userData"]["email"]);
            
            $this->session_data["user_data"] = $userData;

            $userPrivilege = $this->users->verifyUserPrivilege($userData["idprivilegio"]);
            $this->session_data["user_privilege"] = $userPrivilege;

            $this->session_data["status"] = true;
            $this->startSession($this->session_data);

        }*/

        echo json_encode($result);
    }

    private function googleClientInstance(){
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
        return $client;
    }

    private function verifyGoogleUserData($client, $userToken){
        $erros = array();

        $payload = $client->verifyIdToken($userToken);

        if($payload){
            if($payload['email_verified']){
                if($payload['name'] != ""){
                    $response = array(
                        "thirdParty" => array(
                            "thirdName" => 'google',
                            "id" => $payload['sub'],
                        ),
                        "userData" => array(
                            "email" => $payload['email'],
                            "nomecompleto" => $payload['name'],
                            "nome" => $payload['given_name'],
                            "sobrenome" => $payload['family_name'],
                            "picture" => $payload['picture']
                        )
                    );
                    return $response;
                }else{
                    $erros['error'] = "Erro: nome invalido!";
                }
            }else{
                $erros['error'] = "Falha na verificao do Email!";
            }
        }else{
            $erros['error'] = "Token Invalido!";
        }
        return $erros;
    }

/* 
|--------------------------------------------------------------------------
| Sessão
|--------------------------------------------------------------------------
| Todas as funções de sessão
*/

    private function startSession($sessionData){
        $this->session->set_userdata($sessionData);
        $this->session_data = $this->default_session_data;
    }

    public function session_destroy(){

        $this->session->unset_userdata('user_data');
        $this->session->unset_userdata('user_privilege');
        $this->session->set_userdata('status', false);
        $this->session->sess_destroy();
        redirect('user');

    }
}