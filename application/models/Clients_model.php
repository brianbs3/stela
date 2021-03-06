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
        $this->db->from('notes_view');
        $this->db->where('clientID', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }
  
    function addClientNote($d) {
        $insert = $this->db->insert('client_notes', $d);
        return $insert;
    }
  
    function getNotesForAppointment($ts, $clientID) {
        $this->db->from('client_notes');
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

    function getClientProfile($id){
        $this->db->from('client_data_profile');
        $this->db->where('clientID', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }

    function getFullClientProfile($id){
        $this->db->from('clients');
        $this->db->join('client_data_profile', 'clients.id = client_data_profile.clientID');
        $this->db->where('clientID', $id);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
        return null;
    }

    function upsertClient($data) {
        $query = $this->db->insert_string('clients', $data);
        $query .= " ON DUPLICATE KEY UPDATE 
            firstName = '{$data['firstName']}',
            lastName = '{$data['lastName']}',
            address1 = '{$data['address1']}',
            city = '{$data['city']}',
            state = '{$data['state']}',
            zip = '{$data['zip']}',
            areaCode = '{$data['areaCode']}',
            phonePrefix = '{$data['phonePrefix']}',
            phoneLineNumber = '{$data['phoneLineNumber']}',
            promotionEmail = '{$data['promotionEmail']}',
            promotionText = '{$data['promotionText']}',
            appointmentAlert = '{$data['appointmentAlert']}',
            email = '{$data['email']}',
            birthMonth = '{$data['birthMonth']}',
            birthDay = '{$data['birthDay']}',
            birthYear = '{$data['birthYear']}',
            signedDate = '{$data['signedDate']}'
        ";

        $result = $this->db->query($query);
        $id =  $this->db->insert_id();
        return array('result'=>$result, 'id' => $id);

    }
    function upsertClientProfile($data) {
        $query = $this->db->insert_string('client_data_profile', $data);
        $query .= " ON DUPLICATE KEY UPDATE 
            occupation = '{$data['occupation']}',
            employer = '{$data['employer']}',
            sunSensitiveMeds = '{$data['sunSensitiveMeds']}',
            allergicSunlight = '{$data['allergicSunlight']}',
            colorHair = '{$data['colorHair']}',
            naturalHairColor = '{$data['naturalHairColor']}',
            tanEasily = '{$data['tanEasily']}',
            skinType = '{$data['skinType']}',
            freckle = '{$data['freckle']}',
            avgDailySunExposure = '{$data['avgDailySunExposure']}',
            participateOutoors = '{$data['participateOutoors']}',
            useMoisturizerLotion = '{$data['useMoisturizerLotion']}'
        ";

        $result = $this->db->query($query);
        $id =  $this->db->insert_id();
        return array('result'=>$result, 'id' => $id);

    }

    function clientSearch($term) {
        $this->db->from('clients');
        $this->db->or_like('firstName', $term);
        $this->db->or_like('lastName', $term);
        $this->db->or_like('areaCode', $term);
        $this->db->or_like('phonePrefix', $term);
        $this->db->or_like('phoneLineNumber', $term);
        $query = $this->db->get();
        if($query)
            return $query->result_array();
    }
}
