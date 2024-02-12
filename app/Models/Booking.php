<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const RESCHEDULED = 2;
    public const CANCELED = 3;
    public const COMPLETED = 5;

    protected $fillable = [
        'reference_number', 'patient_id', 'booking_date', 'note', 'status', 'clinic_id', 'clinic_department_id'
    ];

    public $casts = [
        'booking_date' => 'datetime'
    ];

    protected $appends = [
        'status_name'
    ];

    public function getRouteKeyName(): string
    {
        return 'reference_number';
    }

    public static function newReferenceNumber($uniqueDigit = null): string
    {
        return 'B' . now()->format('Ymdhis') . $uniqueDigit;
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'PENDING';
                break;
            case 1: 
                return 'APPROVE';
                break;
            case 2:
                return 'RESCHEDULED';
                break;
            case 3:
                return 'CANCELED';
                break;
            default:
                return 'COMPLETED';
                break;
        }
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function healthDeclarationForm(): HasOne
    {
        return $this->hasONe(PatientHealthDeclarationForm::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(ClinicDepartment::class, 'clinic_department_id');
    }
}
