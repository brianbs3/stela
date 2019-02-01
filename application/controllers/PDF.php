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
            $cost = number_format($p['cost'], 2);
            $productsHTML .= "<tr><td>{$p['product']}</td><td align=\"right\">\${$cost}</td></tr>";
            $productCost += $p['cost'];
        }

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
            <table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" spacing=\"20px\">
            <tr><td><b>Services:</b></td><td align=\"right\">\${$appt['serviceCost']}</td></tr>
            $servicesHTML
            <tr>
                <td>Notes:</td>
                <td align=\"left\">";
                    foreach($appt['notes'] as $n)
                        $html .= "{$n['note']}<br>";
            $html .= "
                </td>
            </tr>
            <tr><td><b>Products:</b></td><td align=\"right\">\${$appt['productCost']}</td></tr>
            $productsHTML
            </table>
            <hr style=\"border-top: dotted 1px;\">
            <table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\" spacing=\"200px\">
            <tr><td><br><b>Total:</b></td><td align=\"right\"><b>\${$appt['total']}</b></td></tr>
            </table>     
       
            <br>
        ";
        $filename = md5(time());
        $dir = "{$_SERVER['DOCUMENT_ROOT']}/stela/public/pdf";//__DIR__;
        $pdf->writeHTML($html, true, false, false, false, '');
        ob_clean();
        $pdf->Output("$dir/$filename.pdf", 'F');
        echo"<a target='_blank' href='/stela/public/pdf/$filename.pdf'>Downoad Receipt</a>";
        //echo $html;
    }
}
