<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    
    public function __construct(){
        parent::__construct();

        //REQUIRES\\
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
        require_once(APPPATH . 'libraries/model/PessoaTerceiroModel.php');
        $this->load->model('UserDAO', 'userDAO');
        $this->config->load('google');

    }
    
    public function index(){

        if($this->session->userdata("logged") == true){

            redirect('user/profile');
            
        }else{

            redirect('user/login');

        }

    }
    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    | Todas as funções que chamam view
    */
        public function login(){

            if(!$this->session->userdata("logged")){

                $content = array(
                    "head_scripts" => array('https://apis.google.com/js/platform.js', 'https://apis.google.com/js/platform.js?onload=renderButton'),
                    "scripts" => array('loginGoogle.js', 'util.js'),
                    );
                $this->template->show('login.php', $content);

            }else{

                redirect('user');

            }
        }
        public function profile(){

            if($this->session->userdata("logged")){
                redirect('profile');
            }else{
                redirect('user');
            }
        }

    /*
    |--------------------------------------------------------------------------
    | Ajax
    |--------------------------------------------------------------------------
    | Todas as funções de requisições ajax
    */
        public function ajaxLoginGoogle(){
            if (!$this->input->is_ajax_request()) {
                exit("Nenhum acesso de script direto permitido!");
            }

            $response = array(
                "error" => false,
                "error_type" => null
            );

            $tokenId = $this->input->post("token");

            $result = $this->googleLogin($tokenId);

            if($result !== true){
                $response["error_type"] = $result;
            }

            $response["error_type"] != null ? $response["error"] = true : null;
            
            echo json_encode($response);
        }

    /*
    |--------------------------------------------------------------------------
    | Google
    |--------------------------------------------------------------------------
    | Todas as funções relacionadas ao Google exceto ajax
    */
        private function googleLogin($token){

            $payload = $this->googleAuth($token);
            
            if(!$payload){
                return "authentication";
            }

            $googleUserData = $this->googleUserModel($payload);
            $userThirdData = $this->googleUserThirdModel($payload['sub']);

            if(!$googleUserData){
                return "info_lack";
            }
            $userExist = $this->userDAO->userExist($googleUserData->getEmail());
            
            if($userExist){
                //update
                $updateUser = $this->userDAO->updateUser($googleUserData, $userThirdData);

                if(!$updateUser) return "update";
            }else{
                //register
                $addUser = $this->userDAO->insertNewUser($googleUserData, $userThirdData);

                if(!$addUser) return "register";
            }
            //start session
            $userData = $this->userDAO->selectUserData("email", $googleUserData->getEmail());

            if(!$userData){
                return false;
            }

            $additionalInfo = array(
                "picture" => $payload["picture"]
            );

            return $this->startSession($userData, $additionalInfo);
        }
        
        private function googleAuth($token){
          
            $result = true;

            $clientId = $this->config->item('client_id', 'google');

            $client = new Google_Client(['client_id' => $clientId]);

            $payload = $client->verifyIdToken($token);

            return $payload;

        }

        private function googleUserModel($payload){
            $error = false;

            $userData = new PessoaModel();

            isset($payload['email']) ? $userData->setEmail($payload['email']) : $error = true;
            isset($payload['name']) ? $userData->setNomeCompleto($payload['name']) : $error = true;
            isset($payload['given_name']) ? $userData->setNome($payload['given_name']) : null;
            isset($payload['family_name']) ?$userData->setSobrenome($payload['family_name']) : null;
            
            return $error ? false : $userData;
        }

        private function googleUserThirdModel($sub){

            $userThirdData = new PessoaTerceiroModel();

            $terceiroId = $this->userDAO->selectThirdId('google');

            $userThirdData->setTerceiroId($terceiroId);
            $userThirdData->setPessoaTerceiroId($sub);

            return $userThirdData;

        }

    /*
    |--------------------------------------------------------------------------
    | Sessão
    |--------------------------------------------------------------------------
    | Todas as funções relacionadas a sessão do usuário
    */
        
        private function startSession($userData, $additionalInfo = array()){  
            
            $this->session->set_userdata("logged", true);
            $this->session->set_userdata("userId", $userData->getId());
            $this->session->set_userdata("email", $userData->getEmail());
            $this->session->set_userdata("nome", $userData->getNome());
            $this->session->set_userdata("sobrenome", $userData->getSobrenome());
            $this->session->set_userdata("thirdInfo", $additionalInfo);
            
            return true;
        }

        public function endSession(){
            $this->session->sess_destroy();
            redirect('user');
        }

    /*
    |--------------------------------------------------------------------------
    | Cadastrar Usuário
    |--------------------------------------------------------------------------
    | Cadastrar um novo usuário
    */

        private function registerUser($userModel){
            return $this->userDAO->insertNewUser($userModel);
        }
}