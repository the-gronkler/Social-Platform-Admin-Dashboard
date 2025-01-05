<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConditionalButton extends Component
{
    public string $action;
    public $model;
    public string $buttonClass;
    public string $tooltip;
    public string $buttonType;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $action,
               $model,
        string $buttonClass = 'button-primary',
        string $tooltip = '',
        string $buttonType = 'submit',
    )
    {
        $this->action = $action;
        $this->model = $model;
        $this->buttonClass = $buttonClass;
        $this->tooltip = $tooltip;
        $this->buttonType = $buttonType;
    }



    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.conditional-button');
    }
}
