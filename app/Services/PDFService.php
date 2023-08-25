<?php

namespace App\Services;

use TCPDF;

class PDFService
{
    // Setup the page
    public function setup() {
        // Create a new TCPDF instance
        $pdf = new TCPDF('P', 'in', 'A4', true, 'UTF-8', false);

        // Set the document properties
        $pdf->SetCreator('MGB-X R10CA');
        $pdf->SetAuthor('MGB X - FAD');
        $pdf->SetTitle('Certificate of Appearance');
        $pdf->SetSubject('Certificate of Appearance');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins (1 inch each side)
        $pdf->SetMargins(0.5, 0.5, 0.5);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('times', '', 12);

        return $pdf;
    }

    public function generatePDF() {
        $pdf = $this->setup();

        // Add content to the PDF
        $content = "This is a sample PDF generated using Laravel and TCPDF with 1-inch margins on each side.";
        $pdf->Write(0, $content, '', 0, 'L', true, 0, false, false, 0);
        
        // Add MGB Logo
        $logo_path = base_path('public/images/mgb-logo-white.jpg');
        $xPosition = $pdf->GetX();
        $yPosition = $pdf->GetY();
        $pdf->Image($logo_path, $xPosition, $yPosition, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdfContent = $pdf->Output('sample.pdf', 'I');
        return $pdfContent;
    }
}