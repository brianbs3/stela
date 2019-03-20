<?php
require_once('Stela.php');

class Elec extends Stela
{
    public function index()
    {
        $this->load->model('elec_model');
        // $c = $this->appointments_model->get_appointments();
        //    $this->dump_array($c);

        $panels = $this->elec_model->get_panels();
        $this->dump_array($panels);

    }

    public function drawPanel($id=0){
        $this->load->model('elec_model');
        if($id == 0)
            $id = $this->input->get('id', true);

        $panel_deets = $this->elec_model->get_panel_details($id);
        $cs = $this->elec_model->get_panel_circuits($id);
        $circuits = array();
        foreach($cs as $c){
           $circuits[$c['number']] = $c;
        }
        $rows = $panel_deets[0]['totalSlots'] / $panel_deets[0]['sides'];
        echo"
            <table border=1>
        ";
        $c = 1;

        for($i = 0; $i < $rows; $i++) {
            $txt = (isset($circuits[$c])) ? $circuits[$c]['notes'] : 'nope';
            echo "
                <tr><td>". $txt . " " . $c++ ."</td><td>" . $txt . " " . $c++ . "</td></tr>
            ";
        }
        echo"</table>";

        $this->dump_array($circuits);
    }


}
