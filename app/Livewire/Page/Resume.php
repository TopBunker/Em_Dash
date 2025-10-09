<?php

namespace App\Livewire\Page;

use App\Services\ResumeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Resume extends Component
{
    public $background = [];
    public $experience = [];
    public $portfolio = [];
    public $skills = [];
    public $references = [];
    public $hasSettings = true;

    public function mount(string $userId): void {
        $resume = ResumeService::getResume($userId);
        $this->background = $resume['background'];
        $this->experience = $resume['experience'];
        $this->skills = $resume['skills'];
        session()->put('resume_download', $resume['file']);
        if(count($resume['references']) > 0){
            $this->references = $resume['references'];
        }
    }

    /**
     * Check for value in array recursively
     * @param mixed $value 
     * @param mixed $array 
     * @return true|false 
     */
    public function hasValue(string $value, array $array): bool {
        if(!empty($array)){
            foreach ($array as $item) {
                if(is_array($item)){
                    if($this->hasValue($value, $item)){
                        return true;
                    }
                }elseif($item === $value){
                    return true;
                }
            }
        }
        return false;
    }

    public function render()
    {
        $authorized = session('authorized');
        if ($authorized) {
            return view('livewire.page.resume', ['background' => $this->background, 'experience' => $this->experience, 'portfolio' => $this->portfolio, 'skills' => $this->skills, 'references' => $this->references]);
        }else {
            return view('livewire.page.resume-access');
        }
    }
}
