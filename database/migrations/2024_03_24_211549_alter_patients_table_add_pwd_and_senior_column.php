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
        Schema::table('patients', function (Blueprint $table) {
            $table->tinyInteger('philhealth_member')
                ->after('lastname')
                ->default(0);

            $table->tinyInteger('pwd')
                ->after('philhealth_member')
                ->default(0);

            $table->tinyInteger('senior')
                ->after('pwd')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['philhealth_member', 'pwd', 'senior']);
        });
    }
};
