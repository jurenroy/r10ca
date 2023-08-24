<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppearancesLog;

class AppearancesLogsController extends Controller
{
    public function saveLog(Request $request) {
        // Receive and validate the data provided
        $validatedData = $request->validate([
            'fullname'  => 'required',
            'company'   => 'required',
            'date_from' => 'required',
            'date_to'   => 'required',
            'purpose'   => 'required'
        ], [
            'date_from.required' => 'Date arrived is required.',
            'date_to.required' => 'Date returned is required.',
        ]);

        // Process the saving sequence
        $log = new AppearancesLog();
        $log->fullname  =   $validatedData['fullname'];
        $log->company  =   $validatedData['company'];
        $log->date_from  =   $validatedData['date_from'];
        $log->date_to  =   $validatedData['date_to'];
        $log->purpose  =   $validatedData['purpose'];

        $log->save();

        return response()->json(["message" => "Hello world"], 200);
    }
}
