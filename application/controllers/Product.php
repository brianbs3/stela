<?php
require_once('Stela.php');
class Product extends Stela
{
    public function index()
    {
      echo"products...";
    }

    public function productList(){
        $this->load->model('product_model');
        $products = $this->product_model->get_product_metadata();
        echo "
      <h1 class=productsHeader align='center'>Product</h1>
      <button type='button' class='btn btn-primary' id='productAddButton' onClick='addProduct()'>Add Product</button>
      <br><br>
      <table class='table table-striped'>
        <thead class='thead-dark'>
          <tr>
            <th scope='col'>Edit</th>
            <th scope='col'>UPC</th>
            <th scope='col'>Manufacturer</th>
            <th scope='col'>Description</th>
            <th scope='col'>Color</th>
            <th scope='col'>Cost</th>
            <th scope='col'>Price</th>
            <th scope='col'>Size</th>
          </tr>
        </thead>
      <tbody>
    ";
        foreach ($products as $p) {
            $cost = "\$ " . number_format($p['cost'], 2);
            $price = "\$ " . number_format($p['price'], 2);
            echo "
        <tr>
          <th scope='row'><button type='button' class='btn btn-primary' class='productEditButton' onClick='editProduct(\"{$p['id']}\")'>Edit</button>
          <td>{$p['upc']}</td>
          <td>{$p['manufacturer']}</td>
          <td>{$p['description']}</td>
          <td>{$p['color']}</td>
          <td>{$cost}</td>
          <td>{$price}</td>
          <td>{$p['size']}</td>
        </tr>
      ";
        }
        echo " 
      </tbody>
    </table>
        ";
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
