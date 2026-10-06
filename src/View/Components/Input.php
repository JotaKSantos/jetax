<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;

class Input extends Component
{
    use FieldStyles;

    /**
     * Tipos de input disponíveis.
     */
    public const TYPES = ['text', 'email', 'password', 'number', 'date', 'search'];

    /**
     * Presets de máscara disponíveis.
     */
    public const MASK_PRESETS = [
        'cpf' => '###.###.###-##',
        'cnpj' => '##.###.###/####-##',
        'phone' => '(##) #####-####',
        'cep' => '#####-###',
        'date' => '##/##/####',
    ];

    /**
     * Cria uma nova instância do componente de input.
     */
    public function __construct(
        public string $type = 'text',
        public string $name = '',
        public string $label = '',
        public string $icon = '',
        public string $mask = '',
        public string $state = '',
        public string $message = '',
        public bool $readonly = false,
    ) {}

    /**
     * Retorna o padrão de máscara Alpine.js para o tipo fornecido.
     */
    public function maskPattern(): string
    {
        if (empty($this->mask)) {
            return '';
        }

        return self::MASK_PRESETS[$this->mask] ?? $this->mask;
    }

    /**
     * Indica se há máscara configurada.
     */
    public function hasMask(): bool
    {
        return ! empty($this->mask);
    }

    /**
     * Retorna as classes CSS do input baseadas no estado atual.
     * A detecção de erro via $errors é feita no Blade template. A altura de
     * 40px vem da classe h-10, nunca de style inline.
     */
    public function inputClasses(bool $hasError = false): string
    {
        $base = 'w-full h-10 rounded-lg px-4 text-sm transition-all outline-none';

        if ($this->readonly || $this->attributes?->get('readonly') !== null) {
            return $base.' bg-surface-container-low border border-outline-variant text-on-surface/40 cursor-default';
        }

        if ($hasError || $this->state === 'error') {
            return $base.' bg-error-container/30 border border-error text-on-surface focus:border-error focus:ring-2 focus:ring-error/20';
        }

        return match ($this->state) {
            'warning' => $base.' bg-surface-input border border-warning text-on-surface focus:border-warning focus:ring-2 focus:ring-warning/20',
            'success' => $base.' bg-surface-input border border-success text-on-surface focus:border-success focus:ring-2 focus:ring-success/20',
            default => $base.' bg-surface-input border border-outline-variant text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20',
        };
    }

    /**
     * Retorna as classes CSS da mensagem de estado.
     * A detecção de erro via $errors é feita no Blade template.
     */
    public function messageClasses(bool $hasError = false): string
    {
        return $this->fieldMessageClasses($hasError ? 'error' : $this->state);
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.input');
    }
}
