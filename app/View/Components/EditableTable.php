<?php

namespace App\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class EditableTable extends Component
{
    public $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Factory
     */
    public function render()
    {
        return view('components.editable-table');
    }
}
