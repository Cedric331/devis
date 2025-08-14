<?php

use App\Services\PdfRenderer;
use Dompdf\Dompdf;

it('renders html to pdf', function () {
    $renderer = new PdfRenderer(new Dompdf());
    $pdf = $renderer->render('<h1>Hello</h1>');

    expect($pdf)->toStartWith('%PDF');
});
