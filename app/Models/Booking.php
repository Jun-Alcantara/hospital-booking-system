<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    public const FOR_ASSESSMENT = 0;
    public const APPROVED = 1;
    public const FOR_APPROVAL = 2;
    public const CANCELED = 3;
    public const FOR_RESCHEDULING = 4;
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
                return 'FOR ASSESSMENT';
                break;
            case 1: 
                return 'APPROVED';
                break;
            case 2:
                return 'FOR APPROVAL';
                break;
            case 3:
                return 'CANCELED';
                break;
            case 4: 
                return 'FOR RESCHEDULING';
                break;
            default:
                return 'COMPLETED';
                break;
        }
    }

    public function scopeFilterByRole(Builder $query, User $user): void
    {
        $query->when($user->role_id == User::TRIAGE_OFFICER, function ($q) {
            $q->where('bookings.status', Booking::FOR_ASSESSMENT);
        });

        $query->when($user->role_id == User::ADMISSION_COORDINATOR, function ($q) {
            $q->where('bookings.status', BOoking::FOR_APPROVAL);
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function healthDeclarationForm()
    {
        return $this->hasMany(PatientHealthDeclarationForm::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(ClinicDepartment::class, 'clinic_department_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }
}
