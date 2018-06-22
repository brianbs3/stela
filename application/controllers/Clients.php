<?php
require_once('Stela.php');
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
class Clients extends Stela
{
    public function index()
    {
        $this->load->model('clients_model');
        $c = $this->clients_model->get_clients();
        $this->dump_array($c);
        echo "clients";
    }

    public function clientList()
    {
//        echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-whatever=\"@mdo\">Open modal for @mdo</button>";
//        echo "
//    <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
//      <div class='modal-dialog' role='document'>
//        <div class='modal-content'>
//          <div class='modal-header'>
//            <h5 class='modal-title' id='exampleModalLabel'>New message</h5>
//            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
//              <span aria-hidden='true'>&times;</span>
//            </button>
//          </div>
//          <div class='modal-body'>
//            <form>
//              <div class='form-group'>
//                <label for='firstName' class='col-form-label'>First Name</label>
//                <input type='text' class='form-control' id='firstName'>
//              </div>
//              <div class='form-group'>
//                <label for='message-text' class='col-form-label'>Message:</label>
//                <textarea class='form-control' id='message-text'></textarea>
//              </div>
//            </form>
//          </div>
//          <div class='modal-footer'>
//            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
//            <button type='button' class='btn btn-primary'>Send message</button>
//          </div>
//        </div>
//      </div>
//    </div>
//
//
//    <div class='modal fade' id='notesModal' tabindex='-1' role='dialog' aria-labelledby='notesModalLabel' aria-hidden='true'>
//      <div class='modal-dialog' role='document'>
//        <div class='modal-content'>
//          <div class='modal-header'>
//            <h5 class='modal-title' id='notesModalLabel'>New message</h5>
//            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
//              <span aria-hidden='true'>&times;</span>
//            </button>
//          </div>
//          <div class='modal-body'>
//            <form>
//              <div class='form-group'>
//                <label for='firstName' class='col-form-label'>First Name</label>
//                <input type='text' class='form-control' id='firstName'>
//              </div>
//              <div class='form-group'>
//                <label for='message-text' class='col-form-label'>Message:</label>
//                <textarea class='form-control' id='message-text'></textarea>
//              </div>
//            </form>
//          </div>
//          <div class='modal-footer'>
//            <button type='button' class='btn btn-secondary' data-dismiss='modal2'>Close</button>
//            <button type='button' class='btn btn-primary'>Send message</button>
//          </div>
//        </div>
//      </div>
//    </div>
//    ";
        $this->load->model('clients_model');
        $clients = $this->clients_model->get_clients();
        echo "
      <h1 class=clientsHeader>Clients</h1>
      <button type='button' class='btn btn-primary' id='clientAddButton' onClick='addClient()'>Add Client</button>
      <br><br>
      <table class='table table-striped'>
        <thead class='thead-dark'>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Notes</th>
            <th scope='col'>First</th>
            <th scope='col'>Last</th>
            <th scope='col'>Email</th>
            <th scope='col'>Address 1</th>
            <th scope='col'>Address 2</th>
            <th scope='col'>City</th>
            <th scope='col'>State</th>
            <th scope='col'>Zip</th>
            <th scope='col'>Phone</th>
            <th scope='col'>Email Promotion</th>
            <th scope='col'>Text Promotion</th>
            <th scope='col'>Appointment Reminder</th>
          </tr>
        </thead>
      <tbody>
    ";
        foreach ($clients as $c) {
            $barcode = urlencode("{$c['firstName']} {$c['lastName']}");
            echo "
        <tr>
          <th scope='row'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo' id='clientEditButton_{$c['id']}'>Edit</button>
          <th scope='row'><button type='button' class='btn btn-primary' onClick=\"showClientNotes({$c['id']})\" id='clientNotesButton_{$c['id']}'>Notes</button></th>
          <td>{$c['firstName']}</td>
          <td>{$c['lastName']}</td>
          <td>{$c['email']}</td>
          <td>{$c['address1']}</td>
          <td>{$c['address2']}</td>
          <td>{$c['city']}</td>
          <td>{$c['state']}</td>
          <td>{$c['zip']}</td>
          <td>{$this->formatPhoneNumber($c['areaCode'], $c['phonePrefix'], $c['phoneLineNumber'])}</td>
          <td>{$this->bool2txt($c['promotionEmail'])}</td>
          <td>{$this->bool2txt($c['promotionText'])}</td>
          <td>{$this->bool2txt($c['appointmentAlert'])}</td>
        </tr>
      ";
        }
        echo " 
      </tbody>
    </table>
    
    <script>
      $('#exampleModal').on('show.bs.modal', function (event) {
      alert('hello1');
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          console.log(recipient)
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)
    
          modal.find('.modal-title').text('New message to ' + recipient)
          modal.find('.modal-body input').val(recipient)
       })
        $('#notesModal').on('show.bs.modal', function (event) {
        alert('hello2');
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          console.log(recipient)
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal2 = $(this)
    
          modal2.find('.modal-title').text('New message to ' + recipient)
          modal2.find('.modal-body input').val(recipient)
       })
</script>
    ";
    }

    public function clientsPDF()
    {
        $this->load->model('clients_model');
        $clients = $this->clients_model->get_clients();
        $this->dump_array($clients);
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
        $pdf->AddPage();
        $tbl = "
      <table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
      <thead>
       <tr style=\"background-color:#000000;color:#FFFFFF;\">
        <td width=\"10%\" align=\"center\">First Name</td>
        <td width=\"10%\" align=\"center\">Last Name</td>
        <td width=\"20%\" align=\"center\">Address</td>
        <td width=\"10%\"  align=\"center\">City</td>
        <td width=\"5%\" align=\"center\">State</td>
        <td width=\"7%\" align=\"center\">Zip</td>
        <td width=\"12%\" align=\"center\">Phone</td>
        <td width=\"25%\" align=\"center\">Email</td>
       </tr>
      </thead>
    ";
        foreach ($clients as $c) {
            $tbl .= "
        <tr>
          <td width=\"10%\" align=\"center\">{$c['firstName']}</td>
          <td width=\"10%\" align=\"center\">{$c['lastName']}</td>
          <td width=\"20%\" align=\"center\">{$c['address1']}</td>
          <td width=\"10%\" align=\"center\">{$c['city']}</td>
          <td width=\"5%\" align=\"center\">{$c['state']}</td>
          <td width=\"7%\" align=\"center\">{$c['zip']}</td>
          <td width=\"12%\" align=\"center\">{$this->formatPhoneNumber($c['areaCode'],$c['phonePrefix'],$c['phoneLineNumber'])}</td>
          <td width=\"25%\" align=\"center\">{$c['email']}</td>
        </tr>
      ";
        }
        $tbl .= "
      </table>
    ";
        $pdf->writeHTML($tbl, true, false, false, false, '');
        ob_clean();
        $pdf->Output('my_test.pdf', 'I');
    }


    public function getClientNotes()
    {
        $this->load->model('clients_model');
        $id = $this->input->get('id', true);
        $notes = $this->clients_model->getClientNotes($id);
        $nArr = array();
        if(isset($notes[0])) {
            $nArr['firstName'] = $notes[0]['firstName'];
            $nArr['lastName'] = $notes[0]['lastName'];
        }
        $nArr['notes'] = array();
        foreach($notes as $n)
            $nArr['notes'][] = array('note' => $n['note'], 'ts' => $n['ts']);

//        $this->dump_array($nArr);
        echo json_encode($nArr);

    }

    public function addClientNote() {
        $clientId = $this->input->post('clientId');
        $note = $this->input->post('note');
        $noteArr = array(
            'clientId' => $clientId,
            'note' => $note
        );

        $this->load->model('clients_model');
        $insert = $this->clients_model->addClientNote($noteArr);
        $noteArr['insert'] = $insert;
        echo json_encode($noteArr);
    }

    public function generateClientForm($data = null){
        echo"
            <table class='table table-striped' id=clientFormTable border=1>
            <thead class='thead-dark'><th> </th><th> </th></thead>
            <form id=clientForm>
                <tr>
                    <td>First Name</td>
                    <td><input type=text name=firstName placeholder='First Name'></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type=text name=lastName placeholder='Last Name'></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>( <input type=text name=areaCode maxlength='3' size='3'> )<input type=text name=phonePrefix maxlength='3' size='3'> - <input type=text name=lineNumber maxlength='4' size='4'>  &nbsp; &nbsp; Text Reminder: <input type=checkbox name=textReminder></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type=text name=clientEmail
                </tr>
            </form>
            </table>
        ";
    }

    function processClientForm()
    {
        $client = $this->input->post('test2', true);
        $test = $this->input->post('test', true);
        echo"test: $test";
        $this->dump_array($_POST);
    }

}


// <td><img src=/stela/index.php/Barcode?code=$barcode></td>
