<?php
require_once('Stela.php');

class Login extends Stela
{
    public function index(){
        echo "login";
    }

    public function loginForm(){
        echo"<input type=text name=userName placeholder='User Name' />";
    }

    public function doLogin(){
//        session_start();
        $pin = $this->input->post('pin', true);
        $_SESSION['stela'] = array(
            'firstName' => 'Brian',
            'lastName' => 'Sizemore'
        );
        $_COOKIE['stela'] = 1;
        $_SESSION['sess_status_last_checked'] = time();
//        header("Location: /stela/login.php");
    }

    public function doLogout(){
        unset($_SESSION);
        session_destroy();
    }
}