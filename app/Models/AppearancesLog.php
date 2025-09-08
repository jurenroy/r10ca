<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppearancesLog extends Model
{
    use HasFactory;

    // Add the new fields to the $fillable array
    protected $fillable = [
        'serial_number',
        'fullname',
        'company',
        'date_from',
        'date_to',
        'purpose',
        'position', // New column
        'accommodation_provided', // New column
        'accommodation_remarks', // New column
        'food_provided', // New column
        'food_remarks', // New column
        'transportation_provided', // New column
        'transportation_remarks', // New column
        'others_provided', // New column
        'others_remarks', // New column
    ];

    protected static function booted() {
        static::creating(function ($log) {
            // Create a transaction - to ensure uniqueness of the serial number even it will encounter an error
            DB::transaction(function () use ($log) {
                // Fetch the latest serial number avaiable
                $latestEntry = self::latest()->first();

                if($latestEntry) {
                    // Get the latest serial number
                    $latestSerialNumber = $latestEntry->serial_number;

                    // Get the year prefix of the latest serial number
                    $latestSerialNumberYear = substr($latestSerialNumber, 5);

                    // Check if the current year is equal to the latest serial number prefix
                    if($latestSerialNumberYear == date('Y')) {
                        // If true
                        // Increment the sequence by 1
                        $nextSequenceNumber = substr($latestSerialNumber, 0, 4) + 1;
                        $newSerialNumber = str_pad($nextSequenceNumber, 4, '0', STR_PAD_LEFT) . '-' . date('Y');

                        // Set the new serial number and save
                        $log->serial_number = $newSerialNumber;
                    } else {
                        // If false
                        // Get the current year and restart the sequence to 1
                        $newSerialNumber = str_pad(1, 4, 0, STR_PAD_LEFT) . '-' . date('Y');

                        // Set the new serial number and save
                        $log->serial_number = $newSerialNumber;
                    }
                } else {
                    $newSerialNumber = str_pad(1, 4, 0, STR_PAD_LEFT) . '-' . date('Y');

                    // Set the new serial number and save
                    $log->serial_number = $newSerialNumber;
                }
            });
        });
    }
}
