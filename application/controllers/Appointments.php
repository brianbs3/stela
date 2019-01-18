<?php
require_once('Stela.php');



class Appointments extends Stela {
    public function index()
    {
        $this->load->model('appointments_model');
        // $c = $this->appointments_model->get_appointments();
        //    $this->dump_array($c);


        $data['stylists'] = $this->getStylists();

        $this->load->view('appointments', $data);
    }

    public function getAppointmentsForDay()
    {
        $date = $this->input->get('date');
        $this->load->model('appointments_model');
        $app = $this->appointments_model->getAppointmentsForDay($date);
$this->dump_array($app);
        foreach($app as $k => $val)
            $app[$k]['phone'] = $this->formatPhoneNumber($val['areaCode'], $val['phonePrefix'], $val['phoneLineNumber']);
        $json = json_encode($app);

        foreach($app as $k=>$val)
        {
            $checkedInVal = intval($val['checkedIn']);
            $checkInClass = '';
            $checkClass = 'ui-icon-check';
            $checkInAxis = 'notCheckedIn';
            if($checkedInVal === 1) {
                $checkInClass = 'appointmentCheckedIn';
                $checkClass = 'ui-icon-circle-check';
                $checkInAxis = 'checkedIn';
            }
            else if($checkedInVal === 2) {
                $checkInClass = 'appointmentCheckedOut';
                $checkClass = 'ui-icon-locked';
                $checkInAxis = 'checkedOut';
            }
        echo"
        <div id=appointment_{$val['appointmentID']} axis='{$checkInAxis}' class='portlet appointmentPortlet' width='20px'>
        <div class='portlet-header'>{$val['clientFirstName']} {$val['clientLastName']} 
            &nbsp;<span id=checkin_{$val['appointmentID']} onClick=\"checkIn({$val['appointmentID']})\" class=\"ui-icon {$checkClass}\">icon</span> 
            <span id=checkin_notes_{$val['clientID']} onClick=\"showClientNotes({$val['clientID']})\" class=\"ui-icon  ui-icon-pencil\">icon</span></div>
            <div class='portlet-content  {$checkInClass}'>{$val['phone']}<br>{$val['appointmentType']}
            <input type='hidden' id=appointment_{$val['appointmentID']}_time value='${val['ts']}'>
            <input type='hidden' id=appointment_{$val['appointmentID']}_stylist value='${val['stylistID']}'>
            ";
            echo"
            </div>
        </div>
        ";
        }
    }

    public function updateCheckIn(){
        /*
         * Not Checked In => 0
         * Checked In => 1
         * Checked Out => 2
         */
        $this->load->model('appointments_model');
        $id = $this->input->get('id');
        $val = $this->input->get('checkinVal');

        $data = array('checkedIn' => $val);
        if(intval($val) === 1){
            $data['checkInTime'] = date('Y-m-d H:i:s');
        }
        else if(intval($val) === 2){
            $data['checkOutTime'] = date('Y-m-d H:i:s');
        }

        if($id && $data) {
            $insert = $this->appointments_model->updateCheckIn($id, $data);
            $data['insert'] = $insert;
        }
        echo json_encode($data);



    }
}
