<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Bubble extends Component
{
    public $resume;

    public function mount(array $resume = []){
        $this->resume = $resume;
    }

    public function render()
    {
        return view('livewire.pages.bubble');
    }
}
