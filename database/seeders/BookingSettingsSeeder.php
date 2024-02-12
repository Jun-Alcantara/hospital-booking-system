<?php

namespace Database\Seeders;

use App\Models\BookingSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookingSettings::UpdateOrCreate([
            'id' => 1
        ], [
            'max_booking_per_day' => 250,
            'visit_start' => 6,
            'visit_end' => 18
        ]);
    }
}
