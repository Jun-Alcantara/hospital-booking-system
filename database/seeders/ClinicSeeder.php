<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clinic;
use App\Models\ClinicDepartment;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            'Internal Medicine' => [
                'Pulmonary',
                'Cardiology',
                'Neurology',
                'Nephrology',
                'Diabetes',
                'Dermatology'
            ],
            'Pediatrics' => [
                'Pedia-Cardio',
                'Pedia-Nephrology',
                'Pedia-Neurology',
                'Adolescent'
            ],
            'Family Medicine' => [
                'Geriatrics'
            ],
            'Surgery' => [
                'ENT',
                'Orthopedic',
                'Neorology',
                'Elective Minor Procedure',
                'Elective Major Procedure'
            ],
            'OB-Gyne' => [
                'Prenatal Check-up'
            ],
            'Dental' => [], 
            'Specialty Clinic' => [
                'Heart Station',
                'Ultrasound'
            ]
        ];

        foreach ($clinics as $clinic => $departments) {
            $c = Clinic::create([
                'name' => $clinic
            ]);

            foreach ($departments as $department) {
                ClinicDepartment::create([
                    'clinic_id' => $c->id,
                    'name' => $department
                ]);
            }
        }
    }
}
