<?php
require('Stela.php');
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
class PDF extends Stela {
  public function index()
  {
    echo"PDF";
  }

  public function font_test()
  {

    //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
    $pdf->AddPage();

    $fonts = array(
        'aealarabiya',
        'aefurat',
        'cid0cs',
        'cid0ct',
        'cid0jp',
        'cid0kr',
        'courier',
        'dejavusansbi',
        'dejavusansb',
        'dejavusanscondensedbi',
        'dejavusanscondensedb',
        'dejavusanscondensedi',
        'dejavusanscondensed',
        'dejavusansextralight',
        'dejavusansi',
        'dejavusansmonobi',
        'dejavusansmonob',
        'dejavusansmonoi',
        'dejavusansmono',
        'dejavusans',
        'dejavuserifbi',
        'dejavuserifb',
        'dejavuserifcondensedbi',
        'dejavuserifcondensedb',
        'dejavuserifcondensedi',
        'dejavuserifcondensed',
        'dejavuserifi',
        'dejavuserif',
        'freemonobi',
        'freemonob',
        'freemonoi',
        'freemono',
        'freesansbi',
        'freesansb',
        'freesansi',
        'freesans',
        'freeserifbi',
        'freeserifb',
        'freeserifi',
        'freeserif',
        'helvetica',
        'hysmyeongjostdmedium',
        'kozgopromedium',
        'kozminproregular',
        'msungstdlight',
        'pdfacourierbi',
        'pdfacourierb',
        'pdfacourieri',
        'pdfacourier',
        'pdfahelveticabi',
        'pdfahelveticab',
        'pdfahelveticai',
        'pdfahelvetica',
        'pdfasymbol',
        'pdfatimesbi',
        'pdfatimesb',
        'pdfatimesi',
        'pdfatimes',
        'pdfazapfdingbats',
        'stsongstdlight',
        'symbol',
        'times',
        'zapfdingbats',
    );
    foreach($fonts as $f)
    {
      $pdf->SetFont($f, 'B', 8);
      $pdf->writeHTML("font: $f<br />", true, false, false, false, '');
      $tbl = "
      <table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
      <thead>
       <tr style=\"background-color:#000000;color:#FFFFFF;\">
        <td width=\"10%\" align=\"center\">First Name</td>
        <td width=\"10%\" align=\"center\">Last Name</td>
        <td width=\"40%\" align=\"center\">Address 1</td>
        <td width=\"10%\" align=\"center\">Address 2</td>
        <td width=\"10%\"  align=\"center\">City</td>
        <td  width=\"10%\" align=\"center\">State</td>
        <td  width=\"10%\" align=\"center\">Zip</td>
       </tr>
      </thead>
        <tr>
          <td width=\"10%\" align=\"center\">Brian</td>
          <td width=\"10%\" align=\"center\">Sizemore</td>
          <td width=\"40%\" align=\"center\">3025 Squire Boone Trl</td>
          <td width=\"10%\"  align=\"center\"></td>
          <td width=\"10%\" align=\"center\">Boonville</td>
          <td width=\"10%\" align=\"center\">NC</td>
          <td width=\"10%\" align=\"center\">27011</td>
        </tr>
      </table>
      <br>
      <br>
      ";
      $pdf->writeHTML($tbl, true, false, false, false, '');
    }
    ob_clean();
    $pdf->Output('my_test.pdf', 'I');
  }


