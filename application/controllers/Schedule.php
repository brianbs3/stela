<?php
require_once('Stela.php');


class Schedule extends Stela {
  public function index()
  {
    $this->load->model('schedule_model');
    $c = $this->schedule_model->get_schedule();
    $this->dump_array($c);
    echo"schedule";
  }
}