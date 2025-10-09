<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    /**
     * Trigger file download in browser
     * @return BinaryFileResponse|RedirectResponse
     */
    public function download(): StreamedResponse|RedirectResponse {
        $authorized = session('authorized');
        if (!$authorized) {
            return back()->with('error', 'You are not authorized to download this file.');
        } else {
            $file = session('resume_download');
            // Check if file exists in storage
            if(Storage::exists($file)){
                return Storage::download($file);
            }else{
                return back()->with('error', 'File not found.');
            }  
        }
    }
}
