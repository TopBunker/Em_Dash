<?php

namespace App\Services;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Image;
use App\Models\Portfolio;
use App\Models\Resume;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Arr;

class ResumeService
{
    public static function flatten($collection): array {
        if($collection === null){
            return [];
        }else{
            
            $keys = array_keys($collection->toArray()[0]);
            $package = [];
            foreach ($collection->toArray() as $element) {
                $prepackage = [];
                foreach ($keys as $key) {
                    $prepackage[$key] = $element[$key];
                }
                $package[] = $prepackage;
            }
            return $package;
        }
    }

   /**
    * Construct user resume.
    */
    public static function show(string $id): Array {
        if(is_null($id)){
            $user_id = User::first()->id;
        }{
            $user_id = $id;
        }
        
        $resId = Resume::where('user_id', $user_id)->value('id');

        $resume = Resume::select('id','title','hasPort','summary')
                    ->with([
                        'skills:id,resume_id,category,description,level',
                        'references:id,resume_id,referee,referral',
                        'educations' => function ($query){
                            $query->select('id','resume_id','institution','start_date','end_date','degree','level')
                            ->with([
                            'eduDetail:education_id,detail',
                            'eduCertificates:id,education_id,title,issued_by,issued_at,file_name',
                            'institutionAddress:id,addressable_id,line_1,line_2,city,state,country_code',
                            'institutionAddress.country:code,name'
                            ]);
                     }])->find($resId);

        $background['summary'] = $resume->summary;
        $educations = [];
        if($resume->education){
            foreach ($resume->educations as $education) {
                $educations[] = ['startDate' => $education->start_date, 'endDate' => $education->end_date, 'degree' => $education->degree];
            }
        }
        $background['educations'] = $educations;

        $references = [];
        if($resume->references){
            foreach ($resume->references as $reference) {
                $references[] = ['referral' => $reference->referral, 'referee' => $reference->referee];
            }
        }

        $skills = [];
        if($resume->skills){
            foreach ($resume->skills as $skill) {
                $skills[] = ['category' => $skill->category, 'description' => $skill->description, 'level' => $skill->level];
            }
        }

        $collection = Experience::select('id','start_date','end_date','position','employer','business_type')
                    ->where('resume_id', $resId)
                    ->with([
                        'tasks:id,experience_id,heading,task',
                        'accomplishments:id,experience_id,heading,accomplishment',
                        'employerAddress:id,addressable_id,line_1,line_2,city,state,country_code',
                        'employerAddress.country:code,name'
                        ])
                    ->get();
        $experience = ResumeService::flatten($collection);

        $collection = Portfolio::select('id','title','description','file_name','link')
                    ->where('resume_id', $resId)
                    ->get();
        $portfolio = ResumeService::flatten($collection);
        $resume = ['background'=>$background,'experience'=>$experience,'portfolio'=>$portfolio,'skills'=>$skills,'references'=>$references];          
                        
        return $resume;
    }
}
