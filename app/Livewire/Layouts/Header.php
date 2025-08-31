<?php

namespace App\Livewire\Layouts;

use App\Models\Image;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Header extends Component
{
    
    public string $fName = 'Jordane';
    public string $lName = 'Delahaye';
    public array $contact = [];
    public string $image = 'system/profile-picture-placeholder.png';
    public string $title = 'Problem Solver';

    public $userId;

    public function mount($userId){
        $this->userId = $userId;
        $user = User::find($userId);

        if(isset($user)){
            $this->lName = $user->last_name;
            $this->fName = $user->first_name;
            $mail = $user->email;
            $contact = array('email'=>$mail);

            if(Schema::hasTable('resumes')){
                $resume = Resume::select('id','title','tel','hasImage','status')
                    ->where('user_id', $userId)
                    ->with([
                        'personalAddress:id,addressable_id,line_1,line_2,city,state,country_code',
                        'personalAddress.country:code,name'
                    ])
                    ->first();
                $this->title = $resume->title;

                if(Schema::hasTable('images') && $resume->hasImage){
                    $fileName = Image::where('resume_id',$resume->id)->value('file_name');
                    $this->image = 'user/'.$fileName;
                }

                $contact['tel'] = $resume->tel;
                $contact['address'] = $resume->personalAddress;
                $this->contact = $contact;
            }else{
                return 'No resume found.';
            }
        }{
            return 'Unknown user.';
        }
    }
    
    public function render()
    {
        return view('livewire.layouts.header');
    }
}
