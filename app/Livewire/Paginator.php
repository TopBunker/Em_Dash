<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\{Layout, Locked, On};
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Paginator extends Component
{
    #[Locked]
    private $user;

    #[Locked]
    public string $userId = '';
    
    #[Locked]
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

        $authorized = Cache::get('authorized_'.session()->getId(), false);
        if ($authorized) {
            $this->setComponent('resume');
        }else{
             $this->setComponent('resume-access');
        }
    }

    /**
     * Dynamically navigate pages
     * @param mixed $active 
     * @return void 
     */
    #[On('switchTo')]
    public function setComponent(string $active): void { 
        $component = '';
        $authorized = Cache::get('authorized_'.session()->getId(), false);
        if ($active === 'resume') {
            if ($authorized) {
                $component = 'page.'.$active;
            }else{
                $component = 'page.resume-access';
            } 
        } else {
            $component = 'page.'.$active;
        }
        $this->activeComponent = $component;

        if(!in_array($component, $this->loadedComponents)){
            $this->loadedComponents[] = $this->activeComponent;
        }
     }

    #[On('authorize')]
    public function refresh(){
        $this->setComponent('resume');
    }

    public function render()
    {
        return view('livewire.paginator', ['userId' => $this->userId]);
    }
}
