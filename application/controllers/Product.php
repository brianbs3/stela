<?php
require_once('Stela.php');
class Product extends Stela
{
    public function index()
    {
      echo"products...";
    }

    public function drawProductTable($products){
        echo"
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
            <th scope='col'>Count</th>
          </tr>
        </thead>
      <tbody>
        ";
        foreach ($products as $p) {
            $cost = "\$ " . number_format($p['cost'], 2);
            $price = "\$ " . number_format($p['price'], 2);
            
            echo "
        <tr>
          <th scope='row'><button type='button' class='btn btn-outline-primary' class='productEditButton' onClick='editProduct(\"{$p['id']}\")'>Edit</button>
          <td>{$p['upc']}</td>
          <td>{$p['manufacturer']}</td>
          <td>{$p['description']}</td>
          <td>{$p['color']}</td>
          <td>{$cost}</td>
          <td>{$price}</td>
          <td>{$p['size']}</td>
          <td><input type='text' size='5' id='productCount_{$p['upc']}' class='productListCount' value='{$p['count']}'></td>
        </tr>
        ";
        }
        echo " 
      </tbody>
    </table>
    <script>setupProductListCountInput();</script>
        ";
    }

    public function drawProductHeader($term='', $drawFilter=false){


        echo "
      <h1 class=productsHeader align='center'>Product</h1>
      ";
        if($drawFilter)
            echo"<h2>Results for: $term</h2>";
        echo"
      <table border='0' width='100%'>
        <tr>
        <td>
        ";
        if($drawFilter)
            echo"<input type='text' id=productFilter placeholder='Filter' autofocus> &nbsp;&nbsp;<button type='button' class='btn btn-outline-primary' id='productFilterButton' onClick='filterProduct()'>Filter Product</button>";
        echo"
        </td>
        <td>
        <div align='right'>
        <button type='button' class='btn btn-outline-primary' id='productAddButton' onClick='addProduct()'>Add Product</button>
        <button type='button' class='btn btn-outline-primary' id='productCartButton' onClick='productCartSetup()'>Product Cart</button>
        <button type='button' class='btn btn-outline-primary' id='productBarcodeButton' onClick='productBarcodePDF()'>Product Barcodes</button>
        </div>
        </td>
        </tr>
        </table>
      
      <br><br>";
    }

    public function productList(){
        $this->load->model('product_model');
        $term = $this->input->get('term', true);
        if($term == '')
            $products = $this->product_model->get_product_metadata();
        else
            $products = $this->product_model->productSearch($term);
        $this->drawProductHeader($term, true);
        $this->drawProductTable($products);
        echo"<script>setupProductFilter();
        $('#productFilter').focus();</script>";
    }

    public function productCart(){
        $this->load->model('product_model');
        $this->drawProductHeader();
        echo"
        <h1 class=productsHeader align='center'>Cart</h1>
        
          <table width='100%'>
            <tbody>
                <tr><td>
                <table border=1 id=appointmentReceiptProductTable width='100%'>
                    <thead><th>UPC</th><th>Description</th><th>Quantity</th><th>Price Each</th></thead>
                    <tr>
                        <td width=10%><input name=upc class=appointmentReceiptProductUPC size=15 type=text ></td>
                        <td width=80%><input name=desc type=text class=appointmentReceiptProductDescription size=50></td>
                        <td width=5%><input name=quantity class=appointmentReceiptProductQuantity size=5 type=text ></td>
                        <td width=5%><input name=price class=appointmentReceiptProductPrice size=5 type=text ></td>
                    </tr>
                </table></td></tr>
                <tr><td><button class='btn btn-outline-primary' onClick='addReceiptProduct();'>Add</button>&nbsp;&nbsp;
                <button class='btn btn-outline-primary' onClick='generateProductReceipt();'>Check Out</button>
                </td></tr>
            </tbody>
         
        </table>
        <div id='productReceiptPDFDiv'></div>
        <script>setupReceiptProductUPC();</script>
        ";
    }
    public function generateProductReceipt(){
        $this->dump_array($_POST);
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

    public function generateProductForm($data = null){
        $this->load->model('product_model');
        $productID = $this->input->get('productID', true);
        $p = $this->setupBlankProductArray();
        $existing = false;
        if($productID)
            $product = $this->product_model->getProduct($productID);
        if(isset($product)){
            $p = $product[0];
            $existing = true;
            unset($product);
        }
        echo"
        <form id=productForm>
            <table class='table table-striped' id=clientFormTable border=1>
            <thead class='thead-dark'><th> </th><th> </th></thead>

            <input id=productFormProductID type=hidden value='{$productID}' name=id>
                <tr>
                    <td>UPC</td>
                    <td><input  value='{$p['upc']}' type=text name=upc placeholder='UPC'></td>
                </tr>
                <tr>
                    <td>Manufacturer</td>
                    <td><input  value='{$p['manufacturer']}' type=text name=manufacturer placeholder='Manufacturer'></td>
                </tr>
                 <tr>
                    <td>Description</td>
                    <td><input  value='{$p['description']}' type=text name=description placeholder='Description'></td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td><input  value='{$p['color']}' type=text name=color placeholder='Color'></td>
                </tr>
                <tr>
                    <td>Cost</td>
                    <td><input  value='{$p['cost']}' type=text name=cost placeholder='Cost'></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input  value='{$p['price']}' type=text name=price placeholder='Price'></td>
                </tr>
                <tr>
                    <td>Size</td>
                    <td><input  value='{$p['size']}' type=text name=size placeholder='Size'></td>
                </tr>
            </table>
            </form>
    
        ";
    }

    function setupBlankProductArray() {
        $c = array(
            'upc' => '',
            'manufacturer' => '',
            'description' => '',
            'color' => '',
            'cost' => '',
            'price' => '',
            'location' => '',
            'size' => ''
        );

        return $c;
    }

    public function processProductForm(){
        $this->load->model('product_model');
        $productForm = $this->input->post('productForm', true);
        $product = array();
        foreach($productForm as $p)
            $product[$p['name']] = $p['value'];

        $upsert = $this->product_model->upsertProduct($product);
        $existing = ($product['id']) ? true : false;
        $return = array(
            'existing' => $existing,
            'insertID' => $upsert['id'],
            'insertStatus' => $upsert['result'],
            'product' => $product
        );
        echo json_encode($return);
    }

    public function updateQuantity(){
        $this->load->model('product_model');
        $upc = $this->input->post('upc', true);
        $quantity = $this->input->post('quantity');

        $productArr = $this->product_model->getProductFromUPC($upc);

        $return = array();
        if(isset($productArr[0]['upc']))
            $id = $productArr[0]['id'];
        else{
            $return['status'] = false;
            $return['message'] = "Product does not exist";
        }
        $update = $this->product_model->updateQuantity($id, $quantity);
        $this->dump_array($update);
        echo"upc: $upc<br>";
        echo"quantity: $quantity<br>";
    }
}
