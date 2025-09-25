<?php

namespace App\View\Components\Resume;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Skills extends Component
{
     public $skills = [];
     public $categories = [];

    /**
     * Create a new component instance.
     */
    public function __construct($params)
    {
        $skills = [];
        foreach ($params as $key => $item) {
            $cat = $item['category'];
            if (!in_array($cat, $this->categories)) {
                $this->categories[] = $cat; 
            }
            if ($item['sub_category']!==null) {
                $skills[$cat][$item['sub_category']] = [$item['description'],$item['level']];
            }else{
                $skills[$cat][] = [$item['description'],$item['level']];
            }
        }
        $this->skills = $skills;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resume.skills');
    }
}