    function appointmentReceiptPDF()
    {
        $this->load->model('appointments_model');
        $this->load->model('clients_model');
        $appointmentID = $this->input->post('appointmentID', true);
        $serviceCost = $this->input->post('serviceCost', true);
        $productCost = $this->input->post('productCost', true);
        $services = $this->input->post('services', true);
        $products = $this->input->post('products', true);

        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
        $pdf->AddPage();
        //$pdf->SetFont('cid0cs', '', 8);
        //$pdf->SetFont('cid0jp', '', 10);
        //$pdf->SetFont('dejavusansb', '', 8);
        //$pdf->SetFont('dejavusansextralight', '', 8);
        //$pdf->SetFont('dejavuserifi', '', 8);
        //$pdf->SetFont('hysmyeongjostdmedium', '', 8);
        //$pdf->SetFont('kozgopromedium', '', 10);
        //$pdf->SetFont('msungstdlight', '', 8);
        //$pdf->SetFont('stsongstdlight', '', 8);
        $pdf->SetFont('times', '', 12);

        $appointmentData = $this->appointments_model->getAppointmentByID($appointmentID);
        if(isset($appointmentData[0]))
            $appt = $appointmentData[0];
        else
            die("Invalid Appointment");
        $notes = $this->clients_model->getNotesForAppointment($appt['ts'], $appt['clientID']);

        $serviceCost = 0;
        $servicesHTML = "";
        foreach($services as $s) {
            $cost = number_format($s['cost'], 2);
            $servicesHTML .= "<tr><td>{$s['service']}</td><td align=\"right\">\${$cost}</td></tr>";
            $serviceCost += $s['cost'];
        }
        $productCost = 0;
        $productsHTML = "";

        foreach($products as $p){
            $this->dump_array($p);
            $cost = number_format($p['price'] * $p['quantity'], 2);
            $p['price'] = number_format($p['price'], 2);
            $productsHTML .= "<tr><td width=\"20%\">{$p['upc']}</td><td width=\"50%\">{$p['description']}</td><td width=\"20%\">{$p['quantity']} @ \${$p['price']}</td><td width=\"10%\" align=\"right\">\${$cost}</td></tr>";
            $productCost += $cost;
        }
        $notesHTML = "";
        foreach($appt['notes'] as $n)
            $notesHTML .= "{$n['note']}<br>";
        $appt['notes'] = $notes;
        $appt['serviceCost'] = number_format($serviceCost, 2);
        $appt['productCost'] = number_format($productCost, 2);
        $appt['total'] = number_format($appt['serviceCost'] + $appt['productCost'], 2);
        $appt['checkinTime'] = date('m/d/Y - g:i:s A', strtotime($appt['checkinTime'] . " - 5 hours"));
        $appt['checkoutTime'] = date('m/d/Y - g:i:s A', strtotime($appt['checkoutTime'] . " - 5 hours"));

        $html = "
            <table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
            <tbody>
                <tr>
                    <td><h1>Inspirations Salon, LLC</h1>112 E. Main St<br>Boonville NC 27011</td>
                    <td align=\"right\">
                        Appointment #: {$appt['appointmentID']}<br>
                        <b>{$appt['clientFirstName']} {$appt['clientLastName']}</b>
                        <br>{$appt['clientAddress']}
                        <br>{$appt['clientCity']} {$appt['clientState']} &nbsp;{$appt['clientZip']}
                        <br>{$this->formatPhoneNumber($appt['areaCode'], $appt['phonePrefix'], $appt['phoneLineNumber'])}
                    </td>
                </tr>
            </tbody>
            </table>
            <hr>
            <table border=\"0\">
                <tr><td>Check In: {$appt['checkinTime']}</td><td align=\"right\"> Check Out: {$appt['checkoutTime']}</td></tr>
            </table>
            <div>
            <table border=\"0\"  cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" spacing=\"20px\">
            <tr><td><b>Services:</b></td><td align=\"right\"><b>\${$appt['serviceCost']}</b></td></tr>
            $servicesHTML
            <tr>
                <td>Notes:</td>
                <td align=\"left\">$notesHTML</td>
            </tr>
            </table>
            <div>
            <table border=\"0\"  cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" spacing=\"20px\">
            <tr><td><b>Products:</b></td><td align=\"right\"><b>\${$appt['productCost']}</b></td></tr>
            </table>
            <table border=\"0\" border-style=\"dotted\" width=\"90%\">
            $productsHTML
            </table>
            <hr style=\"border-top: dotted 1px;\">
            <table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" spacing=\"200px\">
            <tr><td><br><b>Total:</b></td><td align=\"right\"><b>\${$appt['total']}</b></td></tr>
            </table>
            </div>
        ";

        $filename = md5(time());
        $dir = "{$_SERVER['DOCUMENT_ROOT']}/stela/public/pdf";//__DIR__;
        $pdf->writeHTML($html, true, false, false, false, '');
        ob_clean();
        $pdf->Output("$dir/$filename.pdf", 'F');
        echo"<a target='_blank' href='/stela/public/pdf/$filename.pdf'>Downoad Receipt</a>";
        //echo $html;
    }

    public function productBarcodes(){
        $this->load->model('product_model');
        $products = $this->product_model->getProducts();
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAuthor('Brian Sizemore');
        $pdf->SetTitle('Shear Inspirations, LLC Client Data Profile');
        $pdf->SetSubject('Client Data Form');

        $pdf->AddPage();

        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        foreach($products as $p) {
            $y = $pdf->getY();
            $x = $pdf->getX();
            $pdf->write1DBarcode($p['upc'], 'UPCA', '', '', '', 14, 0.2, $style, 'N');
            $pdf->setX($x);
            $pdf->setY($y + 10);
            $pdf->Cell(30, 5, "", 0, 'L', 1, 0, '', '', true);
            $pdf->Cell(100, 5, "{$p['manufacturer']} - {$p['description']} : {$p['size']} = \${$p['price']}", 0, 'L', 1, 0, '', '', true);
//            $pdf->Cell(20, 5, "}", 0, 1);
            $pdf->Ln();

        }
        ob_clean();
        $pdf->Output("products.pdf", 'I');
    }

