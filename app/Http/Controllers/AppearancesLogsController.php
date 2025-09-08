<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppearancesLog;
use App\Services\PDFService;

class AppearancesLogsController extends Controller
{
    protected $pdfService;

    // Initialize a constructor
    public function __construct(PDFService $pdfService) {
        $this->pdfService = $pdfService;
    }

    public function saveLog(Request $request) {
        // Receive and validate the data provided
        $validatedData = $request->validate([
            'fullname'                  => 'required',
            'company'                   => 'required',
            'date_from'                 => 'nullable|date',
            'date_to'                   => 'nullable|date',
            'purpose'                   => 'required',
            'position'                  => 'nullable|string',
            'accommodation_provided'    => 'nullable|boolean',
            'accommodation_remarks'     => 'nullable|string',
            'food_provided'             => 'nullable|boolean',
            'food_remarks'              => 'nullable|string',
            'transportation_provided'  => 'nullable|boolean',
            'transportation_remarks'   => 'nullable|string',
            'others_provided'           => 'nullable|boolean',
            'others_remarks'            => 'nullable|string',
        ], [
            'date_from.required'        => 'Date arrived is required.',
            'date_to.required'          => 'Date returned is required.',
            'position.string'           => 'Position must be a valid string.',
            'accommodation_remarks.string' => 'Accommodation remarks must be a valid string.',
            'food_remarks.string'       => 'Food remarks must be a valid string.',
            'transportation_remarks.string' => 'Transportation remarks must be a valid string.',
            'others_remarks.string'     => 'Other remarks must be a valid string.',
        ]);

        // Process the saving sequence
        $log = new AppearancesLog();
        $log->fullname                  = $validatedData['fullname'];
        $log->company                   = $validatedData['company'];
        $log->date_from                 = $validatedData['date_from'];
        $log->date_to                   = $validatedData['date_to'];
        $log->purpose                   = $validatedData['purpose'];
        $log->position                  = $validatedData['position'] ?? null;
        $log->accommodation_provided    = $validatedData['accommodation_provided'] ?? null;
        $log->accommodation_remarks     = $validatedData['accommodation_remarks'] ?? null;
        $log->food_provided             = $validatedData['food_provided'] ?? null;
        $log->food_remarks              = $validatedData['food_remarks'] ?? null;
        $log->transportation_provided  = $validatedData['transportation_provided'] ?? null;
        $log->transportation_remarks   = $validatedData['transportation_remarks'] ?? null;
        $log->others_provided           = $validatedData['others_provided'] ?? null;
        $log->others_remarks            = $validatedData['others_remarks'] ?? null;

        if ($log->save()) {
            // Attempt to send the certificate (PDF) to the email
            $retryCount = 0;
            $maxRetries = 3;
            $emailSent = false;
        
            // Try sending the email up to $maxRetries times
            while ($retryCount < $maxRetries && !$emailSent) {
                try {
                    // Call the PDF service to generate and send the certificate
                    $this->pdfService->sendCerficateOfAppearance($log);
        
                    // If the email is sent successfully, set the flag to true
                    $emailSent = true;
        
                } catch (\Exception $e) {
                    // Log the error message for debugging purposes
                    Log::error("Failed to send email for log ID {$log->id}: " . $e->getMessage());
        
                    // Retry the sending attempt
                    $retryCount++;
                }
            }
        
            // If email sending failed after all retries, return failure response
            if (!$emailSent) {
                return response()->json(["message" => "Save successful, but email could not be sent. Please try again."], 500);
            }
        
            // If email was successfully sent, return success response
            return response()->json(["message" => "Save successful and email sent."], 200);
        }
    }

}
