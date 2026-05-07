<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Upload extends Component
{
    /**
     * Cria uma nova instância do componente de upload.
     */
    public function __construct(
        public bool $multiple = false,
        public string $accept = '',
        public int $maxSize = 0,
    ) {}

    /**
     * Retorna o tamanho máximo em bytes para validação no cliente.
     */
    public function maxSizeBytes(): int
    {
        return $this->maxSize > 0 ? $this->maxSize * 1024 * 1024 : 0;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.upload');
    }
}
