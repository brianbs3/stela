<?php

class Stela_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }

    function checkLogin($pin) {
        $this->db->from('stylists');
        $this->db->where('pin', $pin);
        $this->db->select('firstName, lastName, id');
        $query = $this->db->get();
        if($query)
          return $query->result_array();
        return null;
    }
}
