<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Chip extends Component
{
    /**
     * Prefixo dos atributos que o consumidor endereça ao botão de remoção
     * (`remove:data-filter="situacao"` vira `data-filter="situacao"` no `<button>`).
     */
    public const REMOVE_PREFIX = 'remove:';

    /**
     * Cria uma nova instância do chip de exibição.
     *
     * O chip não tem estado: quem decide se ele existe é o servidor. Com `removable`, o `×` é
     * um `<button>` que recebe os atributos de clique do consumidor (`wire:click`,
     * `x-on:click`, `@click`) e os prefixados com `remove:`.
     */
    public function __construct(
        public string $label = '',
        public bool $removable = false,
        public string $removeLabel = 'Remover',
    ) {}

    /**
     * Indica se o atributo pertence ao botão de remoção.
     */
    public function isRemoveAttribute(string $key): bool
    {
        if (! $this->removable) {
            return false;
        }

        foreach (['wire:click', 'x-on:click', '@click', self::REMOVE_PREFIX] as $prefix) {
            if (str_starts_with($key, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Atributos do elemento raiz: todos, menos os do botão de remoção.
     */
    public function rootAttributes(ComponentAttributeBag $attributes): ComponentAttributeBag
    {
        return $attributes->filter(fn (mixed $value, string $key): bool => ! $this->isRemoveAttribute($key));
    }

    /**
     * Atributos do botão de remoção, com o prefixo `remove:` retirado.
     */
    public function removeAttributes(ComponentAttributeBag $attributes): ComponentAttributeBag
    {
        $removeAttributes = [];

        foreach ($attributes->getAttributes() as $key => $value) {
            if ($this->isRemoveAttribute($key)) {
                $name = str_starts_with($key, self::REMOVE_PREFIX) ? substr($key, strlen(self::REMOVE_PREFIX)) : $key;
                $removeAttributes[$name] = $value;
            }
        }

        return new ComponentAttributeBag($removeAttributes);
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.chip');
    }
}
