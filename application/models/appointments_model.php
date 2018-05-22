<?php

class Appointments_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
  function get_appointments()
  {
    $this->db->from('appointments');
    $query = $this->db->get();
    if($query)
      return $query->result_array();
    return null;
  }
}
