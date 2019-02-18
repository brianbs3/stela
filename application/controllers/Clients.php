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
            <th scope='col'>Profile</th>
            <th scope='col'>First</th>
            <th scope='col'>Last</th>
            <th scope='col'>DOB</th>
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
            $dob = $this->format_dob($c['birthMonth'], $c['birthDay'], $c['birthYear']);
            echo "
        <tr>
          <th scope='row'><button type='button' class='btn btn-primary' class='clientEditButton' onClick='editClient(\"{$c['id']}\")'>Edit</button>
          <th scope='row'><button type='button' class='btn btn-primary' onClick=\"showClientNotes({$c['id']})\" id='clientNotesButton_{$c['id']}'>Notes</button></th>
          <th scope='row'><button type='button' class='btn btn-primary' onClick=\"editClientProfile({$c['id']})\" id='clientProfileButton_{$c['id']}'>Profile</button></th>
          <td>{$c['firstName']}</td>
          <td>{$c['lastName']}</td>
          <td>{$dob}</td>
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
        $this->load->model('clients_model');
        $clientID = $this->input->get('clientID', true);
        $c = $this->setupBlankClientArray();
        $existing = false;
        if($clientID)
            $client = $this->clients_model->getClient($clientID);
        if(isset($client)){
            $c = $client[0];
            $existing = true;
            unset($client);
        }
        $textReminder = ($c['appointmentAlert']) ? 'checked' : '';
        $promotionEmail = ($c['promotionEmail']) ? 'checked' : '';
        $promotionText = ($c['promotionText']) ? 'checked' : '';
        echo"
        <form id=clientForm>
            <table class='table table-striped' id=clientFormTable border=1>
            <thead class='thead-dark'><th> </th><th> </th></thead>

            <input id=clientFormClientID type=hidden value='{$clientID}' name=id>
                <tr>
                    <td>First Name</td>
                    <td><input  value='{$c['firstName']}' type=text name=firstName placeholder='First Name'></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type=text value='{$c['lastName']}' name=lastName placeholder='Last Name'></td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td>
                        <input type='text' value='{$c['birthMonth']}' name='birthMonth' placeholder='MM' size='2'>
                        <input type='text' value='{$c['birthDay']}' name='birthDay' placeholder='DD' size='2'>
                        <input type='text' value='{$c['birthYear']}' name='birthYear' placeholder='YYYY' size='4'>
                    </td>
                </tr>
                <tr>
                    <td>Address</td><td><input type=text value='{$c['address1']}' name=address1 placeholder='Address'><br><input type=text value='{$c['city']}' name=city placeholder='City'> <input type=text size=4 value='{$c['state']}' placeholder='State' name=state><input type=text size=10 value='{$c['zip']}' placeholder='Zip' name=zip></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>( <input type=text value='{$c['areaCode']}' name=areaCode maxlength='3' size='3'> )<input type=text value='{$c['phonePrefix']}' name=phonePrefix maxlength='3' size='3'> - <input type=text value='{$c['phoneLineNumber']}' name=phoneLineNumber maxlength='4' size='4'></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type=text name=email value='{$c['email']}' size=50>
                </tr>
                <tr>
                    <td>Alerts</td>
                    <td>
                    Text Reminder: <input type=checkbox name=appointmentAlert $textReminder>
                    &nbsp;&nbsp;Email Promotion: <input type=checkbox name=promotionEmail $promotionEmail>
                    &nbsp;&nbsp;Text Promotion: <input type=checkbox name=promotionText $promotionText>
                    </td>
                </tr>

            </table>
            </form>
            <script>setupBirthDateInput();</script>
        ";
    }

    function setupBlankClientArray() {
        $c = array(
            'firstName' => '',
            'lastName' => '',
            'address1' => '',
            'address2' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'areaCode' => '',
            'phonePrefix' => '',
            'phoneLineNumber' => '',
            'promotionEmail' => '',
            'promotionText' => '',
            'appointmentAlert' => '',
            'email' => null,
            'birthMonth' => '',
            'birthDay' => '',
            'birthYear' => ''
        );

        return $c;
    }

    function processClientForm()
    {
        $this->load->model('clients_model');
        $clientForm = $this->input->post('clientForm', true);
        $client = array();
        foreach($clientForm as $c)
            $client[$c['name']] = $c['value'];
        $client['appointmentAlert'] = (isset($client['appointmentAlert']) && $client['appointmentAlert'] === 'on') ? 1 : 0;
        $client['promotionEmail'] = (isset($client['promotionEmail']) && $client['promotionEmail'] === 'on') ? 1 : 0;
        $client['promotionText'] = (isset($client['promotionText']) && $client['promotionText'] === 'on') ? 1 : 0;
        $upsert = $this->clients_model->upsertClient($client);
        $existing = ($client['id']) ? true : false;
        $return = array(
            'existing' => $existing,
            'insertID' => $upsert['id'], 
            'insertStatus' => $upsert['result'],
            'client' => $client
        ); 
        echo json_encode($return);
    }

    public function clientSearchJson(){
        $term = $this->input->get('term', true);

        echo json_encode($result);
    }

    public function generateClientProfileForm($data = null){
        $this->load->model('clients_model');
        $clientID = $this->input->get('clientID', true);
        $c = $this->setupBlankClientProfileArray();
        $existing = false;
        if($clientID)
            $client = $this->clients_model->getClientProfile($clientID);

        if(isset($client[0])){
            $c = $client[0];
            $existing = true;
            unset($client);
        }
        $sunSensitiveMedsYes = ($c['sunSensitiveMeds']) ? 'checked' : '';
        $sunSensitiveMedsNo = ($c['sunSensitiveMeds']) ? '' : 'checked';

        $allergicSunlightYes = ($c['allergicSunlight']) ? 'checked' : '';
        $allergicSunlightNo = ($c['allergicSunlight']) ? '' : 'checked';

        $colorHairYes = ($c['colorHair']) ? 'checked' : '';
        $colorHairNo = ($c['colorHair']) ? '' : 'checked';

        $tanEasilyYes = ($c['tanEasily']) ? 'checked' : '';
        $tanEasilyNo = ($c['tanEasily']) ? '' : 'checked';

        $skinTypeOily = ($c['skinType']  == 'oily') ? 'checked' : '';
        $skinTypeDry = ($c['skinType'] == 'dry') ? 'checked' : '';
        $skinTypeNone = ($c['skinType'] !== 'dry' && $c['skinType'] !== 'oily') ? 'checked' : '';

        $freckleYes = ($c['freckle']) ? 'checked' : '';
        $freckleNo = ($c['freckle']) ? '' : 'checked';

        $participateOutoorsYes = ($c['participateOutoors']) ? 'checked' : '';
        $participateOutoorsNo = ($c['participateOutoors']) ? '' : 'checked';

        $useMoisturizerLotionYes = ($c['useMoisturizerLotion']) ? 'checked' : '';
        $useMoisturizerLotionNo = ($c['useMoisturizerLotion']) ? '' : 'checked';

        echo"
        <form id=clientProfileForm>
            <table class='table table-striped' id=clientProfileFormTable border=1>
            <thead class='thead-dark'><th> </th><th> </th></thead>

            <input id=clientProfileFormClientID name=clientID type=hidden value='{$clientID}' name=id>
                <tr>
                    <td>Occupation: &nbsp;&nbsp;&nbsp;&nbsp; <input  value='{$c['occupation']}' type=text name=occupation placeholder='Occupation'></td>
                    <td>Employer: &nbsp;&nbsp;&nbsp;&nbsp; <input  value='{$c['employer']}' type=text name=employer placeholder='Employer'></td>
                    
                </tr>
                <tr>
                    <td>Are you taking any Medication which would cause sensitivity to sunlight?</td>
                    <td>
                        Yes <input value=yes type=radio name=sunSensitiveMeds $sunSensitiveMedsYes>
                        No <input value=no type=radio name=sunSensitiveMeds $sunSensitiveMedsNo>
                    </td>
                </tr>
                 <tr>
                    <td>Do you have any known allergic reaction to sunlight?</td>
                    <td>
                        Yes <input value=yes type=radio name=allergicSunlight $allergicSunlightYes>
                        No <input value=no type=radio name=allergicSunlight $allergicSunlightNo>
                    </td>
                </tr>
                <tr>
                    <td>Do you color your hair? &nbsp;&nbsp;&nbsp;&nbsp;
                    
                        Yes <input value=yes type=radio name=colorHair $colorHairYes>
                        No <input value=no type=radio name=colorHair $colorHairNo>
                    </td>
                    <td>Natural Hair Color: &nbsp;&nbsp;&nbsp;&nbsp; <input  value='{$c['naturalHairColor']}' type=text name=naturalHairColor placeholder='Natural Hair Color'></td>
                </tr>
                 <tr>
                    <td>Do you tan easily?</td>
                    <td>
                        Yes <input value=yes type=radio name=tanEasily $tanEasilyYes>
                        No <input value=no type=radio name=tanEasily $tanEasilyNo>
                    </td>
                </tr>
                 <tr>
                    <td>How would you best describe your skin?</td>
                    <td>
                        Oily <input value=oily type=radio name=skinType $skinTypeOily>
                        Dry <input value=dry type=radio name=skinType $skinTypeDry>
                        None <input value=none type=radio name=skinType $skinTypeNone>
                    </td>
                </tr>
                <tr>
                    <td>Do you have a tendency to freckle?</td>
                    <td>
                        Yes <input value=yes type=radio name=freckle $freckleYes>
                        No <input value=no type=radio name=freckle $freckleNo>
                    </td>
                </tr>
                <tr>
                    <td>What is your average exposure to sunlight on a daily basis?  (in hours)</td>
                    <td><input value='{$c['avgDailySunExposure']}' type=text name=avgDailySunExposure placeholder='Daily Sun Exposure (hrs)'></td>
                </tr>
                <tr>
                    <td>Do you participate in outdoor activities on a regular basis?</td>
                    <td>
                        Yes <input value=yes type=radio name=participateOutoors $participateOutoorsYes>
                        No <input value=no type=radio name=participateOutoors $participateOutoorsNo>
                    </td>
                </tr>
                <tr>
                    <td>Are you presently using a moisturizer or lotion?</td>
                    <td>
                        Yes <input value=yes type=radio name=useMoisturizerLotion $useMoisturizerLotionYes>
                        No <input value=no type=radio name=useMoisturizerLotion $useMoisturizerLotionNo>
                    </td>
                </tr>
                <tr>
                    <td>Allergies</td>
                    <td><input value='{$c['allergies']}' type=text name=allergies placeholder='Allergies'></td>
                </tr>
                <tr>
                    <td>Hair Products Used</td>
                    <td><input value='{$c['hairProductsUsed']}' type=text name=hairProductsUsed placeholder='Hair Products Used'></td>
                </tr>
                 <tr>
                    <td>Hair Condition Rating (1-10) &nbsp;&nbsp;&nbsp;&nbsp; <input value='{$c['hairConditionRating']}' type=text name=hairConditionRating placeholder='Hair Condition'></td>
                    <td>Comments: <input value='{$c['hairConditionRatingComments']}' type=text name=hairConditionRatingComments placeholder='Comments'></td>
                </tr>
                <tr>
                    <td>Client Remarks</td>
                    <td><textarea name='clientRemarks' value='{$c['clientRemarks']}' cols='50' rows='5'></textarea></td>
                </tr>
                <tr>
                    <td>Referred By</td>
                    <td><input value='{$c['referredBy']}' type=text name=referredBy placeholder='Referred By'></td>
                </tr>
                
                <tr><td colspan='2'>
                <b>For your health and safety, you MUST always use Protective Eyewear.  The use of the TANNING UNIT without protective eyewear can cause the early formation of cataracts and/or temporary or permanent blindness.</b>
                </td></tr>
                ";

        echo"
            </table>
            </form>
            <div id=clientProfilePDF>PDF HERE</div>
        ";
    }

    function setupBlankClientProfileArray() {
        $c = array(
            'occupation' => '',
            'employer' => '',
            'sunSensitiveMeds' => '',
            'allergicSunlight' => '',
            'colorHair' => '',
            'naturalHairColor' => '',
            'tanEasily' => '',
            'skinType' => '',
            'freckle' => '',
            'avgDailySunExposure' => '',
            'participateOutoors' => '',
            'useMoisturizerLotion' => '',
            'allergies' => '',
            'hairProductsUsed' => '',
            'referredBy' => '',
            'clientRemarks' => '',
            'hairConditionRating' => '',
            'hairConditionRatingComments' => ''
        );

        return $c;
    }

    function processClientProfileForm()
    {
        $this->load->model('clients_model');
        $clientForm = $this->input->post('clientProfileForm', true);

        $client = array();
        foreach($clientForm as $c)
            $client[$c['name']] = $c['value'];

        $upsert = $this->clients_model->upsertClientProfile($client);
        $existing = ($client['clientID']) ? true : false;
        $return = array(
            'existing' => $existing,
            'insertID' => $upsert['id'],
            'insertStatus' => $upsert['result'],
            'client' => $client
        );
        echo json_encode($return);
    }

}


// <td><img src=/stela/index.php/Barcode?code=$barcode></td>
