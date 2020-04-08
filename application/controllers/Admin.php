<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
    function __construct() { 
        parent::__construct(); 

        // Load form validation library & user model 
        $this->load->library('form_validation'); 
         
        // User login status 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    } 

    public function index(){
        if($this->isUserLoggedIn){
            redirect('admin/account');
        }else{
            //envia para a pagina os arquivos unicos dela
            redirect('admin/login');
        }
    }
    public function login(){
        if($this->isUserLoggedIn){
            redirect('admin/account');
        }else{
            $content = array(
                "styles" => array("login.css"),
                "scripts" => array("util.js", "login.js")
            );
            
            $this->template->show('login.php', $content);
        }
    }
    //Leva ate a area do operador
    public function account(){
        $data = array();
        if($this->isUserLoggedIn){
            $this->template->show('restrict.php');
        }else{
            redirect('admin/login');
        }
    }

    public function loginAjax(){
        if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}
        //Adicionando variavel json para usar no ajax
        $json = array();
        $json["status"] = 0; //verifica se há erros (0-nao 1-sim)
        $json["error_list"] = array();

        //Recolhe informacoes do formulario;
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        
        //Se o botao login for acionado
        if(empty($username)){
            $json["status"] = 1;
            $json["error_list"]["#nome"] = "Usuário não pode ser vazio!";
        }else{
            
            $this->form_validation->set_rules('username', 'Usuário', 'required');
            $this->form_validation->set_rules('password', 'Senha', 'required');

            if($this->form_validation->run() == true){
                //Carrega o model
                $this->load->model('user'); 
                //pega as informacoes digitadas pelo user
                $conditions = array(
                    'returnType' => 'single',
                    'conditions' => array(
                        'A_userName' => $username,
                        'A_password' => $password, /* No exemplo foi usado md5*/
                    )
                );
                //verifica as informacoes mandando para uma funcao do model
                $result = $this->user->getRows($conditions);
                if($result){
                    $this->session->set_userdata('isUserLoggedIn', true);
                    $this->session->set_userdata('userId', $result['A_id']);
                    //redirect('admin/account');
                }else{
                    $json["status"] = 1;
                }
            }else{
                //Sinalizando erros
                $json["status"] = 1;
                }
            }
            if($json["status"] == 1){
                $json["error_list"]["#botaoLogin"] = "Usuário e/ou Senha incorretos!";
        }
        echo json_encode($json);
    }

    public function logout(){ 
        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->sess_destroy(); 
        redirect('admin/index');
    }
}