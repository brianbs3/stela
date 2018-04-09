<?php

/* 
* Do some path massaging to get the barcode to work
*/
$dir = dirname(__FILE__, 3);
set_include_path(get_include_path() . PATH_SEPARATOR . "$dir/Image");
$path = get_include_path();

require_once('Stela.php');
require_once("Image/Image/Barcode2.php");

class Barcode extends Stela {
  public function index()
  {
    $code = $this->input->get('code', true);
    $encode = $this->input->get('encode', true);
    $img_type = $this->input->get('img_type', true);

    if(!$encode)
      $this->drawBarcode($code);
    else if(!$img_type)
      $this->drawBarcode($code, $encode);
    else
      $this->drawBarcode($code, $encode, $img_type);
  }

  public function drawBarcode($code = "", $encode = "code128", $img_type = "png")
  {
    Image_Barcode2::draw($code, $encode, $img_type, true, 15, 1);
  }
}
