<?php

class Elec_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_panels()
    {
        $this->db->from('elec_panels');
        $query = $this->db->get();
        if ($query)
            return $query->result_array();
        return null;
    }

    function get_panel_details($id){
        $this->db->from('elec_panels');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query)
            return $query->result_array();
        return null;
    }

    function get_panel_circuits($id){
        $this->db->from('elec_circuits');
        $this->db->where('panelID', $id);
        $query = $this->db->get();
        if ($query)
            return $query->result_array();
        return null;
    }
}