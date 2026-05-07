<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Pin extends Component
{
    /**
     * Tipos de entrada disponíveis para o PIN/OTP.
     */
    public const TYPES = ['numeric', 'alphanumeric'];

    /**
     * Cria uma nova instância do componente Pin/OTP.
     */
    public function __construct(
        public int $length = 6,
        public string $type = 'numeric',
    ) {}

    /**
     * Retorna o padrão de input mode baseado no tipo.
     */
    public function inputMode(): string
    {
        return $this->type === 'numeric' ? 'numeric' : 'text';
    }

    /**
     * Retorna o padrão de validação baseado no tipo.
     */
    public function pattern(): string
    {
        return $this->type === 'numeric' ? '[0-9]' : '[a-zA-Z0-9]';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.pin');
    }
}
