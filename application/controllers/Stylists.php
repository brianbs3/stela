<?php
require_once('Stela.php');


class Stylists extends Stela
{
    public function index()
    {
echo"stylists";
    }

  public function getStylistInfoById()
  {
    $this->load->model('stylists_model');
    $id = $this->input->get('id', true);
    $stylist = $this->stylists_model->getStylistInfoById($id);
    echo"id: $id<br>";
    echo json_encode($stylist);
    
  }


}
