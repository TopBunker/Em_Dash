<?php

namespace App\View\Components\Resume;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Background extends Component
{

    public $summary = '';
    public $educations = [];

    /**
     * Create a new component instance.
     */
    public function __construct($params)
    {

        $this->summary = $params['summary'];
        $this->educations = $params['educations'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resume.background');
    }
}
