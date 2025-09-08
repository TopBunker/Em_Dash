<?php

namespace App\Livewire\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{

    public $hasSettings = false;

    public function render()
    {
        return view('livewire.page.contact');
    }
}
