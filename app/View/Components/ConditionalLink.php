<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;

class ConditionalLink extends Component
{
    public string $action;
    public $model;
    public string $cssClass;
    public ?string $tooltip = null;
    public string $href;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $action,
               $model,
        string $cssClass = 'button-primary',
        ?string $tooltip = null,
        string $href = '#'
    )
    {
        if ($tooltip === null || $tooltip === '')
            $tooltip = "You don't have permissions to perform this action";

        $this->action = $action;
        $this->model = $model;
        $this->cssClass = $cssClass;
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
