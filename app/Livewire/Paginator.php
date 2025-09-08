<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\{Layout, Locked, On};
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Paginator extends Component
{
    #[Locked]
    private $user;

    #[Locked]
    private string $userId = '';
    
    public string $activeComponent = '';
    
    public $loadedComponents = [];

    public function mount(string $id = 'main'): void {
        // initiate user state
        if($id !== 'main'){
            $this->user = User::find($id);
        }
        if($id === 'main'){
            $this->user = User::first();
        }
        $this->userId = $this->user->id;
        
        $this->setComponent('resume');
    }

    /**
     * Dynamically navigate pages
     * @param mixed $active 
     * @return void 
     */
    #[On('switchTo')]
    public function setComponent(string $active): void { 
        $component = 'page.'.$active;
        $this->activeComponent = $component;

        if(!in_array($component, $this->loadedComponents)){
            $this->loadedComponents[] = $this->activeComponent;
        }
     }

    public function render()
    {
        return view('livewire.paginator', ['userId' => $this->userId]);
    }
}
