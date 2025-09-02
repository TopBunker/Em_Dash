<?php

namespace App\Services;

use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

use function PHPUnit\Framework\isArray;

class ResumeService
{
    /**
     * Automatically remove id references 
     * @param mixed $object 
     * @param string $id 
     * @return array 
     */
    public static function scrubId(array $collection, array | string $id = 'id'): array {
        $scrubbedLayer = [];
        $object = $collection;
        $keys = array_keys($object);
        if(is_array($id)){
            $scrubbed = $object;
            for ($i=0; $i < count($id); $i++) { 
                $scrubbed = ResumeService::scrubId($scrubbed, $id[$i]);   
            }
            $scrubbedLayer = $scrubbed;
        }else{
            $reg = '';
            if($id === 'id'){
                $reg = '/^id\b$|_id\b$/';
            }else{
                $reg = '/^'.$id.'$/';
            }
            foreach($keys as $key){
                // filter strings not matching regex $id or *_$id
                $value = $object[$key];
                if(is_int($key)){
                    if(is_array($value)){
                        $scrubbedLayer[$key] = ResumeService::scrubId($value, $id);
                    }else{
                        $scrubbedLayer[$key] = $value;
                    }
                }else{
                    $res = preg_match($reg, strtolower($key));
                    if(!($res > 0)){
                        if(is_array($value)){
                            //scrub sub array if not empty
                            if(count($value) > 0){
                                $scrubbedLayer[$key] = ResumeService::scrubId($value, $id);
                            }else{
                                $scrubbedLayer[$key] = $value;
                            }
                        }else{
                            $scrubbedLayer[$key] = $value;
                        }
                    }
                }
            }
        }
        return $scrubbedLayer;
    }

   /**
    * Assemble user resume for render.
    */
    public static function show(string $id = ''): array {
        if($id === ''){
            $user_id = User::first()->id;
        }{
            $user_id = $id;
        }
        
        $resId = Resume::where('user_id', $user_id)->value('id');

        $collection = Resume::select('id','hasPort','summary')
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
                     }])->find($resId)->toArray();
        $background['summary'] = $collection['summary'];
        $background['educations'] = ResumeService::scrubId($collection['educations'],['id','code']);
        $skills = ResumeService::scrubId($collection['skills']);

        $references = ResumeService::scrubId($collection['references']);

        $collection = Experience::select('id','start_date','end_date','position','employer','business_type')
                    ->where('resume_id', $resId)
                    ->with([
                        'tasks:id,experience_id,heading,task',
                        'accomplishments:id,experience_id,heading,accomplishment',
                        'employerAddress:id,addressable_id,line_1,line_2,city,state,country_code',
                        'employerAddress.country:code,name'
                        ])
                    ->get()->toArray();
        $experience = [];
        $theads = [];
        $aheads = [];
        foreach($collection as $exp){
            foreach ($exp['tasks'] as $tsk) {
                $theads[] = $tsk['heading']; 
            }
            foreach ($exp['accomplishments'] as $accom){
                $aheads[] = $accom['heading'];
            }
            $experience['experiences'][] = ResumeService::scrubId($exp,['id','code']);
        }
        $experience['headings'] = array_unique(array_merge($theads, $aheads));

        $collection = Portfolio::select('id','title','description','file_name','link')
                    ->where('resume_id', $resId)
                    ->get()->toArray();;
        $portfolio = $collection;
        $resume = ['background'=>$background,'experience'=>$experience,'portfolio'=>$portfolio,'skills'=>$skills,'references'=>$references];          
        return $resume;
    }
}
