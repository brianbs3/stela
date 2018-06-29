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
}