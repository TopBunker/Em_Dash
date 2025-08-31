<?php

namespace App\Livewire;

use App\Models\Image;
use App\Models\Resume;
use App\Models\User;
use App\Services\ResumeService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Welcome extends Component
{
    protected $user;

    public string $userId = '';
    
    public string $activeComponent = 'pages.classic';
    
    public $loadedComponents = [];

    public function mount(string $id = 'main'): void {
        if($id !== 'main'){
            $this->user = User::find($id);
        }
        if($id === 'main'){
            $this->user = User::first();
        }
        $this->userId = $this->user->id;
        
        $this->activeComponent = 'pages.classic';

        $this->loadedComponents[] = $this->activeComponent;
    }

    public function getActive(){
        return $this->activeComponent;
    }

    public function updatingActiveComponent($property, $value){
        if ($property === 'activeComponent') {
            dd($property);
        }
        dd($property, $value);
    }

    #[On('switchTo')]
    public function setComponent($active){
        $this->activeComponent = 'pages.'.$active;

        if(!in_array($active, $this->loadedComponents)){
            $this->loadedComponents[] = $this->activeComponent;
        }
     }
    
    public function render(): View
    {
        return view('livewire.welcome', ['userId' => $this->userId]);
    }
}
