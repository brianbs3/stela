<?php
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
require_once('Stela.php');


class CheckIn extends Stela {
    public function index()
    {
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
        $pdf->AddPage();
        $pdf->writeHTML("Hello", true, false, false, false, '');
        $tbl = "
            <table border=1>
                <thead><th>Name</th><th>Time</th></thead>
                ";
        for($i = 0; $i < 20; $i++)
            $tbl .= "<tr><td></td><td></td></tr>";
        $tbl .= "
            </table>
        ";
//        echo"$tbl";
        $pdf->writeHTML($tbl, true, false, false, false, '');
        ob_clean();
        $pdf->Output('my_test.pdf', 'I');
    }
}