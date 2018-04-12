<?php

require_once('Stela.php');

class Email extends Stela {
  public function index()
  {
    echo"email";
  }

  public function sendEmail()
  {
    $this->load->library('email');

    $this->email->from('brianbs3@gmail.com', 'Brian Sizemore');
    $this->email->to('bsizemore@apple.com');
    $this->email->cc('bsizemore@apple.com');
    //$this->email->bcc('them@their-example.com');
    
    $this->email->subject('Email Test');
    $this->email->message('Testing the email class.');
    //$this->email->message('<h1>Testing the email class.</h1>  Email....');
    
    $this->email->send();
  }
}