    public function clientProfileForm(){
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('Brian Sizemore');
        $pdf->SetAuthor('Brian Sizemore');
        $pdf->SetTitle('Client Profile');
        $pdf->SetSubject('Version 0.1');


        $pdf->AddPage();
        $pdf->SetMargins(1, 1, 1);
        $pdf->SetFont('dejavusansextralight', '', 10);

        $pdf->setCellMargins(1, 1, 1, 1);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->SetFillColor(255, 255, 255);
        $medLine = "_______________________";
        $shortLine = "________";
        $longLine = "__________________________________________________________________";
        $fullLine = "____________________________________________________________________________";

//        $html = '
//         <table border="1" cellpadding="1" cellspacing="0" width="100%">
//            <tbody>
//                <tr>
//                    <td>Date: '.$medLine.'</td><td align="right">Birthdate: '.$medLine.'</td>
//                </tr>
//            </tbody>
//        </table>
//        ';

        $pdf->MultiCell(80, 5, "Date: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(80, 5, "Birthdate: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->MultiCell(80, 5, "Name: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(80, 5, "Phone: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "Address: $longLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(80, 5, "City: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(40, 5, "State: $shortLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(40, 5, "Zip: $shortLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(80, 5, "Occupation: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(80, 5, "Employer: $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "Allergies: $longLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "Common hair care products used: (shampoo, spray, gel, etc.) $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "$fullLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "Referred by: $longLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "Client Remarks: $longLine", 0, 'L', 1, 0, '', '', true);

        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->MultiCell(180, 5, "Stylist Use Only", 0, 'C', 1, 0, '', '', true);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln();
        $pdf->MultiCell(80, 5, "Hair Condition Rating (1-10) $shortLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(120, 5, "Comment $medLine", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(80, 5, "Scalp Condition Rating (1-10) $shortLine", 0, 'L', 1, 0, '', '', true);
        $pdf->MultiCell(120, 5, "Comment $medLine", 0, 'L', 1, 0, '', '', true);
//        $pdf->writeHTML($html, true, false, false, false, '');
        ob_clean();
        $pdf->Output("products.pdf", 'I');

    }

    public function clientProfileTable(){

        echo $html;
    }

    public function clientProfilePDF(){
        $clientID = $this->input->get('clientID', true);

        $this->load->model('clients_model');
        $p = $this->clients_model->getFullClientProfile($clientID);
        $c = $p[0];
        $areaCode = (strlen($c['areaCode']) == 3) ? $c['areaCode'] : "          ";
        $phonePrefix = (strlen($c['phonePrefix']) == 3) ? $c['phonePrefix'] : "           ";
        $phoneLineNumber = (strlen($c['phoneLineNumber']) == 4) ? $c['phoneLineNumber'] : "           ";
        if(isset($c['sunSensitiveMeds']))
            $sunSensitiveMeds = ($c['sunSensitiveMeds'] == 0) ? 'No' : 'Yes';
        else  $sunSensitiveMeds = '( Yes / No )';
        if(isset($c['allergicSunlight']))
            $allergicSunlight = ($c['allergicSunlight'] == 0) ? 'No' : 'Yes';
        else  $allergicSunlight = '( Yes / No )';
        if(isset($c['colorHair']))
            $colorHair = ($c['colorHair'] == 0) ? 'No' : 'Yes';
        else  $colorHair = '( Yes / No )';
        if(isset($c['tanEasily']))
            $tanEasily = ($c['tanEasily'] == 0) ? 'No' : 'Yes';
        else  $tanEasily = '( Yes / No )';
        if(isset($c['skinType']))
            $skinType = $c['skinType'];
        else  $skinType = '( Oily / Dry )';
        if(isset($c['freckle']))
            $freckle = ($c['freckle'] == 0) ? 'No' : 'Yes';
        else  $freckle = '( Yes / No )';
        if(isset($c['participateOutoors']))
            $participateOutoors = ($c['participateOutoors'] == 0) ? 'No' : 'Yes';
        else  $participateOutoors = '( Yes / No )';
        if(isset($c['useMoisturizerLotion']))
            $useMoisturizerLotion = ($c['useMoisturizerLotion'] == 0) ? 'No' : 'Yes';
        else  $useMoisturizerLotion = '( Yes / No )';

        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAuthor('Brian Sizemore');
        $pdf->SetTitle('Shear Inspirations, LLC Client Data Profile');
        $pdf->SetSubject('Client Data Form');

        $pdf->AddPage();

        $fontFamily = "freesans";

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont($fontFamily, 'BI', 20);

        $pdf->Cell(30, 10, "Shear Inspirations, LLC", 0, 'L', 1, 0, '', '', true);

        $pdf->SetFont($fontFamily, '', 14);
        $pdf->Cell(0, 5, 'Client Data Profile', 0, 'R', 'R', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(30, 5, "112 E. Main St", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->Cell(30, 5, "Boonville, NC 27011", 0, 'L', 1, 0, '', '', true);

        $pdf->Ln(10);
        $pdf->Cell(0, 5, '', 'T', 'L', 1, 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(30, 5, "DOB ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "{$c['birthMonth']} / ", 'B', 'L', 'R', 0, '', '', true);
        $pdf->Cell(10, 5, "{$c['birthDay']} / ", 'B', 'L', 'R', 0, '', '', true);
        $pdf->Cell(10, 5, "{$c['birthYear']}", 'B', 'L', 'R', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(30, 5, "First Name: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(60, 5, $c['firstName'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(30, 5, "Last Name: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $c['lastName'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(30, 5, "Address: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $c['address1'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(30, 5, "City: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(40, 5, $c['city'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(20, 5, "State: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(30, 5, $c['state'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(20, 5, "Zip: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $c['zip'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Ln(10);

        $pdf->Cell(30, 5, "Occupation: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(60, 5, $c['occupation'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(30, 5, "Employer: ", 0, 'L', 1, 0, '', '', true);

        $pdf->Cell(0, 5, $c['employer'], 'B', 'L', 1, 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(20, 5, "Phone: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(60, 5, "($areaCode) $phonePrefix - $phoneLineNumber", 'B', 'L', 1, 0, '', '', true);
        $pdf->Cell(10, 5, "", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(20, 5, "Email: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, "{$c['email']}", 'B', 'L', 'C', 0, '', '', true);

        $pdf->Ln(10);
        $pdf->Cell(160, 5, "Are you taking any medication which would cause sensitivity to sunlight? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $sunSensitiveMeds, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Do you have any known allergic reaction to sunlight? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $allergicSunlight, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Do you color your hair? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $colorHair, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Natural Hair Color? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $c['naturalHairColor'], 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Do you tan easily? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $tanEasily, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "How would you best describe your skin? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $skinType, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Do you have a tendency to freckle? ", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $freckle, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(160, 5, "What is your average exposure to sunlight on a daily basis? (in hours)", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $c['avgDailySunExposure'], 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Do you participate in outdoor activities on a regular basis?", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $participateOutoors, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(10);
        $pdf->Cell(140, 5, "Are you presently using a moisturizer or lotion?", 0, 'L', 1, 0, '', '', true);
        $pdf->Cell(0, 5, $useMoisturizerLotion, 'B', 'L', 'C', 0, '', '', true);
        $pdf->Ln(15);
        $pdf->SetFont($fontFamily, 'B', 12);
        $pdf->MultiCell(0, 5, "For your health and safety, you MUST always use Protective Eyewear. The use of the TANNING UNIT without protective eyewear can cause the early formation of cataracts and/or temporary or permanent blindness.", 0, 'L', 1, 0, '', '', true);


        $pdf->SetFont($fontFamily, '', 12);
        $pdf->Ln();
        $pdf->MultiCell(0, 5, "I, the undersigned, hereby state: ", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(0, 5, "    1. I have truthfully answered the written questions with regard to the use of the tannig facility. ", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(0, 5, "    2. I have advised Shear Inspirations, LLC that I have no health problems or sensitivities which would prevent me from utilizing the ultraviolet facility provided.", 0, 'L', 1, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(0, 5, "    3. I hereby release Shear Inspirations, LLC from any and all liability resulting from use of the facility and assume all risks, known and unknown, in connection therewith.", 0, 'L', 1, 0, '', '', true);

        $pdf->Ln(25);
        $pdf->Cell(10, 5, "Date: ", 0, 'L', 'C', 0, '', '', true);
        $pdf->Cell(50, 5, "", 'B', 'L', 'C', 0, '', '', true);
        $pdf->Cell(20, 5, "    Signature: ", 0, 'L', 'C', 0, '', '', true);
        $pdf->Cell(0, 5, "", 'B', 'L', 'C', 0, '', '', true);


        ob_clean();
        $pdf->Output("products.pdf", 'I');

    }
}
