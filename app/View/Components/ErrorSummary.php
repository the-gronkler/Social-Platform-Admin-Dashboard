<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ErrorSummary extends Component
{
    public function __construct()
    {
    }

    public function render(): View
    {
        return view('components.error-summary');
    }
}
