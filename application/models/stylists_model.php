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
}