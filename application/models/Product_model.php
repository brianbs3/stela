<?php

class Product_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
        $this->db->from('product');
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
}