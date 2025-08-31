<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Resume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
