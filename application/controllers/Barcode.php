<?php
require_once('Stela.php');
require('application/libraries/fpdf.php');
require('TCPDF/tcpdf.php');
class Barcode extends Stela {
  public function index()
  {
    require_once('TCPDF/tcpdf_barcodes_1d.php');
    $barcodeobj = new TCPDFBarcode('hello world', 'C128');
    $barcodeobj->getBarcodePNG(2, 30, array(0,0,0));
  }

  public function getBarcode($code = 'bs', $encode = 'C128')
  {
//    $code = $this->input->get('code', true);
 //   $encode = $this->input->get('encode', true);

    require_once('TCPDF/tcpdf_barcodes_1d.php');
    $barcodeobj = new TCPDFBarcode($code, $encode);
    $barcodeobj->getBarcodePNG(2, 30, array(0,0,0));
    
  }
}
