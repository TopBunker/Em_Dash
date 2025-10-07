<?php

namespace App\Livewire\Page;

use App\Models\ResumeAccess as ModelsResumeAccess;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ResumeAccess extends Component
{
    public $password = '';

    #[Locked]
    public $authorized = false;

    #[Locked]
    public $userId = '';

    public function checkPassword() {
        $key = ModelsResumeAccess::where('user_id', $this->userId)->sole()->access_key;
        if (Hash::check($this->password, $key)) {
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
