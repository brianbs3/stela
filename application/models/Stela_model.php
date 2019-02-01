<?php

class Stela_model extends CI_Model {

    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }

    function getInspirationCount(){
        $query = "SELECT COUNT(*) AS c FROM inspirations";
        $result = $this->db->query($query);
        if($result)
            return $result->result_array();
    }

    function getInspiration($id){
        $this->db->from('inspirations');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }
}
