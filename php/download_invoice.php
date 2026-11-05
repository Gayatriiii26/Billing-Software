<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

$id = (int)$_GET['id'];

ob_start();

$_GET['id'] = $id;
$pdfMode = true;

// IMPORTANT
include("../pages/gst_invoice.php");

$html = ob_get_clean();

$mpdf = new Mpdf([
    'format' => 'A4',
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
    'margin_bottom' => 5,
]);

$mpdf->WriteHTML($html);

$mpdf->Output("Invoice_$id.pdf","D");