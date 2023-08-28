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

    public function generatePDF($data = null) {
        $pdf = $this->setup();

        // Retrived the latest data in database
        $firstname      = $data['fullname'];
        $company        = $data['company'];
        $date           = $data['date_from'] . 'to' . $data['date_to'];
        $serial_number  = $data['serial_number'];
        $purpose        = $data['purpose'];

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
        $pdf->writeHTMLCell(8.3, 0, 0, 1.85, 'No. ___________________________', 0, 1, 0, true, 'C');
        $pdf->writeHTMLCell(8.3, 0, 0, 1.80, $serial_number, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'TO WHOM IT MAY CONCERN:';
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(0, 0, 0.5, 3, $text, 0, 1, 0, true);

        //Paragraph
        $pdf->SetFont('helvetica', '', 12);
        // $text = "<p style=\"align: justify; line-height: 1.6\">THIS IS TO CERTIFY that <span style=\"text-decoration: underline; font-weight: bold;\">$firstname</span>, of the <span style=\"text-decoration: underline; font-weight: bold;\">$company</span> appeared in this Offie on <span style=\"text-decoration: underline; font-weight: bold;\">$date</span> for the purpose of <span style=\"text-decoration: underline; font-weight: bold;\">$purpose</span>.";

        $text = '<p align="justify" style="line-height: 5;">THIS IS TO CERTIFY that _______________________________________________________, of the ________________________________________________________________________ appeared in this Office on ___________________________________________ for the purpose of ______________________________________________________________________________.</p>';
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(0, 0, 0.5, 3.5, $text, 0, 1, 0, true);
        
        // Fill in the blanks with the user inputs
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->writeHTMLCell(5.1, 0, 2.65, 3.75, $fullname, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->writeHTMLCell(6.67, 0, 1.12, 4.6, $company, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->writeHTMLCell(4, 0, 2.47, 5.45, $date, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->writeHTMLCell(7.23, 0, 0.54, 6.07, $purpose, 0, 1, 0, true, 'C');

        //Signatory
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $logo_path = base_path('public/images/lbt.jpg');
        $pdf->Image($logo_path, 5.95, 7.6, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);
        $pdf->SetAlpha(0.5); // Adjust the alpha value as per your requirement
        
        $text = '<b>LIBERTY B. DAITIA</b><br>';
        $text .='Chief, Finance and Administrative Division';
        $pdf->SetAlpha(1); // Set the alpha value back to 1 for normal opacity
        $pdf->writeHTMLCell(0, 0, 5, 8, $text, 0, 1, 0, true, 'C');

        //Footer
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'Date of Issuance &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;_____________________________<br>';
        $text .='Place of Issuance&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;Mines and Geosciences Bureau<br>';
        $text .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Regional Office No. X<br>';
        $text .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puntod, Cagayan de Oro City';
        
        $pdf->writeHTMLCell(0, 0, 0.5, 10, $text, 0, 1, 0, true, 'L');
        
        // Date of issuance
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->writeHTMLCell(2.7, 0, 2.2, 9.98, date('m-d-Y'), 0, 1, 0, true, 'L');
        

        $logo_path = base_path('public/images/line-footer.jpg');
        $pdf->Image($logo_path, 0, 11.4, 8.3, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'MGB-X-FAD-FO-045';
        
        $pdf->writeHTMLCell(0, 0, 0.5, 11.41, $text, 0, 1, 0, true, 'l');

        $pdfContent = $pdf->Output('sample.pdf', 'I');
        return $pdfContent;
    }
}