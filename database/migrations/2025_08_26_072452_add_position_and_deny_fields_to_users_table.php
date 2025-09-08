<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appearances_logs', function (Blueprint $table) {
            // Add the position field (nullable)
            $table->string('position')->nullable()->after('fullname');

            // Add checkbox fields (nullable)
            $table->boolean('accommodation_provided')->nullable()->after('company');
            $table->text('accommodation_remarks')->nullable()->after('accommodation_provided');
            
            $table->boolean('food_provided')->nullable()->after('accommodation_remarks');
            $table->text('food_remarks')->nullable()->after('food_provided');
            
            $table->boolean('transportation_provided')->nullable()->after('food_remarks');
            $table->text('transportation_remarks')->nullable()->after('transportation_provided');
            
            $table->boolean('others_provided')->nullable()->after('transportation_remarks');
            $table->text('others_remarks')->nullable()->after('others_provided');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appearances_logs', function (Blueprint $table) {
            // Drop the columns if the migration is rolled back
            $table->dropColumn([
                'position',
                'accommodation_provided', 'accommodation_remarks',
                'food_provided', 'food_remarks',
                'transportation_provided', 'transportation_remarks',
                'others_provided', 'others_remarks'
            ]);
        });
    }
};
