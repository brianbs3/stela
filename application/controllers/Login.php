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
        session_start();
        $_SESSION['stela'] = array();
        $_COOKIE['stela'] = 1;
        header("Location: index.php");
    }
}