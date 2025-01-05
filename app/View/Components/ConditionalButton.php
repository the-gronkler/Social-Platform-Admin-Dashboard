<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConditionalButton extends Component
{
    public string $action;
    public $model;
    public string $cssClass;
    public ?string $tooltip = null;
    public string $buttonType;


    /**
     * Create a new component instance.
     */
    public function __construct(
        string $action,
               $model,
        string $cssClass = 'button-primary',
        ?string $tooltip = null,
        string $buttonType = 'submit',
        ?string $modelClass = null,
    )
    {
        $this->action = $action;
        $this->model = $model;
        $this->cssClass = $cssClass;
        $this->tooltip = $tooltip;
        $this->buttonType = $buttonType;
    }


    public function render(): View
    {

        return view('components.conditional-button', [
            'model' => $this->model,
            'tooltip' => $this->tooltip
        ]);
    }
}
