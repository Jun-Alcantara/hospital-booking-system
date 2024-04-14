<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class UpdateBookingReferenceNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-booking-reference-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Booking::all()->map(function ($booking) {

        });
    }
}
