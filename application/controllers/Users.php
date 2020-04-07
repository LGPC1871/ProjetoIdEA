<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{
    function __construct() { 
        parent::__construct(); 

        // Load form validation library & user model 
        $this->load->library('form_validation'); 
        $this->load->model('user'); 
         
        // User login status 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    } 

    public function index(){
        if($this->isUserLoggedIn){
            redirect('users/account');
        }else{
            redirect('users/login');
        }
    }

    //Leva ate a area do operador
    public function account(){
        $data = array();
        if($this->isUserLoggedIn){
            $conditions = array( 
                'id' => $this->session->userdata('userId') 
            ); 
            $data['user'] = $this->user->getRows($conditions);
            $this->template->show('restrict.php', $data);
        }else{
            redirect('users/login');
        }
    }

    public function login(){
        $this->template->show('login.php');

        $data = array();   
        //Se o botao login for acionado
        if($this->input->post('loginSubmit')){
            $this->form_validation->set_rules('username', 'Usuário', 'required');
            $this->form_validation->set_rules('password', 'Senha', 'required');

            if($this->form_validation->run() == true){
                //pega as informacoes digitadas pelo user
                $conditions = array(
                    'returnType' => 'single',
                    'conditions' => array(
                        'A_userName' => $this->input->post('username'),
                        'A_password' => $this->input->post('password'), /* No exemplo foi usado md5*/
                        /*'status' => 1*/
                    )
                );
                //verifica as informacoes mandando para uma funcao do model
                $checkLogin = $this->user->getRows($conditions);
                if($checkLogin){
                    $this->session->set_userdata('isUserLoggedIn', true);
                    $this->session->set_userdata('userId', $checkLogin['A_id']);
                    redirect('users/account');
                }
            }else{
                redirect('users/login');
            }
        }
    }

    public function logout(){ 
        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->sess_destroy(); 
        redirect('users/login');
    }
}