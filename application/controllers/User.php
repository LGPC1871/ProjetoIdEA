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
            "has_password" => false,
            "user_privilege" => array()
        );
        $this->session_data = $this->default_session_data;
    }

    public function index(){
        if($this->session->userdata("status") == true){
            if($this->session->userdata("has_password") == true){
                redirect('user/profile');
            }else{
                redirect('user/password_define');
            }
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
        if($this->session->userdata("status") == true && $this->session->userdata("has_password") == true){
            $content = array(
                "styles" => array('form.css', 'register.css'),
            );
            $this->template->show('profile.php');
        }else{
            redirect('user/index');
        }
    }

    public function register(){
        if($this->session->userdata("status") == true){
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
        if($this->session->userdata("status") == true){
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

    public function forgotPassword(){
        if($this->session->userdata("status") == true){
            redirect('user/index');
        }else{
            $content = array(
                "styles" => array('form.css'),
                "scripts" => array('form.js', 'passwordRecovery.js', 'util.js')
            );
            $this->template->show('password_recovery.php', $content);
        }
    }

    public function password_define(){
        $content = array(
            "styles" => array('form.css'),
            "scripts" => array('form.js', 'util.js', 'passwordDefine.js')
        );
        $this->template->show('password_define.php', $content);
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

        //Recolhe informacoes do formulario
        $email = $this->input->post("Email");
        $password = $this->input->post("Senha");
    
        $inputArray = array(
            "#email" => $email,
            "#password" => $password,
        );
        //Verifica se todos os campos foram preenchidos
        foreach($inputArray as $key => $value){
            if(empty($value) || $value == " " || ctype_space($value)){
                $response['empty'] = 1;
                $response['status'] = 1;
                array_push($response["error_list"], $key);
            }
        }
        //Validação do Usuário
        if($response['status'] == 0){
            
            $userData = $this->users->selectUserData($email);

            if(!$userData){
                $response['status'] = 1;
                array_push($response["error_list"], "#email");
            }
        }
        //Validação da senha
        if($response['status'] == 0){
            if(password_verify($password, $userData["senha"])){
                $password = "";
                unset($userData["senha"]);
                $this->session_data["user_data"] = $userData;
            }else{
                $response['status'] = 1;
                array_push($response["error_list"], "#email", "#password");
            }
        }
        //verificar privilégio do usuário
        if($response['status'] == 0){
            $userPrivilege = $this->users->verifyUserPrivilege($userData["idprivilegio"]);

            if($userPrivilege){
                $this->session_data["user_privilege"] = $userPrivilege;
            }else{
                $response['status'] = 1;
                array_push($response["error_list"], "#email", "#password");
            }
        }
        //Criando sessão
        if($response['status'] == 0){
            $this->session_data["status"] = true;
            $this->startSession($this->session_data);
        }

        echo json_encode($response);
    } 
/*
|--------------------------------------------------------------------------
| Login/Cadastro Google
|--------------------------------------------------------------------------
| Todas as funções login google
*/
    public function googleAjaxLogin(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }
        $response = array(
            "status" => 0,
            "teste" => array('1', '2'),
        );

        $client = $this->googleClientInstance();

        $userToken = $_POST['userToken'];

        $googleUserData = $this->verifyGoogleUserData($client, $userToken);
        
        $userId = $this->users->getUserId($googleUserData["userData"]["email"]);

        if(isset($googleUserData['Erro'])){
            $response['status'] = 1;
        }

        if($response['status'] == 0){
            $userExist = $this->users->userExists($googleUserData["userData"]["email"]);

            if($userExist){
                
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

        }
        echo json_encode($response);
    }

    private function verifyGoogleUserData($client, $userToken){
        $erros = array();

        $payload = $client->verifyIdToken($userToken);

        if($payload){
            if($payload['email_verified']){
                if($payload['name'] != ""){
                    $response = array(
                        "thirdParty" => array(
                            "thirdId" => 1,
                            "id" => $payload['sub'],
                        ),
                        "userData" => array(
                            "email" => $payload['email'],
                            "nomecompleto" => $payload['name'],
                            "nome" => $payload['given_name'],
                            "sobrenome" => $payload['family_name'],
                        )
                   
                    );
                    return $response;
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

    public function googleClientInstance(){
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
/* 
|--------------------------------------------------------------------------
| Cadastro
|--------------------------------------------------------------------------
| Todas as funções da funcionalidade de cadastro
*/
    public function registerAjax(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }
        //array de resposta para a requisição ajax
        $response = array(
            "status" => 0,
            "empty" => 0,
            "error_list" => array(),
            "generic_error" => false
        );
        
        $firstName = $this->input->post("Nome");
        $lastName = $this->input->post("Sobrenome");
        $email = $this->input->post("Email");
        $senha = $this->input->post("Senha");
        $senhaConfirma = $this->input->post("Senha2");

        $inputArray = array(
            "#firstName" => $firstName,
            "#lastName" => $lastName,
            "#email" => $email,
            "#password" => $senha,
            "#passwordConfirm" => $senhaConfirma
        );

        foreach($inputArray as $key => $value){
            if(empty($value) || $value == " " || ctype_space($value)){
                $response['empty'] = 1;
                $response['status'] = 1;
                array_push($response["error_list"], $key);
            }
        }

        if($response['status'] == 0){
            //verificar nomes
            $pattern = '/[^a-zA-Z ]/';
            if(preg_match($pattern, $firstName)){
                $response['status'] = 1;
                array_push($response["error_list"], "#firstName");
            }
            if(preg_match($pattern, $lastName)){
                $response['status'] = 1;
                array_push($response["error_list"], "#lastName");
            }
            $fullName = $firstName . " " . $lastName;
        }

        if($response['status'] == 0){
            //verificar Email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            $userExist = $this->users->userExists($email);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $userExist){
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
            }else{
                $passwordHash = password_hash($senha, PASSWORD_DEFAULT);
            }
        }

        if($response['status'] == 0){
            $userData = array(
                    "email" => $email,
                    "nomecompleto" => $fullName,
                    "nome" => $firstName,
                    "sobrenome" => $lastName,
                    "senha" => $passwordHash,
            );
            
            $result = $this->users->insertNewUser($userData);

            if(!$result){
                $response["status"] = 1;
                $response["generic_error"] = true;
            }
        }

        echo json_encode($response);
    }
/* 
|--------------------------------------------------------------------------
| Sessão
|--------------------------------------------------------------------------
| Todas as funções de sessão
*/

    private function startSession($sessionData){

        $sessionData['has_password'] = $this->users->userHasPassword($sessionData['user_data']['id']);

        $this->session->set_userdata($sessionData);
        $this->session_data = $this->default_session_data;

    }

    public function destroySession(){

        $this->session->unset_userdata('user_data');
        $this->session->unset_userdata('user_privilege');
        $this->session->set_userdata('status', false);
        $this->session->sess_destroy();
        redirect('user');

    }
/* 
|--------------------------------------------------------------------------
| Senha
|--------------------------------------------------------------------------
| Todas as funções de senha do usuário
*/
    public function passwordDefineAjax(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
        }
        
        $response = array(
            "status" => 0,
            "empty" => 0,
            "error_list" => array(),
            "generic_error" => false
        );

        $senha = $this->input->post("senha");
        $senhaConfirma = $this->input->post("confirma");

        $inputArray = array(
            "#password" => $senha,
            "#passwordConfirm" => $senhaConfirma,
        );

        foreach($inputArray as $key => $value){
            if(empty($value) || $value == " " || ctype_space($value)){
                $response['empty'] = 1;
                $response['status'] = 1;
                array_push($response["error_list"], $key);
            }
        }

        if($response['status'] == 0){
            if($senha == $senhaConfirma){
                $passwordHash = password_hash($senha, PASSWORD_DEFAULT);
            }else{
                $response['status'] = 1;
                array_push($response["error_list"], "#password");
                array_push($response["error_list"], "#passwordConfirm");
            }
        }

        if($response['status'] == 0){
            $userId = $this->session->userdata('user_data')['id'];

            $result = $this->users->setUserPassword($userId, $passwordHash);

            if(!$result){
                $response['status'] = 1;
                $response['generic_error'] = true;
            }
        }

        echo json_encode($result);
    }
}