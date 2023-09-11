<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppearancesLog;
use App\Services\PDFService;
use DataTables;

class AdminController extends Controller
{
    protected $pdfService;

    // Initialize a constructor
    public function __construct(PDFService $pdfService) {
        $this->pdfService = $pdfService;
    }

    public function dashboard() {
        return view('dashboard');
    }

    // Retrieve all the appearance log data
    public function appearance_log_data() {
        $logs = AppearancesLog::all();

        return DataTables::of($logs)->addIndexColumn()
                                    ->addColumn('formatted_date', function ($model) {
                                        

                                        if(is_null($model->date_from) && is_null($model->date_to)) {
                                            return '-';
                                        } else {
                                            $start_date = date('m/d/Y', strtotime($model->date_from));
                                            $end_date = date('m/d/Y', strtotime($model->date_to));

                                            return $start_date . " - " . $end_date;
                                        }
                                    })
                                    ->addColumn('date_issued', function ($model) {
                                        return date('m/d/Y', strtotime($model->created_at));
                                    })
                                    ->make(true);
    }

    // Display the CA for re-print
    public function displayCA($id) {
        $logData = AppearancesLog::where('id', $id)->first();

        $this->pdfService->reprint($logData);
    }

    // Data for the stats
    public function graphData(Request $request) {
        $appearanceLogs = AppearancesLog::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', date('Y'))
                                                                                                    ->groupBy('month')
                                                                                                    ->orderBy('month')
                                                                                                    ->get();

        $labels = [];
        $data = [];
        $monthColors = ['#0074E4', '#FF0066', '#33CC33','#FFD700', '#9933FF', '#FF9900', '#FF5050', '#3399FF', '#66CC99', '#FF6633', '#996699', '#00CC99'];

        for ($i = 1; $i < 12; $i++) {
            $month = date("F", mktime(0, 0, 0, $i, 1));
            $count = 0;

            foreach($appearanceLogs as $ca) {
                if($ca->month == $i) {
                    $count = $ca->count;
                    break;
                }
            }

            array_push($labels, $month);
            array_push($data, $count);
        }

        $datasets = [
            [
                'label'             => 'Data',
                'data'              => $data,
                'backgroundColor'   => $monthColors
            ]
        ];

        return response()->json(['datasets' => $datasets, 'labels' => $labels]);
    }

    // Generate Report for printing summary
    public function generateReport(Request $request) {
        
        // Retrieve data for summary printing
        $appearanceLogs = AppearancesLog::whereMonth('created_at', date('m', strtotime($request->query('date_covered'))))->get();

        $this->pdfService->summaryReport($request->query('date_covered'), $appearanceLogs);
    }
}
