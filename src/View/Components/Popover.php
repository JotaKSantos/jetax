<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Popover extends Component
{
    use ValidatesVariant;

    /**
     * Posições disponíveis para o painel em relação ao gatilho.
     *
     * `top` e `bottom` centralizam o painel no gatilho; os sufixos `-start` e `-end`
     * alinham pela borda esquerda ou direita.
     */
    public const POSITIONS = ['bottom', 'bottom-start', 'bottom-end', 'top', 'top-start', 'top-end'];

    /**
     * Cria uma nova instância do componente de popover.
     *
     * Com `open` nulo o popover controla a própria visibilidade (o gatilho alterna). Com
     * `open` booleano a visibilidade segue o servidor, e o fechamento por clique fora ou Esc
     * emite o evento `close` para o consumidor atualizar o estado.
     */
    public function __construct(
        public string $position = 'bottom',
        public ?bool $open = null,
    ) {
        $this->position = $this->validateVariant($position, self::POSITIONS, 'bottom', 'position');
    }

    /**
     * Indica se a visibilidade é controlada pelo consumidor via `:open`.
     */
    public function controlled(): bool
    {
        return $this->open !== null;
    }

    /**
     * Indica se o painel nasce aberto.
     */
    public function isOpen(): bool
    {
        return $this->open === true;
    }

    /**
     * Direção vertical do painel em relação ao gatilho: `top` ou `bottom`.
     */
    public function vertical(): string
    {
        return str_starts_with($this->position, 'top') ? 'top' : 'bottom';
    }

    /**
     * Alinhamento horizontal do painel em relação ao gatilho: `start`, `center` ou `end`.
     */
    public function horizontal(): string
    {
        return match (true) {
            str_ends_with($this->position, '-start') => 'start',
            str_ends_with($this->position, '-end') => 'end',
            default => 'center',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.popover');
    }
}
