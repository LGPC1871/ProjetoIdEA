<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{
    public function __construct(){
        parent::__construct();

        //REQUIRES\\

    }
    public function index(){
        if($this->session->userdata("logged")){
            $this->loadProfile();
        }else{
            redirect('user/login');
        }

    }

    private function loadProfile(){
        $this->template->show("profile.php", $content);
    }
}