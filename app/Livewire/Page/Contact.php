<?php

namespace App\Livewire\Page;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use InvalidArgumentException;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class Contact extends Component
{
    use WithFileUploads;

    #[Validate('required', message: 'Please provide the name of either an organization or individual for reference.')]
    public string $name = '';

    #[Validate('required', message: 'Please provide an email address for follow-up.')]
    #[Validate('email', message: 'Please provide a valid email address.')]
    public string $email = '';

    #[Validate('required', message: 'Please include a clear subject.')]
    public string $subject = '';

    #[Validate('required', message: 'A message body is required.')]
    public string $message = '';

    #[Validate(['uploads.*' => 'file|nullable|mimetypes:application/pdf,application/msword|mimes:pdf,doc,docx|extensions:pdf,doc,docx'])]
    public $uploads = [];

    public string $fielder = ''; // Honeypot field for bot detection

    /**
     * Save message and send response.
     * @return RedirectResponse 
     * @throws InvalidArgumentException 
     * @throws ValidationException 
     */
    public function send() {
        if (!empty($this->fielder)) {
            // Bot detected via honeypot field
            return;
        }

        if (RateLimiter::tooManyAttempts('contact-form:'.$this->email, 3)) {
            $this->addError('fielder', 'Too many attempts. Please wait a minute and try again.');
            return;
        }

        RateLimiter::hit('contact-form:'.$this->email);

        $this->validate();

        try{ 
            $result = DB::transaction( function () {
                $message = Message::create([
                    'user_id' => $this->userId,
                    'name' => $this->name,
                    'mail' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                ]);

                if (!empty($this->uploads)) {
                    foreach ($this->uploads as $upload) {
                        $location = $upload->store(path: 'documents');
                        $message->documents()->create([
                            'file_location' => $location,
                        ]);
                    }
                }

                return $message;
            });
            if ($result) {
                $this->reset();
                return back()->with('success', 'Message sent!');
            } else {
                return back()->with('error', 'Message could not be sent. Please try again.');
            }
            
        } catch (Throwable $e) {
            report($e);
            return back()->with('error', 'Message could not be sent. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.page.contact');
    }
}
