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

  function getAppointmentsForDay($d)
  {
//    $query = "SELECT * FROM appointments WHERE appointmentTS LIKE '$d%'";
//    echo"query: $query";


    $this->db->from('appointmentsview');
    $this->db->like('ts', $d);
    $query = $this->db->get();
    if($query)
          return $query->result_array();
    return null;
  }

  function updateCheckIn($id, $d){
      $this->db->where('id', $id);
      $update = $this->db->update('appointments', $d);
      return $update;
  }
}
