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
    public $references = [];
    public $skills = [];

    public function mount(string $userId): void {
        $resume = ResumeService::show($userId);
        $this->background = Arr::from($resume['background']);
        $this->experience = Arr::from($resume['experience']);
        $this->portfolio = Arr::from($resume['portfolio']);
        $this->references = Arr::from($resume['references']);
        $this->skills = Arr::from($resume['skills']);
    }

    public function render()
    {
        return view('livewire.pages.classic');
    }
}
