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

    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

}
