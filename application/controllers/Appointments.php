<?php
require_once('Stela.php');


class Appointments extends Stela {
  public function index()
  {
    $this->load->model('appointments_model');
    $c = $this->appointments_model->get_appointments();
//    $this->dump_array($c);

    echo"Appointments";
      $this->load->view('appointments');
  }

  public function getAppointmentsForDay()
  {
    $date = $this->input->get('date');
    $this->load->model('appointments_model');
    $app = $this->appointments_model->getAppointmentsForDay($date);
    $this->dump_array($app);
  }
}