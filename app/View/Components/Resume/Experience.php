<?php

namespace App\View\Components\Resume;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Experience extends Component
{
     public $experiences = [];
     public $headings = [];


    /**
     * Create a new component instance.
     */
    public function __construct($params = [])
    {
        $this->headings = $params['headings'];
        $this->experiences = $params['experiences'];
    } 

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resume.experience');
    }
}
