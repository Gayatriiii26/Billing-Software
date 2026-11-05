<?php

ob_start();

$pdfMode = true;

/*
    This loads your existing invoice page.
    Because $pdfMode is true:
    - Back button won't show
    - Print button won't show
*/

include("gst_invoice.php");

$html = ob_get_clean();

require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();

$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(
    "Invoice_" . $_GET['id'] . ".pdf",
    [
        "Attachment" => true
    ]
);

exit;