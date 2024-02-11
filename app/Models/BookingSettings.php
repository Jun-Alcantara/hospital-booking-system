<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSettings extends Model
{
    use HasFactory;

    protected $fillable = ['max_booking_per_day', 'visit_start', 'visit_end'];

    protected $casts = [
        'visit_start' => 'integer',
        'visit_end' => 'integer'
    ];
}
