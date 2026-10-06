<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;

class Textarea extends Component
{
    use FieldStyles;

    /**
     * Cria uma nova instância do componente de textarea.
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public int $rows = 4,
        public bool $autoResize = false,
        public string $state = '',
        public string $message = '',
    ) {}

    /**
     * Retorna as classes CSS do textarea baseadas no estado atual.
     * A detecção de erro via $errors é feita no Blade template.
     */
    public function textareaClasses(bool $hasError = false): string
    {
        $base = 'w-full rounded-lg px-4 py-3 text-sm transition-all outline-none resize-none';

        if ($this->attributes->get('disabled') !== null || $this->attributes->has('disabled')) {
            return $base.' bg-surface-container-low border border-outline-variant text-on-surface/40 cursor-not-allowed opacity-50';
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
        return view('jetax::components.textarea');
    }
}
