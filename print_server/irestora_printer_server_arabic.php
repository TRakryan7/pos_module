<?php
//load library
require __DIR__ . '/escpos-php/autoload.php';
//include helper function
include_once 'include/printer_helper.php';
//include printer load
include_once 'include/printer_load_arabic.php';

$object = json_decode(($_POST['content_data']));
$content_img = (($_POST['content_img']));
if($object){
    if($object->print_type=="invoice"){
        $data1 = $content_img;
        list($type, $data1) = explode(';', $data1);
        list(, $data1)      = explode(',', $data1);
        $data1 = base64_decode($data1);
        $print_content = 'include/print_content.png';
        file_put_contents(''.$print_content, $data1);
        sleep(1);
        print_receipt($object);

    }else if ($object->print_type=="bill"){
        print_receipt_bill($object);
    }else if ($object->print_type=="kot"){
        print_receipt_kot($object);
    }else if ($object->print_type=="bot"){
        print_receipt_bot($object);
    }
}



