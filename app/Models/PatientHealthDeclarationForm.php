<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHealthDeclarationForm extends Model
{
    use HasFactory;
    
    protected $fillable = ['booking_id', 'firstname', 'middlename', 'lastname', 'gender', 'dob', 'age', 'contact_number', 'occupation', 'address', 'unit_number', 'barangay', 'municipality', 'province', 'country', 'zip_code', 'questions'];
}
