<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id', 'name'
    ];
}
