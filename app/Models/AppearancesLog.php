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
                $latestSerialNumber = self::max('serial_number');

                if($latestSerialNumber) {

                } else {
                    $newSerialNumber = date('Y') . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);

                    // Set the new serial number and save
                    $log->serial_number = $newSerialNumber;
                }
            });
        });
    }
}
