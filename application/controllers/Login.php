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

    public function doLogin() {
        $this->load->model('stela_model');
        $pin = $this->input->post('pin', true);
        $login = $this->stela_model->checkLogin($pin);
        $return = array(); 
        if(isset($login[0])){
            $return = $login[0];
            $return['status'] = true; 
            $return['timestamp'] = time();
            $_SESSION['login'] = $return;
        }
        else
            $return['status'] = false;
        echo json_encode($return);
    }
}
