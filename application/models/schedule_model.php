<?php

class Schedule_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
  function get_schedule()
  {
    $this->db->from('schedule');
    $query = $this->db->get();
    if($query)
      return $query->result_array();
    return null;
  }
}
