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

    function newAppointment($a) {
        $query = "INSERT INTO appointments (clientID, appointmentDuration, stylistID, appointmentTS, appointmentType) 
            VALUES ('{$a['clientID']}', '{$a['appointmentDuration']}', '{$a['stylistID']}', STR_TO_DATE('{$a['appointmentTS']}', '%Y-%m-%d %h:%i %p'), '{$a['appointmentType']}')";
        $result = $this->db->query($query);
        echo"{$this->db->last_query()}";
        return $result;
    }

    function getCheckinStatus($id)
    {
        $this->db->from('appointments');
        $this->db->select('checkedIn');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }

    function getAppointmentByID($id)
    {
        $this->db->from('appointmentsview');
        $this->db->where('appointmentID', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }
}
