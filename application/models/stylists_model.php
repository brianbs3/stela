<?php

class Stylists_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getStylists()
    {
        $this->db->from('stylists');
        $query = $this->db->get();
        if ($query)
            return $query->result_array();
        return null;
    }

    function getStylistInfoById($id)
    {
        $this->db->from('stylists');
        $this->db->select('firstName, lastName, id');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query)
          return $query->result_array();
        return null;
    }

    function getStylistsWithBooth()
    {
        $this->db->from('stylists');
        $this->db->where('hasBooth', 1);
        $query = $this->db->get();
        if ($query)
          return $query->result_array();
        return null;

    }
}
