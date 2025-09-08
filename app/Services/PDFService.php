<?php

namespace App\Services;

use App\Mail\MailHandler;
use Illuminate\Support\Facades\Mail;
use TCPDF;

class PDFService
{
    // Setup the page
    public function setup($userOrientation = 'P') {
        // Create a new TCPDF instance
        $pdf = new TCPDF(
            $orientation = $userOrientation, 
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

    // Generate PDF
    public function generatePDF($data = null) {
        $pdf = $this->setup();

        // Retrived the latest data in database
        $fullname       = $data['fullname'];
        $company        = $data['company'];
        if(is_null($data['date_from']) || is_null($data['date_to'])) {
            $date       = '';
        } else {
            $date       = date_format(date_create($data['date_from']), 'm/d/Y') . ' - ' . date_format(date_create($data['date_to']), 'm/d/Y');
        }
        $serial_number  = $data['serial_number'];
        $purpose        = $data['purpose'];
        $position       = $data['position'];
        // Initialize the $table array and map values from $data
        $table = [
            'accommodation_provided' => $data['accommodation_provided'],
            'accommodation_remarks' => $data['accommodation_remarks'],
            'food_provided' => $data['food_provided'],
            'food_remarks' => $data['food_remarks'],
            'transportation_provided' => $data['transportation_provided'],
            'transportation_remarks' => $data['transportation_remarks'],
            'others_provided' => $data['others_provided'],
            'others_remarks' => $data['others_remarks']
        ];

        //Page Header
        $logo_path = base_path('public/images/mgb-logo-white.jpg');
        $pdf->Image($logo_path, 0.5, 0.2, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        // New bago.png in the original ISO position
        $logo_path = base_path('public/images/bago.png');
        $pdf->Image($logo_path, 6.8, 0.2, 1, '', 'PNG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

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
        $pdf->SetFont('helvetica', 'B', 12); 

        // Check if position is null to determine X-axis position
        $xPosition = is_null($position) ? 0 : 3; // Changed from 5.5 to 4.8 (moved left)

        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement) 
        $pdf->writeHTMLCell(8.3, 0, $xPosition, 1.85, 'No. ___________________________', 0, 1, 0, true, 'C'); 
        $pdf->writeHTMLCell(8.3, 0, $xPosition, 1.80, $serial_number, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'TO WHOM IT MAY CONCERN:';
        // Only show "TO WHOM IT MAY CONCERN" when position is null
        if (is_null($position)) {
            // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
            $pdf->writeHTMLCell(0, 0, 0.5, 3, $text, 0, 1, 0, true);
        }

        //Paragraph
        $pdf->SetFont('helvetica', '', 12);
        // $text = "<p style=\"align: justify; line-height: 1.6\">THIS IS TO CERTIFY that <span style=\"text-decoration: underline; font-weight: bold;\">$firstname</span>, of the <span style=\"text-decoration: underline; font-weight: bold;\">$company</span> appeared in this Offie on <span style=\"text-decoration: underline; font-weight: bold;\">$date</span> for the purpose of <span style=\"text-decoration: underline; font-weight: bold;\">$purpose</span>.";

        // Check if this is DENR format (position exists) or Original format
if (!is_null($position) && !empty($position)) {
    // DENR FORMAT - Independent lines with bottom borders
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    
    // Line 1: "THIS IS TO CERTIFY that [NAME],"
    $pdf->writeHTMLCell(0, 0, 1.5, 2.6, 'THIS IS TO CERTIFY that', 0, 0, 0, true, 'L');
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->writeHTMLCell(4, 0, 3.8, 2.6, $fullname, 'B', 0, 0, true, 'C'); // Bottom border only
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, 7.8, 2.6, ',', 0, 1, 0, true, 'L');

    // Base Y position
    $y_position = 3;
    
    // Calculate offset based on length of company string
    $companyLength = strlen($company);
    
    if ($companyLength > 80) {
        $y_position += 0.16;
    } elseif ($companyLength > 40) {
        $y_position += 0.08;
    }
    
    // Line 2: "[POSITION], of the [COMPANY]" - ALIGNED
    // Now write the cells with adjusted Y
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->writeHTMLCell(3, 0, 0.5, $y_position, $position, 'B', 0, 0, true, 'C');

    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, 3.5, $y_position, ', of the', 0, 0, 0, true, 'L');

    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->writeHTMLCell(3.5, 0, 4.3, 3, $company, 'B', 1, 0, true, 'C');
    
    // Line 3: "has personally appeared at the [VENUE] for the purpose of" - ALIGNED
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, 0.5, $y_position+0.4, 'has personally appeared at the', 0, 0, 0, true, 'L');
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->writeHTMLCell(2, 0, 3.7, $y_position+0.4, $place_venue ?? 'MGB-X', 'B', 0, 0, true, 'C'); // Venue with bottom border
    $pdf->SetFont('helvetica', '', 11);
    $pdf->writeHTMLCell(0, 0, 6.2, $y_position+0.4, ' for the purpose of', 0, 1, 0, true, 'L'); // ALIGNED

    // Calculate offset based on length of company string
    $add_position = 0;
    $purposeLength = strlen($purpose);

    // Number of full 40-character blocks
    $blocks = intdiv($purposeLength, 40);  // PHP 7+ function for integer division

    // Then multiply by 0.4 for offset per block
    $add_position = $blocks * 0.2;
    
    // Line 4: [PURPOSE] during the period [DATE] - ALIGNED (50% width)
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->writeHTMLCell(3.6, 0, 0.5, $y_position+0.8, $purpose, 'B', 0, 0, true, 'C'); // 50% of 7.23 = 3.6, bottom border only
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, 4.1, $y_position+0.8+$add_position, ' during the period', 0, 0, 0, true, 'L');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->writeHTMLCell(3, 0, 5.8, $y_position+0.8+$add_position, $date, 'B', 0, 0, true, 'C'); // Date with bottom border - ALIGNED
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, 8.8, $y_position+0.8+$add_position, '.', 0, 1, 0, true, 'L');

    // Add Table for Accommodation, Food, Transportation, and Others
$t_position = 0;
$t_position += ($y_position + 1.3 + $add_position);  // Adjust Y position for the table

// Table header (Text only with borders)
$pdf->SetFont('helvetica', 'B', 12);
$pdf->text(2.5, $t_position, 'Provided');  // Item name
$pdf->text(3.5, $t_position, 'Not Provided');  // Item name
$pdf->text(5.5, $t_position, 'Remarks');  // Item name

// Accommodation row (Plain text without table structure)
$pdf->SetFont('helvetica', '', 12);
$pdf->text(0.5, $t_position + 0.4, 'Accommodation');  // Item name
$pdf->text(2.8, $t_position + 0.4, ($table['accommodation_provided'] == 1) ? '/' : '');  // Provided column
$pdf->text(4.0, $t_position + 0.4, ($table['accommodation_provided'] == 0) ? '/' : '');  // Not Provided column
$pdf->text(5.5, $t_position + 0.4, $table['accommodation_remarks']);  // Remarks column
$pdf->Line(5.5, $t_position + 0.7, 4.5 + 30, $t_position + 0.7);  // Uniform underline
$pdf->Rect(2.7, $t_position + 0.35, 0.3, 0.3);  // Box for "Provided" (Accommodation)
$pdf->Rect(3.9, $t_position + 0.35, 0.3, 0.3);  // Box for "Not Provided" (Accommodation)

// Food row (Plain text without table structure)
$pdf->text(0.5, $t_position + 0.8, 'Food');  // Item name
$pdf->text(2.8, $t_position + 0.8, ($table['food_provided'] == 1) ? '/' : '');  // Provided column
$pdf->text(4.0, $t_position + 0.8, ($table['food_provided'] == 0) ? '/' : '');  // Not Provided column
$pdf->text(5.5, $t_position + 0.8, $table['food_remarks']);  // Remarks column
$pdf->Line(5.5, $t_position + 1.1, 4.5 + 30, $t_position + 1.1);  // Uniform underline
$pdf->Rect(2.7, $t_position + 0.75, 0.3, 0.3);  // Box for "Provided" (Food)
$pdf->Rect(3.9, $t_position + 0.75, 0.3, 0.3);  // Box for "Not Provided" (Food)

// Transportation row (Plain text without table structure)
$pdf->text(0.5, $t_position + 1.2, 'Transportation');  // Item name
$pdf->text(2.8, $t_position + 1.2, ($table['transportation_provided'] == 1) ? '/' : '');  // Provided column
$pdf->text(4.0, $t_position + 1.2, ($table['transportation_provided'] == 0) ? '/' : '');  // Not Provided column
$pdf->text(5.5, $t_position + 1.2, $table['transportation_remarks']);  // Remarks column
$pdf->Line(5.5, $t_position + 1.4, 4.5 + 30, $t_position + 1.4);  // Uniform underline
$pdf->Rect(2.7, $t_position + 1.15, 0.3, 0.3);  // Box for "Provided" (Transportation)
$pdf->Rect(3.9, $t_position + 1.15, 0.3, 0.3);  // Box for "Not Provided" (Transportation)

// Others row (Plain text without table structure)
$pdf->text(0.5, $t_position + 1.6, 'Others');  // Item name
$pdf->text(2.8, $t_position + 1.6, ($table['others_provided'] == 1) ? '/' : '');  // Provided column
$pdf->text(4.0, $t_position + 1.6, ($table['others_provided'] == 0) ? '/' : '');  // Not Provided column
$pdf->text(5.5, $t_position + 1.6, $table['others_remarks']);  // Remarks column
$pdf->Line(5.5, $t_position + 1.9, 4.5 + 30, $t_position + 1.9);  // Uniform underline
$pdf->Rect(2.7, $t_position + 1.55, 0.3, 0.3);  // Box for "Provided" (Others)
$pdf->Rect(3.9, $t_position + 1.55, 0.3, 0.3);  // Box for "Not Provided" (Others)
} else {
    // ORIGINAL FORMAT - Keep your working code
    $text = '<p align="justify" style="line-height: 5;">THIS IS TO CERTIFY that _______________________________________________________, of the ________________________________________________________________________ appeared in this Office on ___________________________________________ for the purpose of ______________________________________________________________________________.</p>';
    $pdf->writeHTMLCell(0, 0, 0.5, 3.5, $text, 0, 1, 0, true);
    
    // Fill in the blanks - Original format
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);
    // Name
    $pdf->writeHTMLCell(5.1, 0, 2.65, 3.7, $fullname, 0, 1, 0, true, 'C');
    
