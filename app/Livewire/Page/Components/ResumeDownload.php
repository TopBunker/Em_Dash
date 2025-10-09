<?php

namespace App\Livewire\Page\Components;

use Illuminate\Support\Facades\URL;
use Livewire\Component;

class ResumeDownload extends Component
{ 
    public string $downloadUrl = '';

    public function generateUrl() {
        $this->downloadUrl = URL::temporarySignedRoute('resume.download', now()->addMinutes(7));

        // Livewire handles redirect on the frontend
        $this->redirect($this->downloadUrl);
    }

    public function render()
    {
        return view('livewire.page.components.resume-download');
    }
}
