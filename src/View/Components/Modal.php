<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use InvalidArgumentException;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Modal extends Component
{
    use ValidatesVariant;

    /**
     * Tamanhos disponíveis para o modal (JETAX-031). `3xl` (980 px) é mais estreito que
     * `2xl` (1080 px): o nome foi fixado depois da escala.
     */
    public const SIZES = ['sm', 'md', 'md-lg', 'lg', 'xl', '2xl', '3xl', 'fullscreen'];

    /**
     * z-index da raiz no nível 1. Cada nível acima soma `LEVEL_STEP`.
     */
    public const BASE_Z_INDEX = 50;

    /**
     * Incremento de z-index por nível de empilhamento.
     */
    public const LEVEL_STEP = 10;

    /**
     * Cria uma nova instância do componente de modal.
     *
     * `level` (inteiro ≥ 1) empilha modais: um modal de nível 2 aberto a partir
     * de um de nível 1 pinta por cima dele, independente da ordem no DOM.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        public string $id = 'modal',
        public string $size = 'md',
        public bool $highRisk = false,
        public int $level = 1,
    ) {
        $this->size = $this->validateVariant($size, self::SIZES, 'md', 'size');
        $this->level = $this->validateLevel($level);
    }

    /**
     * z-index da raiz, crescente com o nível.
     */
    public function zIndex(): int
    {
        return self::BASE_Z_INDEX + ($this->level - 1) * self::LEVEL_STEP;
    }

    /**
     * Retorna as classes CSS de largura para o tamanho do modal, com o px do Claude
     * Design (JETAX-031).
     */
    public function sizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'max-w-xs',
            'md-lg' => 'max-w-[600px]',
            'lg' => 'max-w-[660px]',
            'xl' => 'max-w-[820px]',
            '2xl' => 'max-w-[1080px]',
            '3xl' => 'max-w-[980px]',
            'fullscreen' => 'w-full max-w-full h-full',
            default => 'max-w-[560px]',
        };
    }

    /**
     * Retorna as classes CSS do painel, por token de superfície e borda. Raio de 14 px e
     * sombra do Claude Design (JETAX-031).
     */
    public function containerClasses(): string
    {
        $base = 'bg-surface-container-lowest rounded-[14px] shadow-[0_24px_60px_rgb(9_42_66/0.16)] overflow-hidden border';

        if ($this->highRisk) {
            return $base.' border-4 border-warning/20';
        }

        return $base.' border-outline-variant';
    }

    /**
     * Retorna as classes CSS do header, por token.
     */
    public function headerClasses(): string
    {
        if ($this->highRisk) {
            return 'px-6 py-4 flex justify-between items-center bg-warning/10 text-warning';
        }

        return 'px-6 py-4 flex justify-between items-center bg-surface-container-lowest text-on-surface';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.modal');
    }

    /**
     * Valida o nível: abaixo de 1 lança em `local`/`testing` e, nos demais
     * ambientes, registra `Log::warning` e usa o nível 1.
     *
     * @throws InvalidArgumentException
     */
    protected function validateLevel(int $level): int
    {
        if ($level >= 1) {
            return $level;
        }

        $message = sprintf('Modal: valor "%d" inválido para "level". Use um inteiro ≥ 1.', $level);

        if (in_array(config('app.env'), ['local', 'testing'], true)) {
            throw new InvalidArgumentException($message);
        }

        Log::warning($message, [
            'component' => static::class,
            'prop' => 'level',
            'value' => $level,
            'fallback' => 1,
        ]);

        return 1;
    }
}
