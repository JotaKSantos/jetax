<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
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
            return $base.' bg-red-50 border border-red-500 focus:border-red-500 focus:shadow-[0_0_0_2px_rgba(239,68,68,0.1)]';
        }

        return match ($this->state) {
            'warning' => $base.' bg-amber-50 border border-amber-500 focus:border-amber-500 focus:shadow-[0_0_0_2px_rgba(245,158,11,0.1)]',
            'success' => $base.' bg-green-50 border border-green-500 focus:border-green-500 focus:shadow-[0_0_0_2px_rgba(34,197,94,0.1)]',
            default => $base.' bg-surface-input border border-outline-variant text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20',
        };
    }

    /**
     * Retorna as classes CSS da mensagem de estado.
     * A detecção de erro via $errors é feita no Blade template.
     */
    public function messageClasses(bool $hasError = false): string
    {
        if ($hasError || $this->state === 'error') {
            return 'text-red-600 text-[10px] font-medium mt-1';
        }

        return match ($this->state) {
            'warning' => 'text-amber-600 text-[10px] font-medium mt-1',
            'success' => 'text-green-600 text-[10px] font-medium mt-1',
            default => 'text-slate-500 text-[10px] font-medium mt-1',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.textarea');
    }
}
