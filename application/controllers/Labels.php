<?php
require_once('Stela.php');
require_once('PDF_Label.php');
require_once('application/libraries/Image/Image/Barcode2.php');

/*------------------------------------------------
To create the object, 2 possibilities:
either pass a custom format via an array
or use a built-in AVERY name
------------------------------------------------*/
class Labels extends Stela
{
    public function miniLabels($type = 'E')
    {
//        set_include_path(".:/usr/lib/php:/usr/local/lib/php:/Library/WebServer/Documents/stela/application/libraries/Image:/Library/WebServer/Documents/stela");/
        set_include_path(".:/usr/lib/php:/usr/local/lib/php:/Library/WebServer/Documents/stela/application/libraries/Image:/var/www/html/stela/application/libraries/Image");
        // Example of custom format
        // $pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>1, 'marginTop'=>1, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>14));

        // Standard format
//        $pdf = new PDF_Label('5195');
        $pdf = new PDF_Label('5195');
        $pdf->setFont('courier');
        $pdf->AddPage();

        // Print labels
        for ($i = 1; $i <= 60; $i++) {
            $strArr = $this->randomString(9, $type, false);
            $str = $strArr['randomString'];

            $barcodePath = "public/barcodes/".$str.".png";
            $barcode = new Image_Barcode2();
            imagepng(Image_Barcode2::draw($str, 'code128', 'png', false), $barcodePath);
            $pdf->Add_Label($barcodePath);

//            $pdf->Add_Label($strArr['randomString']);
        }

        $pdf->Output();
    }
}
?>