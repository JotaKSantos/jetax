<?php

use Livewire\Component;
use Livewire\Livewire;

class LoadingTestComponent extends Component
{
    public function save(): void
    {
        // simula operação lenta
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-jetax-button wire:click="save" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                Salvar
            </x-jetax-button>
            <x-jetax-spinner wire:loading wire:target="save" />
            <x-jetax-skeleton wire:loading wire:target="save" />
        </div>
        HTML;
    }
}

it('test_button_disabled_during_request', function () {
    Livewire::test(LoadingTestComponent::class)
        ->assertSeeHtml('wire:loading.attr="disabled"')
        ->assertSeeHtml('wire:loading.class="opacity-50"');
});

it('test_spinner_visible_during_request', function () {
    Livewire::test(LoadingTestComponent::class)
        ->assertSeeHtml('wire:loading')
        ->assertSeeHtml('wire:target="save"');
});
