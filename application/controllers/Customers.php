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
}
