<?php

class Product_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getProductFromUPC($upc){
        $this->db->from('product');
        $this->db->where('upc', $upc);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
    }
    function lookupProduct($upc) {
        $this->db->from('product');
        $this->db->like('upc', $upc);

        $query = $this->db->get();
        if($query)
            return $query->result_array();
    }

    function getProducts(){
        $this->db->from('product');
        $query = $this->db->get();
        if($query)
            return $query->result_array();
    }

    function get_product_metadata(){
        $this->db->select(
            'product.id as id, 
            product.upc as upc,
            product.manufacturer as manufacturer,
            product.description as description,
            product.color as color,
            product.cost as cost,
            product.price as price,
            product.location as location,
            product.size as size,
            product_inventory.count as count
            '
        );
        $this->db->from('product');
        $this->db->join('product_inventory', 'product.id = product_inventory.productID', 'left');
        $this->db->order_by('manufacturer, description');
        $query = $this->db->get();
        
        if($query)
            return $query->result_array();
        return null;
    }

    function getProduct($id) {
        $this->db->from('product');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }

    function upsertProduct($data) {
        $query = $this->db->insert_string('product', $data);
        $query .= " ON DUPLICATE KEY UPDATE 
            upc = '{$data['upc']}',
            manufacturer = {$this->db->escape($data['manufacturer'])},
            description = {$this->db->escape($data['description'])},
            color = {$this->db->escape($data['color'])},
            cost = {$this->db->escape($data['cost'])},
            price = {$this->db->escape($data['price'])},
            size = {$this->db->escape($data['size'])}
        ";

        $result = $this->db->query($query);
        $id =  $this->db->insert_id();
        return array('result'=>$result, 'id' => $id);
    }

    function productSearch($term){
        $this->db->select(
            'product.id as id, 
            product.upc as upc,
            product.manufacturer as manufacturer,
            product.description as description,
            product.color as color,
            product.cost as cost,
            product.price as price,
            product.location as location,
            product.size as size,
            product_inventory.count as count
            '
        );
        $this->db->from('product');
        $this->db->join('product_inventory', 'product.id = product_inventory.productID', 'left');
        $this->db->or_like('upc', $term);
        $this->db->or_like('manufacturer', $term);
        $this->db->or_like('description', $term);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
    }

    function updateQuantity($id, $quantity){
        $data = array('productID' => $id, 'locationID' => 1, 'count' => $quantity);
        $query = $this->db->insert_string('product_inventory', $data);
        $query .= " ON DUPLICATE KEY UPDATE 
            `count` = '{$data['count']}'
        ";

        $result = $this->db->query($query);
        $id =  $this->db->insert_id();
        return array('result'=>$result, 'id' => $id);
    }
}