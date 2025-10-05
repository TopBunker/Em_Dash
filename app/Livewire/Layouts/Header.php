<?php

namespace App\Livewire\Layouts;

use App\Models\Image;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    
    #[Locked]
    public string $fName = 'Jordane';

    #[Locked]
    public string $lName = 'Delahaye';

    #[Locked]
    public array $contact = [];

    #[Locked]
    public string $image = 'system/profile-picture-placeholder.png';

    #[Locked]
    public string $title = 'Problem Solver';

    protected string $userId;

    public function mount($userId){
        $this->userId = $userId;
        $user = User::find($userId);

        if(isset($user)){
            $this->lName = $user->last_name;
            $this->fName = $user->first_name;
            $mail = preg_split('/@|\.(?=[^.]+$)/', $user->email, 3);
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
                    $fileName = Image::where('resume_id',$resume->id)->value('file_location');
                    $this->image = $fileName;
                }

                $contact['tel'] = preg_split('/\s+/', $resume->tel);
                $contact['address'] = $resume->personalAddress;
                $this->contact = $contact;
            }else{
                return 'No resume found.';
            }
        }{
            return 'Unknown user.';
        }
    }

    #[On('authorize')]
    public function refresh(){}
    
    public function render()
    {
        $authorized = Cache::get('authorized_'.session()->getId(), false);
        return view('livewire.layouts.header', ['authorized' => $authorized]);
    }
}
