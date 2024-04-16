<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email', 'firstname', 'middlename', 'lastname', 'philhealth_member', 'pwd', 'senior', 'verification_code'
    ];

    public function emailIsVerified()
    {
        return $this->email_verified_at != null;
    }
}
