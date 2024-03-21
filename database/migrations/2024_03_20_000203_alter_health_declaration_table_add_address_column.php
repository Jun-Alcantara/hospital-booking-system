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
        Schema::table('patient_health_declaration_forms', function (Blueprint $table) {
            $table->string('unit_number')
                ->after('address')
                ->nullable();

            $table->string('barangay')
                ->after('unit_number')
                ->nullable();

            $table->string('municipality')
                ->after('barangay')
                ->nullable();

            $table->string('province')
                ->after('municipality')
                ->nullable();

            $table->string('country')
                ->after('province')
                ->nullable();
                
            $table->string('zip_code')
                ->after('country')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_health_declaration_forms', function (Blueprint $table) {
            $table->dropColumn([
                'unit_number',
                'barangay',
                'municipality',
                'province',
                'country',
                'zip_code',
            ]);
        });
    }
};
