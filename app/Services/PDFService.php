<?php

namespace App\Services;

use TCPDF;

class PDFService
{
    // Setup the page
    public function setup() {
        // Create a new TCPDF instance
        $pdf = new TCPDF(
            $orientation = 'P', 
            $unit = 'in', 
            $format = 'A4', 
            $unicode = true, 
            $encoding = 'UTF-8', 
            $diskcache = false);

        // Set the document properties and add a page
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MGB X - FAD');
        $pdf->SetTitle('Certificate of Appearance');
        $pdf->SetSubject('Certificate of Appearance');
        $pdf->SetKeywords('CA, Certificate, Appearance');
        $pdf->setFontSubsetting(true);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setAutoPageBreak(false);

        $pdf->AddPage();

        return $pdf;
    }

    public function generatePDF() {
        $pdf = $this->setup();

        //Page Header
        $logo_path = base_path('public/images/mgb-logo-white.jpg');
        $pdf->Image($logo_path, 0.5, 0.2, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $logo_path = base_path('public/images/NQA_ISO9001_CMYK_UKAS.jpg');
        $pdf->Image($logo_path, 6.8, 0.3, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $logo_path = base_path('public/images/line-header.jpg');
        $pdf->Image($logo_path, 0, 1.3, 8.3, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $text = 'Republic of the Philippines<br>';
        $text .= 'Department of Environmental and Natural Resources<br>';
        $text .= '<b>MINES AND GEOSCIENCES BUREAU</b><br>';
        $text .= '<b>Regional Office No. X</b><br>';
        $text .=  'DENR-X Compound, Puntod, Cagayan de Oro City';
        
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(8.3, 0, 0, 0.2, $text, 0, 1, 0, true, 'C');


        //Body
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'CERTIFICATE OF APPEARANCE';
        
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(8.3, 0, 0, 1.5, $text, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(8.3, 0, 0, 1.75, 'No. ______________________', 0, 1, 0, true, 'C');
        $pdf->writeHTMLCell(8.3, 0, 0, 1.75, '2023-0202', 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'TO WHOM IT MAY CONCERN:';
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(0, 0, 0.5, 3, $text, 0, 1, 0, true);

        //Paragraph
        $pdf->SetFont('helvetica', '', 12);
        // $text = '<p align="justify" style="line-height: 5">THIS IS TO CERTIFY that _______________________________________________, of the ______________________________________________________________________________ appeared in this Office on ___________________________ for the purpose of _____________________________________________________________________________________________.</p>';
        
        $purpose = 'Attend Annual Technical Forum';
        $text = '<p align="justify" style="line-height: 2">THIS IS TO CERTIFY that _______________________________________________, of the ______________________________________________________________________________ appeared in this Office on ___________________________ for the purpose of <span style="font-weight: bold; text-decoration: underline;">' . $purpose . '<span>.</p>';
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(0, 0, 0.5, 3.5, $text, 0, 1, 0, true);
        
        //Signatory
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        $logo_path = base_path('public/images/lbt.jpg');
        $pdf->Image($logo_path, 100, 55, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);
        $pdf->SetAlpha(0.5); // Adjust the alpha value as per your requirement
        
        $text = '<b>LIBERTY B. DAITIA</b><br>';
        $text .='Chief, Finance and Administrative Division';
        $pdf->SetAlpha(1); // Set the alpha value back to 1 for normal opacity

        $pdf->writeHTMLCell(0, 4.5, 90, 65, $text, 0, 1, 0, true, 'C');

        //Footer
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'Date of Issuance &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;_____________________________<br>';
        $text .='Place of Issuance&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;Mines and Geosciences Bureau<br>';
        $text .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Regional Office No. X<br>';
        $text .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puntod, Cagayan de Oro City';
        
        $pdf->writeHTMLCell(0, 4.5, 9, 80, $text, 0, 1, 0, true, 'L');

        $logo_path = base_path('public/images/line-footer.jpg');
        $pdf->Image($logo_path, 3, 98, 142, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', 'B', 5);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'MGB-X-FAD-FO-045';
        
        $pdf->writeHTMLCell(0, 4.5, 9, 99, $text, 0, 1, 0, true, 'l');

        $pdfContent = $pdf->Output('sample.pdf', 'I');
        return $pdfContent;
    }
}