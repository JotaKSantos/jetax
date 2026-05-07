<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class AuthLayout extends Component
{
    public function __construct(
        public string $title = '',
        public string $subtitle = '',
        public string $logo = '',
    ) {}

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.auth-layout');
    }
}