    // Company
    $pdf->writeHTMLCell(6.67, 0, 1.12, 4.5, $company, 0, 1, 0, true, 'C');
    
    // Date
    $pdf->writeHTMLCell(4, 0, 2.47, 5.3, $date, 0, 1, 0, true, 'C');
    
    // Purpose
    $pdf->writeHTMLCell(7.23, 0, 0.54, 6.1, $purpose, 0, 1, 0, true, 'C');
}

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
        
        $pdf->writeHTMLCell(0, 0, 0.5, 9., $text, 0, 1, 0, true, 'L');
        
        // Date of issuance
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->writeHTMLCell(2.7, 0, 2.2, 8.98, date('m-d-Y'), 0, 1, 0, true, 'L');

        // ISO logo moved to footer area (add this near the footer section)
        $logo_path = base_path('public/images/NQA_ISO9001_CMYK_UKAS.jpg');
        $pdf->Image($logo_path, 6.8, 10.3, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        // Add Certification Text beside the logo (left side of the logo)
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(0.4, 10.4);  // Position of the text next to the logo
        if (!is_null($position)) {
            $pdf->MultiCell(6.3, 0, 'This Certification is being used upon request of the aforementioned in compliance with the standing regulation provided for under Republic Act. No. 3847 Implemented by COA Circular No. 127 for the purpose of establishing evidence of duration of his / her appearance hereto, the truth of which is hereby vouchsafed by the undersigned, and the DENR MC No. 2024-04 Re: Revised Guidelines on the Payment of Claims for Official Local Travels.', 0, 'L');
        }

        $logo_path = base_path('public/images/line-footer.jpg');
        $pdf->Image($logo_path, 0, 11.4, 8.3, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $text = (!is_null($position) && !empty($position)) ? 'MGB-X-FAD-FO-045A' : 'MGB-X-FAD-FO-045';
        
        $pdf->writeHTMLCell(0, 0, 0.5, 11.41, $text, 0, 1, 0, true, 'l');

        $pdfContent = $pdf->Output('sample.pdf', 'S');
        return $pdfContent;
    }

    // Send PDF
    public function sendCerficateOfAppearance($logData) {
        // Generate PDF
        $pdfContent = $this->generatePDF($logData);

        // Set recipient email
        $recipientEmail = 'mgbxreceiving@gmail.com';
        // $recipientEmail = 'baddergenius@gmail.com';
        Mail::to($recipientEmail)->send(new MailHandler($pdfContent));

        return "Welcome email sent successfully!";
    }

    // Display for re-printing
    public function reprint($data) {
        $pdf = $this->setup();

        // Retrived the latest data in database
        $fullname       = $data->fullname;
        $company        = $data->company;
        if(is_null($data->date_from) || is_null($data->date_to)) {
            $date       = '';
        } else {
            $date       = date_format(date_create($data->date_from), 'm/d/Y') . ' - ' . date_format(date_create($data->date_to), 'm/d/Y');
        }
        $serial_number  = $data->serial_number;
        $purpose        = $data->purpose;

        //Page Header
        $logo_path = base_path('public/images/mgb-logo-white.jpg');
        $pdf->Image($logo_path, 0.5, 0.2, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        // New bago.png in the original ISO position
        $logo_path = base_path('public/images/bago.png');
        $pdf->Image($logo_path, 6.8, 0.2, 1, '', 'PNG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

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
        $pdf->writeHTMLCell(2.7, 0, 2.2, 9.98, date_format(date_create($data->created_at), 'm/d/Y'), 0, 1, 0, true, 'L');

        // ISO logo moved to footer area (add this near the footer section)
        $logo_path = base_path('public/images/NQA_ISO9001_CMYK_UKAS.jpg');
        $pdf->Image($logo_path, 6.8, 10.3, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);
        

        $logo_path = base_path('public/images/line-footer.jpg');
        $pdf->Image($logo_path, 0, 11.4, 8.3, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'MGB-X-FAD-FO-045';
        
        $pdf->writeHTMLCell(0, 0, 0.5, 11.41, $text, 0, 1, 0, true, 'l');

        $pdfContent = $pdf->Output('sample.pdf', 'I');
        return $pdfContent;
    }

    // Summary Report
    public function summaryReport($date_covered, $data) {
        $pdf = $this->setup('L');

        // Set custom margins
        $pdf->SetMargins(0.5, 0.5, 0.5); // Left, top, right

        // Set auto page breaks based on margins
        $pdf->SetAutoPageBreak(true, 0.5); // Set the bottom margin for page break

        //Page Header
        $logo_path = base_path('public/images/mgb-logo-white.jpg');
        $pdf->Image($logo_path, 0.5, 0.2, 1, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        // New bago.png in the original ISO position
        $logo_path = base_path('public/images/bago.png');
        $pdf->Image($logo_path, 6.8, 0.2, 1, '', 'PNG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $logo_path = base_path('public/images/line-header.jpg');
        $pdf->Image($logo_path, 0, 1.3, 11.7, '', 'JPG', '', 'T', false, 300, '', false, false, 0 , false, false, false);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $text = 'Republic of the Philippines<br>';
        $text .= 'Department of Environmental and Natural Resources<br>';
        $text .= '<b>MINES AND GEOSCIENCES BUREAU</b><br>';
        $text .= '<b>Regional Office No. X</b><br>';
        $text .=  'DENR-X Compound, Puntod, Cagayan de Oro City';
        
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(11.7, 0, 0, 0.2, $text, 0, 1, 0, true, 'C');

        // Body
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor(0, 0, 0);
        $text = 'CERTIFICATE OF APPEARANCE LOG CY ' . strtoupper(date('F Y', strtotime($date_covered)));
        
        // (cell width, cell height, x-axis, y-axis, content, border, -, cell fill, placement)
        $pdf->writeHTMLCell(11.7, 0, 0, 1.5, $text, 0, 1, 0, true, 'C');

        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetXY(0.5, 2);
        $tbl = '<table border="1" cellpadding="5">
                    <thead>
                        <tr style="text-align: center;">
                            <th>Name</th>
                            <th>Office</th>
                            <th>Period of Visit</th>
                            <th>Purpose</th>
                            <th>Control Number</th>
                        </tr>
                    </thead>
                    <tbody>';

        if($data->count() > 0) {
            foreach($data as $details) {
                if(is_null($details->date_from) && is_null($details->date_to)) {
                    $date = '-';
                } else {
                    $start_date = date('m/d/Y', strtotime($details->date_from));
                    $end_date = date('m/d/Y', strtotime($details->date_to));
    
                    $date = $start_date . " - " . $end_date;
                }
    
                $tbl .= '<tr>
                            <td>' . $details->fullname . '</td>
                            <td>' . $details->company . '</td>
                            <td>' . $date . '</td>
                            <td>' . $details->purpose . '</td>
                            <td>' . $details->serial_number . '</td>
                        </tr>';
            }
        } else {
            $tbl .= '<tr style="text-align: center;"><td colspan="5">No data available</td></tr>';
        }
                        
        $tbl .= '</tbody>
                </table>';

        // Output the table on the PDF
        $pdf->writeHTML($tbl, true, false, true, false, '');

        $pdfContent = $pdf->Output('sample.pdf', 'I');
        return $pdfContent;
    }
}