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
}