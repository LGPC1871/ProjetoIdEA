<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('google');
        $this->config->load('google');
        $this->load->model('users');
        $this->load->library('form_validation');  
    }
    public function index(){
        if($this->session->userdata('loggedIn') == true){
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
        if($this->session->userdata('loggedIn') == true){
            $this->template->show('profile.php');
        }else{
            redirect('user/index');
        }
    }
    public function register(){
        if($this->session->userdata('loggedIn') == true){
            redirect('user/index');
        }else{
            $content = array(
                "styles" => array('form.css', 'register.css'),
                "scripts" => array("util.js", "form.js", "register.js"),
            );
            $this->template->show('register.php', $content);
        }
    }
    public function login(){
        if($this->session->userdata('loggedIn') == true){
            redirect('user/index');
        }else{
            $content = array(
                "styles" => array('login.css', 'form.css'),
                "headScripts" => array('https://apis.google.com/js/platform.js', 'https://apis.google.com/js/platform.js?onload=renderButton'),
                "scripts" => array('loginGoogle.js', 'loginPadrao.js', 'util.js', 'form.js'),
            );
            $this->template->show('login.php', $content);
        }
    }
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
| Todas as funções login
*/
    public function loginAjax(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}
        //Adicionando variavel json para usar no ajax
        $response = array(
            "status" => 0,
            "empty" => 0,
            "error_list" => array()
        );

        //Recolhe informacoes do formulario;
        $email = $this->input->post("Email");
        $password = $this->input->post("Senha");
        
        //Se o botao login for acionado
        
        if(empty($email) || empty($password)){
            $response["status"] = 1;
            $response["empty"] = 1;
            if(empty($password))
                array_push($response["error_list"], "#password");
            if(empty($email))
                array_push($response["error_list"], "#email");
        }else{
            
            $this->form_validation->set_rules('Email', 'Email', 'required');
            $this->form_validation->set_rules('Senha', 'Senha', 'required');

            if($this->form_validation->run() == true){

                $result = $this->users->getUserData($email);
                
                if($result){
                    
                    $userEmail = $result->AA_email;
                    $passwordHash = $result->AA_password;

                    if(password_verify($password, $passwordHash)){
                        $this->session->set_userdata('loggedIn', true);
                        $this->session->set_userdata('userData', $result);
                    }else{
                        $response["status"] = 1;
                    }
                }else{
                    $response["status"] = 1;
                }
            }else{
                $response["status"] = 1;
                }
            if($response["status"] == 1){
                array_push($response["error_list"], "#email", "#password");
            }
        }
        echo json_encode($response);
    }
    public function userLogout(){
        $this->session->set_userdata('loggedIn', false);
        $this->session->unset_userdata('userData');

        $this->session->sess_destroy();

        redirect('user');
    }
/*
|--------------------------------------------------------------------------
| Login Google
|--------------------------------------------------------------------------
| Todas as funções login google
*/
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
/* 
|--------------------------------------------------------------------------
| Register
|--------------------------------------------------------------------------
| Todas as funções da funcionalidade de cadastro
*/
    public function registerAjax(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }

        $response = array(
            "status" => 0,
            "empty" => 0,
            "error_list" => array()
        );
        
        $firstName = $this->input->post("Nome");
        $lastName = $this->input->post("Sobrenome");
        $email = $this->input->post("Email");
        $senha = $this->input->post("Senha");
        $senhaConfirma = $this->input->post("Senha2");

        $inputJson = array(
            "#firstName" => $firstName,
            "#lastName" => $lastName,
            "#email" => $email,
            "#password" => $senha,
            "#passwordConfirm" => $senhaConfirma
        );

        foreach($inputJson as $key => $value){
            if(empty($value) || $value == " "){
                $response['empty'] = 1;
                $response['status'] = 1;
                array_push($response["error_list"], $key);
            }
        }
        if($response['status'] == 0){
            //verificar nomes
            if(preg_match('/[^a-zA-Z]/', $firstName)){
                $response['status'] = 1;
                array_push($response["error_list"], "#firstName");
            }
            if(preg_match('/[^a-zA-Z]/', $lastName)){
                $response['status'] = 1;
                array_push($response["error_list"], "#lastName");
            }
        }

        if($response['status'] == 0){
            //verificar Email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response['status'] = 1;
                array_push($response["error_list"], "#email");
            }
        }

        if($response['status'] == 0){
            //verificar senhas
            if($senha != $senhaConfirma){
                $response['status'] = 1;
                array_push($response["error_list"], "#password");
                array_push($response["error_list"], "#passwordConfirm");
            }
        }

        echo json_encode($response);
    }
}