<?php

//require_once "../Image/Barcode2.php";
require_once('Image/Barcode2.php');

$num = isset($_REQUEST['num']) ? $_REQUEST['num'] : '15101967';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'int25';
$imgtype = isset($_REQUEST['imgtype']) ? $_REQUEST['imgtype'] : 'png';

Image_Barcode2::draw($num, $type, $imgtype);