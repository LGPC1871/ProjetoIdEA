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
    public function forgotPassword(){
        if($this->session->userdata('loggedIn') == true){
            redirect('user/index');
        }else{
            $content = array(
                "styles" => array('form.css'),
                "scripts" => array('form.js', 'passwordRecovery.js', 'util.js')
            );
            $this->template->show('password_recovery.php', $content);
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
            $userExist = $this->users->userExists($email);
            if(!$userExist){
                $response['status'] = 1;
                array_push($response["error_list"], "#email");
            }else{
                $userData = $this->users->getUserData($email);
                /*ADICIONAR FUNCAO PARA VERIFICAR PAPEL DO USUÁRIO E ATRIBUIR A userData */
            }
        }
        //Validação da senha
        if($response['status'] == 0){
            $userPassword = $userData->AA_senha;

            if(!password_verify($password, $userPassword)){
                $response['status'] = 1;
                array_push($response["error_list"], "#email", "#password");
            }
        }
        //Criando sessão
        if($response['status'] == 0){
            $status = true;
            $this->startSession($userData, $status);
        }

        echo json_encode($response);
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

        $userData = $this->verifyGoogleUserData($client, $userToken);
        
        if(!isset($userData['Erro'])){
            $userExist = $this->users->userExists($userData['AA_email']);

            if($userExist){
                $userData['AA_updated'] = date("Y-m-d H:i:s");
                $this->users->updateUserData($userData);
            }else{
                $userData['AA_created'] = date("Y-m-d H:i:s");
                $userData['AA_updated'] = date("Y-m-d H:i:s");
                $this->users->insertUserData($userData);
            }
            $this->startSession($userData, true);
        }else{
            //CASO OCORRA ALGUM ERRO
            $this->echoUserData($userData);
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
            "error_list" => array()
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
            $result = $this->users->userExists($email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $result){
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
            $time = date("Y-m-d H:i:s");
            $userData = array(
                'AA_email' => $email,
                'AA_nomeCompleto' => $fullName,
                'AA_nome' => $firstName,
                'AA_sobrenome' => $lastName,
                'AA_senha' => $passwordHash,
                'AA_created' => $time,
                'AA_updated' => $time,
                'AD_id' => 1
            );
            
            $this->users->insertNewUser($userData);
        }

        echo json_encode($response);
    }
/* 
|--------------------------------------------------------------------------
| Sessão
|--------------------------------------------------------------------------
| Todas as funções de sessão
*/

    private function startSession($userData){
        $sessionData = array(
            "loggedIn" => true,
            "userData" => $userData,
        );

        $this->session->set_userdata($sessionData);
    }

    public function destroySession(){
        $this->session->unset_userdata('userData');
        $this->session->set_userdata('loggedIn', false);
        $this->session->sess_destroy();
        redirect('user');
    }
/* 
|--------------------------------------------------------------------------
| Senha
|--------------------------------------------------------------------------
| Todas as funções de senha do usuário
*/
    public function passwordRecovery(){
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
        
        $inputJson = array(
            "#email" => $email,
        );

        foreach($inputJson as $key => $value){
            if(empty($value) || $value == " " || ctype_space($value)){
                $response['empty'] = 1;
                $response['status'] = 1;
                array_push($response["error_list"], $key);
            }
        }

        if($response['status'] == 0){
            $userExist = $this->users->userExists($email);
            if(!$userExist){
                $response['status'] = 1;
                array_push($response["error_list"], "#email");
            }else{
                $userData = $this->users->getUserEmailPassword($email);
                $userEmail = $userData->AA_email;
                $userPasswordHash = $userData->AA_password;                
            }
        }
        if($response['status'] == 0){
            
            if((!strcmp($email, $user_email))){
                $pass=$row->pass;
                    /*Mail Code*/
                    $to = $userEmail;
                    $subject = "Recuperar Senha";
                    $txt = "Sua senha é: $pass .";
                    $headers = "From: noreply@idea.com";

                    mail($to,$subject,$txt,$headers);
            }else{
                $response['status'] = 1;
                array_push($response["error_list"], "#email");            
            }
        }

        echo json_encode($response);
    }
}