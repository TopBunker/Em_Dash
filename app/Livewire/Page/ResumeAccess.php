<?php

namespace App\Livewire\Page;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ResumeAccess extends Component
{
    public $password = '';

    #[Locked]
    public $authorized = false;

    public function checkPassword() {
        $password = env('RESUME_PASSWORD');
        if (Hash::check($this->password, $password)) {
            $this->authorized = true;
            Cache::put('authorized_'.session()->getId(), true, now()->addMinutes(60));
            $this->dispatch('authorize');
        } else {
            return back()->with('error', 'Incorrect password.');
        }
    }

    public function render()
    {
        return view('livewire.page.resume-access');
    }
}
