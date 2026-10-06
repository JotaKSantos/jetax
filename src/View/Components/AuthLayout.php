<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthLayout extends Component
{
    public function __construct(
        public string $title = '',
        public string $subtitle = '',
        public string $logo = '',
    ) {}

    public function render(): View
    {
        return view('jetax::components.auth-layout');
    }
}
