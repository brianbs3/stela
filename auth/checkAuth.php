<?php
    if(!isset($_SESSION))
        session_start();
    require_once('authConfig.php');
    if($_SERVER['REQUEST_URI'] != '/stela/index.php/login/doLogin') {
            print_r($_SESSION);
        $now = time();
        if(isset($_SESSION['login'])){
            if($now = $_SESSION['login']['timestamp'] > $TIMEOUT){
                session_unset();
                session_destroy();
            }
        }
    }
