<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
    function __construct() { 
        parent::__construct(); 
        $this->load->library('form_validation');  
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    } 
    public function index(){
        if($this->isUserLoggedIn){
            redirect('admin/account');
        }else{
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
        $json["status"] = 0; //sinaliza se há erros (0-nao 1-sim)
        $json["error_list"] = array();

        //Recolhe informacoes do formulario;
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        
        //Se o botao login for acionado
        
        if(empty($username) || empty($password)){
            $json["status"] = 1;
            if(empty($password))
                $json["error_list"]["#senha"] = "";
            if(empty($username))
                $json["error_list"]["#nome"] = "";
        }else{
            
            $this->form_validation->set_rules('username', 'Usuário', 'required');
            $this->form_validation->set_rules('password', 'Senha', 'required');

            if($this->form_validation->run() == true){
                $this->load->model('user'); 

                $result = $this->user->getUserData($username);
                
                if($result){
                    
                    $userId = $result->A_id;
                    $passwordHash = $result->A_password;

                    if(password_verify($password, $passwordHash)){
                        $this->session->set_userdata('isUserLoggedIn', true);
                        $this->session->set_userdata('userId', $userId);
                    }else{
                        $json["status"] = 1;
                    }
                }else{
                    $json["status"] = 1;
                }
            }else{
                $json["status"] = 1;
                }
            if($json["status"] == 1){
                $json["error_list"]["#botaoLogin"] = "";
            }
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