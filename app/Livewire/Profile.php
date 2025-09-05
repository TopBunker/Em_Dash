<?php

namespace App\Livewire;

use App\Livewire\Layouts\Footer;
use App\Models\User;
use Livewire\Attributes\{Layout, Locked, On};
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Profile extends Component
{
    #[Locked]
    private $user;

    #[Locked]
    private string $userId = ''; //to-do: protect
    
    public string $activeComponent = 'page.resume';
    
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
        
        $this->activeComponent = 'page.resume';

        $this->loadedComponents[] = $this->activeComponent;

        $this->setComponent('resume');
    }

    /**
     * Getter for active component
     * @return string 
     */
    public function getActive(): string {
        $component = preg_split('/./', $this->activeComponent);
        return array_pop($component);
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
        return view('livewire.profile', ['userId' => $this->userId]);
    }
}
