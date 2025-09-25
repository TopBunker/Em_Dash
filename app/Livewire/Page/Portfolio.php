<?php

namespace App\Livewire\Page;

use App\Models\User;
use App\Services\ResumeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Portfolio extends Component
{
    public $hasSettings = false;
    
    public $portfolios =[];

    #[Locked]
    public $script = '';


    public function mount(string $userId): void {
        $portfolios = ResumeService::getPortfolio($userId);
        $this->portfolios = $portfolios;
    }

    /**
     * Trigger file download in browser
     * @return BinaryFileResponse|RedirectResponse
     */
    public function download(string $file): StreamedResponse|RedirectResponse {
        if(Storage::disk('public')->exists($file)){
            return Storage::disk('public')->download($file);
        }else{
            return back()->with('error', 'File not found.');
        }  
    }

    
    public function render()
    {
        return view('livewire.page.portfolio');
    }
}
