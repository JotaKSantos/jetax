<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
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
     * A detecção de erro via $errors é feita no Blade template.
     */
    public function inputClasses(bool $hasError = false): string
    {
        $base = 'w-full rounded-lg px-4 text-sm transition-all outline-none';

        if ($this->readonly || $this->attributes->get('readonly') !== null) {
            return $base.' bg-slate-100 border border-slate-200 text-slate-400 cursor-default';
        }

        if ($hasError || $this->state === 'error') {
            return $base.' bg-red-50 border border-red-500 focus:border-red-500 focus:shadow-[0_0_0_2px_rgba(239,68,68,0.1)]';
        }

        return match ($this->state) {
            'warning' => $base.' bg-amber-50 border border-amber-500 focus:border-amber-500 focus:shadow-[0_0_0_2px_rgba(245,158,11,0.1)]',
            'success' => $base.' bg-green-50 border border-green-500 focus:border-green-500 focus:shadow-[0_0_0_2px_rgba(34,197,94,0.1)]',
            default => $base.' bg-[#f3f3ff] border border-[#e2e6f1] focus:bg-white focus:border-[#0061a5] focus:shadow-[0_0_0_2px_rgba(0,97,165,0.1)]',
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
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.input');
    }
}
