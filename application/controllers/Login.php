<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    
    public function __construct(){
        parent::__construct();

        //REQUIRES\\
        require_once(APPPATH . 'libraries/model/PessoaModel.php');
        require_once(APPPATH . 'libraries/model/PessoaTerceiroModel.php');
        require_once(APPPATH . 'libraries/model/TerceiroModel.php');
        require_once(APPPATH . 'libraries/model/PessoaPrivilegioModel.php');
        require_once(APPPATH . 'libraries/model/PrivilegioModel.php');

        //LOADS\\
        $this->load->model('dao/PessoaDAO', 'pessoaDAO');
        $this->load->model('dao/TerceiroDAO', 'terceiroDAO');
        $this->load->model('dao/PessoaTerceiroDAO', 'pessoaTerceiroDAO');
        $this->load->model('dao/PrivilegioDAO', 'privilegioDAO');
        $this->load->model('dao/PessoaPrivilegioDAO', 'pessoaPrivilegioDAO');

        $this->config->load('google');

    }
    
    public function index(){
        if(!$this->session->userdata("logged")){
            $content = array(
                "head_scripts" => array(
                    'https://apis.google.com/js/platform.js', 
                    'https://apis.google.com/js/platform.js?onload=renderButton'
                ),
                "scripts" => array(
                    'user.js', 
                    'util.js'
                ),
            );
            $this->template->show('login.php', $content);
        }else{
            redirect('profile');
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
        /**
         * funcao googleLogin
         * efetua login com conta google,
         * cadastra ou atualiza dados da pessoa
         * @param GoogleToken
         * @return string - erro
         * @return boolean - sucesso
         */
        private function googleLogin($token){

            $payload = $this->googleAuth($token);
            
            if(!$payload){
                return "authentication";
            }

            $pessoaModel = $this->googleUserModel($payload);
            
            if(!$pessoaModel) return "info_lack";
            $pessoaTerceiroModel = $this->googlePessoaTerceiro($payload['sub']);

            if(!$pessoaTerceiroModel) return "invalid_third";
            
            $userExist = $this->pessoaDAO->getUser(array('select' => array('id'),'where' => array('email'=>$pessoaModel->getEmail())));
            if($userExist){
                //update
                $pessoaTerceiroModel->setPessoaId($userExist->getId());
                $input = array(
                    'pessoaModel' => $pessoaModel,
                    'pessoaTerceiroModel' => $pessoaTerceiroModel
                );
                $result = $this->updateUser($input);
                if(!$result) return "update";
            }else{
                //register
                $input = array(
                    'pessoaModel' => $pessoaModel,
                    'pessoaTerceiroModel' => $pessoaTerceiroModel
                );
                $result = $this->registerUser($input);

                if(!$result) return "register";
            }
            //start session
            /*$userData = $this->userDAO->selectUserData("email", $pessoaModel->getEmail());

            if(!$userData){
                return false;
            }

            $additionalInfo = array(
                "picture" => $payload["picture"]
            );

            return $this->startSession($userData, $additionalInfo);*/
        }
        
        /**
         * funcao googleAuth
         * autenticacao da sessao google
         * @param token
         * @return payload
         * @return false
         */
        private function googleAuth($token){

            $clientId = $this->config->item('client_id', 'google');

            $client = new Google_Client(['client_id' => $clientId]);

            $payload = $client->verifyIdToken($token);

            return $payload;

        }

        /**
         * funcao googleUserModel
         * gera um objeto contendo as informacoes
         * do usuário
         * @param payload
         * @return PessoaModel
         * @return false
         */
        private function googleUserModel($payload){
            $error = false;

            $userData = new PessoaModel();

            isset($payload['email']) ? $userData->setEmail($payload['email']) : $error = true;
            isset($payload['name']) ? $userData->setNomeCompleto($payload['name']) : $error = true;
            isset($payload['given_name']) ? $userData->setNome($payload['given_name']) : $error = true;
            isset($payload['family_name']) ?$userData->setSobrenome($payload['family_name']) : null;
            
            return $error ? false : $userData;
        }
        
        /**
         * Método instancia um objeto PessoaTerceiro
         * retorna com pessoaId null, deve ser adicionado posteriormente
         * @param string $sub
         * @return object
         */
        private function googlePessoaTerceiro($sub){
            
            //faz uma busca em @terceiro
            //retornará false se o terceiro nao existir
            $like = array(
                'nome' => 'google'
            );
            $options = array(
                'like' => $like
            );
            $terceiro = $this->terceiroDAO->getTerceiro($options);
            
            if(!$terceiro) return false;
            $terceiroId = $terceiro->getId();

            $pessoaTerceiro = new PessoaTerceiroModel();
            $pessoaTerceiro->setTerceiroId($terceiroId);
            $pessoaTerceiro->setPessoaTerceiroId($sub);
            
            return $pessoaTerceiro;
        }

    /*
    |--------------------------------------------------------------------------
    | Sessão
    |--------------------------------------------------------------------------
    | Todas as funções relacionadas a sessão do usuário
    */
        /**
         * funcao startSession
         * inicia uma sessao na aplicação
         * @param PessoaModel
         * @param array $additionalInfo
         * @return true
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

        /**
         * funcao endSession
         * finaliza a sessao do usuário na aplicação
         * @return null
         */
        public function endSession(){
            $this->session->sess_destroy();
            redirect('user');
        }


    /*
    |--------------------------------------------------------------------------
    | PRIVATE
    |--------------------------------------------------------------------------
    | Todas as funções da classe
    */
        /**
         * método registerUser
         * cadastra um novo usuário na aplicação
         * retorna false se a operação falhar
         * @param array $input
         * @return bool
         */
        private function registerUser($input = array()){
            //executar método em @pessoa
            $inputPessoaDAO = array(
                'pessoaModel' => $input['pessoaModel']
            );
            $pessoaId = $this->pessoaDAO->addUser($inputPessoaDAO);
            if(!$pessoaId) return false;

            //executar método em @pessoa_terceiro
            $pessoaTerceiroModel = $input['pessoaTerceiroModel'];
            $pessoaTerceiroModel->setPessoaId($pessoaId);
            $inputPessoaTerceiroDAO = array(
                'pessoaTerceiroModel' => $pessoaTerceiroModel
            );
            if(!$this->pessoaTerceiroDAO->addPessoaTerceiro($inputPessoaTerceiroDAO)){
                $this->pessoaDAO->removeUser(array('where' => array('id' => $pessoaId)));
                return false;
            } 

            //executar método em @pessoa_privilegio com privilégio inicial padrao
            $like = array(
                'nome' => 'participante'
            );
            $options = array(
                'like' => $like
            );
            $privilegio = $this->privilegioDAO->getPrivilegio($options);

            $pessoaPrivilegio = new PessoaPrivilegioModel();
            $pessoaPrivilegio->setPessoaId($pessoaId);
            $pessoaPrivilegio->setPrivilegioId($privilegio->getId());

            $inputPessoaPrivilegioDAO = array(
                'pessoaPrivilegioModel' => $pessoaPrivilegio
            );

            if(!$this->pessoaPrivilegioDAO->addPrivilege($inputPessoaPrivilegioDAO)){
                $this->pessoaDAO->removeUser(array('where' => array('id' => $pessoaId)));
                $this->pessoaTerceiroDAO->removePessoaTerceiro(array('where' => array('pessoa_id' => $pessoaId)));
                return false;
            } 

            //@return
            return true;
        }

        /**
         * método updateUser
         * atualiza informações do usuário
         * @param array $input
         * @return boolean
         */
        private function updateUser($input = array()){
            //executar update em @pessoa
            $inputPessoaDAO = array(
                'pessoaModel' => $input['pessoaModel']
            );
            if(!$this->pessoaDAO->updateUser($inputPessoaDAO)) return false;
            
            //verificar existencia em @terceiro
            $pessoaTerceiro = $input['pessoaTerceiroModel'];
            $inputPessoaTerceiroDAO = array(
                'pessoaTerceiroModel' => $pessoaTerceiro
            );
            $options = array(
                'where' => array(
                    'pessoa_id' => $pessoaTerceiro->getPessoaId(),
                    'terceiro_id' => $pessoaTerceiro->getTerceiroId(),
                ),
                'select' => array(
                    'id_pessoa_terceiro'
                )
            );
            $pessoaTerceiroExiste = $this->pessoaTerceiroDAO->getPessoaTerceiro($options);
            if(!$pessoaTerceiroExiste){
                if(!$this->pessoaTerceiroDAO->addPessoaTerceiro($inputPessoaTerceiroDAO)) return false;
            }else{
                if(!$this->pessoaTerceiroDAO->updatePessoaTerceiro($inputPessoaTerceiroDAO)) return false;
            }
            return true;
        }
}