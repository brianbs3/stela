<?php
require_once('Stela.php');



class Appointments extends Stela {
    public function index()
    {
        $this->load->model('appointments_model');
        // $c = $this->appointments_model->get_appointments();
        //    $this->dump_array($c);


        $data['stylists'] = $this->getStylistsWithBooth();

        $this->load->view('appointments', $data);
    }

    public function getStylistsWithBooth()
    {
        $this->load->model('stylists_model');
        $c = $this->stylists_model->getStylistsWithBooth();
        return $c;
    }

    public function getAppointmentsForDay()
    {
        $date = $this->input->get('date');
        $this->load->model('appointments_model');
        $app = $this->appointments_model->getAppointmentsForDay($date);
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
        $startTime = date('g:i A', strtotime($val['ts']));
        $chunks = 15 * $val['appointmentDuration'];
        $endTime = date('g:i A', strtotime("+$chunks minutes", strtotime($startTime)));
        echo"
        <div id=appointment_{$val['appointmentID']} axis='{$checkInAxis}' class='portlet appointmentPortlet {$checkInClass}' width='20px'>
            <div class='portlet-header'>{$val['clientFirstName']} {$val['clientLastName']} 
                &nbsp;<span id=checkin_{$val['appointmentID']} onClick=\"checkIn({$val['appointmentID']})\" class=\"ui-icon {$checkClass}\">icon</span> 
                <span id=checkin_notes_{$val['clientID']} onClick=\"showClientNotes({$val['clientID']})\" class=\"ui-icon  ui-icon-pencil\">icon</span>
            </div>
            <div class='portlet-content'>{$val['phone']}<br>{$val['appointmentType']}
            <br>
                Appt Start: $startTime<br>
                Appt End: $endTime<br>
                <input type='hidden' id=appointment_{$val['appointmentID']}_time value='${val['ts']}'>
                <input type='hidden' id=appointment_{$val['appointmentID']}_stylist value='${val['stylistID']}'>
                <input type='hidden' id=appointment_{$val['appointmentID']}_duration value='${val['appointmentDuration']}'>
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
        else if(intval($val) === 0) {
            $data['checkInTime'] = '0000-00-00 00:00:00';
            $data['checkOutTime'] = '0000-00-00 00:00:00';
        }

        if($id && $data) {
            $insert = $this->appointments_model->updateCheckIn($id, $data);
            $data['insert'] = $insert;
        }
        echo json_encode($data);
    }

    public function newAppointmentForm(){
        $this->load->model('stylists_model');
        $this->load->model('clients_model');
        $stylistId = $this->input->get('stylistId', true); 
        $chunk = $this->input->get('chunk', true); 
        $date = $this->input->get('date', true); 
        $stylistInfoArr = $this->stylists_model->getStylistInfoById($stylistId);
        $clients = $this->clients_model->getSortedClients();
        if(isset($stylistInfoArr[0]))
            $s = $stylistInfoArr[0];
        else
            die('error getting info for stylist');
        $timeArr = explode('_', $chunk);
        $time = "{$timeArr[0]}:{$timeArr[1]} {$timeArr[2]}";
    
        echo"<form id='newAppointmentForm'>";
        echo"<table border=1>
                <tr>
                    <td>Stylist</td><td>{$s['firstName']} {$s['lastName']}</td>
                </tr> <tr>
                    <td>Client:</td><td>
                <select id=newAppointmentClient name=newAppointmentClient>
        ";
        foreach($clients as $c){
            echo"<option value={$c['id']}>{$c['firstName']} {$c['lastName']}</option>";
        }
        echo"
                        </select>
                    </td>
                </tr><tr>
                    <td>Date: </td><td><input name=newAppointmentDate value='$date'></td>
                </tr><tr>
                    <td>Service: </td>
                    <td><input type=text name=newAppointmentType></td> 
                </tr><tr>
                    <td>Time: </td><td><input name=newAppointmentTime value='$time'></td> 
                </tr><tr>
                    <td>Duration (minutes):</td>
                    <td>
                        <select id=newAppointmentDuration name=newAppointmentDuration>
        ";
        for($i = 1; $i < 20; $i++){
            $opt = $i * 15;
            echo"<option value=$i>$opt</option>";
        }
        echo"
                    </td>
                </tr>
            </table>
            <input type=hidden name=stylistId value=$stylistId>
        </form>
        ";
    }
    function newAppointment() {
        $this->load->model('appointments_model');
        $form = $this->input->post('form', true);
        $date = $this->input->post('date', true);
        $appt = array();
        foreach($form as $f) {
            switch($f['name']){
                case "newAppointmentClient":
                    $appt['clientID'] = $f['value'];
                    break;
                case "newAppointmentTime":
                    $t = $f['value'];
                    break;
                case "newAppointmentDuration":
                    $appt['appointmentDuration'] = $f['value'];
                    break;
                case "stylistId":
                    $appt['stylistID'] = $f['value'];
                    break;
                case "newAppointmentType":
                    $appt['appointmentType'] = $f['value'];
                    break;
            }
            
        }

        $appt['appointmentTS'] = "$date $t";

        $newAppt = $this->appointments_model->newAppointment($appt);
        if($newAppt)
            echo json_encode($appt);
    }

    function getCheckinStatus()
    {
        $this->load->model('appointments_model');
        $id = $this->input->get('id', true);
        $return = array(
            'id' => $id
        );
        $status = $this->appointments_model->getCheckinStatus($id);
        $return ['status'] = $status;
        echo json_encode($return);
    }

    public function checkoutReceipt()
    {
        $apptID = $this->input->get('id', true);
        echo"
            <table border=1>
            <tbody>
                <tr>
                    <td>Product Cost: </td>
                    <td><input type=text name=productCost id=appointmentReceiptProductCost></td>
                </tr>
                <tr>
                    <td>Service Cost: </td>
                    <td><input type=text name=serviceCost id=appointmentReceiptServiceCost></td>
                </tr>
            </tbody>
            </table>
            <input type=hidden name=appointmentID id=appointmentReceiptID value=$apptID>
            <div id='appointmentReceiptPDFDiv'></div>
        ";
    }
}
