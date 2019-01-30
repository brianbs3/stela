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
  
      function getSortedClients()
      {
          $this->db->from('clients');
          $this->db->order_by('lastName, firstName');
          $query = $this->db->get();
          if($query)
            return $query->result_array();
          return null;
      }
  
    function getClientNotes($id){
        $this->db->from('notesView');
        $this->db->where('clientID', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }
  
    function addClientNote($d) {
        $insert = $this->db->insert('clientNotes', $d);
        return $insert;
    }
  
    function getNotesForAppointment($ts, $clientID) {
        $this->db->from('clientNotes');
        $this->db->where('clientID', $clientID);
        $this->db->like('ts', date('Y-m-d', strtotime($ts)));
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }

    function getClient($id) {
        $this->db->from('clients');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }
}
