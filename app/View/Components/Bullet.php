<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bullet extends Component
{
    public int $type;
    public string $item;

    /**
     * Create a new component instance.
     */
    public function __construct(int $type, string $item)
    {
        $this->type = $type;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bullet');
    }
}
