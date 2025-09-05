<?php

namespace App\Livewire\Page;

use App\Services\ResumeService;
use Illuminate\Support\Arr;
use Livewire\Component;

class Portfolio extends Component
{
    public $state = [];

    public function mount(string $userId): void {
        $resume = ResumeService::show($userId);
        $this->state['resume/background'] = Arr::from($resume['background']);
        $this->state['resume/experience'] = Arr::from($resume['experience']);
        $this->state['resume/portfolio'] = Arr::from($resume['portfolio']);
        $this->state['resume/references'] = Arr::from($resume['references']);
        $this->state['resume/skills'] = Arr::from($resume['skills']);
    }
    
    public function render()
    {
        return view('livewire.page.portfolio');
    }
}
