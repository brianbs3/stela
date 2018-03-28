<?php
require_once('Stela.php');
class Customers extends Stela {
  public function index()
  {
    $this->load->model('customers_model');
    $c = $this->customers_model->get_customers();
    $this->dump_array($c);
    echo"customers";
  }

  public function list()
  {
    $this->load->model('customers_model');
    $customers = $this->customers_model->get_customers();
    foreach($customers as $c)
      $this->dump_array($c);
  }
}
