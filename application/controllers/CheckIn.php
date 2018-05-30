<?php
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
require_once('Stela.php');


class CheckIn extends Stela {
    public function index()
    {

        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(20, 5, 20);
        $pdf->AddPage();
        $pdf->writeHTML("<span align=\"right\">Date: ___/___/______</span><h2 align=\"center\">Sign in below to reserve your spot for today!</h2><br>", true, false, false, false, '');
        $tbl = "
             <table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
                <thead>
                    <tr style=\"background-color:#000000;color:#FFFFFF;\">
                        <td width=\"20%\" align=\"center\">Time</td>
                        <td width=\"80%\" align=\"center\">Name</td>
                    </tr>
                </thead>
                <tbody>
                ";
        $startHour = 8;
        $endHour = 17;
        $minChunk = 15;
        $showAMPM = true;
        $tod = "";
        for($i = $startHour; $i <= $endHour; $i++) {
            $h = ($i > 12) ? $i - 12 : $i;
            for($j = 0; $j <= 45; $j++) {
                if ($j % $minChunk == 0) {
                    $m = ($j == 0) ? "00" : $j;
                    if($showAMPM)
                        $tod = ($i > 12) ? "PM" : "AM";
                    $tbl .= "
                        <tr>
                            <td width=\"20%\" align=\"center\">$h:$m $tod</td>
                            <td width=\"80%\"></td>
                         </tr>";
                }
            }
        }

        $tbl .= "
            </tbody></table>
        ";
//        echo"$tbl";
        $pdf->writeHTML($tbl, true, false, false, false, '');
        ob_clean();
        $pdf->Output('my_test.pdf', 'I');
    }
}