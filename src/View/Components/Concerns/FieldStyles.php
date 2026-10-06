<?php

namespace Jetax\DesignSystem\View\Components\Concerns;

trait FieldStyles
{
    /**
     * Classes do rótulo dos campos de formulário: 11px, peso 700 e
     * espaçamento .06em, com a cor do token on-surface-variant.
     */
    public function labelClasses(): string
    {
        return 'block text-[11px] font-bold text-on-surface-variant uppercase tracking-[.06em] font-body';
    }

    /**
     * Classes da mensagem abaixo do campo, por estado (error, warning,
     * success ou neutro), sempre por token.
     */
    public function fieldMessageClasses(string $state = ''): string
    {
        $color = match ($state) {
            'error' => 'text-error',
            'warning' => 'text-warning',
            'success' => 'text-success-text',
            default => 'text-on-surface-variant',
        };

        return $color.' text-[10px] font-medium mt-1';
    }

    /**
     * Id estável do campo: derivado do name quando existe; sem name, um hash
     * de 8 caracteres do rótulo e do placeholder. Um id que muda a cada
     * render faz o morph do Livewire trocar o elemento e perder o foco.
     */
    public function fieldId(string $prefix, string $placeholder = ''): string
    {
        if (($this->name ?? '') !== '') {
            return $prefix.'_'.$this->name;
        }

        return $prefix.'_'.substr(md5(($this->label ?? '').$placeholder), 0, 8);
    }
}
