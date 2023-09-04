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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('division')->nullable();
            $table->boolean('first_login')->default(true);

            // Rename email to username and name to firstname
            $table->renameColumn('email', 'username');
            $table->renameColumn('name', 'firstname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns
            $table->dropColumn('middlename', 'lastname', 'division', 'suffix', 'first_login');

            // Rename email to username and name to firstname
            $table->renameColumn('username', 'email');
            $table->renameColumn('firstname', 'name');
        });
    }
};
