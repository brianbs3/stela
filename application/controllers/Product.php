<?php
require_once('Stela.php');
class Product extends Stela
{
    public function index()
    {
      echo"products...";
    }

    public function lookupProduct() {
        $upc = $this->input->get('upc', true);
        $this->load->model('product_model');
        $result = $this->product_model->lookupProduct($upc);
        $return = null;
        if(isset($result[0]))
            $return = $result[0];
        else
            $return = array('status' => false, 'message' => 'UPC not found');
        header('Content-Type: application/json');
        echo json_encode($return);
    }
}
