<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;

class ConditionalLink extends Component
{
    public string $action;
    public $model;
    public string $linkClass;
    public ?string $tooltip = null;
    public string $href;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $action,
               $model,
        string $linkClass = 'button-primary',
        ?string $tooltip = null,
        string $href = '#'
    )
    {
        $this->action = $action;
        $this->model = $model;
        $this->linkClass = $linkClass;
        $this->tooltip = $tooltip;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.conditional-link', [
            'model' => $this->model,
            'tooltip' => $this->tooltip
        ]);
    }
}
