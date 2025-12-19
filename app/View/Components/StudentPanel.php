<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class StudentPanel extends Component
{
    public function render(): View
    {
        // Mengarah ke file resources/views/layouts/student-panel.blade.php
        return view('layouts.student-panel');
    }
}