<?php
require_once('Stela.php');


class Appointments extends Stela {
  public function index()
  {
    $this->load->model('appointments_model');
    $c = $this->appointments_model->get_appointments();

    echo"Appointments";
      $this->load->view('appointments');
  }
}