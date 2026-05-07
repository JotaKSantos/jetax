<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    /**
     * Tamanhos disponíveis para o avatar.
     */
    public const SIZES = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];

    /**
     * Status disponíveis para o indicador de presença.
     */
    public const STATUSES = ['online', 'offline', 'blocked'];

    /**
     * Cores de fundo para iniciais — usadas de forma determinística por hash do nome.
     */
    public const INITIALS_COLORS = [
        'bg-blue-500',
        'bg-emerald-500',
        'bg-violet-500',
        'bg-amber-500',
        'bg-rose-500',
        'bg-sky-500',
        'bg-teal-500',
        'bg-orange-500',
        'bg-pink-500',
        'bg-indigo-500',
    ];

    /**
     * Iniciais extraídas do nome.
     */
    public string $initials;

    /**
     * Cor de fundo gerada por hash do nome.
     */
    public string $initialsColor;

    /**
     * Cria uma nova instância do componente Avatar.
     */
    public function __construct(
        public ?string $src = null,
        public string $name = '',
        public string $size = 'md',
        public bool $rounded = true,
        public ?string $status = null,
    ) {
        $this->initials = $this->extractInitials($name);
        $this->initialsColor = $this->resolveInitialsColor($name);
    }

    /**
     * Extrai as iniciais do nome: primeira letra do primeiro e do último nome.
     */
    public function extractInitials(string $name): string
    {
        $name = trim($name);

        if ($name === '') {
            return '?';
        }

        $parts = preg_split('/\s+/', $name);

        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 1));
        }

        $first = mb_strtoupper(mb_substr($parts[0], 0, 1));
        $last = mb_strtoupper(mb_substr($parts[count($parts) - 1], 0, 1));

        return $first.$last;
    }

    /**
     * Determina a cor de fundo de forma determinística pelo hash do nome.
     */
    public function resolveInitialsColor(string $name): string
    {
        if ($name === '') {
            return self::INITIALS_COLORS[0];
        }

        $index = abs(crc32($name)) % count(self::INITIALS_COLORS);

        return self::INITIALS_COLORS[$index];
    }

    /**
     * Retorna as classes de dimensão para o tamanho configurado.
     */
    public function sizeClasses(): string
    {
        return match ($this->size) {
            'xs' => 'w-6 h-6',
            'sm' => 'w-8 h-8',
            'lg' => 'w-12 h-12',
            'xl' => 'w-16 h-16',
            'xxl' => 'w-24 h-24',
            default => 'w-10 h-10',
        };
    }

    /**
     * Retorna a classe de arredondamento conforme o formato configurado.
     */
    public function roundedClass(): string
    {
        return $this->rounded ? 'rounded-full' : 'rounded-2xl';
    }

    /**
     * Retorna o tamanho do texto de iniciais de acordo com o tamanho do avatar.
     */
    public function textSizeClass(): string
    {
        return match ($this->size) {
            'xs' => 'text-[8px]',
            'sm' => 'text-[10px]',
            'lg' => 'text-sm',
            'xl' => 'text-lg',
            'xxl' => 'text-2xl',
            default => 'text-xs',
        };
    }

    /**
     * Retorna as classes e posição do indicador de status.
     *
     * @return array{color: string, position: string}
     */
    public function statusDotClasses(): array
    {
        return match ($this->status) {
            'online' => ['color' => 'bg-emerald-500', 'position' => 'top-0 right-0'],
            'offline' => ['color' => 'bg-slate-400', 'position' => 'top-0 right-0'],
            'blocked' => ['color' => 'bg-rose-500', 'position' => 'bottom-0 right-0'],
            default => ['color' => '', 'position' => ''],
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.avatar');
    }
}
