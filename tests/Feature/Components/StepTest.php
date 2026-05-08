<?php

it('renders step items', function () {
    $view = $this->blade('
        <x-jetax-step :current="2">
            <x-jetax-step-item :step="1" label="Passo 1" />
            <x-jetax-step-item :step="2" label="Passo 2" />
            <x-jetax-step-item :step="3" label="Passo 3" />
        </x-jetax-step>
    ');
    $view->assertSee('Passo 1', false);
    $view->assertSee('Passo 2', false);
    $view->assertSee('Passo 3', false);
});

it('active step has primary class', function () {
    $view = $this->blade('
        <x-jetax-step :current="2">
            <x-jetax-step-item :step="2" label="Ativo" />
        </x-jetax-step>
    ');
    $view->assertSee('bg-primary', false);
});

it('completed steps have check icon', function () {
    $view = $this->blade('
        <x-jetax-step :current="3">
            <x-jetax-step-item :step="1" label="Feito" />
        </x-jetax-step>
    ');
    $view->assertSee('check', false);
});

it('pending steps have muted class', function () {
    $view = $this->blade('
        <x-jetax-step :current="1">
            <x-jetax-step-item :step="3" label="Futuro" />
        </x-jetax-step>
    ');
    $view->assertSee('text-on-surface-variant', false);
});

it('passes through wire:model', function () {
    $view = $this->blade('
        <x-jetax-step :current="1" wire:model="currentStep">
            <x-jetax-step-item :step="1" label="Passo 1" />
        </x-jetax-step>
    ');
    $view->assertSee('wire:model', false);
});
