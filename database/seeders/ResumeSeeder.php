<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Resume;
use App\Models\ResumeAccess;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ResumeSeeder extends Seeder
{
    /**
     * Run the Resume seeds.
     */
    public function run(): void
    {
        // Faker (for testing)
        Resume::factory()
                ->hasPersonalAddress()
                ->hasImage()
                ->hasSkills()
                ->hasReferences(3)
                ->hasPortfolios()
                ->has(Education::factory()->hasEduDetail()->hasEduCertificates()->hasInstitutionAddress(), 'educations')
                ->has(Experience::factory()->count(3)->hasEmployerAddress()->hasTasks(3)->hasAccomplishments(3))
                ->create();
    }
}
