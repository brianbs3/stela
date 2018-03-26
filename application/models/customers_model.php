<?php

class Customers_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
  function get_customers()
  {
    $this->db->from('customers');
    $query = $this->db->get();
    if($query)
      return $query->result_array();
    return null;
  }
}
