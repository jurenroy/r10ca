<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppearancesLog extends Model
{
    use HasFactory;

    protected $fillable = ['serial_number', 'fullname', 'company', 'date_from', 'date_to', 'purpose'];

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
                    $latestSerialNumberYear = substr($latestSerialNumber, 0, 4);

                    // Check if the current year is equal to the latest serial number prefix
                    if($latestSerialNumberYear == date('Y')) {
                        // If true
                        // Increment the sequence by 1
                        $nextSequenceNumber = substr($latestSerialNumber, Str::length(date('Y') . '-')) + 1;
                        $newSerialNumber = date('Y') . '-' . str_pad($nextSequenceNumber, 4, '0', STR_PAD_LEFT);

                        // Set the new serial number and save
                        $log->serial_number = $newSerialNumber;
                    } else {
                        // If false
                        // Get the current year and restart the sequence to 1
                        $newSerialNumber = date('Y') . '-' . str_pad(1, 4, 0, STR_PAD_LEFT);

                        // Set the new serial number and save
                        $log->serial_number = $newSerialNumber;
                    }
                } else {
                    $newSerialNumber = date('Y') . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);

                    // Set the new serial number and save
                    $log->serial_number = $newSerialNumber;
                }
            });
        });
    }
}
