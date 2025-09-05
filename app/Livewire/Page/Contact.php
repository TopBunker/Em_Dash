<?php

namespace App\Livewire\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Contact extends Component
{
    public function render()
    {
        return view('livewire.page.contact');
    }
}
