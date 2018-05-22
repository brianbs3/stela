<?php

class Clients_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
  function get_clients()
  {
    $this->db->from('clients');
    $query = $this->db->get();
    if($query)
      return $query->result_array();
    return null;
  }
}
