<?php

namespace App\Livewire\Pages;

use App\Services\ResumeService;
use Illuminate\Support\Arr;
use Livewire\Component;

class Classic extends Component
{
    public $background = [];
    public $experience = [];
    public $portfolio = [];
    public $skills = [];
    public $references = [];
    public $sections = ['Background', 'Experience', 'Skills'];

    public function mount(string $userId): void {
        $resume = ResumeService::show($userId);
        $this->background = $resume['background'];
        $this->experience = $resume['experience'];
        $this->skills = $resume['skills'];
        if(count($resume['references']) > 0){
            $this->references = $resume['references'];
            $this->sections[] = 'References';
        }
        if(count($resume['portfolio'])>0){
            $this->portfolio = $resume['portfolio'];
            $this->sections[] = 'Portfolio';
        }
    }

    public function render()
    {
        return view('livewire.pages.classic', ['background' => $this->background, 'experience' => $this->experience, 'portfolio' => $this->portfolio, 'skills' => $this->skills, 'references' => $this->references]);
    }
}
