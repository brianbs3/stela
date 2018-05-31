<?php
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
require_once('Stela.php');


class CheckIn extends Stela {
    public function index()
    {

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAuthor('Brian Sizemore');
        $pdf->SetTitle('Future Hair Designs Check In Form');
        $pdf->SetSubject('Check In Form');
//        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();
         $pdf->SetAlpha(.3);

            $img_file = "http://" . base_url('public/images/logo.jpg');


            $pdf->Image($img_file, 110, 50, 100, 100, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetAlpha(1);
//        $pdf->writeHTML("<span width=\"30%\" align=\"center\"><b>Sign in below to reserve your spot for today!</b></span><span align=\"right\">     Date: ___/___/______</span>", true, false, false, false, '');
        $pdf->writeHTML("<table border=\"0\"><tr><td width=\"75%\" align=\"left\"><b>Sign in below to reserve your spot for today!</b><br>Please ensure you arrive at least 15 minutes before your scheduled time.</td><td width=\"25%\" align=\"right\">Date: ____/____/_______</td></tr></table>", true, false, false, false, '');
        $tbl = "
             <table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
                <thead>
                    <tr style=\"background-color:#000000;color:#FFFFFF;\">
                        <td width=\"10%\" align=\"center\">Time</td>
                        <td width=\"18%\" align=\"center\">Estela</td>
                        <td width=\"18%\" align=\"center\">Gray</td>
                        <td width=\"18%\" align=\"center\">Fernando</td>
                        <td width=\"18%\" align=\"center\">Julia</td>
                        <td width=\"18%\" align=\"center\">Elsa</td>
                    </tr>
                </thead>
                <tbody>
                ";
        $startHour = 8;
        $endHour = 16;
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
                    if($h != 16 && $m != 45)
                    {
                        $tbl .= "
                            <tr>
                                <td width=\"10%\" align=\"center\">$h:$m $tod</td>
                                <td width=\"18%\"></td>
                                <td width=\"18%\"></td>
                                <td width=\"18%\"></td>
                                <td width=\"18%\"></td>
                                <td width=\"18%\"></td>
                             </tr>";
                     }
                }
            }
        }

        $tbl .= "
            </tbody></table>
        ";
        $pdf->writeHTML($tbl, true, false, false, false, '');
        ob_clean();
        $pdf->Output('my_test.pdf', 'I');
    }
}