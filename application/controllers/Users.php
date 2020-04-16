<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    function __construct() { 
        parent::__construct();
        
        $this->load->library('form_validation'); 
         
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
        
    }

    public function index(){ 
        redirect('users/login');
    } 

    public function login(){
        $content = array(
            "headScripts" => array("https://apis.google.com/js/platform.js"),
            "scripts" => array("loginGoogle.js"),
        );
        $this->template->show('login.php', $content);
    }

    public function register(){
        $this->template->show('register.php');
    }
}