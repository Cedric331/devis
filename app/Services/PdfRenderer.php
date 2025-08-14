<?php

namespace App\Services;

use Dompdf\Dompdf;

class PdfRenderer
{
    public function __construct(private Dompdf $dompdf)
    {
    }

    /**
     * Render the given HTML to a PDF binary string.
     */
    public function render(string $html): string
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        return $this->dompdf->output();
    }
}
