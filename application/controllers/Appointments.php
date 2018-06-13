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
        foreach($app as $k => $val)
            $app[$k]['phone'] = $this->formatPhoneNumber($val['areaCode'], $val['phonePrefix'], $val['phoneLineNumber']);
        $json = json_encode($app);

        foreach($app as $k=>$val)
        {

        echo"
        <div id=appointment_{$val['appointmentID']} class='portlet' width='20px'>
        <div class='portlet-header'>{$val['clientFirstName']} {$val['clientLastName']}</div>
        <div class='portlet-content'>{$val['phone']}<br>{$val['appointmentType']}</div>
        </div>
        ";
        }
        //  $this->dump_array($app);
//        echo $json;
        echo"<script>
        
          $( '.portlet' )
          .addClass( 'ui-widget ui-widget-content ui-helper-clearfix ui-corner-all' )
          .find( '.portlet-header' )
            .addClass( 'ui-widget-header ui-corner-all' )
            .prepend( '<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>');
        </script>
        ";
    }
}
