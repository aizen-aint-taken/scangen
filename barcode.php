<?php

if(isset($_POST['submit'])){
    $text = $_POST["text_message"];
 
    require 'vendor/autoload.php';


    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    echo $generator->getBarcode($text , $generator::TYPE_CODE_128);
  
}


