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

    public function render()
    {
        return view('livewire.page.resume', ['background' => $this->background, 'experience' => $this->experience, 'portfolio' => $this->portfolio, 'skills' => $this->skills, 'references' => $this->references]);
    }
}
