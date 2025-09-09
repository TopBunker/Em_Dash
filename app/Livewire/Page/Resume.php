<?php

namespace App\Livewire\Page;

use App\Services\ResumeService;
use Livewire\Component;

class Resume extends Component
{
    public $background = [];
    public $experience = [];
    public $portfolio = [];
    public $skills = [];
    public $references = [];
    public $hasSettings = true;

    public function mount(string $userId): void {
        $resume = ResumeService::show($userId);
        $this->background = $resume['background'];
        $this->experience = $resume['experience'];
        $this->skills = $resume['skills'];
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
            foreach ($array as $key => $item) {
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
        return view('livewire.page.resume', ['background' => $this->background, 'experience' => $this->experience, 'portfolio' => $this->portfolio, 'skills' => $this->skills, 'references' => $this->references]);
    }
}
